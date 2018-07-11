<?php
//--PAYPAL SCRIPT---------------------------------------------------------------

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);             // <- Use this line for real use
//$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);   // <- Use this line when testing in SandBox

global $upload_folder_path;

// assign posted variables to local variables
$item_name            = $_POST['item_name'];
$item_number          = $_POST['item_number'];
$quantity             = $_POST['quantity'];
$payment_amount       = $_POST['mc_gross'];
$fee                  = $_POST['mc_fee'];
$tax                  = $_POST['tax'];
$payment_currency     = $_POST['mc_currency'];
$exchange_rate        = $_POST['exchange_rate'];
$payment_status       = $_POST['payment_status'];
$payment_type         = $_POST['payment_type'];
$payment_date         = $_POST['payment_date'];
$txn_id               = $_POST['txn_id'];
$txn_type             = $_POST['txn_type']; // 'cart', 'send_money' or 'web_accept' (manual page 46)
$custom               = $_POST['custom'];   // Any custom data
$receiver_email       = $_POST['receiver_email'];
$first_name           = $_POST['first_name'];
$last_name            = $_POST['last_name'];
$payer_business_name  = $_POST['payer_business_name'];
$payer_email          = $_POST['payer_email'];
$address_street       = $_POST['address_street'];
$address_zip          = $_POST['address_zip'];
$address_city         = $_POST['address_city'];
$address_state        = $_POST['address_state'];
$address_country      = $_POST['address_country'];
$address_country_code = $_POST['address_country_code'];
$residence_country    = $_POST['residence_country'];

if (!$fp) {
	// HTTP ERROR
} else {
	fputs ($fp, $header . $req);
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) {
			$payment_verified = true;
		} else if (strcmp ($res, "INVALID") == 0) {
			$payment_verified = false;
		}
	}
	fclose ($fp);
}

//--CONFIG----------------------------------------------------------------------
$fromEmail = $General->get_site_emailId();
$fromEmailName = $General->get_site_emailName();
$paymentOpts = $General->get_payment_optins('paypal');
$merchantid = $paymentOpts['merchantid'];

$supplier_address      = $fromEmail;    // Destination address for all internal notifications
$paypal_address        = $fromEmail;   // Sender address for outgoing messages
$paypal_address_raw    = $merchantid;              // The address the IPN should come from

$supplier_name_long    = $fromEmailName;            // Company Long name
$supplier_name_short   = $fromEmailName;                         // Company short name
$supplier_web_site     = get_option('siteurl');         // Company web site
$supplier_support_site = get_option('siteurl');      // Company Help desk URL
$supplier_tax_id       = "xxxxxxxxxxxxxxx";                  // VAT / Tax ID

$txnid_daystokeep      = 30;                                 // Days transaction ID will be kept

//--FORMAT TRANSACTION DETAILS--------------------------------------------------

if ($quantity == '0' || $quantity == "" ) { $quantity = 1; }
if ($exchange_rate == '0' || $exchange_rate == "" ) { $exchange_rate = 1; }
if ($residence_country <> "") { $country = $residence_country; } else { $country = $address_country_code; }

list($user_system, $user_country) = split(';', $custom); // Get custom data
if ($country == "") { $country = $user_country; }        // In case PayPal has no country value we use custom one

$transaction_details .= "<table>";
$transaction_details .= "<tr><td>--------------------------------------------------</td></tr>";
$transaction_details .= "<tr><td>Order Details for Order #$custom  </td></tr>";
$transaction_details .= "<tr><td>--------------------------------------------------</td></tr>";
$transaction_details .= " <tr><td>Product: ".str_replace(',',',<br>',$item_name)." </td></tr>";
$transaction_details .= "<tr><td>  Amount: $payment_amount</td></tr>";
$transaction_details .= "<tr><td>Currency: $payment_currency</td></tr>";
$transaction_details .= "<tr><td>    Rate: $exchange_rate</td></tr>";
$transaction_details .= "<tr><td>--------------------------------------------------</td></tr>";
$transaction_details .= "<tr><td>   Buyer: $first_name $last_name</td></tr>";
$transaction_details .= "<tr><td>  E-Mail: $payer_email</td></tr>";
$transaction_details .= "<tr><td>--------------------------------------------------</td></tr>";
$transaction_details .= "<tr><td>Trans ID: $txn_id</td></tr>";
$transaction_details .= "<tr><td>  Status: $payment_status</td></tr>";
$transaction_details .= "<tr><td>    Type: $payment_type</td></tr>";
$transaction_details .= "<tr><td>  Method: $txn_type</td></tr>";
$transaction_details .= "<tr><td>--------------------------------------------------</td></tr>";
$transaction_details .= "</table>";

