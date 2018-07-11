<ul>
<?php
if ( !isset($post) ) { 
	include('../../../../wp-load.php');
}
	$cs_page_builder_template = get_option("cs_page_builder_template");
	if ( $cs_page_builder_template != "" ) {
		$sxe = new SimpleXMLElement( $cs_page_builder_template );
			foreach ( $sxe->children() as $node ) {
			?>
                <li>
                	<a class="delet" onclick="javascript: return confirm('Are you sure you want to delete this Template?')" href="javascript:del_page_builder_template('<?php echo $node->attributes()?>')">&nbsp;</a>
                	<a href="javascript:add_page_builder_template('<?php echo $node->attributes()?>')" class="temp-btn">
                        <span class="temp-del">&nbsp;</span>
                        <span><?php echo $node->attributes()?></span>
                    </a>
                </li>
            <?php
			}
	}
	
?>
</ul>