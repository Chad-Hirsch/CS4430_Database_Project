<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */

if(isset($_POST['btn-signup']))
{
    $reg_user = new USER();

	//$uname = trim($_POST['txtuname']);
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtpass']);
   	$firstname = trim($_POST['first_name']);
   	$lastname = trim($_POST['last_name']);
   $uname = "".$firstname." $lastname";
  	$court = trim($_POST['court']);
   	$court_address = trim($_POST['court_ad']);
 
  	$court_phone = trim($_POST['court_ph']);
 
 	$phone = trim($_POST['phone']);
  	$address = trim($_POST['address']);
   $usertype = trim($_POST['usertype']);
   $userstate="Pending";
	$code = md5(uniqid(rand()));
$password = md5($upass);




/* Password Matching Validation */
	if($_POST['txtpass'] != $_POST['confirm_password']){ 
	$error_message = 'Passwords should be same <a href="#addnewaccount" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Try Again</a>
<br>'; 
	}

	/* Email Validation */
	if(!isset($error_message)) {
		if (!filter_var($_POST["txtemail"], FILTER_VALIDATE_EMAIL)) {
		$error_message = 'Invalid Email Address <span class="pull-right"><a href="#addnewaccount" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Try Again</a>';
		}
	}

	/* Name check*/
	if(!isset($error_message)) {

if(!preg_match("^[A-Za-z0-9]+$^" , "$firstname$lastname" ))
{
	$error_message = 'Your name contains invalid characters <a href="#addnewaccount" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Try Again</a>';
}
}
	/* Password check*/
	if(!isset($error_message)) {

if(strlen($upass)<5)
{
	$error_message = 'Password is too short, Your password should be more than five characters <a href="#addnewaccount" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Try Again</a>
';
}
}
	if(!isset($error_message)) {

$time = time();
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg = "
		      <div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry !</strong>  email already exists , Please Try another one
			  </div>
			  ";
	}
	else
	{


$stmt = $pdo->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode,firstName,lastName,court_name,address,phone,userType,userState,regTime,court_address,court_phone) 
			                                             VALUES(:user_name, :user_mail, :user_pass, :active_code, :first_name, :last_name, :court, :address_full, :phone_no, :user_type, :user_state, :reg_time, :court_ad, :court_phone)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->bindparam(":first_name",$firstname);
			$stmt->bindparam(":last_name",$lastname);
			$stmt->bindparam(":court",$court);
			$stmt->bindparam(":address_full",$address);
			$stmt->bindparam(":phone_no",$phone);
			$stmt->bindparam(":user_type",$usertype);
			$stmt->bindparam(":user_state",$userstate);
			$stmt->bindparam(":reg_time",$time);
   $stmt->bindparam(":court_ad",$court_address);

  $stmt->bindparam(":court_phone",$court_phone);

		$resultreg = $stmt->execute();
	
		
	


	
    
if($resultreg)
	{			
			
$msgreg = "<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>Success , Account created successfully...</div>
";
			
		}
		else
		{
			$msgreg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>Sorry , Query could no execute...</div>";
		}		
	}
}

}

?>

<?php if(isset($msgreg)) echo $msg; 	if(isset($error_message)) echo"<div class='alert alert-danger'>
						<button class='close' data-dismiss='alert'>&times;</button> $error_message</div>"; ?>
