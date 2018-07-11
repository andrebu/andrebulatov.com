<?php
global $Cart;
$Cart->empty_cart();
?>
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
<script>
 function setAttributeVal()
 {
 	var postformflag = 1;
	if(eval(document.getElementById('size')))
	{
		var size = document.getElementById('size').value;
		if(size == '')
		{
			alert('Please select size');
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
				alert('Please select color');
				postformflag = 0;
			}
		}else
		{
			var color = 0;
		}
	}
	if(postformflag)
	{
		var attstr = '';
		if(size != '' && color != '')
		{
			attstr = size+','+color;
		}else
		if(size != '' && color == '')
		{
			attstr = color;
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
			window.location.href="<?php echo get_option('siteurl'); ?>/?page=payment&paymentmethod=paypal";
		}
	});
	return false;
}
</script>

<form id="shopingcartfrm" name="shopingcartfrm">
  <input type="hidden" name="cartact" value="addtocart" />
  <input type="hidden" name="product_id" id="product_id" value="<?php the_ID(); ?>" />
  <input name="product_qty" id="product_qty" type="hidden" value="1" class="textbox" />
  <input type="hidden" name="product_att" id="product_att" value="" />
  <input type="hidden" name="product_price" id="product_price" value="<?php echo $product_cart_price;?>" />
  <input type="hidden" name="product_istaxable" id="product_istaxable" value="<?php echo $data['istaxable'];?>" />
  <input type="hidden" name="product_weight" id="product_weight" value="<?php echo $data[ 'weight']; ?>" />
  <div class="b_buynow"> <a href="javascript:void(0);" onclick="setAttributeVal();" > <?php _e('Buy Now'); ?></a> </div>

</form>
<?php }?>   