<?php
set_time_limit(0);
global  $wpdb;
//require_once (TEMPLATEPATH . '/delete_data.php');
/////////////// GENERAL SETTINGS START ///////////////
$shoppingcart_general_settings = get_option('shoppingcart_general_settings');
if(!$shoppingcart_general_settings || ($shoppingcart_general_settings && count($shoppingcart_general_settings)==0))
{
	$cartinfo = array(
						"currency"				=> 'USD',
						"currencysym"			=> '$',
						"site_email"			=>   get_option('admin_email'),
						"site_email_name"		=>	get_option('blogname'),
						"tax"					=>	'0.00',
						"is_show_weight"		=>	'1',
						"store_type"			=>	'cart',
						"imagepath"				=>	"",		
						"is_show_coupon"		=>	"1",
						"dash_noof_orders"		=>	"10",
						"is_show_tellafrnd"		=>	"1",
						"is_show_addcomment"	=>	"0",
						"checkout_type"			=>	"cart",
						"is_show_relproducts"	=>	"1",
						"digitalproductpath"	=>	"",
						"is_show_blogpage"		=>	"1",
						"is_show_storepage"		=>	"1",
						"is_show_category"		=>	"1",
						"checkout_method"		=>	"normal",
						"is_show_termcondition"	=>	'1',
						"termcondition"			=>	'Accept Terms and Conditions',
						"loginpagecontent"		=>	'If you are an existing customer of [#$store_name#] or have previously registered you may sign in below or request a new password. Otherwise please enter your information below and an account will be created for you.',												
						"bill_address1"			=>	"1",
						"bill_address2"			=>	"1",																	
						"bill_city"				=>	"1",
						"bill_state"			=>	"1",
						"bill_country"			=>	"1",
						"bill_zip"				=>	"1",
						"is_active_affiliate"	=>	"0",
						"send_email_guest"		=>	"1",						
						);
	update_option("shoppingcart_general_settings",$cartinfo);
}
/////////////// GENERAL SETTINGS END ///////////////
/////////////// PAYMENT SETTINGS START ///////////////
$paymethodinfo=array();
$payOpts = array();
	$payOpts[] = array(
					"title"			=>	"Merchant Id",
					"fieldname"		=>	"merchantid",
					"value"			=>	"myaccount@paypal.com",
					"description"	=>	"Example : myaccount@paypal.com",
					);
	$payOpts[] = array(
					"title"			=>	"Cancel Url",
					"fieldname"		=>	"cancel_return",
					"value"			=>	get_option('siteurl')."/?page=cancel_return&pmethod=paypal",
					"description"	=>	"Example : http://mydomain.com/cancel_return.php",
					);
	$payOpts[] = array(
					"title"			=>	"Return Url",
					"fieldname"		=>	"returnUrl",
					"value"			=>	get_option('siteurl')."/?page=return&pmethod=paypal",
					"description"	=>	"Example : http://mydomain.com/return.php",
					);
	$payOpts[] = array(
					"title"			=>	"Notify Url",
					"fieldname"		=>	"notify_url",
					"value"			=>	get_option('siteurl')."/?page=notifyurl&pmethod=paypal",
					"description"	=>	"Example : http://mydomain.com/notifyurl.php",
					);								
	$paymethodinfo[] = array(
						"name" 		=> 'Paypal',
						"key" 		=> 'paypal',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'1',
						"payOpts"	=>	$payOpts,
						);
	//////////pay settings end////////
	//////////google checkout start////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	"Merchant Id",
					"fieldname"		=>	"merchantid",
					"value"			=>	"1234567890",
					"description"	=>	"Example : 1234567890"
					);
	$paymethodinfo[] = array(
						"name" 		=> 'Google Checkout',
						"key" 		=> 'googlechkout',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'2',
						"payOpts"	=>	$payOpts,
						);
//////////google checkout end////////
//////////authorize.net start////////
$payOpts = array();
	$payOpts[] = array(
					"title"			=>	"Login ID",
					"fieldname"		=>	"loginid",
					"value"			=>	"yourname@domain.com",
					"description"	=>	"Example : yourname@domain.com"
					);
	$payOpts[] = array(
					"title"			=>	"Transaction Key",
					"fieldname"		=>	"transkey",
					"value"			=>	"1234567890",
					"description"	=>	"Example : 1234567890",
					);
	$paymethodinfo[] = array(
						"name" 		=> 'Authorize.net',
						"key" 		=> 'authorizenet',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'3',
						"payOpts"	=>	$payOpts,
						);
//////////authorize.net end////////
//////////worldpay start////////
	$payOpts = array();	
	$payOpts[] = array(
					"title"			=>	"Instant Id",
					"fieldname"		=>	"instId",
					"value"			=>	"123456",
					"description"	=>	"Example : 123456"
					);
	$payOpts[] = array(
					"title"			=>	"Account Id",
					"fieldname"		=>	"accId1",
					"value"			=>	"12345",
					"description"	=>	"Example : 12345"
					);
	$paymethodinfo[] = array(
						"name" 		=> 'Worldpay',
						"key" 		=> 'worldpay',
						"isactive"	=>	'1', // 1->display,0->hide\
						"display_order"=>'4',
						"payOpts"	=>	$payOpts,
						);
