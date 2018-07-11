<?php
/*
Plugin Name: WP Order Cart
Plugin URI: http://wpordercart.webolution.co.za/
Description: Create an online catalogue with products that can be ordered via shopping cart with checkout, details of orders are sent to specified email address.
Version: 1.2
Author: CP Brand
Author URI: http://webolution.co.za
License: GPLv2 or later.
*/

class WPOrderCart {
    
function __construct() {
    
    require_once('php/lib.php');
    require_once('php/currencies.php');
    
    define('MYPLUGINNAME_PATH', plugin_dir_path(__FILE__));
    
    add_action('init', array($this, 'wpordercart_custom_post_type_init'));
    add_action('init', array($this, 'wpordercart_taxonomies_products'), 0);
    add_action('save_post', array($this, 'wpordercart_save_products_meta'), 1, 2);
    add_filter('post_updated_messages', array($this, 'wpordercart_products_updated_messages'));
    add_action('template_redirect', array($this, 'wpordercart_custom_display_template'), 5);        
    add_filter('template_include', array($this, 'wpordercart_custom_display_template_include'));
    
    require_once('classes/wpordercart_admin.php');	
    $this->wpordercart_adminO = new WPOrderCart_Admin();
    
    require_once('classes/wpordercart_public.php');	
    $this->wpordercart_publicO = new WPOrderCart_Public();
        
    require_once("classes/wpordercart_widget.php");
    require_once("classes/wpordercart_searchwidget.php");
    require_once("classes/wpordercart_pricesliderwidget.php");
    require_once('classes/wpordercart_widgets.php');	
    $this->wpordercart_widgetsO = new WPOrderCart_Widgets();				
} 
	
function wpordercart_custom_post_type_init() {
    $args = array(
		'label' => 'Products',
		'labels' => array(
			'name' => 'Products',
			'singular_name' => 'Product',
			'add_new_item' => 'Add new product',
			'edit_item' => 'Edit product',
			'new_item' => 'New product',
			'view_item' => 'View product',
			'search_items' => 'Search products',
			'not_found' => 'No products found',
			'not_found_in_trash' => 'No products found in Trash',
		),		
		'description' => 'WP Order Cart product',
		'public' => true, 
		'menu_position' => 101,
		'menu_icon' => plugins_url( 'img/cart.png' , __FILE__ ),
		'rewrite' => array('slug' => 'products'),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'register_meta_box_cb' => array($this, 'add_products_metaboxes'),
		'has_archive'   => true
		);
    register_post_type('products', $args);
}

function wpordercart_taxonomies_products() {
	$labels = array(
		'name'              => _x('Product Categories', 'taxonomy general name'),
		'singular_name'     => _x('Product Category', 'taxonomy singular name'),
		'search_items'      => __('Search Product Categories'),
		'all_items'         => __('All Product Categories'),
		'parent_item'       => __('Parent Product Category'),
		'parent_item_colon' => __('Parent Product Category:'),
		'edit_item'         => __('Edit Product Category'), 
		'update_item'       => __('Update Product Category'),
		'add_new_item'      => __('Add New Product Category'),
		'new_item_name'     => __('New Product Category'),
		'menu_name'         => __('Product Categories'),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'query_var' => true, 
		'rewrite' => true
	);
	register_taxonomy('product_category', 'products', $args);
}

function add_products_metaboxes() {
    add_meta_box('wpordercart_products_price', 'Product price', array($this, 'wpordercart_products_price_gethtml'), 'products', 'normal', 'high');
	add_meta_box('wpordercart_products_sku', 'SKU', array($this, 'wpordercart_products_sku_gethtml'), 'products', 'normal', 'high');
}

function wpordercart_products_price_gethtml() {
    global $post;
    echo '<input type="hidden" name="wpordercart_products_meta_noncename" id="wpordercart_products_meta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    $productprice = get_post_meta($post->ID, 'price', true);
	echo '<label for="price" >';
       _e("R ", 'wpordercart');
	echo '</label> ';
    echo '<input type="text" name="price" value="' . $productprice . '" size="15" />';
}

function wpordercart_products_sku_gethtml() {
    global $post;
    echo '<input type="hidden" name="wpordercart_products_meta_noncename" id="wpordercart_products_meta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    $productsku = get_post_meta($post->ID, 'sku', true);
	echo '<label for="sku" >';
       _e("SKU", 'wpordercart');
	echo '</label> ';
    echo '<input type="text" name="sku" value="' . $productsku . '" size="15" />';
}

function wpordercart_save_products_meta($post_id, $post) {
    if (!wp_verify_nonce( $_POST['wpordercart_products_meta_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
    if (!current_user_can('edit_post', $post->ID))
        return $post->ID;
    $products_meta['price'] = $_POST['price'];
    $products_meta['sku'] = $_POST['sku'];	
    foreach ($products_meta as $key => $value) { 
        if($post->post_type == 'revision') return;
        $value = implode(',', (array)$value);
        if(get_post_meta($post->ID, $key, FALSE)) {
            update_post_meta($post->ID, $key, $value);
        } else {
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key);
    }
}

function wpordercart_products_updated_messages($messages) {
	global $post, $post_ID;
	$messages['products'] = array(
		0 => '', 
		1 => sprintf( __('Product updated. <a href="%s">View product</a>.'), esc_url( get_permalink($post_ID))),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Product updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Product published. <a href="%s">View product</a>.'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Product saved.'),
		8 => sprintf( __('Product submitted. <a target="_blank" href="%s">Preview product</a>.'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>.'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview product</a>.'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}

function wpordercart_custom_display_template() {
	
	$checkoutpageid = get_option("wpordercart_checkout_page_id");
	if ($checkoutpageid != false) {
		if (is_page($checkoutpageid)) {
			load_template(MYPLUGINNAME_PATH . 'templates/checkout.php'); exit;
		}
	}
	
	$post_type = get_query_var('post_type');
	if ($post_type == 'products') {  
		if (is_search()) {
			load_template(MYPLUGINNAME_PATH . 'templates/productsearch.php'); exit;
		}
		if (is_post_type_archive($post_type)) {
			load_template(MYPLUGINNAME_PATH . 'templates/products.php'); exit;
		}
		/*if (is_category()) {
			load_template(WP_PLUGIN_DIR . '/wpordercart' . '/templates/products.php'); exit;
		}*/
		if (is_single()) {
			if (file_exists(TEMPLATEPATH . '/single-' . $post_type . '.php')) return;
			load_template(MYPLUGINNAME_PATH . 'templates/product.php'); exit;
		}
		
	}
}

function wpordercart_custom_display_template_include($template){
    $taxonomy_array = array('product_category');
    foreach ($taxonomy_array as $taxonomy_single) {
        if (is_tax($taxonomy_single)) {
            $template = MYPLUGINNAME_PATH . 'templates/products.php';
            break;
        }
    }
  return $template;
}

function new_excerpt_more( $more ) {
	global $post;
	return '&nbsp;<a href="'. get_permalink($post->ID) . '">...</a>';
}

} // end class

$wpordercart = new WPOrderCart();