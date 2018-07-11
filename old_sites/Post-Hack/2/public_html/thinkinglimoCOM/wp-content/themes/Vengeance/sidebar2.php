<div id="sidebar_r">
   <ul>
    <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>
    <li>
    	<h3 class="sidebartitle">
        <?php _e('Recent Posts'); ?>
      </h3>
      <ul>
        <?php $recent = new WP_Query("showposts=5"); while($recent->have_posts()) : $recent->the_post();?>
        <li><a href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
          </a> </li>
        <?php endwhile; ?>
        </ul>
      </li>
    <li>
    	<h3 class="sidebartitle">
        <?php _e('Sponsors Links'); ?>
      </h3>
      <ul class="list-blogroll">
        <?php get_links('-1', '<li>', '</li>', '<br />', FALSE, 'id', FALSE, FALSE, -1, FALSE); ?>
      </ul> 
      </li>
     <?php endif; ?>
  </ul>
  
  <h3 class="sidebartitle">Flickr</h3>
  <div class="flickr">
	<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=6&display=latest&size=s&source=user&user=<?php echo $pt_flickr_id; ?>"></script>
	</div>
  
 </div><!--Sidebar right-->