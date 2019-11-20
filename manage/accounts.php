<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */

require_once '../conn.php';

	

//Check login
if($user_login->is_logged_in()=="")
{
	$user_login->redirect('../login.php');

}
if($is_usertype!="is_admin"){

header('location:index.php');
exit;
}

//Total user count
	$select_user_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userID>'0'");
	$select_user_count->execute();
$usercount=$select_user_count->rowCount();

//Active user count
	$select_user_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userState='Active'");
	$select_user_count->execute();
$useractive=$select_user_count->rowCount();
	
	//Inactive user count
	
	$select_user_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userState='Inactive'");
	$select_user_count->execute();
$userinactive=$select_user_count->rowCount();

//Pending user count
$select_user_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userStatus='N'");
	$select_user_count->execute();
$userpending=$select_user_count->rowCount();

//High Court user count
$select_user_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_highcourt'");
	$select_user_count->execute();
$userd=$select_user_count->rowCount();

//Lawyer user count
$select_user_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_lawyer'");
	$select_user_count->execute();
$usertd=$select_user_count->rowCount();

//Court user count
$select_user_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_court'");
	$select_user_count->execute();
$userto=$select_user_count->rowCount();

//Admin user count
$select_user_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_admin'");
	$select_user_count->execute();
$usera=$select_user_count->rowCount();

//Search user
	if(isset($_POST['btn-search']))
{
	$search = trim($_POST['search']);
    $addsel = " AND userEmail='$search'";
}

if($_GET['user_type']=="courts") {
$addsel = " AND userType='is_court'";

				
}
if($_GET['user_type']=="highcourt") {
$addsel = " AND userType='is_highcourt'";

				
}

if($_GET['user_type']=="lawyer") {
$addsel = " AND userType='is_lawyer'";

				
}

echo"  <title> Accounts - ".site_name()."</title>
";

include "../includes/logmenu.php";
?>

 <div id="page-wrapper">

            <div class="container-fluid">


                <!-- Page Heading -->
                <div class="row">
       
</div>
	
<div class="row"> 
         <div class="col-lg-12"> 
          <div class="main-box clearfix"> 
           <header class="main-box-header clearfix"> 
             
<!-- Search --!>
<?php
 
	
include "regclient.php";
 ?>
<div class="_col-lg-4">
        <form method="POST" action="?seach">
               
      <div class="form-group input-group">
                                <input type="text" class="form-control" placeholder="Search with email" name="search">
                                <span class="input-group-btn"><button type="submit" name="btn-search" class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span>
           </div></form>              
   </div>
<!-- /Search --!>
 <?php
 

$msg = "<div class='alert alert-info'>".$_GET['msg']."</div>";

 if(isset($_GET['msg'])) echo $msg;  ?>

		<span class="pull-right"><a href="#addnewaccount" data-toggle="modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add New Account</a></span>

 
<span class="pull-left"><a href="?user=" class="btn-xs btn-success"><span class="glyphicon glyphicon-user"></span>All Account (<?php
 echo $usercount;?>)</a></span>

<span class="pull-left"><a href="?user=active" class="btn-xs btn-primary"><span class="glyphicon glyphicon-user"></span>Active Account (<?php
 echo $useractive;?>)</a></span>

<span class="pull-left"><a href="?user=inactive" class="btn-xs btn-danger"><span class="glyphicon glyphicon-user"></span>Inactive Account (<?php

 echo $userinactive;?>)</a></span>

<span class="pull-left"><a href="?user=pending" class="btn-xs btn-warning"><span class="glyphicon glyphicon-user"></span> Pending Approval (<?php

 echo $userpending;?>)</a></span>


<span class="pull-left"><a href="?user_type=highcourt" class="btn-xs btn-success"><span class="glyphicon glyphicon-user"></span> High Court Managers (<?php
 
 echo $userd;?>)</a></span>

<span class="pull-left"><a href="?user_type=courts" class="btn-xs btn-success"><span class="glyphicon glyphicon-user"></span> Court Managers (<?php
 
 echo $userto;?>)</a></span>

<span class="pull-left"><a href="?user_type=lawyer" class="btn-xs btn-success"><span class="glyphicon glyphicon-user"></span> Lawyer (<?php
 
 echo $usertd;?>)</a></span>
		<div style="height:50px;"></div>
           
  </header> 

           <div class="main-box-body clearfix"> 

