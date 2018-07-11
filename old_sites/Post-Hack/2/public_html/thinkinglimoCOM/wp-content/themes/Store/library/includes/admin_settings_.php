<?php
global $wpdb,$General,$upload_folder_path;
if($_POST)
{
	$cartsql = "select * from $wpdb->options where option_name like 'shoppingcart_general_settings'";
	$cartinfo = $wpdb->get_results($cartsql);
	if($cartinfo)
	{
		foreach($cartinfo as $cartinfoObj)
		{
			$option_id = $cartinfoObj->option_id;
			$option_value = unserialize($cartinfoObj->option_value);
			$currency = $option_value['currency'];
			$currencysym = $option_value['currencysym'];
			$site_email = $option_value['site_email'];
			$site_email_name = $option_value['site_email_name'];
			$tax = $option_value['tax'];
			$is_show_weight = $option_value['is_show_weight'];
			$store_type = $option_value['store_type'];	
			$imagepath = $option_value['imagepath'];
			$is_show_coupon = $option_value['is_show_coupon'];
			$dash_noof_orders = $option_value['dash_noof_orders'];
			$is_show_tellafrnd = $option_value['is_show_tellafrnd'];
			$is_show_addcomment = $option_value['is_show_addcomment'];
			$checkout_type = $option_value['checkout_type'];
			$is_show_relproducts = $option_value['is_show_relproducts'];
			$digitalproductpath = $option_value['digitalproductpath'];
			$is_show_blogpage = $option_value['is_show_blogpage'];	
			$is_show_storepage = $option_value['is_show_storepage'];
			$is_show_category = $option_value['is_show_category'];
			$checkout_method = $option_value['checkout_method'];
			$is_show_termcondition = 	$option_value['is_show_termcondition'];
			$termcondition = 	$option_value['termcondition'];
			$loginpagecontent = 	$option_value['loginpagecontent'];
			$bill_address1 = 	$option_value['bill_address1'];
			$bill_address2 = 	$option_value['bill_address2'];		
			$bill_city = 	$option_value['bill_city'];
			$bill_state = 	$option_value['bill_state'];
			$bill_country = 	$option_value['bill_country'];
			$bill_zip = 	$option_value['bill_zip'];
			$is_active_affiliate = 	$option_value['is_active_affiliate'];
			$send_email_guest = 	$option_value['send_email_guest'];
			
			
																							
		}
	}
	$option_value['currency'] = $_POST['currency'];
	$option_value['currencysym'] = $_POST['currencysym']; 
	$option_value['site_email'] = $_POST['site_email'];
	$option_value['site_email_name'] = $_POST['site_email_name']; 
	$option_value['tax'] = $_POST['tax'];
	$option_value['is_show_weight'] = $_POST['is_show_weight'];
	$option_value['store_type'] = $_POST['store_type'];	
	$option_value['imagepath'] = $_POST['imagepath'];
	$option_value['is_show_coupon'] = $_POST['is_show_coupon'];	
	$option_value['dash_noof_orders'] = $_POST['dash_noof_orders'];	
	$option_value['is_show_tellafrnd'] = $_POST['is_show_tellafrnd'];
	$option_value['is_show_addcomment'] = $_POST['is_show_addcomment'];
	$option_value['checkout_type'] = $_POST['checkout_type'];
	$option_value['is_show_relproducts'] = $_POST['is_show_relproducts'];	
	$option_value['digitalproductpath'] = $_POST['digitalproductpath'];	
	$option_value['is_show_blogpage'] = $_POST['is_show_blogpage'];	
	$option_value['is_show_storepage'] = $_POST['is_show_storepage'];
	$option_value['is_show_category'] = $_POST['is_show_category'];
	$option_value['checkout_method'] = $_POST['checkout_method'];
	$option_value['is_show_termcondition'] = $_POST['is_show_termcondition'];
	$option_value['termcondition'] = $_POST['termcondition'];
	$option_value['loginpagecontent'] = $_POST['loginpagecontent'];
	$option_value['bill_address1'] = $_POST['bill_address1'];
	$option_value['bill_address2'] = $_POST['bill_address2'];
	$option_value['bill_city'] = $_POST['bill_city'];
	$option_value['bill_state'] = $_POST['bill_state'];
	$option_value['bill_country'] = $_POST['bill_country'];
	$option_value['bill_zip'] = $_POST['bill_zip'];
	$option_value['is_active_affiliate'] = $_POST['is_active_affiliate'];
	$option_value['send_email_guest'] = $_POST['send_email_guest'];
	
	
		
		
	$option_value_str = serialize($option_value);
	$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id='".$option_id."'";
	$wpdb->query($updatestatus);
	$message = "Updated Succesfully.";
}
$cartsql = "select * from $wpdb->options where option_name like 'shoppingcart_general_settings'";
$cartinfo = $wpdb->get_results($cartsql);
if(count($cartinfo)==0)
{
	$paymethodinfo = array(
						"currency"		=> 'USD',
						"currencysym"	=> '$',
						"site_email"	=> 'smart@gmail.com',
						"site_email_name"=>	'my online shop',
						"tax"			=>	'0.00',
						"is_show_weight"=>	'1',
						"store_type"	=>	'cart',
						//"imagepath"		=>	ABSPATH . "wp-content/uploads/product_images",
						"imagepath"		=>	"",		
						"is_show_coupon"=>	"1",
						"dash_noof_orders"=>	"5",
						"is_show_tellafrnd"=>	"1",
						"is_show_addcomment"=>	"0",
						"checkout_type"=>	"cart",
						"is_show_relproducts"=>	"1",
						"digitalproductpath"=>	"",
						"is_show_blogpage"=>	"1",
						"is_show_storepage"=>	"1",
						"is_show_category"=>	"1",
						"checkout_method"	=>	"normal",
						"is_show_termcondition"	=>	'1',
						"termcondition"	=>	'Accept Terms and Conditions',
						"loginpagecontent"	=>	'If you are an existing customer of [#$store_name#] or have previously registered you may sign in below or request a new password. Otherwise please enter your information below and an account will be created for you.',												
						"bill_address1"=>	"1",
						"bill_address2"=>	"1",																	
						"bill_city"=>	"1",
						"bill_state"=>	"1",
						"bill_country"=>	"1",
						"bill_zip"=>	"1",
						"is_active_affiliate"=>	"0",
						"send_email_guest"=>	"1",
						
						
						);
	$paymethodArray = array(
							"option_name"	=>	'shoppingcart_general_settings',
							"option_value"	=>	serialize($paymethodinfo),
							);
	$wpdb->insert( $wpdb->options, $paymethodArray );
}
$cartsql = "select * from $wpdb->options where option_name like 'shoppingcart_general_settings'";
$cartinfo = $wpdb->get_results($cartsql);
if($cartinfo)
{
	foreach($cartinfo as $cartinfoObj)
	{
		$option_id = $cartinfoObj->option_id;
		$option_value = unserialize($cartinfoObj->option_value);
		$currency = $option_value['currency'];
		$currencysym = $option_value['currencysym'];
		$site_email = $option_value['site_email'];
		$site_email_name = $option_value['site_email_name'];
		$tax = $option_value['tax'];
		$is_show_weight = $option_value['is_show_weight'];
		$store_type = $option_value['store_type'];
		$imagepath = $option_value['imagepath'];
		$is_show_coupon = $option_value['is_show_coupon'];
		$dash_noof_orders = $option_value['dash_noof_orders'];
		$is_show_tellafrnd = $option_value['is_show_tellafrnd'];	
		$is_show_addcomment = $option_value['is_show_addcomment'];
		$checkout_type = $option_value['checkout_type'];
		$is_show_relproducts = $option_value['is_show_relproducts'];
		$digitalproductpath = $option_value['digitalproductpath'];
		$is_show_blogpage = $option_value['is_show_blogpage'];
		$is_show_category = $option_value['is_show_category'];
		$checkout_method = $option_value['checkout_method'];
		$is_show_termcondition = $option_value['is_show_termcondition'];
		$termcondition = $option_value['termcondition'];
		$loginpagecontent = $option_value['loginpagecontent'];
		$bill_address1 = $option_value['bill_address1'];
		$bill_address2 = $option_value['bill_address2'];
		$bill_city = $option_value['bill_city'];
		$bill_state = $option_value['bill_state'];
		$bill_country = $option_value['bill_country'];
		$bill_zip = $option_value['bill_zip'];
		$is_active_affiliate = $option_value['is_active_affiliate'];
		$send_email_guest = $option_value['send_email_guest'];		
															
	}
}
?>

