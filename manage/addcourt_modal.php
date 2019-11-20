<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
?>
<!-- Add New -->
    <div class="modal fade" id="addnewaccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Add New Court</h4></center>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
				<form method="POST" action="">
					

 <div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Court type:</label>
						</div>
						<div class="col-lg-10">
<script type="text/javascript"> function showfield(name){ if(name=='is_highcourt')document.getElementById('div11').innerHTML='  <div class="form-group"> <label>High Court Name</label><input type="text" class="form-control" placeholder="Enter court name" name="court" value="<?php if(isset($_POST['court'])) echo $_POST['court']; ?>" required /></div><div class="form-group"> <label>Court Address</label><input type="text" class="form-control" placeholder="Enter court address" name="court_ad" value="<?php if(isset($_POST['court_ad'])) echo $_POST['court_ad']; ?>" required /></div>  <div class="form-group"> <label>Court Contact(Phone)</label><input type="text" class="form-control" placeholder="Enter court no.." name="court_ph" value="<?php if(isset($_POST['court_ph'])) echo $_POST['court_ph']; ?>" required /></div>'; else if(name=='is_court')document.getElementById('div11').innerHTML='  <div class="form-group"> <label>Court Name</label><input type="text" class="form-control" placeholder="Enter court name" name="court" value="<?php if(isset($_POST['court'])) echo $_POST['court']; ?>" required /></div>  <div class="form-group"> <label>Court Address</label><input type="text" class="form-control" placeholder="Enter court address" name="court_ad" value="<?php if(isset($_POST['court_ad'])) echo $_POST['court_ad']; ?>" required /></div>  <div class="form-group"> <label>Court Contact(Phone)</label><input type="text" class="form-control" placeholder="Enter court no.." name="court_ph" value="<?php if(isset($_POST['court_ph'])) echo $_POST['court_ph']; ?>" required /></div>'; else if(name=='is_lawyer')document.getElementById('div11').innerHTML='  '; else document.getElementById('div12').innerHTML=''; } </script>

<select class="form-control" placeholder="Select sign up type" name="usertype" id="usertype" onchange="showfield(this.options[this.selectedIndex].value)" required>   
   
<option value="">Please select court type...</option> 
  
<option value="is_court">Court</option>
 <option value="is_highcourt">High Court</option> 
</select> 
 

 <div id="div11">
</div>
<div id="div12">
</div>

    
</div>
</div>

<hr><strong> Court Operator Details </strong>

<hr>
 <div class="form-group">
       <label>Email address</label>
        <input type="text" class="form-control" placeholder="Email address" name="txtemail" value="<?php if(isset($_POST['txtemail'])) echo $_POST['txtemail']; ?>" required />
   </div>

      <div class="form-group">
     <label>Password</label>
        <input type="password" class="form-control" placeholder="Password" name="txtpass" required />
    
</div>
<div class="form-group">
     <label>Password</label>
        <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required />
    
</div>

    <div class="form-group">
 <label>First name</label>
<input type="text" class="form-control" placeholder="First name" name="first_name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>" required />
 
</div>
    <div class="form-group">
 <label>Last name</label>
<input type="text" class="form-control" placeholder="Last name" name="last_name" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>" required />
 
</div>
   
    <div class="form-group">
 <label>Address</label>
<input type="text" class="form-control" placeholder="Address" name="address" value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>" required />
 
</div>
  <div class="form-group">
 <label>Phone</label>
<input type="text" class="form-control" placeholder="Phone" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>" required />
 
</div>

	
                </div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <button type="submit" class="btn btn-primary" name="btn-signup"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
				</form>
                </div>
				
            </div>
        </div>
    </div>
