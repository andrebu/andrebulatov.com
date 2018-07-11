<?php
global $General;
$post_array = $General->get_post_array($post->ID);
?>
 <div id="content">
    <div style="margin:10px 0px 20px 0px;border-bottom:1px solid #CCC;"></div>
    <h4><?php _e('Related Products');?></h4>
        
<ul class="display thumb_view">
<?php
if($post_array)
{
	$relatedprd_count = 0;
	foreach($post_array as $postval)
	{
		$product_id = $postval->ID;
		$product_post_title = $postval->post_title;
		$productlink = get_permalink($product_id);
		if($postval->post_status == 'publish')
		{
	?>
		<?php
	$image_array = $General->get_post_image($product_id);
	//$imagepath = WP_CONTENT_DIR.str_replace(get_option( 'siteurl' ).'/wp-content','',$image_array[0]);
	//if($image_array[0]!='' && file_exists($imagepath))
	if($image_array[0]!='')
	{
		$relatedprd_count++;
	?>
	   <li>
		   <?php
		   if($Product->get_product_price_sale($product_id)>0)
			{
			?>
			<img src="<?php bloginfo('template_directory'); ?>/images/sale.png" alt="" class="sale_img" />
			<?php
			}?>
			
			 
			<div class="content_block">
				<div class="product_image">
				<?php
				if($image_array[0]!='')
				{
				?>
				 <a href="<?php echo $productlink;?>" class="product_thumb" ><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $image_array[0]; ?>&amp;w=150&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" title="<?php echo $product_post_title;?>" alt="<?php echo $product_post_title;?>"/></a>
				 <?php }?>
			</div>
				<div class="content">
					<h3><a href="<?php echo $productlink;?>"><?php echo $product_post_title;?></a></h3>
				</div>
			</div>
		</li>
		<?php
	}
		if($relatedprd_count==4)
		{
			break;
		}
		}
		?>
		<?php
	}
}
?>
  </ul>
</div>
	
