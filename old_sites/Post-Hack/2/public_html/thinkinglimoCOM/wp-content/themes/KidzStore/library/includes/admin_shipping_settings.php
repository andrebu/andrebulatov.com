<?php
global $wpdb;
if($_POST)
{

	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$paymentOpts = $option_value['payOpts'];
			for($o=0;$o<count($paymentOpts);$o++)
			{
				$paymentOpts[$o]['value'] = $_POST[$paymentOpts[$o]['fieldname']];
			}
			$option_value['payOpts'] = $paymentOpts;
			$option_value_str = serialize($option_value);
		}
	}
	
	$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id='".$_GET['id']."'";
	$wpdb->query($updatestatus);
	wp_redirect(get_option( 'siteurl' )."/wp-admin/admin.php?page=manageshipping&payact=setting&msg=success&id=".$_GET['id']);
}

$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
$paymentupdinfo = $wpdb->get_results($paymentupdsql);
if($paymentupdinfo)
{
	foreach($paymentupdinfo as $paymentupdinfoObj)
	{
		$option_value = unserialize($paymentupdinfoObj->option_value);
		//$option_value['isactive'] = $_GET['status'];
		$paymentOpts = $option_value['payOpts'];
	}
}
?>

<form action="<?php echo get_option( 'siteurl' );?>/wp-admin/admin.php?page=manageshipping&payact=setting&id=<?php echo $_GET['id'];?>" method="post" name="payoptsetting_frm">
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
  <h2><?php _e($option_value['name']);?>  <?php _e('Settings'); ?></h2>
  <?php if($_GET['msg']){?>
  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
    <p><?php _e('Updated Succesfully'); ?> </p>
  </div>
  <?php }?>
  <table width="65%" cellpadding="5" class="widefat post fixed" >
    <thead>
      <?php
for($i=0;$i<count($paymentOpts);$i++)
{
	$payOpts = $paymentOpts[$i];
?>
      <tr>
        <td width="140"><strong><?php _e($payOpts['title']);?></strong> : </td>
        <td width="800"><input type="text" name="<?php echo $payOpts['fieldname'];?>" id="<?php echo $payOpts['fieldname'];?>" value="<?php echo $payOpts['value'];?>" />
          <br />
          <?php _e($payOpts['description']);?> </td>
        <td width="853">&nbsp;</td>
      </tr>
      <?php
}
?>
      <tr>
        <td></td>
        <td><input type="submit" name="submit" value="<?php _e('Submit'); ?>" class="button-secondary action" />
          &nbsp;
          <input type="button" name="cancel" value="<?php _e('Cancel'); ?>" onClick="window.location.href='<?php echo get_option( 'siteurl' )."/wp-admin/admin.php?page=manageshipping"; ?>'" class="button-secondary action" /></td>
        <td>&nbsp;</td>
      </tr>
    </thead>
  </table>
</form>
