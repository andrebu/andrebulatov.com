<?php
	require_once('../../../../wp-load.php');
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
		$sxe = new SimpleXMLElement("<social_network></social_network>");
			$sxe->addChild('twitter', $twitter );
			$sxe->addChild('facebook', $facebook );
			$sxe->addChild('linkedin', $linkedin );
			$sxe->addChild('digg', $digg );
			$sxe->addChild('delicious', $delicious );
			$sxe->addChild('google_plus', $google_plus );
			$sxe->addChild('google_buzz', $google_buzz );
			$sxe->addChild('google_bookmark', $google_bookmark );
			$sxe->addChild('myspace', $myspace );
			$sxe->addChild('reddit', $reddit );
			$sxe->addChild('stumbleupon', $stumbleupon );
			$sxe->addChild('youtube', $youtube );
			$sxe->addChild('feedburner', $feedburner );
			$sxe->addChild('flickr', $flickr );
			$sxe->addChild('picasa', $picasa );
			$sxe->addChild('vimeo', $vimeo );
			$sxe->addChild('tumblr', $tumblr );
		update_option( "cs_social_network", $sxe->asXML() );
	echo "Social Network Settings Saved";
?>