<form action="<?php echo get_option( 'siteurl' );?>/wp-admin/admin.php?page=settings" method="post">
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
  <h2><?php _e('Shopping Cart General Settings'); ?></h2>
  <?php if($message){?>
  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
    <p><?php echo $message;?> </p>
  </div>
  <?php }?>
  <table width="80%" cellpadding="5" class="widefat post fixed" >
    <thead>
      <tr>
        <td width="180"><?php _e('Store Type'); ?></td>
        <td width="58%"><select name="store_type">
            <option value="cart" <?php if($store_type=='cart'){?> selected="selected"<?php }?>>Shopping Cart</option>
            <option value="digital" <?php if($store_type=='digital'){?> selected="selected"<?php }?>>Digital Shop</option
>
            <option value="catalog" <?php if($store_type=='catalog'){?> selected="selected"<?php }?>>Catalog Mode</option>
          </select>        </td>
      </tr>
      <tr>
        <td><?php _e('Checkout Type (for "Shopping Cart" and "Digital Shop" only)'); ?> </td>
        <td><select name="checkout_type">
            <option value="cart" <?php if($checkout_type=='cart'){?> selected="selected"<?php }?>>Shopping Cart</option>
            <option value="buynow" <?php if($checkout_type=='buynow'){?> selected="selected"<?php }?>>Buy Now Button</option>
          </select>        </td>
      </tr>
        <tr>
        <td><?php _e('Checkout/Login Method'); ?></td>
        <td><select name="checkout_method">
            <option value="normal" <?php if($checkout_method=='normal'){?> selected="selected"<?php }?>>Normal Checkout</option>
            <option value="single" <?php if($checkout_method=='single'){?> selected="selected"<?php }?>>Checkout as Guest</option>
          </select>        </td>
      </tr>
       <tr>
        <td><?php _e('Send Registration Email Notification'); ?><br />
        <?php _e('In case of Checkout as Guest do you want to send Registration Email Notification'); ?>
        </td>
        <td>
        <select name="send_email_guest">
            <option value="0" <?php if($send_email_guest=='0'){?> selected="selected"<?php }?>>No</option>
            <option value="1" <?php if($send_email_guest==1){?> selected="selected"<?php }?>>Yes</option>
          </select>        </td>
      </tr>
      <tr>
        <td><?php _e('From Email Name'); ?></td>
        <td><input type="text" name="site_email_name" value="<?php echo $site_email_name;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('From Email ID'); ?></td>
        <td><input type="text" name="site_email" value="<?php echo $site_email;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('Default Currency (Ex.: USD)'); ?></td>
        <td><input type="text" name="currency" value="<?php echo $currency;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('Default Currency Symbol (Ex.: $)'); ?></td>
        <td><input type="text" name="currencysym" value="<?php echo $currencysym;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('Product Tax - apply to each products (%)'); ?></td>
        <td><input type="text" name="tax" value="<?php echo $tax;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('Product Image Path'); ?> (<?php echo get_option('siteurl') . "$upload_folder_path";?>) <br />
          <?php _e('(Default folder is "products_img")'); ?> </td>
        <td><input type="text" name="imagepath" value="<?php echo $imagepath;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('Digital Product Path'); ?> (<?php echo get_option('siteurl') . "$upload_folder_path";?>) <br />
          <?php _e('(Default folder is "digital_products")'); ?> </td>
        <td><input type="text" name="digitalproductpath" value="<?php echo $digitalproductpath;?>" /></td>
      </tr>
      <tr>
        <td><?php _e('Display Product Weight'); ?></td>
        <td><select name="is_show_weight">
            <option value="1" <?php if($is_show_weight==1){?> selected="selected"<?php }?>>Yes</option>
            <option value="0" <?php if($is_show_weight=='0'){?> selected="selected"<?php }?>>No</option>
          </select>        </td>
      </tr>
      <tr>
        <td><?php _e('Display Coupon code on checkout page'); ?> </td>
        <td><select name="is_show_coupon">
            <option value="1" <?php if($is_show_coupon==1){?> selected="selected"<?php }?>>Yes</option>
            <option value="0" <?php if($is_show_coupon=='0'){?> selected="selected"<?php }?>>No</option>
          </select>        </td>
      </tr>
      <tr>
        <td><?php _e('Display "Tell a Friend" on Product detail page'); ?> </td>
        <td><select name="is_show_tellafrnd">
            <option value="1" <?php if($is_show_tellafrnd==1){?> selected="selected"<?php }?>>Yes</option>
            <option value="0" <?php if($is_show_tellafrnd=='0'){?> selected="selected"<?php }?>>No</option>
          </select>        </td>
      </tr>
      <tr>
        <td><?php _e('Display "Add Comment" on Product detail page'); ?></td>
        <td><select name="is_show_addcomment">
            <option value="1" <?php if($is_show_addcomment==1){?> selected="selected"<?php }?>>Yes</option>
            <option value="0" <?php if($is_show_addcomment=='0'){?> selected="selected"<?php }?>>No</option>
          </select>        </td>
      </tr>
      <tr>
        <td><?php _e('Display "Related Products" on Product detail page'); ?></td>
        <td><select name="is_show_relproducts">
            <option value="1" <?php if($is_show_relproducts==1){?> selected="selected"<?php }?>>Yes</option>
            <option value="0" <?php if($is_show_relproducts=='0'){?> selected="selected"<?php }?>>No</option>
          </select>        </td>
      </tr>
      <tr>
        <td><?php _e('Display Blog Page'); ?></td>
        <td><select name="is_show_blogpage">
            <option value="1" <?php if($is_show_blogpage==1){?> selected="selected"<?php }?>>Yes</option>
            <option value="0" <?php if($is_show_blogpage=='0'){?> selected="selected"<?php }?>>No</option>
          </select>        </td>
      </tr>
      <tr>
        <td><?php _e('Display Store Page'); ?></td>
        <td><select name="is_show_storepage">
            <option value="1" <?php if($is_show_storepage==1){?> selected="selected"<?php }?>>Yes</option>
            <option value="0" <?php if($is_show_storepage=='0'){?> selected="selected"<?php }?>>No</option>
          </select>        </td>
      </tr>
     <?php /*?> <tr>
        <td><?php _e('Display Category'); ?></td>
        <td><select name="is_show_category">
            <option value="1" <?php if($is_show_category==1){?> selected="selected"<?php }?>>Yes</option>
            <option value="0" <?php if($is_show_category=='0'){?> selected="selected"<?php }?>>No</option>
          </select>        </td>
      </tr><?php */?>
      <tr>
        <td><?php _e('Display No of Orders on Dashboard'); ?></td>
        <td><input type="text" name="dash_noof_orders" value="<?php echo $dash_noof_orders;?>" /></td>
      </tr>
       <tr>
        <td><?php _e('Display Term and Conditions'); ?><br />
       ( <?php _e('Display Term and Conditions checkbox at checkout page'); ?>)        </td>
        <td><select name="is_show_termcondition">
            <option value="1" <?php if($is_show_termcondition==1){?> selected="selected"<?php }?>>Yes</option>
            <option value="0" <?php if($is_show_termcondition=='0'){?> selected="selected"<?php }?>>No</option>
          </select>
          statement beside checkbox <input type="text" name="termcondition" value="<?php echo $termcondition;?>"  />        </td>
      </tr>
       <tr>
        <td><?php _e('Registration Page Mandatory Fields'); ?>
        <br />( <?php _e('the selected fields will be Mandatory Fields while collecting user information'); ?>)        </td>
        <td><input type="checkbox" name="bill_address1" value="1" <?php if($bill_address1){?> checked="checked"<?php }?> /> Address1
        &nbsp;&nbsp;<input type="checkbox" name="bill_address2" value="1" <?php if($bill_address2){?> checked="checked"<?php }?> /> Address2
        &nbsp;&nbsp;<input type="checkbox" name="bill_city" value="1" <?php if($bill_city){?> checked="checked"<?php }?> /> City
        &nbsp;&nbsp;<input type="checkbox" name="bill_state" value="1" <?php if($bill_state){?> checked="checked"<?php }?> /> State
        &nbsp;&nbsp;<input type="checkbox" name="bill_country" value="1" <?php if($bill_country){?> checked="checked"<?php }?> /> Country
        &nbsp;&nbsp;<input type="checkbox" name="bill_zip" value="1" <?php if($bill_zip){?> checked="checked"<?php }?> /> Postal Code        </td>
      </tr>
      <tr>
        <td><?php _e('Login Page Top Content'); ?> </td>
        <td><textarea name="loginpagecontent" id="loginpagecontent" cols="70" rows="7"><?php echo $loginpagecontent;?></textarea></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" name="submit" value="<?php _e('Submit'); ?>" class="button-secondary action" /></td>
      </tr>
    </thead>
  </table>
</form>
<script language="javascript">
function resetthankyoucontent()
{
	var thankyoucontent='Thank you for your order\n\nYour payment has been successfully received and your order will be processed for shipping.\n\nThank you for shopping at {#[store_name]#}.';
	document.getElementById('thankyoucontent').value = thankyoucontent;
}
</script>