//--PROCESS PAYMENT-------------------------------------------------------------

$headers = "From: $paypal_address";
$customer_address = "$first_name $last_name <$payer_email>";

if ($payment_verified) {
	// check the payment_status is Completed
	// check that txn_id has not been previously processed
	// check that receiver_email is your Primary PayPal email
	// check that payment_amount/payment_currency are correct
	// process payment
	
	if (strcmp ($payment_status, "Completed") == 0) { // Payment has been successfully completed
		
	// The sender e-mail is the right address

	if (!CheckTransactionID($txn_id)) { // Check if it is not a duplicate transaction

		if (strcmp ($txn_type, "web_accept") == 0) { // This is a direct sale thru Purchase button on web site
			
			$orderId = $custom;
			$General->set_ordert_status($orderId,'approve');
			/////affiliate email start
			$orderId = $custom;
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
			$aid = $affliate_info['aid'];
			if($aid)
			{
				$usersql = "SELECT user_nicename,user_email FROM $wpdb->users WHERE ID=\"$aid\"";
				$userinfo = $wpdb->get_results($usersql);
				$toEmailName = $userinfo[0]->user_nicename;
				$toEmail = $userinfo[0]->user_email;
				$user_affiliate_data = get_usermeta($aid,'user_affiliate_data');
				$cart_amt = str_replace(',','',substr($cart_info['cart_amt'],1));
				$order_amount = $cart_amt - $order_info['discount_amt'];
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
				<p>Order Amount :       '.$General->get_amount_format($cart_amt,0).'</p>
				<p>Qty :       '.$product_qty.'</p>
				<p>Product ordered: '.$product_name.'</p>
				<p>Your commission: '.$General->get_amount_format($share_amt,0).'</p>
				<p>----</p>
				';
				$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$aff_message,$extra='');///To affiliate email
			}
			/////affiliate email end
			
			$customer_subject = "<p>Thanks for shopping $item_name!</p>";
			$customer_message  = "<p>Greetings from $supplier_name_short,</p>";
			$customer_message .= "<p>Thank you for your recent purchase! Provided below is important information</p>";
			$customer_message .= "<p>about the delivery of your products. It is recommended that you print or save</p>";
			$customer_message .= "<p>this email for future reference. Should you experience any product related</p>";
			$customer_message .= "<p>problems, please use the support information found below.</p>";
			$customer_message .= "<p>Your serial (if applies) will be sent very soon in a separate e-mail.</p>";
			$customer_message .= "<p>$transaction_details</p>";
			$customer_message .= "<p>Please feel free to send us your questions, comments, or suggestions. If</p>";
			$customer_message .= "<p>you are having troubles getting started with this product, feel free to</p>";
			$customer_message .= "<p>ask us using our support inquiry form at: $supplier_support_site</p>";
			$customer_message .= "<p>Please be as descriptive as possible.</p>";
			$customer_message .= "<p>Thanks again for supporting our products!</p>";
			$customer_message .= "<p>The $supplier_name_short Team.</p>";
			$customer_message .= "<p>$supplier_web_site</p>";
				
			$supplier_subject  = "<p>PayPal purchase notification";
			$supplier_message  = "</p>";
			$supplier_message .= "<p><paypal>";
			$supplier_message .= " </p><p>   Product purchased: $item_name</p><p>";
			$supplier_message .= "    System: $user_system</p><p>";
			$supplier_message .= "    SKU: $item_number</p><p>";
			$supplier_message .= "    Quantity: $quantity</p><p>";
			$supplier_message .= "    Customer: $first_name $last_name</p><p>";
			$supplier_message .= "    Email: $payer_email</p><p>";
			$supplier_message .= "    Total Amount Paid: $payment_currency $payment_amount</p><p>";
			$supplier_message .= "    Profit: " . strval($payment_amount - $fee - $tax) . "</p><p>";
			$supplier_message .= "    Fee: $fee</p><p>";
			$supplier_message .= "    Tax: $tax</p><p>";
			$supplier_message .= "    Date: " . date('m/d/Y') . "</p><p>"; //$payment_date\r\n";
			$supplier_message .= "    TransactionID: $txn_id</p><p>";
			$supplier_message .= "    Country: $country</p><p>";
			$supplier_message .= "</paypal></p><p>";	
			$supplier_message .= "$transaction_details</p>";
			
///////////email start//////////
		$store_name = get_option('blogname');
		$admindestinationfile =   ABSPATH . $upload_folder_path."notification/emails/paypal_ipn_order_success_customer.txt";
		if(file_exists($admindestinationfile))
		{
			$customer_message = file_get_contents($admindestinationfile);
			$filecontent_arr1 = explode('[SUBJECT-STR]',$customer_message);
			$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
			$customer_subject = $filecontent_arr2[0];
			$customer_message = $filecontent_arr2[1];
			$search_array = array('[#$user_name#]','[#$to_name#]','[#$transaction_details#]','[#$store_name#]');
			$replace_array = array(__('Customer'),$customer_address,$transaction_details,$store_name);
			$customer_message = str_replace($search_array,$replace_array,$customer_message);
		}
		$admindestinationfile =   ABSPATH . $upload_folder_path."notification/emails/paypal_ipn_order_success_supplier.txt";
		if(file_exists($admindestinationfile))
		{
			$supplier_message = file_get_contents($admindestinationfile);
			$filecontent_arr1 = explode('[SUBJECT-STR]',$customer_message);
			$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
			$supplier_subject = $filecontent_arr2[0];
			$supplier_message = $filecontent_arr2[1];
			$search_array = array('[#$user_name#]','[#$to_name#]','[#$transaction_details#]','[#$store_name#]');
			$replace_array = array(__('Customer'),$supplier_address,$transaction_details,'Pay Pal');
			$supplier_message = str_replace($search_array,$replace_array,$supplier_message);
		}
		
//////////////////email end/////////
	
			SendMessage($customer_address, $customer_subject, $customer_message, $headers);      // Copy for customer	
			SendMessage($supplier_address, $supplier_subject, $supplier_message, $headers);      // Copy for Supplier
					
			
			//Prepare invoice
			$invoice_number = $_POST['custom'];
			
			$invoice  = "<p>$first_name $last_name,</p><p>";			
			$invoice .= "Thanks for your order! A copy of your invoice is included below. If you</p><p>";
			$invoice .= "have any questions, contact us at $supplier_support_site</p><p>";
			$invoice .= "Give the order ID shown below as an identifier. Please note your license</p><p>";
			$invoice .= "code is included below and a copy will also arrive via a separate email</p><p>";
			$invoice .= "with instructions. Nothing is to be shipped to you.</p><p>";
			$invoice .=  "Order-ID: #" . $invoice_number . "</p><p>";
			
			$invoice .= "________________________________________________________________________</p><p>";
			$invoice .= "Billing Information:</p><p>";
			if ( $payer_business_name <> "" ) { $invoice .= "  $payer_business_name</p><p>"; }
			$invoice .= "  $first_name $last_name</p><p>";
			$invoice .= "  $payer_email</p><p>";
			if ( $address_street <> "" ) { $invoice .= "  $address_street</p><p>"; }
			if ( $address_city <> "" && $address_state <> "" ) { $invoice .= "  $address_city, $address_state $address_zip</p><p>"; }
			if ( $address_country <> "" ) { $invoice .= "  $address_country</p><p>"; }
			$invoice .= "</p><p>";
			$invoice .= "Currency: $payment_currency (Rate= $exchange_rate)</p><p>";
			$invoice .= "Order Method: PayPal";
			$invoice .= "</p><p>";
			$invoice .= "Item name                                      Price      Qty      Total</p><p>";
			$invoice .= "------------------------------------------------------------------------</p><p>";
			$invoice .= "$item_name" . str_pad($payment_amount , 52 - strlen($item_name), " ", STR_PAD_LEFT);
			$invoice .= str_pad($quantity , 61 - 52, " ", STR_PAD_LEFT) . str_pad($payment_amount , 11, " ", STR_PAD_LEFT) . "</p><p>";
			$invoice .= "</p><p>";
			$invoice .= "------------------------------------------------------------------------</p><p>";
			$invoice .= "Total:" . str_pad($payment_amount , 72 - 6, " ", STR_PAD_LEFT) . "</p><p>";
			if ($tax <> '0' && $tax <> "") { $invoice .= "  Tax:" . str_pad($tax , 72 - 6, " ", STR_PAD_LEFT) . "</p><p>"; }
			$invoice .= "------------------------------------------------------------------------</p><p>";
			$invoice .= "</p><p>";
			$invoice .= "We have charged your PayPal account for the total above.</p><p>";
			$invoice .= "Thanks for your business!</p><p>";
			$invoice .= "";
			$invoice .= "NOTE:  Please do not reply to this e-mail as it will not be received.</p><p>";
			$invoice .= "Please visit our support page: $supplier_support_site</p>";
			$invoice .= "";
			
			LogInvoice($invoice_number, "$first_name $last_name", $country, $txn_id, $item_name, $payment_currency, $exchange_rate, $payment_amount, $fee, $tax);
			SaveInvoice($invoice_number, $invoice);	
			
			SendMessage($supplier_address, "Invoice #" . $invoice_number, $invoice, $headers);                           // Send invoice to Supplier
			SendMessage($customer_address, "Your $supplier_name_short Order #" . $invoice_number, $invoice, $headers);   // Send invoice to customer

		
		} else if (strcmp ($txn_type, "send_money") == 0) { // Transaction created by customer from the Send Money tab on the PayPal website.
			// Handle 'Send money' here or do nothing
		} else if (strcmp ($txn_type, "cart") == 0) { // Transaction created by customer via the PayPal Shopping Cart feature.
			// Handle cart purchase here
		} else {
			// oops!!!! We should never get there...
		}
		
	} else {
		// Transaction ID already exists, this is a duplicate process
	}
	

		
	} else if (strcmp ($payment_status, "Refunded") == 0 || strcmp ($payment_status, "Reversed") == 0 || strcmp ($payment_status, "Partially-Refunded") == 0) {
		
		if (!CheckTransactionID($txn_id)) { // Check if it is not a duplicate transaction
			$parent_txn_id = $_POST['parent_txn_id']; // Contains the original transaction ID, the one that has been refunded or reversed
			$reason_code   = $_POST['reason_code'];   // Reason why the payment has been refunded, refund, chargeback, buyer complaint...
		
			If ( $payment_status == "Refunded" ) { $invoice_number = "** Refund"; }
			If ( $payment_status == "Partially-Refunded" ) { $invoice_number = "** Partial Refund"; }
			If ( $payment_status == "Reversed" ) { $invoice_number = "** Chargeback"; }
		
			LogInvoice($invoice_number, "$first_name $last_name", $country, $txn_id, $parent_txn_id, $payment_currency, $exchange_rate, $payment_amount, $fee, $tax);
		
			$subject = "PayPal transaction #$parent_txn_id $payment_status ($reason_code)";
			$message = "$subject:\r\r";
			$message .= $transaction_details;
				
			SendMessage($supplier_address, $subject, $message, $headers);
		}
		
	} else if (strcmp ($payment_status, "Pending") == 0 ) { // The payment is pending
	
		$pending_reason = $_POST['pending_reason']; // Reason why this transaction is pending
		
		$subject = "PayPal transaction $payment_status ($pending_reason)";
		$message = "Greetings from $supplier_name_short,\r\r";
		
		if (strcmp ($pending_reason, "echeck") == 0 ) {
			$message .= "Thank you for your purchase. This e-mail confirms that you have sent an\r";
			$message .= "eCheck Payment for $payment_amount $payment_currency to us.\r\r";
			$message .= "This eCheck Payment will remain <Uncleared> until the funds have cleared\r";
			$message .= "from your account, which usually takes 4 business days.\r\r";
			$message .= "The serial numbers for the products you have purchased will be sent\r";
			$message .= "automatically as soon as the funds have cleared into our PayPal account.\r\r";
			$message .= $transaction_details;
		} else {
			$message .= "Thank you for your purchase. This e-mail confirms that you have sent a\r";
			$message .= "payment for $payment_amount $payment_currency to us.\r\r";
			$message .= "This Payment is pending (Reason: $pending_reason)\r\r";
			$message .= "The serial numbers for the products you have purchased will be sent\r";
			$message .= "automatically as soon as the funds have cleared into our PayPal account.\r\r";
			$message .= $transaction_details;
		}
		
		SendMessage($supplier_address, $subject, $message, $headers);    // Copy for Supplier
		SendMessage($customer_address, $subject, $message, $headers);    // Copy for customer
		
	} else { // Payment has *not* been successfully completed
	
		$subject = "PayPal transaction $payment_status (not handled)";
		$message = "$subject:\r\r";
		$message .= $transaction_details;
				
		SendMessage($supplier_address, $subject, $message, $headers);
		
	}
		
} else if (!$payment_verified) { // log for manual investigation

	$subject = "PayPal error";
	$message = "Error in processing.\r\r";
	$message .= $transaction_details;

	SendMessage($supplier_address, $subject, $message, $headers);
	
}

