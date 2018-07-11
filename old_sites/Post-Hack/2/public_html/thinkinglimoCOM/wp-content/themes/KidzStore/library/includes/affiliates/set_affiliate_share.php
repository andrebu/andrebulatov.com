<?php
global $current_user;
get_currentuserinfo();
$user_id = $current_user->data->ID;

if($cartTotalAmt>0 && $_COOKIE['affiliate-settings'] != '')
{
	$aff_info_array = explode('|',$_COOKIE['affiliate-settings']);
	$aid = $aff_info_array[0];
	$lkey = $aff_info_array[1];
	
	$user_affiliate_data = array();
	//$user_affiliate_data =  $current_user->user_affiliate_data;
	$user_affiliate_data = get_usermeta($aid,'user_affiliate_data');
	$share_amt = 0;
	$affiliate_settings = get_option('affiliate_settings');
	if($affiliate_settings['aff_share_amt']>0)
	{
		$share_amt = $affiliate_settings['aff_share_amt'];
	}
	$user_affiliate_data[] = array(
							"lkey"			=>	$lkey,
							"orderNumber"	=>	$orderNumber,
							"order_amt"		=>	$cartTotalAmt,
							"share_amt"		=>	$share_amt,
							"date"			=>	date('Y-m-d'),
							);
	//print_r($user_affiliate_data);
	update_usermeta($aid,'user_affiliate_data',$user_affiliate_data);
	//setcookie('affiliate-settings', '', time(), SITECOOKIEPATH,COOKIE_DOMAIN );
}
?>