//////////worldpay end////////
//////////2co start////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	"Vendor ID",
					"fieldname"		=>	"vendorid",
					"value"			=>	"1303908",
					"description"	=>	"Enter Vendor ID Example : 1303908"
					);
	$payOpts[] = array(
					"title"			=>	"Notify Url",
					"fieldname"		=>	"ipnfilepath",
					"value"			=>	get_option('siteurl')."/?page=notifyurl&pmethod=2co",
					"description"	=>	"Example : http://mydomain.com/2co_notifyurl.php",
					);
	$paymethodinfo[] = array(
						"name" 		=> '2CO (2Checkout)',
						"key" 		=> '2co',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'5',
						"payOpts"	=>	$payOpts,
						);
//////////2co end////////
//////////pre bank transfer start////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	"Bank Information",
					"fieldname"		=>	"bankinfo",
					"value"			=>	"ICICI Bank",
					"description"	=>	"Enter the bank name to which you want to transfer payment"
					);
	$payOpts[] = array(
					"title"			=>	"Account ID",
					"fieldname"		=>	"bank_accountid",
					"value"			=>	"AB1234567890",
					"description"	=>	"Enter your bank Account ID",
					);
	$paymethodinfo[] = array(
						"name" 		=> 'Pre Bank Transfer',
						"key" 		=> 'prebanktransfer',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'6',
						"payOpts"	=>	$payOpts,
						);				
//////////pre bank transfer end////////
//////////pay cash on devivery start////////
	$payOpts = array();
	$paymethodinfo[] = array(
						"name" 		=> 'Pay Cash On Delivery',
						"key" 		=> 'payondelevary',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'7',
						"payOpts"	=>	$payOpts,
						);
//////////pay cash on devivery end////////
for($i=0;$i<count($paymethodinfo);$i++)
{
	$payment_method_info = array();
	$payment_method_info  = get_option('payment_method_'.$paymethodinfo[$i]['key']);
	if(!$payment_method_info)
	{
		update_option('payment_method_'.$paymethodinfo[$i]['key'],$paymethodinfo[$i]);
	}
}
/////////////// PAYMENT SETTINGS END ///////////////
/////////////// SHIPPING METHIDS START /////////////// 
$shippingmethodinfo = array();
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Enable Free Shipping?",
				"fieldname"		=>	"free_shipping_amt",
				"value"			=>	"0",
				"description"	=>	"Example : shipping amt = 0 ",
				);
$payOpts = array();
$shippingmethodinfo[] = array(
					"name" 		=> 'Free Shipping',
					"key" 		=> 'free_shipping',
					"isactive"	=>	'1', // 1->display,0->hide
					"payOpts"	=>	$payOpts,
					);
///////////////////////////////////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Shipping Amount",
				"fieldname"		=>	"flat_rate_amt",
				"value"			=>	"0",
				"description"	=>	"Example : enter a value that will be added as default for shipping when someone goes throught checkout"
				);
$shippingmethodinfo[] = array(
					"name" 		=> 'Flat Rate Shipping',
					"key" 		=> 'flat_rate',
					"isactive"	=>	'0', // 1->display,0->hide
					"payOpts"	=>	$payOpts,
					);
///////////////////////////////////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Price Shipping 1",
				"fieldname"		=>	"price_shipping1",
				"value"			=>	"10->100=1",
				"description"	=>	'Example : if total price is between $10 and $100 then shipping price is $1 so the equation is -> <strong>10->100=1</strong>'
				);
$payOpts[] = array(
				"title"			=>	"Price Shipping 2",
				"fieldname"		=>	"price_shipping2",
				"value"			=>	"101->200=10",
				"description"	=>	'Example : if total price is between $101 and $200 then shipping price is $10 so the equation is -> <strong>101->200=10</strong>'
				);
$payOpts[] = array(
				"title"			=>	"Price Shipping 3",
				"fieldname"		=>	"price_shipping3",
				"value"			=>	"201->300=20",
				"description"	=>	'Example : if total price is between $201 and $300 then shipping price is $20 so the equation is -> <strong>201->300=20</strong>'
				);
$payOpts[] = array(
				"title"			=>	"Price Shipping 4",
				"fieldname"		=>	"price_shipping4",
				"value"			=>	"301->500=50",
				"description"	=>	'Example : if total price is between $301 and $500 then shipping price is $50 so the equation is -> <strong>301->500=50</strong>'
				);
$payOpts[] = array(
				"title"			=>	"Price Shipping 5",
				"fieldname"		=>	"price_shipping5",
				"value"			=>	"501->1000=60",
				"description"	=>	'Example : if total price is between $301 and $500 then shipping price is $60 so the equation is -> <strong>301->500=60</strong>'
				);
$shippingmethodinfo[] = array(
					"name" 		=> 'Price Base Shipping',
					"key" 		=> 'price_base',
					"isactive"	=>	'0', // 1->display,0->hide
					"payOpts"	=>	$payOpts,
					);
