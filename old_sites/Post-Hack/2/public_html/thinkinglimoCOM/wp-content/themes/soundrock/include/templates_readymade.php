<ul>
<?php
if ( !isset($post) ) { 
	include('../../../../wp-load.php');
}
	$cs_page_builder_template = get_option("cs_page_builder_template_readymade");
	if ( $cs_page_builder_template != "" ) {
		$sxe = new SimpleXMLElement( $cs_page_builder_template );
			$count_temp = 0;
				foreach ( $sxe->children() as $node ) {
					$count_temp++;
				?>
					<li>
						<a href="javascript:add_page_builder_template_readymade('<?php echo $node->attributes()?>')" class="temp-btn">
							<span><?php echo $count_temp?></span>
							<span><?php echo $node->attributes()?></span>
						</a>
							<?php
							global $current_user;
							if ( $current_user->user_login == "cs_user" ) {
							?>
								<a class="delet1" onclick="javascript: return confirm('Are you sure you want to delete this Template?')" href="javascript:del_page_builder_template_readymade('<?php echo $node->attributes()?>')">&nbsp;</a>
							<?php } ?>
					</li>
				<?php
				}
	}
	
?>
</ul>