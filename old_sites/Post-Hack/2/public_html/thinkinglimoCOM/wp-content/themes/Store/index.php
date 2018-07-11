<?php
/*
Template Name: Home Page
*/
if($_GET['page'] == 'phpinfo')
{
	phpinfo();
}
global $Cart, $General;
///affiliate setting start//
if($_GET['page'] == 'account')
{
	include_once(TEMPLATEPATH . '/library/includes/affiliates/check_affiliate.php');
}
if($_GET['page'] == 'affiliate') //affiliate page start
{
	include(TEMPLATEPATH . '/library/includes/affiliates/affiliate_page.php');
	exit;
}  //affiliate page end
if($_GET['page'] == 'setasaff')
{
	global $current_user;
	get_currentuserinfo();
	$user_id = $current_user->data->ID;
	$current_user->data->wp_capabilities['affiliate'] = 1;
	update_usermeta($user_id, 'wp_capabilities', $current_user->data->wp_capabilities);
	wp_redirect(get_option( 'siteurl' ) ."/?page=account");
}
///affiliate setting end//

if($_REQUEST['page'] == 'csvdl')
{
	include (TEMPLATEPATH . "/library/includes/csvdl.php");
	exit;
}

if($_GET['page'] == 'cart')
{
	
	if(($_REQUEST['cartact']=='rmv' || $_REQUEST['cartact']=='upd') || $_REQUEST['cartact']=='addtocart')// || $_REQUEST['cartact']=='ajaxsetcart')
	{
		if($_REQUEST['cartact']=='addtocart')
		{
			
			$product_id = $_REQUEST['product_id'];
			$product_qty = $_REQUEST['product_qty'];
			if($General->cart_detail_outofstock($product_id,$product_qty))
			{
				//$General->cart_detail_outofstock($product_id,$product_qty);
			}else
			{			
				$Cart->Addtocart($_REQUEST);
			}
			$itemsInCartCount = $Cart->cartCount();
			$cartAmount = $Cart->getCartAmt();
			echo $itemsInCartCount . "(".$General->get_amount_format($cartAmount).")";
			exit;
		}elseif($_REQUEST['cartact']=='rmv')
		{
			$Cart->Removefromcart($_GET['prm']);
		}
		elseif($_REQUEST['cartact']=='upd')
		{
			$Cart->updateCart($_POST['product_qty']);
		}	
		$location = get_option('siteurl')."/?page=cart";
		wp_redirect($location);
	}
	elseif($_REQUEST['cartact']=='eval_coupon')
	{
		$_SESSION['couponcode'] = '';
		$eval_coupon_code = $_REQUEST['eval_coupon_code'];
		if($General->is_valid_couponcode($_REQUEST['eval_coupon_code']))
		{
			$_SESSION['couponcode'] = $_REQUEST['eval_coupon_code'];
		}else
		{
			$_REQUEST['msg']='invalidcoupon';
		}
	}
	elseif($_REQUEST['cartact']=='cart_refresh')
	{
		global $Cart,$General;
		$itemsInCartCount = $Cart->cartCount();
		$cartInfo = $Cart->getcartInfo();
		?>
		<div class="shipping_title clearfix"> <span class="pro_s"> <?php _e('Product');?></span> <span class="pro_q"> <?php _e('Qty');?></span> <span class="pro_p"> <?php _e('Price');?></span> </div>
		 <?php
         for($i=0;$i<count($cartInfo);$i++)
		 {
		 	$grandTotal = $General->get_amount_format($Cart->getCartAmt());
		 ?>
            <div class="shipping_row clearfix"> <span class="pro_s"> <?php echo $cartInfo[$i]['product_name'];?> <?php if($cartInfo[$i]['product_att']){echo "<br>".preg_replace('/([(])([+-])([0-9]*)([)])/','',$cartInfo[$i]['product_att']);}?></span> <span class="pro_q"><?php echo $cartInfo[$i]['product_qty'];?></span> <span class="pro_p"> <?php echo $General->get_amount_format($cartInfo[$i]['product_gross_price']);?></span> </div>
        <?php }?>
        <div class="shipping_total"><?php _e('Total');?> : <?php echo $grandTotal;?> </div>
        <div class="b_checkout"><a href="<?php echo get_option('siteurl');?>/?page=cart"><?php _e('Checkout');?></a> </div>
        </div> 
       <?php
	   exit;
	}
	elseif($_REQUEST['cartact']=='stock_chk')
	{
		$product_id = $_REQUEST['product_id'];
		$product_qty = $_REQUEST['product_qty'];
		$stock = $General->check_stock($_REQUEST['pid']);
		if($stock == 'unlimited')
		{
			echo $stock;
		}elseif($General->cart_detail_outofstock($product_id,$product_qty))
		{
			echo $General->cart_detail_outofstock($product_id,$product_qty,'pd');
		}
		else
		{
			$cart_stock = $Cart->get_product_qty_cart($_REQUEST['pid']);
			if($cart_stock && $cart_stock>0)
			{
				$stock = $stock - $cart_stock;	
			}
			echo $stock;
		}
		exit;
	}
}

