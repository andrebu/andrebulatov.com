<?php

class WPOCShoppingCartWidget extends WP_Widget {
  function WPOCShoppingCartWidget() {
    parent::WP_Widget( false, $name = 'WPOCShoppingCartWidget' );
  }

  function widget( $args, $instance ) {
    extract( $args );
    $title = apply_filters( 'widget_title', $instance['title'] );
    ?>

    <?php
	echo $before_widget;
    ?>

    <?php
      if ($title) {
	echo $before_title . $title . $after_title;
      }
    ?>
    <?php
		$checkoutpageid = get_option("wpordercart_checkout_page_id");
		if ($checkoutpageid != false) {
			$checkoutpageurl = get_permalink($checkoutpageid);	
		}
	?>
	<br />
    <div id='divwpocshoppingcartwidget'  >
    	<div id='divwpocshoppingcartwidgetcontent' tabindex='100' >
        	<div style='padding-left:5px;' ><img src='<?php echo plugins_url('/img/loading.gif', dirname(__FILE__) ); ?>' title='Loading...' style='border:none;' /></div>
        </div>
    </div>
    <!-- WPOrderCart UI General Form -->
	<div id='wpocshoppingcartwidget-dialog-msg' style='display:none;' >
    	<br />
		<div id='wpocshoppingcartwidget-div-dialog-msg-content' >&nbsp;</div>
	</div>
    
<script type='text/javascript' >
	(function($) {
		$(function () {	
			<?php if ($checkoutpageid != false) { ?>
			getcart();
			$('.aaddtocart').live('click',function() {
				var idstr = decodeURIComponent($(this).attr('id'));
			    var strarr = idstr.split('_');
			    var productidval = strarr[1];
				var qtyval = $('#txtaddtocartqty_' + productidval).val();
				addtocart(productidval, qtyval);
			});
			$('.aupdatecart').live('click',function() {
				var idstr = decodeURIComponent($(this).attr('id'));
			    var strarr = idstr.split('_');
			    var cmdval = strarr[0];
				var productidval = strarr[1];
				switch(cmdval) {
					case 'aupdatecart':
						var qtyval = $('#txtupdatecartqty_' + productidval).val();
						updatecart(productidval, qtyval);
					break;
					case 'aremovecart':
						updatecart(productidval, "0");
						break;				
				}
			});
			$('#aemptycart').live('click',function() {
				$('#wpocshoppingcartwidget-div-dialog-msg-content').html('All products added to cart will be removed.');
				$('#wpocshoppingcartwidget-dialog-msg').dialog({ title: 'Confirmation', height: 215, width: 600, modal: true, 
					buttons: { 
						'Confirm' : function () { 
							$('#wpocshoppingcartwidget-dialog-msg').dialog('close');
							emptycart();	
						},
						'Cancel' : function () { 
							$('#wpocshoppingcartwidget-dialog-msg').dialog('close'); 
						}
					}
				});
			});
	    	$('#acheckout').live('click',function() {
				location.replace('<?php echo $checkoutpageurl; ?>');	
			}); 
			$('#aordercarthowto').live('click',function() {
			<?php
                $wpordercart_order_instructions = get_option("wpordercart_order_instructions");
                if (!$wpordercart_order_instructions) {
                    $wpordercart_order_instructions = "We will then receive the order details and will be in contact with you shortly after that";
                } 
            ?> 
				var howtostr = '<?php echo "<br /><ul class=\"lihowto\" ><li>Browse through the various categories and products</li><li>Select a product and update your quantity and proceed to click on <img src=\"" . plugins_url('/img/cart_add.png', dirname(__FILE__) ) . "\" title=\"Add to cart\" style=\"border:none;\" /> \"Add to Cart\"</li><li>You can continue to add other products, click on <img src=\"" . plugins_url('/img/cart_remove.png', dirname(__FILE__) )  . "\" title=\"Empty shopping cart\" style=\"border:none;\" /> \"Empty Shopping Cart\" or <img src=\"" . plugins_url('/img/cart_go.png', dirname(__FILE__) )  . "\" title=\"Check out\" style=\"border:none;\" /> \"Check Out\"</li><li>On checkout page you will be able to edit products, fill in your details and submit your order</li><li>" . $wpordercart_order_instructions . "</li>"; ?>';
				webodialogmsg('wpocshoppingcartwidget-dialog-msg', 'wpocshoppingcartwidget-div-dialog-msg-content', 'Shopping Cart and Order Info', howtostr, 450, 750);
			});
			<?php } else { ?>
			webodialogmsg('wpocshoppingcartwidget-dialog-msg', 'wpocshoppingcartwidget-div-dialog-msg-content', 'Error', 'WP Order Cart not set up correctly.<br /><br />Please set your checkout page from WP-Admin - WP Order Cart Settings.', 250, 600);
			<?php } ?>
	    });
		
function addtocart(productidval, qtyval) {
	weboordercarttoggleloading(true);
	$.ajax({ 
		type : 'POST', 
		url : weboordercartgetajaxurlwidget(), 
		dataType : 'json', 
		data: { action : 'wpordercart-ajax-submit', cmd: 'add-to-cart', productid: productidval, qty: qtyval }, 
		success : function(data) {
			weboordercarttoggleloading(false);
			if (data.error) {
				webodialogmsg('wpocshoppingcartwidget-dialog-msg', 'wpocshoppingcartwidget-div-dialog-msg-content', 'Server error', 'Could not add item to shopping cart, please try again later.', 215, 600);
			} else {
				getcart();
			}
		} 
	});
}

function updatecart(productidval, qtyval) {
	weboordercarttoggleloading(true);
	$.ajax({ 
		type : 'POST', 
		url : weboordercartgetajaxurlwidget(),  
		dataType : 'json', 
		data: { action : 'wpordercart-ajax-submit', cmd: 'update-cart', productid: productidval, qty: qtyval }, 
		success : function(data) {
			weboordercarttoggleloading(false);
			if (data.error) {
				webodialogmsg('wpocshoppingcartwidget-dialog-msg', 'wpocshoppingcartwidget-div-dialog-msg-content', 'Server error', 'Could not update shopping cart, please try again later.', 215, 600);
			} else {
				if (qtyval != 0) {
					webodialogmsg('wpocshoppingcartwidget-dialog-msg', 'wpocshoppingcartwidget-div-dialog-msg-content', 'Server response', 'Shopping cart updated.', 215, 600);
				}
				getcart();
			}
		} 
	});
}

function getcart() {
	$.ajax({ 
		type : 'POST', 
		url : weboordercartgetajaxurlwidget(), 
		dataType : 'json', 
		data: { action : 'wpordercart-ajax-submit', cmd: 'get-cart' }, 
		success : function(data) {
			if (!data.error) {
				$('#divwpocshoppingcartwidgetcontent').html(data.ordercarthtml);
				$('#divwpocshoppingcartwidgetcontent').focus();
			}
		} 
	});		
}

function emptycart() {
	weboordercarttoggleloading(true);
	$.ajax({ 
		type : 'POST', 
		url : weboordercartgetajaxurlwidget(),  
		dataType : 'json', 
		data: { action : 'wpordercart-ajax-submit', cmd: 'empty-cart' }, 
		success : function(data) {
			weboordercarttoggleloading(false);
			if (data.error) {
			webodialogmsg('wpocshoppingcartwidget-dialog-msg', 'wpocshoppingcartwidget-div-dialog-msg-content', 'Server error', 'Could not empty shopping cart, please try again later.', 215, 600);
			} else {
				getcart();
			}
		} 
	});
}

function weboordercartgetajaxurlwidget() {
	var ajaxurlstr = WPOrderCartAjaxO.ajaxurl;
	return ajaxurlstr;
}

function weboordercarttoggleloading(isvisible) {
	if (isvisible) {
		$('.cartloading').fadeIn();	
	} else {
		$('.cartloading').fadeOut();	
	}
}

})(jQuery);    
</script>
     <?php
       echo $after_widget;
     ?>
     <?php
  }

  function update( $new_instance, $old_instance ) {
    return $new_instance;
  }

  function form( $instance ) {
    $title = esc_attr( $instance['title'] );
    ?>

    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
      </label>
    </p>
    <?php
  }
}

add_action( 'widgets_init', 'WPOCShoppingCartWidgetInit' );
function WPOCShoppingCartWidgetInit() {
  register_widget( 'WPOCShoppingCartWidget' );
}

?>