<?php
if ( empty($post->ID) ) $post->ID = "";
	if ( $node->getName() == "rich_editor" ) {
		$rich_editor = 1;
		include(TEMPLATEPATH."/include/cs_meta_load_rich_editor.php");
	}
	else if ( $node->getName() == "gallery" ) {
		include(TEMPLATEPATH."/include/gallery_pb.php");
	}
	else if ( $node->getName() == "event" ) {
		include(TEMPLATEPATH."/include/event_pb.php");
	}
	else if ( $node->getName() == "slider" ) {
		include(TEMPLATEPATH."/include/slider_pb.php");
	}
	else if ( $node->getName() == "blog" ) {
		include(TEMPLATEPATH."/include/cs_meta_load_blog.php");
	}
	else if ( $node->getName() == "news" ) {
		include(TEMPLATEPATH."/include/cs_meta_load_news.php");
	}
	else if ( $node->getName() == "contact" ) {
		include(TEMPLATEPATH."/include/cs_meta_load_contact.php");
	}
	else if ( $node->getName() == "album" ) {
		include(TEMPLATEPATH."/include/album_pb.php");
	}
?>