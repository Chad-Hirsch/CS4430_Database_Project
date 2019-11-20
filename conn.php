<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 session_start();
 require_once 'config.php';

//CHECK INSTALLATION

if (!defined('DB_install')) {
   header('Location: install.php');
   exit;
  }

//INCLUDES CORE FILES
require_once 'includes/class.user.php';
require_once 'includes/sql_conn.php';
require_once 'includes/settings.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';


?> 