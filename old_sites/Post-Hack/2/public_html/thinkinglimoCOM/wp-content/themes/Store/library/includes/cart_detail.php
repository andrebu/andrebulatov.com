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
$_SESSION['shippingmethod'] = $shippingmethod_code;
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
		alert('<?php _e('Please Enter Coupon Code'); ?>');
		return false;
	}else
	{
		document.getElementById('eval_coupon_code').value = coupon_code;
		document.evaluate_coupon.submit();
	}
	return true;
}
</script>
<?php get_header(); ?>

 
<div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix">
    
        <div id="content">        
       
    
<h1 class="head"><?php _e('My Shopping Cart'); ?> (<?php echo $itemsInCartCount;?>)</h1>
                <div class="breadcrumb clearfix">
                	<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; Shopping Cart'); } ?>
                </div>
                <?php
                if($itemsInCartCount>0)
				{
				?>
                 <?php if($_GET['msg']=='emptycart'){ _e('<div style="color:red">Sorry! your cart is empty. Select product(s) to continue. </div><br>');}?>
                    <form action="<?php echo get_option('siteurl'); ?>/?page=cart&cartact=upd" method="post" name="updatecart">
                      <input type="hidden" name="cartprdid" value="<?php echo $i; ?>" />
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                        <tr>
                          <td colspan="2" class="title"><?php _e('Product(s)'); ?></td>
                          <td width="103" align="center" class="title"><?php _e('Price'); ?></td>
                          <td width="222" align="center" class="title"><?php _e('Qty'); ?></td>
                          <td width="101" align="center" class="title"><?php _e('Total'); ?></td>
                        </tr>
                        <?php
                                for($i=0;$i<count($cartInfo);$i++)
                                {
                                
                                $product_image = $cartInfo[$i]['product_image'];
                                $product_id = $cartInfo[$i]['product_id'];
                                $product_name = $cartInfo[$i]['product_name'];
                                $product_qty = $cartInfo[$i]['product_qty'];
                                $product_att = $cartInfo[$i]['product_att'];
                               // $product_att = preg_replace('/([(])([+-])([0-9]*)([)])/','',$product_att);
                                $product_price = $General->get_amount_format($cartInfo[$i]['product_gross_price'],0);
                                $product_price_total = $cartInfo[$i]['product_gross_price']*$cartInfo[$i]['product_qty'];
                                ?>
                        <?php /*?><form action="<?php echo get_option('siteurl'); ?>/?page=cart&cartact=upd&prm=<?php echo $i; ?>" method="post"><input type="hidden" name="cartprdid" value="<?php echo $i; ?>" /><?php */?>
                        <tr>
                          <td width="64" valign="top" class="row1 bnone" ><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $product_image; ?>&amp;h=60&amp;w=50&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt=""  class="product_thum" /></td>
                          <td width="892" valign="top" class="row1"><strong><?php echo $product_name;?> </strong>
                            <?php
                                        if($product_att!='')
                                        {
                                        echo '<p>('.str_replace(',',', ',$product_att).')</p>'; 
                                        }
                                        ?>
                            
                            <a href="<?php echo get_option('siteurl'); ?>/?page=cart&cartact=rmv&prm=<?php echo $i; ?>" title="Remove from Cart" class="remove_item"><?php _e('Remove Item'); ?></a> </td>
                          <td align="center" valign="top" class="row1 tprice" ><?php echo $product_price; ?></td>
                          <td align="center" valign="top" class="row1 tprice"   ><input type="text" name="product_qty[]" size="8" value="<?php echo $product_qty; ?>" class="qty" onKeyPress="return numberonly(event)" />
                           <?php $chk_stock=$General->cart_detail_outofstock($product_id); if($chk_stock){ echo '<br><span style="color:#FF0000; font-size:12px;">'.$chk_stock.'</span>';}?>
                          </td>
                          <td valign="top" class="row1 tprice "    ><?php echo $General->get_amount_format($product_price_total,0); ?></td>
                          <?php /*?><td align="center" valign="top" class="row1" ><input type="image" src="<?php bloginfo('template_directory'); ?>/images/update.png" alt="update"  /> </td><?php */?>
                        </tr>
                        <?php /*?></form><?php */?>
                        <?php
                                }
                                ?>
                        <tr>
                          <td colspan="2" align="right" class="row1" ></td>
                          <td align="center" class="row1" ></td>
                          <td align="center" class="row1 tprice" >
                          <!--<a  href="javascript:void(0);" onclick="document.updatecart.submit();" class="normal_button " >Update Cart</a> -->
                          <input type="submit" name="Update Cart" value="<?php _e('Update Cart'); ?>" class="highlight_input_btn update_cart" />
                          </td>
                          <td align="left" class="row1 tprice" >&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="right" ></td>
                          <td align="right" >&nbsp;</td>
                          <td colspan="2" align="right"  ><?php _e('Sub Total Amount'); ?></td>
                          <td align="left" class=" tprice" ><?php echo  $grandTotal; ?></td>
                        </tr>
                        <?php
                                 if($product_tax>0)
                                 {
                                 ?>
                        <tr>
                          <td align="right" ></td>
                          <td align="right"  >&nbsp;</td>
                          <td colspan="2" align="right"  ><?php _e('Tax Amount'); ?> (<?php echo $product_tax;?>%) </td>
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
                          <td colspan="3" align="right" ><?php echo $General->get_shipping_method($shippingmethod);?> <?php _e('Amount'); ?> :</td>
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
                          <td colspan="2" align="right" class="total_amount_title" ><strong><?php _e('Total Amount'); ?> : </strong></td>
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
                          <td colspan="2" style="text-decoration:underline;"><strong>Shipping Methods</strong></td>
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
                       <?php if($General->is_show_coupon()){ ?>
                        <div class="coupon_code">
                          <table border="0" cellpadding="3" cellspacing="3"  >
                            <?php if($_REQUEST['msg']=='invalidcoupon'){?>
                            <tr>
                              <td  colspan="2" style="color:#FF0000"><?php _e('Not a valid Coupon. Please enter correct one.'); ?><br />
                                <br /></td>
                            </tr>
                            <?php }?>
                            <tr>
                              <td class="table_td_align" ><?php _e('Discount Code'); ?> : </td>
                              <td class="table_td_align"><input type="text" class="coupon_text fl" value="<?php echo $_SESSION['eval_coupon_code'];?>" name="coupon_code" id="coupon_code" />
                               <?php /*?><!-- <a href="javascript:void(0);"  onclick="evaluate_coupon_amt();"  class="fl normal_button" >Recalculate</a>--> <?php */?>
                                <input type="button" onclick="evaluate_coupon_amt();" name="Recalculate" value="Recalculate" class="normal_input_btn fl recalculate" />
                              </td>
                            </tr>
                          </table>
                        </div>
                        <?php }?>
                        <a href="<?php echo get_option('siteurl'); ?>" class="fl continue_spacer"><?php _e('&laquo; Continue Shopping'); ?> </a>
                        <input type="submit" name="Update" value="<?php _e('Checkout  &raquo;'); ?>" class="highlight_input_btn checkout_spacer fr " />
                         <!--<a href="javascript:void(0);" onclick="document.checkout_frm.submit();" class="highlight_button fr checkout_spacer" >CheckOut  &raquo; </a>--> </div>
                      <!-- button bar #end -->
                     
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td></td>
                          <td align="right"></td>
                        </tr>
                      </table>
                    </form>
                    <form action="<?php ?>" method="post" name="evaluate_coupon">
                      <input type="hidden" name="cartact" value="eval_coupon" />
                      <input type="hidden" name="eval_coupon_code" id="eval_coupon_code" value="" />
                    </form>
                <?php
				}else
				{
				?>
                 <h3><?php _e('Sorry, the Cart is empty.  Select Products via Continue Shopping.'); ?> </h3>
          		<a href="<?php echo get_option('siteurl');?>" class="highlight_button fl"><?php _e('&laquo; Continue Shopping'); ?> </a>
                <?php
				}
				?>
                

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