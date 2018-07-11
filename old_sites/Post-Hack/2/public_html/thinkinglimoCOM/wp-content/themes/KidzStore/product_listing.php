<?php
/*
Template Name: Product Listing Page
*/
?>
<?php
/*
 * @package WordPress
 * @subpackage Kidzstore
*/
?>
<?php get_header(); 
global $Product,$Cart;
?>
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			<h2><?php echo single_cat_title(); ?> </h2>
             <div class="breadcrumb clearfix"><?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?></div>
		</div>
	</div>
</div>

<div class="wrapper" >
  
  <div class="container_16 clearfix">
    <div id="content" class="grid_11 clearfix">
      <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery-latest.js"></script>
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
      <?php
 if(have_posts())
 {
 ?>
      
        <div id="printandemail">
			<div id="print"><a href="#">Print</a></div>
			<div id="switchthumb"><a href="#" class="switch_thumb swap"><?php _e('Switch Thumb');?></a></div>
		</div>
      
      
      <ul style="display: block;" class="display thumb_view">
        
          <?php
		$counter = 0;
        while(have_posts())
        {
            $counter++;
			the_post();
            $data = get_post_meta( $post->ID, 'key', true );
            $product_price = $Product->get_product_price($post->ID);
            ?>
        <li>
        <div class="content_block">
            <div class="product_image"><a href="<?php the_permalink() ?>"><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $data[ 'productimage' ]; ?>&amp;w=150&amp;h=160&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""  border="0" /></a>
          <?php
			if($Product->get_product_price_sale($post->ID)>0)
			{
			?>
            <img src="<?php bloginfo('template_directory'); ?>/images/sale.png" alt="" class="sale_img" />
            <?php
			}else
			{
			?>
            <?php
			}
			?> 
            </div>
            <div class="content">
                <h3><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                <p class="contentp"><?php echo bm_better_excerpt(500, ' ... '); ?></p>
                <span class="sale_price">
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
                </span>
                <div class="button1"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php _e('View Details');?></a></div>
            </div>
        </div>
                
                
         
          <!-- content block #end -->
        </li>
        <?php
		if($counter%4==0)
		{
		echo '<li class="product_seperator"></li>';
		}
        }
        ?>
      </ul>
      <div class="clearfix"></div>
      <div class="pagination">
        <div class="Navi">
          <?php if (function_exists('wp_pagenavi')) { ?>
          <?php wp_pagenavi(); ?>
          <?php } ?>
        </div>
      </div>
      <?php
 }
 ?>
      <!-- pagination #end -->
    </div>
    <!-- content-in #end -->
    <?php get_sidebar(); ?>
  </div>
  <!-- container 16-->
</div>
<!-- wrapper #end -->
<?php get_footer(); ?>
