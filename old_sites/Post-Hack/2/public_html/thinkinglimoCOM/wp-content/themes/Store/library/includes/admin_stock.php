<?php
global $wpdb,$Cart,$General;
if($_REQUEST['pagetype'] == 'delete' && $_REQUEST['code'] != '')
{
	$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
	$couponinfo = $wpdb->get_results($couponsql);
	if($couponinfo)
	{
		foreach($couponinfo as $couponinfoObj)
		{
			$option_value = unserialize($couponinfoObj->option_value);
			unset($option_value[$_REQUEST['code']]);
			$option_value_str = serialize($option_value);
			$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_name='discount_coupons'";
			$wpdb->query($updatestatus);
		}
	}
	$location = get_option('siteurl')."/wp-admin/admin.php?page=managecoupon&msg=delsuccess";
	wp_redirect($location);exit;
}
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
.widefat
{
width:80%;
}
.stock:hover
{
	background:#CCCCCC;
}
</style>
<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/dhtmlgoodies_calendar.js"></script>
<link href="<?php bloginfo('template_directory'); ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />

<h2><?php _e('Manage Stock'); ?></h2>
<table width="100%">
<tr>
<td><form method="post" action="<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=stock" name="stock_frm">
<?php
if($_REQUEST['srch_stdate'])
{
	$srch_stdate = $_REQUEST['srch_stdate'];
}else
{
	$srch_stdate = '';
}
if($_REQUEST['srch_enddate'])
{
	$srch_enddate = $_REQUEST['srch_enddate'];
}else
{
	$srch_enddate = date('Y-m-d');
}

?>
        <table>
          <tr>
            <td valign="middle"><strong><?php _e('Search'); ?> : </strong></td>
            <td valign="top">From : 
              <input type="text" value="<?php echo $srch_stdate;?>" name="srch_stdate" id="srch_stdate" size="12"  />&nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.stock_frm.srch_stdate,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">
			  </td>
            <td valign="top"> &nbsp;&nbsp;To : <input type="text" value="<?php echo $srch_enddate;?>" name="srch_enddate" id="srch_enddate" size="12" />&nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.stock_frm.srch_enddate,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">
			</td>
			
			 </td>
            <td valign="top">&nbsp;&nbsp;
              <input type="submit" name="Search" value="<?php _e('Search'); ?>" class="button-secondary action" onclick="chkfrm();" />
            </td>
            </tr>
          <tr>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
          </tr>
        </table>
      </form></td>
</tr>
</table>
<table width="100%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
      <th width="350" align="left"><strong><?php _e('Products'); ?></strong></th>
      <th width="100" align="center"><strong><?php _e('Opening Stock'); ?></strong></th>
      <th width="100" align="right"><strong><?php _e('Sold Out'); ?></strong></th>
      <th width="100" align="left"><strong><?php _e('Current Stock'); ?></strong></th>
	   <th width="100" align="left"><strong><?php _e('Low stock value'); ?></strong></th>
	  <th width="100" align="left"><strong><?php _e('Stock enabled?'); ?></strong></th>
      <th align="left">&nbsp;</th>
    </tr>
	<pre>
<?php
$prdsql = "select p.ID,p.post_title from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status in ('draft','publish') and p.post_type='post' and (pm.meta_key like 'key' and pm.meta_value like '%:\"posttype\";%' and pm.meta_value like '%product%') order by p.post_title";
$prdinfo = $wpdb->get_results($prdsql);
 $arg_parm = array(
 			"stdate"	=>	$_REQUEST['srch_stdate'],
			"enddate"	=>	$_REQUEST['srch_enddate'],	
			);
if($prdinfo)
{
	for($i=0;$i<count($prdinfo);$i++)
	{
		$data = get_post_meta( $prdinfo[$i]->ID, 'key', true );
		$current_stock = $General->product_current_orders_count($prdinfo[$i]->ID,$arg_parm);
	?>
    <tr class="stock">
      <td><a href="<?php echo get_option('siteurl');?>/wp-admin/post.php?action=edit&post=<?php echo $prdinfo[$i]->ID;?>"><div><?php echo $prdinfo[$i]->post_title;?></div></a></td>
      <td align="center"><?php
		if($data['initstock']=='')
		{
			_e("Unlimited");
		}elseif($data['initstock']=='0')
		{
			echo "<font style=\"color:#006600;\"><b>".__("Out of Stock")."</b></font>";
		}else
		{
			echo number_format($data['initstock']);
		}
	  ?></td>
      <td align="center"><?php _e($current_stock);?></td>
      <td align="center">
	  <?php
		if($data['initstock']=='')
		{
			_e("Unlimited");
		}elseif($data['initstock']=='0')
		{
			echo "<font style=\"color:#006600;\"><b>".__("Out of Stock")."</b></font>";
		}else
		{
			if(($data['initstock']-$current_stock)>0)
			{
				echo number_format($data['initstock']-$current_stock);
			}else
			{
				echo "<font style=\"color:#006600;\"><b>".__("Out of Stock")."</b></font>";
			}
		}
	  ?>
	   </td>
	   <td align="center"><?php echo $data['minstock'];?></td>
	    <td align="center"><?php echo $data['is_check_outofstock'];?></td>
      <td>&nbsp;</td>
    </tr>
    <?php
	}
	
}
?>
  </thead>
</table>
