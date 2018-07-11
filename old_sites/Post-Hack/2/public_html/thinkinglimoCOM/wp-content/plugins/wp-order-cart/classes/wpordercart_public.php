<?php
/**
 * WP Order Cart Public Class
*/
class WPOrderCart_Public {

function __construct() {
    add_action('wp_enqueue_scripts', array($this, 'wpordercart_load_js'));
    add_action('wp_enqueue_scripts', array($this, 'wpordercart_general_css'));
    add_shortcode("wpordercart", array($this, "wpordercart_handler"));                
    add_action('wp_ajax_nopriv_wpordercart-ajax-submit', array($this, 'wpordercart_ajax_submit'));
    add_action('wp_ajax_wpordercart-ajax-submit', array($this, 'wpordercart_ajax_submit'));
}

public function wpordercart_load_js() {
    wp_enqueue_script('jquery');			
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script('jquery-ui-slider');
    wp_register_script('wpordercart_lib_js', plugins_url('/js/lib.js', dirname(__FILE__)));
    wp_enqueue_script('wpordercart_lib_js');		
    wp_register_script('wpordercart_js', plugins_url('/js/wpordercart.js', dirname(__FILE__)));
    wp_enqueue_script('wpordercart_js');
    wp_localize_script('wpordercart_js', 'WPOrderCartAjaxO', array('ajaxurl' => admin_url('admin-ajax.php' )));	
	//if (is_tax('product_category') || is_post_type_archive('products')) {
    	wp_register_script('wpordercart_fancybox_js', plugins_url('/js/jquery.fancybox.js?v=2.1.3', dirname(__FILE__)));
	    wp_enqueue_script('wpordercart_fancybox_js');	
    	wp_register_script('wpordercart_fancybox_btns_js', plugins_url('/js/jquery.fancybox-buttons.js?v=1.0.5.js', dirname(__FILE__)));
	    wp_enqueue_script('wpordercart_fancybox_btns_js');	
    	wp_register_script('wpordercart_fancybox_thumbs_js', plugins_url('/js/jquery.fancybox-thumbs.js?v=1.0.7', dirname(__FILE__)));
	    wp_enqueue_script('wpordercart_fancybox_thumbs_js');	
    	wp_register_script('wpordercart__fancybox_media_js', plugins_url('/js/jquery.fancybox-media.js?v=1.0.5', dirname(__FILE__)));
	//}
}

public function wpordercart_general_css() {
	wp_register_style('wpordercart-general-css', plugins_url('css/style.css', dirname(__FILE__)));
    wp_enqueue_style('wpordercart-general-css');
	wp_register_style('wpordercart-ui-css', plugins_url('css/smoothness/jquery-ui-1.9.0.custom.min.css', dirname(__FILE__)));
    wp_enqueue_style('wpordercart-ui-css');
	//if (is_tax('product_category') || is_post_type_archive('products')) {
		wp_register_style('wpordercart-fancybox-css', plugins_url('css/jquery.fancybox.css?v=2.1.2', dirname(__FILE__)));
    	wp_enqueue_style('wpordercart-fancybox-css');
		wp_register_style('wpordercart-fancybox-btns-css', plugins_url('css/jquery.fancybox-buttons.css?v=1.0.5', dirname(__FILE__)));
	    wp_enqueue_style('wpordercart-fancybox-btns-css');
		wp_register_style('wpordercart-fancybox-thumbs-css', plugins_url('css/jquery.fancybox-thumbs.css?v=1.0.7', dirname(__FILE__)));
	    wp_enqueue_style('wpordercart-fancybox-thumbs-css');
	//}
}

//Public view | Inlcude in pages or posts with [wpordercart display="product" id="1" ]

/*
[wpordercart display="product" id="1" ]
*/

function wpordercart_handler($atts) {
	extract( 
		shortcode_atts( 
			array(
				'display' => '-1',
				'id' => '-1'				
				), $atts));
	$returnhtml = $this->wpordercart_get_content($display, $id);	
	return $returnhtml;
}

function wpordercart_get_content($display, $id) {
	$htmlstr = "";
	switch ($display) {
		case "product":
			$htmlstr = $this->wpordercart_display_single_product($id);
			break;
		case "-1":
			$htmlstr = "<p>No selection specified.</p>";
			break;
	}
	$htmlstr .= "<input type='hidden' id='jslib' value='" . $display . "' />";
	$htmlstr .= "
<!-- WPOrderCart Public UI General Form -->
<div id='wpocshoppingcartwidget-public-dialog-msg' style='display:none;' >
	<br />
	<div id='wpocshoppingcartwidget-div-public-dialog-msg-content' >&nbsp;</div>
</div>		
";
	return $htmlstr;
}

function wpordercart_display_single_product($productid) {
	$producttitle = get_the_title($productid);
	$linktoproduct = "<h2><a href='" . get_permalink($productid) . "' >" . $producttitle . "</a></h2>";
	$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($productid), 'medium');
    $productimgstr = "<a class='fancybox-effects-c' href='" . $large_image_url[0] . "' title='" . $producttitle . "' >" . get_the_post_thumbnail($productid, 'thumbnail') . "</a>";
	$skustr = get_post_meta($productid, "sku", true);
	$wpordercart_default_currency = get_option("wpordercart_default_currency");
	$wpordercart_default_currency_symbol = wpordercart_getsymbolfromcode($wpordercart_default_currency);
	$wpordercart_default_currency_description = wpordercart_getdescriptionfromcode($wpordercart_default_currency);
	$wpordercart_show_price = get_option("wpordercart_show_price");	
	$porstr = "<span title='Price On Request' >P.O.R.</span>";
	$pricestr = "";
	switch ($wpordercart_show_price) {
		case "y":
			$pricestr = get_post_meta($productid, "price", true);
			if ($pricestr == "") {
				$pricestr = $porstr;
			} else {
				$pricestr = "<span title='" . $wpordercart_default_currency_description . "' >" . $wpordercart_default_currency_symbol . "</span>&nbsp;" . $pricestr;	
			}
			break;
		case "por":
			$pricestr = $porstr;
			break;
	}
	$returnhtmlstr = "
<table style='width:150px; float:left; margin-left:15px;' >
	<tr><td colspan='2' style='border:none;' ><h2>" . $linktoproduct . "</h2></td></tr>
	<tr><td colspan='2' style='padding:15px; border:none;' >" . $productimgstr . "</td></tr>";
	if ($skustr != "") { 
		$returnhtmlstr .= "
	<tr>
		<td style='font-weight:bold; border:none;' >SKU:&nbsp;</td>
		<td style='border:none;' >" . $skustr . "</td>
	</tr>";		
	}
	if ($wpordercart_show_price != "n") {
		$returnhtmlstr .= "
	<tr>
    	<td style='font-weight:bold; border:none;' >Price:&nbsp;</td>
	    <td style='border:none;' >" . $pricestr . "</td>
	</tr>";
	}
	$returnhtmlstr .= "
</table>";				
	return $returnhtmlstr;
}

