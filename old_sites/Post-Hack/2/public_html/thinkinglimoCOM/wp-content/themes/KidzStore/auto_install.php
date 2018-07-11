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
	$paymethodinfo = array();
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
						"dis_amt"		=>	'100',
						);
	update_option('discount_coupons',$discount_coupons_arr);
}
/////////////// DISCOUNT COUPON END ///////////////
/////////////// TERMS & products START ///////////////
$category_array = array('Blog','Feature',array('Baby','Baby Girls Bottoms'),'Baby Girls Dresses',array('Baby Girls Footwear','Babygrows & Vests','Girls Bottoms','Girls Coats'),array('Girls Dresses','Girls Footwear','Girls Tops'));

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
					"productimage"			=> $dummy_image_path.'baby_bottom1.jpg',	
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '22',	
					"specialprice"			=> '18',	
					"size"					=> '12month,16month,18month',
					"color"					=> 'Red, Black, Blue, Yellow',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Frill Skirt Denim',
					"post_content"	=>	'How western can little girls get?! This denim skirt fits snug & then kicks out into a cotton lined frill. The frills are an orange, red & navy check. They make this pretty denim skirt feminine that really has the fashion edge! The 6 month - 2 years sizes of the skirt comes with navy cotton knickers to fit over babies nappies. Tommy have every base covered with this cute skirt. Team with the Davina blouse to bring out the orange in the check!',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_bottom2.jpg',
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',	
					"price"					=> '34',	
					"specialprice"			=> '30',	
					"size"					=> '12month,16month',
					"color"					=> 'Pink, Purple, Yellow',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Baby Pettiskirt',
					"post_content"	=>	'How western can little girls get?! This denim skirt fits snug & then kicks out into a cotton lined frill. The frills are an orange, red & navy check. They make this pretty denim skirt feminine that really has the fashion edge! The 6 month - 2 years sizes of the skirt comes with navy cotton knickers to fit over babies nappies. Tommy have every base covered with this cute skirt. Team with the Davina blouse to bring out the orange in the check!',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_bottom3.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '50',	
					"specialprice"			=> '40',	
					"size"					=> '12month,16month',
					"color"					=> 'Red, Black',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Daisy Baby Pettiskirt',
					"post_content"	=>	'How western can little girls get?! This denim skirt fits snug & then kicks out into a cotton lined frill. The frills are an orange, red & navy check. They make this pretty denim skirt feminine that really has the fashion edge! The 6 month - 2 years sizes of the skirt comes with navy cotton knickers to fit over babies nappies. Tommy have every base covered with this cute skirt. Team with the Davina blouse to bring out the orange in the check!',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 3 end///
////product 4 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_bottom4.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '50',	
					"specialprice"			=> '45',	
					"size"					=> '12month,16month',
					"color"					=> 'Black, Red',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pants In Pink Stripes',
					"post_content"	=>	'These have a great shape and cater to the baby who is bored of regular jersey trousers! They have an Aladdin feel, but are certainly not costume; for an every day cotton jersey trouser, these have style. The pinks, greens & charcoals all mix together to create a riot of colour, perfect for this Autumn Winter & beyond! Wash at 40 degrees & iron on reverse.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 4 end///
////product 5 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_bottom5.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '60',	
					"specialprice"			=> '50',	
					"size"					=> '12month,16month,18month',
					"color"					=> 'Pink, Purple, Yellow',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pants in baby pink',
					"post_content"	=>	'These trousers have a great shape and cater to the baby who is bored of regular jersey trousers! They have an Aladdin feel, but are certainly not costume; for an every day jersey trouser, these have such style.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 5 end///
////product 6 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_bottom6.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '35',	
					"specialprice"			=> '30',	
					"size"					=> '12month,16month,18month',
					"color"					=> 'Red, Black',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pants in red',
					"post_content"	=>	'These trousers have a great shape and cater to the baby who is bored of regular jersey trousers! They have an Aladdin feel, but are certainly not costume; for an every day jersey trouser, these have such style.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 6 end///
////product 6 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_bottom7.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '50',	
					"specialprice"			=> '35',	
					"size"					=> '12month,16month,18month,22month',
					"color"					=> 'Pink, Purple, Yellow',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pants in navy',
					"post_content"	=>	'These trousers have a great shape and cater to the baby who is bored of regular jersey trousers! They have an Aladdin feel, but are certainly not costume; for an every day jersey trouser, these have such style.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 6 end///
