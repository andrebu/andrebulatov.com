<?php

// Use these lines to restore Site URL and WordPress URl - after, visit https://andrebulatov.com/wp-login.php
//update_option('siteurl','https://andrebulatov.com');
//update_option('home','https://andrebulatov.com');

// Define the version as a constant so we can easily replace it throughout the theme
define( 'ABBOT_VERSION', 1.37 );


/*-----------------------------------------------------------------------------------*/
/* Add Rss to Head
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'automatic-feed-links' );


/*-----------------------------------------------------------------------------------*/
/* register main menu
/*-----------------------------------------------------------------------------------*/
register_nav_menus( 
	array(
		'primary'	=>	__( 'Primary Menu', 'less' ),
	)
);


/*-----------------------------------------------------------------------------------*/
/* Enque Styles and Scripts
/*-----------------------------------------------------------------------------------*/
//wp_register_script( $handle, $src, $deps, $ver, $in_footer );
function less_scripts()  { 
	
	// Remove genericons
	wp_dequeue_style('genericons');
	wp_deregister_style('genericons');

    // Deregister the included library
    wp_deregister_script( 'jquery' );
    // Register the library again from Google's CDN
    wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', array(), null, false );
	
	// Add Boostrap theme scripts
	wp_enqueue_script( 'bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js', array('jquery'), null, true );
 	// Add Bootstrap styles
	wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css', array(), null, 'all' );
    
 	// Theme styles
	wp_enqueue_style( 'less-style', get_template_directory_uri() . '/style.css', array('bootstrap'), '02072015', 'all' );
	// Add theme scripts
	wp_enqueue_script( 'less-js', get_template_directory_uri() . '/js/script.js', array('jquery'), ABBOT_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'less_scripts' );


/*-----------------------------------------------------------------------------------*/
/* Add support for post thumbnails
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'post-thumbnails' ); 


/*-----------------------------------------------------------------------------------*/
/* Add support for in-content .php via shortcodes 
/*-----------------------------------------------------------------------------------*/
function my_page_title_shortcode( ){
   return get_the_title();
}
add_shortcode( 'page_title', 'my_page_title_shortcode' );


/*-----------------------------------------------------------------------------------*/
/* Register widget area
/*-----------------------------------------------------------------------------------*/
/**
 * Register widget area.
 *
 * @since Profile 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function less_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'less' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'less' ),
		'class'         => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'less_widgets_init' );


// emoji removal wp-emoji
//remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
//remove_action( 'wp_print_styles', 'print_emoji_styles' );


// first block wraps post imgs on blog pages, second one adds itemprop="image" to the same
/*
function wrap_thumb_schema( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    return "<div class='image-container' itemprop='image'>{$html}</div>";
}
add_filter( 'post_thumbnail_html', 'wrap_thumb_schema', 10, 5 );
*/
/*
function ipwp_img_attr($attr) {
    $attr['itemprop'] = 'image';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'ipwp_img_attr', 10, 2);
*/


//custom, to get the excerpt on any page, even out of th eloop
function get_excerpt_by_id($post_id){
	$the_post = get_post($post_id); //Gets post ID
	$the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
	$excerpt_length = 35; //Sets excerpt length by word count
	$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
	$words = explode(' ', $the_excerpt, $excerpt_length + 1);
	
	if ( count($words) > $excerpt_length ) :
		array_pop($words);
		array_push($words, '…');
		$the_excerpt = implode(' ', $words);
	endif;

	$the_excerpt = '<p>' . $the_excerpt . '</p>';

	return $the_excerpt;
}


//custom, to turn off Yoast meta/schema.org
function amt_schemaorg_skip_front_page( $default ) {
    if ( is_front_page() || is_home() ) {
        return array();
    }
    return $default;
}
add_filter( 'disable_wpseo_json_ld_output', '__return_true' );
add_filter( 'wpseo_json_ld_output', '__return_false' );


//disable WLW windows live writer
//remove_action('wp_head', 'wlwmanifest_link');
//remove_action('wp_head', 'rsd_link');

//Auto hAtom hEntry
//mod content - use this function only if you DON'T USE Suffusion theme
function hatom_mod_post_content ($content) {
	if ( in_the_loop() && !is_page() ) {
		$content = '<span class="entry-content">'.$content.'</span>';
	}
	return $content;
}
add_filter( 'the_content', 'hatom_mod_post_content');
//add hatom data
function add_suf_hatom_data($content) {
	$t = get_the_modified_time('F jS, Y');
	$author = get_the_author();
	$title = get_the_title();
	if (is_home() || is_singular() || is_archive() ) {
		$content .= '<div class="hatom-extra" style="display:none;visibility:hidden;"><span class="entry-title">'.$title.'</span> was last modified: <span class="updated"> '.$t.'</span> by <span class="author vcard"><span class="fn">'.$author.'</span></span></div>';
	}
	return $content;
}
add_filter('the_content', 'add_suf_hatom_data');

add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
	add_image_size( 'main-stage-image', 775, 368, true );
}
