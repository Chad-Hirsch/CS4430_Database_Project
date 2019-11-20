 <div class="page-content">

<section class="page-home cover-image">
    <div style="background-image: url(<?php echo $site_url; ?>/styles/Homepeg-image-mobile-1.jpg);" class="cover-image-container"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-6  col-md-5 col-lg-4 order-section" id="green-mobile-panel" style="background-color: <?php echo $site_color;?>;">
                    <div id="order_panel" class="order-module roboto chosen-county">
        <h3>Quick Suit</h3>
        <form id="case_step01" action="<?php echo add_case_link();?>?action=add&from=_homepage" method="POST">
<!----->

<?php

if($user_login->is_logged_in()=="")
{
 ?>
<div class="form-group">
 <label class="font-16 bold">First name</label>
<input type="text" class="form-control" placeholder="First name" name="first_name" required />
 
</div>
    <div class="form-group">
 <label class="font-16 bold">Last name</label>
<input type="text" class="form-control" placeholder="Last name" name="last_name" required />
 
</div>


<?php
}
?>
<div class="form-group">
    
							<label class="font-16 bold">Case Title:</label>
						
						
							<input type="text" name="case_name" class="form-control" required>
						
					</div>

					
<div class="form-group">
						<label class="font-16 bold">Case Content:</label>
	
<?php					
			if($user_login->is_logged_in()=="")
{
 ?>			
							<textarea class="form-control" rows="3" name="case_text" disabled>You must login to fill this form</textarea>
<?php	} else { ?>
<textarea class="form-control" rows="3" name="case_text"></textarea>
<?php	} ?>
						</div>
					
		<div class="form-group">
							<label class="font-16 bold">Case Document:</label>
						
				<?php					
			if($user_login->is_logged_in()=="")
{
 ?>		
							<input type="file" class="form-control" name="case_attachment" disabled>
						
<?php	} else { ?>					
		

<input type="file" class="form-control" name="case_attachment">
						

<?php	} ?>
</div>
						 <div class="form-group">
 <label class="font-16 bold">Post to (Select Court):</label>
<select class="form-control" name="id" required>
<?php
	$stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE userType='is_highcourt' AND userState='Active' ORDER BY userID DESC");
	$stmt->execute();
if($stmt->rowCount() > 0)
{
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);
		?>
                      
   
<option value="<?php echo $row['userID']; ?>"><?php echo $row['court_name']; ?> </option>
 
<?php }
?>
<?php }
?>

</select> 
 
</div>

    
	
<div class="form-group">
<?php					
			if($user_login->is_logged_in()=="")
{
 ?>	
 <label class="font-16 bold">Phone</label>
<input type="text" class="form-control" placeholder="Phone" name="phone" required />
        <?php } ?>       
            <button class="btn btn-orange btn-validate" type="submit" name="btn-addcase">Submit<i class="fa fa-arrow-circle-right"></i></button>

      
            </div>
 <!-endy-->
        </form>
    </div>
	                <div class="order-steps">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="roboto round-bullet">
                                    <span>1</span>
                                </div>
                            </div>
                            <div class="col-xs-10">
                                <p class="bullet-title">Filing lawsuit Online made easy</p>
                            </div>
 
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="roboto round-bullet">
                                    <span>2</span>
                                </div>
                            </div>
                            <div class="col-xs-10">
                                <p class="bullet-title">Fast case tracking</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="roboto round-bullet">
                                    <span>3</span>
                                </div>
                            </div>
                            <div class="col-xs-10">
                                <p class="bullet-title">Receive Updates on case status</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="call-to-action col-sm-6 col-md-6 col-lg-7 title-text">
                <div style="background-image: url(<?php echo $site_url; ?>/styles/Homepeg-image-mobile-1.jpg);" class="cover-image-container"></div>
                 <img class="cover-image-line" src="./styles/cover-image-line.png">                 <h3 class="cover-image-title roboto">
                  <?php echo"".site_name()."";?><br>
                                    </h3>
                <p class="cover-image-subtitle">File your case online, it's quick and it's easy!<br></p>
                <!--<a href="#/how sit-up">
                    <button class="btn btn-transparent">See how it works</button>
                </a>-->
            </div>
        </div>
    </div>
</section>

    <section class="striped process-desc">
        <div class="container">
            <div class="row">
                <div class="col-md-4 step">
                    <div class="image" style="background-image: url(&#39;/styles/howItWorks_1.png&#39;); background-size: contain; background-repeat: no-repeat;"><div>1</div></div>
                    <div class="text">
                        <span class="title">File Case Online</span>
                        <br>
                        Organise your suit online in less than 10 minutes. It's simple and secure
                    </div>
                </div>

                <div class="col-md-4 step">
                    <div class="image" style="background-image: url(&#39;/styles/howItWorks_2.png&#39;); background-size: contain; background-repeat: no-repeat;"><div>2</div></div>
                    <div class="text">
                        <span class="title">Processing</span>
                        <br>
                         Your case is received and process within 24hours
                    </div>
                </div>

                <div class="col-md-4 step">
                    <div class="image" style="background-image: url(&#39;/images/howItWorks_3.png&#39;);  background-size: contain; background-repeat: no-repeat;"><div>3</div></div>
                    <div class="text">
                        <span class="title">Receive Updates</span>
                        <br>
                        Receive updates on case status online
                    </div>
                </div>
            </div>
        </div>
    </section>




<section class="striped social-media-opinions-list">
    <div class="container">
        <h1>What people are saying about our Lawyers</h1>
      
        <div class="row">
                            <div class="col-md-4 col-xs-12">
                    <div class="container-fluid">
                        <div class="row social-media-opinion">
                            <div class="social-media-icon col-sm-2 hidden-xs">
                                <img src="./styles/top-user.png">                            </div>
                            <div class="text col-sm-9 col-sm-offset-1 col-xs-12">
                                <div class="social-arrow-div"></div>
                                <div class="comment">
                                    <span class="author">

                                       Bob from Kalamazoo, MI                                  </span>
                                    Your website is very easy to use.                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                            <div class="col-md-4 col-xs-12">
                    <div class="container-fluid">
                        <div class="row social-media-opinion">
                            <div class="social-media-icon col-sm-2 hidden-xs">
                                <img src="./styles/top-user.png">                            </div>
                            <div class="text col-sm-9 col-sm-offset-1 col-xs-12">
                                <div class="social-arrow-div"></div>
                                <div class="comment">
                                    <span class="author">
                                        Barr. John from Muskegon, MI                                   </span>
                                    Very user Friendly.                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                            <div class="col-md-4 col-xs-12">
                    <div class="container-fluid">
                        <div class="row social-media-opinion">
                            <div class="social-media-icon col-sm-2 hidden-xs">
                                <img src="./styles/top-user.png">                            </div>
                            <div class="text col-sm-9 col-sm-offset-1 col-xs-12">
                                <div class="social-arrow-div"></div>
                                <div class="comment">
                                    <span class="author">
                                        Jack from Ludington, MI                               </span>
                                 Easy to use the site.                   </div>
                            </div>
                        </div>
                    </div>
                </div>

                    </div>
    </div>
</section>



   

        
        </div>