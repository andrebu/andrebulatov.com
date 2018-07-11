<?php
global $General,$wpdb;
$userInfo = $General->getLoginUserInfo();
if($_POST)
{
	if($_REQUEST['chagepw'])
	{
		$new_passwd = $_POST['new_passwd'];
		if($new_passwd)
		{
			$user_id = $current_user->data->ID;
			wp_set_password($new_passwd, $user_id);
			$message1 = __(PW_CHANGE_SUCCESS_MSG);
		}		
	}else
	{
		$user_id = $userInfo['ID'];
		$user_add1 = stripslashes(str_replace("'","&acute;",$_POST['user_add1']));
		$user_add2 = stripslashes(str_replace("'","&acute;",$_POST['user_add2']));
		$user_city = stripslashes(str_replace("'","&acute;",$_POST['user_city']));
		$user_state = stripslashes(str_replace("'","&acute;",$_POST['user_state']));
		$user_country = stripslashes(str_replace("'","&acute;",$_POST['user_country']));
		$user_postalcode = stripslashes(str_replace("'","&acute;",$_POST['user_postalcode']));
		$user_phone = $_POST['user_phone'];
		
		$buser_add1 = stripslashes(str_replace("'","&acute;",$_POST['buser_add1']));
		$buser_add2 = stripslashes(str_replace("'","&acute;",$_POST['buser_add2']));
		$buser_city = stripslashes(str_replace("'","&acute;",$_POST['buser_city']));
		$buser_state = stripslashes(str_replace("'","&acute;",$_POST['buser_state']));
		$buser_country = stripslashes(str_replace("'","&acute;",$_POST['buser_country']));
		$buser_postalcode = stripslashes(str_replace("'","&acute;",$_POST['buser_postalcode']));
		$buser_phone = $_POST['buser_phone'];
		$user_address_info = array(
							"user_add1"		=> $user_add1,
							"user_add2"		=> $user_add2,
							"user_city"		=> $user_city,
							"user_state"	=> $user_state,
							"user_country"	=> $user_country,
							"user_postalcode"=> $user_postalcode,
							"user_phone"	=> $user_phone,
							"buser_name" 	=> stripslashes(str_replace("'","&acute;",$_POST['buser_fname'])).' '.stripslashes(str_replace("'","&acute;",$_POST['buser_lname'])),
							"buser_add1"	=> $buser_add1,
							"buser_add2"	=> $buser_add2,
							"buser_city"	=> $buser_city,
							"buser_state"	=> $buser_state,
							"buser_country"	=> $buser_country,
							"buser_postalcode"=> $buser_postalcode,
							"buser_phone"=> $buser_phone,
							);
		update_usermeta($user_id, 'user_address_info', serialize($user_address_info)); // User Address Information Here
		update_usermeta($user_id, 'first_name', $_POST['user_fname']); // User Address Information Here
		update_usermeta($user_id, 'last_name', $_POST['user_lname']); // User Address Information Here
		$userName = $_POST['user_fname'].'  '.$_POST['user_lname'];
		$updateUsersql = "update $wpdb->users set user_nicename=\"$userName\", display_name=\"$userName\"  where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
		$message = "Information Updated successfully.";
	}
}
$userInfo = $General->getLoginUserInfo();
$user_address_info = unserialize(get_user_option('user_address_info', $user_id));
$user_add1 = $user_address_info['user_add1'];
$user_add2 = $user_address_info['user_add2'];
$user_city = $user_address_info['user_city'];
$user_state = $user_address_info['user_state'];
$user_country = $user_address_info['user_country'];
$user_postalcode = $user_address_info['user_postalcode'];
$user_phone = $user_address_info['user_phone'];
$buser_phone = $user_address_info['buser_phone'];
$display_name = $userInfo['display_name'];
$display_name_arr = explode(' ',$display_name);
$user_fname = $display_name_arr[0];
$user_lname = $display_name_arr[2];
$buser_add1 = $user_address_info['buser_add1'];
$buser_add2 = $user_address_info['buser_add2'];
$buser_city = $user_address_info['buser_city'];
$buser_state = $user_address_info['buser_state'];
$buser_country = $user_address_info['buser_country'];
$buser_postalcode = $user_address_info['buser_postalcode'];
$bdisplay_name = $user_address_info['buser_name'];
$display_name_arr = explode(' ',$bdisplay_name);
$buser_fname = $display_name_arr[0];
$buser_lname = $display_name_arr[2];