///////////////////////////////////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Weight Shipping 1",
				"fieldname"		=>	"price_shipping1",
				"value"			=>	"1->10=10",
				"description"	=>	"Example : if total weight is between 1 lbs and 10 lbs then shipping price is $10 so the equation is -> <strong>1->10=10</strong>"
				);
$payOpts[] = array(
				"title"			=>	"Weight Shipping 2",
				"fieldname"		=>	"price_shipping2",
				"value"			=>	"11->51=20",
				"description"	=>	"Example : if total weight is between 11 lbs and 51 lbs then shipping price is $20 so the equation is -> <strong>11->51=20</strong>"
				);
$payOpts[] = array(
				"title"			=>	"Weight Shipping 3",
				"fieldname"		=>	"price_shipping3",
				"value"			=>	"51->100=30",
				"description"	=>	"Example : if total weight is between 51 lbs and 100 lbs then shipping price is $30 so the equation is -> <strong>51->100=30</strong>"
				);
$payOpts[] = array(
				"title"			=>	"Weight Shipping 4",
				"fieldname"		=>	"price_shipping4",
				"value"			=>	"101->150=40",
				"description"	=>	"Example : if total weight is between 101 lbs and 150 lbs then shipping price is $40 so the equation is -> <strong>101->150=40</strong>"
				);
$payOpts[] = array(
				"title"			=>	"Weight Shipping 5",
				"fieldname"		=>	"price_shipping5",
				"value"			=>	"151->200=40",
				"description"	=>	"Example : if total weight is between 101 lbs and 150 lbs then shipping price is $40 so the equation is -> <strong>151->200=40</strong>"
				);
$shippingmethodinfo[] = array(
					"name" 		=> 'Weight Base Shipping',
					"key" 		=> 'weight_base',
					"isactive"	=>	'0', // 1->display,0->hide
					"payOpts"	=>	$payOpts,
					);
						
for($i=0;$i<count($shippingmethodinfo);$i++)
{
	$shipping_method_info = array();
	$shipping_method_info  = get_option('shipping_method_'.$shippingmethodinfo[$i]['key']);
	if(!$shipping_method_info)
	{
		update_option('shipping_method_'.$shippingmethodinfo[$i]['key'],$shippingmethodinfo[$i]);
	}
}
/////////////// SHIPPING METHIDS END ///////////////
/////////////// DISCOUNT COUPON START ///////////////
$discount_coupons = array();
$discount_coupons  = get_option('discount_coupons');
if(!$discount_coupons)
{
	$discount_coupons_arr[] = array(
						"couponcode"	=>	'friend_discount',
						"dis_per"		=>	'per',
						"dis_amt"		=>	'15',
						);
	$discount_coupons_arr[] = array(
						"couponcode"	=>	'customer_discount',
						"dis_per"		=>	'amt',
						"dis_amt"		=>	'50',
						);
	update_option('discount_coupons',$discount_coupons_arr);
}
/////////////// DISCOUNT COUPON END ///////////////
/////////////// TERMS & products START ///////////////
$category_array = array('Blog','Feature','Olive Oils','Organic Bread','Organic Food','Sugar','Tea');

$dummy_image_path = get_template_directory_uri().'/images/dummy/';

$post_array = array();
$post_author = $wpdb->get_var("SELECT ID FROM $wpdb->users order by ID asc limit 1");
$post_info = array();
$post_info[] = array(
					"post_title"	=>	'Sample Lorem Ipsum Post',
					"post_content"	=>	'What is Lorem Ipsum?<br><br>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Why do we use it?<br><br>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ‘lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
<br><br>Where does it come from?',
					);
$post_info[] = array(
					"post_title"	=>	'another sample post',
					"post_content"	=>	'What is Lorem Ipsum?<br><br>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Why do we use it?<br><br>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ‘lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
<br><br>Where does it come from?',
					);
$post_info[] = array(
					"post_title"	=>	'Sample Blog Post',
					"post_content"	=>	'orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
					);
$post_info[] = array(
					"post_title"	=>	'What is Lorem Ipsum?',
					"post_content"	=>	'What is Lorem Ipsum?<br><br>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Why do we use it?<br><br>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ‘lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
<br><br>Where does it come from?',
					);
$post_info[] = array(
					"post_title"	=>	'Letraset sheets',
					"post_content"	=>	'What is Lorem Ipsum?<br><br>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Why do we use it?<br><br>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ‘lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
<br><br>Where does it come from?',
					);
$post_info[] = array(
					"post_title"	=>	'Why do we use it?',
					"post_content"	=>	'What is Lorem Ipsum?<br><br>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Why do we use it?<br><br>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ‘lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
<br><br>Where does it come from?',
					);				
$post_array['Blog'] = $post_info;
//====================================================================================//
$post_info = array();
////product 1 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'goodforme.png',	
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '70',	
					"specialprice"			=> '50',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Good for Me',
					"post_content"	=>	'This is a wordpress post. You may display latest of your products or, use this slider to display various promotion offers, miscellaneous features or, highlight some special products. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b11.png',
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',	
					"price"					=> '400',	
					"specialprice"			=> '350',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '8',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Organic maple flakes',
					"post_content"	=>	' Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b10.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '232',	
					"specialprice"			=> '',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '12',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pure organic maple',
					"post_content"	=>	'Maple syrup goes perfectly with pancakes, and can be used to replace sugar in many sweet dishes. No other ingredient is added to the syrup. This syrup comes from the Vifranc farm, near Quebec, and is of the very highest quality. Two types of maple are used in its production, which is certified organic, and the trees come from sustainable sources.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 3 end///
