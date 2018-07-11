<?php
global $wpdb,$upload_folder_path;
if($_POST)
{
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$filename = $_POST['filename'];
	$file = $_POST['notification'];	
	if($file=='emails' || $file=='message')
	{
		$destinationfile =   ABSPATH . $upload_folder_path."notification/$file/$filename";
		if($subject)
		{
			$subject = '[SUBJECT-STR]'.$subject.'[SUBJECT-END]';
		}
		echo $message = $subject.$message;
		file_put_contents($destinationfile,$message);
		
		$fp = fopen($destinationfile,'rw');
		wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=notification&msg=success');
	}
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
</style>
<h2><?php _e('Manage Notification'); ?></h2>
<?php
$file = $_REQUEST['notification'];
$filename = $_REQUEST['file'];
if($file=='emails' || $file=='message')
{
	if($file=='emails') // Emails template
	{
		$destinationfile =   ABSPATH . $upload_folder_path."notification/$file/$filename";
		$filecontent = file_get_contents($destinationfile);
		$filecontent_arr1 = explode('[SUBJECT-STR]',$filecontent);
		$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
		$subject = $filecontent_arr2[0];
		$message = $filecontent_arr2[1];
		$file_array['file'] =  $filename;
		$file_array['subject'] =  $subject;
		$file_array['message'] =  $message;
	}elseif($file=='message')  // Message Templaes
	{
		$destinationfile =   ABSPATH . $upload_folder_path."notification/$file/$filename";
		$filecontent = file_get_contents($destinationfile);
		$file_array['file'] =  $filename;
		$file_array['message'] =  $filecontent;
	}
}
?>
<?php
if($file_array)
{
	?>
  <h3><?php _e($file);?></h3>
  <form action="" method="post" name="message_frm">
  <input type="hidden" name="filename" value="<?php echo $file_array['file'];?>">
  <input type="hidden" name="notification" value="<?php echo $file;?>">
  <table width="100%" cellpadding="5" class="widefat post fixed" >
  <tr>
  <td width="100px"><?php _e('File Name');?> : </td>
  <td><?php echo $file_array['file'];?></td>
  </tr>
  <tr>
  <td width="100px"><?php _e('File Path');?> : </td>
  <td><?php echo $destinationfile;?></td>
  </tr>
  <?php
  if($file=='emails')
  {
  ?>
  <tr>
  <td><?php _e('Subject');?> : </td>
  <td><input type="text" name="subject" value="<?php echo $file_array['subject'];?>"></td>
  </tr>
  <?php
  }
  ?>
  <tr>
  <td><?php _e('Message');?> : </td>
  <td><textarea name="message" cols="90" rows="20"><?php echo $file_array['message'];?></textarea></td>
  </tr>
  <tr>
  <td></td>
  <td><input type="submit" name="Submit" value="<?php _e('Submit')?>"> <input type="button" name="cancel" value="<?php _e('Cancel')?>" onClick="window.location.href='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=notification'">
  <input type="button" name="cancel" value="<?php _e('Back')?>" onClick="window.location.href='<?php echo get_option('siteurl');?>/wp-admin/admin.php?page=notification'">
  </td>
  </tr>
</table>
</form>
<?php  
}
?>