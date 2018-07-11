<?php 
session_start();
ob_start();
global $Cart,$General,$wpdb;
global $upload_folder_path;
$orderInfoArray = array();
$itemsInCartCount = $Cart->cartCount();
$cartInfo = $Cart->getcartInfo();
$grandTotal = $General->get_amount_format($Cart->getCartAmt());
$userInfo = $General->getLoginUserInfo();
$cartTotalAmt = $Cart->getCartAmt();
if($_REQUEST['coupon_code'])
{
	$coupon_code = $_REQUEST['coupon_code'];
}else
{
	$coupon_code = $_SESSION['couponcode'];	
}
$discount_amt = $General->get_discount_amount($coupon_code,$Cart->getCartAmt());
$shipping_amt = $General->get_amount_format($General->get_shipping_amt($_REQUEST['shippingmethod'],$cartTotalAmt),0);
$taxable_amt = $General->get_tax_amount();
$payable_amt = $General->get_payable_amount($_REQUEST['shippingmethod']);
if($payable_amt>0)
{
	$order_status = 'processing';
}else
{
	$order_status = 'approve';
}
$paymentFlag = 1;

$cartInfo = $Cart->getcartInfo();
$userInfo = $General->getLoginUserInfo();
$itemsInCartCount = $Cart->cartCount();

if($_SESSION['checkout_as_guest'] == '') //normal checkout
{
	if(!$userInfo)
	{
		wp_redirect(get_option( 'siteurl' ).'/?page=login');
		exit;
	}
}else  // single page checkout
{
	include_once(TEMPLATEPATH . '/library/includes/single_page_checkout_insertuser.php');  //checkout type single page
}
if(!$itemsInCartCount)
{
	wp_redirect(get_option( 'siteurl' ).'/?page=cart&msg=emptycart');
	exit;
}
if($_REQUEST['paymentmethod'] == '')
{
	wp_redirect(get_option( 'siteurl' ).'/?page=checkout&msg=nopaymethod');
	exit;
}
$user_address_info = unserialize(get_user_option('user_address_info', $userInfo['ID']));
$user_address_info['user_name'] = $userInfo['display_name'];
$cart_info_array['cart_info'] = $cartInfo;
$cart_info_array['cart_amt'] = $General->get_amount_format($cartTotalAmt);

$paymentmethod = $_REQUEST['paymentmethod'];

/////////////////////////////////////////////////////////////////
$ordersql = "select meta_value from $wpdb->usermeta where meta_key = 'user_order_info' and user_id='".$userInfo['ID']."'";
$orderinfo = $wpdb->get_results($ordersql);
if($orderinfo)
{
	foreach($orderinfo as $orderinfoObj)
	{
		$meta_value_arr = array();
		$meta_value = unserialize(unserialize($orderinfoObj->meta_value));
		$orderId_array = array_keys($meta_value);
		$orerNumber = $orderId_array[count($orderId_array)-1];
		$order_number = preg_replace('/([0-9]*([_]))/','',$meta_value[$orerNumber][0]['order_info']['order_id']);
		$orderNumber = $userInfo['ID'].'_'.date('Ymd').'_'.($order_number+1);
	}
}

/////////////////////////////////////////////////////////////////
$payment_info_array = array();
$payment_info_array['paydeltype'] = $paymentmethod;
if($_REQUEST['shippingmethod'])
{
	$payment_info_array['shippingtype'] = $_REQUEST['shippingmethod'];
	$payment_info_array['shipping_amt'] = $shipping_amt;
}

$orderInfoArray['user_info'] = $user_address_info;
$orderInfoArray['cart_info'] = $cart_info_array;
$orderInfoArray['payment_info'] = $payment_info_array;

////AFFILIATE CODING START///
if($General->is_active_affiliate())
{
	if($cartTotalAmt>0 && $_COOKIE['affiliate-settings'] != '')
	{
		$aff_info_array = explode('|',$_COOKIE['affiliate-settings']);
		$aid = $aff_info_array[0];
		$lkey = $aff_info_array[1];
		$affliate_info =  array(
								"aid"	=>	$aid,
								);
		$orderInfoArray['affliate_info'] = $affliate_info;
	}
}
////AFFILIATE CODING END///

