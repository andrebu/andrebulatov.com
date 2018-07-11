<?php 
session_start();
ob_start();
global $Cart,$General;
$_REQUEST['coupon_code'] = $_REQUEST['eval_coupon_code'];
$_SESSION['checkout_as_guest'] = $_REQUEST['checkout_as_guest']; 
$shippingmehod_arr = $General->get_shipping_mehod();
if(count($shippingmehod_arr)==1)
{
	$shippingmethod_code = $shippingmehod_arr[0];
	$shippingmethod = $General->get_shipping_method($shippingmethod_code);
}
if($shippingmethod_code)
{
	$_SESSION['shippingmethod'] = $shippingmethod_code;
}
$itemsInCartCount = $Cart->cartCount();
$cartInfo = $Cart->getcartInfo();
$grandTotal = $General->get_amount_format($Cart->getCartAmt());
$product_tax = $General->get_product_tax();
$taxable_amt = $General->get_tax_amount();
$payable_amt = $General->get_payable_amount();

$paymentsql = "select * from $wpdb->options where option_name like 'shipping_method_%'";
$paymentinfo = $wpdb->get_results($paymentsql);
if($paymentinfo)
{
	$shippingcount = 0;
	foreach($paymentinfo as $paymentinfoObj)
	{
		$paymentInfo = unserialize($paymentinfoObj->option_value);
		if($paymentInfo['isactive'])
		{
			$shippingcount++;
			$shippingmethod = $paymentInfo['key'];
		}
	}
}
if($shippingcount == 1)
{
	$shipping_amt = $General->get_shipping_amt($shippingmethod,$Cart->getCartAmt());
	$payable_amt = $General->get_payable_amount($shippingmethod);
}
?>
<script>
function evaluate_coupon_amt()
{
	var coupon_code = document.getElementById('coupon_code').value;
	if(coupon_code == '')
	{
		alert('Please Enter Coupon Code');
		return false;
	}else
	{
		document.getElementById('eval_coupon_code').value = coupon_code;
		document.evaluate_coupon.submit();
	}
}
</script>
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			<h2><?php _e(SHOPPING_CART_PAGE_TITLE); ?> (<?php echo $itemsInCartCount;?>)</h2>
             <div class="breadcrumb clearfix">
			<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; '.__(SHOPPING_CART_PAGE_TITLE)); } ?>
             </div>
		</div>
	</div>
</div>