function wpordercart_ajax_submit() {
    $return['error'] = true;	
    $cmd = htmlspecialchars($_POST['cmd']);
    switch ($cmd) {
    	case 'add-to-cart':
		$productid = htmlspecialchars(trim($_POST['productid']));
		$qty = htmlspecialchars(trim($_POST['qty']));
		session_start();
		if(isset($_SESSION['ordercart_products_arr'])) {
			$ordercart_products_arr = $_SESSION['ordercart_products_arr'];
			$found = false;
			foreach($ordercart_products_arr as $key => $value) {
				if ($productid == $key) {
					$_SESSION['ordercart_products_arr'][$productid]["qty"] += $qty; 
					$found = true;
				}
			}	
		}
		if (!$found) {
			$product = array();
			$product['qty'] = $qty;
			$_SESSION['ordercart_products_arr'][$productid] = $product;	
		}
		$return['error'] = false; 
		break;
	case 'update-cart':
		$productid = htmlspecialchars(trim($_POST['productid']));
		$qty = htmlspecialchars(trim($_POST['qty']));
		session_start();
		$ordercart_products_arr = $_SESSION['ordercart_products_arr'];
		foreach($ordercart_products_arr as $key => $value) {
			if ($productid == $key) {
				$_SESSION['ordercart_products_arr'][$productid]["qty"] = $qty; 
			}
		}
		$return['error'] = false; 
		break;		
	case 'get-cart':
		$return['ordercarthtml'] = $this->get_order_cart(); 
		$return['error'] = false; 
		break;
    case 'get-cart-checkout':
		$name = htmlspecialchars(trim($_POST['name']));
		$city = htmlspecialchars(trim($_POST['city']));
		$telno = htmlspecialchars(trim($_POST['telno']));
		$emailaddress = htmlspecialchars(trim($_POST['emailaddress']));
		$return['ordercartcheckouthtml'] = $this->wpordercartgetcartcheckout($name, $city, $telno, $emailaddress); 
		$return['error'] = false; 
		break;				
	case 'empty-cart':
		session_start();
		unset($_SESSION['ordercart_products_arr']);
		$return['error'] = false; 
		break;				
	case 'submit-order-form':
		$name = htmlspecialchars(trim($_POST['name']));
		$city = htmlspecialchars(trim($_POST['city']));
		$telno = htmlspecialchars(trim($_POST['telno']));
		$emailaddress = htmlspecialchars(trim($_POST['emailaddress']));
		$adminsentresponsestr = $this->wpordercart_validatesentresponse($this->wpordercartsendorderform($name, $city, $telno, $emailaddress, true));
		if ($adminsentresponsestr != "ok") {
			$return['msg'] = $adminsentresponsestr;
		} else {
			$buyersentresponsestr = $this->wpordercart_validatesentresponse($this->wpordercartsendorderform($name, $city, $telno, $emailaddress, false));
			if ($buyersentresponsestr != "ok") {
				$return['msg'] = $buyersentresponsestr;
			} else {
				$return['error'] = false;
			}
		}
		break;	
    }
    $response = json_encode($return);
    header("Content-Type: application/json");
    echo $response;
    exit;
}

