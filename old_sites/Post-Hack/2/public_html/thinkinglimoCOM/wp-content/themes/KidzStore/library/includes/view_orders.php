<h3> <?php _e(MY_ORDERS_TITLE)?> </h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
  <tr>
    <td class="title"><?php _e(ORDER_NUMBER_TEXT);?></td>
    <td width="25%" align="center" class="title"><?php _e(DATE_TEXT);?></td>
    <td width="10%" align="center" class="title"><?php _e(PRICE_TEXT);?></td>
    <td width="10%" align="center" class="title"><?php _e(STATUS_TEXT);?></td>
  </tr>
  <?php
$userInfo = $General->getLoginUserInfo();
$ordersql = "select meta_value from $wpdb->usermeta where meta_key = 'user_order_info' and user_id='".$userInfo['ID']."'";
$orderinfo = $wpdb->get_results($ordersql);
if($orderinfo)
{
	foreach($orderinfo as $orderinfoObj)
	{
		$meta_value_arr = array();
		$meta_value = unserialize(unserialize($orderinfoObj->meta_value));
		foreach($meta_value as $oid=>$ovalue)
		{
			$user_info = $ovalue[0]['user_info'];
			$cart_info = $ovalue[0]['cart_info'];
			$payment_info = $ovalue[0]['payment_info'];
			$order_info = $ovalue[0]['order_info'];
		?>
  <tr>
    <td class="row1"><a href="<?php echo get_option('siteurl');?>/?page=order_detail&oid=<?php echo $order_info['order_id'];?>"><?php echo $order_info['order_id'];?></a></td>
    <td align="center" class="row1"><?php echo date(get_option('date_format'),strtotime($order_info['order_date']));?></td>
    <td align="center" class="row1 tprice"><?php echo $order_info['payable_amt'];?></td>
    <td align="center" class="remove"><?php echo $General->getOrderStatus($order_info['order_status']);?></td>
  </tr>
  <?php
		}
	}
}
?>
</table>