<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Header
	/*-----------------------------------------------------------------------------------*/
	/**
	 *
	 * The template for displaying the header
	 *
	 * Displays all of the <head> section and everything up till <div id="main">
	 *
	 * @package WordPress
	 * @subpackage Profile
	 * @since Profile 1.0
	 */
?>
<!-- 	<?php header('Content-Type: text/html; charset=UTF-8'); ?> -->



<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<!--[if lt IE 9]>
    <div aria-hidden="true" class="browsehappy"><strong>Seriously?</strong> You're using a <em>terribly old</em>&nbsp; version of Internet Explorer.<br> You really should <a href="http://browsehappy.com/?locale=en">upgrade</a>, you'll find the web works much better in a modern browser.<br>
    I recommend Google Chrome, it's fast, secure and works on this PC. <strong><a href="https://www.google.com/chrome/">Do it!</a></strong> <button class="close">&times;</button></div>
<![endif]-->

<!--
========================================================================

	Design and Property of Andre Bulatov

========================================================================
-->

<head>

	<!-- 	Basic Meta Tags -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="resource-type" content="document" />
	<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<!-- <meta http-equiv="content-language" content="en-us" /> -->
	<meta name="author" content="Andre Bulatov" />
	<meta name="contact" content="andre.bulatov@gmail.com" />
	<meta name="copyright" content="Copyleft? (c)2013-2016 Andre Bulatov. All Rights Reserved?" />
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta name="theme-color" content="#41b7d8">	
    <title><?php wp_title(''); ?></title>
	<!-- <link rel="canonical" href="//andrebulatov.com/contact/"> -->

	<link rel="alternate" href="<?php echo site_url().'/'.get_page_uri(); ?>" hreflang="x-default">
	<link rel="alternate" href="<?php echo site_url().'/'.get_page_uri(get_the_ID()); ?>" hreflang="en">
	<link rel="alternate" href="<?php echo site_url().'/'.get_page_uri(get_the_ID()); ?>" hreflang="en-us">
    <!--    Link Tags   -->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<!--
	<?php
	setup_postdata( $post );
	if (is_single() || is_page()) {
		$meta_url    = get_permalink();
		$meta_title  = get_the_title();
		$meta_desc   = get_the_excerpt();
		$meta_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full );
		$meta_thumb  = $meta_thumbs[0];
		if(!$meta_thumb) {
			$meta_thumb = 'https://secure.gravatar.com/avatar/e96e1c2b25eac0979f5a996f4974ffdd?s=96&d=mm&r=g&size=75';
		}
		$meta_name   = str_replace('@', '', get_the_author_meta('twitter'));
	} elseif ( is_archive() ) {
		$meta_url    = get_permalink();
		$meta_title  = wp_title('', false);
		$meta_desc   = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true); 
	} elseif ( is_home() ) {
		$meta_title  = wp_title('', false);
		$meta_desc   = get_bloginfo('description');
		//$meta_desc   = get_post_meta(get_the_ID(), 'description', true);
	}
	?>

	
	<meta name="description" content="            php echo $meta_desc; ?>">
	<meta name="robots" content="noodp, noydir" />
	<link rel="canonical" href="https://andrebulatov.com/blog/">
	<link rel="next" href="https://andrebulatov.com/blog/page/2/">
-->
	<script type="application/ld+json">
	[
		{ 
			"@context": "http://schema.org",
			"@type": "Person",
			"name": "Andre Bulatov",
			"givenName": "Andre",
			"familyName": "Bulatov",
			"url": "https://andrebulatov.com",
			"email": "andre.bulatov@gmail.com",
			"birthDate": "July 4th, 1984",
			"birthPlace": "Ust-kamenogorsk, Kazakstan",
			"nationality": "American",
			"image": "https://andrebulatov.com/wp-content/uploads/images/Andre.png",
			"address": {
				"@type": "PostalAddress",
				"addressLocality": "New York",
				"addressRegion": "NY",
				"postalCode": "10119",
				"streetAddress": "1 Pennsylvania Plaza"
			},
			"colleague": [
				"http://boriskhaykin.com/",
				"http://stephlev.com/"
			],
			"sameAs": [ 
				"https://twitter.com/AndreBulatov",
				"https://www.facebook.com/iamandrebulatov",
				"https://instagram.com/iamandrebulatov",
				"https://www.linkedin.com/in/andrebulatov",
				"https://plus.google.com/+AndreBulatov"
			]
		},
		{
			"@context": "http://schema.org",
			"@type": "WebSite",
			"url": "https://andrebulatov.com",
			"name": "Andre's Website",
			"creator": {
				"@type": "Person",
				"name": "Andre Bulatov"
			},
			"dateCreated": "March 3, 2013",
			"dateModified": "November 18, 2015",
			"copyrightYear": "2013?",
			"copyrightHolder": {
				"@type": "Organization",
				"name": "Andre Bulatov LLC?"
			},
			"about": {
				"@type": "Person",
				"name": "Andre Bulatov"
			},
			"description": "A personal profile website",
			"accountablePerson": "Andre Bulatov",
			"inLanguage": "en-US",
			"isFamilyFriendly": "true",
			"potentialAction": {
				"@type": "SearchAction",
				"target": "https://andrebulatov.com/?s={searchQuery}",
				"query-input": "required name=searchQuery"
			}
		}
	]
	</script>
	
	<!-- Other/social meta tags -->
