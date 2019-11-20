<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
require_once 'conn.php';


$user_case = new USER();


//Getting case ID
$order_sql=$_GET['id'];

	$stmtp = $pdo->prepare("SELECT * FROM cases WHERE caseID=:order_sql");
	$stmtp->execute(array(":order_sql"=>$order_sql));

if($stmtp->rowCount() > 0)
{
	while($row=$stmtp->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);

				$dates=$row['case_date'];
$case_name=$row['case_name'];

$case_status=$row['case_status'];
$case_text=$row['case_text'];
$case_from=$row['case_from'];
$case_to_s=$row['case_to'];
$case_to=get_user($case_to_s, court_name);
$case_by=get_user($case_from, userName);
$postd=$row['case_posted'];
$post_to=get_user($postd, court_name);

$case_id=$row['caseID'];
$colorstatus="danger";
if($case_status=="Open"){
$colorstatus="success";
}
}
}			
else {

$err_m=" Invalid Request ";
}

echo"  <title> Case  #$case_id - ".site_name()."</title>
";

include "includes/logmenu.php";


?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->

                             <div class="_list-group">

              
<div class="row col-lg-12">
 
                <!-- /.row -->

   <div class="col-lg-6">
                      <div class="alert alert-success">
                            
                            <i class="fa fa-info-circle"></i> <h2>Case details: #<?php echo $case_id;?>, Title: <?php echo $case_name;?></h2>
</div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>CASE DETAILS</th>
                                        
                                 <th><?php if($case_status != "Closed") {

if(!preg_match('/is_lawyer/i', $is_usertype)) {
 ?>
<span class="pull-right">
<a href="#manage<?php echo $case_id; ?>" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Update Case</a></a>
</span>
   
<?php }} ?>
</th>
      
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr class="warning">
                                        <td><strong>Case Number</strong></td>
                                        <td><?php echo $case_id;?></td>
                                        
                                    </tr>                 
                                    <tr class="warning">
                                        <td><strong>Case Title:</strong></td>
                                        <td><?php echo$case_name;?></td>
                                        
                                    </tr>
         
                      <tr class="warning">
                                        <td><strong>Filed Date:</strong></td>
                                        <td><?php echo"".date('Y/m/d    H:i',$case_date)."";?></td>
                                        
                                    </tr>     
<tr class="warning">
                                        <td><strong>Status </strong></td>
<td> <?php echo $case_status;?>
                                        </td>
                                        
                                    </tr>               
                            
   <tr class="warning">
                                        <td><strong>Filed by:</strong></td>
                                        <td><span class="badge"><a href="profile.php?id=<?php echo $case_from; ?>"><?php echo $case_by; ?></a></span>
</td>
                                        
                                    </tr>          
     
   <tr class="warning">
                                        <td><strong>Filed to:</strong></td>
                                        <td><span class="badge"><a href="profile.php?id=<?php echo $case_to_s; ?>"><?php echo $case_to; ?></a></span>
</td>
                                        
                                    </tr>          

<?php
if(!$postd==""){
?>
     
   <tr class="warning">
                                        <td><strong>Posted  to:</strong></td>
                                        <td><span class="badge"><a href="profile.php?id=<?php echo $postd; ?>"><?php echo $post_to; ?></a> for hearing</span>
</td>
                                        
                                    </tr>          
<?php } ?>
<tr class="warning">
                                        <td><strong>Case Document:</strong></td>
                                        <td><a href="documents/<?php echo $case_attachment;?>">Export Case Documents</a></td>
                                        
                                    </tr>           
                                </tbody>
                            </table>
<div class="panel-heading label-warning"><strong> 
Case Contents:</strong>
</div>
<div class="alert">
<article id="news">

  <?php echo nl2br ($case_text) ?>
    </article>
</div>    
                       
                        </div>

                <!-- /.row -->
</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>

    <?php 
//Modal
if(preg_match('/is_admin/i', $is_usertype)) {
include "manage/adduser_modal.php";

}

include "manage/updatecase_modal.php";

 ?>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


<script src="js/endy2.js"></script>


</body>