////product 7 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_bottom8.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '45',	
					"specialprice"			=> '30',	
					"size"					=> '12month,16month,18month,22month',
					"color"					=> 'Red, Black',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pants In Blue Stripes',
					"post_content"	=>	'These have a great shape and cater to the baby who is bored of regular jersey trousers! They have an Aladdin feel, but are certainly not costume; for an every day cotton jersey trouser, these have style. In smart new season blue colours these stripy trousers make you smile whatever the weather! Wash at 40 degrees & iron on reverse.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 7 end///
////product 8 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_bottom9.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '50',	
					"specialprice"			=> '40',	
					"size"					=> '12month,16month,22month',
					"color"					=> 'Red, Black',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pale Pink & White',
					"post_content"	=>	'Cool bottoms to compliment all cool tops. Elasticated waist for comfort and easy changing. 100% luxury cotton and machine washable. Made in England.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 8 end///
////product 8 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_bottom10.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '65',	
					"specialprice"			=> '50',	
					"size"					=> '12month,16month,22month',
					"color"					=> 'Red, Black, Pink, Purple, Yellow',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Snuglo Striped Trousers',
					"post_content"	=>	'Cool bottoms to compliment all cool tops. Elasticated waist for comfort and easy changing. 100% luxury cotton and machine washable. Made in England.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	1,
					);
////product 8 end///

$post_array['Baby Girls Bottoms'] = $post_info;
//====================================================================================//
////product 1 start///
$post_info = array();
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_dress3.jpg',	
					"productimage1"			=> $dummy_image_path.'baby_dress2.jpg',		
					"productimage2"			=> $dummy_image_path.'baby_dress1.jpg',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '95',	
					"specialprice"			=> '80',	
					"size"					=> '16months,18months,22months,24months',
					"color"					=> 'RED,BLACK,WHITE',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Dress In Orange Spots',
					"post_content"	=>	'Molo makes fab baby clothes for boys and girls straight from Denmark! The quirky designs are designed so that children can express their creativity through their clothing and gain confidence & self esteem. Thats not bad when they are wrapped in unique and fun quirky baby clothing. The quality is unrivaled, the stretchy cotton pieces are finished with a contrast stitching, collars & cuffs that always show case their funky stripes and stars in the best way. Whether you like the pyjamas, that can be split and worn as separates in the daytime if you prefer, or the baby-grows, you are guaranteed that your baby will stand out from the crowd! The dresses are great teamed over contrasting stripy trousers or simply with warm tights!',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_dress7.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '80',	
					"specialprice"			=> '60',	
					"size"					=> '18months,22months',
					"color"					=> 'pink,orange,blue,white',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Striped Dress',
					"post_content"	=>	'Lilli Belle is 100% Merino Wool & as soft as cashmere. The delicate striped dress is available in baby pink & grey marl or baby blue & grey marl. The long sleeved dress ties with a bowed belt around the middle & looks great worn over the Poppy & Ned Merino Leggings or jeans respectively. The snuggly knit is super soft on skin & merino wool is hypo-allergenic.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Striped,Dress',
					"post_feature"	=>	0,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_dress6.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '100',	
					"specialprice"			=> '70',	
					"size"					=> '18months,20months,22months',
					"color"					=> 'pink,orange,blue,white',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Dress in Aqua',
					"post_content"	=>	'100% cotton bright colour fashion for babies. This simple jersey dress is a great basic for summer. Team it with the co-ordinating Limo B nappy pants for a total colour burst!',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Aqua,Dress',
					"post_feature"	=>	0,
					);
////product 3 end///
////product 4 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_dress8.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '100',	
					"specialprice"			=> '70',	
					"size"					=> '',
					"color"					=> 'pink,chocolate,sky blue,red',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Dress in Pink',
					"post_content"	=>	'This 100% merino wool mini dress from Poppy & Ned has a distinctive 60’s feel. The turtle neck, short sleeved dress has concealed pockets on the front of the dress and is a slim fitting stylish dress. The Bo Mini dress looks fab when teamed with the Poppy & Ned Merino Leggings.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Dress',
					"post_feature"	=>	0,
					);
////product 4 end///
////product 5 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_dress9.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '95',	
					"specialprice"			=> '70',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'blue,red,pink,white,black',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Poppy & Ned Velve',
					"post_content"	=>	'This little girls party dress from Poppy and Ned is perfect for the Christmas season. Made from a beautiful velvet the full skirted dress is finished off with a sash bow lined in dark red satin. The petticoat of the skirt is net lines, so the skirt is perfect for twirling around, all finished off with a white broiderie lace trim. The little puff sleeves give the dress a fairy-tale feel that is perfect for special occasions or Christmas day!',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Poppy,Dress',
					"post_feature"	=>	1,
					);
