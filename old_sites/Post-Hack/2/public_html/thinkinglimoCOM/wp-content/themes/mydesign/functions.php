<?php

/* load language - if it exists */
load_theme_textdomain( 'flatbox', get_template_directory() . '/languages' );
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) ) require_once( $locale_file );

/* add admin options */
$reinstall_error_msg = __( 'Please reinstall the theme, one of the files is missing (utils/admin/index.php)', 'flatbox' );
if (file_exists( get_template_directory() . '/utils/admin/index.php' ))
	require_once( 'utils/admin/index.php' );
else
	wp_die( $reinstall_error_msg );

/* meta box */
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/utils/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/utils/meta-box' ) );
if (file_exists( RWMB_DIR . 'meta-box.php' ))
	require_once RWMB_DIR . 'meta-box.php';
else
	wp_die( $reinstall_error_msg );
if (file_exists( RWMB_DIR . 'meta-box-config.php' ))
	include RWMB_DIR . 'meta-box-config.php';
else
	wp_die( $reinstall_error_msg );

/* add image resizer script */
if (file_exists( get_template_directory() . '/utils/aq_resizer.php' ))
	require_once( 'utils/aq_resizer.php' );
else
	wp_die( $reinstall_error_msg );

/* obtain some admin settings */
global $smof_data;

/* shortcodes */
if (file_exists(get_template_directory() . '/utils/shortcodes.php'))
	require_once('utils/shortcodes.php');
else
	wp_die( $reinstall_error_msg );

/* sidebar widgets */
if (file_exists( get_template_directory() . '/utils/custom-widgets.php' ))
	require_once( 'utils/custom-widgets.php' );
else
	wp_die( $reinstall_error_msg );

/* custom post types */
if (file_exists( get_template_directory() . '/utils/custom-post-types.php' ))
	require_once( 'utils/custom-post-types.php' );
else
	wp_die( $reinstall_error_msg );


if(is_admin()) {
    require_once locate_template('utils/plugins.php');
}

add_action( 'after_setup_theme', 'mydesign_theme_setup' );

function mydesign_theme_setup() {
	/* filters, actions, and theme-supported features. */
	$defaults = array(
	'default-image'          => '',
	'random-default'         => false,
	'width'                  => 0,
	'height'                 => 0,
	'flex-height'            => false,
	'flex-width'             => false,
	'default-text-color'     => '',
	'header-text'            => true,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $defaults );
	$defaults = array(
		'default-color'          => '',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $defaults );

	add_theme_support( 'automatic-feed-links' );


	add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
	function add_menu_parent_class( $items ) {
		$parents = array();
		foreach ( $items as $item ) {
			if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) $parents[] = $item->menu_item_parent;
		}
		foreach ( $items as $item ) {
			if ( in_array( $item->ID, $parents ) ) $item->classes[] = 'arrow'; 
		}
		return $items;    
	}


	// include custom posts types in categories, tags or archive listing
	function flatbox_add_custom_types( $query ) {
		if ( !is_admin() || is_category() || is_tag() || is_archive() ) {
			if ($query->is_main_query()) {
				$query->set( 'post_type', array( 'post', 'page', 'nav_menu_item', 'portfolio', 'portfolio-items', 'staff-members', 'testimonials' ) );
			}
			return $query;
		}
	}
	add_filter( 'pre_get_posts', 'flatbox_add_custom_types' );


}	//	End mydesign theme setup

add_editor_style();
if ( ! isset( $content_width ) ) $content_width = 940;

/* Menu Settings */
register_nav_menus( array(
	'main_menu'   => __( 'Main Menu', 'flatbox' )
) );

/* enable and set thumbnail sizes */
if (function_exists( 'add_theme_support' )) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 120, 120, true );
	add_image_size( 'thumbnail', 120, 120, true );
	add_image_size( 'medium', 480, 320, true );
	add_image_size( 'large', 940, 480, true );
}
function flatbox_jpeg_quality( $quality ) {
	return 95;
}
add_filter( 'jpeg_quality', 'flatbox_jpeg_quality' );

