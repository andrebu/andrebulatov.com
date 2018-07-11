<?php
/**
 * WP Order Cart Admin Class
*/
class WPOrderCart_Admin {

function __construct() {
    add_action('admin_menu', array($this, 'wpordercart_admin_menu'));
    add_action('admin_print_styles', array($this, 'register_admin_styles'));
	add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));
	add_action('wp_ajax_wpordercart-admin-ajax-submit', array($this, 'wpordercart_admin_ajax_submit'));   }
    
function register_admin_styles() {
    wp_register_style('wpordercart-admin-general-css', plugins_url('/css/admin-style.css', dirname(__FILE__)));
    wp_enqueue_style('wpordercart-admin-general-css');
    wp_register_style('wpordercart-ui-css', plugins_url('/css/smoothness/jquery-ui-1.9.0.custom.min.css', dirname(__FILE__)));
    wp_enqueue_style('wpordercart-ui-css');		
} 

function register_admin_scripts() {
	wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script('jquery-ui-tabs');				
    wp_register_script('wpordercart_lib_js', plugins_url('/js/lib.js', dirname(__FILE__)));
    wp_enqueue_script('wpordercart_lib_js');		
    wp_register_script('wpordercart_admin_js', plugins_url('/js/wpordercart_admin.js', dirname(__FILE__ )));
    wp_enqueue_script('wpordercart_admin_js');
    wp_localize_script('wpordercart_admin_js', 'WPOrderCartAdminAjaxO', array('ajaxurl' => admin_url('admin-ajax.php')));
}
	
//Admin Menu
function wpordercart_admin_menu() {
    if (current_user_can('manage_options'))  {
	   add_menu_page('WP Order Cart Settings', 'WP Order Cart', 'manage_options', 'wpordercart_dashboard_mh', array($this, 'wpordercart_dashboard'), plugins_url('img/cart.png' , dirname(__FILE__)), 100);
	}
}
	
function wpordercart_dashboard() {
    echo ($this->wpordercart_get_admin_content("settings"));
}

function wpordercart_get_admin_content($contentcode) {
    $htmlstr = "";
    if (current_user_can('manage_options')) { 
        switch ($contentcode) {
            case "settings":
        	    $args = array( 'name' => 'checkout_page_id', 'echo' => 0);
                $ddlpagesstr = wp_dropdown_pages($args);
        		$wpordercart_default_currency = get_option("wpordercart_default_currency");
    			$wpordercart_show_price = get_option("wpordercart_show_price");	
    			$wpordercart_checkout_page_id = get_option("wpordercart_checkout_page_id");
    			$wpordercart_order_email_address = get_option("wpordercart_order_email_address");
    			$wpordercart_order_button_css_class = get_option("wpordercart_order_button_css_class");
                $wpordercart_order_instructions = get_option("wpordercart_order_instructions");
                if (!$wpordercart_order_instructions) {
                    $wpordercart_order_instructions = "We will then receive the order details and will be in contact with you shortly after that";
                }
                $wpordercart_order_thank_you_msg = get_option("wpordercart_order_thank_you_msg");
			    if (!$wpordercart_order_thank_you_msg) {
    				$wpordercart_order_thank_you_msg = "Thank you for your order.";
			    }
			    $wpordercart_order_email_thank_you_msg = get_option("wpordercart_order_email_thank_you_msg");
			    if (!$wpordercart_order_email_thank_you_msg) {
           		    $wpordercart_order_email_thank_you_msg = "Thank you for your order.";
			    }
                $htmlstr = "
<div class='wrap' >
	<h2>WP Order Cart Settings</h2>
	<label id='lblmsg' class='lblmsgerror' >&nbsp;</label>
	<br /><br />		
	<div id='wpordercart-tabs-settings' >
	    <ul>
    	    <li><a href='#tabs-general' >General</a></li>
    	</ul>
	    <div id='tabs-general' >
    	    <table style='width:100%;' >
				<tr>
					<td>Currency:&nbsp;</td>
					<td>" . wpordercart_getddlcurrencies("ddlwpordercartcurrency", $wpordercart_default_currency) . "</td>
				</tr>	
				<tr>
					<td>Show price:&nbsp;</td>
					<td>
						<select id='ddlwpordercartshowprice' >
							<option value='y' >Show price</option>
							<option value='por' >Show 'P.O.R. (Price on request)'</option>
							<option value='n' >Don't show price</option>
						</select>
					</td>
				</tr>	
				<tr>
					<td>Checkout page:&nbsp;</td>
					<td>" . $ddlpagesstr . "</td>
				</tr>
				<tr>
					<td>Email address to receive orders:&nbsp;</td>
					<td><input id='txtwpordercartorderemail' type='text' value='" . $wpordercart_order_email_address . "' style='width:285px;' /></td>
				</tr>	
				<tr>
					<td>Buttons CSS class:&nbsp;</td>
					<td><input id='txtwpordercartorderbtncssclass' type='text' value='" . $wpordercart_order_button_css_class . "' style='width:285px;' /></td>
				</tr>
                <tr>
					<td style='width:25%;' >On site intructions to buyer when placing an order:&nbsp;</td>
					<td><textarea id='txtwpordercartorderinstructions' rows='5' cols='35' >" . $wpordercart_order_instructions . "</textarea></td>
				</tr>
				<tr>
					<td style='width:25%;' >Thank you message displayed on site when order is submitted:&nbsp;</td>
					<td><textarea id='txtwpordercartorderthankyoumsg' rows='5' cols='35' >" . $wpordercart_order_thank_you_msg . "</textarea></td>
				</tr>
				<tr>
					<td style='width:25%;' >Thank you message displayed in order email sent to buyer:&nbsp;</td>
					<td><textarea id='txtwpordercartorderemailthankyoumsg' rows='5' cols='35' >" . $wpordercart_order_email_thank_you_msg . "</textarea></td>
				</tr>
			</table>		
			<br />
			<input id='btnupdategeneralsettings' class='button-primary' type='submit' value='Update Settings' >
			&nbsp;
			<span id='spanupdategeneralsettingsloading' style='font-size:14px; display:none;' >Contacting server, please wait...</span> 
	    </div>
    </div>
</div>		
";	
                $htmlstr .= "<input type='hidden' id='jslib' value='settings' />";
	       	    $htmlstr .= "
<script type='text/javascript' >
	(function($) {
		$(function () {
			$('#ddlwpordercartcurrency').val('" . $wpordercart_default_currency . "');
			$('#ddlwpordercartshowprice').val('" . $wpordercart_show_price . "');
			$('#checkout_page_id').val('" . $wpordercart_checkout_page_id . "');
		});
	})(jQuery);   			
</script>					
				";
    			break;
    	}
    }
   	$htmlstr .= "
		<!-- WPOrderCart Admin UI General Form -->
		<div id='wpocshoppingcartwidget-admin-dialog-msg' style='display:none;' >
    		<br />
			<div id='wpocshoppingcartwidget-div-admin-dialog-msg-content' >&nbsp;</div>
		</div>	
	";
    return $htmlstr;
}        