////product 4 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b5.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '355',	
					"specialprice"			=> '',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Durum Couscous',
					"post_content"	=>	'Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 4 end///
////product 5 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b4.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '222',	
					"specialprice"			=> '',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Cousocous',
					"post_content"	=>	'Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 5 end///
////product 6 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b3.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '350',	
					"specialprice"			=> '',	
					"size"					=> '1,2,3,4,5',
					"color"					=> '',
					"weight"				=> '11',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Garden Peas',
					"post_content"	=>	'Dipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.

Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 6 end///
////product 6 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b13.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '350',	
					"specialprice"			=> '',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '15',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Green Beans',
					"post_content"	=>	'Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.

Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 6 end///
////product 7 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b9.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '250',	
					"specialprice"			=> '',	
					"size"					=> '1,2,3,4,5',
					"color"					=> '',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Cousocous Kamut',
					"post_content"	=>	'Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.

Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 7 end///
////product 8 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b7.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '500',	
					"specialprice"			=> '',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Gummy Jellies',
					"post_content"	=>	'Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.

Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 8 end///
////product 8 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b6.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '950',	
					"specialprice"			=> '850',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '12',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Organic Honey',
					"post_content"	=>	'Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.

Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 8 end///

$post_array['Organic Food'] = $post_info;
//====================================================================================//
////product 1 start///
$post_info = array();
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b12.png',	
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '95',	
					"specialprice"			=> '80',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '12',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Oli Ola',
					"post_content"	=>	'Two bottles, One containing the extra virgin olive oil, and the other one containing the balsamic vinegar of Modena, both linked up by an ingenious and revolutionary system, allowing you to precisely measure these two ingredients in order to make a made-to-measure dressing for your salads. Everything is possible: from 100% of vinegar to 100% of oil, through all intermediates, with a very easy system, thanks to a measured stopper! The concept is simple but clever; it has been rewarded at the famous international show of food innovation. This prize is deserved because when you try this product you definitely want to adopt it! Practical: these bottles are refillable!',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b5.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '150',	
					"specialprice"			=> '100',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '12',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Cousocous',
					"post_content"	=>	'Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b3.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '100',	
					"specialprice"			=> '70',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '12',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Garden Peas',
					"post_content"	=>	'Dipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.

Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 3 end///
////product 4 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b13.png',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '100',	
					"specialprice"			=> '70',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Green Beans',
					"post_content"	=>	'Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.

Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 4 end///
$post_array['Olive Oils'] = $post_info;
//===================================================================================//
////product 1 start///
$post_info = array();
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'goodforme.png',	
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '95',	
					"specialprice"			=> '80',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '11',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Good for Me',
					"post_content"	=>	'This is a wordpress post. You may display latest of your products or, use this slider to display various promotion offers, miscellaneous features or, highlight some special products. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b14.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '150',	
					"specialprice"			=> '100',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Guinea pepper',
					"post_content"	=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.

Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b17.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '200',	
					"specialprice"			=> '150',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '13',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Oli Ola',
					"post_content"	=>	'Two bottles, One containing the extra virgin olive oil, and the other one containing the balsamic vinegar of Modena, both linked up by an ingenious and revolutionary system, allowing you to precisely measure these two ingredients in order to make a made-to-measure dressing for your salads. Everything is possible: from 100% of vinegar to 100% of oil, through all intermediates, with a very easy system, thanks to a measured stopper! The concept is simple but clever; it has been rewarded at the famous international show of food innovation. This prize is deserved because when you try this product you definitely want to adopt it! Practical: these bottles are refillable!',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 3 end///
////product 4 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b11.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '100',	
					"specialprice"			=> '60',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '12',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Organic maple flakes',
					"post_content"	=>	'Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 4 end///
////product 5 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b10.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '100',	
					"specialprice"			=> '60',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '12',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pure organic maple',
					"post_content"	=>	'Maple syrup goes perfectly with pancakes, and can be used to replace sugar in many sweet dishes. No other ingredient is added to the syrup. This syrup comes from the Vifranc farm, near Quebec, and is of the very highest quality. Two types of maple are used in its production, which is certified organic, and the trees come from sustainable sources.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 5 end///
