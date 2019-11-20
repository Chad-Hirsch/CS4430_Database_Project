<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
/* Password reset */


require_once 'conn.php';


   echo" <title>Forgot Password? </title>
";



include"includes/nav.php";



$user = new USER();

if($user->is_logged_in()!="")
{
	$user->redirect('dashboard.php');
}




//Forgot Password Form Validation


if(isset($_POST['btn-submit']))
{
	



$email = $_POST['txtemail'];
	
	$stmt = $user->runQuery("SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1");



	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	if($stmt->rowCount() == 1)
	{
	

	


$id = base64_encode($row['userID']);
	


	$code = md5(uniqid(rand()));
		
		


$stmt = $user->runQuery("UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:email");



	

	$stmt->execute(array(":token"=>$code,"email"=>$email));
		
		



$message= "
				   Hello , $email
				   <br /><br />
				   We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore                   this email,
				   <br /><br />
				   Click Following Link To Reset Your Password 
				   <br /><br />
				   <a href='<?php echo $site_url;?>/resetpass.php?id=$id&code=$code'>click here to reset your password</a>
				   <br /><br />
				   thank you :)
				   ";
	




	$subject = "Password Reset";
		

	$headers .= "From: Password reset <".$Emailsender.">\r\n";


				
	


		mail($email,$subject,$message,$headers);	



		
	

	$msg = "<div class='alert alert-success'>
					<button class='close' data-dismiss='alert'>&times;</button>
					We've sent an email to $email.
                    Please click on the password reset link in the email to generate new password. 
			  	</div>";
	}





	else
	{
		



$msg = "<div class='alert alert-danger'>
					<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry!</strong>  this email not found. 
			    </div>";
	}
}

?>

  


  


     <div class="page-content">




   <section class="striped"> 
  

  <div class="container"> 
  

   <div class="row"> 
     
   

   <div class="mainArea-first col-xs-12 col-md-7 col-lg-8"> 

<div>
<div class="panel panel-default">
                            <div class="panel-heading">
     

                           <h3 class="panel-title">Forgot Password</h3>
                            </div>
 
                           <div class="panel-body">
                   
 
  
    <form class="form-fpass" method="post">
 
       
        	<?php
			if(isset($msg))
			{
		

		echo $msg;
			}
			else
			{
				?>
 

             	<div class='alert alert-info'>
				Please enter your email address. You will receive a link to create a new password via email.!
				</div>  
                <?php
			}
			?>
      

  
<div class="form-group">
    
    <input type="email" class="form-control" placeholder="Email address" name="txtemail" required />
</div>
     	<hr />
  
      <button class="btn btn-danger btn-primary" type="submit" name="btn-submit">Generate new Password</button>
   
   </form>

     </div>
                        
            



   </div>
 

 </div> 

    </div> 
   
</section> 
  
     
 </div> 

     


<?php

include"footer.php";
?>
