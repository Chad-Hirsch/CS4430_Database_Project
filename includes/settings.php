<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
 
//Enter your Site details


//SITE GENERAL SETTINGS

$site_url=SITE_PATH; //Don't comment this line


define('site_big_logo', "$site_url/styles/big-logo.jpg");
define('site_small_logo', "$site_url/styles/extra-small-logo.jpg");
define('site_contact_email', 'admin@yoursite.com');


//Site Global settings
global $db_handle;
global $session_id;
global $is_usertype;
global $site_url;
global $currency;
global $site_color;
global $admin_id;
$db_handle = new DBController();
$user = new USER();
$user_login = new USER();

//Site Style settings
$site_color='#6c4023';
$site_color_font='#f1b600';

//mail
$Emailsender = 'noreply@'.$_SERVER["SERVER_NAME"];

//administrator ID
$admin_id = "1";

//SiteName

function site_name()
{

$info=SITE_NAME;
 //Do not Comment this line
return $info;
}
 


?>