////product 6 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'p_b7.png',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '100',	
					"specialprice"			=> '60',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Gummy Jellies',
					"post_content"	=>	'Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.

Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 6 end///
$post_array['Organic Bread'] = $post_info;
//==========================================================================================================//
////product 1 start///
$post_info = array();
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'lajawab_sugar_big.jpg',	
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '10',	
					"specialprice"			=> '7',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'La Jawab Sugar',
					"post_content"	=>	'Be it the yummy kheer or the steaming hot halwa, relish them  all with the heavenly sweetness of La Jawab sugar. It is made from Khandesh (meaning land of sugar), which is  the heartland of sugar cane. Great care is taken to ensure that La Jawab sugar is hygienically packed and vacuum sealed so that every sugar crystal remains moisture free.
					<table class="table2" border="0" cellspacing="2" cellpadding="2" >
					<tr >
					<td colspan="3" height="28" align="center"><strong>Packaging</strong></td>
					</tr>
					<tr>
					<td width="24%" align="center"><strong>SKU</strong></td>
					<td width="49%" align="center"></td>
					<td width="27%" align="center"></td>
					</tr>
					<tr>
					<td align="center">1kg</td>
					<td align="center">Pouch</td>
					<td align="center"></td>
					</tr>
					<tr>
					<td align="center">500g</td>
					<td align="center">Pouch</td>
					<td align="center"></td>
					</tr>
					<tr>
					<td align="center">250g</td>
					<td align="center">Pouch</td>
					<td align="center"></td>
					</tr>
					</table>',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 1 end///
$post_array['Sugar'] = $post_info;
//=====================================================================================//
////product 1 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'lajawab.jpg',	
					"productimage1"			=> $dummy_image_path.'j9_big.gif',		
					"productimage2"			=> $dummy_image_path.'j9.jpg',		
					"productimage3"			=> $dummy_image_path.'lajawab1.jpg',		
					"productimage4"			=> $dummy_image_path.'lajawabtea.jpg',		
					"productimage5"			=> $dummy_image_path.'lajawab.jpg',		
					"productimage6"			=> $dummy_image_path.'j9.jpg',		
					"price"					=> '70',	
					"specialprice"			=> '50',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'La Jawab Tea',
					"post_content"	=>	'La Jawab Tea is made from leaves plucked from the finest tea estates of south India. Each leaf of tea is carefully picked to create a special blend that’s just perfect for the UAE and gulf market.

Its exotic taste, great aroma and good liquor, together make it a tea which truly lives up to its name.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'anokhi_big.jpg',
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',	
					"price"					=> '70',	
					"specialprice"			=> '49',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Anokhi',
					"post_content"	=>	'Anokhi is the tea for the common man who overcomes even the toughest of hardships with a great strength of character. The strong taste of Anokhi tea truly makes it the Chai Jo Josh Jagaye.
Favoured by the masses for its economic pricing, Anokhi tea is made from leaves plucked from the tea gardens of Assam, Nilgiri and Dooars.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'j9_big.gif',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '60',	
					"specialprice"			=> '45',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Jivraj 9 Tea',
					"post_content"	=>	'Tea is an integral part of our lives as, with each sip, it helps up to start a day full of new hopes. It is this very spirit that defines Jivraj 9 tea, making it the most popular product from the house of Jivraj.

					Jivraj 9 is a C.T.C. tea made from leaves that are carefully plucked from upper Assam tea estates and packed under strict hygienic conditions. Its golden yellow colour and strong aroma epitomizes the courage that’s needed to pursue our dreams. This makes Jivraj 9, a true “Sangharsh Ka Saathi”.
					
					Jivraj 9 tea is also available in dust pouch and tea bags  that facilitate quick brewing.
					<table border="0" cellspacing="2" cellpadding="2" width="100%" class="table2">
					<tbody>
					<tr>
					<td colspan="3" height="28" align="center">Packaging</td>
					</tr>
					<tr>
					<td width="24%" align="center"><strong>SKU</strong></td>
					<td width="49%" align="center"><strong>Leaf</strong></td>
					<td width="27%" align="center"><strong>Dust</strong></td>
					</tr>
					<tr>
					<td align="center">1kg</td>
					<td align="center">Box Pack/Pouch</td>
					<td align="center">Pouch</td>
					</tr>
					<tr>
					<td align="center">500g</td>
					<td align="center">Box Pack/Pouch</td>
					<td align="center">Pouch</td>
					</tr>
					<tr>
					<td align="center">250g</td>
					<td align="center">Box Pack/Pouch</td>
					<td align="center">Pouch</td>
					</tr>
					<tr>
					<td align="center">100g</td>
					<td align="center">Pouch</td>
					<td align="center">Pouch</td>
					</tr>
					<tr>
					<td align="center">50g</td>
					<td align="center">Pouch</td>
					<td align="center">Pouch</td>
					</tr>
					<tr>
					<td align="center">25g</td>
					<td align="center">Pouch</td>
					<td align="center">-</td>
					</tr>
					<tr>
					<td align="center">10g/Rs.2</td>
					<td align="center">Pouch</td>
					<td align="center">-</td>
					</tr>
					<tr>
					<td align="center">5g/Rs.1</td>
					<td align="center">Pouch</td>
					<td align="center">-</td>
					</tr>
					<tr>
					<td colspan="3" align="center"></td>
					</tr>
					</tbody></table>
					<table border="0" cellspacing="2" cellpadding="2" width="100%">
					<tbody>
					<tr>
					<td colspan="2" height="28" align="center"><span>For export </span></td>
					</tr>
					<tr>
					<td width="40%" align="center">908g (2lbe)</td>
					<td width="60%" align="center">Box Pack</td>
					</tr>
					<tr>
					<td align="center">454g (1lbe)</td>
					<td align="center">Box Pack</td>
					</tr>
					<tr>
					<td colspan="2" align="center"></td>
					</tr>
					</tbody></table>
					<table border="0" cellspacing="2" cellpadding="2" width="100%">
					<tbody>
					<tr>
					<td colspan="2" height="28" align="center"><span>Tea Bags </span></td>
					</tr>
					<tr>
					<td width="23%" align="center">200g</td>
					<td width="77%" align="center">Box Pack (100 teabags x 2g)</td>
					</tr>
					<tr>
					<td align="center">50g</td>
					<td align="center">Box Pack (25 teabags x 2g)</td>
					</tr>
					</tbody></table>',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 3 end///
