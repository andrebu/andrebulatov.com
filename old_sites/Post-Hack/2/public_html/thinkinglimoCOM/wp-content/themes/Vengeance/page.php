<?php get_header(); ?>
<!--page.php-->

<div id="content">
  <div class="content_center">
    <div class="content_top">

       <!--loop-->
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <!--post title-->
      
     
 
  <div class="posts">
          <div class="posts-in">
          
             <h1   id="post-<?php the_ID(); ?>">
        <?php the_title(); ?>
      </h1>
      
    
      <!--post with more link -->
      <div class="clear">
        <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
      </div>
      <!--if you paginate pages-->
      <?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number');?>
      <!--end of post and end of loop-->
      <?php endwhile; endif; ?>
      
      </div>
      
      
      	</div>
		</div>     
         
        </div>

     <div class="content_bottom clear"></div>    
 </div>
<!--page.php end-->
<!--include sidebar-->
<?php get_sidebar();?>
<!--include footer-->
<?php get_footer(); ?>
