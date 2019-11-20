<?php

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
     define('DB_host', 'localhost');
     define('DB_name', 'chadhirs_law');
     define('DB_user', 'chadhirs_law');
     define('DB_password', 'TJTIh7Rf2eM8');
     define('SITE_NAME', 'Lawyer Case Managment');
     define('SITE_PATH', 'http://cs4430.site');
     define('SITE_ABOUT', 'Welcome to our CS4430 Lawyer Case Managment Application.');
     define('SITE_TERMS', 'We created this site using Bootstrap, CSS, HTML, PHP, and mySQL. Most of the design is from a website template. ');
     ?>