////product 4 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'j9_big.gif',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '60',	
					"specialprice"			=> '45',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'J9 Tea',
					"post_content"	=>	'For the real tea lovers, the first cup of the day is very special. This is why are very particular about what goes into every pack of premium original J9 tea.
					J9 tea is the finest Assam orthodox C.T.C. leaf tea which gives you the best aroma and full bodied strength.
					Each leaf is carefully picked from Assam tea gardens during summer the perfect time to pluck. Its rich deep golden yellow colour gives you the finest way to relax and “Unwind”.
					<table border="0" cellspacing="2" cellpadding="2" width="100%" class="table2" >
					 <tr>
					<td colspan="2" height="28" align="center"><span>Packaging</span></td>
					</tr>
					<tr>
					<td width="40%" align="center"><strong>SKU</strong></td>
					<td width="60%" align="center"><strong>Leaf</strong></td>
					</tr>
					<tr>
					<td align="center">500g</td>
					<td align="center">Box Pack</td>
					</tr>
					<tr>
					<td align="center">250g</td>
					<td align="center">Box Pack</td>
					</tr>
					<tr>
					<td colspan="2" height="5" align="center"></td>
					</tr>
					</table>',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 4 end///
////product 5 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'j9_green_big.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '60',	
					"specialprice"			=> '45',	
					"size"					=> 'small,mideum,laarge',
					"color"					=> 'golden,silver,white',
					"weight"				=> '10',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'J9 green tea ',
					"post_content"	=>	'J9 green tea is just the thing for those health conscious people who’re looking for an effective and refreshing way to stay fit. Every leaf of J9 green tea has been thoughtfully picked, keeping your well-being in mind.

J9 green tea gives you a mild tasting, fresh cup of golden tea. It has high levels of anti-oxidants and is considered and is considered an ideal drink after meals.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 5 end///
$post_array['Tea'] = $post_info;
//===============================================================================//

