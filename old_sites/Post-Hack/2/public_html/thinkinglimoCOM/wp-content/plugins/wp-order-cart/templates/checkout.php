<?php
/**
 * WP Order Cart Template for displaying a single product.
 *
 * @package WordPress
 */

get_header(); 

?>

<div class='divcheckout' >

<table>
	<tr>
    	<td style='height:18px; vertical-align:middle;' ><h1 style="padding-left:15px;" >Checkout</h1></td>
        <td style='height:18px; padding-left:15px; vertical-align:middle;' ><img class='cartloading' src='<?php echo plugins_url('/img/loading.gif', dirname(__FILE__) );?>' title='Loading...' style='border:none; display:none;' /></td>
    </tr>
</table>
        

<table class='tblcheckout' >
	<tr>
    	<td style='width:70%;' >
        	<div id='divwpordercartcheckout' tabindex='101' >&nbsp;</div>        
		</td>
        <td style='width:30%;' >
			<table>
            	<tr>
                	<td>
                    	<h2>Instructions</h2>
                        <br />
                    	<ul class='lihowto' >
	                        <li>Complete the order form, filling in all required fields <span class='requiredfield' >*</span></li>
                            <li>Click on "Place Order"</li>
                            <li>
<?php
    $wpordercart_order_instructions = get_option("wpordercart_order_instructions");
    if (!$wpordercart_order_instructions) {
        $wpordercart_order_instructions = "We will then receive the order details and will be in contact with you shortly after that";
    } 
    echo $wpordercart_order_instructions;                            
?>                          </li>
                        </ul>           	
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
				<tr>
                	<td>
						<div id="wpordercart-widget-area-8" >
							<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('wpordercart-widget-area-8'); } ?>
						</div>	       	
                    </td>
                </tr>                         
                <tr><td>&nbsp;</td></tr>
				<tr>
                	<td>
						<div id="wpordercart-widget-area-9" >
							<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('wpordercart-widget-area-9'); } ?>
						</div>	       	
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
				<tr>
                	<td>
						<div id="wpordercart-widget-area-10" >
							<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('wpordercart-widget-area-10'); } ?>
						</div>	       	
                    </td>
                </tr>                                         
            </table>    
        </td>
	</tr>        
</table>

</div>

<?php
	$wpordercart_order_thank_you_msg = get_option("wpordercart_order_thank_you_msg");
	if (!$wpordercart_order_thank_you_msg) {
		$wpordercart_order_thank_you_msg = "Thank you for your order.";
	}
?>