////product 5 end///
$post_array['Baby Girls Dresses'] = $post_info;
//===================================================================================//
////product 1 start///
$post_info = array();
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_footwear1.jpg',	
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '105',	
					"specialprice"			=> '60',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Red,Black,White',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Ballerina Shoe',
					"post_content"	=>	'These gorgeous little ballerina pumps from Baby Bloch are made in the softest patent leather. The ballerinas with leather sole, cotton lining and cotton strap to keep on babies feet! Expertly crafted for comfort, style, and the protection of your baby’s feet, the elasticated bow that ties at the toe can be pulled to tighten the shoe. Packaged in a box, perfect as a newborn gift by world famous ballerina shoes designer Bloch. Shoe length: newborn = 10.5 cm = size 0.5. 0-6 months = 11.5 cm = size 1. 6-12 months = 12.5 cm = size 2. 12-18 months = 13.5 cm = size 4. 18-24 months = 15 cm = size 4.5.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Shoe',
					"post_feature"	=>	0,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_footwear2.jpg',
					"productimage1"			=> $dummy_image_path.'baby_footwear5.jpg',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '100',	
					"specialprice"			=> '80',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pumps In Pink',
					"post_content"	=>	'These gorgeous little ballerina pumps from Baby Bloch are made in the softest suede. These tiny shoes feature a delicate polka dot design that is punched into the suede surface, feminine and fashion conscious at such a young age! The ballerinas with leather sole, cotton lining and cotton strap to keep on babies feet! Expertly crafted for comfort, style, and the protection of your baby’s feet, the elasticated bow that ties at the toe can be pulled to tighten the shoe. Packaged in a box, perfect as a newborn gift by world famous ballerina shoes designer Bloch. Shoe length: newborn = 10.5 cm = size 0.5. 0-6 months = 11.5 cm = size 1. 6-12 months = 12.5 cm = size 2. 12-18 months = 13.5 cm = size 4. 18-24 months = 15 cm = size 4.5.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Shoe',
					"post_feature"	=>	1,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_footwear3.jpg',
					"productimage1"			=> $dummy_image_path.'baby_footwear4.jpg',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '80',	
					"specialprice"			=> '60',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Leather Ballerina',
					"post_content"	=>	'These gorgeous little ballerina pumps from Baby Bloch are made in the softest patent leather. These tiny shoes feature a pink ruffled frill that runs across the toes of the pump, feminine and fashion conscious at such a young age! The ballerinas with leather sole, cotton lining and cotton strap to keep on babies feet! Expertly crafted for comfort, style, and the protection of your baby’s feet, the elasticated bow that ties at the toe can be pulled to tighten the shoe. Packaged in a box, perfect as a newborn gift by world famous ballerina shoes designer Bloch. Shoe length: newborn = 10.5 cm = size 0.5. 0-6 months = 11.5 cm = size 1. 6-12 months = 12.5 cm = size 2. 12-18 months = 13.5 cm = size 4. 18-24 months = 15 cm = size 4.5.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Leather,Shoe',
					"post_feature"	=>	0,
					);
////product 3 end///
////product 4 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_footwear6.jpg',
					"productimage1"			=> $dummy_image_path.'baby_footwear7.jpg',	
					"productimage2"			=> $dummy_image_path.'baby_footwear8.jpg',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '100',	
					"specialprice"			=> '60',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Milly Patent Ballerina',
					"post_content"	=>	'These gorgeous little ballerina pumps from Baby Bloch are made in the softest patent leather. The ballerinas with leather sole, cotton lining and cotton strap to keep on babies feet! Expertly crafted for comfort, style, and the protection of your baby’s feet, the elasticated bow that ties at the toe can be pulled to tighten the shoe. Packaged in a box, perfect as a newborn gift by world famous ballerina shoes designer Bloch. Shoe length: newborn = 10.5 cm = size 0.5. 0-6 months = 11.5 cm = size 1. 6-12 months = 12.5 cm = size 2. 12-18 months = 13.5 cm = size 4. 18-24 months = 15 cm = size 4.5.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Shoe',
					"post_feature"	=>	0,
					);
