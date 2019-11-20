<!-- /.modal -->

<!-- Edit -->
    <div class="modal fade" id="manage<?php echo $case_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Manage Case #<?php echo $case_id; ?> - <?php echo $case_name; ?></h4></center>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
<?php 
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */ 
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
                            

<form method="POST" action="<?php echo $site_url; ?>/manage/edit.php?id=<?php echo $case_id; ?>" enctype="multipart/form-data">
						 <div class="form-group">
 <label style="position:relative; top:7px;">Send this case to:</label>
<select class="form-control" name="posto" required>
<option value="">Please Select Court...</option>
<?php
	$stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_court' AND userState='Active' ORDER BY userID DESC");
	$stmt->execute();
if($stmt->rowCount() > 0)
{
	while($rowx=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		extract($rowx);
		?>
                      
   
<option value="<?php echo $rowx['userID']; ?>"><?php echo $rowx['court_name']; ?> </option>
 
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
			<form method="POST" action="<?php echo $site_url; ?>/manage/edit.php?id=<?php echo $case_id; ?>" enctype="multipart/form-data">
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
							<textarea class="form-control" rows="5" name="case_text" required><?php echo $case_text; ?></textarea>
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