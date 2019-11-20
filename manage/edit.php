<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */

require_once '../conn.php';

	
$user = new USER();

if($user->is_logged_in()=="")
{
	$user->redirect('../login.php');
}

	$id=$_GET['id'];


$time = time();
	

 //ACTIVATE ACCOUNT
if($is_usertype=="is_admin"){

	if($_GET['activate']=="1") {
	$stmt = $user->runQuery("UPDATE tbl_users SET userStatus='Y', userState='Active' WHERE userID='$id'");
$stmt->execute();
header('location:accounts.php?msg_a=Activated');
}

if($_GET['activate_court']=="1") {
	$stmt = $user->runQuery("UPDATE tbl_users SET court_status='Active' WHERE userID='$id'");
$stmt->execute();
header('location:manage_courts.php?msg_a=Activated');
}

 //DEACTIVATE ACCOUNT
	if($_GET['deactivate']=="1") {
	$stmt = $user->runQuery("UPDATE tbl_users SET userState='Inactive' WHERE userID='$id'");
$stmt->execute();
header('location:accounts.php?msg_a=Deactivated');
}


if($_GET['deactivate_court']=="1") {
	$stmt = $user->runQuery("UPDATE tbl_users SET court_status='' WHERE userID='$id'");
$stmt->execute();
header('location:manage_courts.php?msg_a=Deactivated');
}

 //DELETE ACCOUNT
	if($_GET['delete']=="1") {
	$stmt = $user->runQuery("DELETE FROM tbl_users WHERE userID='$id'");
$stmt->execute();
header('location:accounts.php?msg_a=Deleted');
}
}