/* pagination */
function paginate_links_attributes() {
	return 'class="button"';
}
add_filter('paginate_links_attributes', 'paginate_links_attributes');
function pagination_pages() {
	global $wp_query;
	$pages = '';
	$max = $wp_query->max_num_pages;
	if (!$current = get_query_var('paged')) $current = 1;
	if ($max > 1) $pages = '<span class="pages">Page ' . $current . ' of ' . $max . '</span>'."\r\n";
	return $pages;
}
function pagination_links() {
	global $wp_query;
	$max = $wp_query->max_num_pages;
	if ($max > 1) {
		if (!$current = get_query_var('paged')) $current = 1;
		$a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
		$a['total'] = $max;
		$a['current'] = $current;
		echo '<div class="pagination">'.paginate_links($a).'</div>';
	}
}





//Register the taxonomy for the project categories
register_taxonomy(
    'project-category', 
    'project-category', 
    array ('hierarchical' => true, 'label' => __('Project Categories', 'flatbox' ))
    );  // portfolio categories

/* excerpt settings */
function mydesign_excerpt_more($more) {
	global $post;
	return '&#46;&#46;&#46;<div class="call-clearfix"></div> <a class="morestyle" href="'. get_permalink($post->ID) . '">' . __( 'Continue Reading', 'flatbox' ) . '</a>';
}
add_filter('excerpt_more', 'mydesign_excerpt_more');

function custom_excerpt_length( $length ) {
	return 28;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function excerpt($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
    }


/* widgets */
function flatbox_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Page Sidebar', 'flatbox' ),
		'id' => 'page-sidebar',
		'description' => __( 'Widget area for your main site sidebar', 'flatbox' ),
		'before_widget' => '<div class="%2$s sep widget-wrap">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="wtitle">',
		'after_title' => '</h3><div class=""></div>',
	));

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'flatbox' ),
		'id' => 'sidebar-1',
		'description' => __( 'An optional widget area for your site footer', 'flatbox' ),
		'before_widget' => '<div class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'flatbox' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional widget area for your site footer', 'flatbox' ),
		'before_widget' => '<div class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'flatbox' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'flatbox' ),
		'before_widget' => '<div class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Extra Menu', 'flatbox' ),
		'id' => 'sidebar_extra',
		'description' => __( 'Extra menu widgets', 'flatbox' ),
		'before_widget' => '<div class="%2$s wmenu_b">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="wmenu_t">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'flatbox_widgets_init' );

// functions to run on activation - flush to clear rewrites
if ( is_admin() ) {
	if ( isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
		$wp_rewrite->flush_rules();
	}
	// check for theme updates
	if ( !empty($smof_data["themeforest_username"]) && !empty($smof_data["themeforest_apikey"]) ) {
		require_once("utils/updater/theme-update.php");
		ThemeUpdater::init( $smof_data["themeforest_username"], $smof_data["themeforest_apikey"], 'liviu_cerchez' );
	}
}


function flatbox_comment_form_sep() {
	echo '<div class="sep sep-reply"></div>';
}
add_action ( 'comment_form_before', 'flatbox_comment_form_sep' );
add_action ( 'comment_form_must_log_in_after', 'flatbox_comment_form_sep' );


if ( ! function_exists( 'flatbox_comment' ) ) {

	function flatbox_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p><?php _e( 'Pingback:', 'flatbox' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'flatbox' ) ); ?></p>
<?php
				break;
			default :
			// Proceed with normal comments.
			global $post; ?>

			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<div class="clearfix">
					<div class="comment-author"><?php echo get_avatar( $comment, 80 ); ?></div>
					<div class="comment-body">
						<h6 class="bold"><?php echo get_comment_author_link( $comment->comment_ID ); ?> <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'flatbox' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></h6>
						<p class="date"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><span class="icon-date-gray"></span><?php
							/* translators: 1: date, 2: time */
							printf( __( '%1$s at %2$s', 'flatbox' ), get_comment_date(), get_comment_time() ); ?></a></p>
<?php if ( $comment->comment_approved == '0' ) : ?>
						<div class="alert notice">
							<p><em><?php _e( 'Your comment is awaiting moderation.', 'flatbox' ); ?> <?php edit_comment_link( __( 'Edit', 'flatbox' ) ); ?></em></p>
							<br />
							<?php comment_text(); ?>
						</div>
<?php else: ?>
						<?php comment_text(); ?>
						<?php edit_comment_link( __( 'Edit', 'flatbox' ) ); ?>
<?php endif; ?>

					</div>
				</div>
<?php
			break;
		endswitch; // end comment_type check
	}

} // function_exists



