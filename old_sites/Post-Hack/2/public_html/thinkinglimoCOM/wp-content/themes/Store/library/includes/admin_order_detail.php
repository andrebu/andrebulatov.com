<?php
global $Cart,$General,$wpdb;
$userInfo = $General->getLoginUserInfo();
$userInfo = $General->getLoginUserInfo();

$orderId = $_GET['oid'];
$order_number = preg_replace('/([0-9]*([_]))/','',$orderId);
$userId = preg_replace('/([_])([0-9]*)/','',$orderId);
$ordersql = "select u.display_name,u.user_email,um.meta_value from $wpdb->usermeta as um join $wpdb->users as u on u.ID=um.user_id where um.meta_key = 'user_order_info' and um.user_id='".$userId."'";
$orderinfo = $wpdb->get_results($ordersql);
if($orderinfo)
{
	foreach($orderinfo as $orderinfoObj)
	{
		$meta_value = unserialize(unserialize($orderinfoObj->meta_value)); 
		$display_name= $orderinfoObj->display_name;	
		$user_email= $orderinfoObj->user_email;
		$orderInformationArray = $meta_value[$order_number-1];
		$user_info = $orderInformationArray[0]['user_info'];
		$cart_info = $orderInformationArray[0]['cart_info'];
		$payment_info = $orderInformationArray[0]['payment_info'];
		$order_info = $orderInformationArray[0]['order_info'];
		$affliate_info = $orderInformationArray[0]['affliate_info'];
	}
}
$orderInformationArray[0]['user_info']['user_name']=$display_name;
if($_POST['act']) // update order 
{
	$issendEmail = 0;
	if($order_info['order_status'] != $_POST['ostatus'] && ($_POST['ostatus']=='reject' || $_POST['ostatus']=='approve'))
	{
		$issendEmail = 1;
	}
	$order_info['order_status']=$_POST['ostatus'];
	$order_info['order_admmin_comment']=$_POST['ocomments'];
	$order_info['order_status_date']=date('Y-m-d H:i:s');
	$orderInformationArray[0]['order_info'] = $order_info;
	$order_info_all = $order_info;
	$meta_value[$order_number-1] = $orderInformationArray;
	update_usermeta($userId, 'user_order_info', serialize($meta_value)); // Save Order Information Here
	$display_message = "Order updated successfully.";
	if($issendEmail)
	{
		$fromEmail = $General->get_site_emailId();
		$fromEmailName = $General->get_site_emailName();
		$subject_default = "Order ".$_POST['ostatus'] ." Email, Order Number:#$orderId";
		$message = "";
		$toEmailName = $display_name;
		$toEmail = $user_email;
		///////////admin email//////////
		global $upload_folder_path;
		if($_POST['ostatus']=='approve')
		{
			$admindestinationfile =   ABSPATH . $upload_folder_path."notification/emails/order_approval.txt";
			$admin_message = '[SUBJECT-STR]order approval email[SUBJECT-END]<p>Dear [#$to_name#],</p><p>Your order has been approved.</p><p>[#$order_info#]</p><p>[#$store_name#]</p>';
		}else
		{
			$admindestinationfile =   ABSPATH . $upload_folder_path."notification/emails/order_rejection.txt";
			$admin_message = '[SUBJECT-STR]order rejection email[SUBJECT-END]<p>Dear [#$to_name#],</p><p>Your order has been rejected.</p><p>[#$order_info#]</p><p>[#$store_name#]</p>';
		}
		if(file_exists($admindestinationfile))
		{
			$admin_message = file_get_contents($admindestinationfile);
		}
		
		$filecontent_arr1 = explode('[SUBJECT-STR]',$admin_message);
		$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
		$subject = $filecontent_arr2[0];
		if($subject == '')
		{
			$subject = $subject_default;
		}
		$admin_message = $filecontent_arr2[1];
		$order_info = $General->get_order_detailinfo_tableformat($orderInformationArray[0]);
		$search_array = array('[#$user_name#]','[#$to_name#]','[#$order_info#]','[#$store_name#]');
		$replace_array = array($toEmailName,$toEmailName,$order_info,$store_name);
		$client_message = str_replace($search_array,$replace_array,$admin_message);
		$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$client_message,$extra='');///approve/reject email
		
		///AFFILIATE START//
		if($General->is_active_affiliate())
		{
			if($_POST['ostatus']=='approve')  // send affiliate email
			{
				$aid = $affliate_info['aid'];
				if($aid)
				{
					$usersql = "SELECT user_nicename,user_email FROM $wpdb->users WHERE ID=\"$aid\"";
					$userinfo = $wpdb->get_results($usersql);
					$toEmailName = $userinfo[0]->user_nicename;
					$toEmail = $userinfo[0]->user_email;
					$user_affiliate_data = get_usermeta($aid,'user_affiliate_data');
					$cart_amt = str_replace(',','',substr($cart_info['cart_amt'],1));
					$order_amount = $cart_amt - $order_info_all['discount_amt'];
					foreach($user_affiliate_data as $key => $val)
					{
						$share_amt = ($order_amount*$val['share_amt'])/100;
					}			
					$cart_info_arr = $cart_info['cart_info'];
					for($c=0;$c<count($cart_info_arr);$c++)
					{
						$product_name[] = $cart_info_arr[$c]['product_name'];
						$product_qty = $product_qty + $cart_info_arr[$c]['product_qty'];
					}
					$product_name = implode(', ',$product_name);
					$subject = 'Affiliate Sale';
					$aff_message = '
					<p>Dear '.$toEmailName.',</p>
					<p>
					New sale has been made by your affiliate link and<br>
					commission credited to your balance.<br>
					</p>
					<p>
					You may find sale details below:
					</p>
					<p>----</p>
					<p>Transaction Id : '.$order_info['order_id'].'</p>
					<p>Order Amount :       '.$General->get_amount_format($order_amount,0).'</p>
					<p>Qty :       '.$product_qty.'</p>
					<p>Product ordered: '.$product_name.'</p>
					<p>Your commission: '.$General->get_amount_format($share_amt,0).'</p>
					<p>----</p>
					';
					/*echo $aff_message;
					echo "<br>";
					echo "Subject : $subject<br>";
					echo "From $fromEmail,$fromEmailName<br>";
					echo "To $toEmail,$toEmailName<br>";
					exit;*/
					$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$aff_message,$extra='');///To affiliate email
				}
			}
		}
		///AFFILIATE END///
		
	}
}
 ?>