function wpordercart_add_update_option($option_name, $new_value) {
	$allok = false;
	if (get_option($option_name) == $new_value) {
		return "same";
	} else {
		$updateok = update_option($option_name, $new_value);
	} 
	if ($updateok) { return "updateok"; }
	else {
		$deprecated = ' ';
	    $autoload = 'no';
	    $addok = add_option($option_name, $new_value, $deprecated, $autoload);
	}
	if ($addok) {
		return "addok";
	} else {
		return "notok";
	}
}

function wpordercart_admin_ajax_submit() {
    $return['error'] = true;	
    $cmd = htmlspecialchars($_POST['cmd']);
    switch ($cmd) {
    	case 'update-settings-general':
    	   	$checkout_page_id = htmlspecialchars(trim($_POST['checkout_page_id']));
	       	$wpordercartdefaultcurrency = htmlspecialchars(trim($_POST['wpordercartdefaultcurrency']));
		    $wpordercartshowprice = htmlspecialchars(trim($_POST['wpordercartshowprice']));
    		$wpordercartorderemail = htmlspecialchars(trim($_POST['wpordercartorderemail']));
	       	$wpordercartorderbuttoncssclass = htmlspecialchars(trim($_POST['wpordercartorderbuttoncssclass']));
            $wpordercartorderinstructions = htmlspecialchars(trim($_POST['wpordercartorderinstructions']));
	       	$wpordercart_order_thank_you_msg = htmlspecialchars(trim($_POST['wpordercartorderthankyoumsg']));
		    $wpordercart_order_email_thank_you_msg = htmlspecialchars(trim($_POST['wpordercartorderemailthankyoumsg']));
    		$resultstr1 = $this->wpordercart_add_update_option("wpordercart_default_currency", $wpordercartdefaultcurrency); 
	       	$resultstr2 = $this->wpordercart_add_update_option("wpordercart_show_price", $wpordercartshowprice); 
    		$resultstr3 = $this->wpordercart_add_update_option("wpordercart_checkout_page_id", $checkout_page_id); 
    		$resultstr4 = $this->wpordercart_add_update_option("wpordercart_order_email_address", $wpordercartorderemail); 
    		$resultstr5 = $this->wpordercart_add_update_option("wpordercart_order_button_css_class", $wpordercartorderbuttoncssclass);
            $resultstr6 = $this->wpordercart_add_update_option("wpordercart_order_instructions", $wpordercartorderinstructions);
    		$resultstr7 = $this->wpordercart_add_update_option("wpordercart_order_thank_you_msg", $wpordercart_order_thank_you_msg);
    		$resultstr8 = $this->wpordercart_add_update_option("wpordercart_order_email_thank_you_msg", $wpordercart_order_email_thank_you_msg);
    		if ($resultstr1 != "notok" && $resultstr2 != "notok" && $resultstr3 != "notok" && $resultstr4 != "notok" && $resultstr5 != "notok" && $resultstr6 != "notok" && $resultstr7 != "notok" && $resultstr8 != "notok") { $return['error'] = false; }
            $return['error'] = false;
    		break;
    }
    $response = json_encode($return);
    header("Content-Type: application/json");
    echo $response;
    exit;
}
    
} //end class    