function wpordercart_validatesentresponse($sentresponsestr) {
	switch ($sentresponsestr) {
		case "no_cart_session":
			return "No active cart session found, add some products.";	
		case "order_email_address":
			return "WP Order Cart setup error: Email address to receive orders not specified.";	
		case "empty_cart":
			return "Cart is empty, add some products.";	
		case "send_fail":	
			return "Email could not be sent.";	
		case "ok":
			return "ok";	
	}
}

function get_order_cart() {
	$returnhtmlstr = "";
	$ordercarthtmlstr = "";
	$noitemsincasrthtmlstr = "
		<table>
			<tr>
				<td style='height:25px; vertical-align:middle;' >No items in shopping cart.</td>
				<td style='height:25px; padding-left:5px; vertical-align:middle;' ><img class='cartloading' src='" . plugins_url('/img/loading.gif', dirname(__FILE__)) . "' title='Loading...' style='border:none; display:none;' /></td>
			</tr>	
		</table>		
";
	session_start();
	if(!isset($_SESSION['ordercart_products_arr'])) {
		return $noitemsincasrthtmlstr;
	}
	$ordercart_products_arr = $_SESSION['ordercart_products_arr'];
	$ordercarttotalint = 0;
	foreach($ordercart_products_arr as $key => $value) {
		foreach($value as $key2 => $value2) {
			if ($value2 > 0) { 
				$productname = get_the_title($key);
				$porstr = "<span title='Price On Request' >P.O.R.</span>";
				$wpordercart_show_price = get_option("wpordercart_show_price");	
				if ($wpordercart_show_price == "y") {
					$wpordercart_default_currency = get_option("wpordercart_default_currency");
					$wpordercart_default_currency_symbol = wpordercart_getsymbolfromcode($wpordercart_default_currency);
					$wpordercart_default_currency_description = wpordercart_getdescriptionfromcode($wpordercart_default_currency);	
					$pricestr = get_post_meta($key, "price", true);
					$rowtotalint = 0;
					if ($pricestr != "" && is_numeric($pricestr)) {
						$rowtotalint = $pricestr * $value2;
						$ordercarttotalint += $rowtotalint;
						$pricestr = "<span title='" . $wpordercart_default_currency_description . "' >" . $wpordercart_default_currency_symbol . "</span>&nbsp;" . $rowtotalint;
					} else {
						$pricestr = $porstr;
					}	
				}
				$productid = $key;
				$thumbimgstr = "";
				$thumburlstr = wp_get_attachment_url(get_post_thumbnail_id($key));
				if ($thumburlstr) {
					$thumbimgstr = "<img src='" . $thumburlstr . "' style='border:none; width:25px;' />";
				}
				$ordercarthtmlstr .= "
					<tr>
						<td>" . $thumbimgstr . "</td>
						<td style='font-size:15px;' >" . $productname . "</td>
						<td>
							<table cellpadding='0' cellspacing='0' style='border:none;' >
								<tr>
									<td style='vertical-align:middle;' ><input id='txtupdatecartqty_" . $productid . "' type='text' value='" . $value2 . "' class='numbersOnly' maxlength='5' style='width:25px;' /></td>
									<td style='vertical-align:middle;' >
										<table cellpadding='0' cellspacing='0' style='border:none;' >
											<tr><td style='vertical-align:middle;' ><a id='aupdatecart_" . $productid . "' class='aupdatecart' href='javascript:void(0);' ><img src='" . plugins_url('img/cart_edit.png', dirname(__FILE__)) . "' title='Update cart' style='border:none; max-width:16px;' /></a></td></tr>
											<tr><td style='vertical-align:middle;' ><a id='aremovecart_" . $productid . "' class='aupdatecart' href='javascript:void(0);' ><img src='" . plugins_url('img/cart_delete.png', dirname(__FILE__))  . "' title='Remove from cart' style='border:none; max-width:16px;' /></a></td></tr>
										</table>
									</td>
									
								</tr>
							</table>				
						</td>";
				if ($wpordercart_show_price == "y") {
					$ordercarthtmlstr .= "<td>" . $pricestr . "</td>";
				} else {
					$ordercarthtmlstr .= "<td>&nbsp;</td>";
				}
				$ordercarthtmlstr .= "</tr>";
			}
		}
	}
	if ($ordercarthtmlstr == "") {
		$returnhtmlstr = $noitemsincasrthtmlstr;
	} else {
		$returnhtmlstr = "
<table class='tblshoppingcart' cellpadding='0' cellspacing='0' >
	<tr style='font-weight:bold;' ><td>&nbsp;</td><td>Product</td><td>Qty</td>";
		if ($wpordercart_show_price == "y") {
			$returnhtmlstr .= "<td>Price</td>";
		}
		$returnhtmlstr .= "	
	</tr>
	" . $ordercarthtmlstr . "
	<tr>
		<td style='padding:5px;' colspan='2' >
			<table style='border:none;' >
				<tr>
					<td style='vertical-align:middle;' ><a id='aordercarthowto' href='javascript:void(0);' ><img src='" . plugins_url('/img/information.png', dirname(__FILE__)) . "' title='How to Order' style='border:none;' /></a></td>
					<td style='vertical-align:middle;' ><a id='aemptycart' href='javascript:void(0);' ><img src='" . plugins_url('/img/cart_remove.png', dirname(__FILE__)) . "' title='Empty shopping cart' style='border:none;' /></a></td>
					<td style='vertical-align:middle;' ><a id='acheckout' href='javascript:void(0);' ><img src='" . plugins_url('/img/cart_go.png', dirname(__FILE__)) . "' title='Check out' style='border:none;' /></a></td>
					<td style='vertical-align:middle; width:16px;' ><img id='imgcartloading' class='cartloading' src='" . plugins_url('/img/loading.gif', dirname(__FILE__)) . "' title='Loading...' style='border:none; display:none;' /></td>
				</tr>
			</table>				
		</td>";
		if ($wpordercart_show_price == "y") {
			$returnhtmlstr .= "<td style='font-weight:bold; text-align:right;' colspan='2' >Total:&nbsp;<span title='" . $wpordercart_default_currency_description . "' >" . $wpordercart_default_currency_symbol . "&nbsp;" . $ordercarttotalint . "</td>";
		} 
		$returnhtmlstr .= "
	</tr>
</table>	
";
	}
	return $returnhtmlstr;
}