//--POST PAYMENT PROCESSES-------------------------------------------------------------

EmptyMailQueue();
DeleteFilesOlderThan("transactions", $txnid_daystokeep);

//--FUNCIONS---------------------------------------------------------------------------

// Send message and check result
function SendMessage($recipient, $subject, $message, $headers) {
	global $General;
$fromEmail = $General->get_site_emailId(); 
	$fromEmailName = $General->get_site_emailName();
	if ( stristr( $recipient, "@" ) !== FALSE ) {
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
		$result = wp_mail($recipient, $subject, $message, $headers);
		if ( !$result ) { LogDeliveryError($recipient, $subject, $message, $headers); }
	}
}

// If message has not been sent successfully we store it to the mailqueue directory
function LogDeliveryError($recipient, $subject, $message, $headers) {
	$filename = "mailqueue/" . date('YmdHis') . ".txt";
	$counter = 1;
	while (file_exists($filename)) {
		$filename = "mailqueue/" . date('YmdHis') . $counter . ".txt";
		$counter++;
	}
	$handle   = fopen($filename, "a+");
	$contents = "<msg_recipient>$recipient</msg_recipient>\n";
	$contents .= "<msg_subject>$subject</msg_subject>\n";
	$contents .= "<msg_headers>$headers</msg_headers>\n";
	$contents .= "<msg_body>" . str_replace("\r", "\n", $message). "</msg_body>\n";
	fputs($handle, $contents);
	fclose($handle);
}

