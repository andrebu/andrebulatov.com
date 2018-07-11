<?php
global $wpdb;
if($_REQUEST['user_id']=='')
{
	if($_POST && $_POST['setsetting'])
	{
	$affiliate_settings = array(
						"is_active_affiliate"		=> $_POST['is_active_affiliate'],
						"aff_share_amt"				=> $_POST['aff_share_amt'],
						"affiliate_cookie_lifetime"	=> $_POST['affiliate_cookie_lifetime'],
						"affiliate_login_content_top"	=> $_POST['affiliate_login_content_top'],
						"affiliate_login_content_bottom"	=> $_POST['affiliate_login_content_bottom'],
						"affiliate_terms_conditions"	=> $_POST['affiliate_terms_conditions'],					
						);
	update_option('affiliate_settings', $affiliate_settings);
	$message = "Settings Updated successfully";
	}
	$affiliate_settings = get_option('affiliate_settings');
	$is_active_affiliate = $affiliate_settings['is_active_affiliate'];
	$aff_share_amt = $affiliate_settings['aff_share_amt'];
	$affiliate_cookie_lifetime = $affiliate_settings['affiliate_cookie_lifetime'];
	$affiliate_login_content_top = $affiliate_settings['affiliate_login_content_top'];
	$affiliate_login_content_bottom = $affiliate_settings['affiliate_login_content_bottom'];
	$affiliate_terms_conditions = $affiliate_settings['affiliate_terms_conditions'];
	
	
	?>
	<form action="<?php echo get_option( 'siteurl' );?>/wp-admin/admin.php?page=affiliates_settings" method="post">
    <input type="hidden" name="setsetting" value="1" />
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
	<h2><?php _e('Affiliate Settings'); ?></h2>
	<?php if($message){?>
	<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
	<p><?php echo $message;?> </p>
	</div>
	<?php }?>
	<table width="80%" cellpadding="5" class="widefat post fixed" >
	<thead>
	  <tr>
		<td><?php _e(AFF_MODULE_ACTIVE_TITLE); ?></td>
		<td>
         <select name="is_active_affiliate">
            <option value="0" <?php if($is_active_affiliate=='0'){?> selected="selected"<?php }?>>No</option>
            <option value="1" <?php if($is_active_affiliate==1){?> selected="selected"<?php }?>>Yes</option>
          </select>  
		</td>
	  </tr>
      <tr>
		<td><?php _e(AFF_REG_LINK_TITLE); ?></td>
		<td><b><?php echo get_option('siteurl');?>/?page=affiliate&type=reg</b>
		</td>
	  </tr>
	  <tr>
		<td><?php _e(AFF_SIGNIN_LINK_TITLE); ?></td>
		<td><b><?php echo get_option('siteurl');?>/?page=affiliate</b>
		</td>
	  </tr>
	  <tr>
		<td><?php _e(SHARE_AMT_TITLE); ?>(%)<br><?php _e(SHARE_AMT_TITLE_DESC); ?></td>
		<td><input type="text" name="aff_share_amt" value="<?php echo $aff_share_amt;?>" />
		</td>
	  </tr>
	  <tr>
		<td><?php _e(SHARE_COOKIES_ALIVE_TITLE); ?><br><?php _e(SHARE_COOKIES_ALIVE_DESC); ?></td>
		<td><input type="text" name="affiliate_cookie_lifetime" value="<?php echo $affiliate_cookie_lifetime;?>" /></td>
	  </tr>
	  <tr>
		<td><?php _e(LOGIN_TEXT_TOP_TITLE); ?><br><?php _e(LOGIN_TEXT_TOP_DESC); ?></td>
		<td>
		<textarea name="affiliate_login_content_top" id="affiliate_login_content_top" cols="70" rows="5"><?php echo $affiliate_login_content_top;?></textarea>
		</td>
	  </tr>
	  <tr>
		<td><?php _e(LOGIN_TEXT_BOTTOM_TITLE); ?><br><?php _e(LOGIN_TEXT_BOTTOM_DESC); ?></td>
		<td><textarea name="affiliate_login_content_bottom"  id="affiliate_login_content_bottom" cols="70" rows="5"><?php echo $affiliate_login_content_bottom;?></textarea></td>
	  </tr>
       <tr>
		<td><?php _e(TERMS_AND_CONDITIONS_TITLE); ?><br><?php _e(TERMS_AND_CONDITIONS_DESC); ?></td>
		<td><textarea name="affiliate_terms_conditions"  id="affiliate_terms_conditions" cols="70" rows="3"><?php echo $affiliate_terms_conditions;?></textarea></td>
	  </tr>
	  <tr>
		<td></td>
		<td><input type="submit" name="submit" value="<?php _e('Submit'); ?>" class="button-secondary action" /></td>
	  </tr>
	</thead>
	</table>
	</form>
	<p></p>
	<?php
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/affiliates/admin_affiliates_frm.php');
	}
	include_once(TEMPLATEPATH . '/library/includes/affiliates/admin_affiliates.php');
	include_once(TEMPLATEPATH . '/library/includes/affiliates/admin_affiliate_sale_report_default.php');
}
include_once(TEMPLATEPATH . '/library/includes/affiliates/admin_affiliates_report.php');
?>