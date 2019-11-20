<?php
 
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
require_once 'conn.php';

echo"  <title> Viewing Notification - ".site_name()."</title>";

include "includes/logmenu.php";

//User Session
$session_user = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$session_user->execute(array(":uid"=>$_SESSION['userSession']));
$rows = $session_user->fetch(PDO::FETCH_ASSOC);
$user=$rows['userID'];

//Select Notification
$notice_id=$_REQUEST['id'];
	$select_notice = $pdo->prepare("SELECT * FROM notice WHERE comment_id='$notice_id'");
	$select_notice->execute();
if($stmt->rowCount() > 0)
{
	while($row=$select_notice->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);
$dates=$row['comment_date'];
$ctext=nl2br($row['comment_text']);
$csubject=trim($row['comment_subject']);
$cif=get_user($row['comment_from'], userName);

}
}		?>
                


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                
<div class="row">
 
                <!-- /.row -->

<div class="_col-lg-4">
<br/><br/>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>  <?php echo $csubject; ?></h3>
                            </div>
                            <div class="panel-body">

                               
<div class="row">
<div class=" col-md-9 col-lg-9 ">
                            
      
   

                                            
                                        <span class="badge"><?php echo"".date('d | M | Y',$dates)." ".date('H:i',$dates).""; ?></span>
                           <div class="alert alert-info">
             <i class="fa fa-fw fa-money"></i> <?php echo $ctext; ?>
    <br/> 
                                    
                             
                                </div>
                               
From <span class="badge"><a href="profile.php?id=<?php echo$row['comment_from']; ?>"><?php echo $cif; ?></a></span>
                            </div>
                        </div>
                    </div>


</div>
                    </div>
                <!-- /.row -->
</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->



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
