<?php
header('Content-Type: text/html; charset=UTF-8');
/**
 * The Header for Andre Bulatov.
 *
 * based on bootstrap and LESS theme
 */
 
?>



<!doctype html>
<html <?php language_attributes(); ?>>
<!--
========================================================================

	Design and Property of Andre Bulatov

========================================================================
-->


<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<!--    Andre title edit to avoid duplicate title in browser header -->
    <title><?php wp_title(''); ?></title>
    <!--    Andre title edit to avoid duplicate title in browser header -->
    <!-- 
    <title>
	<?php bloginfo('name'); ?> | <?php if( is_home() ) : echo bloginfo( 'description' ); endif; ?><?php wp_title( '', true ); ?>
	</title> 
	-->


	<!-- 	Andre Child Theme code BEGIN -->

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
	<link rel="stylesheet" id="twentyfourteen-lato-css" href="//fonts.googleapis.com/css?family=Lato%3A300%2C400%2C700%2C900%2C300italic%2C400italic%2C700italic&amp;subset=latin%2Clatin-ext" type="text/css" media="all">
	<!--    END Andre's Fonts -->


	<!--    Andre's Metas -->
    <meta property="fb:admins" content="100004378810001" />
    <meta name="twitter:site" content="@andrebulatov" />
    <meta name="twitter:domain" content="andrebulatov.com" />
    <meta name="twitter:creator" content="@andrebulatov" />
    <meta name="twitter:app:id:googleplay" content="com.imgur.mobile" />
    <meta property="og:title" content="Powerful web design with results." />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="An awesome web designer, making beautiful web sites that bring results." />
    <meta property="og:image" content="http://andrebulatov.com/wp-content/themes/Less/images/Andre-Hoboken.png" />
    <meta property="og:image:height" content="100" />
    <meta property="og:image:width" content="100" />
    <meta name="twitter:card" content="summary_small_image" />
    <meta name="twitter:title" content="Powerful web design with results." />
    <meta name="twitter:description" content="An awesome web designer, making beautiful web sites that bring results." />
    <meta name="twitter:image:src" content="http://andrebulatov.com/wp-content/themes/Less/images/Andre-Hoboken.png" />
    <meta name="twitter:image:height" content="100" />
    <meta name="twitter:image:width" content="100" />
	<!--    END Andre's Metas -->
	
	
	<!-- 	Google CDN hosted jQuery	 -->
	<!-- 	jQuery Core -->
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>  -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<!-- 	jQuery UI -->
	<!--
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	-->
	<!-- 	jQuery Mobile -->
<!--
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jquerymobile/1.4.3/jquery.mobile.min.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquerymobile/1.4.3/jquery.mobile.min.js"></script>	
-->
	<!-- 	END Google CDN hosted jQuery	 -->

<!--
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
-->

	<!-- 	Bootstrap CDN -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<!-- Optional theme -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css"> -->
	<!-- 	END Bootstrap CDN -->

	<script type="text/javascript" src="http://andrebulatov.com/wp-content/themes/Less/js/script.js"></script>

	<!-- 	END Andre Child Theme -->
	
	<script type='text/javascript'>
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip({'placement': 'top'})
		})
	</script>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<?php wp_head(); ?>

</head>















<body  data-spy="scroll" data-target="#navbar-example" <?php body_class(); ?>>


<div id="top" class="jumbotron" data-src="http://andrebulatov.com/wp-content/uploads/WELS_2.jpg" data-position="center center">
	<div class="container">
		<h1>Andre Bulatov</h1>
		<p class="lead">Front-end Web Design</p>
	</div>

	<div class="overlay"></div>

	<a href="#profile" class="scroll-down">	
		<span class="glyphicon glyphicon-chevron-down"></span>
	</a>
</div>

<nav class="navbar navbar-default" id="navbar-example" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#profile">Profile</a></li>
					<li><a href="#experiences">Experiences</a></li>
					<li><a href="#abilities">Abilities</a></li>
					<li><a href="#projects">Projects</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>


<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start header
	/*-----------------------------------------------------------------------------------*/
?>

<header id="masthead" class="site-header" role="banner">

	<div class="container">
		
		<div class="gravatar">
			<img alt="Andre Bulatov" src="http://andrebulatov.com/wp-content/uploads/Andre_normal.png" class="avatar avatar-100 photo" height="100" width="100" onclick="alert('I love you too!')")>
