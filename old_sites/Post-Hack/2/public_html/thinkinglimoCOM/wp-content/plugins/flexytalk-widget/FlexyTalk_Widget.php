<?php
/**
 * Plugin Name: FrescoChat Live Chat
 * Plugin URI: http://www.FrescoChat.com
 * Description: FrescoChat - Intuitive, simple but powerful Live Chat solution. Connect from any mobile device or PC  - Free plan available
 * Version: 3.1.9
 * Author: FrescoChat
 */


function FT_Process()
{
$installation_mode=get_option(ft_installation_mode);

if($installation_mode=="1"){
	echo Get_Code();
	}
}

function Get_Code() {
$datadept=ft_get_dept();
$widget_id=get_option(ft_widget_id);
$htmlCode="<script id='fresco_script' data-frescochat='".$widget_id."' ".$datadept. ">var script = document.createElement('script');script.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//frescochat.blob.core.windows.net/app/v3/js/frescochat.js';document.getElementsByTagName('head')[0].appendChild(script);
   </script>";
return $htmlCode;
}
function ft_get_dept()
{
$dept_code=get_option(ft_dept);
$deptcodeStr="";

if($dept_code!="" ){
	$deptcodeStr=" data-frescochat-dept='".$dept_code."' ";
}
return $deptcodeStr;
}
//*************** Admin function ***************
function flexytalk_admin() {


	echo '<iframe src="http://panel.frescochat.com/home" width="100%" height="100%" style="min-height:850px; width:100%" frameborder=0 ></iframe>';

}




function flexytalk_admin_actions() {

 add_menu_page('FrescoChat', 'FrescoChat', 'manage_options','frescochat', 'flexytalk_admin', plugins_url( 'img/logo_icon.png', __FILE__ ));
add_submenu_page( 'frescochat', 'Control Panel', 'Control Panel','manage_options', 'frescochat', 'flexytalk_settings' );
 add_submenu_page( 'frescochat', 'Account Settings', 'Account Settings','manage_options', 'frescochat_settings', 'flexytalk_settings' );

}
add_action('admin_menu', 'flexytalk_admin_actions');
add_action('wp_footer', 'FT_Process');
add_action( 'widgets_init', 'flexytalk_load_widgets' );
add_filter( 'plugin_row_meta', 'flexytalk_register_plugin_links',10,2);



function flexytalk_settings()
{
 
include("flexytalk_settings.php");
}




function flexytalk_register_plugin_links($links, $file) {
	$base = plugin_basename(__FILE__);
	if ($file == $base) {
		//$links[] = '<a href="admin.php?page=flexytalk">' . __('Settings','flexytalk_widget') . '</a>';
		//$links[] = '<a href="http://www.flexytalk.com/support/faq/" target="_blank">' . __('FAQ','flexytalk_widget') . '</a>';
		$links[] = '<a href="http://frescochat.uservoice.com" target="_blank">' . __('Support','flexytalk_widget') . '</a>';
	}
	return $links;
}

function flexytalk_load_widgets() {
	register_widget( 'FlexyTalk_Widget' );
}
class FlexyTalk_Widget extends WP_Widget {

	function FlexyTalk_Widget() {

	$widget_ops = array( 'classname' => 'FlexyTalk', 'description' => __('Chat with your website visitors.', 'FlexyTalk') );
	$control_ops = array( 'width' => 700, 'height' => 350, 'id_base' => 'flexytalk-widget' );
	$this->WP_Widget( 'flexytalk-widget', __('FrescoChat Live Chat Widget', 'FrescoChat Live Chat Widget'), $widget_ops, $control_ops );
	}

function widget( $args, $instance ) {
if(is_active_widget( '', '', 'flexytalk-widget')){


		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget;


		$htmlCode="<div class='ft_widget_container' style='display:inline-block'/>";
		$installation_mode=get_option(ft_installation_mode);

		if($installation_mode=="0"){
		$widget_id=get_option(ft_widget_id);
	    $htmlCode=$htmlCode. "<script id='fresco_script' data-frescochat='".$widget_id."' ". ft_get_dept().">
         var script = document.createElement('script');
         script.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//frescochat.blob.core.windows.net/app/v3/js/frescochat.js';
         document.getElementsByTagName('head')[0].appendChild(script);
   </script>";
}

	printf( $htmlCode);

	

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	


}
}
?>