<style>
body, td, textarea, input, select {
	font:13px Arial, Helvetica, sans-serif;
}
.fl {
	float: left
}
.fr {
	float: right
}
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
/* view cart page --------------- */
.table {
	margin-bottom:10px;
	width:100%;
}
.table td {
	padding:5px 10px;
	vertical-align:top;
}
.table td.title {
	font-size:14px;
	font-weight:bold;
	color:#000;
	border-bottom:2px solid #ddd;
	border-top:2px solid #ddd;
}
.table .row1 {
	background:#fff;
	border-right:1px solid #ddd;
	border-bottom:1px solid #ddd;
	font-size:12px;
	color:#444;
}
.table .row1 a {
	text-decoration:none;
	color:#333;
}
.table .row3 {
	background:#fff;
	border-bottom:1px solid #ddd;
	font-size:12px;
	color:#333;
	padding:8px;
}
.table .bnone {
	border-right:none;
}
.table .tprice {
	padding-left:22px;
	font-size:14px;
	font-weight:bold;
	text-align:left;
}
.table .remove {
	background:#fff;
	border-bottom:1px solid #ddd;
	font-size:12px;
	color:#333;
}
.table .total_price {
	padding-left:22px;
	font-size:22px;
	border-right:1px solid #ddd;
	border-bottom:1px solid #ddd;
	text-align:left;
	background:#eee;
	color:#000;
}
.table .row2 {
	background:#eee;
	border-right:1px solid #ddd;
	border-bottom:1px solid #ddd;
	font-size:14px;
	color:#333;
	padding-top:10px;
}
.table a {
	text-decoration:underline;
	color:#333;
}
.table a:hover {
	text-decoration:underline;
	color:#000;
}
.qty_input {
	width:50px;
}
.product_thum {
	border:1px solid #ccc;
	padding:5px;
	background:#fff;
}
.table .pro_title {
	color:#000;
}
.table .pro_des {
	color:#666;
	font-size:12px;
}
.table .qty {
	border:1px solid #ccc;
	padding:2px;
	width:60px;
}
.action_button {
	background:#9c9c9c;
	font:bold 14px Arial, Helvetica, sans-serif;
	color:#fff;
	text-align:center;
	padding:5px;
	border:none;
	cursor:pointer;  /*-moz-border-radius:0.5em;*/
}
.action_button:hover {
	background:#636363;
}
.button_bar {
	height:100%;
	overflow:hidden;
	margin-bottom:50px;
	padding-top:10px;
}
.button_bar2 {
	border-top:1px solid #ccc;
	border-bottom:1px solid #ccc;
	height:100%;
	overflow:hidden;
	margin-bottom:50px;
}
.coupon_code {
	width:480px;
	float:left;
	background:#eee;
	padding:10px 10px;
	border-right:1px solid #ccc;
}
.coupon_text {
	padding:5px;
	border:1px solid #ccc;
	margin-left:5px;
	margin-right:5px;
}
.coupon_code table td {
	vertical-align: middle;
}
.empty_cart {
	background:#9c9c9c url(images/i_empty_cart.png) no-repeat right 7px;
	font:bold 14px Arial, Helvetica, sans-serif;
	color:#fff;
	text-align:center;
	border:none;
	cursor:pointer;
	padding:5px 25px 5px 5px;
	float:right;
}
.empty_cart:hover {
	background:#636363 url(images/i_empty_cart.png) no-repeat right 7px;
}
.total_amount {
	background:#e8e8e8;
	border-top:1px solid #ddd;
	border-bottom:1px solid #ddd;
	padding:10px 5px;
	font-size:18px;
}
.total_amount_title {
	background:#e8e8e8;
	border-top:1px solid #ddd;
	border-bottom:1px solid #ddd;
	padding:10px 5px;
	font-size:16px;
}
.back {
	background:#9c9c9c url(images/i_arrow.png) no-repeat 10px 10px;
	float:left;
	font:bold 14px Arial, Helvetica, sans-serif;
	color:#fff;
	text-align:center;
	padding:5px 5px 5px 20px;
	border:none;
	cursor:pointer;
	margin-right:8px;
}
.back:hover {
	background:#636363 url(images/i_arrow.png) no-repeat 10px 10px;
}
.confirm {
	background:#333 url(images/i_arrow2.png) no-repeat right 10px;
	font:bold 14px Arial, Helvetica, sans-serif;
	color:#fff;
	float:right;
	text-align:center;
	padding:5px 22px 5px 5px;
	border:none;
	cursor:pointer;
}
.confirm:hover {
	background:#000 url(images/i_arrow2.png) no-repeat right 10px;
}
.order_info {
	border:1px solid #ccc;
	height:100%;
	overflow:hidden;
	padding:10px;
	padding-bottom:5px;
	background:#fff;
	margin-bottom:10px;
}
#content .order_info p {
	font-size:13px;
}
#content .order_info p span {
	width:100px;
	float:left;
}
a.normal_button {
	-moz-border-radius:11px;
	-moz-box-sizing:content-box;
	border:1px solid #bbb;
	text-shadow:0 1px 0 #FFFFFF;
	padding:8px 10px;
	line-height:10px;
	color:#444;
	background:#fff;
	cursor:pointer;
	font-size:12px;
	line-height:10px;
	text-decoration:none;
	display:block;
}
a:hover.normal_button, .normal_button:focus {
	border:1px solid #333;
	background:#fff;
	color:#000;
	text-decoration:none;
}
.continue_spacer {
	margin-left:200px;
	margin-top:10px;
}
#content a.highlight_button {
	-moz-border-radius:11px;
	-moz-box-sizing:content-box;
	border:1px solid #464646;
	padding:8px 10px;
	line-height:10px;
	color:#fff;
	background:#464646;
	cursor:pointer;
	font-size:12px;
	line-height:10px;
}
#content a:hover.highlight_button, .highlight_button:focus {
	border:1px solid #333;
	background:#000;
	color:#fff;
	text-decoration:none;
}
.checkout_spacer {
	margin:10px 0 0 0;
}
#authorizenetoptions {
	margin-left:25px;
}
#authorizenetoptions input, #authorizenetoptions select {
	border:1px solid #ccc;
	padding:4px;
}
/* checkout page ------------------------------------------------ */

