<link href="<?php echo get_template_directory_uri()?>/css/admin/theme_options.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_template_directory_uri()?>/css/admin/jquery.miniColors.css" rel="stylesheet" type="text/css" />
<link href="<?php echo get_template_directory_uri()?>/css/admin/datePicker.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/tabs.js"></script>

<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/select.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/jquery.miniColors.js"></script>

<!--[if IE]><script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/jquery.bgiframe.js"></script><![endif]-->
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/functions.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/cs_functions.js"></script>

<script src="<?php echo get_template_directory_uri()?>/scripts/validation/jquery.metadata.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri()?>/scripts/validation/jquery.validate.js" type="text/javascript"></script>

<!-- Left Column Start -->
<div class="col1 left">
	<div class="logo">
    	<a href="#"><img src="<?php echo get_template_directory_uri()?>/images/admin/logo-admin.png" /></a>
    </div>
    <div class="navigation">
    	<ul>
            <li>
            	<a href="admin.php?page=functions.php" class="<?php if($_GET['page']=="functions.php"){echo "active";} ?>">
                	<span class="icon-g-setting">&nbsp;</span>
                    <span class="link">General Settings</span>
                </a>
            </li>
            <li>
            	<a href="admin.php?page=home_page_settings" class="<?php if( $_GET['page']=="home_page_settings"){echo "active";} ?>">
                	<span class="icon-home">&nbsp;</span>
                    <span class="link">Home Page Settings</span>
                </a>
            </li>
            <li>
            	<a href="admin.php?page=cufon" class="<?php if($_GET['page']=="cufon"){echo "active";} ?>">
                    <span class="icon-fonts">&nbsp;</span>
                    <span class="link">Fonts</span>
                </a>
            </li>
            <li>
            	<a href="admin.php?page=manage_sidebars" class="<?php if($_GET['page']=="manage_sidebars"){echo "active";} ?>">
                	<span class="icon-sidebars">&nbsp;</span>
                    <span class="link">Side Bars</span>
                </a>
                </li>
                <li>
                	<a href="admin.php?page=slider_setting" class="<?php if($_GET['page']=="slider_setting"){echo "active";} ?>">
                    	<span class="icon-slider-manage">&nbsp;</span>
                        <span class="link">Slider Setting</span>
                    </a>
                </li>
                <li>
                	<a href="admin.php?page=social_network" class="<?php if($_GET['page']=="social_network"){echo "active";} ?>">
                    	<span class="icon-social">&nbsp;</span>
                        <span class="link">Social Networking</span>
                    </a>
                </li>
                <li>
                    <a href="admin.php?page=manage_languages" class="<?php if($_GET['page']=="manage_languages"){echo "active";} ?>">
                        <span class="icon-languages">&nbsp;</span>
                    	<span class="link">Language</span>
                	</a>
                </li>
                <li>
                	<a href="admin.php?page=default_pages_manage" class="<?php if($_GET['page']=="default_pages_manage"){echo "active";} ?>">
                    	<span class="icon-default-pages">&nbsp;</span>
                        <span class="link">Default Pages</span>
                    </a>
                </li>
                <li>
                	<a href="admin.php?page=newsletter_manage" class="<?php if($_GET['page']=="newsletter_manage"){echo "active";} ?>">
                    	<span class="icon-newsletter">&nbsp;</span>
                        <span class="link">Newsletter Management</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Left Column End -->

