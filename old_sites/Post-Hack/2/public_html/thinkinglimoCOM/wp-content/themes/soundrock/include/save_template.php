<?php
	require_once('../../../../wp-load.php');
	$cs_page_builder_template = get_option("cs_page_builder_template");
	if ( $cs_page_builder_template != "" ) {
		$sxe = new SimpleXMLElement( $cs_page_builder_template );
			foreach ( $sxe->children() as $node ) {
				if ( $node->attributes() == $_POST['template_name'] ) {
					$already_exist = "This Template Already Exist";
				}
			}
	}
	
if ( $_POST['template_name'] == "" ) {
	echo "Template Name is Required";
}
else if ( $already_exist <> "" ) {
	echo $already_exist;
}
else {
	if ( $cs_page_builder_template == "" ) { $cs_page_builder_template = "<pagebuilder_templates></pagebuilder_templates>"; }
		$sxe_main = new SimpleXMLElement( $cs_page_builder_template );
			$sxe = $sxe_main->addChild('template');
			$sxe->addAttribute('name', $_POST['template_name']);
				include(TEMPLATEPATH."/include/save_all_sections.php");
					update_option( "cs_page_builder_template", $sxe_main->asXML() );
		echo "<script>hide_template_name()</script>";
	echo "Template Saved";
}
?>
