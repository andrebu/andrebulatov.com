<?php
$chekcout_method = $General->get_checkout_method();

if($userInfo) //simple checkout
{
?>
<div class="checkout_address">
  <div class="address_info fl">
    <h3><?php _e('Billing Address'); ?> </h3>
    <div class="address_row"> <b><?php echo $userInfo['display_name'];?></b></div>
    <div class="address_row"><?php echo $user_address_info['user_add1'];?></div>
    <div class="address_row"><?php echo $user_address_info['user_add2'];?></div>
    <div class="address_row"><?php echo $user_address_info['user_city'];?>, <?php echo $user_address_info['user_state'];?>,</div>
    <div class="address_row"><?php echo $user_address_info['user_country'];?> - <?php echo $user_address_info['user_postalcode'];?></div>
    <?php if($user_address_info['user_phone']!='' ){?> <div class="address_row"><?php _e(PHONE_NUMBER_TEXT);?> : <?php echo $user_address_info['user_phone'];?></div>  <?php }?>
  </div>
  <div class="address_info fr">
    <h3><?php _e('Shipping Address'); ?> <span>(<a href="<?php echo get_option('siteurl'); ?>/?page=myaccount&type=editprofile"><u><?php _e('Edit'); ?></u></a>)</span> </h3>
    <div class="address_row"> <b><?php echo $user_address_info['buser_name'];?></b></div>
    <div class="address_row"><?php echo $user_address_info['buser_add1'];?> </div>
    <div class="address_row"><?php echo $user_address_info['buser_add2'];?></div>
    <div class="address_row"><?php echo $user_address_info['buser_city'];?>, <?php echo $user_address_info['buser_state'];?>, </div>
    <div class="address_row"><?php echo $user_address_info['buser_country'];?> - <?php echo $user_address_info['buser_postalcode'];?></div>
     <?php if($user_address_info['user_phone']!='' && $user_address_info['buser_phone']==''){?> <div class="address_row"><?php _e(PHONE_NUMBER_TEXT);?> : <?php echo $user_address_info['user_phone'];?></div>  <?php }elseif($user_address_info['buser_phone']!=''){?><div class="address_row"><?php _e(PHONE_NUMBER_TEXT);?> : <?php echo $user_address_info['buser_phone'];?></div><?php }?>
  </div>
</div>
<?php
}else  //single page checkout
{
?>
<div class="checkout_address">
<div class=" address_info3 ">
 <div class="address_row2"><label><?php _e('Your Name');?> <span class="indicates">*</span></label> <input type="text" name="user_fname" id="user_fname" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($user_fname)); ?>" size="25"  /></div>
 
 
    <div class="address_row2 address_row2_spacer"><label><?php _e('Email');?> <span class="indicates">*</span></label> <input type="text" name="user_email" id="user_email" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" /></div>
  
   <?php
    if(!$General->is_storetype_digital())
	{
	?>
<?php
$mandotary_info = $General->get_userinfo_mandatory_fields();
if($mandotary_info['bill_address1'])
{
	$bill_address1 = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_address2'])
{
	$bill_address2 = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_city'])
{
	$bill_city = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_state'])
{
	$bill_state = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_country'])
{
	$bill_country = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_zip'])
{
	$bill_zip = ' <span class="indicates">*</span>';
}
if($mandotary_info['bill_phone'])
{
	$bill_phone = ' <span class="indicates">*</span>';
}
?>
    <h3><?php _e(BILLING_ADDRESS_TEXT);?></h3>
    <div class="address_row2"><label><?php _e(ADDRESS_TEXT);?> <?php echo $bill_address1;?> </label><input type="text" name="user_add1" id="user_add1" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($user_add1)); ?>" size="25" /></div>
    <div class="address_row2"><label><?php _e(CITY_TEXT);?> <?php echo $bill_city;?></label><input type="text" name="user_city" id="user_city" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($user_city)); ?>" size="25" /></div>
    <div class="address_row2"><label><?php _e(STATE_TEXT);?> <?php echo $bill_state;?></label> <input type="text" name="user_state" id="user_state" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($user_state)); ?>" size="25" /></div>
    <div class="address_row2"><label><?php _e(COUNTRY_TEXT);?> <?php echo $bill_country;?> </label>  <input type="text" name="user_country" id="user_country" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($user_country)); ?>" size="25" /></div>
    <div class="address_row2"><label><?php _e(POSTAL_CODE_TEXT);?> <?php echo $bill_zip;?></label> <input type="text" name="user_postalcode" id="user_postalcode" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($user_postalcode)); ?>" size="25" /></div>
    <div class="address_row2 address_row2_spacer"><label><?php  _e(PHONE_NUMBER_TEXT); ?>  <?php echo $bill_phone;?></label> <input type="text" name="user_phone" id="user_phone" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($user_phone)); ?>" size="25" /></div>
    
    

  
  
   
   <h3><?php _e(SHIPPING_ADDRESS_TEXT);?></h3> 
   
     <div class="address_row2 same_as_address_spacer"> <input type="checkbox" class="checkin" name="copybilladd" id="copybilladd" onclick="copy_billing_address();" > <span class="fl same_address"> same as Billing Address</span></div>
   <div class="address_row2"><label><?php _e(ADDRESS_TEXT);?> </label><input type="text" name="buser_add1" id="buser_add1" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($buser_add1)); ?>" size="25" /></div>
    <div class="address_row2"><label><?php _e(CITY_TEXT);?> </label><input type="text" name="buser_city" id="buser_city" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($buser_city)); ?>" size="25" /></div>
    <div class="address_row2"><label><?php _e(STATE_TEXT);?> </label><input type="text" name="buser_state" id="buser_state" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($buser_state)); ?>" size="25" /></div>
    <div class="address_row2"><label><?php _e(COUNTRY_TEXT);?></label>  <input type="text" name="buser_country" id="buser_country" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($buser_country)); ?>" size="25" /></div>
    <div class="address_row2"><label><?php _e(POSTAL_CODE_TEXT);?></label> <input type="text" name="buser_postalcode" id="buser_postalcode" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($buser_postalcode)); ?>" size="25" /></div> 
 <div class="address_row2"><label><?php  _e(PHONE_NUMBER_TEXT); ?></label>  <input type="text" name="buser_phone" id="buser_phone" class="reg_row_textfield2" value="<?php echo esc_attr(stripslashes($buser_phone)); ?>" size="25" /></div>
  
  </div>
     
 
    
    <?php
	}
	?>
 </div>
<script language="javascript" language="javascript">
function copy_billing_address()
{
	
	if(document.getElementById('copybilladd').checked)
	{
		document.getElementById('buser_add1').value = document.getElementById('user_add1').value;
		document.getElementById('buser_city').value = document.getElementById('user_city').value;
		document.getElementById('buser_state').value = document.getElementById('user_state').value;
		document.getElementById('buser_country').value = document.getElementById('user_country').value;
		document.getElementById('buser_postalcode').value = document.getElementById('user_postalcode').value;
		document.getElementById('buser_phone').value = document.getElementById('user_phone').value;
	}else
	{
		document.getElementById('buser_add1').value = '';
		document.getElementById('buser_city').value = '';
		document.getElementById('buser_state').value = '';
		document.getElementById('buser_country').value = '';
		document.getElementById('buser_postalcode').value = '';
		document.getElementById('buser_phone').value = '';
	}
}
</script>
<?php
}
?>