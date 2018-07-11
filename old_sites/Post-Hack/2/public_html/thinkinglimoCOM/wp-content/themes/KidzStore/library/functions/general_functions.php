<?php 
session_start();
ob_start();
if (!class_exists('General')) {
	class General {
		// Class initialization
		function General() {
		}
		
		function get_payment_method($method)
		{
			global $wpdb;
			$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_$method'";
			$paymentinfo = $wpdb->get_results($paymentsql);
			if($paymentinfo)
			{
				foreach($paymentinfo as $paymentinfoObj)
				{
					$paymentInfo = unserialize($paymentinfoObj->option_value);
					return __('Pay with').$paymentInfo['name'];
				}
			}
		}
		
		function get_shipping_method($method)
		{
			global $wpdb;
			$paymentsql = "select * from $wpdb->options where option_name like 'shipping_method_$method'";
			$paymentinfo = $wpdb->get_results($paymentsql);
			if($paymentinfo)
			{
				foreach($paymentinfo as $paymentinfoObj)
				{
					$paymentInfo = unserialize($paymentinfoObj->option_value);
					return __($paymentInfo['name']);
				}
			}
		}
		
		function get_weight_cart()
		{
			$cartInfo = $_SESSION['CART_INFORMATION'];
			$weight = 0;
			for($i=0;$i<count($cartInfo);$i++)
			{
				if($cartInfo[$i]['product_weight'])
				{

					//$weight = $weight + $cartInfo[$i]['product_weight'];
					$weight = $weight + ($cartInfo[$i]['product_weight']*$cartInfo[$i]['product_qty']);
				}
			}
			return $weight;
		}
		function get_shipping_amt($method,$total_amt=0)
		{
			global $wpdb,$Cart;
			$paymentsql = "select * from $wpdb->options where option_name like 'shipping_method_$method'";
			$paymentinfo = $wpdb->get_results($paymentsql);
			$total_amt1 = $total_amt;
			if($paymentinfo)
			{
				if($_SESSION['couponcode'])
				{
					$coupon_amt = $this->get_discount_amount($_SESSION['couponcode'],$Cart->getCartAmt());
					if($coupon_amt>0)
					{
						$total_amt = $total_amt - $coupon_amt;
					}
				}
				
				foreach($paymentinfo as $paymentinfoObj)
				{
					$paymentInfo = unserialize($paymentinfoObj->option_value);
					$shippingOpts = $paymentInfo['payOpts'];
					for($i=0;$i<count($shippingOpts);$i++)
					{
						$shipping_amt = 0;
						if(strstr($shippingOpts[$i]['value'],'->') && strstr($shippingOpts[$i]['value'],'='))
						{
							$array1 = explode('->',$shippingOpts[$i]['value']);
							$initval = $array1[0];
							$array2 = explode('=',$array1[1]);
							$lastval = $array2[0];
							$rate_amt = $array2[1];
							if($method == 'weight_base')
							{
								$weight = $this->get_weight_cart();
								if(($weight >= $initval) && ($weight <= $lastval))
								{
									$shipping_amt = $rate_amt;
									break;
								}
							}else
							{
								if(($total_amt >= $initval) && ($total_amt <= $lastval))
								{
									$shipping_amt = $rate_amt;
									break;
								}
							}
						}
						elseif(strstr($shippingOpts[$i]['value'],'%'))
						{
							$ship_amount = str_replace('%','',$shippingOpts[$i]['value']);
							if($ship_amount)
							{
								$shipping_amt = ($total_amt1*$ship_amount)/100;
							}
						}
						else
						{
							$shipping_amt = $shippingOpts[$i]['value'];
						}
					}
					
					return $shipping_amt;
				}
			}else
			{
				return '0';
			}
		}
		
		function get_tax_amount()
		{
			global $Cart;
			if(isset($_SESSION['CART_INFORMATION']))
			{
				$cart_info = $_SESSION['CART_INFORMATION'];
				$product_tax = $this->get_product_tax();
				$tax_amt = 0;
				for($i=0;$i<count($cart_info);$i++)
				{
					$cart_prdinfo = $cart_info[$i];
					$qty = $cart_prdinfo['product_qty'];
					$price = $cart_prdinfo['product_gross_price'];
					$grossprice = $qty*$price;
					$istaxable = $cart_prdinfo['product_istaxable'];
					if($_SESSION['couponcode'])
					{
						$grossprice = $grossprice - $this->get_discount_amount($_SESSION['couponcode'],$Cart->getCartAmt());
					}
					if($istaxable=='on')
					{
						$tax_amt = $tax_amt + ($grossprice*$product_tax)/100;
					}else
					{
						$tax_amt = $tax_amt;
					}
				}
				return $tax_amt;
			}
		}
		
		function get_payable_amount($shippingmehod='')  // To get the final payable amoung
		{
			global $Cart;
			$payable_amount = 0;
			$cart_amt = $Cart->getCartAmt();
			$tax_amt = $this->get_tax_amount();
			if($_SESSION['couponcode'])
			{
				$discount_amount = $this->get_discount_amount($_SESSION['couponcode'],$cart_amt);
			}
			if($discount_amount)
			{
				$cart_amt = $cart_amt - $discount_amount;
			}
			if($shippingmehod)
			{
				$shipping_amt = $this->get_shipping_amt($shippingmehod,$Cart->getCartAmt());
				$payable_amount = $cart_amt+$shipping_amt;
			}else
			{
				$payable_amount = $cart_amt;
			}
			if($tax_amt)
			{
				$payable_amount = $payable_amount + $tax_amt;
			}
			return str_replace(',','',number_format($payable_amount,2));
		}
		
		function get_payment_optins($method)
		{
			global $wpdb;
			$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_$method'";
			$paymentinfo = $wpdb->get_results($paymentsql);
			if($paymentinfo)
			{
				foreach($paymentinfo as $paymentinfoObj)
				{
					$option_value = unserialize($paymentinfoObj->option_value);
					$paymentOpts = $option_value['payOpts'];
					$optReturnarr = array();
					for($i=0;$i<count($paymentOpts);$i++)
					{
						$optReturnarr[$paymentOpts[$i]['fieldname']] = $paymentOpts[$i]['value'];
					}
					//echo "<pre>";print_r($optReturnarr);
					return $optReturnarr;
				}
			}
		}
		
		function get_coupon_deduction()
		{
			global $Cart;
			$discount_info = $this->get_discount_info($_SESSION['couponcode']);
			$couponInfo = __("Discount Amount");//.$discount_info['couponcode'];	
			if($discount_info['dis_per']=='dis')
			{
				$couponInfo .= "(".$discount_info['dis_amt']."%)";
			}else
			{
				$couponInfo .= "";
			}
			return $couponInfo;
		}
				
		function get_currency_symbol()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['currencysym'] == '')
			{
				return '$';
			}else
			{
				return $generalinfo['currencysym'];
			}
		}
		
		function get_currency_code()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['currency'] == '')
			{
				return 'USD';
			}else
			{
				return $generalinfo['currency'];
			}
		}
		
		function get_site_emailId()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['site_email'])
			{
				return $generalinfo['site_email'];
			}else
			{
				return get_option('admin_email');				
			}
		}
		
		function get_site_emailName()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['site_email_name'])
			{
				return $generalinfo['site_email_name'];					
			}else
			{
				return get_option('blogname');
			}
		}
		
		function get_product_imagepath()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			return $generalinfo['imagepath'];
		}
		
		function get_product_tax()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			return $generalinfo['tax'];
		}
		
		function is_show_weight()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_weight'])
			{
				return true;
			}else
			{
				return false;
			}
		}
		
		function is_show_coupon()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_coupon'])
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_show_tellaFriend()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_tellafrnd'])
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_show_storepage()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_storepage'])
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_show_category()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_category'])
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_show_blogpage()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_blogpage'])
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_show_addcomment()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_addcomment'])
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_show_related_products()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_relproducts'])
			{
				return true;
			}else
			{
				return false;
			}
		}
		function get_dashboard_display_orders()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			return $generalinfo['dash_noof_orders'];
		}
		
		function is_valid_couponcode($coupon)
		{
			global $wpdb;
			$couponexist = 0;
			if($coupon)
			{
				$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
				$couponinfo = $wpdb->get_results($couponsql);
				if($couponinfo)
				{
					foreach($couponinfo as $couponinfoObj)
					{
						$option_value = unserialize($couponinfoObj->option_value);
						foreach($option_value as $key=>$value)
						{
							if($value['couponcode'] == $coupon)
							{
								$couponexist = 1;
								break;
							}
						}
					}
				}			
			}
			return $couponexist;
		}
		function get_discount_amount($coupon,$amount)
		{
			global $wpdb;
			if($coupon!='' && $amount>0)
			{
				$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
				$couponinfo = $wpdb->get_results($couponsql);
				if($couponinfo)
				{
					foreach($couponinfo as $couponinfoObj)
					{
						$option_value = unserialize($couponinfoObj->option_value);
						foreach($option_value as $key=>$value)
						{
							if($value['couponcode'] == $coupon)
							{
								if($value['dis_per']=='per')
								{
									$discount_amt = ($amount*$value['dis_amt'])/100;
								}else
								if($value['dis_per']=='amt')
								{
									$discount_amt = $value['dis_amt'];
								}
							}
						}
					}
				}
			}
			return $discount_amt;
		}
		
		function get_discount_info($coupon)
		{
			global $wpdb;
			if($coupon!='')
			{
				$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
				$couponinfo = $wpdb->get_results($couponsql);
				if($couponinfo)
				{
					foreach($couponinfo as $couponinfoObj)
					{
						$option_value = unserialize($couponinfoObj->option_value);
						foreach($option_value as $key=>$value)
						{
							if($value['couponcode'] == $coupon)
							{
								return $value;
							}
						}
					}
				}
			}
			return $discount_amt;
		}
		
		function is_storetype_shoppingcart()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['store_type'] == 'cart')
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_storetype_digital()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['store_type'] == 'digital')
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_checkoutype_cart()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['checkout_type'] == 'cart')
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_storetype_catalog()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['store_type'] == 'catalog')
			{
				return true;
			}else
			{
				return false;
			}
		}
		
		function getLoginUserInfo()
		{
			$logininfoarr = explode('|',$_COOKIE[LOGGED_IN_COOKIE]);
			if($logininfoarr)
			{
				global $wpdb;
				$userInfoArray = array();
				$usersql = "select * from $wpdb->users where user_login = '".$logininfoarr[0]."'";
				$userinfo = $wpdb->get_results($usersql);
				foreach($userinfo as $userinfoObj)
				{
					$userInfoArray['ID'] = 	$userinfoObj->ID;
					$userInfoArray['display_name'] = 	$userinfoObj->display_name;
					$userInfoArray['user_nicename'] = 	$userinfoObj->user_login;
					$userInfoArray['user_email'] = 	$userinfoObj->user_email;
					$userInfoArray['user_id'] = 	$logininfoarr[0];
				}
				return $userInfoArray;
			}else
			{
				return false;
			}
		}
		
		function getOrderStatus($status = '',$return='')
		{
			$status_str = '';
			if($status == 'approve')
			{
				$status_str =  '<font style="color:#006633">'.__('Approved').'</font>';
			}
			elseif($status == 'cancel')
			{
				$status_str = '<font style="color:#FF0000">'.__('Canceled').'</font>';
			}
			elseif($status == 'reject')
			{
				$status_str = '<font style="color:#FF0000">'.__('Rejected').'</font>';
			}
			elseif($status == 'shipping')
			{
				$status_str = '<font style="color:#0033FF">'.__('Shipping').'</font>';
			}
			elseif($status == 'delivered')
			{
				$status_str = '<font style="color:#0033FF">'.__('Delivered').'</font>';
			}
			elseif($status == 'processing')
			{
				$status_str = '<font style="color:#FF9900">'.__('Pending').'</font>';
			}
			if($return)
			{
				return __($status_str);	
			}else
			{
				_e($status_str);	
			}
		}
		
		function sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
		{
			if($fromEmail && $toEmail)
			{
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				
				// Additional headers
				$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
				$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
				//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
				//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
				// Mail it
				
				/*echo "From : $fromEmail - $fromEmailName <br>";
				echo "To : $toEmail - $toEmailName <br>";
				echo "Subject : $subject <br>";
				echo "Message : $message <br>";
				echo "$headers <br>";
				exit;*/
				
				wp_mail($toEmail, $subject, $message, $headers);
			}
		}
		
		function get_total_products($month='')
		{
			global $wpdb;
			$query = "SELECT COUNT($wpdb->posts.ID) FROM $wpdb->posts ";
			$query .= " JOIN $wpdb->postmeta";
			$query .= " ON $wpdb->posts.ID = $wpdb->postmeta.post_id";
			$query .= " AND ($wpdb->postmeta.meta_key = 'key') and ($wpdb->postmeta.meta_value like '".'%:"posttype";%'."')";
			$query .=" WHERE $wpdb->posts.post_status = 'publish' and $wpdb->posts.post_parent='0'";
			if($month)
			{
				$query .= " and date_format($wpdb->posts.post_date,'%m')=$month";
			}
			return $wpdb->get_var($query);
		}
		
		function get_total_orders()
		{
			global $wpdb, $General;
			
			$userInfo = $General->getLoginUserInfo();
			$ordersql = "select u.display_name,um.meta_value from $wpdb->usermeta as um join $wpdb->users as u on u.ID=um.user_id  where um.meta_key = 'user_order_info' order by um.umeta_id desc";
			$orderinfo = $wpdb->get_results($ordersql);
			$currentMonthOrders = array();
			$totalOrders = array();
			if($orderinfo)
			{
				foreach($orderinfo as $orderinfoObj)
				{
					$meta_value_arr = array();
					$meta_value = unserialize(unserialize($orderinfoObj->meta_value));
					$display_name= $orderinfoObj->display_name;
					for($i=0;$i<count($meta_value);$i++)
					{
						//$user_info = $meta_value[$i][0]['user_info'];
						//$cart_info = $meta_value[$i][0]['cart_info'];
						//$payment_info = $meta_value[$i][0]['payment_info'];
						$order_info = $meta_value[$i][0]['order_info'];
						//print_r($order_info);
						$totalOrders[$order_info['order_status']][] = $order_info;
						if(date('m',strtotime($order_info['order_date'])) == date('m')) //current month orders
						{
							$currentMonthOrders[$order_info['order_status']][] = $order_info;
						}
					}
				}
			}
			return array($currentMonthOrders,$totalOrders);
		}
		
		function get_total_orders_bydate()
		{
			global $wpdb, $General;
			
			$userInfo = $General->getLoginUserInfo();
			$ordersql = "select u.display_name,um.meta_value from $wpdb->usermeta as um join $wpdb->users as u on u.ID=um.user_id  where um.meta_key = 'user_order_info' order by um.umeta_id desc";
			$orderinfo = $wpdb->get_results($ordersql);
			$currentMonthOrders = array();
			$totalOrders = array();
			if($orderinfo)
			{
				foreach($orderinfo as $orderinfoObj)
				{
					$meta_value_arr = array();
					$meta_value = unserialize(unserialize($orderinfoObj->meta_value));
					$display_name= $orderinfoObj->display_name;
					for($i=0;$i<count($meta_value);$i++)
					{
						//$temparr['user_info'] = $meta_value[$i][0]['user_info'];
						//$cart_info = $meta_value[$i][0]['cart_info'];
						//$payment_info = $meta_value[$i][0]['payment_info'];
						$meta_value[$i][0]['order_info']['customer_name'] = $orderinfoObj->display_name;
						$order_info = $meta_value[$i][0]['order_info'];
						$totalOrders[strtotime($order_info['order_date'])] = $order_info;
					}
				}
			}
			return $totalOrders;
		}	
		
		function get_pagination($targetpage,$total_pages,$limit=10,$page=0)
		{
			/* Setup page vars for display. */
			if ($page == 0) $page = 1;					//if no page var is given, default to 1.
			$prev = $page - 1;							//previous page is page - 1
			$next = $page + 1;							//next page is page + 1
			$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;						//last page minus 1
			
			/* 
				Now we apply our rules and draw the pagination object. 
				We're actually saving the code to a variable in case we want to draw it more than once.
			*/
			if(strstr($targetpage,'?'))
			{
				$querystr = "&pagination";
			}else
			{
				$querystr = "?pagination";
			}
			$pagination = "";
			if($lastpage > 1)
			{	
				$pagination .= "<div class=\"pagination\">";
				//previous button
				if ($page > 1) 
					$pagination.= "<a href=\"$targetpage$querystr=$prev\">&laquo; previous</a>";
				else
					$pagination.= "<span class=\"disabled\">&laquo; previous</span>";	
				
				//pages	
				if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
				{	
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage$querystr=$counter\">$counter</a>";					
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
				{
					//close to beginning; only hide later pages
					if($page < 1 + ($adjacents * 2))		
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage$querystr=$counter\">$counter</a>";					
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage$querystr=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage$querystr=$lastpage\">$lastpage</a>";		
					}
					//in middle; hide some front and some back
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"$targetpage$querystr=1\">1</a>";
						$pagination.= "<a href=\"$targetpage$querystr=2\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage$querystr=$counter\">$counter</a>";					
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage$querystr=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage$querystr=$lastpage\">$lastpage</a>";		
					}
					//close to end; only hide early pages
					else
					{
						$pagination.= "<a href=\"$targetpage$querystr=1\">1</a>";
						$pagination.= "<a href=\"$targetpage$querystr=2\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage$querystr=$counter\">$counter</a>";					
						}
					}
				}
				
				//next button
				if ($page < $counter - 1) 
					$pagination.= "<a href=\"$targetpage$querystr=$next\">next &raquo;</a>";
				else
					$pagination.= "<span class=\"disabled\">next &raquo;</span>";
				$pagination.= "</div>\n";		
			}
			return $pagination;
		}
		
		function get_order_detailinfo_tableformat($orderInfoArray,$isshow_paydetail=0)
		{
			global $Cart,$wpdb;
			$user_info = $orderInfoArray['user_info'];
			$cart_info = $orderInfoArray['cart_info'];
			$payment_info = $orderInfoArray['payment_info'];
			$order_info = $orderInfoArray['order_info'];
			$order_discount_amt = $order_info['discount_amt'];
			$order_taxable_amt = $order_info['taxable_amt'];
			$order_payable_amt = $order_info['payable_amt'];
			
			if($isshow_paydetail)
			{
				$message = '<link rel="stylesheet" type="text/css" href="'.get_stylesheet_directory_uri().'/style.css" media="screen" />';
				$message .= '<style>.address_info {width:400px;}</style>';
			}
			$message .='		
					<table width="100%" class="table table_spacer" cellpadding="0" cellspacing="0" border="0" ><tr><td>
					<div class="order_info">
						 
						 
							<p> <span class="span"> '. __('Order Number').' </span> : <strong>'.$order_info['order_id'].'  </strong>  <br />
						
							<span class="span"> '. __('Order Date').' </span> : '.date(get_option('date_format').' '.get_option('time_format'),strtotime($order_info['order_date'])).' </p>
						 
						
						<p><span class="span">'. __('Order Status') .'</span>  : <strong>'. $this->getOrderStatus($order_info['order_status'],1).'</strong> </p>
					</div> <!--order_info -->
					</td></tr>					
					<tr><td>
					<div class="checkout_address" >
					 <table width="100%" class="table table_spacer" cellpadding="0" cellspacing="0" border="0"><tr><td>	
						<div class="address_info address_info2  fl">
					  <h3>'.__('User Information').'</h3>
					  <div class="address_row"> <b>'.$user_info['user_name'].' </b></div>
					  <div class="address_row">'.$user_info['user_add1'].' </div>
					  <div class="address_row">'.$user_info['user_add2'].'</div>
					  <div class="address_row"> '.$user_info['user_city'].', '.$user_info['user_state'].',</div>
					  <div class="address_row"> '.$user_info['user_country'].'-'.$user_info['user_postalcode'].'. </div>';
					  if($user_info['user_phone']!='' ){$message.='<div class="address_row"> '.__(PHONE_NUMBER_TEXT).' :'.$user_info['user_phone'].'</div>';}
					 $message.='
					</div>
					 </td><td>
					<div class="address_info address_info2 fr">
              <h3> '. __('Shipping Address').'  </h3>
              <div class="address_row"> '; if($user_info['buser_name']==''){$message.=$user_info['user_name'];}else{$message.=$user_info['buser_name'];} $message.='</div>
              <div class="address_row">'; if($user_info['buser_add1']==''){$message.=$user_info['user_add1'];}else{$message.=$user_info['buser_add1'];}	$message.='  </div>
              <div class="address_row">'; if($user_info['buser_add2']==''){$message.=$user_info['user_add2'];}else{$message.=$user_info['buser_add2'];} $message.=' </div>
              <div class="address_row">'; if($user_info['buser_city']==''){$message.=$user_info['user_city'];}else{$message.=$user_info['buser_city'];}	$message.=', ';
			  if($user_info['buser_state']==''){$message.=$user_info['user_state'];}else{$message.=$user_info['buser_state'];} $message.=', </div>
              <div class="address_row">'; if($user_info['buser_country']==''){$message.=$user_info['user_country'];}else{$message.=$user_info['buser_country'];} $message.='-';
				if($user_info['buser_postalcode']==''){$message.=$user_info['user_postalcode'];}else{$message.=$user_info['buser_postalcode'];}	$message.='. </div> '; 
				if($user_info['buser_phone']=='' && $user_info['user_phone']!='' ){$message.='<div class="address_row"> '.__(PHONE_NUMBER_TEXT).' :'.$user_info['user_phone'].'</div>';}elseif($user_info['buser_phone']!=''){$message.='<div class="address_row"> '.__(PHONE_NUMBER_TEXT).' :'.$user_info['buser_phone'].'</div>';} 
			 $message.='
            </div>			
			</td></tr></table>
			</div><!-- checkout Address -->
				</td></tr>	
				</table>	
					 
					  <table width="100%" class="table table_spacer" >
					  <tr>
					  <td class="title"> '. __('Payment Information').'</td>
					   <td class="title"> '. __('Shipping Information').'</td>
					  </tr>
					  <tr>
					  <td class="row1 ">'.$this->get_payment_method($payment_info['paydeltype']).'</td>
					  <td class="row1 ">'.$this->get_shipping_method($payment_info['shippingtype']).'</td>
					  </tr>
					  </table>
					  
					  
					  
					  <h3>  '. __('Products Information').' </h3>
					 
					  <table width="100%" class="table " >
 					  <tr>
					  <td width="50%" align="left" class="title" ><strong> '. __('Product Name').'</strong></td>
					  <td width="13%" align="left" class="title" ><strong> '. __('Qty').'</strong></td>
					  <td width="13%" align="left" class="title" ><strong> '. __('Price').'</strong></td>
					  <td width="23%" align="left" class="title" ><strong> '. __('Price Total').'</strong></td>
					  </tr>';
					  $cart_info1 = $cart_info['cart_info'];
					  $subtotalprice = 0;
					  for($c=0;$c<count($cart_info1);$c++)
					  {
						$totalprc = $cart_info1[$c]['product_qty']*$cart_info1[$c]['product_gross_price'];
			$message .= '<tr>
					  <td class="row1" ><strong>'.$cart_info1[$c]['product_name'];
					  if($cart_info1[$c]['product_att'])
					  {
			$message .= '('.$cart_info1[$c]['product_att'].')';		  
					  }
			$message .='</strong></td>
					  <td class="row1 " >'.$cart_info1[$c]['product_qty'].'</td>
					  <td class="row1 tprice"  >'.$this->get_amount_format($cart_info1[$c]['product_gross_price'],0).'</td>
					  <td class="row1 tprice"  >'.$this->get_amount_format($totalprc,0).'</td>
					  </tr>';
					  $subtotalprice = $subtotalprice+$totalprc;
					  }
			$message .= '<tr>
					  <td colspan="3" align="right" class="row1" ><strong> '. __('Sub Total').' :</strong></td>
					  <td class="row1 tprice" ><strong>'.$this->get_amount_format($subtotalprice,0).'</strong></td>
					  </tr>';
			if($order_discount_amt)
			{
			$message .= '<tr>
					  <td colspan="3" align="right" class="row1" ><strong> '. __('Discount Amount').' :</strong> </td>
					  <td class="row1 tprice">'.$order_discount_amt.'</td>
					  </tr>';
			}
			if($payment_info['shippingtype'])
			{
			$message .= '<tr>
					  <td colspan="3" align="right" class="row1" ><strong>'.__($this->get_shipping_method($payment_info['shippingtype'])) .'  '. __('Amount').' :</strong> </td>
					  <td class="row1 tprice">'.$payment_info['shipping_amt'].'</td>
					  </tr>';
			}
			if($order_taxable_amt)
			{
			$message .= '<tr>
					  <td colspan="3" align="right" class="row1" ><strong> '. __('Tax Amount').' : </strong></td>
					  <td class="row1 tprice">'.$order_taxable_amt.'</td>
					  </tr>';
			}
			$message .= '<tr>
					  <td colspan="3" align="right" class="row2" ><strong> '. __('Total Payable Amount').' :</strong>  </td>
					  <td class="total_price" ><strong>'.$order_payable_amt.'</strong></td>
					  </tr>';
			if($isshow_paydetail)
			{
				if($payment_info['paydeltype'] == 'prebanktransfer')
				{
					$order_id = $order_info['order_id'];
					$order_amt = $order_info['payable_amt'];
					$paymentupdsql = "select option_value from $wpdb->options where option_name='payment_method_".$payment_info['paydeltype']."'";
					$paymentupdinfo = $wpdb->get_results($paymentupdsql);
					$paymentInfo = unserialize($paymentupdinfo[0]->option_value);
					$payOpts = $paymentInfo['payOpts'];
					$bankInfo = $payOpts[0]['value'];
					$accountinfo = $payOpts[1]['value'];
				$message .= ' 
						   <p> '. __('Please transfer amount of').' <u>'.$order_payable_amt.'</u>  '. __('to out bank with following information').':</p>
						 <p>  '. __('payment for Order Number').' : '. $order_id.' &nbsp;&nbsp;('. date(get_option('date_format').' '.get_option('time_format'),strtotime($order_info['order_date'])).')</p>
						 <p> '. __('Bank Name').' : '. $bankInfo.'</p>
						 <p> '. __('Account Number').' : '.$accountinfo.'</p>
						 
						   ';
				}
			}
			$message .='</table>
					  ';
			return $message;
		}
		
		function set_ordert_status($orderId,$order_status)
		{
			global $wpdb;
			$order_number = preg_replace('/([0-9]*([_]))/','',$orderId);
			$userId = preg_replace('/([_])([0-9]*)/','',$orderId);
			$ordersql = "select u.display_name,um.meta_value from $wpdb->usermeta as um join $wpdb->users as u on u.ID=um.user_id where um.meta_key = 'user_order_info' and um.user_id='".$userId."'";
			$orderinfo = $wpdb->get_results($ordersql);
			if($orderinfo)
			{
				foreach($orderinfo as $orderinfoObj)
				{
					$meta_value = unserialize(unserialize($orderinfoObj->meta_value)); 
					$display_name= $orderinfoObj->display_name;	
					$orderInformationArray = $meta_value[$order_number-1];
					$user_info = $orderInformationArray[0]['user_info'];
					$cart_info = $orderInformationArray[0]['cart_info'];
					$payment_info = $orderInformationArray[0]['payment_info'];
					$order_info = $orderInformationArray[0]['order_info'];
					$order_info['order_status']=$order_status;
					$order_info['order_status_date']=date('Y-m-d H:i:s');
					$orderInformationArray[0]['order_info'] = $order_info;
					$meta_value[$order_number-1] = $orderInformationArray;
					update_usermeta($userId, 'user_order_info', serialize($meta_value)); // Save Order Information Here
				}
			}
		}
		
		function get_post_array($postid)
		{
		$postCatArr = wp_get_post_categories($postid);
		$post_array = array();
		for($c=0;$c<count($postCatArr);$c++)
		{
			$category_posts=get_posts('category='.$postCatArr[$c]);
			foreach($category_posts as $post) 
			{
				if($post->ID !=  $postid)
				{
					$post_array[$post->ID] = $post;
				}
			}
		}
		return $post_array;
		}
		
		function get_digital_productpath()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			return $generalinfo['digitalproductpath'];
		}
		
		function get_post_images($pid)
		{
			$image_array = array();
			$pmeta = get_post_meta($pid, 'key', $single = true);
			if($pmeta['productimage'])
			{
				$image_array[] = $pmeta['productimage'];
			}
			if($pmeta['productimage1'])
			{
				$image_array[] = $pmeta['productimage1'];
			}
			if($pmeta['productimage2'])
			{
				$image_array[] = $pmeta['productimage2'];
			}
			if($pmeta['productimage3'])
			{
				$image_array[] = $pmeta['productimage3'];
			}
			if($pmeta['productimage4'])
			{
				$image_array[] = $pmeta['productimage4'];
			}
			if($pmeta['productimage5'])
			{
				$image_array[] = $pmeta['productimage5'];
			}
			if($pmeta['productimage6'])
			{
				$image_array[] = $pmeta['productimage6'];
			}
			return $image_array;
		}
		function get_post_image($pid)
		{
			$image_array = array();
			$pmeta = get_post_meta($pid, 'key', $single = true);
			if($pmeta['productimage'])
			{
				$image_array[] = $pmeta['productimage'];
			}
			if($pmeta['productimage1'])
			{
				$image_array[] = $pmeta['productimage1'];
			}
			if($pmeta['productimage2'])
			{
				$image_array[] = $pmeta['productimage2'];
			}
			if($pmeta['productimage3'])
			{
				$image_array[] = $pmeta['productimage3'];
			}
			if($pmeta['productimage4'])
			{
				$image_array[] = $pmeta['productimage4'];
			}
			if($pmeta['productimage5'])
			{
				$image_array[] = $pmeta['productimage5'];
			}
			if($pmeta['productimage6'])
			{
				$image_array[] = $pmeta['productimage6'];
			}
			return $image_array;
		}
		
		function get_checkout_method() //single page checkout
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['checkout_method']=='')
			{
				return "normal";
			}else
			{
				return $generalinfo['checkout_method'];
			}
		}
			function is_show_term_conditions()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			return $generalinfo['is_show_termcondition'];
		}
		function get_term_conditions_statement()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			return stripcslashes($generalinfo['termcondition']);
		}
		function get_loginpage_top_statement()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			return $generalinfo['loginpagecontent'];
		}
		
		function get_shipping_mehod()
		{
			global $wpdb;
			$paymentsql = "select * from $wpdb->options where option_name like 'shipping_method_%'";
			$paymentinfo = $wpdb->get_results($paymentsql);
			$shippingmethod = array();
			if($paymentinfo)
			{
				$shippingcount = 0;
				foreach($paymentinfo as $paymentinfoObj)
				{
					$paymentInfo = unserialize($paymentinfoObj->option_value);
					if($paymentInfo['isactive'])
					{
						$shippingcount++;
						$shippingmethod[] = $paymentInfo['key'];
					}
				}
			}
			if($shippingcount == 1)
			{
				return $shippingmethod;	
			}
		}
		function get_userinfo_mandatory_fields()
		{
			$return_array = array();
			if(!$this->is_storetype_digital())
			{
			$generalinfo = get_option('shoppingcart_general_settings');
			$return_array['bill_address1'] = $generalinfo['bill_address1'];
			$return_array['bill_address2'] = $generalinfo['bill_address2'];
			$return_array['bill_city'] = $generalinfo['bill_city'];
			$return_array['bill_state'] = $generalinfo['bill_state'];
			$return_array['bill_country'] = $generalinfo['bill_country'];
			$return_array['bill_zip'] = $generalinfo['bill_zip'];
			$return_array['bill_phone'] = $generalinfo['bill_phone'];
			}
			return $return_array;
		}
		
		function is_active_affiliate()
		{
			$generalinfo = get_option('affiliate_settings');
			if($generalinfo['is_active_affiliate'])
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_send_email_guest()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['send_email_guest'] || $generalinfo['send_email_guest'] == '')
			{
				return true;
			}else
			{
				return false;
			}
		}
		
		///manage stock start
		function is_set_stock_alert()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_set_min_stock_alert'] != '')
			{
				return $generalinfo['is_set_min_stock_alert'];
			}else
			{
				return '1';
			}
		}
		function is_show_stock_color()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_stock_color'] != '')
			{
				return $generalinfo['is_show_stock_color'];
			}else
			{
				return '1';
			}
		}
		function is_show_stock_size()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_show_stock_size'] != '')
			{
				return $generalinfo['is_show_stock_size'];
			}else
			{
				return '1';
			}
		}
		
		function check_stock($pid)
		{
			global $Cart;
			$data = get_post_meta( $pid, 'key', true );
			if(trim($data['initstock'])=='') //Unlimited stock
			{
				return "unlimited";
			}else
			{
				if($data['is_check_outofstock']=='on')
				{
					if(trim($data['initstock'])=='0') // Out of Stock
					{
						return "out_of_stock";
					}else
					{
						$sold_prd_count = $this->product_current_orders_count($pid);
						//$cart_stock = $Cart->get_product_qty_cart($pid);
						if($sold_prd_count)
						{
							$sold_prd_count = $sold_prd_count;	
						}
						if(($data['initstock'] - $sold_prd_count)>0)
						{
							return $data['initstock'] - $sold_prd_count;
						}else
						{
							return __("out_of_stock");
						}
					}
				}else
				{
					return "unlimited";
				}			
			}
		}
		function soldout_product_count($pid,$arg=array())
		{
				global $wpdb;
				$stdate = $arg['stdate'];
				$enddate = $arg['enddate'];
				if($enddate == '')
				{
					$enddate = date('Y-m-d H:i:s');
				}else
				{
					$enddate = $enddate;
				}
				$procuct_count = 0;
				$ordersql = "select u.display_name,um.meta_value from $wpdb->usermeta as um join $wpdb->users as u on u.ID=um.user_id  where um.meta_key = 'user_order_info' order by um.umeta_id desc";
				$orderinfo = $wpdb->get_results($ordersql);
				$attribute_count = 0;
				if($orderinfo)
				{
					
					foreach($orderinfo as $orderinfoObj)
					{
						$meta_value_arr = array();
						$meta_value = unserialize(unserialize($orderinfoObj->meta_value));
						$display_name= $orderinfoObj->display_name;
						$attribute_array = array();
						for($i=0;$i<count($meta_value);$i++)
						{
							$order_date = $meta_value[$i][0]['order_info']['order_date'];
							if($stdate !='' && $enddate !='')
							{
								if((strtotime($stdate)<=strtotime($order_date)) && (strtotime($enddate)>=strtotime($order_date)))
								{
									$order_status = $meta_value[$i][0]['order_info']['order_status'];
									$cart_info = $meta_value[$i][0]['cart_info']['cart_info'];
									if($cart_info)
									{
										for($c=0;$c<count($cart_info);$c++)
										{
											if(in_array($pid,$cart_info[$c]))
											{
												$procuct_count++;
											}		
										}
									}
								}
							}elseif($stdate =='' && $enddate !='')
							{
								if((strtotime($enddate)>=strtotime($order_date)))
								{
									
									$order_status = $meta_value[$i][0]['order_info']['order_status'];
									$cart_info = $meta_value[$i][0]['cart_info']['cart_info'];
									if($cart_info)
									{
										for($c=0;$c<count($cart_info);$c++)
										{
											if($arg['attribute'] && $cart_info[$c]['product_id']==$pid)
											{
												//echo $arg['attribute'];
												if(strstr($cart_info[$c]['product_att'],$arg['attribute']))
												 {
													$attribute_count = $attribute_count + $cart_info[$c]['product_qty'];
												 }
												/*for($at=0;$at<$cart_info[$c]['product_qty'];$at++)
												{
													$attribute_array = array_merge($attribute_array,explode(',',$cart_info[$c]['product_att']));
												}*/
											}else
											{
												if(in_array($pid,$cart_info[$c]))
												{
													$procuct_count = $procuct_count+$cart_info[$c]['product_qty'];
												}
											}		
										}
									}
								
								}
							}elseif($stdate !='' && $enddate =='')
							{
								if((strtotime($stdate)<=strtotime($order_date)))
								{
									$order_status = $meta_value[$i][0]['order_info']['order_status'];
									$cart_info = $meta_value[$i][0]['cart_info']['cart_info'];
									if($cart_info)
									{
										for($c=0;$c<count($cart_info);$c++)
										{
											if(in_array($pid,$cart_info[$c]))
											{
												$procuct_count++;
											}		
										}
									}
								
								}
							}
								
						}
					}
				}
				return $procuct_count;
		}
		function product_current_orders_count($pid,$arg=array())
		{
			$procuct_count =  $this->soldout_product_count($pid,$arg=array());
			
			if($_SESSION['CART_INFORMATION'])
			{
				for($i=0;$i<count($_SESSION['CART_INFORMATION']);$i++)
				{
					if($arg['attribute'] && $_SESSION['CART_INFORMATION'][$i]['product_id']==$pid)
					{
						if(strstr($_SESSION['CART_INFORMATION'][$i]['product_att'],$arg['attribute']))
						 {
							$attribute_count = $attribute_count + $_SESSION['CART_INFORMATION'][$i]['product_qty'];
						 }
						/*for($att=0;$att<$_SESSION['CART_INFORMATION'][$i]['product_qty'];$att++)
						{
							$attribute_array = array_merge($attribute_array,explode(',',$_SESSION['CART_INFORMATION'][$i]['product_att']));
						}*/
					}else
					{	
						if($pid == $_SESSION['CART_INFORMATION'][$i]['product_id'])
						{
							$procuct_count = $procuct_count+ $_SESSION['CART_INFORMATION'][$i]['product_qty'];		
						}
					}
				}
			}
			if($attribute_count)
			{				
				return $attribute_count;
			}else
			{
				return $procuct_count;
			}
		}
		function get_out_of_stock_text()
		{
			echo "Out of stock";
		}
		function send_out_of_stock_alert()
		{
			global $Cart;
			$cartInfo = $Cart->getcartInfo();
			for($c=0;$c<count($cartInfo);$c++)
			{
				$this->send_lowest_stock_limit_alert($cartInfo[$c]['product_id']);
			}
		}
		function send_lowest_stock_limit_alert($pid)
		{
			global $wpdb;
			if($this->is_set_stock_alert())
			{
				$data = get_post_meta( $pid, 'key', true );
				if(trim($data['initstock'])!='' && $data['is_check_outofstock']=='on')
				{
					if(trim($data['initstock'])=='0') // Out of Stock
					{
						
					}else
					{
						$sold_prd_count = $this->product_current_orders_count($pid);
						if($data['minstock']>0)
						{
							$sold_prd_count = $sold_prd_count + $data['minstock'];
						}
						if(($data['initstock'] - $sold_prd_count)<=0)
						{
							$prdsql = "select p.post_title from $wpdb->posts p where p.ID=\"$pid\"";
							$prdname = $wpdb->get_var($prdsql);
							$fromEmail = get_option('admin_email');
							$fromEmailName = get_option('blogname');
							$toEmail = $this->get_site_emailId();
							$toEmailName = $this->get_site_emailName();
							$product_url = get_option('siteurl').'/?p='.$pid;
							$subject = 'Product out of  stock alert';
							if(OUT_OF_STOCK_ALERT_EMAIL_MSG=='')
							{
								define('OUT_OF_STOCK_ALERT_EMAIL_MSG','<p>Dear [#$to_name#],</p><p>One of our product <b><a href="[#$product_url#]">[#$product_name#]</a></b> is Out of Stock and this is system generated Alert message for you to inform about lowest level of the product.</p><p>Stock Information is given below:</p><p>Opening Stock : [#$opening_stock#]</p><p>Minimum Stock : [#$minimum_stock#]</p><p>Thank You.</p>');
							}
							$search_array = array('[#$to_name#]','[#$product_url#]','[#$product_name#]','[#$opening_stock#]','[#$minimum_stock#]');
							$replace_array = array($toEmailName,$product_url,$prdname,$data['initstock'],$data['minstock']);
							$message = str_replace($search_array,$replace_array,OUT_OF_STOCK_ALERT_EMAIL_MSG);
							$this->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='');
						}
					}			
				}
			}
		}
		
		function display_stock_text($chk_stock)
		{
			if($chk_stock=='out_of_stock')
			{
				echo '<p>'.__('Current stock is').' : ';
				$this->get_out_of_stock_text();
				echo '</p>';
			}else
			{
				echo '<p>'.__('Current stock is').' : '.$chk_stock.'</p>';
			}
		}
		
		function get_attribute_str($attribute_array)
		{
			for($i=0;$i<count($attribute_array);$i++)
			{
				$attribute_array[$i] = trim(preg_replace('/[(]([+-]+)(.*)[)]/','',$attribute_array[$i]));
			}
			return $att_str = ','.implode(',',$attribute_array).',';
		}
		///manage stock end	
			function is_on_ssl_url()
		{
			$generalinfo = get_option('shoppingcart_general_settings');
			if($generalinfo['is_on_ssl'] || $generalinfo['is_on_ssl']=='')
			{
				return true;
			}else
			{
				return false;
			}
		}
		function get_ssl_normal_url($url)
		{
			if($this->is_on_ssl_url())
			{
				$url = str_replace('http://','https://',$url);
			}
			return $url;
		}
		function get_blog_sub_cats_str($type='array')
		{
			$catid = get_inc_categories("cat_exclude_");
			$catid_arr = explode(',',$catid);
			$blogcatids = '';
			$subcatids_arr = array();
			for($i=0;$i<count($catid_arr);$i++)
			{
				if($catid_arr[$i])
				{
					$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
				}
			}
			if($subcatids_arr && $type=='string')
			{
				$blogcatids = implode(',',$subcatids_arr);
				return $blogcatids;	
			}else
			{
				return $subcatids_arr;
			}			
		}
		function show_blog_link_header_nav()
		{
			global $General;
			$blogcatids = $General->get_blog_sub_cats_str('string');
			if($blogcatids && $General->is_show_blogpage())
			{
				wp_list_categories ('title_li=&depth=0&include=' . $blogcatids. '&sort_column=menu_order'); 
			}
			
		}
		
		function cart_detail_outofstock($pid,$qty=0,$pg='')
		{
			$data = get_post_meta( $pid, 'key', true );
			$sold_prd_count = $this->product_current_orders_count($pid);	
			if($qty)
			{
				$sold_prd_count = $sold_prd_count + $qty;	
			}
			if($data['initstock'])
			{
				if($data['initstock']=='0' || $data['initstock'] < $sold_prd_count)
				{
					$procuct_count =  $this->soldout_product_count($pid,$arg=array());
					$currentqty = $data['initstock'] - $procuct_count;
					if($currentqty>0)
					{
						if($pg=='pd' && $_SESSION['CART_INFORMATION']) //$pg='pd' --for product detail
						{
							for($i=0;$i<count($_SESSION['CART_INFORMATION']);$i++)
							{
								if($_SESSION['CART_INFORMATION'][$i]['product_id']==$pid)
								{
									$product_qty = $_SESSION['CART_INFORMATION'][$i]['product_qty'];
									//$submsg = __('You added '.$product_qty.' in Shopping Bag ');
									$currentqty  = $currentqty - $product_qty;
								}
							}
						}
						if($currentqty>0)
						{
							return __("Maximum available quantity is $currentqty only.");		
						}else
						{
							return __("Out of Stock<strong><br /><a href=\"". get_option('siteurl')."/?page=cart\">".__(VIEW_CART_DETAIL_TEXT)."</a> or <a href=\"". get_option('siteurl')."/?page=cart\">". __(CHECKOUT_TEXT)." &raquo;</a></strong>");
						}
					}else
					{
						return __("Out of Stock<strong><br /><a href=\"". get_option('siteurl')."/?page=cart\">".__(VIEW_CART_DETAIL_TEXT)."</a> or <a href=\"". get_option('siteurl')."/?page=cart\">". __(CHECKOUT_TEXT)." &raquo;</a></strong>");
					}
				}
			}
		}
		
		function get_amount_format($amount,$show_currency=1)
		{
			if($amount)
			{
				$amount = @number_format($amount,2);
				if($show_currency)
				{
					$amount = $this->get_currency_symbol().$amount;	
				}
				return $amount;
			}
		}
		
		
	}
	
	// Start this plugin once all other plugins are fully loaded
}
if(!$General)
{
	$General = new General();
}
?>