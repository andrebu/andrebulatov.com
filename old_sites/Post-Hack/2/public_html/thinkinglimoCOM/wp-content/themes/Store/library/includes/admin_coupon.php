<?php
global $wpdb;
if($_POST['couponact'] == 'addcoupon')
{
	$couponcode = $_POST['couponcode'];
	$coupondisc = $_POST['coupondisc'];
	$couponamt = $_POST['couponamt'];
	if($couponcode)
	{
		$discount_coupons['couponcode'] = $couponcode;
		$discount_coupons['dis_per'] = $coupondisc;
		$discount_coupons['dis_amt'] = $couponamt;
		
		$option_value = get_option('discount_coupons');
		if($option_value)
		{
			if($_POST['code'] != '')
			{
				$option_value[$_POST['code']]  = $discount_coupons;
			}else
			{
				for($i=0;$i<count($option_value);$i++)
				{
					if($option_value[$i]['couponcode'] == $couponcode)
					{
						$location = get_option('siteurl')."/wp-admin/admin.php?page=managecoupon&pagetype=addedit&msg=exist";
						wp_redirect($location);exit;
					}
				}
				$option_value[]  = $discount_coupons;
			}			
			$option_value_str = $option_value;
			update_option('discount_coupons',$option_value_str);
		}else
		{
			$option_value[] = $discount_coupons;
			$option_value_str = $option_value;
			update_option('discount_coupons',$option_value_str);
		}
		$location = get_option('siteurl')."/wp-admin/admin.php?page=managecoupon&msg=success";
		wp_redirect($location);
		exit;
	}
}
if($_REQUEST['code']!='')
{
	$option_value = get_option('discount_coupons');
	$coupon = $option_value[$_REQUEST['code']];
}
?>

<form action="<?php echo get_option('siteurl')?>/wp-admin/admin.php?page=managecoupon&pagetype=addedit&code=<?php echo $_REQUEST['code'];?>" method="post" name="coupon_frm">
  <input type="hidden" name="couponact" value="addcoupon">
  <input type="hidden" name="code" value="<?php echo $_REQUEST['code'];?>">
  <style>
h2 { color:#464646;font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
font-size:24px;
font-size-adjust:none;
font-stretch:normal;
font-style:italic;
font-variant:normal;
font-weight:normal;
line-height:35px;
margin:0;
padding:14px 15px 3px 0;
text-shadow:0 1px 0 #FFFFFF;  }
</style>
  <h2>
    <?php
if($_REQUEST['code']!='')
{
	_e('Edit Coupon');
}else
{
	_e('Add Coupon');
}
?>
  </h2>
  <?php if($_REQUEST['msg']=='exist'){?>
  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
    <p><?php _e('Coupon code already exists, Please user different one.');?></p>
  </div>
  <?php }?>
  <table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="14%"><?php _e('Coupon Code');?></td>
      <td width="86%">:
        <input type="text" name="couponcode" value="<?php echo $coupon['couponcode']?>"></td>
    </tr>
    <tr>
      <td><?php _e('Discount Type');?></td>
      <td>:
        <input type="radio" id="coupondiscper" name="coupondisc" value="per" <?php if($coupon['dis_per'] == 'per' || $coupon['dis_per']==''){?>checked="checked"<?php }?> />
        <?php _e('Percentage');?>(%)&nbsp;&nbsp;
        <!--<input type="text" name="coupondisc" value="">
--></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>:
        <input type="radio" id="coupondiscamt" name="coupondisc" <?php if($coupon['dis_per'] == 'amt'){?> checked="checked"<?php }?> value="amt" />
        <?php _e('Amount');?>&nbsp;&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>:
        <input type="text" name="couponamt" id="couponamt" value="<?php echo $coupon['dis_amt']?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="<?php _e('Submit');?>" onclick="return check_frm();" class="button-secondary action" >
        &nbsp;
        <input type="button" name="cancel" value="<?php _e('Cancel');?>" onClick="window.location.href='<?php echo get_option('siteurl')?>/wp-admin/admin.php?page=managecoupon'" class="button-secondary action" ></td>
    </tr>
  </table>
</form>
<script>
function check_frm()
{
	if(document.getElementById('coupondiscper').checked)
	{
		if(document.getElementById('couponamt').value > 100)
		{
			alert("<?php _e('Percentage should be less than or equal to 100');?>");
			return false;
		}
	}
	return true;
}
</script>
