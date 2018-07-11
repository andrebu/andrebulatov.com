<div id="content">
    <div id="printandemail">
        <div id="print"><a href="#" onclick="window.print();return false;"><?php _e('Print');?></a></div>
		<?php
        if($General->is_show_tellaFriend())
        {
        	include(TEMPLATEPATH . '/library/includes/tellafriend.php');
        }
		?>
        <?php
        if(get_option('ptthemes_feed_name'))
		{
		?>
        <span class="sharethis"><a class="a2a_dd" href="http://www.addtoany.com/subscribe?linkname=http%3A%2F%2F<?php echo stripslashes(get_option('ptthemes_feed_name'));  ?>&amp;linkurl=http%3A%2F%2F<?php echo stripslashes(get_option('ptthemes_feed_url'));  ?>"><?php _e('Share This');?></a>
            <script type="text/javascript">a2a_linkname="<?php echo stripslashes(get_option('ptthemes_feed_name'));  ?>";a2a_linkurl="<?php echo stripslashes(get_option('ptthemes_feed_url'));  ?>";</script>
            <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/feed.js"></script>
          </span>
        <?php }?>
        <?php
        if(get_option('ptthemes_feedburner_url'))
		{
		?>
          <span class="rss"><a href="<?php echo get_option('ptthemes_feedburner_url'); ?>"><?php _e('RSS');?></a> </span>
        <?php }?>
    </div>
    <?php
    $post_images_array = $General->get_post_image($post->ID);
	?>
    <div id="photos">
        <?php if($post_images_array[0]){?>
        
        <div class="productimages">
        <div id="productimage_big">
            <div class="photo productimage" > <a href="#productimage0">
            <img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_images_array[0]; ?>&amp;w=270&amp;h=259&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt="" border="0" />
            </a> </div>
        </div>		
        	<div style="display: none;" id="productimage0" > <img src="<?php echo $post_images_array[0]; ?>" alt="helmet"> </div>
        <?php }?>
        
          <div id="small_thumb">
          
         <?php for($i=1;$i<count($post_images_array);$i++){?>
      
            <div class="photo" > <a href="#productimage<?php echo $i;?>">
            <img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_images_array[$i]; ?>&amp;w=70&amp;h=70&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt="" border="0" />
            </a> </div>
       	
        	<div style="display: none;" id="productimage<?php echo $i;?>" > <img src="<?php echo $post_images_array[$i]; ?>" alt="helmet"> </div>
        <?php }?>
        
         </div>	
        
        </div>
        
    </div>
    <div id="product_info">
        <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
        
         
        
        <?php
        if(get_option('ptthemes_add_to_cart_button_position')=='Above Description' || get_option('ptthemes_add_to_cart_button_position') == '' || get_option('ptthemes_add_to_cart_button_position')=='Above and Below Description') // add to cart button ABOVE description
		{?>
		
        <div class="product_info">
            <?php
			if($Product->get_product_price_sale($post->ID)>0)
			{
			?>
        	 <div class="row_spacer clearfix"><span class="field_text"> <?php _e(REGULAR_PRICE_TEXT);?>:</span> <span class="price_normal"><s> <?php echo $General->get_amount_format($Product->get_product_price_only($post->ID)); ?> </s> </span></div>
        	 <div class="row_spacer clearfix"> <span class="field_text">  <?php _e(SALE_PRICE_TEXT);?> :</span>  <span class="price"> <?php echo $General->get_amount_format($Product->get_product_price_sale($post->ID)); ?></span> </div>
        <?php
			}else
			{
			?>
        	<div class="row_spacer clearfix"> <span class="field_text"> <?php _e(SINGLE_PRICE_TEXT);?>:</span> <span class="price"><?php echo $General->get_amount_format($Product->get_product_price_only($post->ID)); ?></span> </div>
        <?php
			}
			?>
           
            <div class="row_spacer clearfix">
             <?php if($product_size){?>
                 
                  <span class="field_text"> <?php _e('Size');?> : </span> <span class="fl"><?php echo $product_size; ?> </span>  
                  <span style="text-decoration: underline; float:left; margin-top:4px; " class="size_chart more" title="size_chart1">+ <?php _e(SIZE_CHART_TEXT);?></span>
                  <div style="display: none;" class="size_chart1 hide" > <span class="close"><?php _e(CLOSE_TEXT);?></span>
                    <?php if ( get_option('ptthemes_size_chart') != "") { ?>
                    <?php echo stripslashes(get_option('ptthemes_size_chart'));  ?>
                    <?php } ?>
                  </div>
                  <!-- size chart -->
                 
                <?php }?>
            </div>
           
           
            <div class="row_spacer clearfix">
            <?php if($product_color){?>
            <span class="field_text"> <?php _e('Colors');?> : </span>
			<?php echo $product_color; ?>
            <?php }?>
            </div>
            <div class="row_spacer">
            <?php if($General->is_show_weight() && $data[ 'weight']){?>
             <span class="field_text"> <?php _e('Weight');?>: </span> <span> <strong><?php echo $data[ 'weight']; ?></strong></span> 
            <?php }?>
            </div>
             
            </div> <!--product info -->
			 <?php  
		//affiliate link
		if($data['affiliate_link']){  ?>
	   <?php echo $data['affiliate_link'];?>
	   <?php }else{?>
                 <?php
			if($General->is_storetype_shoppingcart() || $General->is_storetype_digital())
			{
				if($General->is_checkoutype_cart())
				{
					include(TEMPLATEPATH . '/library/includes/checkout_cart.php');
				}else
				{
					include(TEMPLATEPATH . '/library/includes/checkout_buynow.php');
				}
			?>
<?php
			}
			elseif($General->is_storetype_catalog())
			{
				if($_REQUEST['msg']=='inqsuccess')
				{
					echo __(INQUIRY_SEND_SUCCESS_MSG)."<Br>";
				}
			?>
<a href="<?php echo get_option('siteurl')."/?page=sendenquiry&pid=".$post->ID;?>" class="normal_button fl"><?php _e(SEND_INQUIRY_TEXT);?> </a>
<?php
			}
         	?>
			<?php }?>
        <?php
		}
		?>
		
		<?php the_content(); ?>
         <?php 
		 //stock start
		 include(TEMPLATEPATH . '/library/includes/stock_desc_single.php');
		 //stock end
		 ?>    
            
            <?php
        if(get_option('ptthemes_add_to_cart_button_position')=='Below Description' || get_option('ptthemes_add_to_cart_button_position')=='Above and Below Description') // add to cart button below description
        {
            if(get_option('ptthemes_add_to_cart_button_position')=='Above and Below Description')
            {
                $product_size = $Product->get_product_custom_dl($post->ID,'size','size2');
                $product_color = $Product->get_product_custom_dl($post->ID,'color','color2');
            }
		?>
       		<div class="product_info"> 
            <?php
			if($Product->get_product_price_sale($post->ID)>0)
			{
			?>
            
        	 <div class="row_spacer clearfix"><span class="field_text"> <?php _e(REGULAR_PRICE_TEXT);?>:</span> <span class="price_normal"><s> <?php echo $General->get_amount_format($Product->get_product_price_only($post->ID)); ?> </s> </span></div>
        	 <div class="row_spacer clearfix"> <span class="field_text">  <?php _e(SALE_PRICE_TEXT);?> :</span>  <span class="price"> <?php echo $General->get_amount_format($Product->get_product_price_sale($post->ID)); ?></span> </div>
        <?php
			}else
			{
			?>
        	 <div class="row_spacer clearfix"> <span class="field_text"> <?php _e(SINGLE_PRICE_TEXT);?>:</span> <span class="price"><?php echo $General->get_amount_format($Product->get_product_price_only($post->ID)); ?></span> </div>
        <?php
			}
			?>
           
            <div class="row_spacer clearfix">
             <?php if($product_size){?>
                 
                  <span class="field_text"> <?php _e('Size');?> : </span> <span class="fl"><?php echo $product_size; ?> </span>  
                  <span style="text-decoration: underline; float:left; margin-top:4px; " class="size_chart more" title="size_chart1">+ <?php _e(SIZE_CHART_TEXT);?></span>
                  <div style="display: none;" class="size_chart1 hide" > <span class="close"><?php _e(CLOSE_TEXT);?></span>
                    <?php if ( get_option('ptthemes_size_chart') != "") { ?>
                    <?php echo stripslashes(get_option('ptthemes_size_chart'));  ?>
                    <?php } ?>
                  </div>
                  <!-- size chart -->
                 
                <?php }?>
            </div>
            <div class="row_spacer clearfix">
			<?php if($product_color){?>
            <span class="field_text"> <?php _e('Colors');?> : </span> 
        <?php echo $product_color; ?>
        <?php }?>
            </div>
            <div class="row_spacer">
            <?php if($General->is_show_weight() && $data[ 'weight']){?>
             <span class="field_text"><?php _e('Weight');?>: </span> <span> <strong><?php echo $data[ 'weight']; ?></strong></span> 
            <?php }?>
            </div>
            
             <?php  
			//affiliate link
			if($data['affiliate_link']){  ?>
		   <?php echo $data['affiliate_link'];?>
		   <?php }else{?>
              <?php
				if($General->is_storetype_shoppingcart() || $General->is_storetype_digital())
				{
					if($General->is_checkoutype_cart())
					{
						if(get_option('ptthemes_add_to_cart_button_position')=='Above and Below Description')
						{
							include(TEMPLATEPATH . '/library/includes/checkout_cart_2.php');
						}else
						{
							include(TEMPLATEPATH . '/library/includes/checkout_cart.php');
						}
					}else
					{
						include(TEMPLATEPATH . '/library/includes/checkout_buynow.php');
					}
				?>
<?php
				}
				elseif($General->is_storetype_catalog())
				{
					if($_REQUEST['msg']=='inqsuccess')
					{
						_e(INQUIRY_SEND_SUCCESS_MSG); echo "<Br>";
					}
				?>
<a href="<?php echo get_option('siteurl')."/?page=sendenquiry&pid=".$post->ID;?>" class="highlight_button fl"><?php _e(SEND_INQUIRY_TEXT);?> </a>
<?php
				}
				?>
				<?php }?>
            
             </div> <!-- product info #end--> 
           
        <?php
		}
        ?>
        
           
    </div>
     <?php
	 if($General->is_show_related_products())
	 {
		include(TEMPLATEPATH . '/library/includes/related_products.php');
	 }
	 ?>
       <?php
                 if($General->is_show_addcomment())
				 {				 
				 ?>
                <div class="fix"></div>
                <div class="fix"><!----></div><br/>
                
                
                <div id="comments"><?php comments_template(); ?></div>
                  <?php
                  }
				  ?>  
     </div>
 <?php get_sidebar(); ?>
</div>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/single.js"></script>