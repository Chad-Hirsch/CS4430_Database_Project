<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
require_once 'conn.php';


//SENDING NOTIFICATION


$username=$rows['userName'];

if(isset($_POST['btn-send-notice']))
{
	$nsubject = trim($_POST['subject']);
	$ntext = trim($_POST['txt']);

	$nto = trim($_POST['to']);

   $time = time();

//Notification
	
if($nto !="") {
$stmtno = $pdo->prepare("INSERT INTO notice(comment_subject,comment_text,comment_to,comment_from,comment_status,comment_date) 
			                                             VALUES('$nsubject', '$ntext', '$nto', '$session_id', '0', '$time')");
 $stmtno->execute();

}
}

echo"  <title>Send Notice - ".site_name()."</title>";

include "includes/logmenu.php";


?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
          
                <!-- /.row -->

<div class="row">
                    <div class="col-lg-4">

  <?php 
		if($stmtno)
		{
			?>
            <div class='alert alert-success'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Notification sent!</strong>
			</div>
            <?php
		}
		?>
<div class="clearfix"><br/><br/></div>

<div>
<div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Send Notice</h3>
                            </div>
                            <div class="panel-body">
                               
                          
        <form class="form-signin" method="post">
    
                        <div class="modal-body">
				<div class="container-fluid">
				<form method="POST" action="">
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;">Subject:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" value="<?php echo $nsubject;?>" name="subject" maxlength="100" required>
						</div>
					</div>
				
<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Message:</label>
						</div>
						<div class="col-lg-10">
							<textarea class="form-control" rows="3" name="txt" required><?php echo $ntext;?></textarea>
						</div>
					</div>

					
 <div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Send to:</label>
						</div>
						<div class="col-lg-10">
<select class="form-control"  name="nto" disabled> 
  
<?php
$nid=$_GET['nid'];
	$stmtp = $pdo->prepare("SELECT * FROM tbl_users WHERE userState='Active' AND userID='$nid'");
	$stmtp->execute();
if($stmtp->rowCount() > 0)
{
	while($rown=$stmtp->fetch(PDO::FETCH_ASSOC))
	{
		extract($rown);
    
	$user_name=$rown['userName'];
      
		$usertype=$rown['userType'];
       $user_id=$rown['userID'];
   $usertype2=get_usertype($rown['userType']);
	
	?>
<option value="<?php echo $user_id; ?>"><?php echo $user_name; ?> (<?php echo"". get_usertype($usertype).""; ?>)</option>
  

<?php }
}

else {
echo '<option value="">No user selected</option>';
}
 ?>

</select> 
 
<input type="hidden" value="<?php echo $user_id; ?>" name="to" required>
</div>
</div>

                </div> 
				</div>
                <div class="modal-footer">
                    
                    <button type="submit" class="btn btn-success" name="btn-send-notice"><span class="glyphicon glyphicon-envelope"></span> Send</a>
				</form>
  </div>
                        </div>
                    </div>

</div>
</div>

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

</html>
