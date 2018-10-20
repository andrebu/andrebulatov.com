<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Header
	/*-----------------------------------------------------------------------------------*/
	/**
	 *
	 * The template for displaying the footer
	 *
	 * Displays all of the <head> section and everything up till <div id="main">
	 *
	 * @package WordPress
	 * @subpackage Profile
	 * @since Profile 1.0
	 */
// header('Content-Type: text/html; charset=UTF-8');
?>



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
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<!--    Andre title edit to avoid duplicate title in browser header -->
    <title><?php wp_title(''); ?></title>


	<!-- 	Andre Child Theme code BEGIN -->

	<link href="https://plus.google.com/109308454256342109455" rel="publisher">

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
	
	
	<!--    Andre's Fonts -->
<!-- 	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/fonts/Andresfonts.css" media="all"> -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,600,700" rel="stylesheet" type="text/css">	
	<link rel="stylesheet" id="twentyfourteen-lato-css" href="//fonts.googleapis.com/css?family=Lato%3A300%2C400%2C700%2C900%2C300italic%2C400italic%2C700italic&amp;subset=latin%2Clatin-ext" type="text/css" media="all">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!--    END Andre's Fonts -->


	<!--    Andre's Metas -->
	<!-- Google Knowledge Graph -->
	<script type="application/ld+json">
	{ "@context" : "http://schema.org",
	  "@type" : "Person",
	  "name" : "Andre Bulatov",
	  "url" : "http://andrebulatov.com",
	  "sameAs" : [ "//twitter.com/AndreBulatov",
	      "//www.facebook.com/iamandrebulatov",
	      "//instagram.com/iamandrebulatov",
	      "//www.linkedin.com/in/andrebulatov",
	      "//plus.google.com/+AndreBulatov"] 
	}
	</script>
    <!--=== META TAGS ===-->
    <meta property="fb:admins" content="100004378810001" />
    <meta name="twitter:site" content="@andrebulatov" />
    <meta name="twitter:domain" content="andrebulatov.com" />
    <meta name="twitter:creator" content="@andrebulatov" />
    <meta name="twitter:app:id:googleplay" content="andrebulatov.com" />
    <meta property="og:title" content="Powerful web design with results." />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="An awesome web designer, making beautiful web sites that bring results." />
    <meta property="og:image" content="http://andrebulatov.com/wp-content/uploads/contact.jpg" />
    <meta property="og:image:height" content="100" />
    <meta property="og:image:width" content="100" />
    <meta name="twitter:card" content="summary_small_image" />
    <meta name="twitter:title" content="Powerful web design with results." />
    <meta name="twitter:description" content="An awesome web designer, making beautiful web sites that bring results." />
    <meta name="twitter:image:src" content="http://andrebulatov.com/wp-content/uploads/contact.jpg" />
    <meta name="twitter:image:height" content="100" />
    <meta name="twitter:image:width" content="100" />
	<!--    END Andre's Metas -->

	<!-- 	Android theme color top navbar  -->
	<meta name="theme-color" content="#41b7d8">	
	
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
	
	<!--    HotJar Analytics -->
	<script>
	    (function(f,b,g){
	        var xo=g.prototype.open,xs=g.prototype.send,c;
	        f.hj=f.hj||function(){(f.hj.q=f.hj.q||[]).push(arguments)};
	        f._hjSettings={hjid:9676, hjsv:2};
	        function ls(){f.hj.documentHtml=b.documentElement.outerHTML;c=b.createElement("script");c.async=1;c.src="//static.hotjar.com/c/hotjar-9676.js?sv=2";b.getElementsByTagName("head")[0].appendChild(c);}
	        if(b.readyState==="interactive"||b.readyState==="complete"||b.readyState==="loaded"){ls();}else{if(b.addEventListener){b.addEventListener("DOMContentLoaded",ls,false);}}
	        if(!f._hjPlayback && b.addEventListener){
	            g.prototype.open=function(l,j,m,h,k){this._u=j;xo.call(this,l,j,m,h,k)};
	            g.prototype.send=function(e){var j=this;function h(){if(j.readyState===4){f.hj("_xhr",j._u,j.status,j.response)}}this.addEventListener("readystatechange",h,false);xs.call(this,e)};
	        }
	    })(window,document,window.XMLHttpRequest);
	</script>
	<!--    END HotJar Analytics -->
	
    <!--=== LINK TAGS ===-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <!--=== WP_HEAD() ===-->
	<?php wp_head(); ?>

</head>




<body  data-spy="scroll" data-target="#navbar-page" <?php body_class(); ?>>

<!-- <header id="masthead" class="site-header" role="banner"> -->

<!-- <div id="top" class="jumbotron" data-src="/wp-content/uploads/kitten_scratch.gif" data-position="center center"> -->
<!-- <div id="top" class="jumbotron" data-src="/wp-content/uploads/highway_animation.gif" data-position="center center"> -->
<div id="top" class="jumbotron" data-src="/wp-content/uploads/contact.jpg" data-position="center center">

	<div class="container">
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> <!-- &mdash; --> 
		</h1>
		<p class="lead"><span><?php echo get_the_title(); ?></span></p>
	</div>

	<div class="overlay"></div>

	<a href="#primary" class="scroll-down-page">	
		<span class="fa fa-chevron-down"></span>
	</a>
</div>

<div id="navToggle">
	<span></span>
</div>
<div id="navContainer" class="navClosed">
	<ul class="navMenu">
		<li class="home"><a href="/"><span class="fa fa-fw fa-home"></span>Home</a></li>
		<li class="rss"><a href="/blog"><span class="fa fa-fw fa-pencil-square-o"></span>Blog</a></li>
		<li class="profile"><a href="/about"><span class="fa fa-fw fa-user"></span>About</a></li>
		<li class="like"><a href="/awesome-code"><span class="fa fa-fw fa-exclamation"></span>Awsm</a></li>
		<li class="email"><a href="/contact"><span class="fa fa-fw fa-envelope"></span>Contact</a></li>
		<li class="arrow back"><?php previous_post_link('%link', '<span class="fa fa-fw fa-arrow-left"></span>Prev', TRUE); ?></li>
		<li class="arrow"><?php next_post_link('%link', '<span class="fa fa-fw fa-arrow-right"></span>Next', TRUE); ?></li>		
	</ul>
</div>

	<div id="primary">
		<div id="content" role="main">
