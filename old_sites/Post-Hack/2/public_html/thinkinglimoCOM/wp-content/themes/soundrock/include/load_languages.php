<?php
	require_once('../../../../wp-load.php');
	global $wpdb;
	foreach ($_POST as $keys=>$values) {
		$$keys = $values;
	}
	
	$lang_theme_db = '';
	$lang_theme_db = get_option("lang_theme");
		if ( isset($lang_theme) ) {
//			if ( get_option("lang_style") <> "" ) {
//				update_option("lang_style", $lang_style);
//			}
//			else {
//				add_option( "lang_style", $lang_style, '', '');
//			}
				if ( $lang_theme_db <> "false" ){
					update_option("lang_theme", $lang_theme);
				}
				else {
					add_option( "lang_theme", $lang_theme, '', '');
				}
					// upating config file start
					$fname = ABSPATH."wp-config.php";
					$fhandle = fopen($fname,"r");
					$content = fread($fhandle,filesize($fname));
					$content = str_replace("define('WPLANG', '$lang_theme_db')", "define('WPLANG', '$lang_theme')", $content);
					$fhandle = fopen($fname,"w");
					fwrite($fhandle,$content);
					fclose($fhandle);
					// upating config file end
		}
	
	//if ($lang_style == "Right to Left"){
	?>
		<!--<link rel="stylesheet" type="text/css" media="all" href="<?php //echo get_template_directory_uri(); ?>/style_rtl.css" />-->
	<?php
	//}
	header("location:".get_bloginfo('siteurl')."/wp-admin/admin.php?page=manage_languages&mess=1");
?>