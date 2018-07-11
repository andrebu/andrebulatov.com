<?php get_header(); ?>

		<div id="container" class="container row">
			<div role="main" class="<?php echo $cs_layout;?>" >
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>			
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="heading"><?php the_title(); ?></h1>
                <div class="in-sec">
                            <div class="desc">
                                <div class='txt'>
                                <?php the_content();?>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                </div>
            <?php endwhile; // end of the loop. ?>
			</div>
		<?php if($cs_layout != "sixteen columns left"){?>
        <!--Sidebar Start-->
            <div class="one-third column left">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) : ?>
                <?php endif; ?>   
            </div>            
        <!--Sidebar Ends-->  
        <?php }?>

            <div class="clear"></div><!-- #content -->

		</div><!-- #container -->
              

        <div class="clear"></div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
