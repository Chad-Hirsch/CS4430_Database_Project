<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
require_once 'conn.php';

$user_login = new USER();

echo"  <title> Activities - ".site_name()."</title>";

include "includes/logmenu.php";


$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);
$user=$rows['userID'];

?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                
<div class="row col-lg-12">
 
                <!-- /.row -->

<div class="_col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Tasks Panel</h3>
                            </div>
                            <div class="panel-body">

                                <div class="row">
<div class=" col-md-9 col-lg-9 ">
<?php
	$stmt = $pdo->prepare("SELECT * FROM notice WHERE comment_to='$user' ORDER BY comment_date DESC LIMIT 100");
	$stmt->execute();
if($stmt->rowCount() > 0)
{
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);
$dates=$row['comment_date'];
		?>
                      
   

                                    
                                    <a href="<?php echo''.$site_url.'/view_notice.php?id='.$row['comment_id'].''; ?>" class="list-group-item">
                                        <span class="badge"><?php echo"".date('d | M | Y',$dates)." ".date('H:i',$dates).""; ?></span>
                                        <i class="fa fa-fw fa-money"></i> <?php echo $row['comment_subject']; ?>
                                    </a>
                    <?php }
}
else {
echo'<a href="#" class="list-group-item">
                                        <span class="badge"></span>
                                        <i class="fa fa-fw fa-money"></i> No activity yet
                                    </a>
';

}
?>
                
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

