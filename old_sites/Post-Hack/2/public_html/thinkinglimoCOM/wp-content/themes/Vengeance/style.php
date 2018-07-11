<?php
require_once( dirname(__FILE__) . '../../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');
header("Content-type: text/css");

global $options;

foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }

/*Everything should be below this*/
?>

body{
color:#<?php echo $pt_body_color; ?>;
font: <?php echo $pt_body_font_size; ?>px <?php echo $pt_body_font_family; ?>;
}
body {
	color:#<?php echo $pt_body_color; ?>;
}
a, #content a,      {
    color:#<?php echo $pt_body_secondary_color; ?>;
}
<?php
//BLOG ALIGNMENT
if ( 'center' == $pt_blog_alignment) //IF center
{ ?>
#content-wrap, #header-in, #footer-in, #nav-in, #banner-in   {
	margin:0 auto;
}
<?php } elseif ( 'left' == $pt_blog_alignment) //IF RIGHT 
{ ?>
#header-in, #navi-in, #banner-in { float:left; padding-left:48px; }
#footer-in {  padding:8px 8px; float:left;  padding-left:48px; }
#content-wrap { margin-bottom:15px;  float:left;  padding-left:48px;}
 <?php } elseif ( 'right' == $pt_blog_alignment) //IF RIGHT 
{ ?>
#header-in, #navi-in, #banner-in { float:right; padding-right:48px; }
#footer-in {  padding:8px 8px; float:right;  padding-right:48px; }
#content-wrap { margin-bottom:15px;  float:right;  padding-right:48px;}
 <?php
}
?>
<?php
 //SIDEBAR LEFT / RIGHT?
if ( 'left' == $pt_sidebar_position) //IF Left
{ ?>
#sidebar {float:left;}
#content {float:right; }
.calendar {
    right:-43px;
    background:url(images/calendar2.png) no-repeat;}
* html .calendar {  right:-37px; }    
    
 <?php } elseif ( 'right' == $pt_sidebar_position ) //IF RIGHT 
{ ?>
#sidebar {float:right; }
#content {float:left; }
.calendar {
    left:-11px;}


<?php
}
?> 