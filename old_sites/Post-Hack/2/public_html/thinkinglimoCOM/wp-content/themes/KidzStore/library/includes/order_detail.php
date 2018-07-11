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
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			<h2><?php _e(ORDER_DETAIL_PAGE_TITLE);?></h2>
             <div class="breadcrumb clearfix"> <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; '.__(ORDER_DETAIL_PAGE_TITLE)); } ?></div>
		</div>
	</div>
</div>

<div class="wrapper" >
  <div class="container_16 clearfix">
    <div id="content" class="grid_11">
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
    </div>
    <!-- content-in #end -->
   <?php get_sidebar(); ?>
  </div>
  <!-- container 16-->
</div>
<!-- wrapper #end -->
<?php get_footer(); ?>