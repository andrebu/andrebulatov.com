<?php
global $wpdb;

if($_GET['status']!='' && $_GET['lid']!='')
{
	$affiliate_links = get_option('affiliate_links');
	$affiliate_links[$_GET['lid']]['link_status'] = $_GET['status'];
	update_option('affiliate_links', $affiliate_links);
	$message = "Updated Successfully";
}
if($_GET['act']=='delete' && $_GET['lid']!='')
{
	$affiliate_links = get_option('affiliate_links');
	unset($affiliate_links[$_GET['lid']]);
	update_option('affiliate_links', $affiliate_links);
	$message = "Deleted Successfully";
}

$affiliate_links = get_option('affiliate_links');
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
<h2><?php _e('Manage Affiliate Links'); ?></h2>
<?php 
if($_REQUEST['msg']=='success'){ $message = "Updated Successfully";
if($message){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php echo $message;?> </p>
</div>
<?php } }?>
<p><a href="<?php echo get_option('siteurl').'/wp-admin/admin.php?page=affiliates_settings&pagetype=addedit'?>"><strong><?php _e('Add Affiliate Link'); ?></strong></a> </p>
<table width="100%"  class="widefat post fixed" >
  <thead>
    <tr>
      <th width="180"><strong><?php _e('Title'); ?></strong></th>
      <th width="300"><strong><?php _e('Link URL'); ?></strong></th>
      <th width="100"><strong><?php _e('Link Key'); ?></strong></th>
      <th width="85" align="center"><strong><?php _e('Action'); ?></strong></th>
    </tr>
<?php
if($affiliate_links)
{
	foreach($affiliate_links as $key=>$affiliate_links_Obj)
	{
	?>
    <tr>
      <td><a href="<?php echo get_option( 'siteurl' );?>/wp-admin/admin.php?page=affiliates_settings&pagetype=addedit&lid=<?php echo $key;?>" title="<?php _e('Edit');?> <?php echo $affiliate_links_Obj['link_title'];?>"><?php echo $affiliate_links_Obj['link_title'];?></a></td>
      <td><?php echo $affiliate_links_Obj['link_url'];?></td>
      <td><?php echo $affiliate_links_Obj['link_key'];?></td>
      <td>
	  <?php 
		if($affiliate_links_Obj['link_status']==1)
		{
			echo '<a href="'.get_option( 'siteurl' ).'/wp-admin/admin.php?page=affiliates_settings&status=0&lid='.$key.'">'.__('Hide').'</a>';
		}else
		{
			echo '<a href="'.get_option( 'siteurl' ).'/wp-admin/admin.php?page=affiliates_settings&status=1&lid='.$key.'">'.__('Show').'</a>';
		}
		?>
        |
       <a href="<?php echo get_option( 'siteurl' );?>/wp-admin/admin.php?page=affiliates_settings&act=delete&lid=<?php echo $key;?>" onclick="return confirm_del();"> <?php _e('Delete');?></a>
      </td>
    </tr>
    <?php
    }
}else
{
?>
<tr><td colspan="4"><h4><?php _e('No records available');?></h4></td></tr>
<?php
}
?>
  </thead>
</table>
<script language="javascript">
function confirm_del()
{
	if(confirm('<?php _e('Are you sure want to delete the link?');?>'))
	{		
		return true;
	}else
	{
		return false;
	}
}
</script>