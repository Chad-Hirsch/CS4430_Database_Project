<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */

//Database Class
class Database
{
     
    private $host = DB_host;
    private $db_name = DB_name;
    private $username = DB_user;
    private $password = DB_password;
    public $conn;
     
    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
}

/* Class USER */

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	
	public function register($uname,$email,$upass,$code,$firstname,$lastname,$companyname,$address,$phone,$usertype,$userstate,$time)
	{
		try
		{							
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode,firstName,lastName,companyName,address,phone,userType,userState,regTime) 
			                                             VALUES(:user_name, :user_mail, :user_pass, :active_code, :first_name, :last_name, :company_name, :address_full, :phone_no, :user_type, :user_state, :reg_time)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

/* clearing cookies function*/
	public function clearcookies() {
if (isset($_COOKIE["islog_email"]) && isset($_COOKIE["islog_pass"]) && isset($_COOKIE["islog_id"])) 
{
//Destroy sessions
unset($_SESSION['userSession']);
   //Destroy Cookies
setcookie("islog_email", "", time()-86400 * 90);
setcookie("islog_pass", "", time()-86400 * 90);
setcookie("islog_id", "", time()-86400 * 90);
header("Location: logout.php");
exit;
return;
 }
}

/* Login function */
	public function login($email,$upass)
	{
		try
		{
          $user = new USER();
			$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
if($userRow['userState']=="Inactive")
				{
header("Location: ?inactive");
					exit;
				}	if($userRow['userPass']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
						return true;
					}
					else
					{
       $user->clearcookies();
						header("Location: ?error");
						exit;
					}
				}
				else
				{
					header("Location: ?inactive");
					exit;
				}	
			}
			else
			{
   $user->clearcookies();
				header("Location: ?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	/* Check if user is logged in */
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();
		$_SESSION['userSession'] = false;
	}
	
	
}


/*  DB connection*/

class DBController {
	private $host = DB_host;
	private $user = DB_user;
	private $password = DB_password;
	private $database = DB_name;
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
	return $conn;
	}
	
	function runQuerys($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRowss($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
	function fetchArray($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}

}
