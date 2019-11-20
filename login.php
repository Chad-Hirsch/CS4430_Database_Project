<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
require_once 'conn.php';


$user_login = new USER();


       echo" <title>Login</title>
";

include"includes/nav.php";


//Check if already login

if($user_login->is_logged_in()!="")
{
$user_login->redirect('dashboard.php');
}

//Validate login Post data
if(isset($_POST['btn-login']))
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);

//Check if Email and Password match
	if($user_login->login($email,$upass))
	{
  $userid=get_email($email, userID);

//Setting cookies for auto login
    setcookie("islog_email", "".$email."", time()+200000000);
   setcookie("islog_pass", "".$upass."", time()+200000000);
   setcookie("islog_id", "".$userid."", time()+200000000);
 
 //Redirect if login was successful
		$user_login->redirect('dashboard.php');
	}
}




?>
<!-- Begin Page Content --!>
 <div class="page-content">


   <section class="striped"> 
    <div class="container"> 
     <div class="row"> 
     
      <div class="mainArea-first col-xs-12 col-md-7 col-lg-8"> 

 
    

  <?php 
	
//Check if account is active
		if(isset($_GET['inactive']))
		{
			?>
            <div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Sorry!</strong> This Account is not Activated. If it's new account, please wait for 1-3days for approval to take place. 
			</div>
            <?php
		}
		?>
<div>
<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Login to your account</h3>
                            </div>
                            
                            
                            <div class="panel-body">
                               
                          
        <form class="form-signin" method="post">
        <?php

//Check if there was error login-in
        if(isset($_GET['error']))
		{
			?>
            <div class='alert alert-success'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Wrong Details!</strong> 
			</div>
            <?php
		}
		?>
        
    <div class="form-group">
       <label>Email address</label>
        <input type="email" class="form-control" placeholder="Email address" name="txtemail" required />
   </div>

      <div class="form-group">
     <label>Password</label>
        <input type="password" class="form-control" placeholder="Password" name="txtupass" required />
    
</div>
       <button class="btn btn-large btn-success" type="submit" name="btn-login">Sign in</button>

        <a href="register.php" style="float:right;" class="btn btn-default">Sign Up</a><hr />
        <a href="fpass.php">Lost your Password ? </a>

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