.checkout_address {
	height:100%;
	overflow:hidden;
	margin-bottom:20px;
}
.address_info {
	width:43%;
	border:1px solid #ccc;
	padding:15px;
}
#content .address_info h3 {
	font-size:16px;
	font-weight:bold;
	border-bottom:1px solid #ccc;
}
.address_row {
	height:100%;
	overflow:hidden;
	line-height:18px;
}
#content .address_info h3 span {
	font-size:12px;
	color:#444;
}
#content .address_info h3 span a {
	color:#444;
}
#content .address_info h3 span a:hover {
	color:#000;
}
.shipping_method {
	border:1px solid #ccc;
	background:#eee;
	padding:5px 10px;
	height:100%;
	overflow:hidden;
	margin-bottom:20px;
}
#content .shipping_method p {
	margin:0;
	padding:0;
}
.method {
	color:#FF3300;
	font-weight:bold;
	font-size:13px;
}
#content h3.shipping_cart {
	margin:0;
	padding:5px;
	font:bold 16px Arial, Helvetica, sans-serif;
	background:#eee;
	border-top:1px solid #ddd;
}
.table_spacer {
	margin-bottom:30px;
}
.payment_method {
	border:1px solid #ccc;
	margin:0 auto 10px auto;
}
</style>
<h2><?php _e('Order Detail of Order'); ?> - <?php echo $_GET['oid'];?></h2>
<table width="80%">
<tr>
  <td style="color:#FF0000;"><?php echo $display_message;?></td>
