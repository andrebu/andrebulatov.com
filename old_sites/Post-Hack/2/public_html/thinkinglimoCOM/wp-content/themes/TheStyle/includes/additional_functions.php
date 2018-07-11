<?php 

/* Meta boxes */

function thestyle_add_custom_panels(){
	add_meta_box("et_post_meta", "ET Settings", "thestyle_post_meta", "post", "normal", "high");
}
add_action("admin_init", "thestyle_add_custom_panels");

function thestyle_post_meta() {
	global $post;

	$custom = get_post_custom($post->ID);
	
	$et_bigpost = isset($custom["et_bigpost"][0]) ? (bool) $custom["et_bigpost"][0] : false; ?>
	
	<div style="margin: 13px 0 11px 4px;">
		<label class="selectit" for="et_bigpost">
			<input type="checkbox" name="et_bigpost" id="et_bigpost" value=""<?php checked( $et_bigpost ); ?> /> Big Post</label><br/>
	</div>

	<?php
}

function thestyle_custom_panel_save($post_id){
	global $pagenow;
	
	if ( 'post.php' != $pagenow ) return $post_id;
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
		
	if ( isset($_POST["et_bigpost"]) ) update_post_meta( $post_id, "et_bigpost", 1 );
	else update_post_meta( $post_id, "et_bigpost", 0 );	
}
add_action('save_post', 'thestyle_custom_panel_save'); ?>