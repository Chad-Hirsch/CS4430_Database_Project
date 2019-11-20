<?php
  /* Site Installation */

if (defined('DB_install')) {
   header('Location: index.php');
   exit;
  }

function install_step_1(){ 
 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agree'])){
  header('Location: install.php?step=2');
  exit;
 }
 if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['agree'])){
  echo '<div class="alert alert-danger">You must agree to the license.</div>';
 }
?>
License Agreement 
<p>
Our licensing model is simple. 
</p>
<p>
Here are the basic truths: Once you purchase any of our products, you automatically agree with the terms below.

</p>
<p>
  <li> You are only allowed to use the software on the websites, you purchased a license for.
</li>
</p>
<p>
   <li> You may have multiple installations of the same product if you have them on the same domain. 
</li>
</p>
<p>
  <li> You are allowed to use the software on http://domain, http://sub domain names.
</li>
</p>
<p>
<li>
You cannot redistribute or resell the theme or source files.
</li>
</p>
<p>
<li>Until the relevant Fee has been paid the Software has not been licensed to you. In this case use of the Software shall be deemed unauthorised use and shall be at your own risk.
</li>
 </p>
 <form action="install.php?step=1" method="post">
 <p>
  I agree to the license
  <input type="checkbox" name="agree" />
 </p>
  <input type="submit" value="Continue" class="btn btn-primary"/>
 </form>
<?php 
}
function install_step_2(){
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] ==''){
   header('Location: install.php?step=3');
   exit;
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] != '')
   echo $_POST['pre_error'];
      
  if (phpversion() < '5.0') {
   $pre_error = ' <div class="alert alert-danger">You need to use PHP5 or above for Lawsuit - Case Management System to be installed!</div>';
  }
  if (ini_get('session.auto_start')) {
   $pre_error .= ' <div class="alert alert-danger">Package will not work with session.auto_start enabled!</div>';
  }
  if (!extension_loaded('mysql')) {
   $pre_error .= ' <div class="alert alert-danger">MySQL extension needs to be loaded for Lawsuit - Case Management System to be installed!</div>';
  }
  if (!extension_loaded('gd')) {
   $pre_error .= ' <div class="alert alert-danger">GD extension needs to be loaded for Lawsuit - Case Management System to be installed!</div>';
  }
  if (!is_writable('config.php')) {
   $pre_error .= ' <div class="alert alert-danger">config.php file needs to be writable for Lawsuit - Case Management System to be installed!</div>';
  }
  ?>
<center><strong> Step 2 of 4</strong> 
</center>
  <table width="100%">
  <tr>
   <td>PHP Version:</td>
   <td><?php echo phpversion(); ?></td>
   <td>5.0+</td>
   <td><?php echo (phpversion() >= '5.0') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>Session Auto Start:</td>
   <td><?php echo (ini_get('session_auto_start')) ? 'On' : 'Off'; ?></td>
   <td>Off</td>
   <td><?php echo (!ini_get('session_auto_start')) ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>MySQL:</td>
   <td><?php echo extension_loaded('mysql') ? 'On' : 'Off'; ?></td>
   <td>On</td>
   <td><?php echo extension_loaded('mysql') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>GD:</td>
   <td><?php echo extension_loaded('gd') ? 'On' : 'Off'; ?></td>
   <td>On</td>
   <td><?php echo extension_loaded('gd') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>config.php</td>
   <td><?php echo is_writable('config.php') ? 'Writable' : 'Unwritable'; ?></td>
   <td>Writable</td>
   <td><?php echo is_writable('config.php') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  </table>
  <form action="install.php?step=2" method="post">
   <input type="hidden" name="pre_error" id="pre_error" value="<?php echo $pre_error;?>" />
   <input type="submit" name="continue" value="Continue"  class="btn btn-primary"/>
  </form>
<?php
}
function install_step_3(){
   $database_host=isset($_POST['database_host'])?$_POST['database_host']:"";
   $database_name=isset($_POST['database_name'])?$_POST['database_name']:"";
   $database_username=isset($_POST['database_username'])?$_POST['database_username']:"";
   $database_password=isset($_POST['database_password'])?$_POST['database_password']:"";
   $admin_name=isset($_POST['admin_name'])?$_POST['admin_name']:"";
  $admin_lastname=isset($_POST['admin_lastname'])?$_POST['admin_lastname']:"";

$admin_email=isset($_POST['admin_email'])?$_POST['admin_email']:"";
 $admin_password=isset($_POST['admin_password'])?$_POST['admin_password']:"";

$site_name=isset($_POST['site_name'])?$_POST['site_name']:"Lawsuit - Case Management";

$site_path=isset($_POST['site_path'])?$_POST['site_path']:"http://". $_SERVER["HTTP_HOST"] ."". str_replace('/install.php', '', $_SERVER["PHP_SELF"]) . "";
  
if (isset($_POST['submit']) && $_POST['submit']=="Install!") {
  
  if (empty($admin_name) || empty($admin_email) || empty($admin_password) || empty($database_host) || empty($database_username) || empty($database_name)) {
   echo '<div class="alert alert-danger">All fields are required! Please re-enter.</div>';
  }

 else {
//CONNECTING DATABASE

   $connection = mysqli_connect($database_host, $database_username, $database_password);
 if(!$connection) {
echo '<div class="alert alert-danger">Error connecting to my SQL server...</div>';
$error_break="Error";
}
 
  //SELECTING DATABASE

  if(!mysqli_select_db($connection, $database_name))  {
echo '<div class="alert alert-danger">Error connecting to my SQL server... No database selected</div>';
$error_break="Error";
}
  
if(!isset($error_break)) {
   $file ='mysql.sql';
   if ($sql = file($file)) {
   $query = '';
   foreach($sql as $line) {
    $tsl = trim($line);
   if (($sql != '') && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != '#')) {
   $query .= $line;
  
   if (preg_match('/;\s*$/', $line)) {
  
    mysqli_query($connection, $query);
    $err = mysqli_error();
    if (!empty($err))
      break;
   $query = '';
   }
   }
   }
  mysqli_query($connection, "INSERT INTO tbl_users SET userEmail='".$admin_email."', userName='Admin', firstName='".$admin_name."', lastName='".$admin_lastname."', userPass = '".md5($admin_password)."', userType='is_admin', userState='Active', regTime='".time()."', userStatus='Y'");
   mysqli_close($connection);
   }
   $f=fopen("config.php","w");
   $database_inf="<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
error_reporting(E_ERROR);
ob_start ();
session_start();

//Enter your configuration details
     define('DB_install', 'YES');
     define('DB_host', '".$database_host."');
     define('DB_name', '".$database_name."');
     define('DB_user', '".$database_username."');
     define('DB_password', '".$database_password."');
     define('SITE_NAME', '".$site_name."');
     define('SITE_PATH', '".$site_path."');
     define('SITE_ABOUT', '	Hello, Welcome to my website');
     define('SITE_TERMS', 'We use cookies to improve your experience, if you continue to use our site we will assume that you are happy to receive cookies.');
     ?>";
  if (fwrite($f,$database_inf)>0){
   fclose($f);
  }
  header("Location: install.php?step=4");
  }
  }
}
?>
<center><strong> Step 3 of 4</strong> 
</center>
  <form method="post" action="install.php?step=3">
  <p>
