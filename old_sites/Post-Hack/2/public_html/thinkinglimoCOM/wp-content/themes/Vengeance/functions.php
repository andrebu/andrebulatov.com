<?php //Begin widget code

if ( function_exists('register_sidebars') )

    register_sidebars(2);

?>
<?php



add_filter('comments_template', 'legacy_comments');



function legacy_comments($file) {



	if(!function_exists('wp_list_comments')) : // WP 2.7-only check

		$file = TEMPLATEPATH . '/legacy.comments.php';

	endif;



	return $file;

}

?>
<?php

$themename = "Vengeance";

$shortname = "pt";

$options = array (

    

array(	"name" => "General Settings",

		"type" => "heading"),



    array(  "name" => "Your Feedburner address",

			"desc" => "Specify Your Feedburner address here.",

            "id" => $shortname."_feedburner_address",

            "std" => "",

            "type" => "text"),

			

    array(  "name" => "Your Feedburner ID",

			"desc" => "Specify Your Feedburner ID here.",

            "id" => $shortname."_feedburner_id",

            "std" => "",

            "type" => "text"),



    array(  "name" => "Your Flickr ID",

			"desc" => "Specify Your Flickr ID here - Use the <a href='http://idgettr.com'>idGettr</a> to find your id.",

            "id" => $shortname."_flickr_id",

            "std" => "7778300@N04",

            "type" => "text"),

    

array(	"name" => "Theme Appearance Settings",

		"type" => "heading"),

		

    array(  "name" => "Title Logo as Image or Text?",

			"desc" => "The Site title should be displayed an Image or Text?",

            "id" => $shortname."_logo_appearance",

            "std" => "image",

            "type" => "select",

			"options" => array("image", "text")),

						

    array(  "name" => "Blog Alignment",

			"desc" => "Blog should be centered, left or right aligned?",

            "id" => $shortname."_blog_alignment",

            "std" => "center",

            "type" => "select",

			"options" => array("left", "right", "center")),

						    

    array(  "name" => "Text Primary Color",

			"desc" => "Specify primary color that will be used for normal text",

            "id" => $shortname."_body_color",

            "std" => "333",

            "type" => "text"),



    array(  "name" => "Normal Font Size",

			"desc" => "Specify font size for the normal text",

            "id" => $shortname."_body_font_size",

            "std" => "12",

            "type" => "text"),

    

    array(  "name" => "Font Family",

			"desc" => "Specify Font Family for the normal text",

            "id" => $shortname."_body_font_family",

            "std" => "Arial",

            "type" => "select",

			"options" => array("Georgia", "trebuchet MS", "Arial", "Verdana", "Lucida Sans", "Helvetica", "sans-serif" )),

			

	  array(  "name" => "Sidebar Position",

			"desc" => "Sidebar Position set Left or Right",

            "id" => $shortname."_sidebar_position",

            "std" => "right",

            "type" => "select",

			"options" => array("left", "right")),

			

array(	"name" => "Advertise Management",

		"type" => "heading"),

 	

		array(  "name" => "Advertise 1 Image Source",

			"desc" => "Path of the image to be displayed in sidebar section - Right Panel",

            "id" => $shortname."_ad_two",

            "std" => "http://premiumthemes.net/_data/banner/advt125x125_1.png",

            "type" => "text"),



    array(  "name" => "Advertise 1 Link",

			"desc" => "Where the advertise 2 should be linked?",

            "id" => $shortname."_ad_two_link",

            "std" => "http://premiumthemes.net/",

            "type" => "text"),

			

	array(  "name" => "Advertise 2 Image Source",

			"desc" => "Path of the image to be displayed in sidebar section - Sidebar",

            "id" => $shortname."_ad_three",

            "std" => "http://premiumthemes.net/_data/banner/advt125x125_1_xhtmthis.gif",

            "type" => "text"),



    array(  "name" => "Advertise 2 Link",

			"desc" => "Where the advertise 3 should be linked?",

            "id" => $shortname."_ad_three_link",

            "std" => "http://xhtmlthis.com",

            "type" => "text"),

			

	array(  "name" => "Advertise 3 Image Source",

			"desc" => "Path of the image to be displayed in sidebar section - Sidebar",

            "id" => $shortname."_ad_four",

            "std" => "http://premiumthemes.net/_data/banner/advt125x125_1_cssace.gif",

            "type" => "text"),



    array(  "name" => "Advertise 3 Link",

			"desc" => "Where the advertise 3 should be linked?",

            "id" => $shortname."_ad_four_link",

            "std" => "http://cssace.com/wp-premium-theme",

            "type" => "text")	

	

);





function mytheme_add_admin() {



    global $themename, $shortname, $options;



    if ( $_GET['page'] == basename(__FILE__) ) {

    

        if ( 'save' == $_REQUEST['action'] ) {



                foreach ($options as $value) {

                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }



                foreach ($options as $value) {

                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }



                header("Location: themes.php?page=functions.php&saved=true");

                die;



        } else if( 'reset' == $_REQUEST['action'] ) {



            foreach ($options as $value) {

                delete_option( $value['id'] ); }



            header("Location: themes.php?page=functions.php&reset=true");

            die;



        }

    }



    add_theme_page($themename." Options", "Current Theme Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');



}



function mytheme_admin() {



    global $themename, $shortname, $options;



    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';

    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';

    

?>

<div class="wrap">
<h2><?php echo $themename; ?> settings</h2>
<form method="post">
  <table class="optiontable">
    <?php foreach ($options as $value) {

    

if ($value['type'] == "heading") { ?>
    <tr valign="top">
      <td colspan="2"><h3 style=" font:bold 15px Tahoma; border-bottom:1px solid #0C6; color: #090"><?php echo $value['name']; ?></h3></td>
    </tr>
    <?php } elseif ($value['type'] == "text") { ?>
    <tr valign="top">
      <th scope="row" style="font:bold 11px Verdana, Arial, Helvetica, sans-serif; padding-top:10px;"><?php echo $value['name']; ?>:</th>
      <td><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
        <br />
        <small><?php echo $value['desc'] ; ?></small> </td>
    </tr>
    <?php } elseif ($value['type'] == "select") { ?>
    <tr valign="top">
      <th scope="row" style="font:bold 11px Verdana; padding-top:10px;"><?php echo $value['name']; ?>:</th>
      <td style="font:11px Verdana, Arial, Helvetica, sans-serif;"><select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
          <?php foreach ($value['options'] as $option) { ?>
          <option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
          <?php } ?>
        </select>
        <br />
        <small><?php echo $value['desc'] ; ?></small> </td>
    </tr>
    <?php

}

}

?>
  </table>
  <p class="submit">
    <input name="save" type="submit" value="Save changes" />
    <input type="hidden" name="action" value="save" />
  </p>
</form>
<form method="post">
  <p class="submit">
    <input name="reset" type="submit" value="Reset" />
    <input type="hidden" name="action" value="reset" />
  </p>
</form>
<?php

}



function mytheme_wp_head() { ?>
<link href="<?php bloginfo('template_directory'); ?>/style.php" rel="stylesheet" type="text/css" />
<?php }



add_action('wp_head', 'mytheme_wp_head');

add_action('admin_menu', 'mytheme_add_admin'); ?>
