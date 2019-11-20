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

//For Admin only
if($is_usertype!="is_admin"){

header('location:index.php');
exit;
}

//Query UNION group
$addcourt="
UNION ALL
SELECT * FROM tbl_users WHERE userType='is_court'";

$addcourta="
UNION ALL
SELECT * FROM tbl_users WHERE userType='is_court' AND court_status='Active'";
$addcourtinc="
UNION ALL
SELECT * FROM tbl_users WHERE userType='is_court' AND court_status=''";

//Total court count
	$select_court_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userID>'0' AND userType='is_highcourt'$addcourt");
	$select_court_count->execute();
$usercount=$select_court_count->rowCount();

	//Active Court count
	$select_court_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_highcourt' AND court_status='Active'$addcourta");
	$select_court_count->execute();
$useractive=$select_court_count->rowCount();

//Inactive Court count
	$select_court_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_highcourt' AND court_status=''$addcourtinc");
	$select_court_count->execute();
$userinactive=$select_court_count->rowCount();


//Court count
$select_court_count = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_court'");
	$select_court_count->execute();
$userd=$select_court_count->rowCount();

//Search court
	if(isset($_POST['btn-search']))
{
	$search = trim($_POST['search']);
    $addsel = " AND userEmail='$search'";
}



echo"  <title>Courts Management- ".site_name()."</title>";

include "../includes/logmenu.php";
?>

 <div id="page-wrapper">

            <div class="container-fluid">


                <!-- Page Heading -->
                <div class="row">
       <?php
 
	
include "regclient.php";
 ?>
</div>
<div class="row"> 
         <div class="col-lg-12"> 
          <div class="main-box clearfix"> 
           <header class="main-box-header clearfix"> 
             

 <?php
$msg = "<div class='alert alert-info'>".$_GET['msg_a']."</div>";

 if(isset($_GET['msg_a'])) echo $msg;  ?>

		<span class="pull-right"><a href="#addnewaccount" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New Court</a></span>

 
<span class="pull-left"><a href="?user=" class="btn-xs btn-success"><span class="glyphicon glyphicon-user"></span>All Registered Courts(<?php echo $usercount;?>)</a></span>

<span class="pull-left"><a href="?user=active" class="btn-xs btn-primary"><span class="glyphicon glyphicon-user"></span>Active Courts (<?php echo $useractive;?>)</a></span>

<span class="pull-left"><a href="?user=inactive" class="btn-xs btn-danger"><span class="glyphicon glyphicon-user"></span>Inactive Courts (<?php echo $userinactive;?>)</a></span>

		<div style="height:50px;"></div>
      </header> 

           <div class="main-box-body clearfix"> 

</div>

	

<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
         
				
				<th><div class="label label-success">  Court Name</div></th>
 <th><div class="label label-success">  Status</div></th>
            
<th><div class="label label-success">  Court Manager</div></th>
             <th><div class="label label-success">  Address</div></th>
             <th> <div class="label label-success">  Phone</div></th>             
				<th><div class="label label-success">  Action</div></th>
			</thead>
			<tbody>
			<?php
				
 if($_GET['user']=="") {

				
}
if($_GET['user']=="inactive") {

$addsel = " AND court_status=''";

				
}
if($_GET['user']=="active") {
$addsel = " AND court_status='Active'";

				
}
if($_GET['user']=="pending") {
$addsel = " AND court_status=''";

				
}
$addcourt="
UNION ALL
SELECT * FROM tbl_users WHERE userType='is_court'$addsel 
";

//Navigation
$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
 
$per_page = 10; // Set how many records do you want to display per page.

$statement = "tbl_users WHERE court_status='Active'"; 
 
$startpoint = ($page * $per_page) - $per_page;
 

				$select_court = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_highcourt'$addsel$addcourt ORDER BY userID DESC LIMIT $startpoint,$per_page");
	$select_court->execute();
