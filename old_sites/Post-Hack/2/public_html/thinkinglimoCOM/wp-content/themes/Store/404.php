<?php get_header(); ?>

<div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix">
    
        <div id="content">    
 
            	<h1 class="head">404 Error Page</h1>
            
             
                     
                        <div class="pagespot">
                
                            <div class="post archive-spot">
                                                                                    
                                <h2><?php echo get_option('ptthemes_404error_name'); ?></h2>
                                
                                <div class="cat-spot"><p><?php echo get_option('ptthemes_404solution_name'); ?></p></div>
                
                                <div class="fix"></div>
                                        
                            </div><!--/post-->  
                
                        </div><!--/pagespot -->
		
  			  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->

<?php get_footer(); ?>