////product 4 end///
$post_array['Girls Footwear'] = $post_info;
//==========================================================================================================//
////product 1 start///
$post_info = array();
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'Babygrows_Vests2.jpg',	
					"productimage1"			=> $dummy_image_path.'Babygrows_Vests3.jpg',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '50',	
					"specialprice"			=> '40',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Booties In Blue',
					"post_content"	=>	'<p>These baby grows from Absorba Premier Jours collection are perfect for little babies first days. This baby grow is made from the softest French cotton. The baby grow has little booties that attach to the baby grow so that you don’t loose them! As your baby grows, you can remove the booties and replace them with socks, to prolong the time that your baby wears this adorable suit. The design on the front is of 3 little teddy bears. The baby grow looks perfect teamed with the 2 way brasserie by Premier Jours. Machine wash at 30 degrees.</p>
<p>The Absorba range fits on the small side. The premature size fits a baby of around 4-5llbs. The newborn size fits a baby of around 7llbs. The 1 month size fits a baby of around 9llbs. The 3 month size usually fits by 2 months. The 6 month size usually fits by 4 months.</p>',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'grows',
					"post_feature"	=>	0,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'Babygrows_Vests4.jpg',	
					"productimage1"			=> $dummy_image_path.'Babygrows_Vests3.jpg',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '50',	
					"specialprice"			=> '40',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Rabbit Babygrow In Blue',
					"post_content"	=>	'<p>These baby grows from Absorba Premier Jours collection are perfect for little babies first days. This baby grow is made from the softest French cotton. The baby grow has a gorgeous all over rabbit print. The baby grow looks perfect teamed with the 2 way brasserie by Premier Jours. Machine wash at 30 degrees.</p>
<p>The Absorba range fits on the small side. The premature size fits a baby of around 4-5llbs. The newborn size fits a baby of around 7llbs. The 1 month size fits a baby of around 9llbs. The 3 month size usually fits by 2 months. The 6 month size usually fits by 4 months.</p>',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'Babygrows_Vests5.jpg',	
					"productimage1"			=> $dummy_image_path.'Babygrows_Vests6.jpg',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '50',	
					"specialprice"			=> '40',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Premier Jours',
					"post_content"	=>	'<p>These baby grows from Absorba Premier Jours collection are perfect for little babies first days. These baby dungarees & matching jacket are made from the softest French cotton. The dungarees are striped and look great layered over a simple vest. The matching jacket is double thickness & layers over the dungarees for extra warmth & style! The outfit features a little footprint design. Machine wash at 30 degrees.</p><p>The Absorba range fits on the small side. The premature size fits a baby of around 4-5llbs. The newborn size fits a baby of around 7llbs. The 1 month size fits a baby of around 9llbs. The 3 month size usually fits by 2 months. The 6 month size usually fits by 4 months.</p>',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 3 end///
////product 4 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'Babygrows_Vests7.jpg',	
					"productimage1"			=> $dummy_image_path.'Babygrows_Vests8.jpg',		
					"productimage2"			=> $dummy_image_path.'Babygrows_Vests9.jpg',
					"productimage3"			=> $dummy_image_path.'Babygrows_Vests10.jpg',	
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '50',	
					"specialprice"			=> '40',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Absorba Baby Set',
					"post_content"	=>	'<p>These baby grows from Absorba Premier Jours collection are perfect for little babies first days. These baby dungarees & matching jacket are made from the softest French cotton. The dungarees are striped and look great layered over a simple vest. The matching jacket is double thickness & layers over the dungarees for extra warmth & style! The outfit features a little footprint design. Machine wash at 30 degrees.</p><p>The Absorba range fits on the small side. The premature size fits a baby of around 4-5llbs. The newborn size fits a baby of around 7llbs. The 1 month size fits a baby of around 9llbs. The 3 month size usually fits by 2 months. The 6 month size usually fits by 4 months.</p>',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					);
