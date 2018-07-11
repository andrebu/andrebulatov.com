<?php

function wpordercart_geturlstringvalue($urlStringName, $returnIfNotSet) {
  if (isset($_GET[$urlStringName]) && $_GET[$urlStringName] != "") return $_GET[$urlStringName]; else return $returnIfNotSet; 
}

function wpordercartsendmail($to, $from, $replyto, $subject, $message) {
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: ' . $from . "\r\n" . 'Reply-To: ' . $replyto . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	if(mail($to, $subject, $message, $headers)){ return true; } else { return false; }
}

?>