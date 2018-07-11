<?php
/*
Template Name: Product Listing Page
*/
?>
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
			<h2>
			    <?php if (is_category()) 
				{ 
					echo single_cat_title();
				}
				elseif (is_day()) 
				{
                	the_time('F jS, Y');
                }
				elseif (is_month())
				{
					the_time('F, Y');
				}
				elseif (is_year()) 
				{
				   the_time('Y'); 
				}
				elseif (is_author()) 
				{
                echo $curauth->nickname;
                }
				elseif (is_tag()) 
				{
                	echo single_tag_title('', true);
				}
				elseif($_GET['page']=='Blog')
				{
					_e(BLOG_TEXT);
				} ?>
            </h2>
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
        <?php
		if(!is_category())
		{
			$totalpost_count = 0;
			$limit = 1000;
			$blogCategoryIdStr = get_inc_categories("cat_exclude_");
			query_posts('showposts=' . $limit . '&cat='.$blogCategoryIdStr);
			if(have_posts())
			{
				while(have_posts())
				{
					 the_post();
					$totalpost_count++;
				}
			}
			global $posts_per_page,$paged;
			$limit = $posts_per_page;
		
			$posts_per_page_homepage = $limit;
			$blogCategoryIdStr = get_inc_categories("cat_exclude_");
			query_posts('showposts=' . $limit . '&paged=' . $paged . '&cat='.$blogCategoryIdStr);
		}
		?>
        <?php if (is_paged()) $is_paged = true; ?>
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