// Look at mailqueue directory and send all messages
function EmptyMailQueue() {
	$path = "mailqueue";
	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {
			if ( $file != ".." && $file != "." ) { 
				$filename = "$path/$file";
				$filehandle = fopen($filename, "r");
				if ($filehandle) {
   					while (!feof($filehandle)) {
       					$contents .= fgets($filehandle, 4096);
   					}
   					fclose($filehandle);
   					$xmlFieldNames = array("msg_recipient", "msg_subject", "msg_headers", "msg_body");
					$data = ParseXMLData($contents, $xmlFieldNames);
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					$result = wp_mail($data['msg_recipient'], $data['msg_subject'], $data['msg_body'], $data['msg_headers']);
					if ( $result ) { unlink($filename); }
				}			
			}
		}
	closedir($handle);
	}
}

function ParseXMLData ($xmlRaw, $xmlFieldNames) {
	// $xmlRaw="<order>Order data</order><label>Label data</label><control>123</control>";
	// $xmlFieldNames=array("order", "label", "control");
	foreach ($xmlFieldNames as $xmlField) {
   		if(strpos($xmlRaw,$xmlField)!==false){
       		$parsedXML[$xmlField]=substr($xmlRaw, strpos($xmlRaw,"<$xmlField>")+strlen("<$xmlField>"), strpos($xmlRaw,"</$xmlField>")-strlen("<$xmlField>")-strpos($xmlRaw,"<$xmlField>"));
		}
	}
	return($parsedXML);
}

