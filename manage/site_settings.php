<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */

require_once '../conn.php';

$user_login = new USER();


if(isset($_POST['btn-settings']))
{
//Settings file

$settings_file="../config.php";
 $file_contents = file_get_contents("$settings_file");

$settings_file2="../includes/settings.php";
 $file_contents2 = file_get_contents("$settings_file2");



//Site Name Edit
if($_POST['sitename']!="") {
	$sitename = trim($_POST['sitename']);

    $file_contents = str_replace("". SITE_NAME ."", "". $sitename ."", $file_contents);
    file_put_contents($settings_file,$file_contents);
    

$save=true;
}

//Site URL edit
if($_POST['siteurl']!="") {
	$siteurl = trim($_POST['siteurl']);

    $file_contents = str_replace("define('SITE_PATH', '". SITE_PATH ."');", "define('SITE_PATH', '".$siteurl ."');",$file_contents);
    file_put_contents("$settings_file",$file_contents);
    
$save=true;
}

//Site About edit
if($_POST['siteabout']!="") {
	$siteabout = str_replace("'", '"', $_POST['siteabout']);

    $file_contents = str_replace("define('SITE_ABOUT', '". SITE_ABOUT ."');", "define('SITE_ABOUT', '".$siteabout ."');",$file_contents);
    file_put_contents("$settings_file",$file_contents);
    
$save=true;
}

//Site Terms edit
if($_POST['siteterms']!="") {
	$siteterms = str_replace("'", '"', $_POST['siteterms']);

    $file_contents = str_replace("define('SITE_TERMS', '". SITE_TERMS ."');", "define('SITE_TERMS', '".$siteterms ."');",$file_contents);
    file_put_contents("$settings_file",$file_contents);
    
$save=true;
}

//Site Contact Email edit
if($_POST['site_contact_email']!="") {
	$site_contact_email = trim($_POST['site_contact_email']);

    $file_contents2 = str_replace("define('site_contact_email', '". site_contact_email ."');", "define('site_contact_email', '".$site_contact_email ."');",$file_contents2);
    file_put_contents("$settings_file2",$file_contents2);
    
$save=true;
}
    
//Site Color edit
if($_POST['site_color']!="") {
	$site_color_new = trim($_POST['site_color']);

    $file_contents2 = str_replace("site_color='$site_color'", "site_color='$site_color_new'",$file_contents2);
    file_put_contents("$settings_file2",$file_contents2);
    
$save=true;
}
    
//Site Font Color edit
if($_POST['site_color_font']!="") {
	$site_color_font_new = trim($_POST['site_color_font']);


    $file_contents2 = str_replace("site_color_font='$site_color_font'", "site_color_font='$site_color_font_new'",$file_contents2);
   file_put_contents("$settings_file2",$file_contents2);
    
$save=true;
}
                    
header("refresh:1;site_settings.php");
}

echo"  <title> Site Settings- ".site_name()."</title>
";

include "../includes/logmenu.php";


?>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
          
                <!-- /.row -->

<div class="row">
                    <div class="col-lg-4">

  <?php 
		if($save)
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
                                <h3 class="panel-title">Site Settings</h3>
                            </div>
                            <div class="panel-body">
                               

        
  
                <div class="modal-body">
				<div class="container-fluid">
				<form method="POST" action="">
					<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;"> Site name:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" value="<?php echo SITE_NAME;?>" name="sitename" required>
						</div>
					</div>
				
<div style="height:10px;"></div>
					<div class="row">
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Site URL:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="siteurl" value="<?php echo SITE_PATH;?>" class="form-control" required>
						
	               </div> 
				</div>
				<div class="row">
						<div class="col-lg-2">
							<label class="control-label" style="position:relative; top:7px;"> Site Contact Email:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" class="form-control" value="<?php echo site_contact_email;?>" name="site_contact_email" required>
						</div>
					</div>
					
					
				
<div style="height:20px;"></div>
<a href="javascript:;" data-toggle="collapse" data-target="#post-page1" class='btn-lg btn-info'>Edit Page Settings
</a>
    <div id="post-page1" class="collapse">
                            


						 <div class="form-group">
 <label style="position:relative; top:7px;">About Page:</label>
<div class="col-lg-10">
							<textarea name="siteabout" class="form-control">
<?php echo SITE_ABOUT;?></textarea>
						
	               </div>
 </div> 
 
  <div class="form-group">
 <label style="position:relative; top:7px;">Terms & Condition Page:</label>
<div class="col-lg-10">
							<textarea name="siteterms"class="form-control">
<?php echo SITE_TERMS;?></textarea>
						
	               </div>
 </div> 
 
</div>

<div style="height:20px;"></div>
<a href="javascript:;" data-toggle="collapse" data-target="#post-page2" class='btn-lg btn-info'>Header/Logo Settings
</a>
    <div id="post-page2" class="collapse">
                            


						 <div class="form-group">
 <label style="position:relative; top:7px;">Site Small logo(Mobile):</label>
<div class="col-lg-10">
							<input type="text" name="site_small_logo" class="form-control" value="<?php echo site_small_logo;?>">
						
	               </div>
 </div> 
 
  <div class="form-group">
 <label style="position:relative; top:7px;">Site big logo(Desktop):</label>
<div class="col-lg-10">

			<input type="text" name="site_big_logo" class="form-control" value="<?php echo site_big_logo;?>">
	               </div>
 </div> 
 
</div>

<div style="height:20px;"></div>
<a href="javascript:;" data-toggle="collapse" data-target="#post-page3" class='btn-lg btn-info'>Styles Settings
</a>
    <div id="post-page3" class="collapse">
                            
<div class="form-group">
 <label style="position:relative; top:7px;">Site Primary Color:</label>
<div class="col-lg-10">
							<input type="text" name="site_color" class="form-control" value="<?php echo $site_color;?>">
	<div style="height:20px; background-color: <?php echo $site_color;?>;"></div>
						
	               </div>
 </div> 
 
  <div class="form-group">
 <label style="position:relative; top:7px;">Site Font color:</label>
<div class="col-lg-10">

			<input type="text" name="site_color_font" class="form-control" value="<?php echo $site_color_font;?>">
  <div style="height:20px; background-color: <?php echo $site_color_font;?>;"></div>
	               </div>
 </div> 
 
</div>



                </div> 
				</div>
                <div class="modal-footer">
                    
                    <button type="submit" class="btn btn-primary" name="btn-settings"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
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

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>