<!--
	<link rel="publisher" href="//plus.google.com/+AndreBulatov">
	<link rel="publisher" href="https://plus.google.com/109308454256342109455">
	<meta name="p:domain_verify" content="eff2f6e55674f45bffcadbb51c9ae9ce"/>
	<meta property="fb:admins" content="100004378810001" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="Andre Bulatov" />
	<meta property="og:title" content="<?php echo $meta_title; ?>" />
	<meta property="og:description" content="<?php echo $meta_desc; ?>" />
	<meta property="og:image" content="<?php echo $meta_thumb; ?>" />
	<meta property="og:image:height" content="200" />
	<meta property="og:image:width" content="200" />
	<meta property="og:locale" content="en_US" />
	<meta name="twitter:card" value="summary" />
	<meta name="twitter:domain" content="andrebulatov.com" />
	<meta name="twitter:url" value="<?php echo $meta_url; ?>" />
	<meta name="twitter:title" value="<?php echo $meta_title; ?>" />
	<meta name="twitter:description" value="<?php echo $meta_desc; ?>" />
	<meta name="twitter:site" value="@andrebulatov" />
	<meta name="twitter:creator" value="@andrebulatov" />
-->
<!--
	<meta name="twitter:image" value="<?php echo $meta_thumb; ?>" />
	<meta name="twitter:image:src" content="<?php echo $meta_thumb; ?>" />
	<meta name="twitter:image:height" content="100" />
	<meta name="twitter:image:width" content="100" />
-->
	<!--    END Andre's Metas -->

	
	<!--    Andre favicons -->
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/favicon-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<meta name="msapplication-TileColor" content="#2d89ef">
	<meta name="msapplication-TileImage" content="/mstile-144x144.png">
	<!--    END Andre favicons -->
	
	
	<!-- 	Google Analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  ga('create', 'UA-57129895-1', 'auto');
	  ga('send', 'pageview');
	</script>
	<!-- 	END Google Analytics -->
	

	<?php wp_head(); ?>


	<!-- W3TC-include-css -->

</head>



<?php 
	$ip_address = $_SERVER["REMOTE_ADDR"];
?>



<body data-spy="scroll" data-target="#navbar-page" <?php body_class(); ?> 
	itemscope itemtype="http://schema.org/<?php 
		if (is_page(array(48, 'about', 'About'))) { 
			echo 'AboutPage'; 
		} elseif (is_page(array(52, 'contact', 'Contact'))) {
			echo 'ContactPage'; 
		} else {
			echo 'WebPage';
		} 
		?>">

<!-- <div id="top" class="jumbotron" data-src="/wp-content/uploads/kitten_scratch.gif" data-position="center center"> -->
<!-- <div id="top" class="jumbotron" data-src="/wp-content/uploads/highway_animation.gif" data-position="center center"> data-src="/wp-content/uploads/images/contact.jpg" data-position="center center" -->
<header id="top" class="masthead jumbotron <?php if (is_page_template('blank.php')) {echo 'hidden';} ?>" role="banner" 
	itemprop="hasPart" itemscope itemtype="http://schema.org/WPHeader">
	<meta itemprop="name" content="ABCOM Site Header" />
	<meta itemprop="description" content="This is the masthead / banner / header for Andre Bulatov's site, AndreBulatov.com" />
	<div class="container">
		<h1 class="site-title" itemprop="headline">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" 
				title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
			</a>
		</h1>
		<h2 class="lead" itemprop="description">
				<?php if(is_home() ): ?>
					Blog
				<?php else: ?>
					<?php echo get_the_title(); ?>
				<?php endif; ?>
		</h2>
	</div>
	<div class="overlay"></div>
