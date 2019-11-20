<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
?>

<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <center><h4 class="modal-title" id="myModalLabel">Add a new case</h4></center>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
				<form method="POST" action="<?php echo $site_url;?>/manage/manage_case.php"  enctype="multipart/form-data">
			<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Case Title:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="case_name" class="form-control" required>
						</div>
					</div>

					<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Case Content:</label>
						</div>
						<div class="col-lg-10">
							<textarea class="form-control" rows="3" name="case_text" required></textarea>
						</div>
					</div>
		<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Case Document:</label>
						</div>
						<div class="col-lg-10">
							<input type="file" class="form-control" name="case_attachment">
						</div>
					</div>
		

<div style="height:10px;"></div>
     <div class="row">
						<div class="col-lg-2">

						 
 <label style="position:relative; top:7px;">Post case to (Select Court):</label>
</div>
<div class="col-lg-10">


<select class="form-control" name="id" required>
<?php

//Select post court query
	$stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_highcourt' AND court_status='Active' ORDER BY userID DESC");
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
 
</div>
		

</div> 
				</div>
                <div class="modal-footer">
                    <a href="?" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</a>
                    <button type="submit" class="btn btn-primary" name="btn-addcase"><span class="glyphicon glyphicon-money"></span> Post Case</a>
				</form>
                </div>
				
            </div>
        </div>
</div>