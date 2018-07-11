<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/dhtmlgoodies_calendar.js"></script>
<link href="<?php bloginfo('template_directory'); ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
<style>
h2 {
	color:#464646;
	font-family:Georgia, "Times New Roman", "Bitstream Charter", Times, serif;
	font-size:24px;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:italic;
	font-variant:normal;
	font-weight:normal;
	line-height:35px;
	margin:0;
	padding:14px 15px 3px 0;
	text-shadow:0 1px 0 #FFFFFF;
}
</style>
<?php
global $General;
?>
<br />
<h2><?php _e('Affiliates Share'); ?></h2>
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
    <form action="" method="post" name="frm_srch">
 <?php _e('Search By');?> : 
     <?php _e('Date From');?>  <input type="text" name="srch_st_date"  id="srch_st_date"  value="<?php echo $_REQUEST['srch_st_date']; ?>" size="10"/>
    &nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.frm_srch.srch_st_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">
    <?php _e('To');?> <input type="text" name="srch_end_date"  id="srch_end_date"  value="<?php echo $_REQUEST['srch_end_date']; ?>" size="10"/>
    &nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.frm_srch.srch_end_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">
     <input type="submit" name="submit" value="<?php _e('Search');?>" class="highlight_input_btn" />
      <input type="button" name="default" onclick="window.location.href='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=affiliates_settings'" value="<?php _e('Default');?>" class="highlight_input_btn" />
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
 <a href="<?php echo get_option('siteurl');?>/?page=account&report_export_current=1&user_id=<?php echo $userId;?><?php echo $params?>" target="_blank"><?php _e('Export to Excel');?></a>
 </form>
 <br />
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
				//if($order_info['order_status'] == 'approve')
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