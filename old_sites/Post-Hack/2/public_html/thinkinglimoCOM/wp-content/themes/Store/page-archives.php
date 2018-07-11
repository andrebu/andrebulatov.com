<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header(); ?>
 
 
 <div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix">
    
        <div id="content">    
 
 
            	<h1 class="head"><?php the_title(); ?></h1>
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
    
  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->

 <?php get_footer(); ?>