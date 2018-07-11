<?php
/*
Template Name: Archives Page
*/
?>
<?php
/*
 * @package WordPress
 * @subpackage Kidzstore
*/
?>
<?php get_header(); ?>

<div class="wrapper" >
  <div class="clearfix container_border">
    <h1 class="head">
      <?php the_title(); ?>
    </h1>
    <div class="breadcrumb clearfix">
      <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
    </div>
  </div>
  <div class="container_12 clearfix ">
    <div id="content" class="grid_7 clearfix">
      <div class="content_spacer">
        <h1 class="head">
          <?php the_title(); ?>
        </h1>
        <div class="breadcrumb clearfix">
          <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
        </div>
        <div id="post-<?php the_ID(); ?>" >
          <div class="arclist box">
            <ul>
              <?php query_posts('showposts=60'); ?>
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              <li>
                <div class="archives-time">
                  <?php the_time('M j Y') ?>
                </div>
                <a href="<?php the_permalink() ?>">
                <?php the_title(); ?>
                </a> - <?php echo $post->comment_count ?> </li>
              <?php endwhile; endif; ?>
            </ul>
          </div>
          <!--/arclist -->
        </div>
        <!--/post -->
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