<div id="parrot-ouioui">
		<div class="parrot-ouioui" style="left: 121px; top: 329px; border-width: 0px 0px 33px 12px; border-bottom-color: rgb(44, 52, 16);"></div> 
		<div class="parrot-ouioui" style="left: 343px; top: 130px; border-width: 0px 65px 38px 0px; border-bottom-color: rgb(88, 91, 41);"></div> 
		<div class="parrot-ouioui" style="left: 328px; top: 126px; border-width: 0px 0px 26px 16px; border-left-color: rgb(88, 91, 41);"></div> 
		<div class="parrot-ouioui" style="left: 224px; top: 120px; border-width: 0px 0px 84px 135px; border-bottom-color: rgb(88, 91, 41);"></div> 
		<div class="parrot-ouioui" style="left: 329px; top: 119px; border-width: 0px 0px 8px 29px; border-bottom-color: rgb(88, 91, 41);"></div> 
		<div class="parrot-ouioui" style="left: 256px; top: 167px; border-width: 0px 0px 72px 106px; border-bottom-color: rgb(148, 115, 55);"></div> 
		<div class="parrot-ouioui" style="left: 233px; top: 346px; border-width: 0px 0px 73px 36px; border-bottom-color: rgb(130, 155, 24);"></div> 
		<div class="parrot-ouioui" style="left: 265px; top: 383px; border-width: 0px 28px 18px 0px; border-bottom-color: rgb(142, 122, 108);"></div> 
		<div class="parrot-ouioui" style="left: 233px; top: 391px; border-width: 0px 0px 29px 38px; border-bottom-color: rgb(96, 84, 49);"></div> 
		<div class="parrot-ouioui" style="left: 230px; top: 396px; border-width: 0px 0px 28px 44px; border-bottom-color: rgb(134, 115, 85);"></div> 
		<div class="parrot-ouioui" style="left: 243px; top: 396px; border-width: 0px 0px 27px 37px; border-bottom-color: rgb(212, 189, 157);"></div> 
		<div class="parrot-ouioui" style="left: 242px; top: 408px; border-width: 0px 0px 16px 30px; border-bottom-color: rgb(66, 43, 21);"></div> 
		<div class="parrot-ouioui" style="left: 131px; top: 369px; border-width: 0px 0px 49px 10px; border-bottom-color: rgb(51, 73, 21);"></div> 
		<div class="parrot-ouioui" style="left: 298px; top: 406px; border-width: 0px 20px 16px 0px; border-bottom-color: rgb(193, 166, 147);"></div> 
		<div class="parrot-ouioui" style="left: 307px; top: 412px; border-width: 0px 19px 19px 0px; border-bottom-color: rgb(174, 155, 142);"></div> 
		<div class="parrot-ouioui" style="left: 279px; top: 392px; border-width: 0px 30px 22px 0px; border-bottom-color: rgb(179, 155, 138);"></div> 
		<div class="parrot-ouioui" style="left: 279px; top: 397px; border-width: 0px 48px 36px 0px; border-bottom-color: rgb(195, 167, 143);"></div> 
		<div class="parrot-ouioui" style="left: 287px; top: 409px; border-width: 0px 12px 8px 0px; border-bottom-color: rgb(201, 180, 127);"></div> 
		<div class="parrot-ouioui" style="left: 268px; top: 410px; border-width: 0px 19px 17px 0px; border-right-color: rgb(201, 180, 127);"></div> 
		<div class="parrot-ouioui" style="left: 295px; top: 413px; border-width: 0px 13px 10px 0px; border-bottom-color: rgb(201, 180, 127);"></div> 
		<div class="parrot-ouioui" style="left: 292px; top: 422px; border-width: 0px 16px 12px 0px; border-right-color: rgb(201, 180, 127);"></div> 
		<div class="parrot-ouioui" style="left: 285px; top: 409px; border-width: 0px 39px 36px 0px; border-bottom-color: rgb(207, 184, 136);"></div> 
		<div class="parrot-ouioui" style="left: 283px; top: 410px; border-width: 0px 18px 14px 0px; border-bottom-color: rgb(174, 143, 83);"></div> 
		<div class="parrot-ouioui" style="left: 307px; top: 422px; border-width: 0px 17px 22px 0px; border-bottom-color: rgb(179, 138, 84);"></div> 
		<div class="parrot-ouioui" style="left: 298px; top: 427px; border-width: 0px 0px 18px 15px; border-bottom-color: rgb(241, 223, 175);"></div> 
		<div class="parrot-ouioui" style="left: 265px; top: 409px; border-width: 0px 57px 36px 0px; border-bottom-color: rgb(195, 170, 98);"></div> 
		<div class="parrot-ouioui" style="left: 237px; top: 382px; border-width: 0px 0px 29px 26px; border-left-color: rgb(118, 145, 26);"></div> 
		<div class="parrot-ouioui" style="left: 243px; top: 413px; border-width: 0px 0px 13px 22px; border-bottom-color: rgb(154, 122, 61);"></div> 
		<div class="parrot-ouioui" style="left: 219px; top: 424px; border-width: 0px 30px 21px 0px; border-right-color: rgb(168, 141, 81);"></div> 
		<div class="parrot-ouioui" style="left: 229px; top: 424px; border-width: 0px 0px 18px 27px; border-bottom-color: rgb(151, 111, 54);"></div> 
		<div class="parrot-ouioui" style="left: 215px; top: 424px; border-width: 0px 13px 21px 0px; border-right-color: rgb(140, 96, 51);"></div> 
		<div class="parrot-ouioui" style="left: 216px; top: 422px; border-width: 0px 10px 21px 0px; border-bottom-color: rgb(155, 105, 41);"></div> 
		<div class="parrot-ouioui" style="left: 218px; top: 437px; border-width: 0px 32px 6px 0px; border-bottom-color: rgb(141, 89, 46);"></div> 
		<div class="parrot-ouioui" style="left: 225px; top: 432px; border-width: 0px 0px 13px 37px; border-bottom-color: rgb(181, 152, 89);"></div> 
		<div class="parrot-ouioui" style="left: 212px; top: 434px; border-width: 0px 0px 11px 16px; border-bottom-color: rgb(133, 89, 41);"></div> 
		<div class="parrot-ouioui" style="left: 320px; top: 281px; border-width: 0px 0px 34px 20px; border-left-color: rgb(222, 229, 187);"></div> 
		<div class="parrot-ouioui" style="left: 313px; top: 281px; border-width: 0px 0px 41px 27px; border-left-color: rgb(216, 215, 206);"></div> 
		<div class="parrot-ouioui" style="left: 208px; top: 336px; border-width: 0px 0px 33px 25px; border-left-color: rgb(74, 87, 44);"></div> 
		<div class="parrot-ouioui" style="left: 212px; top: 380px; border-width: 0px 26px 33px 0px; border-right-color: rgb(103, 129, 24);"></div> 
		<div class="parrot-ouioui" style="left: 239px; top: 315px; border-width: 0px 23px 76px 0px; border-bottom-color: rgb(119, 148, 43);"></div> 
		<div class="parrot-ouioui" style="left: 240px; top: 321px; border-width: 0px 23px 74px 0px; border-right-color: rgb(146, 172, 49);"></div> 
		<div class="parrot-ouioui" style="left: 210px; top: 337px; border-width: 0px 0px 54px 30px; border-bottom-color: rgb(87, 121, 32);"></div> 
		<div class="parrot-ouioui" style="left: 218px; top: 336px; border-width: 0px 0px 44px 24px; border-left-color: rgb(102, 138, 37);"></div> 
		<div class="parrot-ouioui" style="left: 210px; top: 355px; border-width: 0px 0px 42px 17px; border-left-color: rgb(127, 132, 85);"></div> 
		<div class="parrot-ouioui" style="left: 179px; top: 388px; border-width: 0px 0px 24px 47px; border-left-color: rgb(128, 136, 49);"></div> 
		<div class="parrot-ouioui" style="left: 152px; top: 332px; border-width: 0px 0px 61px 62px; border-bottom-color: rgb(93, 119, 27);"></div> 
		<div class="parrot-ouioui" style="left: 162px; top: 352px; border-width: 0px 0px 48px 31px; border-left-color: rgb(69, 101, 43);"></div> 
		<div class="parrot-ouioui" style="left: 137px; top: 368px; border-width: 0px 0px 53px 26px; border-bottom-color: rgb(76, 119, 47);"></div> 
		<div class="parrot-ouioui" style="left: 138px; top: 364px; border-width: 0px 0px 57px 34px; border-left-color: rgb(45, 60, 22);"></div> 
		<div class="parrot-ouioui" style="left: 237px; top: 324px; border-width: 0px 25px 34px 0px; border-right-color: rgb(119, 151, 24);"></div> 
		<div class="parrot-ouioui" style="left: 192px; top: 205px; border-width: 0px 0px 26px 33px; border-bottom-color: rgb(46, 64, 26);"></div> 
		<div class="parrot-ouioui" style="left: 222px; top: 285px; border-width: 0px 0px 43px 37px; border-bottom-color: rgb(163, 165, 77);"></div> 
		<div class="parrot-ouioui" style="left: 240px; top: 274px; border-width: 0px 0px 36px 36px; border-bottom-color: rgb(204, 209, 175);"></div> 
		<div class="parrot-ouioui" style="left: 222px; top: 313px; border-width: 0px 0px 23px 21px; border-bottom-color: rgb(86, 117, 35);"></div> 
		<div class="parrot-ouioui" style="left: 244px; top: 286px; border-width: 0px 0px 42px 28px; border-bottom-color: rgb(117, 141, 41);"></div> 
		<div class="parrot-ouioui" style="left: 262px; top: 355px; border-width: 0px 0px 37px 12px; border-left-color: rgb(170, 192, 99);"></div> 
		<div class="parrot-ouioui" style="left: 202px; top: 177px; border-width: 0px 0px 41px 66px; border-bottom-color: rgb(73, 69, 46);"></div> 
		<div class="parrot-ouioui" style="left: 180px; top: 212px; border-width: 0px 0px 35px 32px; border-bottom-color: rgb(0, 1, 0);"></div> 
		<div class="parrot-ouioui" style="left: 160px; top: 238px; border-width: 0px 0px 38px 28px; border-bottom-color: rgb(111, 99, 49);"></div> 
		<div class="parrot-ouioui" style="left: 163px; top: 237px; border-width: 0px 0px 41px 31px; border-bottom-color: rgb(124, 134, 61);"></div> 
		<div class="parrot-ouioui" style="left: 129px; top: 232px; border-width: 0px 0px 101px 70px; border-bottom-color: rgb(115, 126, 56);"></div> 
		<div class="parrot-ouioui" style="left: 124px; top: 261px; border-width: 0px 0px 84px 59px; border-bottom-color: rgb(11, 18, 8);"></div> 
		<div class="parrot-ouioui" style="left: 202px; top: 227px; border-width: 0px 0px 29px 24px; border-left-color: rgb(9, 13, 8);"></div> 
		<div class="parrot-ouioui" style="left: 209px; top: 226px; border-width: 0px 16px 29px 0px; border-right-color: rgb(55, 77, 36);"></div> 
		<div class="parrot-ouioui" style="left: 199px; top: 239px; border-width: 0px 0px 23px 40px; border-left-color: rgb(39, 55, 28);"></div> 
		<div class="parrot-ouioui" style="left: 183px; top: 231px; border-width: 0px 0px 39px 20px; border-bottom-color: rgb(0, 0, 0);"></div> 
		<div class="parrot-ouioui" style="left: 180px; top: 266px; border-width: 0px 0px 29px 23px; border-left-color: rgb(46, 54, 27);"></div> 
		<div class="parrot-ouioui" style="left: 220px; top: 212px; border-width: 0px 68px 37px 0px; border-bottom-color: rgb(55, 73, 36);"></div> 
		<div class="parrot-ouioui" style="left: 218px; top: 212px; border-width: 0px 54px 30px 0px; border-right-color: rgb(19, 34, 16);"></div> 
		<div class="parrot-ouioui" style="left: 215px; top: 245px; border-width: 0px 0px 42px 32px; border-left-color: rgb(39, 56, 26);"></div> 
		<div class="parrot-ouioui" style="left: 120px; top: 267px; border-width: 0px 0px 96px 61px; border-bottom-color: rgb(61, 83, 31);"></div> 
		<div class="parrot-ouioui" style="left: 211px; top: 244px; border-width: 0px 0px 47px 27px; border-bottom-color: rgb(52, 93, 45);"></div> 
		<div class="parrot-ouioui" style="left: 233px; top: 229px; border-width: 0px 0px 50px 35px; border-left-color: rgb(65, 94, 45);"></div> 
		<div class="parrot-ouioui" style="left: 168px; top: 303px; border-width: 0px 50px 41px 0px; border-bottom-color: rgb(27, 49, 24);"></div> 
		<div class="parrot-ouioui" style="left: 383px; top: 123px; border-width: 0px 18px 20px 0px; border-bottom-color: rgb(148, 131, 91);"></div> 
		<div class="parrot-ouioui" style="left: 347px; top: 248px; border-width: 0px 0px 12px 15px; border-bottom-color: rgb(155, 188, 99);"></div> 
		<div class="parrot-ouioui" style="left: 328px; top: 259px; border-width: 0px 0px 30px 35px; border-left-color: rgb(149, 178, 56);"></div> 
		<div class="parrot-ouioui" style="left: 318px; top: 186px; border-width: 0px 22px 38px 0px; border-right-color: rgb(86, 93, 48);"></div> 
		<div class="parrot-ouioui" style="left: 315px; top: 167px; border-width: 0px 0px 54px 32px; border-left-color: rgb(62, 54, 21);"></div> 
		<div class="parrot-ouioui" style="left: 324px; top: 129px; border-width: 0px 0px 28px 19px; border-bottom-color: rgb(76, 54, 34);"></div> 
		<div class="parrot-ouioui" style="left: 327px; top: 148px; border-width: 0px 13px 13px 0px; border-bottom-color: rgb(156, 132, 86);"></div> 
		<div class="parrot-ouioui" style="left: 330px; top: 155px; border-width: 0px 10px 9px 0px; border-right-color: rgb(153, 133, 81);"></div> 
		<div class="parrot-ouioui" style="left: 326px; top: 134px; border-width: 0px 0px 27px 13px; border-left-color: rgb(155, 155, 113);"></div> 
		<div class="parrot-ouioui" style="left: 322px; top: 133px; border-width: 0px 0px 29px 14px; border-left-color: rgb(68, 79, 43);"></div> 
		<div class="parrot-ouioui" style="left: 339px; top: 135px; border-width: 0px 9px 16px 0px; border-right-color: rgb(191, 164, 112);"></div> 
		<div class="parrot-ouioui" style="left: 334px; top: 139px; border-width: 0px 0px 24px 14px; border-bottom-color: rgb(192, 164, 90);"></div> 
		<div class="parrot-ouioui" style="left: 338px; top: 144px; border-width: 0px 0px 29px 15px; border-bottom-color: rgb(80, 59, 27);"></div> 
		<div class="parrot-ouioui" style="left: 329px; top: 171px; border-width: 0px 0px 29px 25px; border-left-color: rgb(134, 22, 9);"></div> 
		<div class="parrot-ouioui" style="left: 369px; top: 120px; border-width: 0px 32px 22px 0px; border-bottom-color: rgb(178, 70, 34);"></div> 
		<div class="parrot-ouioui" style="left: 351px; top: 120px; border-width: 0px 60px 38px 0px; border-bottom-color: rgb(88, 91, 41);"></div> 
		<div class="parrot-ouioui" style="left: 347px; top: 157px; border-width: 0px 33px 44px 0px; border-right-color: rgb(119, 25, 20);"></div> 
		<div class="parrot-ouioui" style="left: 362px; top: 182px; border-width: 0px 0px 24px 20px; border-bottom-color: rgb(237, 201, 167);"></div> 
		<div class="parrot-ouioui" style="left: 354px; top: 138px; border-width: 0px 0px 12px 10px; border-left-color: rgb(157, 38, 25);"></div> 
		<div class="parrot-ouioui" style="left: 381px; top: 141px; border-width: 0px 0px 20px 16px; border-left-color: rgb(205, 56, 39);"></div> 
		<div class="parrot-ouioui" style="left: 347px; top: 176px; border-width: 0px 7px 43px 0px; border-right-color: rgb(160, 122, 80);"></div> 
		<div class="parrot-ouioui" style="left: 347px; top: 177px; border-width: 0px 4px 28px 0px; border-bottom-color: rgb(62, 41, 18);"></div> 
		<div class="parrot-ouioui" style="left: 219px; top: 179px; border-width: 0px 0px 34px 52px; border-bottom-color: rgb(83, 115, 40);"></div> 
		<div class="parrot-ouioui" style="left: 252px; top: 192px; border-width: 0px 29px 43px 0px; border-right-color: rgb(65, 83, 38);"></div> 
		<div class="parrot-ouioui" style="left: 244px; top: 171px; border-width: 0px 0px 22px 36px; border-bottom-color: rgb(77, 91, 40);"></div> 
		<div class="parrot-ouioui" style="left: 278px; top: 169px; border-width: 0px 53px 73px 0px; border-bottom-color: rgb(75, 115, 41);"></div> 
		<div class="parrot-ouioui" style="left: 293px; top: 223px; border-width: 0px 37px 74px 0px; border-right-color: rgb(131, 163, 40);"></div> 
		<div class="parrot-ouioui" style="left: 268px; top: 215px; border-width: 0px 50px 35px 0px; border-bottom-color: rgb(98, 144, 32);"></div> 
		<div class="parrot-ouioui" style="left: 336px; top: 192px; border-width: 0px 0px 40px 20px; border-bottom-color: rgb(148, 115, 55);"></div> 
		<div class="parrot-ouioui" style="left: 366px; top: 201px; border-width: 0px 0px 21px 18px; border-left-color: rgb(227, 185, 148);"></div> 
		<div class="parrot-ouioui" style="left: 388px; top: 152px; border-width: 0px 0px 22px 20px; border-bottom-color: rgb(140, 115, 40);"></div> 
		<div class="parrot-ouioui" style="left: 389px; top: 152px; border-width: 0px 0px 22px 18px; border-left-color: rgb(135, 111, 42);"></div> 
		<div class="parrot-ouioui" style="left: 388px; top: 169px; border-width: 0px 0px 12px 12px; border-left-color: rgb(200, 48, 35);"></div> 
		<div class="parrot-ouioui" style="left: 378px; top: 151px; border-width: 0px 0px 27px 19px; border-left-color: rgb(186, 60, 36);"></div> 
		<div class="parrot-ouioui" style="left: 393px; top: 173px; border-width: 0px 0px 16px 16px; border-left-color: rgb(202, 115, 104);"></div> 
		<div class="parrot-ouioui" style="left: 377px; top: 177px; border-width: 0px 0px 43px 22px; border-left-color: rgb(188, 114, 73);"></div> 
		<div class="parrot-ouioui" style="left: 313px; top: 258px; border-width: 0px 11px 26px 0px; border-bottom-color: rgb(126, 160, 45);"></div> 
		<div class="parrot-ouioui" style="left: 271px; top: 248px; border-width: 0px 44px 72px 0px; border-right-color: rgb(136, 171, 25);"></div> 
		<div class="parrot-ouioui" style="left: 327px; top: 177px; border-width: 0px 0px 43px 20px; border-bottom-color: rgb(135, 101, 59);"></div> 
		<div class="parrot-ouioui" style="left: 326px; top: 220px; border-width: 0px 17px 13px 0px; border-bottom-color: rgb(145, 165, 54);"></div> 
		<div class="parrot-ouioui" style="left: 310px; top: 219px; border-width: 0px 40px 17px 0px; border-right-color: rgb(154, 156, 53);"></div> 
		<div class="parrot-ouioui" style="left: 269px; top: 231px; border-width: 0px 45px 88px 0px; border-bottom-color: rgb(144, 177, 34);"></div> 
		<div class="parrot-ouioui" style="left: 262px; top: 318px; border-width: 0px 0px 48px 54px; border-left-color: rgb(144, 177, 34);"></div> 
		<div class="parrot-ouioui" style="left: 324px; top: 232px; border-width: 0px 0px 69px 55px; border-left-color: rgb(144, 177, 34);"></div> 
		<div class="parrot-ouioui" style="left: 357px; top: 119px; border-width: 0px 33px 12px 0px; border-bottom-color: rgb(212, 54, 32);"></div> 
		<div class="parrot-ouioui" style="left: 350px; top: 125px; border-width: 0px 25px 13px 0px; border-bottom-color: rgb(183, 37, 24);"></div> 
		<div class="parrot-ouioui" style="left: 352px; top: 129px; border-width: 0px 29px 12px 0px; border-right-color: rgb(208, 49, 35);"></div> 
		<div class="parrot-ouioui" style="left: 393px; top: 132px; border-width: 0px 17px 23px 0px; border-bottom-color: rgb(212, 54, 32);"></div> 
		<div class="parrot-ouioui" style="left: 353px; top: 204px; border-width: 0px 0px 28px 13px; border-bottom-color: rgb(205, 161, 112);"></div> 
		<div class="parrot-ouioui" style="left: 355px; top: 193px; border-width: 0px 0px 36px 23px; border-left-color: rgb(198, 139, 76);"></div> 
		<div class="parrot-ouioui" style="left: 355px; top: 171px; border-width: 0px 0px 23px 22px; border-bottom-color: rgb(201, 145, 78);"></div> 
		<div class="parrot-ouioui" style="left: 376px; top: 176px; border-width: 0px 0px 31px 18px; border-left-color: rgb(245, 212, 184);"></div> 
		<div class="parrot-ouioui" style="left: 324px; top: 149px; border-width: 0px 20px 22px 0px; border-bottom-color: rgb(62, 66, 35);"></div> 
		<div class="parrot-ouioui" style="left: 278px; top: 129px; border-width: 0px 0px 41px 51px; border-bottom-color: rgb(74, 98, 46);"></div> 
		<div class="parrot-ouioui" style="left: 278px; top: 170px; border-width: 0px 40px 59px 0px; border-right-color: rgb(75, 103, 44);"></div> 
		<div class="parrot-ouioui" style="left: 309px; top: 164px; border-width: 0px 30px 58px 0px; border-bottom-color: rgb(72, 95, 42);"></div> 
		<div class="parrot-ouioui" style="left: 313px; top: 271px; border-width: 0px 0px 50px 11px; border-left-color: rgb(153, 184, 28);"></div> 
		<div class="parrot-ouioui" style="left: 357px; top: 208px; border-width: 0px 0px 24px 21px; border-bottom-color: rgb(118, 158, 45);"></div> 
		<div class="parrot-ouioui" style="left: 355px; top: 176px; border-width: 0px 0px 18px 20px; border-left-color: rgb(180, 130, 71);"></div> 
		<div class="parrot-ouioui" style="left: 375px; top: 157px; border-width: 0px 32px 16px 0px; border-bottom-color: rgb(200, 48, 35);"></div> 
		<div class="parrot-ouioui" style="left: 375px; top: 163px; border-width: 0px 22px 14px 0px; border-bottom-color: rgb(243, 188, 164);"></div> 
		<div class="parrot-ouioui" style="left: 349px; top: 163px; border-width: 0px 0px 13px 27px; border-bottom-color: rgb(179, 115, 77);"></div> 
		<div class="parrot-ouioui" style="left: 369px; top: 166px; border-width: 0px 0px 6px 3px; border-bottom-color: rgb(115, 52, 26);"></div> 
		<div class="parrot-ouioui" style="left: 221px; top: 227px; border-width: 0px 0px 63px 48px; border-bottom-color: rgb(68, 101, 48);"></div> 
		<div class="parrot-ouioui" style="left: 320px; top: 178px; border-width: 0px 11px 21px 0px; border-right-color: rgb(138, 26, 11);"></div> 
		<div class="parrot-ouioui" style="left: 330px; top: 121px; border-width: 0px 0px 16px 18px; border-bottom-color: rgb(141, 64, 40);"></div> 
		<div class="parrot-ouioui" style="left: 340px; top: 130px; border-width: 0px 13px 14px 0px; border-right-color: rgb(125, 84, 47);"></div> 
		<div class="parrot-ouioui" style="left: 334px; top: 139px; border-width: 0px 0px 11px 6px; border-bottom-color: rgb(13, 23, 20);"></div> 
		<div class="parrot-ouioui" style="left: 168px; top: 342px; border-width: 0px 0px 22px 49px; border-left-color: rgb(30, 54, 23);"></div> 
		<div class="parrot-ouioui" style="left: 125px; top: 303px; border-width: 0px 0px 63px 46px; border-bottom-color: rgb(30, 41, 21);"></div> 
		<div class="parrot-ouioui" style="left: 217px; top: 288px; border-width: 0px 0px 55px 49px; border-left-color: rgb(59, 101, 45);"></div> 
		<div class="parrot-ouioui" style="left: 168px; top: 304px; border-width: 0px 50px 40px 0px; border-right-color: rgb(43, 68, 34);"></div> 
		<div class="parrot-ouioui" style="left: 170px; top: 233px; border-width: 0px 0px 73px 48px; border-bottom-color: rgb(33, 48, 26);"></div> 
		<div class="parrot-ouioui" style="left: 179px; top: 216px; border-width: 0px 0px 30px 27px; border-bottom-color: rgb(22, 24, 10);"></div> 
		<div class="parrot-ouioui" style="left: 133px; top: 386px; border-width: 0px 0px 68px 32px; border-bottom-color: rgb(51, 81, 39);"></div> 
		<div class="parrot-ouioui" style="left: 134px; top: 430px; border-width: 0px 0px 77px 27px; border-left-color: rgb(88, 110, 55);"></div> 
		<div class="parrot-ouioui" style="left: 147px; top: 430px; border-width: 0px 0px 25px 22px; border-bottom-color: rgb(135, 132, 62);"></div> 
		<div class="parrot-ouioui" style="left: 164px; top: 392px; border-width: 0px 0px 47px 38px; border-left-color: rgb(100, 138, 32);"></div> 
		<div class="parrot-ouioui" style="left: 157px; top: 419px; border-width: 0px 0px 29px 24px; border-left-color: rgb(77, 102, 42);"></div> 
		<div class="parrot-ouioui" style="left: 135px; top: 415px; border-width: 0px 0px 50px 23px; border-left-color: rgb(48, 78, 27);"></div> 
		<div class="parrot-ouioui" style="left: 219px; top: 354px; border-width: 0px 0px 34px 23px; border-bottom-color: rgb(108, 134, 43);"></div> 
		<div class="parrot-ouioui" style="left: 261px; top: 432px; border-width: 0px 30px 13px 0px; border-bottom-color: rgb(213, 187, 127);"></div> 
		<div class="parrot-ouioui" style="left: 245px; top: 424px; border-width: 0px 24px 20px 0px; border-right-color: rgb(166, 127, 55);"></div> 
		<div class="parrot-ouioui" style="left: 247px; top: 422px; border-width: 0px 21px 16px 0px; border-bottom-color: rgb(145, 100, 40);"></div> 
		<div class="parrot-ouioui" style="left: 208px; top: 422px; border-width: 0px 0px 22px 9px; border-bottom-color: rgb(160, 136, 79);"></div> 
		<div class="parrot-ouioui" style="left: 215px; top: 423px; border-width: 0px 0px 9px 13px; border-left-color: rgb(174, 147, 94);"></div> 
		<div class="parrot-ouioui" style="left: 226px; top: 422px; border-width: 0px 15px 20px 0px; border-bottom-color: rgb(174, 148, 86);"></div> 
		<div class="parrot-ouioui" style="left: 264px; top: 416px; border-width: 0px 50px 29px 0px; border-bottom-color: rgb(188, 142, 42);"></div> 
		<div class="parrot-ouioui" style="left: 278px; top: 404px; border-width: 0px 15px 5px 0px; border-bottom-color: rgb(145, 112, 60);"></div> 
		<div class="parrot-ouioui" style="left: 320px; top: 430px; border-width: 0px 7px 15px 0px; border-right-color: rgb(115, 93, 77);"></div> 
		<div class="parrot-ouioui" style="left: 343px; top: 136px; border-width: 0px 3px 16px 0px; border-bottom-color: rgb(192, 164, 90);"></div> 
	</div>	<a href="#primary" class="scroll-down-page">	
		<span class="fa fa-chevron-down"></span>
	</a>