////product 4 end///
$post_array['Babygrows & Vests'] = $post_info;
//=====================================================================================//
////product 1 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_bottom1.jpg',	
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '70',	
					"specialprice"			=> '50',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Nancy Checked Skirt',
					"post_content"	=>	'This girls cotton skirt form Tommy Hilfiger is a gorgeous checked lightweight cotton. The skirt ties with a bow at the rear of the waist & has a side zip & an adjustable waist for easy fit. To give the Nancy skirt it’s full appearance there is a hidden cotton pettiskirt that sits under the skirt. The Nancy skirt sits just above knee length, perfect for summer days. The navy & red check pattern is subtle in it’s detail. Machine wash @ 30 degrees.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Skirt',
					"post_feature"	=>	0,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_bottom2.jpg',
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',	
					"price"					=> '70',	
					"specialprice"			=> '49',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Multi Stripes Skirt',
					"post_content"	=>	'Love this cosy sweatshirt fabric skirt in our own vibrant multi-stripe design fabric. A pull-on, mock button-through skirt for dressing in an instant. It has a shirring elastic detail below the waistband that adds volume to the skirt. With amber buttons and front pockets.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Skirt',
					"post_feature"	=>	0,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_bottom3.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '60',	
					"specialprice"			=> '45',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Baby Pettiskirt',
					"post_content"	=>	'<p>This Oopsy Daisy Baby pettiskirt is custom designed with trendy, fashionable colors. Made from layers of chiffon, these voluminous pettiskirts make dressing like a fairy tale princess possible! The skirts have an elasticated waist that can be tightened with the ribbon. The skirt is constructed from layers of ruffled chiffon that are great for twirling around.</p>
<p>The sizes fit generously, covering a few years. Typically Girls Sizes fit in the following way, Small fits 2-4 years. Medium fits 4-6 years & Large fits 6-10 years.</p>
<p>Typically Baby Sizes fit in the following way, Small fits 0-12 months. Medium fits 12-18 months. Large fits 18-36 months.</p>
<p>Available in a full range of colours, the skirts can be styled with the matching Oopsy Daisy Tops, adorned with chiffon flowers. Worn with footless tights and ballet pumps or you could funk it up and team the pettiskirts with tights, Emu boots & a cool top form No Added Sugar or Dandy Star!</p>',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Skirt',
					"post_feature"	=>	0,
					);
////product 3 end///
////product 4 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_bottom4.jpg',
					"productimage1"			=> $dummy_image_path.'girls_bottom5.jpg',	
					"productimage2"			=> $dummy_image_path.'girls_bottom6.jpg',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '60',	
					"specialprice"			=> '45',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange,Red',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Pettiskirt',
					"post_content"	=>	'<p>This Oopsy Daisy Baby pettiskirt is custom designed with trendy, fashionable colors. Made from layers of chiffon, these voluminous pettiskirts make dressing like a fairy tale princess possible! The skirts have an elasticated waist that can be tightened with the ribbon. The skirt is constructed from layers of ruffled chiffon that are great for twirling around.</p>
<p>The sizes fit generously, covering a few years. Typically Girls Sizes fit in the following way, Small fits 2-4 years. Medium fits 4-6 years & Large fits 6-10 years.</p>
<p>Typically Baby Sizes fit in the following way, Small fits 0-12 months. Medium fits 12-18 months. Large fits 18-36 months.</p>
<p>Available in a full range of colours, the skirts can be styled with the matching Oopsy Daisy Tops, adorned with chiffon flowers. Worn with footless tights and ballet pumps or you could funk it up and team the pettiskirts with tights, Emu boots & a cool top form No Added Sugar or Dandy Star!</p>',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Pettiskirt,Skirt',
					"post_feature"	=>	0,
					);
////product 4 end///
////product 5 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_bottom9.gif',
					"productimage1"			=> $dummy_image_path.'girls_bottom8.jpg',
					"productimage2"			=> $dummy_image_path.'girls_bottom7.jpg',
					"productimage3"			=> $dummy_image_path.'girls_bottom10.jpg',	
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '60',	
					"specialprice"			=> '45',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange,Red',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Bouble Squirrel Skirt',
					"post_content"	=>	'This gorgeous little skirt from Phister & Philina embodies all that is great about the Danish brand. The skirt is made from jersey & the finest baby cord, adorned with an all over print of little squirrels looking for nuts. The main part of the skirt is a charcoal grey offset with a bright pink waistband & finished off with a blue button & green bow detail. The skirt is a puffball bubble shape that is bang on trend this season. The skirt has a ribbed pink waistband, that is adjustable on the inside so it can be altered to the perfect fit. It also co-ordinates with all of the tops in the Phister & Philina range.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Skirt',
					"post_feature"	=>	0,
					);
////product 5 end///
$post_array['Girls Bottoms'] = $post_info;

