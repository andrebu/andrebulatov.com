<?php
/**
 * WP Order Cart Widgets Class
*/
class WPOrderCart_Widgets {

    function __construct() {

        add_action('widgets_init', array( $this, 'wpordercart_init_widgets') );        
                        
	}
    
function wpordercart_init_widgets() {
    if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Shopping Cart Area',
		'id'   => 'wpordercart-widget-area-1',
		'description'   => 'This is a widgetized area intended for the WPOCShoppingCartWidget.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>'
	));

}

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Products Pages 1',
		'id'   => 'wpordercart-widget-area-2',
		'description'   => 'This is the first additional optional widgetized area for the product listing pages of WP Order Cart.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Products Pages 2',
		'id'   => 'wpordercart-widget-area-3',
		'description'   => 'This is the second additional optional widgetized area for the product listing pages of WP Order Cart.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Products Pages 3',
		'id'   => 'wpordercart-widget-area-4',
		'description'   => 'This is the third additional optional widgetized area for the product listing pages of WP Order Cart.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Product Page 1',
		'id'   => 'wpordercart-widget-area-5',
		'description'   => 'This is the first additional optional widgetized area for the product page of WP Order Cart.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Product Page 2',
		'id'   => 'wpordercart-widget-area-6',
		'description'   => 'This is the second additional optional widgetized area for the product page of WP Order Cart.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Product Page 3',
		'id'   => 'wpordercart-widget-area-7',
		'description'   => 'This is the third additional optional widgetized area for the product page of WP Order Cart.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Checkout Page 1',
		'id'   => 'wpordercart-widget-area-8',
		'description'   => 'This is the first additional optional widgetized area for the checkout page of WP Order Cart.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Checkout Page 2',
		'id'   => 'wpordercart-widget-area-9',
		'description'   => 'This is the second additional optional widgetized area for the checkout page of WP Order Cart.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'WPOrderCart Checkout Page 3',
		'id'   => 'wpordercart-widget-area-10',
		'description'   => 'This is the third additional optional widgetized area for the checkout page of WP Order Cart.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));

}
}

}// end class

?>