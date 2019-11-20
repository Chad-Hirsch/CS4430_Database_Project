<!-- CSS --!>
<link href="<?php echo $site_url; ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $site_url; ?>/styles/roboto.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $site_url; ?>/styles/open-sans.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $site_url; ?>/styles/libs.css" rel="stylesheet">
        <link href="<?php echo $site_url; ?>/styles/style.css" rel="stylesheet">
       

    <!-- Custom Fonts -->
    <link href="<?php echo $site_url; ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
    <body>
        
        <header style="background-color: <?php echo $site_color;?>;">
    <div class="container">
        <div class="row">
            <h1 class="col-sm-4 hidden-xs">
                <a href="<?php echo $site_url; ?>" id="HeaderLogoDesktop"><img alt="Image" src="<?php echo site_big_logo; ?>"></a>

            </h1>
            <div class="col-sm-8 hidden-xs">
                <div class="container-fluid">
                    <div class="row">
                        <a href="<?php echo $site_url; ?>/dashboard.php">
                            <div class="col-sm-4 hidden-xs icon-container" "="">
                                <img alt="Member area" src="<?php echo $site_url; ?>/styles/top-user.png">
                                <h2>Member area</h2>
                                <p class="hidden-sm">Login or Register</p>
                            </div>
                        </a>
                        <a href="<?php echo $site_url; ?>/court-list.php">
                            <div class="col-sm-4  hidden-xs icon-container" "="">
                                <img alt="Find Us" src="<?php echo $site_url; ?>/styles/contact-icon.png">
                                <h2>Court List</h2>
                                <p class="hidden-sm">All active courts</p>
                            </div>
                        </a>
                        
                        <div class="customer-type hidden-xs">
                            <ul class="nav nav-pills">
                                <!--<li class="active">
                                    <a href="<?php echo $site_url; ?>">Home</a>
                                </li>-->
                                <li class="social-tab-links">
                                 
                                </li>
                                <li class="search-top text-right">
                                                                   </li>
                                <li id="search_on_content" class="searchForm">
                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<nav class="navbar navbar-default" style="background-color: <?php echo $site_color;?>;">
    <div class="container relative">
        <a class="visible-xs mobile-logo-link" href="<?php echo $site_url; ?>">
            <img alt="Image" src="<?php echo $site_url; ?>/styles" class="pull-left mobile-logo">
            <img alt="Image" src="<?php echo site_small_logo; ?>" class="pull-left mobile-logo-xxs" height="25">
        </a>
            
        <div class="navbar-header visible-xs-block">
            
 <a href="<?php echo $site_url; ?>/">
<span class="label label-success label-circle" style="font-size:15px;"></span>
         </a>
            <a href="<?php echo $site_url; ?>/dashboard.php">
                <img src="<?php echo $site_url; ?>/styles/top-user.png">
            </a>
            <a href="./court-list.php">
                <img src="<?php echo $site_url; ?>/styles/contact-icon.png">
            </a>
            <button type="button" class="navbar-toggle collapsed pull-right" style="background-color: <?php echo $site_color;?>;" data-toggle="collapse" data-target="#main-nav-menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <div class="burger-bar">_____</div>
                <span class="collapsed">MENU</span>
                <span class="open">CLOSE</span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="main-nav-menu" style="background-color: <?php echo $site_color;?>;">

            <div class="mobile-options visible-xs">
                <div class="options-general">
                    <a class="option-home" href="<?php echo $site_url; ?>">
                         <i class="fa fa-arrow-circle-left"></i>Home Page
                    </a>
                    <div class="clear"></div>
                </div>
                <div class="option-back hidde">
                    <span class="menu-header">Back</span>
                    <i class="fa fa-minus-circle"></i>
                </div>
            </div>

            <div class="nav-pages hidden-xs"><ul id="menu-primary" class="menu"><li id="menu-item-162" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-162"><a href="<?php echo $site_url; ?>">Home</a>
<ul class="sub-menu">
	
</ul>
<div class="arrow"></div></li>
<li id="menu-item-561" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-561"><a href="#">Court list</a>
<ul class="sub-menu">
	
	<li id="menu-item-852" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-852"><a href="<?php echo $site_url; ?>/court-list.php">Registered Courts</a></li>

	
</ul>
<div class="arrow"></div></li>

<li id="menu-item-196" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-196"><a href="#">About Us</a>
<ul class="sub-menu">

	<li id="menu-item-1100" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1100"><a href="#">About</a></li>
	
</ul>
<div class="arrow"></div></li>
<li id="menu-item-553" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-553"><a href="#">Member area</a>
<ul class="sub-menu">
	
	<li id="menu-item-3680" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3680"><a href="<?php echo $site_url; ?>/login.php">Login</a></li>
	
<li id="menu-item-3680" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3680"><a href="<?php echo $site_url; ?>/register.php">Register</a></li>
</ul>
<div class="arrow"></div></li>
</ul></div>

<div class="nav-pages visible-xs">

<ul id="menu-mobile" class="menu">
<li id="menu-item-1297" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-1297"><a href="<?php echo $site_url; ?>/court-list.php">Courts list</a>
<ul class="sub-menu">
	
	
</ul>
<div class="arrow"></div></li>
<li id="menu-item-1292" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-1292"><a href="<?php echo $site_url; ?>/dashboard.php">Member Area</a>
<ul class="sub-menu">
	
	<li id="menu-item-1294" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1294"><a href="<?php echo $site_url; ?>/login.php">Login</a></li>
	
	<li id="menu-item-1294" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1294"><a href="<?php echo $site_url; ?>/register.php">Registration</a></li>
	
</ul>
<div class="arrow"></div></li>
<li id="menu-item-1288" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-1288"><a href="#">About Us</a>
<ul class="sub-menu">
	<li id="menu-item-1290" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1290"><a href="#">How it works</a></li>
	
</ul>
<div class="arrow"></div></li>
</ul></div>


            <div class="social-media visible-xs">
                
            </div>

            <a href="<?php echo $site_url; ?>/dashboard.php">
                <div id="btn-business" class="btn-business hidden-xs">
                    Member area                </div>
            </a>

        </div>
    </div>
</nav>
