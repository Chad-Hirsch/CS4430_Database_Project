<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
?>

<header>Notifications</header>
 <?php

//For Displaying notice on Dashboard
	$notices = $pdo->prepare("SELECT * FROM notice WHERE comment_to='$user' ORDER BY comment_date DESC LIMIT 0,8");
	$notices->execute();
if($notices->rowCount() > 0)
{
	while($row=$notices->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);
$dates=$row['comment_date'];
		?>
                      
   

                                    
                                    <a href="<?php echo''.$site_url.'/view_notice.php?id='.$row['comment_id'].''; ?>" class="list-group-item">
                                        <span class="badge"><?php echo"".date('d | M | Y',$dates)." ".date('H:i',$dates).""; ?></span>
                                        <i class="fa fa-fw fa-money"></i> <?php echo $row['comment_subject']; ?>
                                    </a>
                    <?php }
}
else {

echo'<a href="#" class="list-group-item">
                                        <span class="badge"></span>
                                        <i class="fa fa-fw fa-money"></i> No activity yet
                                    </a>
';


}
?>
          <?php
          
//Break if notice is more than 7
      if($notices->rowCount() > 7)
 { 
?>                 
<div class="text-right">
                                    <a href="view_task.php">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                                </div>

<?php } ?>

