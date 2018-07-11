<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js loading ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js loading ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js loading ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js loading" <?php language_attributes(); ?>> <!--<![endif]-->
<?php global $smof_data; ?>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&mdash;', true, 'right'); bloginfo('name'); ?></title>
<meta name="description" content="<?php if(!empty($smof_data['meta-desc'])) { ?><?php echo $smof_data['meta-desc']; ?><?php } else bloginfo('description'); ?>" />
<meta name="keywords" content="<?php if(!empty($smof_data['meta-key'])) { ?><?php echo $smof_data['meta-key']; ?><?php } ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta property="og:title" content="<?php bloginfo('name'); ?>" />
<meta property="og:description" content="<?php if(!empty($smof_data['meta-desc'])) { ?><?php echo $smof_data['meta-desc']; ?><?php } else bloginfo('description'); ?>" />
<?php if(!empty($smof_data['custom_site_image'])) { ?><meta property="og:image" content="<?php echo $smof_data['custom_site_image']; ?>" /><?php } ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <link rel="shortcut icon" href="img/favicon.ico">
  <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
<?php if(!empty($smof_data['custom_apple_touch_icon_1'])) { ?><link rel="apple-touch-icon" href="<?php echo $smof_data['custom_apple_touch_icon_1']; ?>"><?php } ?>
<?php if(!empty($smof_data['custom_apple_touch_icon_2'])) { ?><link rel="apple-touch-icon" sizes="72x72" href="<?php echo $smof_data['custom_apple_touch_icon_2']; ?>"><?php } ?>
<?php if(!empty($smof_data['custom_apple_touch_icon_3'])) { ?><link rel="apple-touch-icon" sizes="114x114" href="<?php echo $smof_data['custom_apple_touch_icon_3']; ?>"><?php } ?>
<?php if(!empty($smof_data['custom_favicon'])) { ?>
<link rel="shortcut icon" href="<?php echo $smof_data['custom_favicon']; ?>" />
<?php } else { ?>
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png" />
<?php } ?>
<?php if(!empty($smof_data['custom_site_image'])) { ?><link rel="image_src" href="<?php echo $smof_data['custom_site_image']; ?>" /><?php } ?>
<?php if (!empty($smof_data['tracking_header'])) echo $smof_data['tracking_header']; ?>
<?php if (!empty($smof_data['custom_css']) ) { ?><style><?php
	echo $smof_data['custom_css']; ?></style><?php } ?>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<nav id="mobile">

    <div id="toggle-bar">
        <strong><a class="mtoggle" href="#">

          <?php
          if(empty($smof_data['custom_logo'])) { 
           echo do_shortcode($smof_data['logo_text']); 
         } else {?>

          <?php $thumb_image_url2 = aq_resize( $smof_data['custom_logo'], '', 110, false ); ?>
          <img src="<?php echo $thumb_image_url2; ?>" class="logo_pic_small" alt="<?php bloginfo( 'name' ); ?>"/>
          <?php } ?>

        </a></strong>
        <a class="navicon mtoggle" href="#">MAIN MENU</a>
    </div>

   <div class="mmenu-warp">
    <?php
        wp_nav_menu(array(
          'container' => false,
          'theme_location' => 'main_menu',
          'depth'           => 1,
          'items_wrap' => '<ul id="mmenu" >%3$s</ul>'
        )); ?>
        </div>

</nav>



<div id="header" class="parentContainer container">
        <div class="header-container">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><div class="content-logo">
            	<!-- <div class="logo"></div> -->
        <?php if(!empty($smof_data['custom_logo']) && current_user_can('manage_options')) { 
            $thumb_image_url = aq_resize( $smof_data['custom_logo'], '', 110, false ); 
          ?>
                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php if(!empty($smof_data['meta-desc'])) { ?><?php echo esc_attr($smof_data['meta-desc']); ?><?php } else { echo esc_attr( get_bloginfo( 'description', 'display' )); } ?>"><img src="<?php echo $thumb_image_url; ?>" class="logo_pic" style="top:34px;" alt="<?php bloginfo( 'name' ); ?>"/></a></h1>
          <?php } 
          elseif(!empty($smof_data['custom_logo']) && !current_user_can('manage_options')) { 
             $thumb_image_url = aq_resize( $smof_data['custom_logo'], '', 110, false ); 
            ?>
          <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php if(!empty($smof_data['meta-desc'])) { ?><?php echo esc_attr($smof_data['meta-desc']); ?><?php } else { echo esc_attr( get_bloginfo( 'description', 'display' )); } ?>"><img src="<?php echo $thumb_image_url; ?>" class="logo_pic" alt="<?php bloginfo( 'name' ); ?>"/></a></h1>

        <?php } else { ?>
                <div class="company-name"><?php echo do_shortcode($smof_data['logo_text']); ?></div>
                <div class="comp-clear"></div>
                <p class="company-tagline"><?php echo do_shortcode($smof_data['logo_tagline_text']); ?></p>
        <?php } ?>
               
            </div></a>
         
            <div class="menu-select">
                <nav id="menu">

     <?php
        wp_nav_menu(array(
          'container' => false,
          'theme_location' => 'main_menu',
          'depth'           => 1,
          'items_wrap' => '<ul>%3$s</ul>'
        )); ?>
                  
                </nav>
            </div>
        </div>
    </div> <!-- end header-->
    