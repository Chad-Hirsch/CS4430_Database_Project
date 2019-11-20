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


//Search Case
	if(isset($_POST['btn-search']))
{
if($_POST['search']!="all") {
	$search = trim($_POST['search']);
    $addsel = " AND case_status='$search'";
}

}

	if(isset($_POST['btn-searchid']))
{
	$search = trim($_POST['search']);
    $addsel = " AND caseID='$search'";

}
echo"  <title> Case Management - ".site_name()."</title>";

include "../includes/logmenu.php";
?>

 <div id="page-wrapper">

            <div class="container-fluid">


                <!-- Page Heading -->
                
<div class="row">
<?php
if($_GET['case']=="add")
{
include "../includes/addcase.php";
}
?>

</div>
<div class="row"> 
         <div class="col-lg-12"> 
          <div class="main-box clearfix"> 
           <header class="main-box-header clearfix"> 
             
           
<!-- Search --!>
	
 <?php

include "addnew_case.php";
 ?>
        <form method="POST" action="?search">
               
      <div class="form-group input-group">
                                <input type="text" class="form-control" placeholder="Search with Case #" name="search">
                                <span class="input-group-btn"><button type="submit" name="btn-searchid" class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span>
           </div></form>              
   
<!-- /Search --!>
<?php

$msg = "<div class='alert alert-info'><button class='close' data-dismiss='alert'>&times;</button>
 ".$_GET['msg_a']."</div>";

 if(isset($_GET['msg_a'])) echo $msg;  

if(preg_match('/is_admin|is_lawyer/i', $is_usertype)) {

?>
		<span class="pull-right"><a href="#addnewcase" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new case</a></span>

<?php } ?>
 
<span class="pull-left"><a href="?case=" class="btn-xs btn-success"><span class="glyphicon glyphicon-shopping-cart"></span>All Cases (<?php echo $casecount;?>)</a></span>

<span class="pull-left"><a href="?case=draft" class="btn-xs btn-danger"><span class="glyphicon glyphicon-shopping-cart"></span>Draft Case(<?php echo $draftcasecount;?>)</a></span>

