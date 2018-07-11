<?php get_header(); ?>
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			<h2><?php _e(SINGLE_CHEKCOUT_PAGE_TITLE); ?></h2>
             <div class="breadcrumb clearfix">
			<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; '.__(SINGLE_CHEKCOUT_PAGE_TITLE)); } ?>
             </div>
		</div>
	</div>
</div>

<div class="wrapper" >
  <div class="container_16 clearfix">
    <div id="content" class="container_16" >
    
 		 <div class="content_spacer">
        <?php
            if($itemsInCartCount>0)
			{
			?>
        <form method="post" name="checkout_frm" id="checkout_frm" action="<?php echo $General->get_ssl_normal_url(get_option('siteurl')); ?>/?page=payment&paymentmethod=<?php echo $_SESSION['paymentmethod'];?>">
          <input type="hidden" name="coupon_code" value="<?php echo $_SESSION['couponcode'];?>" />
          <input type="hidden" name="coupon_code" value="<?php echo $_SESSION['couponcode'];?>" />
          <?php if($_GET['msg']=='nopaymethod'){ _e("<div style='color:red'>Select Payment method to continue.</div><br>");}?>
          <?php
                if(isset($_SESSION['display_message']) && $_SESSION['display_message']!='')
				{
					echo '<p style="color:#FF0000">'.$_SESSION['display_message']."<p>";
					$_SESSION['display_message'] = '';
				?>
          <?php }?>
          <div id="checkout_content">
          <?php
               	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
				$paymentinfo = $wpdb->get_results($paymentsql);
				if($paymentinfo)
				{
				?>
          <h3 class="shipping_cart"> <?php _e('Select Payment Method'); ?></h3>
          <table width="100%" class="table ">
            <?php
                	$paymentOptionArray = array();
					$paymethodKeyarray = array();
					foreach($paymentinfo as $paymentinfoObj)
					{
						$paymentInfo = unserialize($paymentinfoObj->option_value);
						if($paymentInfo['isactive'])
						{
							$paymethodKeyarray[] = $paymentInfo['key'];
							$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
						}
					}
					ksort($paymentOptionArray);
					foreach($paymentOptionArray as $key=>$paymentInfoval)
					{
						for($i=0;$i<count($paymentInfoval);$i++)
						{
							$paymentInfo = $paymentInfoval[$i];
							$jsfunction = 'onclick="showoptions(this.value);"';
							$chked = '';
							if($key==1)
							{
								$chked = 'checked="checked"';
							}
						?>
            <tr>
              <td width="1%"  align="center" class="row3" id="<?php echo $paymentInfo['key'];?>"><input <?php echo $jsfunction;?>  type="radio" value="<?php echo $paymentInfo['key'];?>" id="<?php echo $paymentInfo['key'];?>_id" name="paymentmethod" <?php echo $chked;?> /></td>
              <td class="row3"><?php echo $paymentInfo['name']?></td>
              <?php
							if(file_exists(TEMPLATEPATH.'/library/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php'))
							{
							?>
              <?php
								include_once(TEMPLATEPATH.'/library/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php');
								?>
              <?php
							}
						 ?>
              <?php
						}
					}
					
				?>
            <tr>
              <td  align="center" >&nbsp;</td>
              <td >&nbsp;</td>
          </table>
          <?php
               	}
				?>
          <h3 class="shipping_cart"> <?php _e(YOUR_SELECTION_TEXT); ?> </h3>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table_spacer">
            <tr>
              <td width="60%" class="title"><?php _e(PRODUCT_NAME_TEXT); ?></td>
              <td width="10%" align="center" class="title"><?php _e(QTY_TEXT); ?></td>
              <td width="15%" align="center" class="title"><?php _e(PRICE_TEXT); ?></td>
              <td width="15%" align="center" class="title"><?php _e(TOTAL_TEXT); ?></td>
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
              <td class="row1 " ><?php echo $product_name;
				  if($product_att)
				  {
				  	echo '<br>('.$product_att .')';
                  }
				   ?> </td>
              <td align="center" class="row1 " ><?php echo $product_qty; ?></td>
              <td class="row1 tprice"  ><?php echo $product_price; ?></td>
              <td class="row1 tprice" ><?php echo $General->get_amount_format($product_price_total,0); ?></td>
            </tr>
            <?php
				}
				?>
            <tr>
              <td colspan="3" align="right"  ><?php _e(SUB_TOTAL_AMOUNT_TEXT); ?> : </td>
              <td class=" tprice"><?php echo $grandTotal;?></td>
            </tr>
            <?php
                if($_SESSION['couponcode']){
				?>
            <tr>
              <td colspan="3" align="right"   ><?php _e(DISCOUNT_AMOUNT_TEXT); ?>
                <?php //echo $discount_info['couponcode'];?>
                <?php if($discount_info['dis_per']=='per'){echo '('.$discount_info['dis_amt'].'%)';}?>
                : </td>
              <td class=" tprice" ><?php echo $discount_amt;?></td>
            </tr>
            <?php }?>
            <?php if($taxable_amt>0){?>
            <tr>
              <td colspan="3" align="right" ><?php _e(TAX_AMOUNT_TEXT); ?> (<?php echo $product_tax;?>%) : </td>
              <td class=" tprice"><?php echo  $General->get_amount_format($taxable_amt); ?></td>
            </tr>
            <?php }?>
            <?php
                $grandTotal1 = $General->get_shipping_amt($_SESSION['shippingmethod'],$Cart->getCartAmt());
				$payableAmt = $General->get_payable_amount($_SESSION['shippingmethod']);
				 if($_SESSION['shippingmethod'] && $grandTotal1>0)
				 {
				 ?>
            <tr>
              <td colspan="3" align="right"   ><?php echo __($General->get_shipping_method($_POST['shippingmethod'])).' '. __('Amount');?> :</td>
              <td class=" tprice"><?php echo $General->get_amount_format($grandTotal1);?></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="3" align="right" class="row2"  ><strong><?php _e(FINAL_AMOUNT_TEXT); ?> : </strong></td>
              <td class="total_price "><strong><?php echo $General->get_amount_format($payableAmt)?></strong></td>
            </tr>
          </table>
          
      </div>
      <div id="checkout_sidebar">
        <?php
                 if($_SESSION['shippingmethod'])
				 {
				 ?>
        <div class="shipping_method">
          <p> <strong> <?php _e(SHIPPING_MEHTOD_TEXT); ?> : </strong> <br />
            <span class="method"> <?php echo $General->get_shipping_method($_SESSION['shippingmethod']);?> </span> </p>
        </div>
        <?php }?>
        <?php include_once(TEMPLATEPATH . '/library/includes/checkout_userinfo.php');  //checkout type single page?>
        <!-- checkout Address -->
        <div class="payment_method"><img src="<?php bloginfo('template_directory'); ?>/images/payment_method.png" alt=""   /> </div>
      </div>
    </div>
        
 	  <?php
          if($General->is_show_term_conditions())
		  {
		  ?>
         <div class="terms_condition clearfix">
          <input type="checkbox" name="termsandconditions" id="termsandconditions" class="checkin2" />&nbsp;
         <?php
          if($General->get_term_conditions_statement()!='')
		  {
		  	echo $General->get_term_conditions_statement();
		  }else
		  {
		  	_e(CHECKOUT_TERMS_CONDITIONS_MSG);
		  }
		  ?>
          </div>
          <?php
          }
		  ?>
          <div class="button_bar" >
            <input type="hidden" name="shippingmethod" id="shippingmethod" value="<?php echo $_SESSION['shippingmethod'];?>" />
           <a  href="javascript:void(0);" onclick="history.back();" class="normal_input_btn fl"><?php _e('&laquo; '.BACK_BUTTON); ?>&nbsp;</a> 
             <input type="submit" name="confirm" value="<?php _e(CONFIRM_BUTTON); ?> &raquo;" class="highlight_input_btn fr" onClick="return check_user_info();" />
            <!--<a  href="javascript:void(0);" onclick="document.checkout_frm.submit();" class="highlight_button  fr" >Confirm &raquo;</a>--> </div>
        </form>
        <?php
			}else
			{
			wp_redirect(get_option('siteurl').'/?page=cart');
            }
			?>                  
  			<!--  </div>  content #end -->
 		 
  </div> <!-- page #end -->
 <?php get_sidebar(); ?>
