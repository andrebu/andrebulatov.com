<?php
	require_once('../../../../wp-load.php');
	global $wpdb;
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
	$cs_page_builder_template = get_option("cs_page_builder_template_readymade");
	$count_node = 0;
	if ( $cs_page_builder_template != "" ) {
		$sxe = new SimpleXMLElement( $cs_page_builder_template );
			foreach ( $sxe->children() as $template ) {
				//echo $template->attributes()."<br />";
				if ( $template->attributes() == $filter_name ) {
					foreach ( $template->children() as $node ) {
						include(TEMPLATEPATH."/include/load_all_sections.php");
					}
				}
			}

	}
?>