$ordersql = "select meta_value from $wpdb->usermeta where meta_key = 'user_order_info' and user_id='".$userInfo['ID']."'";
$orderinfo = $wpdb->get_results($ordersql);
if($orderinfo)
{
	foreach($orderinfo as $orderinfoObj)
	{
		$meta_value_arr = array();
		$meta_value = unserialize(unserialize($orderinfoObj->meta_value));
		//$orderNumber = $userInfo['ID'].'_'.date('Ymd').'_'.(count($meta_value)+1);
		$orderId_array = array_keys($meta_value);
		$orerNumber = $orderId_array[count($orderId_array)-1];
		$order_number = preg_replace('/([0-9]*([_]))/','',$meta_value[$orerNumber][0]['order_info']['order_id']);
		$orderNumber = $userInfo['ID'].'_'.date('Ymd').'_'.($order_number+1);		
		$order_info_array = array(
					"order_date"	=>	date('Y-m-d H:s:i'),
					"order_status"	=>	$order_status,
					"order_id"		=>	$orderNumber,
					"discount_amt"	=>	$General->get_amount_format($discount_amt,0),
					"taxable_amt"	=>	$General->get_amount_format($taxable_amt,0),
					"payable_amt"	=>	$General->get_amount_format($payable_amt,0).' '.$General->get_currency_code(),
					"coupon_code"	=>	$coupon_code,
					);
		$orderInfoArray['order_info'] = $order_info_array;
		$orderArray[] = $orderInfoArray;
		$meta_value[$order_number] = $orderArray;
		$orderArray1 = $meta_value;
		
	}
}else
{
	$orderNumber = $userInfo['ID'].'_'.date('Ymd').'_'.'1';
	$order_info_array = array(
					"order_date"	=>	date('Y-m-d H:s:i'),
					"order_status"	=>	$order_status,
					"order_id"		=>	$orderNumber,
					"discount_amt"	=>	$General->get_amount_format($discount_amt,0),
					"taxable_amt"	=>	$General->get_amount_format($taxable_amt,0),
					"payable_amt"	=>	$General->get_amount_format($payable_amt,0).' '.$General->get_currency_code(),
					);
	$orderInfoArray['order_info'] = $order_info_array;
	$orderArray[] = $orderInfoArray;
	$orderArray1[] = $orderArray;
}
/////////////////////////////////////////////////////////////////
$paymentSuccessFlag = 0;
if($paymentmethod == 'prebanktransfer' || $paymentmethod == 'payondelevary')
{
	$paymentSuccessFlag = 1;
}
else //if($paymentmethod == 'paypal' || $paymentmethod == 'googlechkout' || $paymentmethod == 'authorizenet' || $paymentmethod == 'worldpay')
{
	if($payable_amt>0)
	{
		if(file_exists( TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php'))
		{
			include_once(TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php');
		}
	}else
	{
		$paymentSuccessFlag = 1;
	}
}

/////////////////////////////////////////////////////
if($orderArray1 && $paymentFlag)
{
	update_usermeta($userInfo['ID'], 'user_order_info', serialize($orderArray1)); // Save Order Information Here
	///affiliate data start///
	@include_once(TEMPLATEPATH . '/library/includes/affiliates/set_affiliate_share.php'); // affiliate settings
	///affiliate data end///

	$_SESSION['CART_INFORMATION'] = array();
	$_SESSION['eval_coupon_code'] = '';
	$_SESSION['couponcode'] = '';
	// To send HTML mail, the Content-type header must be set
	
	$fromEmail = $General->get_site_emailId();
	$fromEmailName = $General->get_site_emailName();
	$subject = "Payment Pending - Thank you for order";
	$message = "";
	//$userInfo = $General->getLoginUserInfo();
	if($_REQUEST['user_fname']){$userInfo['display_name'] = $_REQUEST['user_fname'];}
	if($_REQUEST['user_email']){$userInfo['user_email'] = $_REQUEST['user_email'];}
	$toEmailName = $userInfo['display_name'];
	$toEmail = $userInfo['user_email'];
	
	$store_name = get_option('blogname');
	$order_info = $General->get_order_detailinfo_tableformat($orderInfoArray,1);
	$clientdestinationfile =   ABSPATH . $upload_folder_path."notification/emails/new_order_customer.txt";
	if(file_exists($clientdestinationfile))
	{
		$client_message = file_get_contents($clientdestinationfile);
	}else
	{
		$client_message = '[SUBJECT-STR]Thanks for shopping - Payment Pending[SUBJECT-END]<p>Dear [#$to_name#],</p>
							<p>[#$order_info#]</p>
							<p>your order received successfully but payment is not confirm yet.</p>
							<p>Thank you for shopping at [#$store_name#].</p>';
	}
	$filecontent_arr1 = explode('[SUBJECT-STR]',$client_message);
	$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
	$subject = $filecontent_arr2[0];
	if($subject == '')
	{
		$subject = "Thanks for shopping - Payment Pending";
	}
	$client_message = $filecontent_arr2[1];
	/////////////customer email//////////////
	if($toEmail)
	{
	$search_array = array('[#$to_name#]','[#$order_info#]','[#$store_name#]');
	$replace_array = array($toEmailName,$order_info,$store_name);
	$client_message = str_replace($search_array,$replace_array,$client_message);	
	$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$client_message,$extra='');///To clidne email
	}
	///////////admin email//////////
	$admindestinationfile =   ABSPATH . $upload_folder_path."notification/emails/new_order_admin.txt";
	if(file_exists($admindestinationfile))
	{
		$admin_message = file_get_contents($admindestinationfile);
	}else
	{
		$admin_message = '[SUBJECT-STR]New order has been placed by '.$toEmailName.' - Payment Pending[SUBJECT-END]
							<p>Dear [#$to_name#],</p>
							<p>order received successfully but payment is not confirm yet.</p>
							<p>[#$order_info#]</p>
							<p>Thank you.</p>';
	}
	$filecontent_arr1 = explode('[SUBJECT-STR]',$admin_message);
	$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
	$subject = $filecontent_arr2[0];
	if($subject == '')
	{
		$subject = "New order has been placed by $toEmailName - Payment Pending";
	}
	if($toEmail)
	{
		$admin_message = $filecontent_arr2[1];
		$search_array = array('[#$to_name#]','[#$order_info#]','[#$store_name#]');
		$replace_array = array($toEmailName,$order_info,$store_name);
		$admin_message = str_replace($search_array,$replace_array,$admin_message);	
		$General->sendEmail($toEmail,$toEmailName,$fromEmail,$fromEmailName,$subject,$admin_message,$extra='');///To admin email
	}
}
global $authorize_net_order_success;
if($paymentSuccessFlag)
{
	wp_redirect(get_option( 'siteurl' ).'/?page=ordersuccess&order='.$orderNumber);
}elseif($authorize_net_order_success == 1)
{
	wp_redirect(get_option('siteurl')."/?page=payment_success&oid=".$orderNumber);
}
?>