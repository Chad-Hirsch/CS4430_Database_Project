<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */

require_once '../conn.php';
	
$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('..)login.php');
}
	if(isset($_POST['btn-signup']))
{
	//$uname = trim($_POST['name']);
	$email = trim($_POST['email']);
	$upass = trim($_POST['password']);
   	$firstname = trim($_POST['firstname']);
   	$lastname = trim($_POST['lastname']);
   $uname = "".$firstname." $lastname";
  	$companyname = trim($_POST['company_name']);
  	$phone = trim($_POST['phone']);
  	$address = trim($_POST['address']);
   $usertype = trim($_POST['usertype']);
   if($is_usertype!="is_admin"){
  $usertype = "is_driver";

  $userownern = ",userOwner";
   $userownerv = ", :user_owner";
}
   $userstate="Pending";
	$code = md5(uniqid(rand()));
$password = md5($upass);


$time = time();
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg_a = "Error: Email already exist";
	}
	else
	{

//$reguser = new PDO();
$stmt = $pdo->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode,firstName,lastName,companyName,address,phone,userType,userState,regTime$userownern) 
			                                             VALUES(:user_name, :user_mail, :user_pass, :active_code, :first_name, :last_name, :company_name, :address_full, :phone_no, :user_type, :user_state, :reg_time$userownerv)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->bindparam(":first_name",$firstname);
			$stmt->bindparam(":last_name",$lastname);
			$stmt->bindparam(":company_name",$companyname);
			$stmt->bindparam(":address_full",$address);
			$stmt->bindparam(":phone_no",$phone);
			$stmt->bindparam(":user_type",$usertype);
			$stmt->bindparam(":user_state",$userstate);
			$stmt->bindparam(":reg_time",$time);
 if($is_usertype!="is_admin"){
$stmt->bindparam(":user_owner",$session_id);
}
		$result = $stmt->execute();
	
		
	


	//	if($reg_user->register($uname,$email,$upass,$code,$firstname,$lastname,$companyname,$address,$phone,$usertype,$userstate,$time))
    
if($result)
	{			
			
			$msg_a = "Account created";

		}
		else
		{
			$msg_a ="An error occurred";
		}		
	}
   if($is_usertype!="is_admin"){
header("location:../dashboard.php?msg=$msg_a");
exit;
}
header("location:accounts.php?msg=$msg_a");
 }


	

?>