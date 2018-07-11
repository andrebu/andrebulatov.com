<?php

class WPOrderCartSearchWidget extends WP_Widget {
  function WPOrderCartSearchWidget() {
    parent::WP_Widget( false, $name = 'WPOrderCartSearchWidget' );
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
	  $wpordercart_order_button_css_class = get_option("wpordercart_order_button_css_class");
    ?>
	<br />
	<form id="searchform" action="<?php bloginfo('url'); ?>/" method="get" >
		<table style='width:100%;' >
        	<tr>
            	<td style='vertical-align:middle;' ><input class="inlineSearch" type="text" name="s" value="Enter a keyword" onblur="if (this.value == '') {this.value = 'Enter a keyword';}" onfocus="if (this.value == 'Enter a keyword') {this.value = '';}" /></td>
				<td style='vertical-align:middle;' ><input class="inlineSubmit <?php if ($wpordercart_order_button_css_class) { echo $wpordercart_order_button_css_class; } ?>" id="searchsubmit" type="submit" alt="Search" value="Search" /></td>
            </tr>
            <tr><td colspan='2' title='Search products by SKU' ><input type="checkbox" id='cbxskusearch' name="sku" value="1" />SKU</td></tr>
        </table>        
        <input type="hidden" name="post_type" value="products" />
	</form>
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

add_action( 'widgets_init', 'WPOrderCartSearchWidgetInit' );
function WPOrderCartSearchWidgetInit() {
  register_widget( 'WPOrderCartSearchWidget' );
}

?>