<h2> Enter Database Details</h2>
<label for="database_host">Database Host</label>
   <input type="text" name="database_host" value='localhost' size="30" class="form-control">
   
 </p>
 <p>
<label for="database_name">Database Name</label>
   <input type="text" name="database_name" size="30" value="<?php echo $database_name; ?>" class="form-control">
   
 </p>
 <p>
  <label for="database_username">Database Username</label>
   <input type="text" name="database_username" size="30" value="<?php echo $database_username; ?>" class="form-control">
 
 </p>
 <p>
<label for="database_password">Database Password</label>
   <input type="text" name="database_password" size="30" value="<?php echo $database_password; ?>" class="form-control">
   
  </p>
  <br/>
 
  <p>
  
<h2>Enter Site Details</h2>
 <label for="username">Site Name</label>
   <input type="text" name="site_name" size="30" value="<?php echo $site_name; ?>" class="form-control">


 </p>
<p>
  
 <label for="username">Site Installation Path</label>
(Do not change this except you are sure)
   <input type="text" name="site_path" size="30" value="<?php echo $site_path; ?>" class="form-control">


 </p>

  <br/>
 <p>
<h2>Enter Admin Details</h2>

<label for="admin_name">Admin First Name</label>
   <input type="text" name="admin_name" size="30" value="<?php echo $admin_name; ?>" class="form-control">
 </p>
<p>
 <label for="admin_name">Admin Last Name</label>
   <input type="text" name="admin_lastname" size="30" value="<?php echo $admin_lastname; ?>" class="form-control">
 </p>
 <p>
 <label for="username">Admin Email Address</label>
   <input type="text" name="admin_email" size="30" value="<?php echo $admin_email; ?>" class="form-control">
 </p>
 <p>
<label for="password">Admin Password</label>
   <input name="admin_password" type="text" size="30" maxlength="15" value="<?php echo $admin_password; ?>" class="form-control">
   
  </p>
 <p>
   <input type="submit" name="submit" value="Install!" class="btn btn-primary">
  </p>
  </form>
<?php
}
function install_step_4(){
?>
<center><strong> Installation complete</strong> 
<?php
echo '<div class="alert alert-success">Congratulations, You just installed Lawsuit - Case Management System</div>';

?>
</center>
 <p><a href="http://<?php echo $_SERVER["HTTP_HOST"]; echo str_replace('/install.php', '', $_SERVER["PHP_SELF"]); ?>">Visit site home page</a></p>
 <p><a href="http://<?php echo $_SERVER["HTTP_HOST"]; echo str_replace('/install.php', '', $_SERVER["PHP_SELF"]); ?>/dashboard.php">Visit site Dashboard page</a></p>
<?php 
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Installation</title>
<meta name="viewport" content=" width=device-width, initial-scale =1.0 ">
  <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->


<style type="text/css">

#page-wrappers {
    width: 100%;
    padding: 0;
    background-color: #fff;
}


</style>
  <link href="css/endy.css" rel="stylesheet">

    <link href="<?php echo $site_url; ?>/css/endy2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<body>
  <!-- Navigation -->
        <nav class="navbar navbar-inverse" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              
                <a class="navbar-brand" href="#">Lawsuit - Case Management System</a>
        <br /> <br />
    </div>

</nav>
   


  <div id="page-wrappers">

            <div class="container-fluid">

                <!-- Page Heading -->
               
         
   <div class="col-lg-6">
 
                      <div class="alert alert-success">
                            
                     Hello,  Welcome to Lawsuit - Case Management System Installation page
</div>
                <!-- Page Heading -->
<div class="_col-md-5">
                <div class="row">
<div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Site Installation</h3>
                            </div>
                            <div class="panel-body">
  <div class="row">
   <div class=" col-md-9 col-lg-9 "> 
           

<?php
$step = (isset($_GET['step']) && $_GET['step'] != '') ? $_GET['step'] : '';
switch($step){
  case '1':
  install_step_1();
  break;
  case '2':
  install_step_2();
  break;
  case '3':
  install_step_3();
  break;
  case '4':
  install_step_4();
  break;
  default:
  install_step_1();
}
?>

</div>
</div>
   </div>
</div>



</div>


</div>
</div>


</div>



</body>