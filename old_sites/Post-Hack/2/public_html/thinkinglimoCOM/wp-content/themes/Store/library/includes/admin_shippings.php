<?php
global $wpdb;

if($_POST && $_POST['action']=='active')
{
	$shippingmethod = $_REQUEST['shippingmethod'];
	$paymentsql = "select * from $wpdb->options where option_name like 'shipping_method_%'";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if($paymentinfo)
	{
		foreach($paymentinfo as $paymentinfoObj)
		{
			$option_value_str = '';
			$option_id = $paymentinfoObj->option_id ;	
			$shippingInfo = unserialize($paymentinfoObj->option_value);
			if($option_id == $_REQUEST['shippingmethod'])
			{
				$shippingInfo['isactive'] = '1';			
			}
			else
			{
				$shippingInfo['isactive'] = '0';
			}
			$option_value_str = serialize($shippingInfo);
			$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id='".$option_id."'";
			$wpdb->query($updatestatus);
		}
		$message = "Status Updated Successfully.";
	}
}

///////////update options start//////
if($_GET['payact']=='setting' && $_GET['id']!='')
{
	include_once(TEMPLATEPATH . '/library/includes/admin_shipping_settings.php');
	exit;
}
//////////update options end////////

$paymentsql = "select * from $wpdb->options where option_name like 'shipping_method_%' order by option_id asc";
$paymentinfo = $wpdb->get_results($paymentsql);
if(count($paymentinfo)==0)
{
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Enable Free Shipping?"),
					"fieldname"		=>	"free_shipping_amt",
					"value"			=>	"0",
					"description"	=>	__("Example : shipping amt = 0 "),
					);
								
	$payOpts = array();
	$paymethodinfo[] = array(
						"name" 		=> __('Free Shipping'),
						"key" 		=> 'free_shipping',
						"isactive"	=>	'1', // 1->display,0->hide
						"payOpts"	=>	$payOpts,
						);
	
///////////////////////////////////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Shipping Amount"),
					"fieldname"		=>	"flat_rate_amt",
					"value"			=>	"0",
					"description"	=>	__("Example : enter a value that will be added as default for shipping when someone goes throught checkout")
					);
												
	$paymethodinfo[] = array(
						"name" 		=> __('Flat Rate Shipping'),
						"key" 		=> 'flat_rate',
						"isactive"	=>	'0', // 1->display,0->hide
						"payOpts"	=>	$payOpts,
						);

///////////////////////////////////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Price Shipping 1"),
					"fieldname"		=>	"price_shipping1",
					"value"			=>	"10->100=1",
					"description"	=>	__('Example : if total price is between $10 and $100 then shipping price is $1 so the equation is -> <strong>10->100=1</strong>')
					);
	$payOpts[] = array(
					"title"			=>	__("Price Shipping 2"),
					"fieldname"		=>	"price_shipping2",
					"value"			=>	"101->200=10",
					"description"	=>	__('Example : if total price is between $101 and $200 then shipping price is $10 so the equation is -> <strong>101->200=10</strong>')
					);
	$payOpts[] = array(
					"title"			=>	__("Price Shipping 3"),
					"fieldname"		=>	"price_shipping3",
					"value"			=>	"201->300=20",
					"description"	=>	__('Example : if total price is between $201 and $300 then shipping price is $20 so the equation is -> <strong>201->300=20</strong>')
					);
	$payOpts[] = array(
					"title"			=>	__("Price Shipping 4"),
					"fieldname"		=>	"price_shipping4",
					"value"			=>	"301->500=50",
					"description"	=>	__('Example : if total price is between $301 and $500 then shipping price is $50 so the equation is -> <strong>301->500=50</strong>')
					);
	$payOpts[] = array(
					"title"			=>	__("Price Shipping 5"),
					"fieldname"		=>	"price_shipping5",
					"value"			=>	"501->1000=60",
					"description"	=>	__('Example : if total price is between $301 and $500 then shipping price is $60 so the equation is -> <strong>301->500=60</strong>')
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('Price Base Shipping'),
						"key" 		=> 'price_base',
						"isactive"	=>	'0', // 1->display,0->hide
						"payOpts"	=>	$payOpts,
						);
						
