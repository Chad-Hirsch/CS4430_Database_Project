<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
require_once 'conn.php';


$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('dashboard.php');
}

//User Registration
if(isset($_POST['btn-signup']))
{
	
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
	$error_message = 'Passwords should be same<br>'; 
	}

	/* Email Validation */
	if(!isset($error_message)) {
		if (!filter_var($_POST["txtemail"], FILTER_VALIDATE_EMAIL)) {
		$error_message = "Invalid Email Address";
		}
	}

	/*Invalid Name check*/
	if(!isset($error_message)) {

if(!preg_match("^[A-Za-z0-9]+$^" , "$firstname$lastname" ))
{
	$error_message = "Your name contains invalid characters";
}
}
	/* Password check*/
	if(!isset($error_message)) {

if(strlen($upass)<5)
{
	$error_message = "Password is too short, Your password should be more than five characters";
}
}
	if(!isset($error_message)) {

	//Check if email already exists
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

//Inserting new user data
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

		$result = $stmt->execute();
	
		
	


	
    
if($result)
	{			
			$id = $reg_user->lasdID();		
			$key = base64_encode($id);
			$id = $key;
			
$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Success!</strong>  Welcome to $site->name !<br/>
				  Your account is currently under review. We periodically review accounts for security purposes and to verify information, which takes about 1-3 business days.
		</div>
					";
			$message = "					
						Hello $uname,
						<br /><br />
						Welcome to $site->name !<br/>
				  Your account is currently under review. We periodically review accounts for security purposes and to verify information, which takes about 1-3 business days.
						<br /><br />

						Thanks,";
						
			$subject = "Registration - $site->name";
		$headers .= "From: Registration <".$Emailsender.">\r\n";
				
			mail($email,$subject,$message,$headers);	
		
		}
		else
		{
			$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>Sorry , Query could no execute...</div>";
		}		
	}
}

}


echo"  <title> Registration -  ".site_name()."</title>
";
include "includes/nav.php";
?>
 <div class="page-content">


   <section class="striped" id="sList"> 
    <div class="container"> 
     <div class="row"> 
     
      <div class="mainArea-first col-xs-12 col-md-7 col-lg-8"> 

<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Registration</h3>

                            </div>
                            <div class="panel-body">
                               
                          
        <?php if(isset($msg)) echo $msg; 	if(isset($error_message)) echo"<div class='alert alert-danger'>
						<button class='close' data-dismiss='alert'>&times;</button> $error_message</div>"; ?>

      <form class="form-signin" method="post">
       
    <div class="form-group">
       <label>Email address</label>
        <input type="email" class="form-control" placeholder="Email address" name="txtemail" value="<?php if(isset($_POST['txtemail'])) echo $_POST['txtemail']; ?>" required />
   </div>

      

    <div class="form-group">
 <label>First name</label>
<input type="text" class="form-control" placeholder="First name" name="first_name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>" required />
 
</div>
    <div class="form-group">
 <label>Last name</label>
<input type="text" class="form-control" placeholder="Last name" name="last_name" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>" required />
 
</div>
   
    <div class="form-group">
 <label>Address</label>
<input type="text" class="form-control" placeholder="Address" name="address" value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>" required />
 
</div>
  <div class="form-group">
 <label>Phone</label>
<input type="text" class="form-control" placeholder="Phone" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>" required />
 
</div>

    <div class="form-group">
 <label>Register As:</label>
<script type="text/javascript"> function showfield(name){ if(name=='is_highcourt')document.getElementById('div11').innerHTML='  <div class="form-group"> <label>High Court Name</label><input type="text" class="form-control" placeholder="Enter court name" name="court" value="<?php if(isset($_POST['court'])) echo $_POST['court']; ?>" required /></div><div class="form-group"> <label>Court Address</label><input type="text" class="form-control" placeholder="Enter court address" name="court_ad" value="<?php if(isset($_POST['court_ad'])) echo $_POST['court_ad']; ?>" required /></div>  <div class="form-group"> <label>Court Contact(Phone)</label><input type="text" class="form-control" placeholder="Enter court no.." name="court_ph" value="<?php if(isset($_POST['court_ph'])) echo $_POST['court_ph']; ?>" required /></div>'; else if(name=='is_court')document.getElementById('div11').innerHTML='  <div class="form-group"> <label>Court Name</label><input type="text" class="form-control" placeholder="Enter court name" name="court" value="<?php if(isset($_POST['court'])) echo $_POST['court']; ?>" required /></div>  <div class="form-group"> <label>Court Address</label><input type="text" class="form-control" placeholder="Enter court address" name="court_ad" value="<?php if(isset($_POST['court_ad'])) echo $_POST['court_ad']; ?>" required /></div>  <div class="form-group"> <label>Court Contact(Phone)</label><input type="text" class="form-control" placeholder="Enter court no.." name="court_ph" value="<?php if(isset($_POST['court_ph'])) echo $_POST['court_ph']; ?>" required /></div>'; else if(name=='is_lawyer')document.getElementById('div11').innerHTML='  '; else document.getElementById('div12').innerHTML=''; } </script>

<select class="form-control" placeholder="Select sign up type" name="usertype" id="usertype" onchange="showfield(this.options[this.selectedIndex].value)" required>   
   
<option value="">Please select ...</option> 
<option value="is_lawyer">Lawyer</option>
  
<option value="is_court">Court</option>
 <option value="is_highcourt">High Court</option> 
</select> 
 
</div>

 <div id="div11">
</div>
<div id="div12">
</div>

<div class="form-group">
     <label>Password</label>
        <input type="password" class="form-control" placeholder="Password" name="txtpass" required />
    
</div>
<div class="form-group">
     <label>Confirm Password</label>
        <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required />
    
</div>
     	<hr />
        <button class="btn btn-large btn-success" type="submit" name="btn-signup">Register</button>
        <a href="login.php" style="float:right;" class="btn btn-primary">Sign In</a>
      </form>

</div>

</div> 

 </div> 
    </div> 
   </section> 
       
 </div> 

     
<?php

include"includes/footer.php";
?>