$feature_cat_name = 'Feature';
for($c=0;$c<count($category_array);$c++)
{
	$feature_cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name=\"$feature_cat_name\"");
	$cat_name = $category_array[$c];
	if(is_array($cat_name))
	{
		$parent_cat_id = '0';
		$cat_name_arr = $cat_name;
		for($i=0;$i<count($cat_name_arr);$i++)
		{
			$cat_id = '';
			$cat_name = $cat_name_arr[$i];
			$cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name=\"$cat_name\"");
			if($cat_id=='')
			{
				$srch_arr = array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_');
				$replace_arr = array('','','','','','','','','','','','','','','','','','','','',',','','');
				$slug = str_replace($srch_arr,$replace_arr,$cat_name);
				$cat_sql = "insert into $wpdb->terms (name,slug) values (\"$cat_name\",\"$slug\")";
				$wpdb->query($cat_sql);
				$last_cat_id = $wpdb->get_var("SELECT max(term_id) FROM $wpdb->terms");
				$cat_id  = $last_cat_id;
				$count = count($post_array[$cat_name]);
				$tt_sql = "insert into $wpdb->term_taxonomy (term_id,taxonomy,parent,count) values (\"$last_cat_id\",'category',\"$parent_cat_id\",\"$count\")";
				$wpdb->query($tt_sql);
				$last_tt_id = $wpdb->get_var("SELECT max(term_taxonomy_id) FROM $wpdb->term_taxonomy");
				if($post_array[$cat_name])
				{
					$post_info_arr = $post_array[$cat_name];
					if(count($post_info_arr)>0)
					{
						for($p=0;$p<count($post_info_arr);$p++)
						{
							$post_title = $post_info_arr[$p]['post_title'];
							$post_content = $post_info_arr[$p]['post_content'];
							$post_date = date('Y-m-d H:s:i');
							$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
							$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name like \"$post_name%\"");
							if($post_name_count>0)
							{
								$post_name = $post_name.'-'.($post_name_count+1);
							}
							$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_content,post_title,post_name) values (\"$post_author\", \"$post_date\", \"$post_date\", \"$post_content\", \"$post_title\", \"$post_name\")";
							$wpdb->query($post_sql);
							$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
							$guid = get_option('siteurl')."/?p=$last_post_id";
							$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
							$wpdb->query($guid_sql);
							update_post_meta( $last_post_id, 'key', $post_info_arr[$p]['post_meta'] );
							update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
							$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
							$wpdb->query($ter_relation_sql);
							$post_feature = $post_info_arr[$p]['post_feature'];
							if($post_feature && $feature_cat_id)
							{
								$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$feature_cat_id\")";
								$wpdb->query($ter_relation_sql);
								$tt_update_sql = "update $wpdb->term_taxonomy set count=count+1 where term_id=\"$feature_cat_id\"";
								$wpdb->query($tt_update_sql);
							}
						}
					}
				}				
			}else
			{
				$last_cat_id = $cat_id;
				$count = count($post_array[$cat_name]);
				$last_tt_id = $wpdb->get_var("SELECT tt.term_taxonomy_id FROM $wpdb->term_taxonomy tt where tt.term_id=\"$last_cat_id\" and tt.taxonomy='category'");
				if($post_array[$cat_name])
				{
					$post_info_arr = $post_array[$cat_name];
					if(count($post_info_arr)>0)
					{
						for($p=0;$p<count($post_info_arr);$p++)
						{
							$post_title = $post_info_arr[$p]['post_title'];
							$post_content = $post_info_arr[$p]['post_content'];
							$post_date = date('Y-m-d H:s:i');
							$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
							$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name like \"$post_name%\"");
							if($post_name_count>0)
							{
								$post_name = $post_name.'-'.($post_name_count+1);
							}
							$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_content,post_title,post_name) values (\"$post_author\", \"$post_date\", \"$post_date\", \"$post_content\", \"$post_title\", \"$post_name\")";
							$wpdb->query($post_sql);
							$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
							$guid = get_option('siteurl')."/?p=$last_post_id";
							$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
							$wpdb->query($guid_sql);
							update_post_meta( $last_post_id, 'key', $post_info_arr[$p]['post_meta'] );
							update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
							$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
							$wpdb->query($ter_relation_sql);
							$post_feature = $post_info_arr[$p]['post_feature'];
							if($post_feature && $feature_cat_id)
							{
								$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$feature_cat_id\")";
								$wpdb->query($ter_relation_sql);
								$tt_update_sql = "update $wpdb->term_taxonomy set count=count+1 where term_id=\"$feature_cat_id\"";
								$wpdb->query($tt_update_sql);
							}
						}
					}
				}
				$tt_update_sql = "update $wpdb->term_taxonomy set count=count+$count where term_id=\"$last_cat_id\"";
				$wpdb->query($tt_update_sql);
			}
			if($i==0)
			{
				$parent_cat_id = $last_cat_id;
			}
		}
	}else
	{
		$cat_id = '';
		$cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name=\"$cat_name\"");
		if($cat_id=='')
		{
			$srch_arr = array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_');
				$replace_arr = array('','','','','','','','','','','','','','','','','','','','',',','','');
			$slug = str_replace($srch_arr,$replace_arr,$cat_name);
			$cat_sql = "insert into $wpdb->terms (name,slug) values (\"$cat_name\",\"$slug\")";
			$wpdb->query($cat_sql);
			$last_cat_id = $wpdb->get_var("SELECT max(term_id) FROM $wpdb->terms");
			$count = count($post_array[$cat_name]);
			$parent_cat_id = 0;
			$tt_sql = "insert into $wpdb->term_taxonomy (term_id,taxonomy,parent,count) values (\"$last_cat_id\",'category',\"$parent_cat_id\",\"$count\")";
			$wpdb->query($tt_sql);
			$last_tt_id = $wpdb->get_var("SELECT max(term_taxonomy_id) FROM $wpdb->term_taxonomy");
			if($post_array[$cat_name])
			{
				$post_info_arr = $post_array[$cat_name];
				if(count($post_info_arr)>0)
				{
					for($p=0;$p<count($post_info_arr);$p++)
					{
						$post_title = $post_info_arr[$p]['post_title'];
						$post_content = $post_info_arr[$p]['post_content'];
						$post_date = date('Y-m-d H:s:i');
						$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
						$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name like \"$post_name%\"");
						if($post_name_count>0)
						{
							$post_name = $post_name.'-'.($post_name_count+1);
						}
						$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_content,post_title,post_name) values (\"$post_author\", \"$post_date\", \"$post_date\", \"$post_content\", \"$post_title\", \"$post_name\")";
						$wpdb->query($post_sql);
						$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
						$guid = get_option('siteurl')."/?p=$last_post_id";
						$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
						$wpdb->query($guid_sql);
						update_post_meta( $last_post_id, 'key', $post_info_arr[$p]['post_meta'] );
						update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
						$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
						$wpdb->query($ter_relation_sql);
						$feature_cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name=\"$feature_cat_name\"");
						$post_feature = $post_info_arr[$p]['post_feature'];
						if($post_feature && $feature_cat_id)
						{
							$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$feature_cat_id\")";
							$wpdb->query($ter_relation_sql);
							$tt_update_sql = "update $wpdb->term_taxonomy set count=count+1 where term_id=\"$feature_cat_id\"";
							$wpdb->query($tt_update_sql);
						}
					}
				}
			}	
		}else
		{
			$last_cat_id = $cat_id;
			$count = count($post_array[$cat_name]);
			$tt_update_sql = "update $wpdb->term_taxonomy set count=count+$count where term_id=\"$last_cat_id\"";
			$wpdb->query($tt_update_sql);
			$last_tt_id = $wpdb->get_var("SELECT tt.term_taxonomy_id FROM $wpdb->term_taxonomy tt where tt.term_id=\"$last_cat_id\" and tt.taxonomy='category'");
			if($post_array[$cat_name])
			{
				$post_info_arr = $post_array[$cat_name];
				if(count($post_info_arr)>0)
				{
					for($p=0;$p<count($post_info_arr);$p++)
					{
						$post_title = $post_info_arr[$p]['post_title'];
						$post_content = $post_info_arr[$p]['post_content'];
						$post_date = date('Y-m-d H:s:i');
						$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
						$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name like \"$post_name%\"");
						if($post_name_count>0)
						{
							$post_name = $post_name.'-'.($post_name_count+1);
						}
						$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_content,post_title,post_name) values (\"$post_author\", \"$post_date\", \"$post_date\", \"$post_content\", \"$post_title\", \"$post_name\")";
						$wpdb->query($post_sql);
						$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
						$guid = get_option('siteurl')."/?p=$last_post_id";
						$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
						$wpdb->query($guid_sql);
						update_post_meta( $last_post_id, 'key', $post_info_arr[$p]['post_meta'] );
						update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
						$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
						$wpdb->query($ter_relation_sql);
						$post_feature = $post_info_arr[$p]['post_feature'];
						$feature_cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name=\"$feature_cat_name\"");
						if($post_feature && $feature_cat_id)
						{
							$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$feature_cat_id\")";
							$wpdb->query($ter_relation_sql);
							$tt_update_sql = "update $wpdb->term_taxonomy set count=count+1 where term_id=\"$feature_cat_id\"";
							$wpdb->query($tt_update_sql);
						}
					}
				}
			}
		}
	}
}
/////////////// TERMS END ///////////////
/////////////// Design Settings START ///////////////
$blog_cat_name = 'Blog';
$blog_cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name=\"$blog_cat_name\"");
update_option("cat_exclude_$blog_cat_id",$blog_cat_id);
update_option("ptthemes_breadcrumbs",'true');
update_option("ptthemes_add_to_cart_button_position",'Below Description');
update_option("ptthemes_size_chart",'<img src="'.$dummy_image_path.'size_chart.png" alt="" >');
update_option("ptthemes_feed_name",'Templatic');
update_option("ptthemes_feed_url",'http://feeds.feedburner.com/Templatic');
update_option("ptthemes_feedburner_url",'http://feeds.feedburner.com/Templatic');
/////////////// Design Settings END ///////////////
/////////////// WIDGET SETTINGS START ///////////////
$feature_cat_name = 'Feature';
$feature_cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name=\"$feature_cat_name\"");

