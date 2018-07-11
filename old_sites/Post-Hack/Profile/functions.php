<?php

// Use these lines to restore Site URL and WordPress URl - after, visit http://andrebulatov.com/wp-login.php
//update_option('siteurl','http://andrebulatov.com');
//update_option('home','http://andrebulatov.com');

// Define the version as a constant so we can easily replace it throughout the theme
define( 'LESS_VERSION', 1.1 );


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

    // Deregister the included library
    wp_deregister_script( 'jquery' );
    // Register the library again from Google's CDN
    wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', array(), null, false );
	
	// Add Boostrap theme scripts
	wp_enqueue_script( 'bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js', array('jquery'), null, false );
 	// Add Bootstrap styles
	wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css', array(), null, false );
    
 	// Theme styles
	wp_enqueue_style( 'less-style', get_template_directory_uri() . '/style.css', array(), '02072015', 'all' );
	// Add theme scripts
	wp_enqueue_script( 'less-js', get_template_directory_uri() . '/js/theme.js', array('jquery'), LESS_VERSION, true );

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
