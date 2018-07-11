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
			<h2><?php _e('Product');?></h2>
             <div class="breadcrumb clearfix"><?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?></div>
		</div>
	</div>
</div>

<div class="wrapper" >
  <div class="clearfix container_border">
    <h1 class="head">
      <?php the_title(); ?>
    </h1>
  </div>
  <div class="container_12 clearfix ">
    <div id="content" class="grid_7 clearfix">
      <div class="content_spacer">
        <?php if (is_paged()) $is_paged = true; ?>
        <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post() ?>
        <div id="post-<?php the_ID(); ?>" class="posts">
          <div class="post_top">    <h3 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
            <?php the_title(); ?>
            </a></h3>

            <?php if ( get_option('ptthemes_relative_date') ) { ?>
            <?php relativeDate(get_the_time('YmdHis')) ?>
            <?php } else { ?>
            <?php the_time('F jS', '', ''); ?>
            ,
            <?php the_time('Y'); ?>
            //
            <?php the_time('g:i a'); ?>
            <?php } ?>
            <strong>@
            <?php the_author_posts_link(); ?>
            </strong>
            <?php if ( get_option( 'ptthemes_commentcount' )) { ?>
            //
           No Comments
            <?php } ?>
          </div>
          <?php if (( get_post_meta($post->ID,'image', true) ) && (get_option( 'ptthemes_timthumb_all' )) ) { ?>
          <a title="Link to <?php the_title(); ?>" href="<?php the_permalink() ?>"><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo get_post_meta($post->ID, "image", $single = true); ?>&amp;h=95&amp;w=95&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt="<?php the_title(); ?>" class="fll" style="margin-right:10px; margin-bottom:10px" /></a>
          <?php } ?>
          <?php if ( get_option( 'ptthemes_postcontent_full' )) { ?>
          <?php the_content(); ?>
          <?php } else { ?>
          <?php the_excerpt(); ?>
          <?php } ?>
          <div class="fix">
            <!---->
          </div>
          <p class="post_bottom">Category :
            <?php the_category(" &amp;"); ?>
          </p>
        </div>
        <!--/post-->
        <?php endwhile; ?>
        <?php else: ?>
        <div class="posts">
          <h2><?php echo get_option('ptthemes_search_nothing_found'); ?></h2>
        </div>
        <?php endif; ?>
        <div class="pagination">
          <?php if (function_exists('wp_pagenavi')) { ?>
          <?php wp_pagenavi(); ?>
          <?php } ?>
        </div>
      </div>
      <!-- content Spacer #end -->
    </div>
    <!-- content-in #end -->
    <?php get_sidebar(); ?>
  </div>
  <!-- container 16-->
</div>
<!-- wrapper #end -->
<?php get_footer(); ?>