if($_SESSION['redirect_page'] == '')
{
	$_SESSION['redirect_page'] = $_SERVER['HTTP_REFERER'];
}
if(strstr($_SESSION['redirect_page'],'page=checkout'))
{
	$login_redirect_link = $General->get_ssl_normal_url(get_option('siteurl')).'/?page=checkout';
}
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
<h3><?php _e(CHANGE_PW_TEXT); ?></h3>
<form name="registerform" id="registerform" action="<?php echo get_option( 'siteurl' ).'/?page=myaccount&type=editprofile&chagepw=1'; ?>" method="post">
<?php if($message1) { ?>
  <div class="sucess_msg"> <?php _e(PW_CHANGE_SUCCESS_MSG); ?> </div>
  </td>
  <?php } ?>
<div class="myorders ">
     <div class="myorders_col myorders_col_2 fl">
        <div class="myorder_form_row ">
        <label>
        <?php _e(NEW_PW_TEXT); ?> <span class="indicates">*</span>
        <input type="password" name="new_passwd" id="new_passwd"  class="myorder_text" />
        </label>        
        </div>
        <div class="myorder_form_row ">
        <label>
        <?php _e(CONFIRM_NEW_PW_TEXT); ?> <span class="indicates">*</span>
        <input type="password" name="cnew_passwd" id="cnew_passwd"  class="myorder_text" />
          <input type="submit" name="Update" value="<?php _e(UPDATE_BUTTON_TEXT) ?>" class="highlight_input_btn fr" onclick="return chk_form_pw();" />
        
        </label>
        
         </div>
       
    </div>
</div>
</form>
<script language="javascript" type="application/javascript">
function chk_form_pw()
{
	if(document.getElementById('new_passwd').value == '')
	{
		alert("<?php _e(ENTER_NW_PW_JS_MSG) ?>");
		document.getElementById('new_passwd').focus();
		return false;
	}
	if(document.getElementById('new_passwd').value.length < 4 )
	{
		alert("<?php _e(ENTER_NW_PW_MIN_JS_MSG) ?>");
		document.getElementById('new_passwd').focus();
		return false;
	}
	if(document.getElementById('cnew_passwd').value == '')
	{
		alert("<?php _e(ENTER_CONFIRMNW_PW_JS_MSG) ?>");
		document.getElementById('cnew_passwd').focus();
		return false;
	}
	if(document.getElementById('cnew_passwd').value.length < 4 )
	{
		alert("<?php _e(ENTER_CONFIRMNW_PW_MIN_JS_MSG) ?>");
		document.getElementById('cnew_passwd').focus();
		return false;
	}
	if(document.getElementById('new_passwd').value != document.getElementById('cnew_passwd').value)
	{
		alert("<?php _e(ENTER_NW_AND_CONFIRM_PW_SAME_JS_MSG) ?>");
		document.getElementById('cnew_passwd').focus();
		return false;
	}
}
</script>


