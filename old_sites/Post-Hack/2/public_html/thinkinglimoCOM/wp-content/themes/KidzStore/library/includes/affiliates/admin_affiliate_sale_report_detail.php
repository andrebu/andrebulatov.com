<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/dhtmlgoodies_calendar.js"></script>
<link href="<?php bloginfo('template_directory'); ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
<br />
<h2><?php _e('Affiliate Detail Report'); ?></h2>
<?php
global $wpdb;
$userId = $_REQUEST['user_id'];
$username = $wpdb->get_var("SELECT user_login FROM $wpdb->users WHERE ID=\"$userId\"");
$usertotal_array = get_total_sale($userId);
?>
<table width="70%"  class="widefat post fixed" >
<thead>
<td class="row1">
<table cellpadding="5" ><tr><td colspan="8"><h3><?php echo $username; _e("'s Affiliate Detail Report"); ?></h3></td></tr>
<tr>
<td><?php _e('No of Transactions'); ?> </td>
<th><?php echo  $usertotal_array[2];?> </th>
<td><?php _e('Total Item Sold'); ?> </td>
<th><?php echo  $usertotal_array[3];?> </th>
<td><?php _e('Total Sale Amount'); ?> </td>
<th><?php echo  $usertotal_array[1];?> </th>
<td><?php _e('Total Earn Amount'); ?> </td>
<th><?php echo  $usertotal_array[0];?> </th>
</tr>
</table>
 </td>
</thead>
</table>
<p></p>
<form action="" method="post" name="frm_srch">
 <?php _e('Search By');?> : 
     <?php _e('Date From');?>  <input type="text" name="srch_st_date"  id="srch_st_date"  value="<?php echo $_REQUEST['srch_st_date']; ?>" size="10"/>
    &nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.frm_srch.srch_st_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">
    <?php _e('To');?> <input type="text" name="srch_end_date"  id="srch_end_date"  value="<?php echo $_REQUEST['srch_end_date']; ?>" size="10"/>
    &nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.frm_srch.srch_end_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">
     <input type="submit" name="submit" value="<?php _e('Search');?>" class="highlight_input_btn" />
      <input type="button" name="default" onclick="window.location.href='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=affiliate_report&user_id=<?php echo $userId;?>'" value="<?php _e('Default');?>" class="highlight_input_btn" />
     <?php
     $params = '';
	 if($_REQUEST['srch_st_date'] != '' && $_REQUEST['srch_end_date'] =='')
	 {
	 	$params = "&srch_st_date=".$_REQUEST['srch_st_date'];
	 }else
	 if($_REQUEST['srch_st_date'] == '' && $_REQUEST['srch_end_date']!='')
	 {
	 	$params = "&srch_end_date=".$_REQUEST['srch_end_date'];
	 }else
	  if($_REQUEST['srch_st_date'] != '' && $_REQUEST['srch_st_date'] != '')
	 {
	 	$params = "&srch_st_date=".$_REQUEST['srch_st_date']."&srch_end_date=".$_REQUEST['srch_end_date'];
	 }
	 ?>
 <a href="<?php echo get_option('siteurl');?>/?page=account&report_export=1&user_id=<?php echo $userId;?><?php echo $params?>" target="_blank"><?php _e('Export to Excel');?></a>
 </form>
