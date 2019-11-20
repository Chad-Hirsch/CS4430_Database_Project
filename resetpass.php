<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */ 
require_once 'conn.php';

$user_login = new USER();


       echo" <title>Reset Password</title>";

include"includes/nav.php";

//Validate URL
if(empty($_GET['id']) && empty($_GET['code']))
{
	$user->redirect('index.php');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];

//Check token
	$stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid AND tokenCode=:token");
	$stmt->execute(array(":uid"=>$id,":token"=>$code));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() == 1)
	{
		if(isset($_POST['btn-reset-pass']))
		{
			$pass = $_POST['pass'];
			$cpass = $_POST['confirm-pass'];
			
			if($cpass!==$pass)
			{
				$msg = "<div class='alert alert-block'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Sorry!</strong>  Password Doesn't match. 
						</div>";
			}
			else
			{
				$password = md5($cpass);
//Update password
				$stmt = $user->runQuery("UPDATE tbl_users SET userPass=:upass WHERE userID=:uid");
				$stmt->execute(array(":upass"=>$password,":uid"=>$rows['userID']));
				
				$msg = "<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						Password Changed.
						</div>";
				header("refresh:5;login.php");
			}
		}	
	}
	else
	{
		$msg = "<div class='alert alert-success'>
				<button class='close' data-dismiss='alert'>&times;</button>
				No Account Found, Try again
				</div>";
				
	}
	
	
}

?>
 <div class="page-content">


   <section class="striped"> 
    <div class="container"> 
     <div class="row"> 
     
      <div class="mainArea-first col-xs-12 col-md-7 col-lg-8"> 

 
 <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Reset your account password</h3>
                            </div>
                            <div class="panel-body">
                               
        <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Password Reset.</h3><hr />
        <?php
        if(isset($msg))
		{
			echo $msg;
		}
		?>
 <div class="form-group">
 <label>New Password</label>
        <input type="password" class="form-control" placeholder="New Password" name="pass" required />
</div>
<div class="form-group">
 <label>Confirm New Password</label>
        <input type="password" class="form-control" placeholder="Confirm New Password" name="confirm-pass" required />
     	<hr />
 </div>
        <button class="btn btn-large btn-success" type="submit" name="btn-reset-pass">Reset Your Password</button>
        
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
