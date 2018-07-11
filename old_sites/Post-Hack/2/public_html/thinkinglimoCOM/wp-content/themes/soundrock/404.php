<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
<div class="clear"></div>
<div class="inner">
	<!-- Container Start -->
    <div class="container row">
        <div class="sixteen columns left">
            <!-- Static Page Start -->
            <div class="in-sec nopad-bot">
                <div class="page-not-found">
                    <div class="fourofuor"><img src="<?php echo get_template_directory_uri(); ?>/images/404.png" alt="404" /></div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

			<!--<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( 'Not Found', 'PixFill' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'PixFill' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<!-- #post-0 -->
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>
</div>