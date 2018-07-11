 <div id="content" class="grid_11">
         <div id="post-<?php the_ID(); ?>" class="posts clearfix">
          <div class="post_top">
            <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
              <?php the_title(); ?>
              </a></h2>
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
        <div class="fix"></div>
        <div id="comments">
          <?php comments_template(); ?>
        </div>
       <!-- content Spacer #end -->
    </div>
    <!-- content-in #end -->
  <?php get_sidebar(); ?>  <!-- sidebar #end -->