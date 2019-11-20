<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
require_once 'conn.php';



echo"  <title> Dashboard - ".site_name()."</title>";

include "includes/logmenu.php";

?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    
   
                        <ol class="breadcrumb">
                           <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard Overview
                            </li>
                            
                        </ol>
                    </div>
                </div>
      <!-- /.row -->
   <?php 
  
//Checking court status
if(preg_match('/court/i', $is_usertype)) {
	
	if($row['court_status']=="") {
header('location:login.php?inactive');
exit;

 }
}
?>

<!-- Counting Cases | Active Courts | Notification --!>

   <div class="row"> 
         <div class="col-lg-3 col-sm-6 col-xs-12"> 
         <a href="view_task.php">
      <div class="main-box infographic-box colored green-bg"> 
           <i class="fa fa-envelope"></i> 
           <span class="headline">Cases</span> 
           <span class="value"><?php echo $casecount;?></span> 
          </div> 
</a>
         </div> 
   <div class="col-lg-3 col-sm-6 col-xs-12"> 
          <div class="main-box infographic-box colored gray-bg"> 
           <i class="fa fa-envelope"></i> 
           <span class="headline">Draft cases</span> 
           <span class="value"><?php echo $draftcasecount;?></span> 
          </div> 
         </div> 
         <div class="col-lg-3 col-sm-6 col-xs-12"> 
          <div class="main-box infographic-box colored emerald-bg"> 
           <i class="fa fa-envelope"></i> 
           <span class="headline">Opened cases</span> 
           <span class="value"><?php echo $opencasecount;?></span> 
          </div> 
         </div> 
 
<div class="col-lg-3 col-sm-6 col-xs-12"> 
         <a href="view_task.php"> 

<div class="main-box infographic-box colored red-bg"> 
           <i class="fa fa-envelope"></i> 
           <span class="headline">Closed Cases</span> 
           <span class="value"><?php echo $closecasecount;?></span> 
          </div> 
</a>
         </div> 


 <div class="col-lg-3 col-sm-6 col-xs-12"> 
          <div class="main-box infographic-box colored purple-bg"> 
           <i class="fa fa-envelope"></i> 
           <span class="headline">Courts</span> 
           <span class="value"><?php echo $courtcount;?></span> 
          </div> 
         </div> 

   <div class="col-lg-3 col-sm-6 col-xs-12"> 
          <div class="main-box infographic-box colored yellow-bg"> 
           <i class="fa fa-envelope"></i> 
           <span class="headline">Notifications</span> 
           <span class="value"><?php echo $taskcount;?></span> 
          </div> 
         </div> 




    </div> 

<!-- END Counting Cases | Active Courts | Notification --!>

<div class="row"> 
         <div class="col-lg-12"> 
          <div class="main-box clearfix"> 

<!-- Search case --!>

<form method="POST" action="manage/manage_case.php?search">
           <header class="main-box-header clearfix"> 
 

        <div class="alert alert-success">
List of the cases you are working on. You can  click the case title in the list below to view the details page of the chosen case.
</div>
  
        
    <div class="filter-block pull-right"> 
             <div class="form-group input-group">    
                       <select class="form-control" name="search" required>

<option value="all">All</option> 
<option value="open">Open Case</option> 
 <option value="closed">Close Case</option> 
          <option value="draft">Draft Case</option> 
               
  </select>
   
<span class="input-group-btn ">  <button type="submit" name="btn-search" class="btn btn-success" type="button"> <i class="fa fa-eye fa-lg"></i> View Case</button></span>
            
  </div>
 <?php
 //Quick Add Case button. Show to other user except court 
      if(!preg_match('/court/i', $is_usertype)) {
  
?>
    <span class="pull-right">
                        <a href="<?php echo $site_url; ?>/manage/manage_case.php?case=add">  <button class="btn btn-success" type="button"> <i class="fa fa-plus fa-lg"></i> Post New Case</button>
</a>
</span>

                    
  <?php     }
  
?>
           
   </div> 
           </header> 

</form>
  
                     <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                       <thead>
                                  <tr>
   
                                                <th><div class="label label-success">   #</div></th>
                                                <th> 
