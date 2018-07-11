<div id="sidebar" class="clearfix">

    <div class="Sponsors">
       <?php include (TEMPLATEPATH . "/ads2.php"); ?>
      </div>


  <div class="sidebar_top"><a href="<?php if($pt_feedburner_address) { echo $pt_feedburner_address; } else { bloginfo('rss2_url'); }?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('RSS feed', ''); ?>" rel="alternate" type="application/rss+xml"> <img src="<?php bloginfo('template_url'); ?>/images/rss2.png" alt="" class="rssfeed"  /></a>
   
    <h4>SEARCH</h4>
    <div class="subscribetextbg">
    
    <?php include(TEMPLATEPATH."/searchform.php");?>
        <p ><a href="<?php if($pt_feedburner_address) { echo $pt_feedburner_address; } else { bloginfo('rss2_url'); }?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('RSS feed', ''); ?>" rel="alternate" type="application/rss+xml" class="i_rss" >  Rss Feed</a> <a href="feed:<?php bloginfo('comments_rss2_url'); ?>" class="i_rss"> RSS Comments</a></p>
    </div>
  </div>
  
     <div class="stop"> 
    
  <?php include (TEMPLATEPATH . "/sidebar1.php"); ?>
  <?php include (TEMPLATEPATH . "/sidebar2.php"); ?>
  </div>
  <div class="sbottom">
  </div>
  
 </div>



<!--sidebar.php end-->
