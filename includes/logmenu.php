<?php
 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 



//LOGIN VALIDATION

if($user_login->is_logged_in()=="")
{

	$user_login->redirect('login.php');
}
   if($session_id==""){
header("location: $site_url/login.php");
exit;
}

//SESSION USER
$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <!-- Bootstrap Core CSS -->
    <link href="<?php
 echo $site_url; ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
  <link href="<?php echo $site_url; ?>/css/endy-dashboard.css" rel="stylesheet">

    <link href="<?php echo $site_url; ?>/css/endy2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo $site_url; ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">





        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color: <?php echo $site_color;?>;">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $site_url; ?>/dashboard.php"><div id='white-it'><?php echo"".site_name()." ";?></div></a>
            </div>
           
             <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
              
                <li class="dropdown">

<!-- Notice on top menu--!>
<?php
$stmtn = $pdo->prepare("SELECT * FROM notice WHERE comment_to='$session_id' AND comment_status='0'");
$stmtn->execute();
$notecount=$stmtn->rowCount();

$stmtnn = $pdo->prepare("SELECT * FROM notice WHERE comment_to='$session_id' ORDER BY comment_date DESC LIMIT 0,8");

	$stmtnn->execute();
?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"><?php echo $notecountx;?></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
                    <ul class="dropdown-menu alert-dropdown">

                   <?php

	
if($stmtnn->rowCount() > 0)
{

	while($rown=$stmtnn->fetch(PDO::FETCH_ASSOC))
	{
		extract($rown);
$dates=$rown['comment_date'];
$cif=get_user($rown['comment_from'], userName);

		?>
                      
   

                                    
                                    
        
                        <li>
                            <a href="<?php echo $site_url; ?>/view_notice.php?id=<?php echo $rown['comment_id']; ?>"><?php echo trim($rown['comment_subject']); ?>
 <span class="label label-primary"><?php echo $cif; ?></span></a>
                        </li>
             <?php        }
  
} ?>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo $site_url; ?>/view_task.php">More</a>
                        </li>
                    </ul>
                </li>

           <li class="dropdownx">
                    <a href="<?php echo $site_url; ?>/manage/manage_case.php?case=add"><span class="glyphicon glyphicon-plus" style="font-size:18px;"></span>Add New Case</a>
                    
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse" style="background-color: <?php echo $site_color;?>;">

                <ul class="nav navbar-nav side-nav" style="background-color: #212121;">


                    <li class="active">
                        <a href="<?php echo $site_url; ?>/dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
    <li>
                        <a href="<?php echo $site_url; ?>/view_task.php"><i class="fa fa-fw fa-bell"></i><span> Notifications</span><span class="label label-danger pull-right"> <?php echo $taskcount; ?> </span>
</a>

                    </li>

           
     <li>
                        <a href="<?php echo $site_url; ?>/manage/manage_case.php"><i class="fa fa-fw fa-circle"></i><span> All Cases</span><span class="label label-primary pull-right"><?php echo $casecount; ?></span>
</a>
                    </li>
  <li>
                        <a href="<?php echo $site_url; ?>/manage/manage_case.php?case=open"><i class="fa fa-fw fa-list"></i><span> Open Cases</span><span class="label label-success pull-right"><?php echo $opencasecount; ?></span>
</a>
                    </li>

 
 
  <li>
                          <a href="<?php echo $site_url; ?>/manage/manage_case.php?case=closed"><i class="fa fa-fw fa-list"></i><span> Closed Cases</span><span class="label label-success pull-right"><?php echo $closecasecount; ?></span>
</a>
                    </li>
 
                

  <li>
                         <a href="<?php echo $site_url; ?>/manage/manage_case.php?case=draft"><i class="fa fa-fw fa-list"></i><span> Draft Cases</span><span class="label label-success pull-right"><?php echo $draftcasecount; ?></span>
</a>
                    </li>

 <li>
                         <a href="<?php echo $site_url; ?>/manage/documents.php"><i class="fa fa-fw fa-list"></i><span> Case Documents</span>
</a>
                    </li>
 
   <?php     if(!preg_match('/court/i', $is_usertype)) {
  
?>             
     <li>
                        <a href="<?php echo $site_url; ?>/manage/manage_case.php?case=add"><span class="label label-success"> <i class="fa fa-fw fa-plus"></i> Post new case</span>
</a>
                    </li>
  <?php     }
  
?>

  <?php     if(preg_match('/is_admin/i', $is_usertype)) {
  
?>
     <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#client"><i class="fa fa-fw fa-user"></i> Clients <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="client" class="collapse">
                            <li>
                                <a href="<?php echo $site_url; ?>/manage/accounts.php">All Clients</a>
                            </li>
<li>
<a href="<?php echo $site_url; ?>/manage/accounts.php?user_type=lawyer">Lawyers</a>
                            </li>
<li>
<a href="<?php echo $site_url; ?>/manage/accounts.php?user_type=courts">Court Manager's Account</a>
                            </li>
<li>
<a href="<?php echo $site_url; ?>/manage/accounts.php?user_type=highcourt">High Court Manager's Account</a>
                            </li>
                            <li>
                           <a href="#addnewaccount" data-toggle="modal">Add Client</a>
                            </li>
                          

                        </ul>
                    </li>
  <?php    }
?>
        
 

<li class="active">

<a>
<i class="fa fa-fw fa-circle"></i><span> Courts</span>
</a>

</li>
<?php
if(preg_match('/court/i', $is_usertype)) {
  

	
		if(!empty($rows['court_name']))
		{
			?>
<li>
<a href="<?php echo $site_url; ?>/manage/update_court.php"><i class="fa fa-fw fa-list"></i><span> My Court (<?php echo trim($rows['court_name']); ?>)</span></a>
</li>

<?php } 
}
?>
<li>

<?php
if(preg_match('/is_admin/i', $is_usertype)) {
$courtlink ='/manage/manage_courts.php';
}
 else
{
$courtlink ='/court-list.php';
} ?>

<a href="<?php echo $site_url; echo $courtlink; ?>"><i class="fa fa-fw fa-list"></i><span> Court list</span></a>

</li>

   <li class="active">
                        <a href="<?php echo $site_url; ?>/profile.php"><i class="fa fa-fw fa-user"></i> My profile</a>
                    </li>
<li>
                            <a href="<?php echo $site_url; ?>/profile.php?profile=edit"><i class="fa fa-fw fa-gear"></i> Edit Profile</a>
                        </li>
                        
<?php
if(preg_match('/is_admin/i', $is_usertype)) { ?>
<li>
                            <a href="<?php echo $site_url; ?>/manage/site_settings.php"><i class="fa fa-fw fa-gear"></i>Site Settings</a>
                        </li>
                        
  <?php } ?>
                        
                        <li>
                            <a href="<?php echo $site_url; ?>/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>

</ul>
 </div>
            <!-- /.navbar-collapse -->
        </nav>
