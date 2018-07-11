<?php
global $General, $Cart;
$paymentOpts = $General->get_payment_optins($_REQUEST['paymentmethod']);
$merchantid = $paymentOpts['vendorid'];
if($merchantid == '')
{
	$merchantid = '1303908';
}
$ipnfilepath = $paymentOpts['ipnfilepath'];
if($ipnfilepath == '')
{
	$ipnfilepath = get_option('siteurl')."/?page=notifyurl&pmethod=2co";
}
$currency_code = $General->get_currency_code();
$cartInfo = $Cart->getcartInfo();
$itemArr = array();
for($i=0;$i<count($cartInfo);$i++)
{
	$product_att = preg_replace('/([(])([+-])([0-9]*)([)])/','',$cartInfo[$i]['product_att']);
	$itemstr = '';
	$itemstr .= $cartInfo[$i]['product_qty'].' X '.$cartInfo[$i]['product_name'];
	if($product_att)
	{
		$itemstr .="($product_att)";
	}
	$itemArr[] = $itemstr;
	
}
$item_name = implode(', ',$itemArr);
$amount = $Cart->getCartAmt();
$payable_amt = $General->get_payable_amount($_REQUEST['shippingmethod']);

$toEmailName = $userInfo['display_name'];
$toEmail = $userInfo['user_email'];

$currency_code = $General->get_currency_code();

global $current_user;
$userinfo = get_usermeta($current_user->data->ID, 'user_address_info');
if($userinfo['buser_add1'])
{
	$user_add1 = $userinfo['buser_add1'];
}else
{
	$user_add1 = $userinfo['user_add1'];
}
if($userinfo['buser_add2'])
{
	$user_add2 = $userinfo['buser_add2'];
}else
{
	$user_add2 = $userinfo['user_add2'];
}
if($userinfo['buser_city'])
{
	$user_city = $userinfo['buser_city'];
}else
{
	$user_city = $userinfo['user_city'];
}
if($userinfo['buser_state'])
{
	$user_state = $userinfo['buser_state'];
}else
{
	$user_state = $userinfo['user_state'];
}
if($userinfo['buser_country'])
{
	$user_country = $userinfo['buser_country'];
}else
{
	$user_country = $userinfo['user_country'];
}
if($userinfo['buser_postalcode'])
{
	$user_postalcode = $userinfo['buser_postalcode'];
}else
{
	$user_postalcode = $userinfo['user_postalcode'];
}

?>

<form method="post" action="https://www.2checkout.com/checkout/purchase" name="frm_payment_method">
<input type="hidden" value="73453" name="c_prod"/>
<input type="hidden" value="<?php echo $item_name;?>" name="c_name"/>
<input type="hidden" value="<?php echo $item_name;?>" name="c_description"/>
<input type="hidden" value="<?php echo $payable_amt;?>" name="c_price"/>
<input type="hidden" value="1" name="id_type"/>
<input type="hidden" value="<?php echo $orderNumber;?>" name="cart_order_id"/>
<input type="hidden" value="<?php echo $payable_amt;?>" name="total"/>
<input type="hidden" value="<?php echo $merchantid;?>" name="sid"/>
<input type="hidden" name="c_tangible" value="N">
<input type='hidden' name='x_receipt_link_url' value='<?php echo $ipnfilepath;?>' />
<input type='hidden' name='x_amount' value='<?php echo $payable_amt;?>' />
<input type='hidden' name='x_login' value='<?php echo $merchantid;?>' />
<input type='hidden' name='x_invoice_num' value='<?php echo $orderNumber;?>' />
<input type='hidden' name='x_first_name' value='<?php echo $toEmailName;?>' />
<input type='hidden' name='x_email' value='<?php echo $toEmail;?>' />
<input type="hidden" name="tco_currency" value="<?php echo $currency_code;?>" />

<input type="hidden" name="street_address" value="<?php echo $user_add1;?>" />
<input type="hidden" name="street_address2" value="<?php echo $user_add2;?>" />
<input type="hidden" name="city" value="<?php echo $user_city;?>" />
<input type="hidden" name="state" value="<?php echo $user_state;?>" />
<input type="hidden" name="zip" value="<?php echo $user_postalcode;?>" />
<input type="hidden" name="country" value="<?php echo $user_country;?>" />
<input type="hidden" name="email" value="<?php echo $toEmail;?>" />
<!--<input type="submit" value="Buy from 2CO" name="purchase" class="submit"/>-->
</form>

 <div class="wrapper" >
		<div class="clearfix container_message">
            	<center><h1 class="head2">Processing for <?php echo $_REQUEST['paymentmethod'];?>, Please wait ....</h1></center>
            </div>

<script>
setTimeout("document.frm_payment_method.submit()",500); 
</script>


        

 