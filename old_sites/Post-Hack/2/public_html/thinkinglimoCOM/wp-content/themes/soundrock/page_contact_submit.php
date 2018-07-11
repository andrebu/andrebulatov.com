<?php
require_once('../../../wp-load.php');
foreach ($_REQUEST as $keys=>$values) {
	$$keys = $values;
}
$subject = "Contact Form Received";
$message = '
	<table width="100%" border="1">
	  <tr>
		<td width="100"><strong>Name:</strong></td>
		<td>'.$contact_name.'</td>
	  </tr>
	  <tr>
		<td><strong>Email:</strong></td>
		<td>'.$contact_email.'</td>
	  </tr>
	  <tr>
		<td><strong>Contact No.</strong></td>
		<td>'.$contact_no.'</td>
	  </tr>
	  <tr>
		<td><strong>Message:</strong></td>
		<td>'.$contact_msg.'</td>
	  </tr>
	  <tr>
		<td><strong>IP Address:</strong></td>
		<td>'.$_SERVER["REMOTE_ADDR"].'</td>
	  </tr>
	</table>
	';
$headers = 'From: Chimp Group <service@chimpgroup.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$attachments = '';
wp_mail( $cs_contact_email, $subject, $message, $headers, $attachments );
echo $cs_contact_succ_msg;
?>