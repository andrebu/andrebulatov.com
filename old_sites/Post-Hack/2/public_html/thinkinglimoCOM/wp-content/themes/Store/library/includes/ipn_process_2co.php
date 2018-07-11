<?php
global $Cart,$General;
foreach ($_POST as $field=>$value)
{
	$ipnData["$field"] = $value;
}

$invoice    = intval($ipnData['x_invoice_num']);
$pnref      = $ipnData['x_trans_id'];
$amount     = doubleval($ipnData['x_amount']);
$result     = intval($ipnData['x_response_code']);
$respmsg    = $ipnData['x_response_reason_text'];
$customer_email    = $ipnData['x_email'];
$customer_name = $ipnData['x_first_name'];

$fromEmail = $General->get_site_emailId();
$fromEmailName = $General->get_site_emailName();
$userInfo = $General->getLoginUserInfo();
$subject = "Acknowledge for #$invoice payment";

if ($result == '1')
{
	// Valid IPN transaction.
	$General->set_ordert_status($invoice,'approve');
	$message = '<p>Dear '.$customer_name.',</p>
			<p>
			payment for order #$invoice completed successfully.<br>
			</p>
			<p>
			<b>You may find detail below:</b>
			</p>
			<p>----</p>
			<p>Order Id : '.$invoice.'</p>
			<p>Order Amount :       '.$General->get_amount_format($amount,0).'</p>
			<p>Transaction ID :       '.$pnref.'</p>
			<p>Result Code : '.$result.'</p>
			<p>Response Message : '.$respmsg.'</p>
			<p>----</p><br><br>
			<p>Thank you.</p>
			';
	$General->sendEmail($fromEmail,$fromEmailName,$customer_email,$customer_name,$subject,$message,$extra='');///To payment email
	
	///affiliate email start//
	$orderId = $invoice;
	$order_number = preg_replace('/([0-9]*([_]))/','',$orderId);
	$userId = preg_replace('/([_])([0-9]*)/','',$orderId);
	$ordersql = "select u.display_name,u.user_email,um.meta_value from $wpdb->usermeta as um join $wpdb->users as u on u.ID=um.user_id where um.meta_key = 'user_order_info' and um.user_id='".$userId."'";
	$orderinfo = $wpdb->get_results($ordersql);
	if($orderinfo)
	{
		foreach($orderinfo as $orderinfoObj)
		{
			$meta_value = unserialize(unserialize($orderinfoObj->meta_value)); 
			$display_name= $orderinfoObj->display_name;	
			$user_email= $orderinfoObj->user_email;
			$orderInformationArray = $meta_value[$order_number-1];
			$user_info = $orderInformationArray[0]['user_info'];
			$cart_info = $orderInformationArray[0]['cart_info'];
			$payment_info = $orderInformationArray[0]['payment_info'];
			$order_info = $orderInformationArray[0]['order_info'];
			$affliate_info = $orderInformationArray[0]['affliate_info'];		
		}
	}
	$aid = $affliate_info['aid'];
	if($aid)
	{
		$usersql = "SELECT user_nicename,user_email FROM $wpdb->users WHERE ID=\"$aid\"";
		$userinfo = $wpdb->get_results($usersql);
		$toEmailName = $userinfo[0]->user_nicename;
		$toEmail = $userinfo[0]->user_email;
		$user_affiliate_data = get_usermeta($aid,'user_affiliate_data');
		$cart_amt = str_replace(',','',substr($cart_info['cart_amt'],1));
		foreach($user_affiliate_data as $key => $val)
		{
			$share_amt = ($cart_amt*$val['share_amt'])/100;
		}			
		$cart_info_arr = $cart_info['cart_info'];
		for($c=0;$c<count($cart_info_arr);$c++)
		{
			$product_name[] = $cart_info_arr[$c]['product_name'];
			$product_qty = $product_qty + $cart_info_arr[$c]['product_qty'];
		}
		$product_name = implode(', ',$product_name);
		$subject = 'Affiliate Sale';
		$aff_message = '
		<p>Dear '.$toEmailName.',</p>
		<p>
		New sale has been made by your affiliate link and<br>
		commission credited to your balance.<br>
		</p>
		<p>
		You may find sale details below:
		</p>
		<p>----</p>
		<p>Transaction Id : '.$order_info['order_id'].'</p>
		<p>Order Amount :       '.$General->get_amount_format($cart_amt,0).'</p>
		<p>Qty :       '.$product_qty.'</p>
		<p>Product ordered: '.$product_name.'</p>
		<p>Your commission: '.$General->get_amount_format($share_amt,0).'</p>
		<p>----</p>
		';
		$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$aff_message,$extra='');
		///To affiliate email end
	}
	/////affiliate email end
	return true;
}
else if ($result != '1')
{
	$message = '<p>Dear '.$customer_name.',</p>
			<p>
			payment for order #$invoice incompleted.<br>
			because of $respmsg
			</p>
			<p>
			<b>You may find detail below:</b>
			</p>
			<p>----</p>
			<p>Order Id : '.$invoice.'</p>
			<p>Order Amount :       '.$General->get_amount_format($amount,0).'</p>
			<p>Transaction ID :       '.$pnref.'</p>
			<p>Result Code : '.$result.'</p>
			<p>Response Message : '.$respmsg.'</p>
			<p>----</p><br><br>
			<p>Thank you.</p>
			';
	$General->sendEmail($fromEmail,$fromEmailName,$customer_email,$customer_name,$subject,$message,$extra='');///To payment email
	return false;
}
?>