///////////////////////////////////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Weight Shipping 1"),
					"fieldname"		=>	"price_shipping1",
					"value"			=>	"1->10=10",
					"description"	=>	__("Example : if total weight is between 1 lbs and 10 lbs then shipping price is $10 so the equation is -> <strong>1->10=10</strong>")
					);
	$payOpts[] = array(
					"title"			=>	__("Weight Shipping 2"),
					"fieldname"		=>	"price_shipping2",
					"value"			=>	"11->51=20",
					"description"	=>	__("Example : if total weight is between 11 lbs and 51 lbs then shipping price is $20 so the equation is -> <strong>11->51=20</strong>")
					);
	$payOpts[] = array(
					"title"			=>	__("Weight Shipping 3"),
					"fieldname"		=>	"price_shipping3",
					"value"			=>	"51->100=30",
					"description"	=>	__("Example : if total weight is between 51 lbs and 100 lbs then shipping price is $30 so the equation is -> <strong>51->100=30</strong>")
					);
	$payOpts[] = array(
					"title"			=>	__("Weight Shipping 4"),
					"fieldname"		=>	"price_shipping4",
					"value"			=>	"101->150=40",
					"description"	=>	__("Example : if total weight is between 101 lbs and 150 lbs then shipping price is $40 so the equation is -> <strong>101->150=40</strong>")
					);
	$payOpts[] = array(
					"title"			=>	__("Weight Shipping 5"),
					"fieldname"		=>	"price_shipping5",
					"value"			=>	"151->200=40",
					"description"	=>	__("Example : if total weight is between 101 lbs and 150 lbs then shipping price is $40 so the equation is -> <strong>151->200=40</strong>")
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('Weight Base Shipping'),
						"key" 		=> 'weight_base',
						"isactive"	=>	'0', // 1->display,0->hide
						"payOpts"	=>	$payOpts,
						);
						
	for($i=0;$i<count($paymethodinfo);$i++)
	{
		$paymethodArray = array(
							"option_name"	=>	'shipping_method_'.$paymethodinfo[$i]['key'],
							"option_value"	=>	serialize($paymethodinfo[$i]),
							);
		$wpdb->insert( $wpdb->options, $paymethodArray );
		//print_r(unserialize(serialize($paymethodArray)));
	}
}
$paymentsql = "select * from $wpdb->options where option_name like 'shipping_method_%'";
$paymentinfo = $wpdb->get_results($paymentsql);
?>
<style>
h2 {
	color:#464646;
	font-family:Georgia, "Times New Roman", "Bitstream Charter", Times, serif;
	font-size:24px;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:italic;
	font-variant:normal;
	font-weight:normal;
	line-height:35px;
	margin:0;
	padding:14px 15px 3px 0;
	text-shadow:0 1px 0 #FFFFFF;
}
</style>
<h2><?php _e('Manage Shipping Options'); ?></h2>
<?php if($message){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e($message);?> </p>
</div>
<?php }?>
<form action="<?php get_option( 'siteurl' ).'/wp-admin/admin.php?page=manageshipping';?>" method="post" name="shippingfrm">
  <input type="hidden" name="action" value="active" />
  <table width="50%" class="widefat post fixed" >
    <thead>
      <tr>
        <th width="45" align="center"><strong><?php _e('Select'); ?></strong></th>
        <th width="180"><strong><?php _e('Method Name'); ?></strong></th>
        <!--<th><strong>Is Active</strong></th>-->
        <th width="100" ><strong><?php _e('Action'); ?></strong></th>
        <th >&nbsp;</th>
      </tr>
      <?php
if($paymentinfo)
{
	foreach($paymentinfo as $paymentinfoObj)
	{
	$option_id = $paymentinfoObj->option_id;	
	$paymentInfo = unserialize($paymentinfoObj->option_value);
?>
      <tr>
        <td align="center"><input type="radio" name="shippingmethod" value="<?php echo $option_id;?>"
     <?php
     if($paymentInfo['isactive'] == 1)
	 {
	 ?>
     checked="checked"
     <?php
	 }
	 ?>
      />
        <td><?php _e($paymentInfo['name']);?></td>
        <td>
          <?php
    if($paymentInfo['payOpts'])
	{
		echo '<a href="'.get_option( 'siteurl' ).'/wp-admin/admin.php?page=manageshipping&payact=setting&id='.$option_id.'">'.__('Settings').'</a>';
	}else
	{
		_e("Settings");
	}
	?>
          <?php /*?> </td>
    </tr></table><?php */?>
        </td>
        <td>&nbsp;</td>
      </tr>
      <?php
	}
}
?>
      <tr>
        <td align="left" style="padding-top:15px;" colspan="4"><input type="submit" name="<?php _e('Submit'); ?>" value="Submit" class="button-secondary action" /></td>
      </tr>
    </thead>
  </table>
</form>
