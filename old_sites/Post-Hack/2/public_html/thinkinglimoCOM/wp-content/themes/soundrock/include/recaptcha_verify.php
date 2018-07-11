<?php
	require_once('../../../../wp-load.php');
	$cs_gs_google_recaptcha_keys = get_option( "cs_gs_google_recaptcha_keys" );
		if ( $cs_gs_google_recaptcha_keys <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_google_recaptcha_keys);
				$cs_private_key = $sxe->cs_private_key;
		}

	require_once('recaptchalib.php');
	
	$resp = recaptcha_check_answer ($cs_private_key,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]);
	if (!$resp->is_valid) {
		echo "Invalid Recaptcha Code";
	} else {
		echo "Valid";
	}
?>