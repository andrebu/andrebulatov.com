<?php
global $Cart,$General;
$itemsInCartCount = $Cart->cartCount();
$grandTotal = $General->get_amount_format($Cart->getCartAmt());
$userInfo = $General->getLoginUserInfo();
$cartInfo = $Cart->getcartInfo();
$product_tax = $General->get_product_tax();
$taxable_amt = $General->get_tax_amount();
$payable_amt = $General->get_payable_amount();
$discount_amt = $General->get_amount_format($General->get_discount_amount($_SESSION['couponcode'],$Cart->getCartAmt()));
$discount_info = $General->get_discount_info($_SESSION['couponcode']);
$_SESSION['redirect_page'] = '';
$_SESSION['checkout_as_guest'] = $_REQUEST['checkout_as_guest']; 
if($_SESSION['couponcode'])
{
	if(!$General->is_valid_couponcode($_SESSION['couponcode']))
	{
		wp_redirect(get_option( 'siteurl' ).'/?page=cart&msg=invalidcoupon');
		exit;
	}
}
$user_address_info = unserialize(get_user_option('user_address_info', $userInfo['ID']));
if($_SESSION['checkout_as_guest'] == '') //simple checkout
{
	global $current_user;
	if(!$current_user->data->ID)
	{
		$_SESSION['redirect_page'] = $_SERVER['QUERY_STRING'];
		wp_redirect(get_option( 'siteurl' ).'/?page=login');
		exit;
	}else
	{
		if($_REQUEST['orderid'])
		{
			include_once(TEMPLATEPATH . '/library/includes/order_paynow.php');  //re order now
		}else
		{
			include_once(TEMPLATEPATH . '/library/includes/normal_checkout.php');  //checkout type normal
		}
	}
}else  //single page checkout
{
	include_once(TEMPLATEPATH . '/library/includes/single_checkout.php');  //checkout type single page
}
?>