if($select_court->rowCount() > 0)
{
	while($row=$select_court->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);

$court_id=trim($row['userID']); 

$court_name=trim($row['court_name']); 

$court_address=trim($row['court_address']); 

$court_phone=trim($row['court_phone']); 

$court_status=trim($row['court_status']); 
if($court_status=="") {
$court_status="Inactive";
}
		$usertype=trim($row['userType']);
    $court_manager=trim($row['userName']);
		?>
					<tr>
					
			
						<td><a href="<?php echo $site_url; ?>/view_court.php?id=<?php echo $court_id; ?>"><?php echo $court_name; ?></a></td>
<td><strong><?php echo $court_status; ?></strong></td>
				

			<td><a href="<?php echo $site_url; ?>/profile.php?id=<?php echo $court_id; ?>"><?php echo $court_manager; ?></a></td>
						<td><?php echo $court_address; ?></td>

<td><?php echo $court_phone; ?></td>
		<td>
							<a href="#edit<?php echo $row['userID']; ?>" data-toggle="modal" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
							 
  <?php if($row['court_status']=="pending") {?>

  <a href="edit.php?activate=1&id=<?php echo $row['userID']; ?>"> <button class="btn btn-success">Approve</button></a>
   
<?php } ?>
 
<?php if($row['court_status']=="Active") {?>

<a href="#dea<?php echo $row['userID']; ?>" data-toggle="modal" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Deactivate</a>
  
<?php } ?>

<?php if($row['court_status']=="") {?>

  <a href="edit.php?activate_court=1&id=<?php echo $row['userID']; ?>"> <button class="btn btn-success">Activate</button></a>
<?php } ?>
							<!-- Deactivate -->
    <div class="modal fade" id="dea<?php echo $row['userID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Deactivate</h4></center>
                </div>
                <div class="modal-body">
 
	<div class="container-fluid">
					<h5><center> <?php echo $row['court_name']; ?> </strong></center></h5> 
                </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="edit.php?deactivate_court=1&id=<?php echo $row['userID']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Deactivate</a>
                </div>
				
            </div>
        </div>
    </div>


<!-- Deactivate -->
    <div class="modal fade" id="dea<?php echo $row['userID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Deactivate Court</h4></center>
                </div>
                <div class="modal-body">
				
				<div class="container-fluid">
					<h5><center> <strong><?php echo $court_name; ?></strong></center></h5> 
                </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="edit.php?deactivate_court=1&id=<?php echo $row['userID']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Deactivate</a>
                </div>
				
            </div>
        </div>
    </div>
<!-- /.modal -->


<!-- Delete -->
    <div class="modal fade" id="del<?php echo $row['userID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Delete Court</h4></center>
                </div>
                <div class="modal-body">
				
				<div class="container-fluid">
					<h5><center> <strong><?php echo $court_name; ?> </strong></center></h5> 
                </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="edit.php?delete=1&id=<?php echo $row['userID']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                </div>
				
            </div>
        </div>
    </div>
<!-- /.modal -->

<!-- Edit -->
    <div class="modal fade" id="edit<?php echo $row['userID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Edit Court #<?php echo $court_id; ?></h4></center>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
				<form method="POST" action="edit.php?id=<?php echo $row['userID']; ?>">

					  <div class="form-group"> <label>Court Name</label><input type="text" class="form-control" name="court" value="<?php echo $court_name; ?>" required /></div>  

<div class="form-group"> <label>Court Address</label><input type="text" class="form-control" name="court_ad" value="<?php echo $court_address; ?>" required /></div> 

 <div class="form-group"> <label>Court Contact(Phone)</label>
<input type="text" class="form-control" name="court_ph" value="<?php echo $court_phone; ?>" required />
</div>
 <div class="form-group"> <label>Court Manager  (<strong><?php echo 
$court_manager;?></strong>)</label>    </div>

                </div>
					</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <button type="submit" class="btn btn-warning" name="btn-editcourt"><span class="glyphicon glyphicon-check"></span> Save</button>
         

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
	<?php include('addcourt_modal.php'); ?>
</div>
  <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <script src="../js/endy.js"></script>

</body>