//=====================================================================================//
////product 1 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_coat1.jpg',	
					"productimage1"			=> $dummy_image_path.'girls_coat3.jpg',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '70',	
					"specialprice"			=> '50',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Girls Duffle Coat',
					"post_content"	=>	'This girl’s duffle coat form Gloverall is exclusively available from Ten Little Monkeys in the UK. The pastel pink 100% wool duffle coat fastens with traditional toggles in a natural rope and wood finish. This coat is based a traditional duffle coat shape, made by the original makers of duffle coats, with an updated colour, to suit modern little girls!',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Coat',
					"post_feature"	=>	0,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_coat2.jpg',
					"productimage1"			=> '',		
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',	
					"price"					=> '70',	
					"specialprice"			=> '49',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Jacket In Multi Stripes',
					"post_content"	=>	'No Added Sugar Dressage Jacket In Multi Stripes is made from cosy, 100% cotton sweatshirt fabric, so big on easy care and comfort. With layered godets of contrast colours at each side, a pink felt logo bunny patch on the upper arm and a box pleat in the back for movement, we would team this with No Added Sugar’s Horsey-Horsey trousers. For a witty equestrian feel, just add a pony',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Coat',
					"post_feature"	=>	0,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_coat4.jpg',
					"productimage1"			=> '',	
					"productimage2"			=> '',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '50',	
					"specialprice"			=> '40',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Fleur Mac',
					"post_content"	=>	'This Mac is a great cover up just in case there are summer showers, we can’t have sun all the time! The khaki mac has a pretty floral print cotton lining which adds weight & warmth to the full swing style mac. Belted at the waist, girls will look chic whenever they choose to wear this classic wardrobe essential.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Coat',
					"post_feature"	=>	0,
					);
////product 3 end///
$post_array['Girls Coats'] = $post_info;
//===============================================================================//
////product 1 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_dress3.jpg',	
					"productimage1"			=> $dummy_image_path.'girls_dress2.jpg',		
					"productimage2"			=> $dummy_image_path.'girls_dress7.jpg',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '150',	
					"specialprice"			=> '130',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Dress In Navy',
					"post_content"	=>	'This girls dress from Tommy Hilfiger is great for casual days. The 100% jersey cotton dress has a simple design of scattered white stars intermixed with the Tommy Hilfiger name. The drop waist detail makes a simple detail. The racer back vest top is great for layering over t-shirts on cooler days.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Dress',
					"post_feature"	=>	1,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_dress4.jpg',
					"productimage1"			=> $dummy_image_path.'girls_dress8.jpg',
					"productimage2"			=> '',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',	
					"price"					=> '170',	
					"specialprice"			=> '149',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Coral Stripes',
					"post_content"	=>	'Fast becoming a no added sugar classic. This season, girls will love the addition of soft ivory tulle to the back tiers for that extra girly-ness. Made from 100% cotton jersey with a slim fit upper body and tiers of contrast fabric at the back. Wash at 40 degrees & iron on reverse.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Dress',
					"post_feature"	=>	1,
					);
////product 2 end///
////product 3 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_dress5.jpg',
					"productimage1"			=> $dummy_image_path.'girls_dress6.jpg',	
					"productimage2"			=> $dummy_image_path.'girls_dress1.jpg',
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',
					"price"					=> '150',	
					"specialprice"			=> '140',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange,Cream',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Bag In Cream',
					"post_content"	=>	'This girls dress from Marybel is a beautiful dress for all seasons. Wear with black tights for a contemporary look this Christmas, or pair with cream tights for an angelic look. Wear alone in the summertime for effortless style. This dress has delicate puffed sleeves with a circle detail that is finished with a fine gold thread. This detail is also featured around the neckline. Change in and out of it easily as there is a concealed zip up the back. The dress also has a subtle puffball hem.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Dress',
					"post_feature"	=>	0,
					);
////product 3 end///
$post_array['Girls Dresses'] = $post_info;
//===============================================================================//
////product 1 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'girls_dress3.jpg',	
					"productimage1"			=> $dummy_image_path.'girls_dress2.jpg',		
					"productimage2"			=> $dummy_image_path.'girls_dress7.jpg',		
					"productimage3"			=> '',		
					"productimage4"			=> '',		
					"productimage5"			=> '',		
					"productimage6"			=> '',		
					"price"					=> '150',	
					"specialprice"			=> '130',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Pink,White,Black,Orange',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'Bag In Cream',
					"post_content"	=>	'This vibrant baby girls blouse from Tommy Hilfiger is a sleeveless design with frills on the shoulders. It looks fab when teamed with the Trisha Mini Skirt or on relaxed days team it with leggings. The top buttons down the front for easy dressing.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Top',
					"post_feature"	=>	0,
					);
