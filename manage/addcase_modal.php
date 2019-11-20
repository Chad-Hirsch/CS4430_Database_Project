<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
?>
<!-- Add New -->
    <div class="modal fade" id="addnewcase" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Add a new case</h4></center>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
				<form method="POST" action="?add"  enctype="multipart/form-data">
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
</div><div class="col-lg-10">

<select class="form-control" name="id" required>
<?php
	$add_case = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_highcourt' AND court_status='Active' ORDER BY userID DESC");
	$add_case->execute();
if($add_case->rowCount() > 0)
{
	while($row=$add_case->fetch(PDO::FETCH_ASSOC))
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

		

<?php
if(preg_match('/is_admin|is_highcourt/i', $is_usertype)) {
 ?>
		
 <div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Case Status:</label>
						</div>
						<div class="col-lg-10">
<select class="form-control"  name="court_status" required>   
   

 <option value="Draft">Draft</option>   
<option value="Open">Open</option>
<option value="Closed">Closed</option>
</select> 
 
</div>
</div>

 
          <?php } ?>      </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <button type="submit" class="btn btn-primary" name="btn-addcase"><span class="glyphicon glyphicon-money"></span> Add</a>
				</form>
                </div>
				
            </div>
        </div>
    </div>