<div class="wrapper" >
<div class="clearfix container_border">
  <?php
	if($itemsInCartCount>0)
	{
	?>
  </div>
  <div class="container_16 clearfix">
    <div id="content" class="grid_11">
     <?php if($_GET['msg']=='emptycart'){ echo "<div style='color:red'>".CART_EMPTY_MSG."</div><br>";}?>
    <form action="<?php echo get_option('siteurl'); ?>/?page=cart&cartact=upd" method="post" name="updatecart">
      <input type="hidden" name="cartprdid" value="<?php echo $i; ?>" />
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
        <tr>
          <td colspan="2" class="title"><?php _e(PRODUCTS_TEXT);?></td>
          <td width="103" align="center" class="title"><?php _e(PRICE_TEXT);?></td>
          <td width="222" align="center" class="title"><?php _e(QTY_TEXT);?></td>
          <td width="101" align="center" class="title"><?php _e(TOTAL_TEXT);?></td>
        </tr>
        <?php
				for($i=0;$i<count($cartInfo);$i++)
				{
				
				$product_image = $cartInfo[$i]['product_image'];
				$product_id = $cartInfo[$i]['product_id'];
				$product_name = $cartInfo[$i]['product_name'];
				$product_qty = $cartInfo[$i]['product_qty'];
				$product_att = $cartInfo[$i]['product_att'];
				$product_att = preg_replace('/([(])([+-])([0-9]*)([)])/','',$product_att);
				$product_price = $General->get_amount_format($cartInfo[$i]['product_gross_price'],0);
				$product_price_total = $cartInfo[$i]['product_gross_price']*$cartInfo[$i]['product_qty'];
				?>
        <tr>
          <td width="64" valign="top" class="row1 bnone" ><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $product_image; ?>&amp;h=60&amp;w=50&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""  class="product_thum" /></td>
          <td width="892" valign="top" class="row1"><strong><?php echo $product_name;?> </strong>
            <?php
						if($product_att!='')
						{
						echo '<br>('.$product_att.')'; 
						}
                        ?>
            <br />
            <a href="<?php echo get_option('siteurl'); ?>/?page=cart&cartact=rmv&prm=<?php echo $i; ?>" title="Remove from Cart" class="remove_item"><?php _e(REMOVE_ITEM_TEXT);?></a> </td>
          <td align="center" valign="top" class="row1 tprice" ><?php echo $product_price; ?></td>
          <td align="center" valign="top" class="row1 tprice"   ><input type="text" name="product_qty[]" size="8" value="<?php echo $product_qty; ?>" class="qty" onKeyPress="return numberonly(event)" />
           <?php $chk_stock=$General->cart_detail_outofstock($product_id); if($chk_stock){ echo '<br><span style="color:#FF0000; font-size:12px;">'.$chk_stock.'</span>';}?>
          </td>
          <td valign="top" class="row1 tprice "    ><?php echo $General->get_amount_format($product_price_total,0); ?></td>
        </tr>
        <?php
				}
				?>
        <tr>
          <td colspan="2" align="right" class="row1" ></td>
          <td align="center" class="row1" ></td>
          <td align="center" class="row1 tprice" ><a  href="javascript:void(0);" onclick="document.updatecart.submit();" class="normal_button " ><?php _e(UPDATE_CART_TEXT); ?></a> </td>
          <td align="left" class="row1 tprice" >&nbsp;</td>
        </tr>
        <tr>
          <td align="right" ></td>
          <td align="right" >&nbsp;</td>
          <td colspan="2" align="right"  ><?php _e(SUB_TOTAL_AMOUNT_TEXT);?></td>
          <td align="left" class=" tprice" ><?php echo  $grandTotal; ?></td>
        </tr>
        <?php
                 if($product_tax>0)
				 {
				 ?>
        <tr>
          <td align="right" ></td>
          <td align="right"  >&nbsp;</td>
          <td colspan="2" align="right"  ><?php _e(TAX_AMOUNT_TEXT);?> (<?php echo $product_tax;?>%) </td>
          <td align="left" class=" tprice" ><?php echo  $General->get_amount_format($taxable_amt); ?></td>
        </tr>
        <?php
				 }
				 ?>
        <?php
                 if($shippingmethod && $shipping_amt>0)
				 {
				 ?>
        <tr>
          <td align="right"  ></td>
          <td colspan="3" align="right" ><?php echo __($General->get_shipping_method($shippingmethod)).' '. __('Amount');?>  :</td>
          <td align="left" class=" tprice" ><?php echo  $General->get_amount_format($shipping_amt); ?></td>
        </tr>
        <?php }?>
        <?php 
				  $couponInfo = $General->get_coupon_deduction();
				  $cart_discount_amt = $General->get_amount_format($General->get_discount_amount($_SESSION['couponcode'],$Cart->getCartAmt()));
				  if($couponInfo && $General->get_discount_amount($_SESSION['couponcode'],$Cart->getCartAmt())>0){?>
        <tr>
          <td colspan="4" align="right" ><?php echo $couponInfo;?> : </td>
          <td align="left" class=" tprice" ><?php echo  $cart_discount_amt; ?></td>
        </tr>
        <?php }?>
        <tr>
          <td colspan="2" align="left" class="total_amount_title"  >&nbsp;</td>
          <td colspan="2" align="right" class="total_amount_title" ><strong><?php _e(TOTAL_AMOUNT_TEXT);?> : </strong></td>
          <td  class="total_price"><?php echo  $General->get_amount_format($payable_amt); ?></td>
        </tr>
      </table>
    </form>
    <form action="<?php global $General; echo $General->get_ssl_normal_url(get_option('siteurl')); ?>/?page=checkout" method="post" name="checkout_frm">
      <?php
               	$paymentsql = "select * from $wpdb->options where option_name like 'shipping_method_%'";
				$paymentinfo = $wpdb->get_results($paymentsql);
				if($paymentinfo)
				{
				?>
      <table width="100%" <?php if($shippingcount==1){ ?> style="display:none;"<?php }?>>
        <tr>
          <td colspan="2" style="text-decoration:underline;"><strong><?php _e(SHIPPING_METHODS_TEXT);?></strong></td>
        </tr>
        <?php
					$shippingcount = 0;
                	foreach($paymentinfo as $paymentinfoObj)
					{
						$paymentInfo = unserialize($paymentinfoObj->option_value);
						if($paymentInfo['isactive'])
						{
						$shippingcount++;
				?>
        <tr>
          <td><?php echo $paymentInfo['name']?></td>
          <td><input type="radio" value="<?php echo $paymentInfo['key'];?>" name="shippingmethod" checked="checked" /></td>
        </tr>
        <?php
						}
					}
				?>
      </table>
      <?php
               	}
				?>
      <br />
     
      <div class="button_bar2">
        <?php if($General->is_show_coupon()){	?>
        <div class="coupon_code">
          <table border="0" cellpadding="5" cellspacing="5">
            <?php if($_REQUEST['msg']=='invalidcoupon'){?>
            <tr>
              <td colspan="2" style="color:#FF0000"><?php _e(INVALID_COUPON_MSG);?><br />
                <br /></td>
            </tr>
            <?php }?>
            <tr>
              <td ><?php _e(DISCOUNT_CODE_TEXT);?> : </td>
              <td><input type="text" class="coupon_text fl" value="<?php echo $_SESSION['eval_coupon_code'];?>" name="coupon_code" id="coupon_code" />
                <a href="javascript:void(0);"  onclick="evaluate_coupon_amt();"  class="fl normal_button" ><?php _e(RECALCULATE_TEXT);?></a> </td>
            </tr>
          </table>
        </div>
       <?php }?>
      </div>
        <div>
        <a href="<?php echo get_option('siteurl'); ?>" class="fl continue_spacer">&laquo; <?php _e(CONTINUE_SHOPPING_TEXT);?> </a> 
        <a href="javascript:void(0);" onclick="document.checkout_frm.submit();" class="highlight_button fr checkout_spacer" ><?php _e(CHECKOUT_TEXT);?>  &raquo; </a> </div>
      <!-- button bar #end -->
    </form>
    <form action="<?php ?>" method="post" name="evaluate_coupon">
      <input type="hidden" name="cartact" value="eval_coupon" />
      <input type="hidden" name="eval_coupon_code" id="eval_coupon_code" value="" />
    </form>
    </div>
    
    <?php
			}else
			{
			?>
      <div class="container_16 clearfix">
    <div id="content" class="grid_11">
  <div id="mycart_content">
          <h3><?php _e(CART_EMPTY_MSG);?> </h3>
          <a href="<?php echo get_option('siteurl');?>" class="highlight_button fl">&laquo; <?php _e(CONTINUE_SHOPPING_TEXT);?> </a>
          
           
         </div>
     </div>
          
          <?php
		  $_SESSION['couponcode'] = '';
            }
			?>
       
      
      <?php get_sidebar(); ?>
    
    </div>
    
</div>
 
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
<!-- wrapper #end -->
<?php get_footer(); ?>