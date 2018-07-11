<?php
/**
 * The default template for displaying all pages in LimoStrap theme, by Andre Bulatov.
 */

get_header(); ?>


	<?php while ( have_posts() ) : the_post(); ?> 
	
	<div id="page-content"> 
		<?php the_content(); endwhile; ?> 
	</div> 


<?php get_footer(); ?>