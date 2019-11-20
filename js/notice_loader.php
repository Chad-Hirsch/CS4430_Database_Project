<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */


require_once '../config.php';

require_once '../includes/class.user.php';
require_once '../includes/sql_conn.php';
require_once '../includes/settings.php';
require_once '../includes/functions.php';

$user_notice = new USER();


//Json Notice loader
if(isset($_REQUEST['view'])) {
if($_REQUEST['view'] !='') {
$nt=$user_notice->runQuery("UPDATE notice SET comment_status='1' WHERE comment_to='$session_id'");

	$nt->execute();
}

$stmtn = $user_notice->runQuery("SELECT * FROM notice WHERE comment_to='$session_id' AND comment_status='0'");
$stmtn->execute();
$count=$stmtn->rowCount();

$stmtnn = $user_notice->runQuery("SELECT * FROM notice WHERE comment_to='$session_id' ORDER BY comment_date DESC LIMIT 0,10");

	$stmtnn->execute();
if($stmtnn->rowCount() > 0)
{

	while($rown=$stmtnn->fetch(PDO::FETCH_ASSOC))
	{
		extract($rown);
$dates=$rown['comment_subject'];

$cid=$rown['comment_id'];
$cij=trim($rown['comment_subject']);
$cif=get_user($rown['comment_from'], userName);

$output .= '<li><a href="'.$site_url.'/view_notice.php?id='.$cid.'"> '.$cij.'
 <span class="label label-danger">!</span></a>
</li>';
                 }
 $output .= '<li class="divider"></li>
                        <li>
                            <a href="'.$site_url.'/view_task.php">More</a>
                        </li>';
}
else {
$output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';

} 

$data = array('notification'=>"$output", 'unseen_notification'=>"$count");

echo json_encode($data);

}
?>