<!--
			<?php 
				// grab admin email and their photo
				$admin_email = get_option('admin_email');
				echo get_avatar( $admin_email, 100 ); 
			?>
-->
		</div><!--/ author -->
		
		<div id="brand">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> &mdash; <span><?php echo get_bloginfo( 'description' ); ?></span></h1>
		</div><!-- /brand -->
	
		<nav role="navigation" class="site-navigation main-navigation">
<!-- 			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?> -->
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>

		</nav><!-- .site-navigation .main-navigation -->
		
		<div class="clear"></div>
	</div><!--/container -->
		
</header><!-- #masthead .site-header -->

<div class="container">

	<div id="primary">
		<div id="content" role="main">


<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Home loop
	/*-----------------------------------------------------------------------------------*/
	
	if( is_home() || is_archive() ) {
	
?>
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article class="post">
					
						<h1 class="title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php the_title() ?>
							</a>
						</h1>
						<div class="post-meta">
							<span class="entry-date">
<!-- 								<?php the_date(); ?> -->
								<?php the_time( get_option( 'date_format' ) ); ?> 
							</span>
							<?php if( comments_open() ) : ?>
								<span class="comments-link">
									<?php comments_popup_link( __( 'Comment', 'break' ), __( '1 Comment', 'break' ), __( '% Comments', 'break' ) ); ?>
								</span>
							<?php endif; ?>
						
						</div><!--/post-meta -->
						
						<div class="the-content">
							<?php the_excerpt( 'Continue...' ); ?> <!-- Andre edited the_content to the_excerpt -->
							
							<?php wp_link_pages(); ?>
						</div><!-- the-content -->
						
						<div class="meta clearfix">
							<div class="category"><?php echo get_the_category_list(); ?></div>
							<div class="tags"><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); ?></div>
						</div><!-- Meta -->
						
					</article>

				<?php endwhile; ?>
				
				<!-- pagintation -->
				<div id="pagination" class="clearfix">
					<div class="past-page"><?php previous_posts_link( 'Newer &raquo;' ); ?></div>
					<div class="next-page"><?php next_posts_link( ' &laquo; Older' ); ?></div>
				</div><!-- pagination -->


			<?php else : ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; ?>

		
	<?php } //end is_home(); ?>

<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Single loop
	/*-----------------------------------------------------------------------------------*/
	
	if( is_single() ) {
?>


			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article class="post">
					
						<h1 class="title"><?php the_title() ?></h1>
						<div class="post-meta">
							<span class="entry-date">
								<?php the_date(); ?>
							</span>
							<?php if( comments_open() ) : ?>
								<span class="comments-link">
									<?php comments_popup_link( __( 'Comment', 'less' ), __( '1 Comment', 'less' ), __( '% Comments', 'less' ) ); ?>
								</span>
							<?php endif; ?>
						
						</div><!--/post-meta -->
						
						<div class="the-content">
							<?php the_content( 'Continue...' ); ?>
							
							<?php wp_link_pages(); ?>
						</div><!-- the-content -->
						
						<div class="meta clearfix">
							<div class="category"><?php echo get_the_category_list(); ?></div>
							<div class="tags"><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); ?></div>
						</div><!-- Meta -->						
						
					</article>

				<?php endwhile; ?>
				
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>


			<?php else : ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; ?>


	<?php } //end is_single(); ?>
	
<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Page loop
	/*-----------------------------------------------------------------------------------*/
	
	if( is_page()) {
?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article class="post">
					
						<h1 class="title"><?php the_title() ?></h1>
						
						<div class="the-content">
							<?php the_content(); ?>
							
							<?php wp_link_pages(); ?>
						</div><!-- the-content -->
						
					</article>

				<?php endwhile; ?>

			<?php else : ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; ?>

	<?php } // end is_page(); ?>

		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->

</div><!-- / container-->










<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Footer
	/*-----------------------------------------------------------------------------------*/
?>

<footer class="site-footer" role="contentinfo">
	<div class="site-info container">

		<span class="copyleft"> 
			Copyleft 
			<span class="copyleft-c">
				 © 
			</span>
			2014 Andre Bulatov  
		<span class="genericon genericon-heart" data-toggle="tooltip" data-placement="top" title="Made With Love">
		</span> <!--  data-delay='{"show":"5000", "hide":"3000"}'  -->
			All rights reserved. 
		</span>
		
	</div><!-- .site-info -->
</footer><!-- #colophon .site-footer -->


<?php wp_footer(); ?>

</body>
</html>
