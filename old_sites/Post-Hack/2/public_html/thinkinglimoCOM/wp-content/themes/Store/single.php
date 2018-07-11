<?php 
session_start();
ob_start();
get_header(); 
global $Product,$Cart, $General;
$product_price = $Product->get_product_price($post->ID);
$product_cart_price = $Product->get_product_price_no_currency($post->ID);
$product_qty = $Product->get_product_qty($post->ID);
$product_size =$Product->get_product_custom_dl($post->ID,'size','','',__('Select Size'));
$product_color = $Product->get_product_custom_dl($post->ID,'color','','',__('Select Color'));
$product_tax = $General->get_product_tax();
$customarray = array('size','color');
//$product_custom_dl_jscript = $Product->get_product_custom_dl_jscript($post->ID,$customarray);
if(get_post_meta( $post->ID, 'key', true ))
{
$data = get_post_meta( $post->ID, 'key', true );
}else
{
	$data = get_post_meta( $post->ID, 'key1', true );	
}
?>
<?php get_header(); ?>
<script> var closebutton='<?php bloginfo('template_directory'); ?>/library/js/closebox.png'; </script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/fancyzoom.js"></script>
<link href="<?php bloginfo('template_directory'); ?>/library/css/thickbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('div.photo a').fancyZoom({scaleImg: true, closeOnClick: true});
		$('#medium_box_link').fancyZoom({width:400, height:300});
		$('#large_box_link').fancyZoom();
		$('#flash_box_link').fancyZoom();
	});
</script>
<style>
	* html #infoHolder { top:335px !important;  }
</style>

<script type="text/javascript">
$(document).ready(function(){

$('.hide').hide();

$('body').append('<div id="infoBacking"></div><div id="infoHolder" class="large"></div>');
$('#infoBacking').css({position:'absolute', left:0, top:0, display:'none', textAlign:'center', background:'', zIndex:'600'});
$('#infoHolder').css({left:0, top:0, display:'none', textAlign:'center', zIndex:'600', position:'fixed'});
if($.browser.msie){$('#infoHolder').css({position:'absolute'});}


$('.more').mouseover(function() {$(this).css({textDecoration:'none'});} );
$('.more').mouseout(function() {$(this).css({textDecoration:'none'});} );

$('.more').click(function(){

if ($('.' + $(this).attr("title")).length > 0) {

	browserWindow()
	getScrollXY()

	if (height<totalY) { height=totalY; }

	$('#infoBacking').css({width: totalX + 'px', height: height + 'px', top:'0px', left:scrOfX + 'px', opacity:0.85});
	$('#infoHolder').css({width: width + 'px', top:scrOfY + 25 + 'px', left:scrOfX + 'px'});
	source = $(this).attr("title");

	$('#infoHolder').html('<div id="info">' + $('.' + source).html() + '<p class="clear"><span class="close"><?php _e('Close X');?></span></p></div>');

	$('#infoBacking').css({display:'block'});
	$('#infoHolder').show();
	$('#info').fadeIn('slow');
}

$('.close').click(function(){
	$('#infoBacking').hide();
	$('#infoHolder').fadeOut('fast');
});

});

/* find browser window size */
function browserWindow () {
	width = 0
	height = 0;
	if (document.documentElement) {
		width = document.documentElement.offsetWidth;
		height = document.documentElement.offsetHeight;
	} else if (window.innerWidth && window.innerHeight) {
		width = window.innerWidth;
		height = window.innerHeight;
	}
	return [width, height];
}
/* find total page height */
function getScrollXY() {
	scrOfX = 0; 
	scrOfY = 0;
	if( typeof( window.pageYOffset ) == 'number' ) {
		scrOfY = window.pageYOffset;
		scrOfX = window.pageXOffset;
	} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
		scrOfY = document.body.scrollTop;
		scrOfX = document.body.scrollLeft;
	} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
		scrOfY = document.documentElement.scrollTop;
		scrOfX = document.documentElement.scrollLeft;
	}
	totalY = (window.innerHeight != null? window.innerHeight : document.documentElement && document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body != null ? document.body.clientHeight : null);

	totalX = (window.innerWidth != null? window.innerWidth : document.documentElement && document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body != null ? document.body.clientWidth : null);
	
	return [ scrOfX, scrOfY, totalY, totalX ];
}