if(preg_match('/court|is_admin/i', $is_usertype)) {
//Marked Case As received
	if($_GET['mark_received']=="1") {
	$stmt = $user->runQuery("UPDATE cases SET case_received='1' WHERE caseID=:cid");
$stmt->execute(array(":cid"=>$id));

$stmtp = $pdo->prepare("SELECT * FROM cases WHERE caseID='$id'");

				
	$stmtp->execute();
if($stmtp->rowCount() > 0)
{
	while($row=$stmtp->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);

$case_name=$row['case_name'];

$case_status=$row['case_status'];
$case_byy=$row['case_from'];
$case_tos=$row['case_to'];
$case_to=get_user($case_tos, court_name);
$case_by=get_user($case_byy, userName);
$case_id=$row['caseID'];
$ctextl="Your case  '#$case_id - $case_name' has been received by $case_to $vv";

$stmtn = $pdo->prepare("INSERT INTO notice(comment_subject,comment_text,comment_to,comment_from,comment_status,comment_date) 
			                                             VALUES('New Update On Case #$case_id', :ctxtl, '$case_byy', '$admin_id', '0', '$time')");
 $stmtn->execute(array(":ctxtl"=>$ctextl));
}
}		
header('location:manage_case.php?msg_a=Success');

}


//Marked Case As open
	if($_GET['mark_open']=="1") {
	$stmt = $user->runQuery("UPDATE cases SET case_status='Open' WHERE caseID=:cid");
$stmt->execute(array(":cid"=>$id));

header('location:manage_case.php?msg_a=Success');

}

//Marked Case As closed
	if($_GET['mark_closed']=="1") {
	$stmt = $user->runQuery("UPDATE cases SET case_status='Closed' WHERE caseID=:cid");
$stmt->execute(array(":cid"=>$id));

header('location:manage_case.php?msg_a=Success');

}


//Marked Case As draft
	if($_GET['mark_draft']=="1") {
	$stmt = $user->runQuery("UPDATE cases SET case_status='Draft' WHERE caseID=:cid");
$stmt->execute(array(":cid"=>$id));

header('location:manage_case.php?msg_a=Success');

}
//POST Case
	if(isset($_POST['btn-postcase']))
{
$postd = $_REQUEST['posto'];

$postp = $_REQUEST['posto'];

if($postp=="") {
$msg_b= "Posting Error, You didn't select court";
header('location:manage_case.php?msg_a=$msg_b');
exit;
}

$stmtp = $pdo->prepare("SELECT * FROM cases WHERE caseID='$id'");

				
	$stmtp->execute();
if($stmtp->rowCount() > 0)
{
	while($row=$stmtp->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);

$case_name=$row['case_name'];

$case_status=$row['case_status'];
$case_byy=$row['case_from'];
$case_tos=$row['case_to'];
$case_to=get_user($case_tos, court_name);
$post_to=get_user($postd, court_name);
$case_by=get_user($case_byy, userName);
$case_id=$row['caseID'];
$postd=get_user($postd, court_name);

//CASE DOCUMENT
    
if(is_uploaded_file($_FILES['case_attachment']['tmp_name']))
 {
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
  $error_message = 'Please attach Case document file';
header('location:manage_case.php?msg_a=$error_message');
}

if(!isset($error_message)) {
    if(!$key = array_search($_FILES['case_attachment']['type'],$listtype))
    {	
 
$error_message = 'Error: Could Not Upload. File Type Should Be .Docx or .Pdf or .Rtf Or .Doc';

header('location:manage_case.php?msg_a=$error_message');
}
}
    if(!isset($error_message)) {
if(!empty($tname)) {

$tmp_name = explode(".", $_FILES["case_attachment"]["name"]);
    $newfilename = $case_named . round(microtime(true)) . '.' . end($tmp_name);

if(move_uploaded_file($_FILES["case_attachment"]["tmp_name"], "../documents/" . $newfilename))
 

        		$upl_true = 'Uploaded';
 
    		else
 
    			$error_message =urlencode( 'Error: Could Not Upload Document');
header('location:manage_case.php?msg_a=$error_message');
        }
}
   

if(isset($upl_true)) {

$stmt = $user->runQuery("UPDATE cases SET case_posted='$postp', case_attachment='$newfilename' WHERE caseID=:cid");
$stmt->execute(array(":cid"=>$id));


  

$vv = '<br/><a href="'.$site_url.'/view_case.php?id='.$case_id.'"><button class="btn btn-success">View</button></a>';
$ctextl="Your case  '#$case_id - $case_name' has been posted to $post_to for hearing $vv";

//NOTIFY LAWYER
$stmtn = $pdo->prepare("INSERT INTO notice(comment_subject,comment_text,comment_to,comment_from,comment_status,comment_date) 
			                                             VALUES('New Update On Case #$case_id', :ctxtl, '$case_byy', '$admin_id', '0', '$time')");
 $stmtn->execute(array(":ctxtl"=>$ctextl));

//NOTIFY COURT
$ctextl1="New case received!!!

$case_to just sent you a new case 

<strong>
  Case ID: #$case_id 
  Case Title: $case_name
   Filed by: $case_by
   To: $case_to
   Posted to: $postd for hearing
</strong>
   $vv";


$stmtn = $pdo->prepare("INSERT INTO notice(comment_subject,comment_text,comment_to,comment_from,comment_status,comment_date) 
			                                             VALUES('New Case Received #$case_id', :ctxtl, '$postp', '$admin_id', '0', '$time')");
 $stmtn->execute(array(":ctxtl"=>$ctextl1));

}
}
}
}		header('location:manage_case.php?msg_a=Posted');

}

//EDIT CASE

	

	if(isset($_POST['btn-editcase']))
{
$case_name = trim($_POST['case_name']);
$case_text = trim($_POST['case_text']);

//CASE DOCUMENT
    
if(is_uploaded_file($_FILES['case_attachment']['tmp_name']))
 {
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
  $error_message = 'Please attach Case document file';
header("location:manage_case.php?msg_a=$error_message");
 exit;
}

if(!isset($error_message)) {
    if(!$key = array_search($_FILES['case_attachment']['type'],$listtype))
    {	
 
$error_message = 'Error: Could Not Upload. File Type Should Be .Docx or .Pdf or .Rtf Or .Doc';

header("location:manage_case.php?msg_a=$error_message");
 exit;
}
}
    if(!isset($error_message)) {
if(!empty($tname)) {

$tmp_name = explode(".", $_FILES["case_attachment"]["name"]);
    $newfilename = $case_named . round(microtime(true)) . '.' . end($tmp_name);

if(move_uploaded_file($_FILES["case_attachment"]["tmp_name"], "../documents/" . $newfilename))
 

        		$upl_true = 'Uploaded';
 
    		else
 
    			$error_message =urlencode( 'Error: Could Not Upload Document');
header("location:manage_case.php?msg_a=$error_message");
      exit;  }
}
   

if(isset($upl_true)) {
$attach =" case_attachment='$newfilename',";
}
}
  

	$stmt = $user->runQuery("UPDATE cases SET case_name=:cname,$attach case_text=:ctext WHERE caseID=:cid");
$stmt->execute(array(":cid"=>$id, ":cname"=>$case_name, ":ctext"=>$case_text));
header('location:manage_case.php?msg_a=Updated');
}