<p></p>
<?php
if($_REQUEST['user_id'])
{
	$user_id = $_REQUEST['user_id'];
	?>
	<table width="100%"  class="widefat post fixed" >
	  <thead>
		 <tr>
			<th class="title"><?php _e('Date'); ?> </th>
			<th class="title"><?php _e('Transaction ID'); ?> </th>
			<th class="title"><?php _e('Payment Status'); ?> </th>
			<th class="title"><?php _e('Item Name'); ?> </th>
			<th class="title"><?php _e('Qty'); ?> </th>
			<th class="title"><?php _e('Amount'); ?> </th>
			<th class="title"><?php _e('Currency'); ?> </th>
			<th class="title"><?php _e('Affiliate Share'); ?> </th>
		</tr>
	<?php
$user_affiliate_data = get_usermeta($user_id,'user_affiliate_data');
$record_count = 0;
if($user_affiliate_data)
{
	$share_total = 0;
	foreach($user_affiliate_data as $key => $val)
	{
		$showrecordflag = 0;
		$order_user_id = preg_replace('/(([_])[0-9]*)/','',$val['orderNumber']);
		$user_order_info = get_usermeta($order_user_id,'user_order_info');
		if($_REQUEST['srch_st_date'] != '' && $_REQUEST['srch_end_date'] =='')
		{
			if($val['date'] == $_REQUEST['srch_st_date'] )
			{
				$showrecordflag = 1;
			}
		}else
		if($_REQUEST['srch_st_date'] == '' && $_REQUEST['srch_end_date']!='')
		{
			if($val['date'] == $_REQUEST['srch_end_date'] )
			{
				$showrecordflag = 1;
			}
		}else
		if($_REQUEST['srch_st_date'] != '' && $_REQUEST['srch_st_date'] != '')
		{
			if(strtotime($val['date']) >= strtotime($_REQUEST['srch_st_date']) && strtotime($val['date']) <= strtotime($_REQUEST['srch_end_date']) )
			{
				$showrecordflag = 1;
			}
		}else
		{
			$showrecordflag = 1;
		}
		
		if($showrecordflag)
		{
			$order_number = preg_replace('/([0-9]*([_]))/','',$val['orderNumber']);
			if(!is_array($user_order_info))
			{
				$user_order_info = unserialize($user_order_info);
			}
			$order_info1 = $user_order_info[$order_number-1][0];
			$cart_info = $order_info1['cart_info']['cart_info'];
			$order_info = $order_info1['order_info'];
			if($order_info['order_status'] == 'approve' || $order_info['order_status'] == 'shipping' || $order_info['order_status'] == 'delivered')
			{
				$record_count++;
				$order_status = $order_info['order_status'];
				$product_name = array();
				$product_qty = 0;
				for($c=0;$c<count($cart_info);$c++)
				{
					$product_name[] = $cart_info[$c]['product_name'];
					$product_qty = $product_qty + $cart_info[$c]['product_qty'];
				}
				$product_name = implode(', ',$product_name);
				$currency = explode(' ',$order_info['payable_amt']);
				$order_amount = $val['order_amt'] - $order_info['discount_amt'];
				if($val['share_amt']>0)
				{
					$share_amt = ($order_amount*$val['share_amt'])/100;
				}
				$share_total = $share_total + $share_amt; 
		?>
			 <tr>
			<td class="row1" ><?php echo date('Y-m-d',strtotime($order_info['order_date']));?></td>
			<td class="row1" ><?php echo $order_info['order_id'];?></td>
			<td class="row1" ><?php echo $order_info['order_status'];?></td>
			<td class="row1" ><?php echo $product_name;?></td>
			<td class="row1" ><?php echo $product_qty;?></td>
			<td class="row1" ><?php echo $General->get_amount_format($order_amount,0);?></td>
			<td class="row1" ><?php echo $currency[1];?></td>
			<td class="row1" ><?php echo $General->get_amount_format($share_amt,0);?></td>
		</tr>   
		<?php
			}
		}
	}
}
if($record_count == '0')
{
?>
<tr><td colspan=8""><h4><?php _e('No record available');?></h4></td></tr>
<?php
}else
{
?>
<tr><td colspan="6">&nbsp;</td><th><?php _e('Total Earn Amount');?> </th><th><?php echo $General->get_amount_format($share_total,0);?></th></tr>
<?php
}
	?>  </thead>
</table>
<?php
}
function get_total_sale($user_id)
{
	$user_affiliate_data = get_usermeta($user_id,'user_affiliate_data');
	if($user_affiliate_data)
	{
		$order_amt_total = 0;
		$share_total = 0;
		$total_orders = 0;
		$product_qty = 0;
		foreach($user_affiliate_data as $key => $val)
		{
			$aff_user_id = preg_replace('/(([_][0-9]*))/','',$val['orderNumber']);
			$user_order_info = get_usermeta($aff_user_id,'user_order_info');
			$order_number = preg_replace('/([0-9]*([_]))/','',$val['orderNumber']);
			if(!is_array(get_usermeta($order_user_id,'user_order_info')))
			{
				$user_order_info = unserialize(get_usermeta($order_user_id,'user_order_info'));
			}else
			{
				$user_order_info = get_usermeta($order_user_id,'user_order_info');
			}
			$order_info1 = $user_order_info[$order_number-1][0];
			$cart_info = $order_info1['cart_info']['cart_info'];
			$order_info = $order_info1['order_info'];
			if($order_info['order_status'] == 'approve')
			{
				$total_orders++;
				$order_amount = $val['order_amt'] - $order_info['discount_amt'];
				if($val['share_amt']>0)
				{
					$share_amt = ($order_amount*$val['share_amt'])/100;
				}
				$share_total = $share_total + $share_amt; 
				$order_amt_total = $order_amt_total + $order_amount;
				for($c=0;$c<count($cart_info);$c++)
				{
					$product_qty = $product_qty + $cart_info[$c]['product_qty'];
				}
			}
		}
	}
	return array($share_total,$order_amt_total,$total_orders,$product_qty);
}
?>