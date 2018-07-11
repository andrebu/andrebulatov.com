<?php
global $General;
?>
<?php
global $wpdb;
$usersql = "select u.ID,u.user_login from $wpdb->users u ,$wpdb->usermeta um WHERE um.user_id=u.ID and (um.meta_key='wp_capabilities' and um.meta_value like \"%affiliate%\") order by user_login";
$userinfo = $wpdb->get_results($usersql);
if($userinfo)
{
	if($_REQUEST['srch_st_date'] == '' && $_REQUEST['srch_end_date'] =='')
	{
		$_REQUEST['srch_st_date'] = date('Y-m-').'1';
		$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) ;
		$_REQUEST['srch_end_date'] = date('Y-m-').$num;
	}
	?>
    <table width="100%"  class="widefat post fixed" >
      <thead>
         <tr>
            <th class="title"><?php _e('User Name'); ?> </th>
            <th class="title"><?php _e('Total Sale Amount'); echo ' ('. $General->get_currency_code().')'; ?> </th>
            <th class="title"><?php _e('Total Share Amount'); echo ' ('.$General->get_currency_code().')'; ?> </th>
        </tr>
        <?php
		if($_REQUEST['srch_st_date'] == '' && $_REQUEST['srch_end_date'] =='')
		{
			$_REQUEST['srch_st_date'] = date('Y-m-').'1';
			$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) ;
			$_REQUEST['srch_end_date'] = date('Y-m-').$num;
		}
		$user_affiliates_share_count = 0;
		foreach($userinfo as $userinfoObj)
        {
            $user_role = get_usermeta($userinfoObj->ID,'wp_capabilities');
            if($user_role['affiliate'])
            {
                $total_amt_array = get_total_share_amt_default($userinfoObj->ID,$_REQUEST['srch_st_date'],$_REQUEST['srch_end_date']);
				if($total_amt_array[0]>0)
				{
					$user_affiliates_share_count++;
                ?>
                <tr>
                    <td class="row1" ><a href="<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=affiliates_settings&user_id=<?php echo $userinfoObj->ID;?>"><?php echo $userinfoObj->user_login;?></a></td>
                    <td class="row1" ><?php echo $General->get_amount_format($total_amt_array[1],0);?></td>
                    <td class="row1" ><?php echo $General->get_amount_format($total_amt_array[0],0);?></td>
                </tr>   
                <?php
				}	
            }
        }
		if($user_affiliates_share_count == '0')
		{
        ?>
        <tr><td colspan="3" align="center"><?php _e('No affiliates share available.');?> </td></tr>
        <?php }?>
        </thead>
    </table>
<?php
}
header('Content-Description: File Transfer');
header("Content-type: application/force-download");
header('Content-Disposition: inline; filename="report.xls"');
//readfile($exportstr);

function get_total_share_amt_default($user_id,$stdate='',$enddate='')
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
			$showrecordflag = 0;
			if($stdate != '' && $enddate =='')
			{
				if($val['date'] == $stdate )
				{
					$showrecordflag = 1;
				}
			}else
			if($stdate == '' && $enddate!='')
			{
				if($val['date'] == $enddate )
				{
					$showrecordflag = 1;
				}
			}else
			if($stdate != '' && $enddate != '')
			{
				if((strtotime($val['date']) >= strtotime($stdate)) && (strtotime($val['date']) <= strtotime($enddate)) )
				{
					$showrecordflag = 1;
				}
			}
			if($showrecordflag)
			{
				$order_user_id = preg_replace('/(([_])[0-9]*)/','',$val['orderNumber']);
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
				if($order_info['order_status'] == 'approve' || $order_info['order_status'] == 'shipping' || $order_info['order_status'] == 'delivered')
				{
					$total_orders++;
					$order_amount = $val['order_amt'] - $order_info['discount_amt'];
					if($val['share_amt']>0)
					{
						$share_amt = ($order_amount*$val['share_amt'])/100;
					}
					//$share_amt = ($val['order_amt']*$val['share_amt'])/100;
					$share_total = $share_total + $share_amt; 
					$order_amt_total = $order_amt_total + $order_amount;
					for($c=0;$c<count($cart_info);$c++)
					{
						$product_qty = $product_qty + $cart_info[$c]['product_qty'];
					}
				}
			}
		}
	}
	return array($share_total,$order_amt_total,$total_orders,$product_qty);
}
?>