<?php 
/*
 * @package WordPress
 * @subpackage Kidzstore
*/
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
$data = get_post_meta( $post->ID, 'key', true );
?>
<script>
 function setAttributeVal()
 {
 	var postformflag = 1;
	var size = 0;
	var color = 0;
	if(eval(document.getElementById('size')))
	{
		var size = document.getElementById('size').value;
		if(size == '')
		{
			alert('Please select size');
			postformflag = 0;
		}
	}
	if(postformflag)
	{
		if(eval(document.getElementById('color')))
		{
			var color = document.getElementById('color').value;
			if(color == '')
			{
				alert('Please select color');
				postformflag = 0;
			}
		}
	}
	if(postformflag)
	{
		if(eval(document.getElementById('cart_information_span')))
		{
			document.getElementById('cart_information_span').innerHTML = 'processing ...';
		}
		if(eval(document.getElementById('addtocartformspan')))
		{
			document.getElementById('addtocartformspan').innerHTML = 'processing ...';
		}
		var attstr = '';
		if(size != '' && color != '')
		{
			attstr = size+','+color;
		}else
		if(size != '' && color == '')
		{
			attstr = size;
		}else
		if(size == '' && color != '')
		{
			attstr = color;
		}
		document.getElementById('product_att').value = attstr;
		postform();
	}
 }

function postform()
{
	dataString = $("#shopingcartfrm").serialize();
	$.ajax({
		url: '<?php echo get_option('siteurl'); ?>/?page=cart&'+dataString,
		type: 'GET',
		dataType: 'html',
		timeout: 9000,
		error: function(){
			alert('Error loading cart information');
		},
		success: function(html){
			if(eval(document.getElementById('cart_information_span')))
			{
				document.getElementById('cart_information_span').innerHTML=html;
			}
			if(eval(document.getElementById('cart_information_header_span')))
			{
				document.getElementById('cart_information_header_span').innerHTML=html;
			}			
			if(eval(document.getElementById('addtocartformspan')))
			{
				document.getElementById('addtocartformspan').innerHTML = '<div id="addtocartformspan" class="clearfix"><div class="addtocartformspan"><span class="msg"> <strong>Added To Cart Successfully </strong></span> |&nbsp;  <a href="<?php echo get_option('siteurl'); ?>/?page=cart" class="viewcart" >View Cart Detail</a></div>';
			}
		}
	});
	return false;
}
</script>
<script> var closebutton='<?php bloginfo('template_directory'); ?>/library/js/closebox.png'; </script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/fancyzoom.js"></script>
<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$('div.photo a').fancyZoom({scaleImg: true, closeOnClick: true});
			$('#medium_box_link').fancyZoom({width:400, height:300});
			$('#large_box_link').fancyZoom();
			$('#flash_box_link').fancyZoom();
		});
	</script>
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			<h2> 
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
						_e('Product');
					}else //DISPLAY BLOG POST
					{
						_e('Blog');
					}
				}
			}
			?>
            </h2>
			 <div class="breadcrumb"><?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?></div>
		</div>
	</div>
</div>


<div class="wrapper" >
<div class="container_16 clearfix ">
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
						include(TEMPLATEPATH . '/library/includes/product_detail.php');
					}else //DISPLAY BLOG POST
					{
						include(TEMPLATEPATH . '/library/includes/blog_detail.php');
					}
				}
			}
			?>
  <!-- container 16-->
</div>
<!-- wrapper #end -->
<?php get_footer(); ?>
