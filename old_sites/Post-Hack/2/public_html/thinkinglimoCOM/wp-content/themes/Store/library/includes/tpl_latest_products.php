<?php
/*
Template Name: Store Page
*/
?>
<?php get_header(); 
global $Product,$Cart;
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
        
<?php if ($_GET['page']=='store') {  ?>
<h1 class="head"><?php _e('Store'); ?></h1>
<div class="breadcrumb clearfix">
	<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',  ' &raquo; ' . $_GET['page']); } ?>
</div>
<?php } ?>
<h3> <?php _e('Latest Products'); ?> </h3>
<?php
$totalpost_count = 0;
$limit = 1000;
$blogCategoryIdStr = str_replace(',',',-',get_inc_categories("cat_exclude_"));
query_posts('showposts=' . $limit . '&cat='.$blogCategoryIdStr);
if(have_posts())
{
	while(have_posts())
	{
		 the_post();
		$totalpost_count++;
	}
}
//echo $totalpost_count;
if($_GET['page'])
{
$limit = 12; // number of posts per page for store page
}else
{
$limit = 8; // number of post per page for home page
}
$posts_per_page_homepage = $limit;
//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
//$paged = $_REQUEST['paged'];
global $paged;
if($paged == '0')
{
	$paged =1;
}
$blogCategoryIdStr = str_replace(',',',-',get_inc_categories("cat_exclude_"));
query_posts('showposts=' . $limit . '&paged=' . $paged .'&cat='.$blogCategoryIdStr);
?>                
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
      <div class="clearfix"></div>
      <?php
 }
 ?>
      
	  <?php
        if($_GET['page'])
		{
			
			/*echo '<div class="next">';
			   str_replace('&','&amp;',next_posts_link(' Next &raquo;', 0));
			echo '</div>';
			echo '<div class="previous">';
			  str_replace('&','&amp;',previous_posts_link('&laquo; Previous ', 0));
		echo '</div>';*/
		?>
        <div class="pagination">
        <div class="Navi">
          <?php if (function_exists('wp_pagenavi')) { ?>
          <?php wp_pagenavi(); ?>
          <?php } ?>
        </div>
      </div>
        <?php
		
		}else
		{
		?>
      <a href="<?php echo get_option('siteurl')."/?page=store";?>" class="highlight_button fr" ><?php _e('View Store'); ?> &raquo;</a>
      <?php }?>
      
  			  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->

 <?php get_footer(); ?>