//DELETE CASE
	if($_GET['delete']=="case") {
$fid=$id;
	$stmt = $user->runQuery("DELETE FROM cases WHERE caseID='$fid'");
$stmt->execute();
header('location:manage_case.php?msg_a=Deleted');
}

}

//EDIT ACCOUNT
	if(isset($_POST['btn-editaccount']))
{
	//$uname = trim($_POST['name']);
	$email = trim($_POST['email']);
	$upass = trim($_POST['password']);
   	$firstname = trim($_POST['firstname']);
   	$lastname = trim($_POST['lastname']);
   //$uname = "".$firstname." $lastname";
  	$companyname = trim($_POST['companyname']);
  	$phone = trim($_POST['phone']);
  	$address = trim($_POST['address']);
  $password = md5($upass);
   
$dname = trim($_POST['court']);
	$dtext = trim($_POST['txt']);

   $daddress = trim($_POST['court_ad']);
 $dphone = trim($_POST['court_ph']);
$dstatus = trim($_POST['court_status']);


$time = time();
	$stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userID=:user_id");
	$stmt->execute(array(":user_id"=>$id));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg_a = "msg=success";
if(strlen($_POST['password'])>1){
	
$addpass=" userPass='$password',";

}

if(strlen($_POST['usertype'])>1){
if($is_usertype=="is_admin"){

   $usertype = trim($_POST['usertype']);
$addusertype=" userType='$usertype',";


  }
}



if(strlen($dname)>1)
{
$court_name=" court_name='$dname',";
}

if(strlen($dtext)>1)
{
$court_text=" court_text='$dtext',";
}

if(strlen($dphone)>1)
{
$court_phone=" court_phone='$dphone',";
}

if(strlen($daddress)>1)
{
$court_address=" court_address='$daddress',";
}
if(strlen($dstatus)>1)
{
$court_status=" court_status='$dstatus',";
}



if(strlen($_POST['email'])>1){
if($is_usertype=="is_admin"){

   $email = trim($_POST['email']);
$addemail=" userEmail='$email',";


  }
}
				
$stmt = $user->runQuery("UPDATE tbl_users SET firstName='$firstname',$addemail$addusertype lastName='$lastname',$addpass companyName='$companyname',$court_name address='$address',$court_phone$court_address$court_text$court_status phone='$phone' WHERE userID='$id'");
$stmt->execute();
}

	header('location:accounts.php?msg_a=Updated');

}

//EDIT COURT

if(preg_match('/court|is_admin/i', $is_usertype)) {

	if(isset($_POST['btn-editcourt']))
{

   	$court = trim($_POST['court']);
   	$court_address = trim($_POST['court_ad']);
 
  	$court_phone = trim($_POST['court_ph']);
$stmt = $user->runQuery("UPDATE tbl_users SET court_name='$court', court_address='$court_address', court_phone='$court_phone' WHERE userID='$id'");
 
$stmt->execute();

//Redirection after editing
if(preg_match('/is_admin/i', $is_usertype)) {	header('location:manage_courts.php?msg_a=Updated');
}

if(preg_match('/court/i', $is_usertype)) {	header('location: update_court.php?msg_a=Updated');
}
}



}

?>