<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
	if(isset($_POST['btn-addcase']))
{

	$case_name = trim($_POST['case_name']);
  	$case_text = trim($_POST['case_text']);
  	$case_status = trim($_POST['case_status']);
   $case_status = trim($_POST['case_status']);
  	$case_status = "Draft";
 

    
  //CASE DOCUMENT
    
    $tname = $_FILES['case_attachment']['name'];
    $case_named = str_ireplace(' ', '_',$case_name);
    $case_named = str_ireplace("'", '_', $case_named);
    $size = $_FILES['case_attachment']['size'];
    $type = $_FILES['case_attachment']['type'];
    $listtype = array(
    '.doc'=>'application/msword',
    '.docx'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    '.rtf'=>'application/rtf',
    '.pdf'=>'application/pdf'); 

    if(!is_uploaded_file($_FILES['case_attachment']['tmp_name']))
 {
  $error_message = 'Please attach Case document file<a href="#addnewcase" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Try Again</a>
<br>';
}

if(!isset($error_message)) {
    if(!$key = array_search($_FILES['case_attachment']['type'],$listtype))
    {	
 
$error_message = 'Error: Could Not Upload. File Type Should Be .Docx or .Pdf or .Rtf Or .Doc<a href="#addnewcase" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Try Again</a>
<br>';

}
}
    if(!isset($error_message)) {
if(!empty($tname)) {

$tmp_name = explode(".", $_FILES["case_attachment"]["name"]);
    $newfilename = $case_named . round(microtime(true)) . '.' . end($tmp_name);

if(move_uploaded_file($_FILES["case_attachment"]["tmp_name"], "../documents/" . $newfilename))
 

        		$upl_true = 'Uploaded';
 
    		else
 
    			$error_message = 'Error: Could Not Upload Document <a href="#addnewcase" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Try Again</a>
<br>';
        }
}
   

   $case_attachment = $newfilename;
  	
$id = trim($_POST['id']);
 
//Security
 $case_text = str_ireplace('\r\n' , '
', $case_text);
    $case_text = str_ireplace('\n' , '
', $case_text);
    $case_text = str_ireplace('\r' , '
', $case_text);

$case_text = strip_tags($case_text, '');

$case_date = time();
$time = time();
$case_from=$session_id;
$case_to=trim($_POST['id']);
 
$lawyer=get_user($session_id, userName);

$hcourt=get_user($case_to, court_name);


/*  Validation */
	if($_POST['case_name'] == ""){ 
	$error_message = 'Case Title cannot be empty <a href="#addnewcase" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Try Again</a>
<br>'; 
	}

	if(!isset($error_message)) {
	
if($_POST['case_text'] == ""){ 
	$error_message = 'Case Content cannot be empty <a href="#addnewcase" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Try Again</a>
<br>'; 
	}

}

	
	if(!isset($error_message)) {

	if(isset($upl_true)) {

	$add_case_query = $pdo->prepare("SELECT * FROM tbl_users WHERE usertype='is_highcourt' AND userID='$case_to'");
	$add_case_query->execute();
if($add_case_query->rowCount() > 0)
{
	while($rowp=$add_case_query->fetch(PDO::FETCH_ASSOC))
	{
		extract($rowp);
		
$time = time();


$add_case = $pdo->prepare("INSERT INTO cases(case_name,case_text,case_status,case_attachment,case_from,case_to,case_date) 
			                                             VALUES(:case_name, :case_text, :case_status, :case_attachment, :case_from, :case_to, :case_date)");
	$result=$add_case->execute(array(":case_name"=>$case_name, ":case_text"=>$case_text, ":case_status"=>$case_status, ":case_attachment"=>$case_attachment,  ":case_from"=>$session_id,  ":case_to"=>$case_to,  ":case_date"=>$case_date));

if($result)
	{			
$add_caset = $pdo->prepare("SELECT * FROM cases ORDER BY caseID DESC LIMIT 1");

$add_caset->execute();
while($rowid=$add_caset->fetch(PDO::FETCH_ASSOC))
	{

  extract($rowid);
$thisid=$rowid["caseID"];
}
//Notification
	
//NotificationUser
$vv = '<br/><a href="'.$site_url.'/view_case.php?id='.$thisid.'"><button class="btn btn-success">View</button></a>';

$ctextl="Your case  #$thisid is waiting for response from $hcourt $vv";

$add_casen = $pdo->prepare("INSERT INTO notice(comment_subject,comment_text,comment_to,comment_from,comment_status,comment_date) 
			                                             VALUES('New Case added #$thisid', :ctxtl, '$case_from', '$admin_id', '0', '$time')");
 $add_casen->execute(array(":ctxtl"=>$ctextl));
		
//Notification High Court
	
$ctexth="$lawyer filed a case #$thisid - $case_name to you $vv";
$add_casen = $pdo->prepare("INSERT INTO notice(comment_subject,comment_text,comment_to,comment_from,comment_status,comment_date) 
			                                             VALUES('New case received #$thisid', :ctxt, '$case_to', '$session_id', '0', '$time')");
 $add_casen->execute(array(":ctxt"=>$ctexth));
			
	
			
	$msg = "<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>Success , Case posted successfully...</div>
";

		}
		else
		{
			$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>Sorry , An error occurred, please contact administrator...</div>";
	}

}
 }

}

}
	
}

			

?>

<?php if(isset($msg)) echo $msg; 	if(isset($error_message)) echo"<div class='alert alert-danger'>
						<button class='close' data-dismiss='alert'>&times;</button> $error_message</div>"; ?>
