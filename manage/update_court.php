<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */

require_once '../conn.php';

//Editing court
$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);
$user=$rows['userID'];

$court_name=trim($rows['court_name']); 

$court_address=trim($rows['court_address']); 

$court_phone=trim($rows['court_phone']); 

$court_status=trim($rows['court_status']); 

$court_manager=trim($rows['userName']);

echo"  <title> My Court- ".site_name()
."</title>";

include "../includes/logmenu.php";


?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
          
                <!-- /.row -->

<div class="row">
                    <div class="col-lg-4">

  <?php 
		if(isset($_GET['msg_a'])) 
		{
			?>
            <div class='alert alert-warning'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Updated!</strong>
			</div>
            <?php
		}
		?>
<div class="clearfix"><br/><br/></div>

<div>
<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">My Court</h3>
                            </div>
                            <div class="panel-body">
                               
                          
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel"><?php echo $court_name; ?></h4></center>
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
                    
                    <button type="submit" class="btn btn-warning" name="btn-editcourt"><span class="glyphicon glyphicon-check"></span> Save</button>
         

  </div>
				</form>
            </div>
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

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>
