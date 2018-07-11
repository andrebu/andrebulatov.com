<?php
/*
Plugin Name: Custom search URL (Nice Search Extension)
Version: 1
Plugin URI: http://wordpress.org/extend/plugins/custom-search-url-nice-search-extension/
Description: Replaces default search page syntax ?s to custom word
Author: Mark King
Author URI: http://wpth.net/
*/
function custom_search_base() {
    $GLOBALS['wp_rewrite']->search_base = 'results';
}

add_action( 'init', 'custom_search_base' );
?>