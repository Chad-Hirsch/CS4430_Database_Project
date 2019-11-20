<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 //PDO SQL CONNECTION
 
   $host = DB_host;
     $db_name = DB_name;
     $username = DB_user;
     $password = DB_password;
     $conn;
     
        try
		{
            $pdo = new PDO("mysql:host=" . $host  . ";dbname=" . $db_name, $username, $password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         


       ?> 