<!-- wrapper #end -->
<script>
function accepttermandconditions()
{
	<?php
	if($General->is_show_term_conditions())
	{
	?>
	if(document.getElementById('termsandconditions').checked)
	{
		return true;
	}else
	{
		alert('<?php _e('Please accept the terms and conditions');?>');
		document.getElementById('termsandconditions').focus();
		return false;
	}
	<?php
	}
	?>
	return true;
}
function check_user_info()
{
	<?php
	if(!$userInfo)
	{
	?>
	if(document.getElementById('user_fname').value=='')
	{
		alert('Please enter Name');
		document.getElementById('user_fname').focus();
		return false;
	}
	if(document.getElementById('user_email').value=='')
	{
		alert('Please enter Email');
		document.getElementById('user_email').focus();
		return false;
	}else
	{
		if(!checkemail(document.getElementById('user_email').value))
		{
			document.getElementById('user_email').focus();
			return false;
		}
	}
	if(!chk_form_reg())
	{
		return false;
	}
	<?php
		if($General->is_show_term_conditions())
		{
	?>
		if(!accepttermandconditions())
		{
			return false;
		}
		return true;
	<?php
		}
	}else
	?>
	return true;
	<?php
	?>
}
function chk_form_reg()
{
	<?php
	if($mandotary_info['bill_address1'])
	{
	?>
		if(document.getElementById('user_add1').value=='')
		{
			alert('<?php _e('Please enter Address') ?>');
			document.getElementById('user_add1').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_city'])
	{
	?>
		if(document.getElementById('user_city').value=='')
		{
			alert('<?php _e('Please enter City') ?>');
			document.getElementById('user_city').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_state'])
	{
	?>
		if(document.getElementById('user_state').value=='')
		{
			alert('<?php _e('Please enter State') ?>');
			document.getElementById('user_state').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_country'])
	{
	?>
		if(document.getElementById('user_country').value=='')
		{
			alert('Please enter <?php _e('Country') ?>');
			document.getElementById('user_country').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_zip'])
	{
	?>
		if(document.getElementById('user_postalcode').value=='')
		{
			alert('<?php _e('Please enter Postal Code') ?>');
			document.getElementById('user_postalcode').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_phone'])
	{
	?>
		if(document.getElementById('user_phone').value=='')
		{
			alert('Please enter <?php _e(PHONE_NUMBER_TEXT) ?>');
			document.getElementById('user_phone').focus();
			return false;
		}
	<?php
	}
	?>
	return true;
}
function checkemail(str)
{
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(str))
	{
		return true;
	}
	else
	{
		alert("Please enter valid email")
		return false;
	}
}
</script>

<script>
function checkbae(){
if (document.layers||document.getElementById||document.all)
return checkemail()
else
return true
}

function showoptions(paymethod)
{
	<?php
	for($i=0;$i<count($paymethodKeyarray);$i++)
	{
	?>
	showoptvar = '<?php echo $paymethodKeyarray[$i]?>options';
	if(eval(document.getElementById(showoptvar)))
	{
		document.getElementById(showoptvar).style.display = 'none';
		if(paymethod=='<?php echo $paymethodKeyarray[$i]?>')
		{
			document.getElementById(showoptvar).style.display = '';
		}
	}
	
	<?php
	}	
	?>
}
<?php
for($i=0;$i<count($paymethodKeyarray);$i++)
{
?>
if(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').checked)
{
	showoptions(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').value);
}
<?php
}	
?>
</script>
<?php get_footer(); ?>