//print_r(get_option('widget_widget_text'));
$home_slider_info[1] = array(
					"title"				=>	'Slider',
					"category"			=>	$feature_cat_id,
					"post_number"		=>	'5',
					"post_link"			=>	'',
					);
$home_slider_info['_multiwidget'] = '1';

update_option('widget_widget_posts1',$home_slider_info);
$home_slider_widget_info = get_option('widget_widget_posts1');
krsort($home_slider_widget_info);
foreach($home_slider_widget_info as $key1=>$val1)
{
	$home_slider_widget_info_key = $key1;
	if(is_int($home_slider_widget_info_key))
	{
		break;
	}
}
		
$home_banner_info[1] = array(
					"title"			=>	'',
					"advt1"			=>	$dummy_image_path.'special_offer.png',
					"advt_link1"	=>	'http://www.templatic.com',
					"advt2"			=>	'',
					"advt_link2"	=>	'',
					);
$home_banner_info['_multiwidget'] = '1';

update_option('widget_widget_text',$home_banner_info);
$home_banner_widget_info = get_option('widget_widget_text');
krsort($home_banner_widget_info);
foreach($home_banner_widget_info as $key=>$val)
{
	$home_banner_widget_info_key = $key;
	if(is_int($home_banner_widget_info_key))
	{
		break;
	}
}
////widget 3 start//
$subscribe_info = array(
					"title"			=>	'Subscribe',
					"id"			=>	'templatic/eKPs',
					"text"			=>	'If you\'d like to stay updated with all our latest news please enter your e-mail address here ',
					);
$subscribe_info['_multiwidget'] = '1';
update_option('widget_subscribewidget',$subscribe_info);
$subscribe_info = get_option('widget_subscribewidget');
krsort($subscribe_info);
foreach($subscribe_info as $key=>$val)
{
	$subscribe_info_key = $key;
	if(is_int($subscribe_info_key))
	{
		break;
	}
}
////widget 3 end//
$sidebars_widgets = get_option('sidebars_widgets');
$sidebars_widgets["sidebar-3"] = array('widget_posts1-'.$home_slider_widget_info_key);
$sidebars_widgets["sidebar-4"] = array('widget_text-'.$home_banner_widget_info_key);
$sidebars_widgets["sidebar-2"] = array('pt-subscribe');
update_option('sidebars_widgets',$sidebars_widgets);
//echo "<pre>";
//print_r(get_option('sidebars_widgets'));
//print_r(get_option('widget_widget_posts1'));
//print_r(get_option('widget_widget_text'));
/////////////// WIDGET SETTINGS END ///////////////
?>