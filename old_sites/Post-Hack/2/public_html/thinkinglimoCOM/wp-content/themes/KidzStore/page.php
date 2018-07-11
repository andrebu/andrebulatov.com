<?php
/*
 * @package WordPress
 * @subpackage Kidzstore
*/
?>
<?php get_header(); ?>
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			<h2><?php the_title(); ?></h2>
             <div class="breadcrumb clearfix"><?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?></div>
		</div>
	</div>
</div>

<div class="wrapper" >
  <div class="container_16 clearfix">
    <div id="content" class="grid_11">
      <div class="content_spacer">
        <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post() ?>
        <?php $pagedesc = get_post_meta($post->ID, 'pagedesc', $single = true); ?>
        <div id="post-<?php the_ID(); ?>" >
          <div class="entry">
            <?php the_content(); ?>
          </div>
        </div>
        <!--/post-->
        <?php endwhile; else : ?>
        <div class="posts">
          <div class="entry-head">
            <h2><?php echo get_option('ptthemes_404error_name'); ?></h2>
          </div>
          <div class="entry-content">
            <p><?php echo get_option('ptthemes_404solution_name'); ?></p>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <!-- content-in #end -->
   <?php get_sidebar(); ?>
  </div>
  <!-- container 16-->
</div>
<!-- wrapper #end -->
<?php get_footer(); ?>
