<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */

$stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$rowid = $stmt->fetch(PDO::FETCH_ASSOC);
$session_id=$rowid['userID'];

//AUTOLOGIN


if(empty($_SESSION['userID'])){

if (isset($_COOKIE["islog_email"]) && isset($_COOKIE["islog_pass"]) && isset($_COOKIE["islog_id"])) 
{
$email=$_COOKIE["islog_email"];
$cpass=$_COOKIE["islog_pass"];

$cuser=$_COOKIE["islog_id"];



if ($user->login($email,$cpass))

{
$_SESSION['userID']=$cuser;

    }  
 } 
}


function get_user($uid, $field) {
$user = new USER();
	$stmt = $user->runQuery("SELECT $field FROM tbl_users WHERE userID=:user_id");
	$stmt->execute(array(":user_id"=>$uid));
	$info = $stmt->fetch(PDO::FETCH_ASSOC);

$info=$info[$field];
return $info;
}

function get_email($uid, $field) {
$user = new USER();
	$stmt = $user->runQuery("SELECT $field FROM tbl_users WHERE userEmail=:user_id");
	$stmt->execute(array(":user_id"=>$uid));
	$info = $stmt->fetch(PDO::FETCH_ASSOC);

$info=$info[$field];
return $info;
}


function get_usertype($usertype) {

if($usertype=="is_court") { 
$t = "Court's Manager account"; } if($usertype=="is_highcourt") { 
$t = "Court's Manager account"; } if($usertype=="is_lawyer") { $t =  "Lawyer"; }

 if($usertype=="is_admin"){ $t= "Administrator"; }

return $t;
}



function pagination($pagen,$per_page=10,$page=1,$url='?'){   
    $user = new USER();

    $pagen=$user->runQuery("SELECT COUNT(*) as `num` FROM {$pagen}");
   $pagen->execute();
    $rowp =  $pagen->fetch(PDO::FETCH_ASSOC);
    $total = $rowp['num'];
    $adjacents = "2"; 
      
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";
      
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
      
    $prev = $page - 1;                          
    $next = $page + 1;
      
    $lastpage = ceil($total/$per_page);
      
    $lpm1 = $lastpage - 1; // //last page minus 1
      
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<ul class='pagination'>";
        //$pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";
              
            if ($page > 1) $pagination.= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";
              
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
            }
          
        } elseif($lastpage > 3 + ($adjacents * 2)){
              
            if($page < 1 + ($adjacents * 2)) {
                  
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";  
                      
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";      
                  
            } else {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
            }
        }
          
             if ($page < $counter - 1) {
                $pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }
          
        $pagination.= "</ul>";        
    }
      
    return $pagination;
}
$is_usertype=get_user($session_id, userType);
     
     
        
        function add_case_link() {
$user_login = new USER();
if($user_login->is_logged_in()=="")
{
$qlink="register.php";
}
if($user_login->is_logged_in()=="")
{
$qlink="manage/addnew_case.php";
}

return $qlink;
}


//Stat count

$user_stat = new USER();

$stmt = $user_stat->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);
$user=$rows['userID'];
	$stats_count = $pdo->prepare("SELECT * FROM notice WHERE comment_to='$user' AND comment_status='0'");
	$stats_count->execute();
$taskcount=$stats_count->rowCount();

	//Court count
	$stats_count = $pdo->prepare("SELECT * FROM tbl_users WHERE court_status='Active'");
	$stats_count->execute();
$courtcount=$stats_count->rowCount();


//SHOW ADMIN USER
if(preg_match('/is_admin/i', $is_usertype)) {

//Case count
	$stats_count = $pdo->prepare("SELECT * FROM cases WHERE caseID>'0'");
$stats_count->execute();
$casecount=$stats_count->rowCount();

$opencasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Open'");
$stats_count->execute();
	$opencasec->execute();
$opencasecount=$opencasec->rowCount();

$closecasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Closed'");
	$closecasec->execute();
$closecasecount=$closecasec->rowCount();

$draftcasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Draft'");
	$draftcasec->execute();
$draftcasecount=$draftcasec->rowCount();

}
//SHOW HIGHCOURT USER

if(preg_match('/is_highcourt/i', $is_usertype)) {

	$stats_count = $pdo->prepare("SELECT * FROM cases WHERE case_to='$user'");
$stats_count->execute();
$casecount=$stats_count->rowCount();

$opencasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Open' AND case_to='$user'");
$stats_count->execute();
	$opencasec->execute();
$opencasecount=$opencasec->rowCount();

$closecasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Closed' AND case_to='$user'");
	$closecasec->execute();
$closecasecount=$closecasec->rowCount();

$draftcasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Draft' AND case_to='$user'");
	$draftcasec->execute();
$draftcasecount=$draftcasec->rowCount();

}


//SHOW COURT USER
if(preg_match('/is_court/i', $is_usertype)) {

	$stats_count = $pdo->prepare("SELECT * FROM cases WHERE case_posted='$user'");
$stats_count->execute();
$casecount=$stats_count->rowCount();

$opencasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Open' AND case_posted='$user'");
$stats_count->execute();
	$opencasec->execute();
$opencasecount=$opencasec->rowCount();

$closecasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Closed' AND case_posted='$user'");
	$closecasec->execute();
$closecasecount=$closecasec->rowCount();

$draftcasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Draft' AND case_posted='$user'");
	$draftcasec->execute();
$draftcasecount=$draftcasec->rowCount();

}

//SHOW LAWYER USER

if(preg_match('/is_lawyer/i', $is_usertype)) {


$stats_count = $pdo->prepare("SELECT * FROM cases WHERE case_from='$user'");
$stats_count->execute();
$casecount=$stats_count->rowCount();

$opencasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Open' AND case_from='$user'");
	$opencasec->execute();
$opencasecount=$opencasec->rowCount();

$closecasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Closed' AND case_from='$user'");
	$closecasec->execute();
$closecasecount=$closecasec->rowCount();

$draftcasec = $pdo->prepare("SELECT * FROM cases WHERE case_status='Draft' AND case_from='$user'");
	$draftcasec->execute();
$draftcasecount=$draftcasec->rowCount();

}

//End stat count
	
	


?>