</div>


<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				
				<th><div class="label label-success">Name</div>
</th>
				<th><div class="label label-success">Email</div>
</th>
            
              <th><div class="label label-success">Account Type</div>
</th>
             <th><div class="label label-success">Status</div>
</th>
				<th><div class="label label-success">Action</div></th>
			</thead>
			<tbody>
			<?php
 
//Adding user to query
				
 if($_GET['user']=="") {

				
}
if($_GET['user']=="inactive") {
$addsel = " AND userState='Inactive'";

				
}
if($_GET['user']=="active") {
$addsel = " AND userState='Active'";

				
}
if($_GET['user']=="pending") {
$addsel = " AND userStatus='N'";

				
}

//Query Navigation
$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
 
$per_page = 10; // Set how many records do you want to display per page.

$statement = "tbl_users WHERE userID>'0'$addsel"; 
$startpoint = ($page * $per_page) - $per_page;
 

				$select_user = $pdo->prepare("SELECT * FROM tbl_users WHERE userID>'0'$addsel ORDER BY userID DESC LIMIT $startpoint,$per_page");
	$select_user->execute();
if($select_user->rowCount() > 0)
{
	while($row=$select_user->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);

		$usertype=$row['userType'];
    $usertype2=get_usertype($row['userType']);
		?>
					<tr>
						
						<td><a href="../profile.php?id=<?php
 
 echo $row['userID'];?>"><?php
 
 echo $row['firstName'];?> <?php
 
  echo $row['lastName']; ?></a></td>
						<td><a href="mailto:<?php
 
 echo $row['userEmail']; ?>"><?php
 
 echo $row['userEmail']; ?></a></td>

						<td><?php
 
 echo $usertype2; ?></td>
<td><strong><?php
 
 echo $row['userState']; ?></strong></td>
						<td>
							<a href="#edit<?php
 
 echo $row['userID']; ?>" data-toggle="modal" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
<a href="<?php
 
 echo $site_url; ?>/send_notice.php?nid=<?php
 
 echo $row['userID']; ?>" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i>Message</a> 
							 
  <?php
 
 if($row['userStatus']=="N") {?>

  <a href="edit.php?activate=1&id=<?php
 
 echo $row['userID']; ?>"> <button class="btn btn-success">Approve</button></a>
   
<?php
 
 } ?>
 
<?php
 
 if($row['userState']=="Active") {?>

<a href="#dea<?php
 
 echo $row['userID']; ?>" data-toggle="modal" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Deactivate</a>
  
<?php
 
 } ?>

<?php
 
 if($row['userState']=="Inactive") {?>

  <a href="edit.php?activate=1&id=<?php
 
 echo $row['userID']; ?>"> <button class="btn btn-success">Activate</button></a>
<?php
 
 } ?>
							<!-- Deactivate -->
    <div class="modal fade" id="dea<?php
 
 echo $row['userID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Deactivate</h4></center>
                </div>
                <div class="modal-body">
				
				<div class="container-fluid">
					<h5><center>Firstname: <strong><?php
 
 echo $row['firstName']; ?> <?php
 
 echo $row['lastName']; ?></strong></center></h5> 
                </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="edit.php?deactivate=1&id=<?php
 
 echo $row['userID']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Deactivate</a>
 

       <a href="edit.php?delete=1&id=<?php
 
 echo $row['userID']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
         </div>
				
            </div>
        </div>
    </div>


<!-- Deactivate -->
    <div class="modal fade" id="dea<?php
 
 echo $row['userID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Deactivate account</h4></center>
                </div>
                <div class="modal-body">
				
				<div class="container-fluid">
					<h5><center> <strong><?php
 
 echo $row['firstName']; ?> <?php
 
 echo $row['lastName']; ?></strong></center></h5> 
                </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="edit.php?deactivate=1&id=<?php
 
 echo $row['userID']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Deactivate</a>
                </div>
				
            </div>
        </div>
    </div>
<!-- /.modal -->


<!-- Delete -->
    <div class="modal fade" id="del<?php
 
 echo $row['userID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Delete account</h4></center>
                </div>
                <div class="modal-body">
				
				<div class="container-fluid">
					<h5><center> <strong><?php
 
 echo $row['firstName']; ?> <?php
 
 echo $row['lastName']; ?></strong></center></h5> 
                </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="edit.php?delete=1&id=<?php
 
 echo $row['userID']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                </div>
				
            </div>
        </div>
    </div>
<!-- /.modal -->

<!-- Edit -->
    <div class="modal fade" id="edit<?php
 
 echo $row['userID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Edit Account</h4></center>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
				<form method="POST" action="<?php
 

echo $site_url; ?>/manage/edit.php?id=<?php
 
 echo $row['userID']; ?>">
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Firstname:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="firstname" class="form-control" value="<?php
 
 echo $row['firstName']; ?>">
						</div>
					</div>
					<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Lastname:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="lastname" class="form-control" value="<?php
 
 echo $row['lastName']; ?>">
						</div>
					</div>
	<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Email:</label>

						</div>
						<div class="col-lg-10">
							<input type="text" name="email" class="form-control" value="<?php
 
 echo $row['userEmail']; ?>">
						</div>
					</div>
<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Phone:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="phone" class="form-control" value="<?php
 
 echo $row['phone']; ?>">
						</div>
					</div>

					<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Address:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="address" class="form-control" value="<?php
 
 echo $row['address']; ?>">
						
	               </div> 
				</div>
 <div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Account type:</label>
						</div>
						<div class="col-lg-10">
<script type="text/javascript"> function showfield_<?php
 
 echo $user_id;?>(name){ if(name=='is_highcourt')document.getElementById('div<?php
 
 echo $user_id;?>').innerHTML='  <div class="form-group"> <label>High Court Name</label><input type="text" class="form-control" placeholder="Enter court name" name="court" value="<?php
 
 if(isset($_POST['court'])) echo $_POST['court']; ?>" required /></div><div class="form-group"> <label>Court Address</label><input type="text" class="form-control" placeholder="Enter court address" name="court_ad" value="<?php
 
 if(isset($_POST['court_ad'])) echo $_POST['court_ad']; ?>" required /></div>  <div class="form-group"> <label>Court Contact(Phone)</label><input type="text" class="form-control" placeholder="Enter court no.." name="court_ph" value="<?php
 
 if(isset($_POST['court_ph'])) echo $_POST['court_ph']; ?>" required /></div>'; else if(name=='is_court')document.getElementById('div<?php
 
 echo $user_id;?>').innerHTML='  <div class="form-group"> <label>Court Name</label><input type="text" class="form-control" placeholder="Enter court name" name="court" value="<?php
 
 if(isset($_POST['court'])) echo $_POST['court']; ?>" required /></div>  <div class="form-group"> <label>Court Address</label><input type="text" class="form-control" placeholder="Enter court address" name="court_ad" value="<?php
 
 if(isset($_POST['court_ad'])) echo $_POST['court_ad']; ?>" required /></div>  <div class="form-group"> <label>Court Contact(Phone)</label><input type="text" class="form-control" placeholder="Enter court no.." name="court_ph" value="<?php
 
 if(isset($_POST['court_ph'])) echo $_POST['court_ph']; ?>" required /></div>'; else if(name=='is_lawyer')document.getElementById('div<?php
 
 echo $user_id;?>').innerHTML='  '; else document.getElementById('div<?php
 
 echo $user_id;?>').innerHTML=''; } </script>

<select class="form-control" name="usertype" id="usertype" onchange="showfield_<?php
 
 echo $user_id;?>(this.options[this.selectedIndex].value)" required>   
   
<option value="<?php
 
 echo $usertype; ?>"><?php
 
  echo"". get_usertype($usertype)."";  ?></option>
<option value="is_lawyer">Lawyer</option>
  
<option value="is_court">Court Manager</option>
 <option value="is_highcourt">High Court Manager</option> 
</select> 
 

 <div id="div<?php
 
 echo $user_id;?>">
</div>

</div>
</div>


<div style="height:10px;"></div>
	 <div class="form-group">
		
     <label>Change Password (<b>Leave empty for null</b>)  </label>
		
        <input type="password" class="form-control" placeholder="Password" name="password" />
    
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
						</td>
 
					</tr>
					<?php
 

				}
			
}
			?>
			</tbody>
		</table>

<?php
 

echo pagination($statement,$per_page,$page,$url='?');
?>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
	<?php
 
 include('adduser_modal.php'); ?>
</div>
  <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <script src="../js/endy.js"></script>

</body>