// Check if a transaction ID already exists
function CheckTransactionID($trans_id) {
	$path = "transactions";
	$filename = "$path/$trans_id.txt";
	$txn_exists = file_exists($filename);
	if (!$txn_exists) {
		$handle = fopen($filename, "a+");
		fclose($handle);
		//DeleteFilesOlderThan($path, $txnid_daystokeep); // moved to post payment processes
	}
	return $txn_exists;
}

// Get a new invoice number
function GetInvoiceNumber() {
	$filename = "invoice_counter.dat";	
	if ( file_exists( $filename ) ) {
		$lastmodifiedyear  = intval( date( "Y", filemtime( $filename ) ) );
		$handle  = fopen( $filename, "r+" );
		$counter = intval( fgets( $handle, 64 ) );
	} else {
		$handle  = fopen( $filename, "a+" );
		$counter = 0;
	}
	if ( flock( $handle, LOCK_EX ) ) {
		if ( intval( date("Y") ) == $lastmodifiedyear + 1 && date( "n" ) == 1 ) {
			ftruncate( $handle, 0 );
			$counter = 0;
		}	
		$counter++;
		rewind( $handle );
		fputs( $handle, $counter );
		flock( $handle, LOCK_UN );
	}
	fclose( $handle );
	return $counter;
}