// enqueue the scripts
function flatbox_scripts_function() {

	// 	Main Theme Style
	wp_register_style( 'main-style',get_template_directory_uri() . '/css3/main.css', array(), '','all' ,true);

	//	 Base and normalize Styles
	wp_register_style( 'normalize',get_template_directory_uri() . '/css3/normalize.css', array(), '','all' ,true);
	wp_register_style( 'base',get_template_directory_uri() . '/css3/base.css', array(), '','all' ,true);
	wp_register_style( 'skeleton',get_template_directory_uri() . '/css3/skeleton.css', array(), '','all' ,true);

	//	 Responsive Style
	wp_register_style( 'style4',get_template_directory_uri() . '/css3/layout.css', array(), '','all' ,true);
	wp_register_style( 'style5',get_template_directory_uri() . '/css3/portfoliostyle.css', array(), '','all' ,true);
	wp_register_style( 'style6',get_template_directory_uri() . '/css3/roll_over.css', array(), '','all' ,true);

	// Layer slider style
	wp_register_style( 'layercss',get_template_directory_uri() . '/layerslider/css/layerslider.css', array(), '','all' ,true);


	//	Enqueue Styles
	wp_enqueue_style( 'main-style' );
	wp_enqueue_style( 'normalize' );
	wp_enqueue_style( 'base' );
	wp_enqueue_style( 'skeleton' );
	wp_enqueue_style( 'style4' );
	wp_enqueue_style( 'style5' );
	wp_enqueue_style( 'style6' );
	wp_enqueue_style( 'layercss' );

	//	Custom theme javascript	functions
	wp_enqueue_script('site', get_template_directory_uri() . '/js3/site.js', array('jquery'),'',true);


	// Progress bars and charts javascript fles
		wp_enqueue_script('superfish4', get_template_directory_uri() . '/js/superfish.js', array('jquery'),'','',true);
		wp_enqueue_script('dchart', get_template_directory_uri() . '/js/jquery.donutchart.js', array('jquery'),'','',true);



	wp_enqueue_script('js-f1', get_template_directory_uri() . '/js3/plugins.js', array('jquery'),'',true);
  	wp_enqueue_script('js-f2', get_template_directory_uri() . '/js3/respond.min.js', array('jquery'),'',true);
  	wp_enqueue_script('js-f3', get_template_directory_uri() . '/js3/jquery.inview.js', array('jquery'),'',true);
	
  	//	Twitter ticker javascript & scroll js
	if ( is_page_template('template-home.php')   ) {
		wp_enqueue_script('js-3', get_template_directory_uri() . '/js3/jquery.scrollTo-1.4.3.1-min.js', array('jquery'),'',true);
		wp_enqueue_script('js-ticker', get_template_directory_uri() . '/js3/ticker.js', array('jquery'),'',true);
	}

	//	Modernizr javascript
	wp_enqueue_script('js-modernizr', get_template_directory_uri() . '/js3/vendor/modernizr.custom.76532.js', array('jquery'),'',true);

	//	Contact Us forms javascript 
	if ( is_page_template('template-home.php')   ) {
		wp_enqueue_script('js-forms', get_template_directory_uri() . '/js3/jquery.forms.min.js', array('jquery'),'',true);
	}

	//	isotope
	wp_enqueue_script('js-isotope', get_template_directory_uri() . '/js3/jquery.isotope.min.js', array('jquery'),'',true);

  	// Layer slider javascript
  	wp_enqueue_script('js-l2', get_template_directory_uri() . '/layerslider/js/jquery-easing-1.3.js', array('jquery'),'',true);
  	wp_enqueue_script('js-l3', get_template_directory_uri() . '/layerslider/js/jquery-transit-modified.js', array('jquery'),'',true);
  	wp_enqueue_script('js-l4', get_template_directory_uri() . '/layerslider/js/layerslider.transitions.js', array('jquery'),'',true);
  	wp_enqueue_script('js-l5', get_template_directory_uri() . '/layerslider/js/layerslider.kreaturamedia.jquery.js', array('jquery'),'',true);
}
add_action( 'wp_enqueue_scripts', 'flatbox_scripts_function' );

function add_IE() {
	$IE = (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$_SERVER['HTTP_USER_AGENT'],$matched));
	if ( $IE ) {
		wp_register_script( 'IE_js', get_template_directory_uri() . '/js/ie.js' );
    	wp_enqueue_script( 'IE_js' );
 	}
}  

add_action( 'wp_enqueue_scripts', 'add_IE', 10 );