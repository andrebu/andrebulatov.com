<?php
class WPOrderCartPriceSliderWidget extends WP_Widget {
  function WPOrderCartPriceSliderWidget() {
    parent::WP_Widget( false, $name = 'WPOrderCartPriceSliderWidget' );
  }

  function widget( $args, $instance ) {
    extract( $args );
    $title = apply_filters( 'widget_title', $instance['title'] );
	$pricemin = $instance['pricemin'];
	$pricemax = $instance['pricemax'];
    ?>

    <?php
	echo $before_widget;
    ?>

    <?php
      if ($title) {
	echo $before_title . $title . $after_title;
      }
	  $wpordercart_order_button_css_class = get_option("wpordercart_order_button_css_class");
    ?>
	<br />
	<div style='text-align:center;' >
    <form id="searchform" action="<?php bloginfo('url'); ?>/" method="get" >
	    <table style='width:100%;' >
    		<tr><td colspan='2' ><div id='wpordercartpriceslider' ></div></td></tr>
        	<tr>
        		<td><div id="wpordercartpriceslideramount" >&nbsp;</div></td>
	            <td><input class="inlineSubmit <?php if ($wpordercart_order_button_css_class) { echo $wpordercart_order_button_css_class; } ?>" id="searchsubmit" type="submit" alt="Search" value="Search" /></td>
    	    </tr>
	    </table>        
        <input type="hidden" name="s" value="pricesearch" />
    	<input type="hidden" name="post_type" value="products" />
        <input type="hidden" id='hvalpricemin' name="pricemin" value="<?php echo $pricemin; ?>" />
        <input type="hidden" id='hvalpricemax' name="pricemax" value="<?php echo $pricemax; ?>" />
    </form>
	</div>
    <?php
		$wpordercart_default_currency = get_option("wpordercart_default_currency");
		$wpordercart_default_currency_symbol = wpordercart_getsymbolfromcode($wpordercart_default_currency);
	?>
	<script type="text/javascript" >
	jQuery(document).ready(function ($) {
		$("#wpordercartpriceslider").slider({
    	   	range: true,
	        min: <?php echo $pricemin; ?>,
    	    max: <?php echo $pricemax; ?>,
	        values: [ <?php echo $pricemin; ?>, <?php echo $pricemax; ?> ],
    	    slide: function( event, ui ) {
	            $('#wpordercartpriceslideramount').html( "<?php echo $wpordercart_default_currency_symbol; ?> " + ui.values[ 0 ] + " - <?php echo $wpordercart_default_currency_symbol; ?> " + ui.values[ 1 ] );
				$('#hvalpricemin').val(ui.values[0]);
				$('#hvalpricemax').val(ui.values[1]);
            }
        });
        $('#wpordercartpriceslideramount').html( "<?php echo $wpordercart_default_currency_symbol; ?> " + $( "#wpordercartpriceslider" ).slider( "values", 0 ) +
            " - <?php echo $wpordercart_default_currency_symbol; ?> " + $( "#wpordercartpriceslider" ).slider( "values", 1 ) );
	});
	</script>
    
    
     <?php
       echo $after_widget;
     ?>
     <?php
  }

  function update( $new_instance, $old_instance ) {
	$instance = $old_instance;
	/* Strip tags (if needed) and update the widget settings. */
	$instance['title'] = strip_tags( $new_instance['title'] );
	if (is_numeric($new_instance['pricemin'])) {
		$instance['pricemin'] = $new_instance['pricemin'];	
	} else {
		$instance['pricemin'] = $instance['pricemin'];	
	}
	if (is_numeric($new_instance['pricemax'])) {
		$instance['pricemax'] = $new_instance['pricemax'];	
	} else {
		$instance['pricemax'] = $instance['pricemax'];	
	}
	return $instance;
  }

  function form( $instance ) {
	/* Set up some default widget settings. */
	$defaults = array( 'title' => 'Price Range', 'pricemin' => '0', 'pricemax' => '500' );
	$instance = wp_parse_args( (array) $instance, $defaults ); 
	
    ?>

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'pricemin' ); ?>">Price Range Slider Start / Min Value:</label>
		<input id="<?php echo $this->get_field_id( 'pricemin' ); ?>" name="<?php echo $this->get_field_name( 'pricemin' ); ?>" value="<?php echo $instance['pricemin']; ?>" style="width:100%;" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'pricemax' ); ?>">Price Range Slider End / Max Value:</label>
		<input id="<?php echo $this->get_field_id( 'pricemax' ); ?>" name="<?php echo $this->get_field_name( 'pricemax' ); ?>" value="<?php echo $instance['pricemax']; ?>" style="width:100%;" />
	</p>


    <?php
  }
}

add_action( 'widgets_init', 'WPOrderCartPriceSliderWidgetInit' );
function WPOrderCartPriceSliderWidgetInit() {
  register_widget( 'WPOrderCartPriceSliderWidget' );
}

?>