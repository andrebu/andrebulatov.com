<?php
global $Cart,$General;
$itemsInCartCount = $Cart->cartCount();
$cartInfo = $Cart->getcartInfo();
$grandTotal = $General->get_amount_format($Cart->getCartAmt());
$userInfo = $General->getLoginUserInfo();
if(!$userInfo)
{
	wp_redirect(get_option( 'siteurl' ).'/?page=login');
	exit;
}
$user_address_info = unserialize(get_user_option('user_address_info', $userInfo['ID']));
?>
<?php get_header(); ?>

<div class="wrapper" >
  <div class="clearfix container_border">
    <h1 class="head"><?php _e('Confirmation Page'); ?></h1>
    <div class="breadcrumb clearfix">
      <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
    </div>
  </div>
  <div class="container_16 clearfix">
    <div id="content" class="grid_11">
      <div class="content_spacer">
        <?php
            if($itemsInCartCount>0)
			{
			?>
        <table width="100%">
          <tr>
            <td><table width="100%">
                <tr>
                  <td><b><?php _e('User Information'); ?></b></td>
                  <td><b><?php _e('Billing Information'); ?></b></td>
                </tr>
                <tr>
                  <td><?php echo $userInfo['display_name'];?></td>
                  <td><?php echo $userInfo['display_name'];?></td>
                </tr>
                <tr>
                  <td><?php echo $user_address_info['user_add1'];?></td>
                  <td><?php echo $user_address_info['user_add1'];?></td>
                </tr>
                <tr>
                  <td><?php echo $user_address_info['user_add2'];?></td>
                  <td><?php echo $user_address_info['user_add2'];?></td>
                </tr>
                <tr>
                  <td><?php echo $user_address_info['user_city'];?>, <?php echo $user_address_info['user_state'];?>,</td>
                  <td><?php echo $user_address_info['user_city'];?>, <?php echo $user_address_info['user_state'];?>,</td>
                </tr>
                <tr>
                  <td><?php echo $user_address_info['user_country'];?> - <?php echo $user_address_info['user_postalcode'];?></td>
                  <td><?php echo $user_address_info['user_country'];?> - <?php echo $user_address_info['user_postalcode'];?></td>
                </tr>
              </table></td>
          </tr>
          <?php
                 if($_POST['paymentmethod'])
				 {
				 ?>
          <tr>
            <td style="height:30px"></td>
          </tr>
          <tr>
            <td><table width="100%">
                <tr>
                  <td><strong><?php _e('Payment Methods'); ?></strong></td>
                </tr>
                <tr>
                  <td><?php echo $General->get_payment_method($_POST['paymentmethod']);
				/*if(file_exists( TEMPLATEPATH.'/library/payment/'.$_POST['paymentmethod'].'.php'))
				{
					include_once(TEMPLATEPATH.'/library/payment/'.$_POST['paymentmethod'].'.php');
				}
*/				?> </td>
                </tr>
              </table></td>
          </tr>
          <?php }?>
          <?php
                 if($_POST['shippingmethod'])
				 {
				 ?>
          <tr>
            <td style="height:30px"></td>
          </tr>
          <tr>
            <td><table width="100%">
                <tr>
                  <td><strong><?php _e('Shipping Methods'); ?></strong></td>
                </tr>
                <tr>
                  <td><?php echo $General->get_shipping_method($_POST['shippingmethod']);?> </td>
                </tr>
              </table></td>
          </tr>
          <?php }?>
          <tr>
            <td style="height:30px"></td>
          </tr>
          <tr>
            <td><strong><?php _e('Cart Information'); ?></strong></td>
          </tr>
          <table width="100%">
            <tr>
              <td><strong><?php _e('Product Name'); ?></strong></td>
              <td><strong><?php _e('Qty'); ?></strong></td>
              <td><strong><?php _e('Price'); ?></strong></td>
              <td><strong><?php _e('Total'); ?></strong></td>
            </tr>
            <?php
				for($i=0;$i<count($cartInfo);$i++)
				{
					$product_id = $cartInfo[$i]['product_id'];
					$product_name = $cartInfo[$i]['product_name'];
					$product_qty = $cartInfo[$i]['product_qty'];
					$product_att = $cartInfo[$i]['product_att'];
					$product_att = preg_replace('/([(])([+-])([0-9]*)([)])/','',$product_att);
					$product_price = $General->get_amount_format($cartInfo[$i]['product_gross_price'],0);
					$product_price_total = $cartInfo[$i]['product_gross_price']*$cartInfo[$i]['product_qty'];
					?>
            <tr>
              <td><?php echo $product_name;
					  if($product_att)
					  {
						echo '<br>('.$product_att .')';
					  }
					   ?> </td>
              <td><?php echo $product_qty; ?></td>
              <td><?php echo $product_price; ?></td>
              <td><?php echo $General->get_amount_format($product_price_total,0); ?></td>
            </tr>
            <?php
				}
				?>
            <tr>
              <td colspan="3" align="right"><strong>Total Amount : </strong></td>
              <td><strong><?php echo $grandTotal;?></strong></td>
            </tr>
            <?php
                 if($_POST['shippingmethod'])
				 {
				 	$grandTotal1 = $General->get_shipping_amt($_POST['shippingmethod'],$Cart->getCartAmt());
					$payableAmt = $General->get_payable_amount($_POST['shippingmethod']);
				 ?>
            <tr>
              <td colspan="3" align="right"><?php echo $General->get_shipping_method($_POST['shippingmethod']);?> Amount :</td>
              <td><?php echo $General->get_amount_format($grandTotal1);?></td>
            </tr>
            <tr>
              <td colspan="3" align="right"><strong>Final Amount : </strong></td>
              <td><strong><?php echo $General->get_amount_format($payableAmt)?></strong></td>
            </tr>
            <?php }?>
          </table>
          </td>
          </tr>
          
          <tr>
            <td style="height:30px"></td>
          </tr>
        </table>
        <br />
        <div>
          <form name="frm_payment_method" id="frm_payment_method" action="<?php echo get_option('siteurl'); ?>/?page=payment&paymentmethod=<?php echo $_POST['paymentmethod'];?>" method="post">
            <input type="button" name="button" id="submit"  class="action_button" value="<?php _e('Back'); ?>" onclick="history.back();" />
            <!--<input name="Confirm" type="button" id="submit" class="action_button" value="Confirm" onclick="document.frm_payment_method.submit();" />-->
            <?php
				foreach($_POST as $key=>$value)
				{
				?>
            <input type="hidden" name="<?php echo $key;?>" id="<?php echo $key;?>" value="<?php echo $value;?>" />
            <?php
				}
				?>
            <input name="Confirm" type="submit" id="submit" class="action_button" value="<?php _e('Confirm'); ?>" />
          </form>
        </div>
        <?php
			}else
			{
			wp_redirect(get_option('siteurl').'/?page=cart');
            }
			?>
      </div>
    </div>
    <!-- content #end -->
    <?php get_sidebar(); ?>
  </div>
  <!-- container 16-->
</div>
<!-- wrapper #end -->
<?php get_footer(); ?>
