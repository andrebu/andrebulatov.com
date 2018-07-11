<script type="text/javascript" >
 function setAttributeVal()
 {
 	var postformflag = 1;
	if(eval(document.getElementById('size')))
	{
		var size = document.getElementById('size').value;
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
		if(eval(document.getElementById('color')))
		{
			var color = document.getElementById('color').value;
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
		if(eval(document.getElementById('cart_information_span')))
		{
			document.getElementById('cart_information_span').innerHTML = '<?php _e('processing ...');?>';
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
		timeout: 20000,
		error: function(){
			//alert('Error loading cart information');
		},
		success: function(html){
			chekc_stock();
			if(eval(document.getElementById('cart_content_sidebar')))
			{
				refresh_cartinfo_sidebar();
			}
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
				document.getElementById('addtocartformspan').innerHTML = '<strong><?php _e(ADDED_CART_MSG);?><Br><a href="<?php echo get_option('siteurl'); ?>/?page=cart"><?php _e(VIEW_CART_DETAIL_TEXT);?></a> or <a href="<?php echo get_option('siteurl'); ?>/?page=cart"><?php _e(CHECKOUT_TEXT);?> &raquo;</a></strong>';
				
			}
		}
	});
	return false;
}
function refresh_cartinfo_sidebar()
{
	$.ajax({
		url: '<?php echo get_option('siteurl'); ?>/?page=cart&cartact=cart_refresh',
		type: 'GET',
		dataType: 'html',
		timeout: 20000,
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
				document.getElementById('addtocartformspan').innerHTML = html;
				//window.location.href='<?php echo $_SERVER['REQUEST_URI'];?>';	
			}
		}
	});
}
function checkstock(attval)
{
	if(eval('document.getElementById("shoppingcart_button_1")'))
	{
		document.getElementById("shoppingcart_button_1").style.display="";
	}
	if(eval('document.getElementById("shoppingcart_outofstock_msg1")'))
	{
		document.getElementById("shoppingcart_outofstock_msg1").innerHTML="";
	}
	if(eval('document.getElementById("shoppingcart_button_2")'))
	{
		document.getElementById("shoppingcart_button_2").style.display="";
	}
	if(eval('document.getElementById("shoppingcart_outofstock_msg2")'))
	{
		document.getElementById("shoppingcart_outofstock_msg2").innerHTML="";
	}
	<?php
	$product_color_js = $Product->get_product_custom_dl($post->ID,'size','',1);
	echo $product_color_js .= $Product->get_product_custom_dl($post->ID,'color','',1);
	?>
}
</script>

<form id="shopingcartfrm" name="shopingcartfrm">
  <input type="hidden" name="cartact" value="addtocart" />
  <input type="hidden" name="product_id" id="product_id" value="<?php the_ID(); ?>" />
  <div class="row ">
  <label><?php _e('Qty:');?></label>  <input name="product_qty" id="product_qty" type="text" onKeyPress="return numberonly(event)" value="1" class="textbox" />
  </div>
  <input type="hidden" name="product_att" id="product_att" value="" />
  <input type="hidden" name="product_price" id="product_price" value="<?php echo $product_cart_price;?>" />
  <input type="hidden" name="product_istaxable" id="product_istaxable" value="<?php echo $data['istaxable'];?>" />
  <input type="hidden" name="product_weight" id="product_weight" value="<?php echo $data[ 'weight']; ?>" />
  <?php /*?><div class="addtocart"><a href="javascript:void(0);" onclick="setAttributeVal();"><?php _e('Add to Shopping Cart'); ?> &raquo; </a></div><?php */?>
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
  <div class="b_addtocart2" id="shoppingcart_button_1"><a href="javascript:void(0);" onclick="setAttributeVal();">addtocart</a> </div>
  <span id="shoppingcart_outofstock_msg1"></span>
<?php }?>
</form><br />
<span id="addtocartformspan" class="clearfix">
<?php if($Cart->is_product_in_cart($post->ID)){echo '<b>'.__('Already Added in the cart').'<Br><a href="'.get_option('siteurl').'/?page=cart">'.__('View Cart Detail').'</a> or <a href="'.get_option('siteurl').'/?page=cart">'.__('Checkout &raquo;').'</a></b>';}?>
</span> 