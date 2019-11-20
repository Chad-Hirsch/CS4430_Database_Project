<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
require_once 'conn.php';


$user_login = new USER();

if($user_login->is_logged_in()=="")
{
	//$user_login->redirect('login');
}


//Get profile ID
$user=$_GET['id'];

if($user=="") {
$user = $session_id;
}

	$stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE userID=:user");
	$stmt->execute(array(":user"=>$user));

if($stmt->rowCount() > 0)
{
	while(	$row=$stmt->fetch(PDO::FETCH_ASSOC))
	
{
		extract($row);
$reg_date=$row['regTime'];
$firstname=trim($row['firstName']);
$lastname=trim($row['lastName']);
$email_id=trim($row['userEmail']);
$userid=$row['userID'];
$userstate=$row['userState'];
$usertype=$row['userType'];

$court_name=trim($row['court_name']);
$address=$row['address'];
$cname=$row['companyName'];


$title_name= "$firstname $lastname Profile";

if(preg_match('/court/i', $usertype)) {
$title_name= "$court_name";

}

$msg='';
}
}
else {

}

echo"  <title>$title_name - ".site_name()."</title>";

include "includes/logmenu.php";


?>


        <div id="page-wrapper">

            <div>

                <!-- Page Heading -->

                         <div class="container">
      <div class="row">
<?php
if($_GET['profile']=="edit")
{
include "includes/edit_profile.php";
}
?>

      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
        <?php if($session_id == "$userid") {?>

   <a href="#edit<?php echo $userid; ?>" data-toggle="modal" >Edit Profile</A>

        <A href="./logout.php" >Logout</A>
<?php } ?>
       <br>
<p class=" text-info"><?php echo"".date('Y/m/d    H:i',time())."";?> </p>
      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $title_name;?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="styles/default-avatar-300x300.png" class="img-circle img-responsive"> </div>
                
         
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Department:</td>
                        <td><?php if($usertype=="is_lawyer") echo "Lawyer";  if($usertype=="is_court") echo "Court"; if($usertype=="is_highcourt") echo "High Court"; if($usertype=="is_admin") echo "Administrator"; ?></td>
                      </tr>
                      <tr>
                        <td>Join date:</td>
                        <td><?php echo"".date('Y/m/d    H:i',$reg_date)."";?></td>
                      </tr>
                      <tr>
                        <td>Status:</td>
                        <td><?php echo $userstate;?></td>
                      </tr>
    
                                    <tr>
                        <td>Address:</td>
                        <td><?php echo $address;?></td>
                      </tr>
                      <tr>
                        <td>Email:</td>
                        <td><a href="<?php echo $email_id;?>"><?php echo $email_id;?></a></td>
                      </tr>
                        <td>Phone Number:</td>
                        <td><?php echo $phone;?>
                        </td>
                           
                      </tr>
                     
                    </tbody>
                  </table>
                  
                  
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                       <a href="<?php echo $site_url; ?>/send_notice.php?nid=<?php echo $userid; ?>" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i>Message</a>
 
   

<?php if($session_id == "$userid") {?>

<span class="pull-left">
<a href="#edit<?php echo $userid; ?>" data-toggle="modal" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit</a> 
</span>

   
<?php }  elseif($is_usertype == "is_admin"){
  ?>
<span class="pull-left">
<a href="#edit<?php echo $userid; ?>" data-toggle="modal" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit</a> 
</span>
<?php } ?>

                  <!--      <span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
-->
                  <?php   if($is_usertype == "is_admin"){
  ?>
<span class="pull-left">
<a href="#del<?php echo $userid; ?>" data-toggle="modal" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i>Delete</a>
                        </span>
 <?php } ?>
                    </div>
            
          </div>
        </div>
      </div>
    </div>

<!-- Delete -->
    <div class="modal fade" id="del<?php echo $userid; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Delete client</h4></center>
                </div>
   <div class="modal-body">
				
				<div class="container-fluid">
					<h5><center> <strong><?php echo $firstname; ?> <?php echo $lastname; ?></strong></center></h5> 
                </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="<?php echo $site_url; ?>/manage/edit.php?delete=1&id=<?php echo $userid; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                </div>
				
            </div>
        </div>
    </div>
<!-- /.modal -->

  <!-- Edit Modal -->
    <div class="modal fade" id="edit<?php echo $userid; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Edit Profile</h4></center>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
				<form method="POST" action="<?php
 echo $site_url; ?>/manage/edit.php?id=<?php echo $userid; ?>&from=profile">
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Firstname:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>" required>
						</div>
					</div>
					<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Lastname:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>" required>
						</div>
					</div>
	<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Email:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="_email" class="form-control" value="<?php echo $email_id; ?>" disabled>
						</div>
					</div>
<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Company Name:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="companyname" class="form-control" value="<?php echo $cname; ?>">
						</div>
					</div>

					<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Address:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
						
	               </div> 
				</div>


	<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Phone:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>">
						</div>
					</div>

<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Password:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="_password" class="form-control" disabled>
						</div>
					</div>

   </div>
					</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <button type="submit" class="btn btn-warning" name="btn-editaccount"><span class="glyphicon glyphicon-check"></span> Save</button>
   
  </div>
				</form>
            </div>
        </div>
    </div>
<!-- /.modal -->

</th>
                                        
                                       
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                <!-- /.row -->
</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
 <?php 

if(preg_match('/is_admin/i', $is_usertype)) {
include "manage/adduser_modal.php";

}
 ?>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


<script src="js/endy2.js"></script>

</body>

