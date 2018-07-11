<script>
 function setAttributeVal2()
 {
 	var postformflag = 1;
	if(eval(document.getElementById('size2')))
	{
		var size = document.getElementById('size2').value;
		if(size == '')
		{
			alert('<?php _e("Please select size");?>');
			postformflag = 0;
		}
	}else
	{
		var size = '';
	}
	if(postformflag)
	{
		if(eval(document.getElementById('color2')))
		{
			var color = document.getElementById('color2').value;
			if(color == '')
			{
				alert('<?php _e("Please select color");?>');
				postformflag = 0;
			}
		}else
		{
			var color = 0;
		}
	}
	if(postformflag)
	{
		/*if(eval(document.getElementById('cart_information_span')))
		{
			document.getElementById('cart_information_span').innerHTML = '<?php _e('processing ...');?>';
		}*/
		if(eval(document.getElementById('addtocartformspan2')))
		{
			document.getElementById('addtocartformspan2').innerHTML = '<?php _e('processing ...');?>';
		}
		if(eval(document.getElementById('cart_information_header_span')))
		{
			document.getElementById('cart_information_header_span').innerHTML = '<?php _e('processing ...');?>';
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
		document.getElementById('product_att2').value = attstr;
		postform1();
	}
 }

function postform1()
{
	dataString = $("#shopingcartfrm2").serialize();
	$.ajax({
		url: '<?php echo get_option('siteurl'); ?>/?page=cart&'+dataString,
		type: 'GET',
		dataType: 'html',
		timeout: 9000,
		error: function(){
			//alert('Error loading cart information');
		},
		success: function(html){
			chekc_stock();
			if(eval(document.getElementById('cart_content_sidebar')))
			{
				refresh_cartinfo_sidebar1();
			}
			if(eval(document.getElementById('cart_information_span')))
			{
				document.getElementById('cart_information_span').innerHTML=html;
			}
			if(eval(document.getElementById('cart_information_header_span')))
			{
				document.getElementById('cart_information_header_span').innerHTML=html;
			}	
			if(eval(document.getElementById('addtocartformspan2')))
			{
				document.getElementById('addtocartformspan2').innerHTML = '<strong><?php _e(ADDED_CART_MSG);?><Br><a href="<?php echo get_option('siteurl'); ?>/?page=cart"><?php _e(VIEW_CART_DETAIL_TEXT);?></a> or <a href="<?php echo get_option('siteurl'); ?>/?page=cart"><?php _e(CHECKOUT_TEXT);?> &raquo;</a></strong>';
			}
		}
	});
	return false;
}
function refresh_cartinfo_sidebar1()
{
	$.ajax({
		url: '<?php echo get_option('siteurl'); ?>/?page=cart&cartact=cart_refresh',
		type: 'GET',
		dataType: 'html',
		timeout: 9000,
		error: function(){
			//alert('Error loading cart information');
		},
		success: function(html){
			if(eval(document.getElementById('cart_content_sidebar')))
			{
				document.getElementById('cart_content_sidebar').innerHTML=html;
			}
		}
	});
	return false;
}
function chekc_stock()
{
	dataString = $("#shopingcartfrm").serialize();
	$.ajax({
		url: '<?php echo get_option('siteurl'); ?>/?page=cart&pid=<?php echo $post->ID?>'+dataString+'&cartact=stock_chk',
		type: 'GET',
		dataType: 'html',
		timeout: 20000,
		error: function(){
			//alert('Error loading cart information');
		},
		success: function(html){
			if(html=='unlimited')
			{
				
			}else
			if(html>0)
			{
				//alert(html);	
			}else
			{
				document.getElementById('addtocartformspan2').innerHTML = html;
				//window.location.href='<?php echo $_SERVER['REQUEST_URI'];?>';	
			}
		}
	});
}

</script>

<form id="shopingcartfrm2" name="shopingcartfrm">
  <input type="hidden" name="cartact" value="addtocart" />
  <input type="hidden" name="product_id" id="product_id2" value="<?php the_ID(); ?>" />
  <div class="row_spacer clearfix">
   <span class="field_text"><?php _e('Qty:');?></span> <input name="product_qty" id="product_qty2" type="text" onKeyPress="return numberonly(event)" value="1" class="textbox" />
  </div>
  <input type="hidden" name="product_att" id="product_att2" value="" />
  <input type="hidden" name="product_price" id="product_price2" value="<?php echo $product_cart_price;?>" />
  <input type="hidden" name="product_istaxable" id="product_istaxable2" value="<?php echo $data['istaxable'];?>" />
  <input type="hidden" name="product_weight" id="product_weight2" value="<?php echo $data[ 'weight']; ?>" />
<?php
global $General;
$chk_stock = $General->check_stock($post->ID);
if($data['isshowstock'])
{
	$General->display_stock_text($chk_stock);
}
if($chk_stock=='out_of_stock')
{
	if(!$data['isshowstock'])
	{
		$General->get_out_of_stock_text();
	}
}
else
{
?>
  <div class="row_spacer" id="shoppingcart_button_2"><a href="javascript:void(0);" onclick="setAttributeVal2();"> <img src="<?php echo get_option('siteurl');?>/wp-content/themes/<?php echo get_option('template');?>/images/i-btn-addtocart.png" /> </a></div>
 <span id="shoppingcart_outofstock_msg2"></span>
<?php }?>
</form>

<span id="addtocartformspan2">
<?php if($Cart->is_product_in_cart($post->ID)){ _e('<b>Already Added in the cart<Br><a href="'.get_option('siteurl').'/?page=cart">View Cart Detail </a> or <a href="'.get_option('siteurl').'/?page=cart">Checkout &raquo;</a></b>');} ?>
</span> 