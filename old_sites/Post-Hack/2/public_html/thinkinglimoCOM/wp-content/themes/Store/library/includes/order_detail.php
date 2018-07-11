<?php
global $Cart,$General,$wpdb;
$userInfo = $General->getLoginUserInfo();
global $current_user;
if(!$current_user->data->ID)
{
	wp_redirect(get_option( 'siteurl' ).'/?page=login');
	exit;
}
?>
<?php get_header(); ?>
<div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix">
        <div id="content">        
<h1 class="head"><?php _e('Order Detail Page'); ?></h1>
                <div class="breadcrumb clearfix">
                	<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; Order Detail'); } ?>
                </div>
 
     	
		<div class="content_spacer">
        <?php
		$userInfo = $General->getLoginUserInfo();
		$ordersql = "select meta_value from $wpdb->usermeta where meta_key = 'user_order_info' and user_id='".$userInfo['ID']."'";
		$orderinfo = $wpdb->get_results($ordersql);
		$orderId = $_GET['oid'];
		$order_number = preg_replace('/([0-9]*([_]))/','',$orderId);
		
		if($orderinfo)
		{
			foreach($orderinfo as $orderinfoObj)
			{
				$meta_value = unserialize(unserialize($orderinfoObj->meta_value)); 	
				$orderInformationArray = $meta_value[$order_number-1];
				$user_info = $orderInformationArray[0]['user_info'];
				$cart_info = $orderInformationArray[0]['cart_info'];
				$payment_info = $orderInformationArray[0]['payment_info'];
				$order_info = $orderInformationArray[0]['order_info'];
			}
		}
		$orderInformationArray[0]['user_info']['user_name']=$userInfo['display_name'];
		 ?>
        <?php echo $General->get_order_detailinfo_tableformat($orderInformationArray[0]); ?>
      </div>
 	                    
  			  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->

 <?php get_footer(); ?>