<div class="page-content">


    <section class="striped" id="sList"> 
    <div class="container"> 
     <div class="row"> 
     
      <div class="mainArea-first col-xs-12 col-md-7 col-lg-8"> 
       <div class="breadcrumbs visible-lg visible-md"> 
        <ul> 
         <li><a href="/">Home</a></li> 
         <li class="item-current item-31">Courts List</li> 
        </ul> 
       </div> 
       <div class="panel panel-default"> 
        <div class="panel-heading">
          Approved Court List 
        </div> 
        <div class="row filters"> 
         <div class="col-xs-12"> 
          <h1>Find court</h1> 
         </div> 
     
        </div> 

  <?php
//Merge court
$addcourt="
UNION ALL
SELECT * FROM tbl_users WHERE court_status='Active' AND userType='is_court'
";

//Navigation
$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
 
$per_page = 20; // Set how many records do you want to display per page.

$statement = "tbl_users WHERE court_status='Active'"; 
$startpoint = ($page * $per_page) - $per_page;
 
//Query
				$stmtp = $pdo->prepare("SELECT * FROM tbl_users WHERE court_status='Active' AND userType='is_highcourt'$addsel$addcourt ORDER BY userID DESC LIMIT $startpoint,$per_page");
	$stmtp->execute();
if($stmtp->rowCount() > 0)
{
	while($row=$stmtp->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);

$court_id=trim($row['userID']); 

$court_name=trim($row['court_name']); 

$court_address=trim($row['court_address']); 

$court_phone=trim($row['court_phone']); 

$court_status=trim($row['court_status']); 
if($court_status=="") {
$court_status="Inactive";
}
		$usertype=trim($row['userType']);
    $court_manager=trim($row['userName']);
		?>

        <!--<a class="court-info-link" href="#">--> 
        <div class="row court-info" data-court-id="23"> 
         <input type="hidden" name="county" class="county" value="Meath"> 
         <input type="hidden" name="town" class="town" value="<?php echo $dname;?>"> 
         <a class="hidden-xs hidden-sm" href="#"> 
          <div class="col-xs-12"> 
           <h1><?php echo $court_name;?></h1> 
          </div> 
          <div class="address col-xs-12 col-sm-8 col-md-6 col-lg-8">
            <?php echo $addressx;?> 
          </div> 
        <!--  <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4"> 
           <div class="phone"> 
            <i class="clicable fa fa-phone"></i><?php echo $scourt_phone;?> 
           </div> 
          </div> 
--!>
          <div class="court-info-link"> 
           <i class="fa fa-angle-right"></i> 
          </div> 
          <div class="clear"></div> </a> 

         <div class="hidden-md hidden-lg"> 
          <div class="col-xs-12"> 
           <a href="#"> <h1><?php echo $court_name;?></h1> </a> 
          </div> 
          <div class="address col-xs-12 col-sm-8">
            <?php echo $court_address;?> 
          </div> 
         <!-- <div class="col-xs-12 col-sm-4"> 
           <div class="phone"> 
            <a style="color: inherit;" href="tel:<?php echo $xphone;?>"><i class="clicable fa fa-phone"></i><?php echo $phone;?></a> 
           </div> 
          </div> 
--!>
          <a class="court-info-link" href="#"> <i class="fa fa-angle-right"></i> </a> 
          <div class="clear"></div> 
         </div> 
        </div> 
        <!--</a>--> 
       
<?php
}
}
?>
<?php
echo pagination($statement,$per_page,$page,$url='?');
?>

<div class="row court-info no-courts"> 
         <div class="col-xs-12">
          Not Found
         </div> 
        </div> 
        <div class="row court-info special-court"> 
         <div class="col-xs-12">
          <h1></h1>
         </div> 
         <div class="address col-xs-12 col-sm-8"></div> 
         <div class="col-xs-12 col-sm-4">
          <div class="phone"></div>
         </div> 
         <div class="clear"></div> 
        </div> 
       </div> 
      </div> 
     </div> 
    </div> 
   </section> 
  </div> 