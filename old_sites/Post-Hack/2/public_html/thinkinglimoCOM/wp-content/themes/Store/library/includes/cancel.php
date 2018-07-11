<?php get_header(); ?>
<div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix">
        <div id="content">        
<h1 class="head"><?php _e('Payment Cancellation'); ?></h1>
                <div class="breadcrumb clearfix">
                	<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; Payment Cancellation'); } ?>
                </div>
<?php
global $upload_folder_path;
$destinationfile =   ABSPATH . $upload_folder_path."notification/message/payment_cancel_paypal.txt";
if(file_exists($destinationfile))
{
	$filecontent = file_get_contents($destinationfile);
}
?>
<?php
$store_name = get_option('blogname');
$search_array = array('[#$store_name#]');
$replace_array = array($store_name);
$filecontent = str_replace($search_array,$replace_array,$filecontent);
if($filecontent)
{
echo $filecontent;
}else
{
?>
<h2><?php _e('We are sorry for Cancellation of your order payment.'); ?></h2>
<?php
}
?> 	                    
  			  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->

 <?php get_footer(); ?>