<h3><?php _e('Personal Information'); ?> 
<?php
if($login_redirect_link){
?>
<input type="button" name="<?php _e(CHECKOUT_TEXT);?>" value="<?php _e(CHECKOUT_TEXT);?>" onclick="window.location.href='<?php echo $login_redirect_link;?>'"  class="highlight_input_btn fr" />
<?php }?>
</h3>
<form name="registerform" id="registerform" action="<?php echo get_option( 'siteurl' ).'/?page=myaccount&type=editprofile'; ?>" method="post">
  <?php if($message) { ?>
  <div class="sucess_msg"> <?php _e(MYACC_INFO_UPDATE_MSG); ?> </div>
  </td>
  <?php } ?>
  <div class="myorders ">
    <div class="myorders_col fl">
      <h5><?php _e(USER_INFO_TEXT); ?> </h5>
     
      <div class="myorder_form_row ">
        <label>
        <?php _e(FIRST_NAME_TEXT) ?> <span class="indicates">*</span>
        </label>
        <input type="text" name="user_fname" id="user_fname" class="myorder_text" value="<?php echo esc_attr(stripslashes($user_fname)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(LAST_NAME_TEXT) ?>
        </label>
        <input type="text" name="user_lname" id="user_lname" class="myorder_text" value="<?php echo esc_attr(stripslashes($user_lname)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(ADDRESS1_TEXT) ?> <?php echo $bill_address1;?>
        </label>
        <input type="text" name="user_add1" id="user_add1" class="myorder_text" value="<?php echo esc_attr(stripslashes($user_add1)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(ADDRESS2_TEXT) ?><?php echo $bill_address2;?>
        </label>
        <input type="text" name="user_add2" id="user_add2" class="myorder_text" value="<?php echo esc_attr(stripslashes($user_add2)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(CITY_TEXT) ?><?php echo $bill_city;?>
        </label>
        <input type="text" name="user_city" id="user_city" class="myorder_text" value="<?php echo esc_attr(stripslashes($user_city)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(STATE_TEXT) ?><?php echo $bill_state;?>
        </label>
        <input type="text" name="user_state" id="user_state" class="myorder_text" value="<?php echo esc_attr(stripslashes($user_state)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(COUNTRY_TEXT) ?><?php echo $bill_country;?>
        </label>
        <input type="text" name="user_country" id="user_country" class="myorder_text" value="<?php echo esc_attr(stripslashes($user_country)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(POSTAL_CODE_TEXT) ?><?php echo $bill_zip;?>
        </label>
        <input type="text" name="user_postalcode" id="user_postalcode" class="myorder_text" value="<?php echo esc_attr(stripslashes($user_postalcode)); ?>" size="25" tabindex="20" />
      </div>
       <div class="myorder_form_row ">
        <label>
        <?php  _e(PHONE_NUMBER_TEXT); ?> <?php echo $bill_phone;?>
        </label>
        <input type="text" name="user_phone" id="user_phone" class="myorder_text" value="<?php echo esc_attr(stripslashes($user_phone)); ?>" size="25" tabindex="20" />
      </div>
    </div>
    <!-- my order col_1 End -->
    <?php
    if(!$General->is_storetype_digital())
	{
	?>
    <div class="myorders_col fr">
      <h5><?php _e(SHIPPING_INFO_TEXT) ?></h5>
      <div class="myorder_form_row ">
      <p><input type="checkbox" class="checkin" name="copybilladd" id="copybilladd" onClick="copy_billing_address();" > same as Billing Address</p>
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(FIRST_NAME_TEXT) ?>
        </label>
        <input type="text" name="buser_fname" id="buser_fname" class="myorder_text" value="<?php echo esc_attr(stripslashes($buser_fname)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(LAST_NAME_TEXT) ?>
        </label>
        <input type="text" name="buser_lname" id="buser_lname" class="myorder_text" value="<?php echo esc_attr(stripslashes($buser_lname)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(ADDRESS1_TEXT) ?>
        </label>
        <input type="text" name="buser_add1" id="buser_add1" class="myorder_text" value="<?php echo esc_attr(stripslashes($buser_add1)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(ADDRESS2_TEXT) ?>
        </label>
        <input type="text" name="buser_add2" id="buser_add2" class="myorder_text" value="<?php echo esc_attr(stripslashes($buser_add2)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(CITY_TEXT) ?>
        </label>
        <input type="text" name="buser_city" id="buser_city" class="myorder_text" value="<?php echo esc_attr(stripslashes($buser_city)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(STATE_TEXT) ?>
        </label>
        <input type="text" name="buser_state" id="buser_state" class="myorder_text" value="<?php echo esc_attr(stripslashes($buser_state)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(COUNTRY_TEXT) ?>
        </label>
        <input type="text" name="buser_country" id="buser_country" class="myorder_text" value="<?php echo esc_attr(stripslashes($buser_country)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php _e(POSTAL_CODE_TEXT) ?>
        </label>
        <input type="text" name="buser_postalcode" id="buser_postalcode" class="myorder_text" value="<?php echo esc_attr(stripslashes($buser_postalcode)); ?>" size="25" tabindex="20" />
      </div>
      <div class="myorder_form_row ">
        <label>
        <?php  _e(PHONE_NUMBER_TEXT); ?>
        </label>
        <input type="text" name="buser_phone" id="buser_phone" class="myorder_text" value="<?php echo esc_attr(stripslashes($buser_phone)); ?>" size="25" tabindex="20" />
      </div>
    </div>
    <?php
    }
	?>
    <!-- my order col_1 End -->
  </div>
