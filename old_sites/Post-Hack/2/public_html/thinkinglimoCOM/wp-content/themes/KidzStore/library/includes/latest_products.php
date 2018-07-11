<?php get_header(); 
global $Product,$Cart;
?>
  <div id="content" class="grid_11 clearfix">
       <h3><?php _e(LATEST_PRD_TITLE)?> </h3>
      <?php 
$limit = 20;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$blogCategoryIdStr = str_replace(',',',-',get_inc_categories("cat_exclude_"));
query_posts('showposts=' . $limit . '&paged=' . $paged .'&cat='.$blogCategoryIdStr);
?>
      <?php
 if(have_posts())
 {
 ?>
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
           
            </div>
            <div class="content">
                <h3><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
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
                <div class="button1"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">View Details</a></div>
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
      <?php
 }
 ?>
      <a href="<?php echo get_option('siteurl')."/?page=store";?>" class="highlight_button fr" ><?php _e(VIEW_STORE_TEXT);?> &raquo;</a>
   </div>
<?php 
global $Cart,$General;
$itemsInCartCount = $Cart->cartCount();
$cartAmount = $Cart->getCartAmt();
?>
  <div id="sidebar" class="grid_4">
    <?php if ( function_exists('dynamic_sidebar') && (is_sidebar_active(2)) ) { // Show on the front page ?>
    <?php get_sidebar(); ?>
    <?php } ?>
  </div>
  <!-- sidebar #end -->