////product 1 end///
////product 2 start///
$post_meta = array();
$post_meta = array(
					"productimage"			=> $dummy_image_path.'baby_top3.jpg',
					"productimage1"			=> $dummy_image_path.'baby_top4.jpg',
					"productimage2"			=> $dummy_image_path.'baby_top5.jpg',		
					"productimage3"			=> $dummy_image_path.'baby_top6.jpg',	
					"productimage4"			=> $dummy_image_path.'baby_top7.jpg',		
					"productimage5"			=> '',		
					"productimage6"			=> '',	
					"price"					=> '100',	
					"specialprice"			=> '70',	
					"size"					=> '14months,18months,20months,22months',
					"color"					=> 'Star Horse,Star Love,Long Sleeved,Dandy Star,Dandy Star Cool',
					"posttype"				=> 'product',
				);
$post_info[] = array(
					"post_title"	=>	'T-Shirt',
					"post_content"	=>	'Fast becoming a no added sugar classic. This season, girls will love the addition of soft ivory tulle to the back tiers for that extra girly-ness. Made from 100% cotton jersey with a slim fit upper body and tiers of contrast fabric at the back. Wash at 40 degrees & iron on reverse.',
					"post_meta"		=>	$post_meta,
					"post_tags"		=>	'Top',
					"post_feature"	=>	1,
					);
////product 2 end///
$post_array['Girls Tops'] = $post_info;
//===============================================================================//