// Save sale to excel sheet
function LogInvoice($invoice_number, $customer_name, $customer_country, $transaction_id, $item_purchased, $currency, $exchange_rate, $amount, $fee, $taxes) {
	$filename = "sales/" . date('Y') . "-" . date('m') . "-sales-" . $currency . ".xls";
	$exists = file_exists($filename);
	$handle   = fopen($filename, "a+");
	
	if ( flock( $handle, LOCK_EX ) ) {
		if (!$exists) {
			$newentry = "Invoice\tDate\tCustomer\tCountry\tTransaction\tProduct\tCurrency\tRate\tGross\tFee\tProfit\tTax\n";
			fputs($handle, $newentry);
		}
		if ($taxes <> '0' && $taxes <> "") {
			if ($customer_country != "") { $country_code = "($customer_country)"; }
			$customer_country = "European Union $country_code";
		} else if ($customer_country == "") {
			$customer_country = "US";
		}
		if ($taxes == "") { $taxes = "0"; }
		$profit = $amount - $fee - $taxes;
		$newentry = "$invoice_number\t" . date('m/d/Y') . "\t$customer_name\t$customer_country\t$transaction_id\t$item_purchased\t$currency\t$exchange_rate\t$amount\t$fee\t$profit\t$taxes\n";
		fputs($handle, $newentry);
		flock( $handle, LOCK_UN );
	}
	fclose($handle);
}

// Save invoice
function SaveInvoice($invoice_number, $invoice) {
	$path = "invoices/" . date('Y');
	if (!file_exists($path)) { mkdir($path, 0777); }
	$path = "invoices/" . date('Y') . "/" . date('m');
	if (!file_exists($path)) { mkdir($path, 0777); }
	$filename = "invoices/" . date('Y') . "/" . date('m') . "/$invoice_number.txt";
	$handle   = fopen($filename, "a+");
	$contents = str_replace("\r", "\n", $invoice);
	fputs($handle, $contents);
	fclose($handle);
}

function DeleteAllFilesFromDir($path) {
	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {
			if ( $file != ".." && $file != "." ) { unlink("$path/$file"); }
		}
	closedir($handle);
	}
}

function DeleteFilesOlderThan($path, $days) {
	if ( is_dir("$path") ) { 
		$handle = opendir($path); 
		while (false!==($file = readdir($handle))) { 
			if ($file != "." && $file != "..") {  
				$Diff = (time() - filectime("$path/$file"))/60/60/24;
				if ($Diff > $days) unlink("$path/$file");
			} 
		}
		closedir($handle); 
	}
}


?>