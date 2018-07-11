http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop
http://codex.wordpress.org/The_Loop









<?php 
	/*-----------------------------------------------------------------------------------*/
	/* Start Body of Home/Landing/Front Page
	/*-----------------------------------------------------------------------------------*/
	/**
	 * The main template file
	 *
	 * This is the front page/home
	 *
	 * @package WordPress
	 * @subpackage Profile
	 * @since Profile 1.0
	 */
?>



<?php get_header(); ?>



<!--
<nav class="navbar navbar-default scroll-down-site" id="navbar-site" role="navigation">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target=".navbar-site">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="navbar-center navbar-brand" href="#"><a class="navbar-brand" href="#"><img id="Andre" src="http://andrebulatov.com/wp-content/uploads/Andre_normal.png" alt="Andre Bulatov" width="25" height="25" title="Andre Bulatov"></a></div>

			<div class="collapse navbar-collapse navbar-site">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#home">Home</a></li>
					<li><a href="#blog">Blog</a></li>
					<li><a href="#resume">Resume</a></li>
					<li><a href="#work">Work</a></li>
					<li><a href="#aboutme">About Me</a></li>
					<li><a href="#contactme">Contact Me</a></li>
				</ul>
			</div>

		</nav>
-->



<!--
<div class="background-theme">
	<div id="articles" class="container">
		<h2>Articles</h2>
	    <p class="lead">
		    “A quote about writing.” 
	        <br>
	        - Some Person
	    </p> 
	    <hr> 
	    <h3>Recent Posts</h3> 
		<?php 
		$thumbnails = get_posts( 'numberposts=5' );
		foreach ( $thumbnails as $thumbnail ) {
			if ( has_post_thumbnail( $thumbnail->ID ) ) {
				echo '<a href="' . get_permalink( $thumbnail->ID ) . '" title="' . esc_attr( $thumbnail->post_title ) . '">';
				echo get_the_post_thumbnail( $thumbnail->ID, 'thumbnail' );
				echo '</a>';
			}
		}
		?>

		<div class="text-center top-marginl">
			<p>Check out my blog for more posts.</p>
			<a href="http://andrebulatov.com/blog" class="btn btn-primary" target="_blank">See More Posts</a>
		</div>
	</div>
</div>
-->

<!--
		<ul>
		<?php
			$args = array( 'numberposts' => '3' );
			$recent_posts = wp_get_recent_posts( $args );
			foreach( $recent_posts as $recent ){
				echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
			}
		?>
		</ul>
-->
<!--
		<?php $pages = get_pages( array( 'child_of' => 1 ) ); ?> 
		<ul>
			<?php foreach ( $pages as $page ) : ?>
				<li>
					<?php echo get_the_post_thumbnail( $page->ID, 'thumbnail' ); ?>
					<h1><?php echo apply_filters( 'the_title', $page->post_title, $page->ID ); ?></h1>
					<?php echo apply_filters( 'the_content', $page->post_content ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
-->










	
<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Page loop
	/*-----------------------------------------------------------------------------------*/
	
	if( is_page()) {
?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article class="post">
					
<!-- 						<h1 class="title"><?php the_title() ?></h1> -->
						
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

<!-- </div> -->  <!-- / container--> 



<?php get_footer(); ?>