<script type='text/javascript' >
jQuery(document).ready(function ($) {
	//Checkout function declarations
	function getcartcheckout(nameval, cityval, telnoval, emailaddressval) {
		weboordercartcheckouttoggleloading(true);
		$.ajax({ 
			type : 'POST', 
			url : weboordercartcartcheckoutgetajaxurlwidget(), 
			dataType : 'json', 
			data: { action : 'wpordercart-ajax-submit', cmd: 'get-cart-checkout', name: nameval, city: cityval, telno: telnoval, emailaddress: emailaddressval }, 
			success : function(data) {
				weboordercartcheckouttoggleloading(false);
				if (!data.error) {
					$('#divwpordercartcheckout').html(data.ordercartcheckouthtml);
					$('#divwpordercartcheckout').focus();
				}
			} 
		});		
	}
	function updatecarto(productidval, qtyval, nameval, cityval, telnoval, emailaddressval) {
		weboordercartcheckouttoggleloading(true);
		$.ajax({ 
			type : 'POST', 
			url : weboordercartcartcheckoutgetajaxurlwidget(), 
			dataType : 'json', 
			data: { action : 'wpordercart-ajax-submit', cmd: 'update-cart', productid: productidval, qty: qtyval }, 
			success : function(data) {
				weboordercartcheckouttoggleloading(false);
				if (data.error) {
					webodialogmsg('wpocshoppingcartwidget-checkout-dialog-msg', 'wpocshoppingcartwidget-checkout-div-dialog-msg-content', 'Server error', 'Could not update shopping cart, please try again later.', 250, 600);
				} else {
					getcartcheckout(nameval, cityval, telnoval, emailaddressval);
					webodialogmsg('wpocshoppingcartwidget-checkout-dialog-msg', 'wpocshoppingcartwidget-checkout-div-dialog-msg-content', 'Server response', 'Shopping cart updated.', 250, 600);
				}
			} 
		});
	}
	function emptycarto() {
		weboordercartcheckouttoggleloading(true);
		$.ajax({ 
			type : 'POST', 
			url : weboordercartcartcheckoutgetajaxurlwidget(),  
			dataType : 'json', 
			data: { action : 'wpordercart-ajax-submit', cmd: 'empty-cart' }, 
			success : function(data) {
				weboordercartcheckouttoggleloading(false);
				if (data.error) {
					webodialogmsg('wpocshoppingcartwidget-checkout-dialog-msg', 'wpocshoppingcartwidget-checkout-div-dialog-msg-content', 'Server error', 'Could not empty shopping cart, please try again later.', 250, 600);
				} else {
					getcartcheckout('', '', '', '');
				}
			} 
		});
	}
	function submitorderform(nameval, cityval, telnoval, emailaddressval) {
		weboordercartcheckouttoggleloading(true);
		$('#spancheckoutloading').fadeIn();
		$.ajax({ 
			type : 'POST', 
			url : weboordercartcartcheckoutgetajaxurlwidget(), 
			dataType : 'json', 
			data: { action : 'wpordercart-ajax-submit', cmd: 'submit-order-form', name: nameval, city: cityval, telno: telnoval, emailaddress: emailaddressval }, 
			success : function(data) {
				weboordercartcheckouttoggleloading(false);
				$('#spancheckoutloading').fadeOut();
				if (data.error) {
					var displaymsg = 'Could not submit order right now, please try again later.';
					if (data.msg != '') {
						displaymsg = displaymsg + '<br /><br />' + data.msg;
					}
					webodialogmsg('wpocshoppingcartwidget-checkout-dialog-msg', 'wpocshoppingcartwidget-checkout-div-dialog-msg-content', 'Send order error', displaymsg, 285, 600);
				} else {
					emptycarto();
					webodialogmsg('wpocshoppingcartwidget-checkout-dialog-msg', 'wpocshoppingcartwidget-checkout-div-dialog-msg-content', 'Order sent', '<?php echo $wpordercart_order_thank_you_msg; ?>', 250, 600);	
				}
			} 
		});
	}
	function weboordercartcartcheckoutgetajaxurlwidget() {
		var ajaxurlstr = WPOrderCartAjaxO.ajaxurl;
	    return ajaxurlstr;
	}	
	function weboordercartcheckouttoggleloading(isvisible) {
		if (isvisible) {
			$('.cartloading').fadeIn();	
		} else {
			$('.cartloading').fadeOut();	
		}
	}
	//End checkout function declarations
	
	getcartcheckout('', '', '', '');
	$('.aupdatecart').live('click',function() {
		var idstr = decodeURIComponent($(this).attr('id'));
		var strarr = idstr.split('_');
		var cmdval = strarr[0];
		var productidval = strarr[1];
		switch(cmdval) {
			case 'aupdatecarto':
				var qtyval = $('#txtupdatecartqtyo_' + productidval).val();
				var nameval = $('#txtname').val();
				var cityval = $('#txtcity').val();
				var telnoval = $('#txttelno').val();
				var emailaddressval = $('#txtemailaddress').val();
				updatecarto(productidval, qtyval, nameval, cityval, telnoval, emailaddressval);
				break;
			case 'aremovecarto':
				var nameval = $('#txtname').val();
				var cityval = $('#txtcity').val();
				var telnoval = $('#txttelno').val();
				var emailaddressval = $('#txtemailaddress').val();
				updatecarto(productidval, "0", nameval, cityval, telnoval, emailaddressval);
				break;								
		}
	});
	$('#aemptycarto').live('click',function() {
		$('#wpocshoppingcartwidget-checkout-div-dialog-msg-content').html('All products added to cart will be removed.');
		$('#wpocshoppingcartwidget-checkout-dialog-msg').dialog({ title: 'Confirmation', height: 215, width: 600, modal: true, 
			buttons: { 
				'Confirm' : function () { 
					$('#wpocshoppingcartwidget-checkout-dialog-msg').dialog('close');
					emptycarto();	
				},
				'Cancel' : function () { 
					$('#wpocshoppingcartwidget-checkout-dialog-msg').dialog('close'); 
				}
			}
		});
	});
	$('#btnsubmitorder').live('click',function() {
		var errormsgval = '';
		var nameval = $('#txtname').val();
		var cityval = $('#txtcity').val();
		var telnoval = $('#txttelno').val();
		var emailaddressval = $('#txtemailaddress').val();
		if (nameval == '' ||  cityval == '' || telnoval == '' || emailaddressval == '') {
			errormsgval = 'Please supply all information for fields marked with an asterisk.';
		} else {
			if (!webovalidEmail(emailaddressval)) {
			errormsgval = 'Please supply a valid email address.';
		} 
	}
		if (errormsgval != '') {
			webodialogmsg('wpocshoppingcartwidget-checkout-dialog-msg', 'wpocshoppingcartwidget-checkout-div-dialog-msg-content', 'Form input response', errormsgval, 250, 600);
		} else {
			submitorderform(nameval, cityval, telnoval, emailaddressval);
		}
	}); 
});
</script>
<!-- WPOrderCart UI CheckOut General Form -->
<div id='wpocshoppingcartwidget-checkout-dialog-msg' style='display:none;' >
   	<br />
	<div id='wpocshoppingcartwidget-checkout-div-dialog-msg-content' >&nbsp;</div>
</div>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>