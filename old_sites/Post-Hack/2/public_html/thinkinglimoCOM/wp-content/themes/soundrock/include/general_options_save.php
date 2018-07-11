<?php
require_once('../../../../wp-load.php');
global $wpdb;
foreach ($_REQUEST as $keys=>$values) {
	$$keys = $values;
}
	
	if ( $tab == "color_style" ) {
		$sxe = new SimpleXMLElement("<cs_gs_color_style></cs_gs_color_style>");
			$sxe->addChild('cs_color_scheme', $cs_color_scheme );
			$sxe->addChild('cs_style_sheet', $cs_style_sheet );
		update_option( "cs_gs_color_style", $sxe->asXML() );
		echo "Color and Styles Saved";
	}
	else if ( $tab == "logo" ) {
		$sxe = new SimpleXMLElement("<cs_gs_logo></cs_gs_logo>");
			$sxe->addChild('cs_logo', $cs_logo );
			$sxe->addChild('cs_width', $cs_width );
			$sxe->addChild('cs_height', $cs_height );
		update_option( "cs_gs_logo", $sxe->asXML() );
		echo "Logo Settings Saved";
	}
	else if ( $tab == "header_script" ) {
		$sxe = new SimpleXMLElement("<cs_gs_header_script></cs_gs_header_script>");
			$sxe->addChild('cs_header_code', $cs_header_code );
			$sxe->addChild('cs_fav_icon', $cs_fav_icon );
		update_option( "cs_gs_header_script", $sxe->asXML() );
		echo "Header Script Saved";
	}
	else if ( $tab == "footer_settings" ) {
		$sxe = new SimpleXMLElement("<cs_gs_footer_settings></cs_gs_footer_settings>");
			$sxe->addChild('cs_footer_logo', $cs_footer_logo );
			$sxe->addChild('cs_copyright', $cs_copyright );
			$sxe->addChild('cs_powered_by', $cs_powered_by );
			$sxe->addChild('cs_powered_icon', $cs_powered_icon );
			$sxe->addChild('cs_analytics', $cs_analytics );
			$sxe->addChild('cs_footer_contact', stripslashes($_POST['cs_footer_contact']) );
		update_option( "cs_gs_footer_settings", $sxe->asXML() );
		echo "Footer Settings Saved";
	}
	else if ( $tab == "google_recaptcha_keys" ) {
		$sxe = new SimpleXMLElement("<cs_gs_google_recaptcha_keys></cs_gs_google_recaptcha_keys>");
			if ( empty($re_captcha) ) $re_captcha = '';
				$sxe->addChild('re_captcha', $re_captcha );
				$sxe->addChild('cs_public_key', $cs_public_key );
				$sxe->addChild('cs_private_key', $cs_private_key );
		update_option( "cs_gs_google_recaptcha_keys", $sxe->asXML() );
		echo "Google Re-Captcha Keys Settings Saved";
	}
	else if ( $tab == "tab_responsive" ) {
		if ( empty($responsive) ) $responsive = '';
		update_option( "cs_gs_responsive", $responsive );
		echo "Responsive Settings Saved";
	}

?>