function wpordercartgetcartcheckout($name, $city, $telno, $emailaddress) {
	session_start();
	if(!isset($_SESSION['ordercart_products_arr'])) {
		return "<div style='padding-top:15px;' >No items in shopping cart.</div>";
	}
	$ordercart_products_arr = $_SESSION['ordercart_products_arr'];
	$tablehtmlstr = "";
	$productshtmlstr = "";
	$atleastone = false;
	$atleastonesku = false;
	foreach($ordercart_products_arr as $key => $value) {
		foreach($value as $key2 => $value2) {
			if ($value2 > 0) { 
				$atleastone = true;
				$productname = get_the_title($key);
				$porstr = "<span title='Price On Request' >P.O.R.</span>";
				$wpordercart_show_price = get_option("wpordercart_show_price");	
				if ($wpordercart_show_price == "y") {
					$wpordercart_default_currency = get_option("wpordercart_default_currency");
					$wpordercart_default_currency_symbol = wpordercart_getsymbolfromcode($wpordercart_default_currency);
					$wpordercart_default_currency_description = wpordercart_getdescriptionfromcode($wpordercart_default_currency);	
					$pricestr = get_post_meta($key, "price", true);
					$rowtotalint = 0;
					if ($pricestr != "" && is_numeric($pricestr)) {
						$rowtotalint = $pricestr * $value2;
						$ordercarttotalint += $rowtotalint;
						$pricestr = "<span title='" . $wpordercart_default_currency_description . "' >" . $wpordercart_default_currency_symbol . "</span>&nbsp;" . $rowtotalint;						
					} else {
						$pricestr = $porstr;
					}	
				}
				$productid = $key;
				$productsku = get_post_meta($key, "sku", true);
				if ($productsku != "") { $atleastonesku = true; }
				//$pricestr = get_post_meta($key, "price", true);
				/*if (strlen($productname) >= 30) {
					$productname = substr($productname, 0, 27) . "...";
				}*/
				$thumbimgstr = "";
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($key), 'medium');
	    		$thumbimgstr = '<a class="fancybox-effects-c" href="' . $large_image_url[0] . '" title="' . $productname . '" >' . get_the_post_thumbnail($key, 'thumbnail') . '</a>';
				$productshtmlstr .= "
					<tr>
						<td style='width:135px; vertical-align:middle;' >" . $thumbimgstr . "</td>
						<td style='font-size:14px; vertical-align:middle;' class='tdproductsku' >" . $productsku . "</td>
						<td style='font-size:13px; vertical-align:middle;' >" . $productname . "</td>
						<td style='vertical-align:middle;' >
							<table cellpadding='0' cellspacing='0' >
								<tr>
									<td style='vertical-align:middle;' ><input id='txtupdatecartqtyo_" . $productid . "' type='text' value='" . $value2 . "' class='numbersOnly' maxlength='5' style='width:25px;' />&nbsp;</td>
									<td style='vertical-align:middle;' >
										<table cellpadding='0' cellspacing='0' >
											<tr><td><a id='aupdatecarto_" . $productid . "' class='aupdatecart' href='javascript:void(0);' ><img src='" . plugins_url('/img/cart_edit.png', dirname(__FILE__)) . "' title='Update cart' style='border:none;' /></a></td></tr>
											<tr><td><a id='aremovecarto_" . $productid . "' class='aupdatecart' href='javascript:void(0);' ><img src='" . plugins_url('/img/cart_delete.png', dirname(__FILE__)) . "' title='Remove from cart' style='border:none;' /></a></td></tr>
										</table>
									</td>
								</tr>
							</table>				
						</td>";
				if ($wpordercart_show_price == "y") {
					$productshtmlstr .= "<td style='vertical-align:middle;' >" . $pricestr . "</td>";
				} else {
					$productshtmlstr .= "<td>&nbsp;</td>";
				}
				$productshtmlstr .= "</tr>";
			}
		}
	}
	if ($atleastone) {
	$tablehtmlstr =	"
<tr style='font-weight:bold; font-size:18px;' ><td>&nbsp;</td><td class='tdproductsku' >SKU</td><td>Product</td><td>Quantity</td>";
	if ($wpordercart_show_price == "y") {
		$tablehtmlstr .= "<td>Price</td>";
	} else {
		$tablehtmlstr .= "<td>&nbsp;</td>";
	}
	$tablehtmlstr .= "</tr>" 
. $productshtmlstr . "
<tr>
	<td colspan='1' style='padding-left:15px;' ><a id='aemptycarto' href='javascript:void(0);' title='Empty shopping cart' ><img src='" . plugins_url('/img/cart_remove.png', dirname(__FILE__)) . "' style='border:none;' /></a></td>";
	if ($wpordercart_show_price == "y") {
		$tablehtmlstr .= "	
		<td colspan='4' style='font-weight:bold; font-size:15px; text-align:right; padding-right:10px;' >Total:&nbsp;<span title='" . $wpordercart_default_currency_description . "' >" . $wpordercart_default_currency_symbol . "&nbsp;" . $ordercarttotalint . "</td></tr>";
	} else {
		$tablehtmlstr .= "<td colspan='4' >&nbsp;</td>";	
	}
	$wpordercart_order_button_css_class = get_option("wpordercart_order_button_css_class");
	$tablehtmlstr .= "
<tr><td colspan='5'	>
	<br />
	<table style='width:100%;' >
		<tr><td style='font-size:16px; font-weight:bold;' colspan='2' >Please complete the order form:</td></tr>
		<tr><td style='font-size:12px;' colspan='2' >Fields marked with an asterisk must be filled in.</td></tr>
		<tr><td style='font-size:14px; font-weight:bold;' >Your details</td></tr>
		<tr><td>Name:&nbsp;</td><td><input id='txtname' maxlength='250' style='width:250px;' value='" . $name . "' />&nbsp;<span class='requiredfield' >*</span></td></tr>
		<tr><td>City:&nbsp;</td><td><input id='txtcity' maxlength='250' style='width:250px;' value='" . $city . "' />&nbsp;<span class='requiredfield' >*</span></td></tr>
		<tr><td>Contact No:&nbsp;</td><td><input id='txttelno' maxlength='50' style='width:250px;' value='" . $telno . "' />&nbsp;<span class='requiredfield' >*</span></td></tr>
		<tr><td>Email:&nbsp;</td><td><input id='txtemailaddress' maxlength='250' style='width:250px;' value='" . $emailaddress . "' />&nbsp;<span class='requiredfield' >*</span></td></tr>
		<tr>
			<td style='vertical-align:middle;' >
				<input id='btnsubmitorder' type='button' value='Place Order' style='font-size:16px; font-weight:bold; padding:5px;' ";
	if ($wpordercart_order_button_css_class) { $tablehtmlstr .= "class='" . $wpordercart_order_button_css_class . "' "; } 
	$tablehtmlstr .= "/>
			</td>
			<td style='vertical-align:middle;' >
				&nbsp;
				<span id='spancheckoutloading' style='font-size:14px; display:none;' >Contacting server, please wait...</span> 
			</td>
		</tr>		
	</table>
</td></tr>		
		";
	} else {
		$tablehtmlstr = "<tr><td colspan='2' >No items in shopping cart.</td></tr>";
	}
	$tablehtmlstr = "<table>" . $tablehtmlstr . "</table>";
	if (!$atleastonesku) {
		$tablehtmlstr .= "
<script type='text/javascript' >
	(function($) {
		$(function () {	
			$('.tdproductsku').css('display', 'none');
		});
	})(jQuery);    
</script>
";
	}
	return $tablehtmlstr;
}