<span class="pull-left"><a href="?case=open" class="btn-xs btn-success"><span class="glyphicon glyphicon-shopping-cart"></span> Open Case( (<?php echo $opencasecount;?>)</a></span>

<span class="pull-left"><a href="?case=closed" class="btn-xs btn-warning"><span class="glyphicon glyphicon-shopping-cart"></span> Closed Case(<?php echo $closecasecount;?>)</a></span>

		<div styles="height:50px;"></div>
           </header> 

         
           
<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
					<tr>
                                                <th><div class="label label-success">   #</div></th>
                                                <th> 
<div class="label label-success"> Date</div</th>
 <th><div class="label label-success">   Title</div></th>
                                   
                                                <th><div class="label label-success">   Filed by</div></th>
            
                                                <th><div class="label label-success">   Status</div></th>
                                              
                                                     <th><div class="label label-success">   Action</div></th>
			</thead>
			<tbody>
			<?php
				

if($_GET['case']=="draft") {
$addsel = " AND case_status='Draft'";

				
}
if($_GET['case']=="open") {
$addsel = " AND case_status='Open'";

				
}
if($_GET['case']=="closed") {
$addsel = " AND case_status='closed'";

				
}

$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
 
$per_page = 10; // Set how many records do you want to display per page.

$statement = "cases WHERE caseID>'0'$addsel"; 
$startpoint = ($page * $per_page) - $per_page;
 


if(preg_match('/is_admin/i', $is_usertype)) {

$statement = "cases WHERE caseID>'0'$addsel"; 


$select_case = $pdo->prepare("SELECT * FROM cases WHERE caseID>'0'$addsel ORDER BY case_date DESC LIMIT $startpoint,$per_page");
}
elseif(preg_match('/is_highcourt/i', $is_usertype))
{
$statement = "cases WHERE case_to='$user'$addsel"; 

	$select_case = $pdo->prepare("SELECT * FROM cases WHERE case_to='$user'$addsel ORDER BY case_date DESC LIMIT $startpoint,$per_page");
  }
elseif(preg_match('/is_court/i', $is_usertype))
{
$statement = "cases WHERE case_posted='$user'$addsel"; 

	$select_case = $pdo->prepare("SELECT * FROM cases WHERE case_posted='$user'$addsel ORDER BY case_date DESC LIMIT $startpoint,$per_page");
  }
else
{
$statement = "cases WHERE case_from='$user'$addsel"; 

	$select_case = $pdo->prepare("SELECT * FROM cases WHERE case_from='$user'$addsel ORDER BY case_date DESC LIMIT $startpoint,$per_page");
}

				
	$select_case->execute();
if($select_case->rowCount() > 0)
{
	while($row=$select_case->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);

				$dates=$row['case_date'];
$case_name=$row['case_name'];

$case_status=$row['case_status'];
$case_text=$row['case_text'];
$case_from=$row['case_from'];
$case_tos=$row['case_to'];
$case_to=get_user($case_tos, userName);
$postd=$row['case_posted'];

$post_to=get_user($postd, court_name);

$case_by=get_user($case_from, userName);
$case_id=$row['caseID'];
$colorstatus="danger";
if($case_status=="Open"){
$colorstatus="success";
}
			?>
                      
   

                        <tr>
                                                <td><a href="../view_case.php?id=<?php echo $case_id; ?>"> <?php echo $case_id; ?></a></td>
                                                <td><?php echo"".date('d/m/Y',$dates).""; ?></td>
                                                <td>
<a href="<?php echo $site_url; ?>/view_case.php?id=<?php echo $case_id; ?>"><?php echo $case_name; ?></a></td>
                                                

 <td><a href="<?php echo $site_url; ?>/profile.php?id=<?php echo $case_from; ?>"><?php echo $case_by; ?></a></td>
                                      <td><span class="label label-<?php echo $colorstatus; ?>"><?php echo $case_status; ?></span></td>
<td><a href="<?php echo $site_url; ?>/view_case.php?id=<?php echo $case_id; ?>"><button class='btnbtn-success'>View</button></a>

<?php if(!preg_match('/is_lawyer/i', $is_usertype)) {

?>
 -   <a href="#edit<?php echo $case_id; ?>" data-toggle="modal" class="btnbtn-warning"><button class='btnbtn-success'>Manage</button></a> 
  
  

	<?php } ?>					
</td>
	<?php			
if(preg_match('/is_highcourt|is_admin/i', $is_usertype)) {
?>
	<td>
		<a href="#del<?php echo $case_id; ?>" data-toggle="modal" class="btnbtn-danger"><span class="glyphicon glyphicon-trash">Remove</span></a>

</td>
<?php } ?>							<!-- Deactivate -->
    <div class="modal fade" id="del<?php echo $case_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Delete Case</h4></center>
                </div>
                <div class="modal-body">
			
				<div class="container-fluid">
					<h5><center>Case #<?php echo $case_id; ?>: <strong><?php echo $case_name; ?> </strong></center></h5> 
                </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="<?php echo $site_url; ?>/manage/edit.php?delete=case&id=<?php echo $case_id; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                </div>
				
            </div>
        </div>
    </div>


<!-- /.modal -->

<!-- Edit -->
    <div class="modal fade" id="edit<?php echo $case_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Manage Case #<?php echo $case_id; ?> - <?php echo $case_name; ?></h4></center>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
<?php 

if(!preg_match('/is_lawyer/i', $is_usertype)) {
?>
<div class="row">

<?php
if(preg_match('/is_highcourt|is_admin/i', $is_usertype)) {
if(!$postd=="") {
 ?>
<a href="<?php echo $site_url; ?>/manage/edit.php?id=<?php echo $case_id; ?>&mark_received=1"><button class='btn-lg btn-warning'>Mark as received</button>
</a>
<hr/>
<?php
    }
}
if(preg_match('/court|is_admin/i', $is_usertype)) {
if($case_status!="Open"){
 ?>


<a href="<?php echo $site_url; ?>/manage/edit.php?id=<?php echo $case_id; ?>&mark_open=1"><button class='btn-lg btn-success'>Mark as open</button>
</a>
<hr/>
<?php
}
if($case_status!="Closed"){
 ?>

<a href="<?php echo $site_url; ?>/manage/edit.php?id=<?php echo $case_id; ?>&mark_closed=1"><button class='btn-lg btn-danger'>Mark as closed</button>
</a>
	
<hr/>
<?php }
if($case_status!="Draft"){
 ?>

<a href="<?php echo $site_url; ?>/manage/edit.php?id=<?php echo $case_id; ?>&mark_draft=1"><button class='btn-lg btn-danger'>Mark as draft</button>
</a>
<hr/>
<?php }
}
if(preg_match('/is_highcourt|is_admin/i', $is_usertype)) {
if($post_to==""){
 ?>

<a href="javascript:;" data-toggle="collapse" data-target="#post-it<?php echo $case_id; ?>"><button class='btn-lg btn-info'>Post this Case for hearing</button>
</a>
    <div id="post-it<?php echo $case_id; ?>" class="collapse">
                            

<form method="POST" action="edit.php?id=<?php echo $case_id; ?>" enctype="multipart/form-data">
						 <div class="form-group">
 <label style="position:relative; top:7px;">Send this case to:</label>
<select class="form-control" name="posto" required>
<option value="">Please Select Court...</option>
<?php
	$stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_court' AND userState='Active' ORDER BY userID DESC");
	$stmt->execute();
if($stmt->rowCount() > 0)
{
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);
		?>
                      
   
<option value="<?php echo $row['userID']; ?>"><?php echo $row['court_name']; ?> </option>
 
<?php }
?>
<?php }
?>

</select> 
 
<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Case Document: (Upload the signed case document)</label>
						</div>
						<div class="col-lg-10">
							<input type="file" class="form-control" name="case_attachment" required>
						</div>
					</div>


</div>
<div style="height:10px;"></div>
			


<button type="submit" class="btn btn-warning" name="btn-postcase"><span class="glyphicon glyphicon-check"></span> Post </button>
</form>
</div>
<! -- Endy --!>

<hr/>
<?php
}
}
if(!preg_match('/is_lawyer/i', $is_usertype)) {
 ?>

<a href="<?php echo $site_url; ?>/send_notice.php?nid=<?php echo $case_from; ?>"><button class='btn-lg btn-success'><i class="glyphicon glyphicon-envelope"></i> Send Notice to Lawyer </button>
</a>
</div>
	<?php } ?>				

<hr/>
<?php }
if(preg_match('/is_admin/i', $is_usertype)) {
 ?>

<a href="javascript:;" data-toggle="collapse" data-target="#edit-it<?php echo $case_id; ?>"><button class='btn-lg btn-info'>Edit Case</button>
</a>
    <div id="edit-it<?php echo $case_id; ?>" class="collapse">
			<form method="POST" action="edit.php?id=<?php echo $case_id; ?>" enctype="multipart/form-data">
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Case Title:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="case_name" value="<?php echo $case_name; ?>" class="form-control" required>
						</div>
					</div>

					<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Case Content:</label>
						</div>
						<div class="col-lg-10">
							<textarea class="form-control" rows="3" name="case_text" required><?php echo $case_text; ?></textarea>
						</div>
					</div>
		<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Case Document: (<?php
if(!$case_attachment==""){
?>
<a href="<?php echo $site_url; ?>/documents/<?php echo $case_attachment;?>">Export</a> <?php } ?>
)</label>
						</div>
						<div class="col-lg-10">
							<input type="file" class="form-control" name="case_attachment">
						</div>
					</div>


<div style="height:10px;"></div>
			


<button type="submit" class="btn btn-warning" name="btn-editcase"><span class="glyphicon glyphicon-check"></span> Save</button>
</form>
</div>
	<?php	
} ?>

                </div>
					</div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    
         
  </div>
				
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
include "modal.php";
?>
</div>
  <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <script src="../js/endy.js"></script>

</body>
</html> 