$feature_cat_name = 'Feature';
for($c=0;$c<count($category_array);$c++)
{
	$feature_cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like \"$feature_cat_name\"");
	$cat_name = $category_array[$c];
	if(is_array($cat_name))
	{
		$parent_cat_id = '0';
		$cat_name_arr = $cat_name;
		for($i=0;$i<count($cat_name_arr);$i++)
		{
			$cat_id = '';
			$cat_name = $cat_name_arr[$i];
			
			$cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like \"$cat_name\"");
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
							$post_id_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\"");
							if($post_id_count==0)
							{
								$post_content = addslashes($post_info_arr[$p]['post_content']);
								$post_date = date('Y-m-d H:s:i');
	
								$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
								$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name=\"$post_name\"");
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
							$post_id_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\"");
							if($post_id_count==0)
							{
								$tt_update_sql = "update $wpdb->term_taxonomy set count=count+1 where term_id=\"$last_cat_id\"";
								$wpdb->query($tt_update_sql);
								$post_content = addslashes($post_info_arr[$p]['post_content']);
								$post_date = date('Y-m-d H:s:i');
								$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
								$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name=\"$post_name%\"");
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
				}
				
			}
			if($i==0)
			{
				$parent_cat_id = $last_cat_id;
			}
		}
	}else
	{
		$cat_id = '';
		$cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like \"$cat_name\"");
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
						$post_id_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\"");
						if($post_id_count==0)
						{
							$post_content = $post_info_arr[$p]['post_content'];
							$post_date = date('Y-m-d H:s:i');
							//$post_name = str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),'-',$post_title);
							$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
							$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name=\"$post_name\"");
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
			}	
		}else
		{
			$last_cat_id = $cat_id;
			$last_tt_id = $wpdb->get_var("SELECT tt.term_taxonomy_id FROM $wpdb->term_taxonomy tt where tt.term_id=\"$last_cat_id\" and tt.taxonomy='category'");
			if($post_array[$cat_name])
			{
				$post_info_arr = $post_array[$cat_name];
				if(count($post_info_arr)>0)
				{
					for($p=0;$p<count($post_info_arr);$p++)
					{
						$post_title = $post_info_arr[$p]['post_title'];
						$post_id_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\"");
						if($post_id_count==0)
						{
							$tt_update_sql = "update $wpdb->term_taxonomy set count=count+1 where term_id=\"$last_cat_id\"";
							$wpdb->query($tt_update_sql);
							$post_content = $post_info_arr[$p]['post_content'];
							$post_date = date('Y-m-d H:s:i');
							$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
							$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name=\"$post_name\"");
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
update_option("ptthemes_banner_title",'Hello!');
update_option("ptthemes_banner_desc",'<p>Welcome to Kids Store - take a look at our cool kids clothes and <br>cool baby clothes for toddlers and their mums!</p>');
update_option("ptthemes_btn_name",'Special Offers');
update_option("ptthemes_btn_url",'http://templatic.com/wordpress-themes-store');


/////////////// Design Settings END ///////////////
/////////////// WIDGET SETTINGS START ///////////////
$feature_cat_name = 'Feature';
$feature_cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name=\"$feature_cat_name\"");

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
					"advt1"			=>	$dummy_image_path.'i-banner01.png',
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

$sidebar_banner_info[1] = array(
					"title"			=>	'',
					"advt1"			=>	$dummy_image_path.'i-banner02.png',
					"advt_link1"	=>	'http://www.templatic.com',
					"advt2"			=>	'',
					"advt_link2"	=>	'',
					);
$sidebar_banner_info['_multiwidget'] = '1';

update_option('widget_widget_advt',$sidebar_banner_info);
$home_banner_widget_info = get_option('widget_widget_advt');
krsort($home_banner_widget_info);
foreach($home_banner_widget_info as $key=>$val)
{
	$home_banner_widget_info_key = $key;
	if(is_int($home_banner_widget_info_key))
	{
		break;
	}
}

$flicker_info = array(
					"id"			=>	'15184611@N00',
					"number"		=>	6,
					);
update_option('widget_flickrwidget',$flicker_info);
$flicker_widget_info = get_option('widget_flickrwidget');
krsort($flicker_widget_info);
foreach($flicker_widget_info as $key=>$val)
{
	$flicker_widget_info_key = $key;
	if(is_int($flicker_widget_info_key))
	{
		break;
	}
}

$tags_info[1] = array(
					"title"			=>	'Tags',
					);
update_option('widget_tag_cloud',$tags_info);
$tags_info = get_option('widget_tag_cloud');
krsort($tags_info);
foreach($tags_info as $key=>$val)
{
	$tags_widget_info_key = $key;
	if(is_int($tags_widget_info_key))
	{
		break;
	}
}

$cat_info[1] = array(
					"title"			=>	'Browse Products',
					"count"			=>	'0',
					"hierarchical"	=>	'0',
					"dropdown"		=>	'0',
					);

update_option('widget_categories',$cat_info);
$cat_info = get_option('widget_categories');
krsort($cat_info);
foreach($cat_info as $key=>$val)
{
	$cat_info_key = $key;
	if(is_int($cat_info_key))
	{
		break;
	}
}

$wp_inactive_widgets = get_option('sidebars_widgets');
$wp_inactive_widgets["sidebar-1"] = array('widget_posts1-'.$home_slider_widget_info_key,'widget_text-'.$home_banner_widget_info_key);
$wp_inactive_widgets["sidebar-2"] = array('categories-'.$cat_info_key,'pt-flickr-photos','tag_cloud-'.$tags_widget_info_key,'widget_advt-'.$home_banner_widget_info_key);
update_option('sidebars_widgets',$wp_inactive_widgets);
/////////////// WIDGET SETTINGS END ///////////////
function set_post_tag($pid,$post_tags)
{
	global $wpdb;
	$post_tags_arr = explode(',',$post_tags);
	for($t=0;$t<count($post_tags_arr);$t++)
	{
		$posttag = $post_tags_arr[$t];
		$term_id = $wpdb->get_var("SELECT t.term_id FROM $wpdb->terms t join $wpdb->term_taxonomy tt on tt.term_id=t.term_id where t.name=\"$posttag\" and tt.taxonomy='post_tag'");
		if($term_id == '')
		{
			$srch_arr = array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_');
				$replace_arr = array('','','','','','','','','','','','','','','','','','','','',',','','');
			$posttagslug = str_replace($srch_arr,$replace_arr,$posttag);
			$termsql = "insert into $wpdb->terms (name,slug) values (\"$posttag\",\"$posttagslug\")";
			$wpdb->query($termsql);
			$last_termsid = $wpdb->get_var("SELECT max(term_id) as term_id FROM $wpdb->terms");
		}else
		{
			$last_termsid = $term_id;
		}
		$term_taxonomy_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy where term_id=\"$last_termsid\" and taxonomy='post_tag'");
		if($term_taxonomy_id=='')
		{
			$termpost = "insert into $wpdb->term_taxonomy (term_id,taxonomy,count) values (\"$last_termsid\",'post_tag',1)";
			$wpdb->query($termpost);
			$term_taxonomy_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy where term_id=\"$last_termsid\" and taxonomy='post_tag'");
		}else
		{
			$termpost = "update $wpdb->term_taxonomy set count=count+1 where term_taxonomy_id=\"$term_taxonomy_id\"";
			$wpdb->query($termpost);
		}
		$termsql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$pid\",\"$term_taxonomy_id\")";
		$wpdb->query($termsql);
	}
}
?>