return false;
				});
				</script>
 <div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix">
    
        <div id="content">  
 
 
            	<h1 class="head"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                <?php
                if(have_posts()) {
				?>
                <div class="breadcrumb clearfix">
                	<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
                </div>
                <?php
                }
				?>
             <?php
			$blogCategoryIdStr = get_inc_categories("cat_exclude_");
			$blogCategoryIdArr = explode(',',$blogCategoryIdStr);
			
			if(have_posts())
			{
				while(have_posts())
				{
					the_post();
					$cagInfo = get_the_category();
					$postCatId = $cagInfo[0]->term_id;
					if(!in_array($postCatId,$blogCategoryIdArr))  //DISPLAY PRODUCT
					{
						$post_image_array = $General->get_post_images($post->ID);
					?>
                    
                    
                    
                    
                    
                    <div class="product clearfix product_inner">
                         	<div  id="photos"  class="pro_img"> 
                              <?php if($post_image_array[0]){?>
                              <div class="photo main_photo" > <a href="#productimage"><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_image_array[0]; ?>&amp;w=490&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""/></a>
                                <div class="zoom"><a href="#productimage"> <?php _e('Zoom');?> </a> </div>
                              </div>
                              <?php }else
							{
							?>
                            <div class="no_image"><?php _e('No Image Available');?></div>
                            <?php
							}
							?>
                              
							 
                            
                            <div class="pro_thumb_img"> 
                            <?php if($post_image_array[1]){?>
                            <div class="photo " ><a href="#productimage1"><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_image_array[1]; ?>&amp;w=50&amp;h=60&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""/></a></div>
                            <?php }	?>
                           <?php if($post_image_array[2]){?>
                            <div class="photo " ><a href="#productimage2"><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_image_array[2]; ?>&amp;w=50&amp;h=60&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""/></a></div>
                            <?php }	?>
                            <?php if($post_image_array[3]){?>
                           <div class="photo " ><a href="#productimage3"> <img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_image_array[3]; ?>&amp;w=50&amp;h=60&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""/></a></div>
                            <?php }	?>
                            <?php if($post_image_array[4]){?>
                            <div class="photo " ><a href="#productimage4"> <img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_image_array[4]; ?>&amp;w=50&amp;h=60&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""/></a></div>
                            <?php }	?>
                            <?php if($post_image_array[5]){?>
                             <div class="photo " ><a href="#productimage5"> <img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_image_array[5]; ?>&amp;w=50&amp;h=60&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""/></a></div>
                            <?php }	?>
                            <?php if($post_image_array[6]){?>
                             <div class="photo " ><a href="#productimage6"> <img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_image_array[6]; ?>&amp;w=50&amp;h=60&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""/></a></div>
                            <?php }	?>
                            
                            <?php if($data[ 'productimage' ]){?><div style="display: none;" id="productimage" > <img src="<?php echo $post_image_array[0]; ?>" alt="helmet"> </div><?php }?>
                            <?php if($data[ 'productimage1' ]){?><div style="display: none;" id="productimage1" > <img src="<?php echo $post_image_array[1]; ?>" alt="helmet"> </div><?php }?>
                            <?php if($data[ 'productimage2' ]){?><div style="display: none;" id="productimage2" > <img src="<?php echo $post_image_array[2]; ?>" alt="helmet"> </div><?php }?>
                            <?php if($data[ 'productimage3' ]){?><div style="display: none;" id="productimage3" > <img src="<?php echo $post_image_array[3]; ?>" alt="helmet"> </div><?php }?>
                            <?php if($data[ 'productimage4' ]){?><div style="display: none;" id="productimage4" > <img src="<?php echo $post_image_array[4]; ?>" alt="helmet"> </div><?php }?>
                            <?php if($data[ 'productimage5' ]){?><div style="display: none;" id="productimage5" > <img src="<?php echo $post_image_array[5]; ?>" alt="helmet"> </div><?php }?>
                            <?php if($data[ 'productimage6' ]){?><div style="display: none;" id="productimage6" > <img src="<?php echo $post_image_array[6]; ?>" alt="helmet"> </div><?php }?>
                            </div> <!-- pro thum img #end -->
                            </div>
                            <div class="product_info">
                              <?php
                               if(get_option('ptthemes_add_to_cart_button_position')=='Above Description' || get_option('ptthemes_add_to_cart_button_position') == '' || get_option('ptthemes_add_to_cart_button_position')=='Above and Below Description') // add to cart button below description
							   {
							   ?>
                               <div class="product_details">
                               
                               		
                                
                                <div class="product_extra">
                                
                                 <?php if($product_size){?>
                                <div class="row ">
                                  <label ><?php _e('Size');?>: </label>
                                  <strong class="fl"><?php echo $product_size; ?></strong> 
                                  
                                  <span style="text-decoration: underline;" class="size_chart more" title="size_chart1">+ <?php _e('Size Chart');?></span>
                                  <div style="display: none;" class="size_chart1 hide" > <span class="close"><?php _e('Close X');?></span>
                                    <?php if ( get_option('ptthemes_size_chart') != "") { ?>
                                    <?php echo stripslashes(get_option('ptthemes_size_chart'));  ?>
                                    <?php } ?>
                                  </div>
                                  <!-- size chart -->
                                </div>
                                <?php }?>
                                <?php if($product_color){?>
            <div class="row">
              <label ><?php _e('Color');?>:</label>
              <strong><?php echo $product_color; ?></strong></div>
            <?php }?>
            
            <?php if($General->is_show_weight() && $data[ 'weight']){?>
                                <div class="row"> <label > <?php _e('Weight');?>: </label> <span class="weight"><?php echo $data[ 'weight']; ?></span></div>
                                <?php }?>
                                
                                </div> <!-- product #extra -->
                                
                                 
                                <div class="product_price">
                                <?php
                                if($Product->get_product_price_sale($post->ID)>0)
								{
								?>
                                <p><?php _e('Regular Price');?>:  <s> <?php echo $General->get_amount_format($Product->get_product_price_only($post->ID)); ?> </s> </p>
                                <p><strong> <?php _e('Sale Price');?> : </strong> <span class="price"> <?php echo $General->get_amount_format($Product->get_product_price_sale($post->ID)); ?></span>  </p>
                                <?php
								}else
								{
								?>
                                <p><strong>Price: <span class="price"> <?php echo $General->get_amount_format($Product->get_product_price_only($post->ID)); ?> </span></strong></p>
                                <?php
                                }
								?>
                                
                                
                                  <?php
								  if($data['affiliate_link'])
								  {
									  ?>
           							 <?php echo $data['affiliate_link'];?>
           						<?php
								  }else
								  {
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
										echo INQUIRY_SEND_SUCCESS_MSG."<Br>";
									}
								?>
           							 <a href="<?php echo get_option('siteurl')."/?page=sendenquiry&pid=".$post->ID;?>" class="normal_button fl"><?php _e(SEND_INQUIRY); ?> </a>
           						<?php
								}
								  }
								?>
                                
                                 </div> <!-- product_price #end -->
                               
                                
                                
                               
            
            </div> <!-- product details #end -->
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
                               <div class="product_details">
                               
                               		
                                
                                <div class="product_extra">
                                
                                 <?php if($product_size){?>
                                <div class="row ">
                                  <label ><?php _e('Size');?>: </label>
                                  <strong class="fl"><?php echo $product_size; ?></strong> 
                                  
                                  <span style="text-decoration: underline;" class="size_chart more" title="size_chart1">+ <?php _e('Size Chart');?></span>
                                  <div style="display: none;" class="size_chart1 hide" > <span class="close"><?php _e('Close X');?></span>
                                    <?php if ( get_option('ptthemes_size_chart') != "") { ?>
                                    <?php echo stripslashes(get_option('ptthemes_size_chart'));  ?>
                                    <?php } ?>
                                  </div>
                                  <!-- size chart -->
                                </div>
                                <?php }?>
                                <?php if($product_color){?>
            <div class="row">
              <label > <?php _e('Color');?>:</label>
              <strong><?php echo $product_color; ?></strong></div>
            <?php }?>
            
            <?php if($General->is_show_weight() && $data[ 'weight']){?>
                                <div class="row"> <label >  <?php _e('Weight');?>: </label> <span class="weight"><?php echo $data[ 'weight']; ?></span></div>
                                <?php }?>
                                
                                </div> <!-- product #extra -->
                                
                                 
                                <div class="product_price">
                                <?php
                                if($Product->get_product_price_sale($post->ID)>0)
								{
								?>
                                <p><?php _e('Regular Price');?>:  <s> <?php echo $General->get_amount_format($Product->get_product_price_only($post->ID)); ?> </s> </p>
                                <p><strong> <?php _e('Sale Price');?>: </strong> <span class="price"> <?php echo $General->get_amount_format($Product->get_product_price_sale($post->ID)); ?></span>  </p>
                                <?php
								}else
								{
								?>
                                <p><strong>Price: <span class="price"> <?php echo $General->get_amount_format($Product->get_product_price_only($post->ID)); ?> </span></strong></p>
                                <?php
                                }
								?>
                                
                                
                                  <?php
								  if($data['affiliate_link'])
								  {
									  ?>
           							 <?php echo $data['affiliate_link'];?>
           						<?php
								  }else
								  {
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
										echo INQUIRY_SEND_SUCCESS_MSG."<Br>";
									}
								?>
           							 <a href="<?php echo get_option('siteurl')."/?page=sendenquiry&pid=".$post->ID;?>" class="normal_button fl"><?php _e(SEND_INQUIRY); ?> </a>
           						<?php
								}
								  }
								?>
                                
                                 </div> <!-- product_price #end -->
                               
                                
                                
                               
            
            </div> <!-- product details #end -->
            					<?php
								}
								 ?>
                                
								<ul class="fav_link">
                                  <li class="print"><a href="#" onclick="window.print();return false;">Print</a> </li>
                                  <?php if ( get_option('ptthemes_feed_name') != "") { ?>
                                  
                                    <?php } ?>
                                   </li>
                                   <?php
                                             if($General->is_show_tellaFriend())
                                             {
                                                include(TEMPLATEPATH . '/library/includes/tellafriend.php');
                                             } ?>
                                </ul>
                                              
                                                                 
                                <div class="fix"></div>
                                
                      </div>  <!-- productinfo #end -->
         		 </div>
                 <div class="fix"></div>
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
                 	<div id="comments"><?php comments_template(); ?></div>
               	 <?php }?>
                    <?php
					}else //DISPLAY BLOG
					{
					?>
					
                    <?php if(get_post_custom_values("thumb")){?>
                    <img src="<?php $values = get_post_custom_values("thumb"); echo $values[0]; ?>" alt="<?php the_title(); ?>" class="thumb" />
                    <?php }?>
					<div id="post-<?php the_ID(); ?>" class="posts">
				    						                        
 				    
                     <p class="postmetadata">Posted on <?php the_time('F j, Y') ?>  // 
                    <span class="commentcount"> <a href="<?php the_permalink(); ?>#commentarea"><?php comments_number('0 Comments', '1 Comments', '% Comments'); ?></a></span></p>
                   
					
                     <?php if ( get_post_meta($post->ID,'image', true) ) { ?>
        <div class="post_img clearfix"> <img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo get_post_meta($post->ID, "image", $single = true); ?>&amp;w=500&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt="<?php the_title(); ?>"  class="img"   /></div>
        <?php } ?>
                    
											
					<?php the_content(); ?>
					
					<div class="fix"><!----></div><br/>
					
					<p class="post_bottom">Category : <?php the_category(" &amp;"); ?></p>
											
                </div>
                <div id="comments"><?php comments_template(); ?></div>
                    <?php
					}
				}
					?>
 			<div class="pagination">
			
                <?php if (function_exists('wp_pagenavi')) { ?><?php wp_pagenavi(); ?><?php } ?>
						
            </div>
			
             <?php }else{ ?>
			 <div class="posts">
              <div class="entry-head">
                <h2><?php echo get_option('ptthemes_404error_name'); ?></h2>
              </div>
              <div class="entry-content">
                <p><?php echo get_option('ptthemes_404solution_name'); ?></p>
              </div>
            </div>
            <?php }?>
 
	     			  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->
<script type="text/javascript">
function numberonly(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        status = "This field accepts numbers only."
        return false
    }
    status = ""
    return true
}
</script>
 <?php get_footer(); ?>