</tr>
<tr>
  <td><table width="100%">
      <tr>
        <td><?php echo $General->get_order_detailinfo_tableformat($orderInformationArray[0]);?> </td>
      </tr>
      <tr>
        <td><form action="<?php echo get_option( 'siteurl' ) ."/wp-admin/admin.php?page=manageorders&oid=".$_GET['oid'];?>" method="post">
            <input type="hidden" name="act" value="orderstatus">
            <table width="75%" class="widefat post fixed" >
              <tr>
                <td width="10%"><strong><?php _e('Order Status'); ?> :</strong></td>
                <td width="90%"><select name="ostatus">
                    <option value="processing" <?php if($order_info['order_status']=='processing'){?> selected<?php }?>><?php _e(ORDER_PROCESSING_TEXT);?></option>
                    <option value="approve" <?php if($order_info['order_status']=='approve'){?> selected<?php }?>><?php _e(ORDER_APPROVE_TEXT);?></option>
                    <option value="reject" <?php if($order_info['order_status']=='reject'){?> selected<?php }?>><?php _e(ORDER_REJECT_TEXT);?></option>
                    <option value="cancel" <?php if($order_info['order_status']=='cancel'){?> selected<?php }?>><?php _e(ORDER_CANCEL_TEXT);?></option>
                    <option value="shipping" <?php if($order_info['order_status']=='shipping'){?> selected<?php }?>><?php _e(ORDER_SHIPPING_TEXT);?></option>
                    <option value="delivered" <?php if($order_info['order_status']=='delivered'){?> selected<?php }?>><?php _e(ORDER_DELIVERED_TEXT);?></option>
                  </select></td>
              </tr>
              <tr>
                <td><strong><?php _e('Comments'); ?>:</strong></td>
                <td><textarea name="ocomments" cols="70"><?php echo stripslashes($order_info['order_admmin_comment']);?></textarea></td>
              </tr>
              <tr>
                <td></td>
                <td><input type="submit" name="submit" value="<?php _e('Update'); ?>" class="button-secondary action" ></td>
              </tr>
            </table>
          </form></td>
      </tr>
      <tr>
        <td><a href="<?php echo get_option('siteurl')."/wp-admin/admin.php?page=manageorders"?>"><strong><?php _e('Back to Orders Listing'); ?></strong></a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