</header>

<nav id="navContainer" class="navClosed" role="navigation" 
	itemprop="hasPart" itemscope itemtype="http://schema.org/SiteNavigationElement">
	<meta itemprop="name" content="ABCOM Site Navigation" />
	<meta itemprop="description" content="This is the main site navigation for Andre Bulatov's site, andrebulatov.com" />
	<ul class="navMenu">
		<li class="home">
			<a href="/" itemprop="url">
				<span class="fa fa-fw fa-home"></span>
				<span itemprop="name">Home</span>
			</a>
		</li>
		<li class="rss">
			<a href="/blog" itemprop="url">
				<span class="fa fa-fw fa-pencil-square-o"></span>
				<span itemprop="name">Blog</span>
			</a>
		</li>
		<li class="profile">
			<a href="/about" itemprop="url">
				<span class="fa fa-fw fa-user"></span>
				<span itemprop="name">About</span>
			</a>
		</li>
		<li class="like">
			<a href="/awesome-code" itemprop="url">
				<span class="fa fa-fw fa-exclamation"></span>
				<span itemprop="name">Awsm</span>
			</a>
		</li>
		<li class="email">
			<a href="/contact" itemprop="url">
				<span class="fa fa-fw fa-envelope"></span>
				<span itemprop="name">Contact</span>
			</a>
		</li>
		<li class="arrow back">
			<?php previous_post_link('%link', '<span class="fa fa-fw fa-arrow-left"></span>Prev', TRUE); ?>
		</li>
		<li class="arrow">
			<?php next_post_link('%link', '<span class="fa fa-fw fa-arrow-right"></span>Next', TRUE); ?>
		</li>		
	</ul>
	<span id="visitors-ip">
		<a href="https://andrebulatov.com/visitor-info/" title="Visitor Info">
			IP: <?php echo $ip_address ?>
		</a>
	</span>
</nav>




<div  <?php if (!(is_page_template('blank.php'))) {echo 'id="primary"';} ?> role="main" 
	itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/WebPageElement">
	<meta itemprop="name" content="ABCOM Andre Bulatov's Profile" />
	<meta itemprop="about" content="Andre Bulatov" />
	<meta itemprop="description" content="This front page is dedicated to Andre Bulatov's skills, education, portfolio and accomplishments, as well as a short autobiographical description by Andre himself!" />
	<div id="navToggle"><span></span></div>


