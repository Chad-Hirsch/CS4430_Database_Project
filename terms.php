<?php

 /* 
 * @Author: Chad Hirsch
 * @package Lawyer Case Management System
 * (c) November 2019
 */
 
require_once 'conn.php';



       echo" <title>Terms and conditions</title>
";

include"includes/nav.php";


?>

 <div class="page-content">


   <section class="striped"> 
    <div class="container"> 
     <div class="row"> 
     
      <div class="mainArea-first col-xs-12 col-md-7 col-lg-8"> 

 
    

  
<div>
<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Terms and Conditions</h3>
                            </div>
                            <div class="panel-body">
                               
 <?php echo SITE_TERMS; ?>
        
  </div>
                        
            



</div> 

 </div> 
  </div> 
   </section> 
       
 </div> 

     
<?php

include"includes/footer.php";
?>