<div class="label label-success"> Date</div</th>
 <th><div class="label label-success">   Title</div></th>
                                              
                                                <th><div class="label label-success">   Status</div></th>
                                              
                                                     <th><div class="label label-success">   Action</div></th>
  
                                  </tr>
 
                                        </thead>
  
                                        <tbody>
                                         

 <div>
                                
<?php

$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
 
$per_page = 5; // Set how many records do you want to display per page.

$statement = "cases WHERE caseID>'0'$addsel"; 
$startpoint = ($page * $per_page) - $per_page;
 
//Admin users Query

if(preg_match('/is_admin/i', $is_usertype)) {

$statement = "cases WHERE caseID>'0'$addsel"; 


$stmtp = $pdo->prepare("SELECT * FROM cases WHERE caseID>'0'$addsel ORDER BY case_date DESC LIMIT $startpoint,$per_page");
}
elseif(preg_match('/is_highcourt/i', $is_usertype))
{
	//High Court users Query
	
$statement = "cases WHERE case_to='$user'$addsel"; 

	$stmtp = $pdo->prepare("SELECT * FROM cases WHERE case_to='$user'$addsel ORDER BY case_date DESC LIMIT $startpoint,$per_page");
  }
elseif(preg_match('/is_court/i', $is_usertype))
{
	
	//Court users Query
	
$statement = "cases WHERE case_posted='$user'$addsel"; 

	$stmtp = $pdo->prepare("SELECT * FROM cases WHERE case_posted='$user'$addsel ORDER BY case_date DESC LIMIT $startpoint,$per_page");
  }
else
{
	//Others users Query
	
$statement = "cases WHERE case_from='$user'$addsel"; 

	$stmtp = $pdo->prepare("SELECT * FROM cases WHERE case_from='$user'$addsel ORDER BY case_date DESC LIMIT $startpoint,$per_page");
}

//execute query
	$stmtp->execute();
if($stmt->rowCount() > 0)
{
	while($row=$stmtp->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);
$dates=$row['case_date'];
$case_name=trim($row['case_name']);

$case_status=$row['case_status'];
$case_text=$row['case_text'];
$case_byy=$row['case_to'];
$case_by=get_user($case_byy, userName);
$case_id=$row['caseID'];
$colorstatus="danger";
if($case_status=="Open"){
$colorstatus="success";
}
			?>
                      
   

                        <tr>
                                                <td><a href="<?php echo $site_url; ?>/view_case.php?id=<?php echo $case_id; ?>"><?php echo$case_id; ?></a></td>
                                                <td><?php echo"".date('d/m/Y',$dates).""; ?>
                                               </td>
<td><a href="<?php echo $site_url; ?>/view_case.php?id=<?php echo $case_id; ?>"><?php echo $case_name; ?></a></td>
                                               


                                                <td><span class="label label-<?php echo $colorstatus; ?>"><?php echo $case_status; ?></span></td>
<td><a href="<?php echo $site_url; ?>/view_case.php?id=<?php echo $case_id; ?>"><span class="label label-success">View</span></a> -
<?php if(!preg_match('/is_lawyer/i', $is_usertype)) {
 ?>
<a href="#manage<?php echo $case_id; ?>" data-toggle="modal"><span class="label label-success">Manage</span></a>
 <?php
 } ?>
</td>

                                            </tr>
  <?php
//Include update case file
include "manage/updatecase_modal.php";
}
}
else {
echo"  <tr>
 <td>No result yet</td></tr>";
}
  ?>   
                                                      </tbody>
                                    </table>
<?php
//Query navigation
echo pagination($statement,$per_page,$page,$url='?');
?>
                                 </div> 
           </div> 
          </div> 
         </div> 
         

                <!-- /.row -->

<?php 

//Include additional dashboard
include "includes/dash.php";
?>

</div>
            <!-- /.container-fluid -->



        </div>
        <!-- /#page-wrapper -->

<?php 
//Modal
if(preg_match('/is_admin/i', $is_usertype)) {
include "manage/adduser_modal.php";

}
 ?>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

<!-- Endy notice JavaScript-->

<script src="js/endy2.js"></script>



</body>
