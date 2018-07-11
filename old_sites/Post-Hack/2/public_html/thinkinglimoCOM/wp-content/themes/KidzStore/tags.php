<?php
/*
Template Name: Product Listing Page
*/
/*
 * @package WordPress
 * @subpackage Kidzstore
*/
?>
<?php get_header(); ?>
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			    <?php if (is_category()) { ?>
			<h2  ><?php echo get_option('ptthemes_browsing_category'); ?> <?php echo single_cat_title(); ?> </h2>  

			<?php } elseif (is_day()) { ?>
			<h2 ><?php echo get_option('ptthemes_browsing_day'); ?> <?php the_time('F jS, Y'); ?> </h2>

			<?php } elseif (is_month()) { ?>
			<h2 ><?php echo get_option('ptthemes_browsing_month'); ?> <?php the_time('F, Y'); ?> </h2>

			<?php } elseif (is_year()) { ?>
			<h2 ><?php echo get_option('ptthemes_browsing_year'); ?> <?php the_time('Y'); ?> </h2>
			
			<?php } elseif (is_author()) { ?>
			<h2 ><?php echo get_option('ptthemes_browsing_author'); ?> <?php echo $curauth->nickname; ?> </h2>
							
			<?php } elseif (is_tag()) { ?>
			<h2 ><?php echo get_option('ptthemes_browsing_tag'); ?> <?php echo single_tag_title('', true); ?> </h2>
			<?php }  elseif ($_GET['page']=='Blog') { ?>
            <h2 ><?php _e('Blog');?></h2>
            <?php } ?>
            <div class="breadcrumb"><?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',  ' &raquo; ' . __(BLOG_TEXT)); } ?></div>
		</div>
	</div>
</div>
 		

  <div class="container_16 clearfix ">
    <div id="content" class="grid_11 clearfix">
      <div class="content_spacer">
       <?php
			if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
			else :
			$curauth = get_userdata(intval($author));
			endif;
		?>
        <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post() ?>
        <div id="post-<?php the_ID(); ?>" class="posts clearfix">
          <div class="post_top">
            <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
              <?php the_title(); ?>
              </a></h3>
            <p class="postmetadata">Posted on
              <?php the_time('F j, Y') ?>
              // <span class="commentcount"> <a href="<?php the_permalink(); ?>#commentarea">
              <?php comments_number('0 Comments', '1 Comments', '% Comments'); ?>
              </a></span></p>
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
        <div class="pagination">
          <?php if (function_exists('wp_pagenavi')) { ?>
          <?php wp_pagenavi(); ?>
          <?php } ?>
        </div>
        <?php endif; ?>
      </div>
      <!-- content Spacer #end -->
    </div>
    <!-- content-in #end -->
    <?php get_sidebar(); ?>
    <!-- sidebar #end -->
  </div>
  <!-- container 16-->

<?php get_footer(); ?>