function wpordercartsendorderform($name, $city, $telno, $emailaddress, $toadmin) {
	session_start();
	if(!isset($_SESSION['ordercart_products_arr'])) {
		return "no_cart_session";
	}
	$wpordercart_order_email_address = get_option("wpordercart_order_email_address");
	if ($wpordercart_order_email_address == false) {
		return "order_email_address";
	}
	$ordercart_products_arr = $_SESSION['ordercart_products_arr'];
	$atleastonesku = $this->wpordercart_cartproductshassku($ordercart_products_arr);
	$orderemailstr = "";
	$tablehtmlstr = "";
	$atleastone = false;
	foreach($ordercart_products_arr as $key => $value) {
		foreach($value as $key2 => $value2) {
			if ($value2 > 0) { 
				$atleastone = true;
				$productname = "<a href=" . get_permalink($key) . " >" . get_the_title($key) . "</a>";
				$porstr = "<span title='Price On Request' >P.O.R.</span>";
				$wpordercart_show_price = get_option("wpordercart_show_price");	
				if ($wpordercart_show_price == "y") {
					$wpordercart_default_currency = get_option("wpordercart_default_currency");
					$wpordercart_default_currency_symbol = wpordercart_getsymbolfromcode($wpordercart_default_currency);
					$wpordercart_default_currency_description = wpordercart_getdescriptionfromcode($wpordercart_default_currency);	
					$pricestr = get_post_meta($key, "price", true);
					$rowtotalint = 0;
					if ($pricestr != "" && is_numeric($pricestr)) {
						$rowtotalint = $pricestr * $value2;
						$ordercarttotalint += $rowtotalint;
						$pricestr = $wpordercart_default_currency_symbol . "&nbsp;" . $rowtotalint;						
					} else {
						$pricestr = $porstr;
					}	
				}
				$productid = $key;
				$productsku = get_post_meta($key, "sku", true);
				//$pricestr = get_post_meta($key, "price", true);
				/*if (strlen($productname) >= 30) {
					$productname = substr($productname, 0, 27) . "...";
				}*/
				$thumbimgstr = get_the_post_thumbnail($key, 'thumbnail');
				$tablehtmlstr .= "
					<tr>
						<td style='width:135px; vertical-align:middle; padding:5px; text-align:center;' >" . $thumbimgstr . "</td>";
				if ($atleastonesku) { 
					$tablehtmlstr .= 
						"<td style='vertical-align:middle; padding:5px; text-align:center;' >" . $productsku . "</td>";
				}
				$tablehtmlstr .= "						
						<td style='vertical-align:middle; padding:5px; text-align:center;' >" . $productname . "</td>
						<td style='vertical-align:middle; padding:5px; text-align:center;' >" . $value2 . "</td>";
				if ($wpordercart_show_price == "y") {
					$tablehtmlstr .= "<td style='vertical-align:middle; padding:5px; text-align:center;' >" . $pricestr . "</td>";
				} else {
					$tablehtmlstr .= "<td>&nbsp;</td>";
				}
				$tablehtmlstr .= "</tr>";
			}
		}
	}
	if ($atleastone) {
		$orderemailstr = "<table>";
		$orderemailstr .= "<tr style='font-weight:bold; font-size:18px;' ><td style='padding:5px;' >&nbsp;</td>";
		if ($atleastonesku) { $orderemailstr .= "<td style='padding:5px; text-align:center;' >SKU</td>"; }
		$orderemailstr .= "<td style='padding:5px; text-align:center;' >Product</td><td style='padding:5px; text-align:center;' >Quantity</td>";
		if ($wpordercart_show_price == "y") {
			$orderemailstr .= "<td style='padding:5px; text-align:center;' >Price</td>"; 
		} else {
			$orderemailstr .= "<td>&nbsp;</td>";
		}
		$orderemailstr .= "</tr>";
		$orderemailstr .= "<tr><td colspan='5' >&nbsp;</td></tr>";		
		$orderemailstr .= $tablehtmlstr;		
		$orderemailstr .= "<tr><td colspan='5' >&nbsp;</td></tr>";
		if ($wpordercart_show_price == "y") {
			$orderemailstr .= "<tr><td colspan='2' style='font-weight:bold; font-size:14px;' >Prices in " . $wpordercart_default_currency_description . ".</td><td colspan='3' style='font-weight:bold; font-size:15px; text-align:right; padding-right:10px;' >Total:&nbsp;" . $wpordercart_default_currency_symbol . "&nbsp;" . $ordercarttotalint . "</td></tr>";
		}
		$orderemailstr .= "<tr><td colspan='5' >&nbsp;</td></tr>";				
		if ($toadmin) {
			$buyertitlestr = "Buyer"; 
		} else {
			$buyertitlestr = "Your"; 
		}
		$orderemailstr .= "<tr><td colspan='5' style='font-weight:bold; padding:5px; font-size:16px;' >" . $buyertitlestr . " details:</td></tr>";		
		$orderemailstr .= "<tr><td colspan='5' ><table>";		
		$orderemailstr .= "<tr><td style='font-weight:bold; padding:5px;' >Name:&nbsp;</td><td style='padding:5px;' >" . $name . "</td></tr>";
		$orderemailstr .= "<tr><td style='font-weight:bold; padding:5px;' >City:&nbsp;</td><td style='padding:5px;' >" . $city . "</td></tr>";
		$orderemailstr .= "<tr><td style='font-weight:bold; padding:5px;' >Contact No:&nbsp;</td><td style='padding:5px;' >" . $telno . "</td></tr>";
		$orderemailstr .= "<tr><td style='font-weight:bold; padding:5px;' >Email:&nbsp;</td><td style='padding:5px;' ><a href='mailto:" . $emailaddress . "' >" . $emailaddress . "</a></td></tr>";
		$orderemailstr .= "</table></td></tr>";		
		$orderemailstr .= "</table>";	
	} else {
		return "empty_cart";
	}
	
	$message = "";
	$sitenameurlstr = "<a href='" . site_url() . "' >" . get_bloginfo('name') . "</a>";
	if ($toadmin) {
		$message .= "<br />New order received from " . $sitenameurlstr . ".";
	} else {
		$message .= "<br />This is a confirmation email regarding your order with " . $sitenameurlstr . ".";
	}
	$message .= "<br /><br /><h2>Order details</h2><br />" . $orderemailstr;
	$emailsubjectstr = "";
	$fromemailaddstr = "";
	$replytoemailaddstr = "";
	if (!$toadmin) {
		$wpordercart_order_email_thank_you_msg = get_option("wpordercart_order_email_thank_you_msg");
		if (!$wpordercart_order_email_thank_you_msg) {
			$wpordercart_order_email_thank_you_msg = "Thank you for your order.";
		}
		$message .= "<br /><p>" . $wpordercart_order_email_thank_you_msg . "</p>";
		$emailsubjectstr = "Order confirmation from " . get_bloginfo('name');
		$toemailaddstr = $emailaddress;
		$fromemailaddstr = $wpordercart_order_email_address;
		$replytoemailaddstr = $wpordercart_order_email_address;
	} else {
		$emailsubjectstr = "New order received from " . get_bloginfo('name');
		$toemailaddstr = $wpordercart_order_email_address;
		$fromemailaddstr = $emailaddress;
		$replytoemailaddstr = $emailaddress;
	}
	if (wpordercartsendmail($toemailaddstr, $fromemailaddstr, $replytoemailaddstr, $emailsubjectstr, $message)) {
		return "ok";
	} else {
		return "send_fail";
	}
}

function wpordercart_cartproductshassku($ordercart_products_arr) {
	foreach($ordercart_products_arr as $key => $value) {
		foreach($value as $key2 => $value2) {
			if ($value2 > 0) { 
				$productsku = get_post_meta($key, "sku", true);
				if ($productsku != "") { return true; }
			}
		}
	}
	return false;
}

} //end class