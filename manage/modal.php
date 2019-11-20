<?php 
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
if(preg_match('/is_admin/i', $is_usertype)) {
include "adduser_modal.php";

}
if(preg_match('/is_admin|is_lawyer/i', $is_usertype)) {
include "addcase_modal.php";
}

 ?>

