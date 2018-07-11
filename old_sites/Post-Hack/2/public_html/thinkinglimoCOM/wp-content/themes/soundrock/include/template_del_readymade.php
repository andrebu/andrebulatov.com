<?php
//	echo $_POST['name'];
	require_once('../../../../wp-load.php');
	$cs_page_builder_template = get_option("cs_page_builder_template_readymade");
	if ( $cs_page_builder_template != "" ) {
		$data = new SimpleXMLElement( $cs_page_builder_template );
			foreach ( $data->template as $template )
			{
				if ( $template['name'] == $_POST['name'] ) {
					$dom = dom_import_simplexml($template);
					$dom->parentNode->removeChild($dom);
				}
			}
			update_option( "cs_page_builder_template_readymade", $data->asXml() );
	}
	include("templates_readymade.php");
?>