<?php
header('Content-Type: text/html; charset=UTF-8');
/**
 * The Header for Thinking Limo.
 *
 * based on bootstrap
 */
 
?>


<!doctype html>
<html <?php language_attributes(); ?>>
<!--
========================================================================

	Design and Property of Thinking Limo, Inc

========================================================================
-->
	<head>

		<meta charset="UTF-8">
		
<!-- 		SEO Stuff -->
		<title><?php wp_title(' | ', true, 'right'); ?></title>
<!-- 	    <meta name="title" content="" /> -->
<!-- 	     -->
<!-- 	    <meta name="keywords" content="" /> -->
		
	    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	
	    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css">
	    
<!-- 		Favicons for Thinking Limo 	 -->
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
<!-- 		END Favicons for Thinking Limo 	 -->
	    
	    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	    <meta name="google-site-verification" content="YJJgnRWDdc81tJ5MCX6-HWnsKlPJeZKGxlpd9KEcMNE" />
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-39595170-1', 'auto');
		  ga('require', 'displayfeatures');
		  ga('send', 'pageview');
		
		</script>	

	    <?php wp_head(); ?>
	
	</head>



	<body>
		<header id="header">
			<nav class="navbar navbar-montere animated navbar-fixed-top navbar-fissa navbar-inverse" role="navigation">
				<div class="navbar-header">
					<a class="navbar-brand animated" href="http://thinkinglimo.com" ></a>
				
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
	
				<div class="navbar-collapse collapse">
					<span class="top_phone">
						888.961.6638
					</span>
					<a href="http://thinkinglimo.com/limo-service-reservation/">
						<span class="top_reserve">
							RESERVE NOW
						</span>
					</a>
					<ul id="main-nav" class="nav navbar-nav">
						<li>
							<a href="http://thinkinglimo.com/limo-service-rates/">
								<span class="line">
									RATES
								</span>
							</a>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="http://thinkinglimo.com/fleet.php">
								<span class="line">
									FLEET
								</span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="http://thinkinglimo.com/limo-fleet/">
										<span class="line">
											limousines 
										</span>
									</a>
								</li>
								<li>
									<a href="http://thinkinglimo.com/car-sedan-fleet/">
										<span class="line">
											sedans
										</span>
									</a>
								</li>
								<li>
									<a href="http://thinkinglimo.com/suv-fleet/">
										<span class="line">
											suvs
										</span>
									</a>
								</li>
								<li>
									<a href="http://thinkinglimo.com/van-fleet/">
										<span class="line">
											vans
										</span>
									</a>
								</li>
								<li>
									<a href="http://thinkinglimo.com/bus-fleet/">
										<span class="line">
											buses
										</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="index.html#">
								<span class="line">
									SERVICES
								</span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="http://thinkinglimo.com/airport-limo-services/">
										<span class="line">
											AIRPORT
										</span>
									</a>
								</li>
								<li>
									<a href="http://thinkinglimo.com/corporate-limo-services/">
										<span class="line">
											CORPORATE
										</span>
									</a>
								</li>
								<li>
									<a href="http://thinkinglimo.com/wedding-limo-services/">
										<span class="line">
											WEDDINGS
										</span>
									</a>
								</li>
								<li>
									<a href="http://thinkinglimo.com/personal-limo-services/">
										<span class="line">
											PERSONAL
										</span>
									</a>
								</li>
							</ul>
						</li>
						<li class="divider"></li>
						<li>
							<a href="http://thinkinglimo.com/limo-service-questions/">
								<span class="line">
									FAQ
								</span>
							</a>
						</li>
						<li>
							<a href="http://thinkinglimo.com/about-limo-service/">
								<span class="line">
									ABOUT US
								</span>
							</a>
						</li>
						<li>
							<a href="http://thinkinglimo.com/contact-limo-service/">
								<span class="line">
									CONTACT US
								</span>
							</a>
						</li>
					</ul>
				</div>
			</nav><!-- #site-navigation -->
		</header>
		
	<!-- 	<div class = "container" > -->