<?php
/*
Template Name: Product Listing Page
*/
?>
<?php get_header(); 
global $Product,$Cart,$General;
?> 
<script type="text/javascript">
$(document).ready(function(){
 
	$("a.switch_thumb").toggle(function(){
	  $(this).addClass("swap"); 
	  $("ul.display").fadeOut("fast", function() {
		$(this).fadeIn("fast").removeClass("thumb_view");
		 });
	  }, function () {
	  $(this).removeClass("swap");
	  $("ul.display").fadeOut("fast", function() {
		$(this).fadeIn("fast").addClass("thumb_view"); 
		});
	}); 

});
</script>
<div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix container_16">
        <div id="content" class="grid_11 clearfix">        
       
    
<h1 class="head"><?php echo single_cat_title(); ?></h1>
                <div class="breadcrumb clearfix">
                	<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
                </div>
 
			 <?php
            if(have_posts())
            {
            ?>
            <a href="#" class="switch_thumb swap"><?php _e('Switch Thumb');?></a>
            <ul class="display thumb_view">
				<?php
				$postcounter = 0;
                while(have_posts())
                {
                    the_post();
					$postcounter++;
					$product_images = $General->get_post_images($post->ID);
                    $data = get_post_meta( $post->ID, 'key', true );
                    $product_price = $Product->get_product_price($post->ID);
                    ?>
                    <li>
                                          
						  <?php
                          if($product_images[0])
                          {
                          ?>
                          <a href="<?php the_permalink() ?>" class="product_thumb">
                          <img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $product_images[0]; ?>&amp;w=145&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""  /></a>
                          <?php
                          }else
                          {
                          ?>
                          <a href="<?php the_permalink() ?>" class="no_image">No Image Available</a>
                          <?php
                          }
                          ?>
                          
                     <div class="content">
                                
                       <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?> </a></h3>
                                 <p class="contentp"><?php echo bm_better_excerpt(200, ' ... '); ?> </p>
                                <p class="sale_price" > <strong><span class="price"> 
								 <?php
								if($Product->get_product_price_sale($post->ID)>0)
								{
									 echo '<s>'.$General->get_amount_format($Product->get_product_price_only($post->ID)).'</s>&nbsp;';
									 echo '<b>'.$General->get_amount_format($Product->get_product_price_sale($post->ID)).'</b>';
									 
								}else
								{
									if($General->is_storetype_catalog())
									 {
										if($Product->get_product_price_only($post->ID)>0)
										{
											echo $General->get_amount_format($Product->get_product_price_only($post->ID));	
										}
									 }else
									 {
										echo $General->get_amount_format($Product->get_product_price_only($post->ID));
									 }
								 }
								 ?>
								
								</span></strong></p>
                                
                        <div class="b_viewdetails"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"  ><?php _e('View Details');?> &raquo;</a> </div>
                             
                     </div>  <!-- productinfo #end -->
           		  
            		</li>
            <?php
				if($postcounter%3==0)
				{
				echo '<li class="product_sepretor"></li>';
				}
				}
			?>
            </ul>
            <div class="pagination">

                <div class="Navi">
                <?php if (function_exists('wp_pagenavi')) 
                {
                    wp_pagenavi(); 
                } ?>
                </div>
            
            </div> <!-- pagination #end -->
            <?php
            }
            ?>    	
  			  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->

 <?php get_footer(); ?>