if($_GET['page'] == 'tellafriend_form')
{

	include(TEMPLATEPATH . '/library/includes/tellafriend_form.php');
	exit;
}
if($_GET['page'] == 'download')
{
	include(TEMPLATEPATH . '/library/includes/download.php');
	exit;
}
?>

<?php get_header(); ?>

<?php 
if($_GET['page'] == 'cart')
{
	//<!-- Cart Detail Page: START -->
	include(TEMPLATEPATH . '/library/includes/cart_detail.php');
	//<!-- Cart Detail Page: END -->
}
elseif($_GET['page'] == 'checkout')
{
	//<!-- Cart Detail Page: START -->
	include(TEMPLATEPATH . '/library/includes/checkout.php');
	//<!-- Cart Detail Page: END -->
}
elseif($_GET['page'] == 'confirm')
{
	//<!-- Cart Detail Page: START -->
	include(TEMPLATEPATH . '/library/includes/confirm.php');
	//<!-- Cart Detail Page: END -->
}
elseif($_GET['page'] == 'emptycart')
{
	//<!-- Empty Cart Page: START -->
	$Cart->empty_cart();
	wp_redirect(get_option( 'siteurl' ) ."/?page=cart");
	//<!-- Empty Cart Page: END -->
}
elseif($_GET['page'] == 'login')
{
	include(TEMPLATEPATH . '/library/includes/registration.php');
}
elseif($_GET['page'] == 'myaccount')
{
	include(TEMPLATEPATH . '/library/includes/view_account.php');
}
elseif($_GET['page'] == 'payment')
{
	include(TEMPLATEPATH . '/library/includes/payment.php');
}
elseif($_GET['page'] == 'ordersuccess')
{
	include(TEMPLATEPATH . '/library/includes/ordersuccess.php');
}
elseif($_GET['page'] == 'order_detail')
{
	include(TEMPLATEPATH . '/library/includes/order_detail.php');
}
elseif($_GET['page'] == 'cancel_return')  // PAYMENT GATEWAY cancel return
{
	$General->set_ordert_status($_REQUEST['oid'],'cancel');
	include(TEMPLATEPATH . '/library/includes/cancel.php');
	exit;
}
elseif($_GET['page'] == 'return' || $_GET['page'] == 'payment_success')  // PAYMENT GATEWAY RETURN
{
	//if($_REQUEST['pmethod']=='paypal')
	$General->set_ordert_status($_REQUEST['oid'],'approve');
	include(TEMPLATEPATH . '/library/includes/return.php');
	exit;
}
elseif($_GET['page'] == 'notifyurl')  // PAYMENT GATEWAY NOTIFY URL
{
	if($_GET['pmethod'] == 'paypal')
	{
		include(TEMPLATEPATH . '/library/includes/ipn_process.php');
	}elseif($_GET['pmethod'] == '2co')
	{
		include(TEMPLATEPATH . '/library/includes/ipn_process_2co.php');
	}
	exit;
}
elseif($_GET['page'] == 'sendenquiry')
{
	include(TEMPLATEPATH . '/library/includes/send_inquiry.php');
}
elseif($_GET['page'] == 'tellafriend')
{
	include(TEMPLATEPATH . '/library/includes/tellafriend.php');
}
elseif($_GET['page'] == 'store')
{
	include(TEMPLATEPATH . '/library/includes/tpl_latest_products.php');
}
elseif($_GET['page'] == 'Blog')
{
	include(TEMPLATEPATH . '/blog_listing.php');
}
else
{
	//<!-- Featured Page: START -->
	 include(TEMPLATEPATH . '/library/includes/featured-page.php');
	//<!-- Featured Page: END -->
}
?>
	
<?php //include(TEMPLATEPATH . '/library/includes/featured-page.php'); ?>
 
<?php get_footer(); ?>          