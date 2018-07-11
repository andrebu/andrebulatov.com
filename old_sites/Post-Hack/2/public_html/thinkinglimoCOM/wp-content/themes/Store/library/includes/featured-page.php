<?php global $is_home; ?>
<script src="<?php bloginfo('template_directory'); ?>/library/js/loopedslider.js" type="text/javascript" charset="utf-8"></script>
		<div id="wrapper">
        	<div id="main_top"></div> <!--main top #end -->
        	<div id="main_center" class="clearfix">
            
             	<div id="content">
  					<div class="banner">
					<?php if ( function_exists('dynamic_sidebar') && (is_sidebar_active(3)) ) { // Show on the front page ?>
                                <?php dynamic_sidebar(3); ?>  
                         <?php } ?>
<!--For Slider -->                
            <script type="text/javascript" charset="utf-8">
			jQuery.noConflict();
			var $j = jQuery;
			$j(function(){
				$j('#loopedSlider').loopedSlider({
			autoStart: 3000,
			restart: 5000
					});
			});

		jQuery.noConflict();
		var $j = jQuery;
		</script>    
<!--For Slider -->
                   </div> <!-- banner #end -->
  			  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->