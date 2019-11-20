<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */

require_once 'conn.php';


$user = new USER();

//LOGOUT USER

if(!$user->is_logged_in())
{
	$user->redirect('index.php');
}

if($user->is_logged_in()!="")
{
   
   //Destroy Cookies
   setcookie("islog_email", "", time()-200000000);
setcookie("islog_pass", "", time()-200000000);
setcookie("islog_id", "", time()-200000000);

	$user->logout();	
	$user->redirect('login.php');
}
?>