<!--  <a  href="javascript:void(0);" onclick="document.registerform.submit();" class="highlight_button fr " >Update</a>-->
  <?php
  if($login_redirect_link)
  {
  ?>
  <input type="button" name="<?php _e(CHECKOUT_TEXT);?>" value="<?php _e(CHECKOUT_TEXT);?>" onclick="window.location.href='<?php echo $login_redirect_link;?>'"  class="highlight_input_btn fl" />
  <?php }?>
  <input type="submit" name="Update" value="<?php _e('Update') ?>" class="highlight_input_btn fr" onclick="return chk_form_profile();" />
</form>
        <script  type="text/javascript" >
function chk_form_profile()
{
	if(document.getElementById('user_fname').value == '')
	{
		alert("<?php _e(ENTER_FSTNAME_JS_MSG); ?>");
		document.getElementById('user_fname').focus();
		return false;
	}
	<?php
	if($mandotary_info['bill_address1'])
	{
	?>
		if(document.getElementById('user_add1').value=='')
		{
			alert('<?php _e(ENTER_ADDRESS1_JS_MSG) ?>');
			document.getElementById('user_add1').focus();
			return false;
		}
	<?php
	}
	?>
	<?php
	if($mandotary_info['bill_address2'])
	{
	?>
		if(document.getElementById('user_add2').value=='')
		{
			alert('<?php _e(ENTER_ADDRESS2_JS_MSG); ?>');
			document.getElementById('user_add2').focus();
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
			alert('<?php _e(ENTER_CITY_JS_MSG) ?>');
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
			alert('<?php _e(ENTER_STATE_JS_MSG) ?>');
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
			alert('<?php _e(ENTER_COUNTRY_JS_MSG) ?>');
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
			alert('<?php _e(ENTER_ZIPCODE_JS_MSG) ?>');
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
	document.registerform.submit();
}
function copy_billing_address()
{
	if(document.getElementById('copybilladd').checked)
	{
		
		document.getElementById('buser_fname').value = document.getElementById('user_fname').value;
		document.getElementById('buser_lname').value = document.getElementById('user_lname').value;
		document.getElementById('buser_add1').value = document.getElementById('user_add1').value;
		document.getElementById('buser_add2').value = document.getElementById('user_add2').value;
		document.getElementById('buser_city').value = document.getElementById('user_city').value;
		document.getElementById('buser_state').value = document.getElementById('user_state').value;
		document.getElementById('buser_country').value = document.getElementById('user_country').value;
		document.getElementById('buser_postalcode').value = document.getElementById('user_postalcode').value;
		document.getElementById('buser_phone').value = document.getElementById('user_phone').value;
	}else
	{
		document.getElementById('buser_fname').value = '';
		document.getElementById('buser_lname').value = '';
		document.getElementById('buser_add1').value = '';
		document.getElementById('buser_add2').value = '';
		document.getElementById('buser_city').value = '';
		document.getElementById('buser_state').value = '';
		document.getElementById('buser_country').value = '';
		document.getElementById('buser_postalcode').value = '';
		document.getElementById('buser_phone').value = '';
	}
}
</script>