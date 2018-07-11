<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options() {

// Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages( 'parent=0' );
foreach ( $of_pages_obj as $of_page ) {
	$of_pages[$of_page->post_name] = $of_page->post_title;
}
$of_pages_tmp = array_unshift( $of_pages, __( 'Select a page:', 'flatbox' ) );

// get layout images
$admin_img_path =  ADMIN_DIR . 'assets/images/';
$portfolio_layouts = array(
	'3' => $admin_img_path . '4-col-portfolio.png',
	'4' => $admin_img_path . '3-col-portfolio.png',
	'6' => $admin_img_path . '2-col-portfolio.png',
);
$portfolio_layouts_keys = array_keys($portfolio_layouts);
$sidebar_layouts = array(
	'right' => $admin_img_path . '2cr.png',
	'left' => $admin_img_path . '2cl.png',
);
$sidebar_layouts_keys = array_keys($sidebar_layouts);

// Set the Options Array
global $of_options;
$of_options = array();

$of_options[] = array(
	"name" => __('General Settings','flatbox'),
	"type" => "heading"
);

$of_options[] = array(
	"name" => __('Logo Text', 'flatbox'),
	"desc" => __('Set the website logo text.', 'flatbox'),
	"id" => "logo_text",
	"std" => __('MyDesign', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Logo tagline Text', 'flatbox'),
	"desc" => __('Set the website logo tagline text.', 'flatbox'),
	"id" => "logo_tagline_text",
	"std" => __('just another theme', 'flatbox'),
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Main Logo Photo', 'flatbox'),
	"desc" => __('Select a graphic logo to be used instead of the text version - it will get resized to fit the theme\'s design. <span style="color:#d52">Recommanded size: 350px x 130px</span>', 'flatbox'),
	"id" => "custom_logo",
	"std" => '',
	"type" => "media"
);


$of_options[] = array(
	"name" => __('Custom Favicon', 'flatbox'),
	"desc" => __("Upload a 16px x 16px png / gif image that will represent your website's favicon", 'flatbox'),
	"id" => "custom_favicon",
	"std" => '',
	"type" => "media"
);

$of_options[] = array(
	"name" => __('Custom Site Image', 'flatbox'),
	"desc" => __('Upload custom site thumbnail image used by services like Facebook Share.', 'flatbox'),
	"id" => "custom_site_image",
	"std" => '',
	"type" => "media"
);

$of_options[] = array(
	"name" => __('Custom CSS', 'flatbox'),
	"desc" => __('Quickly add some CSS to your theme by adding it into this block.', 'flatbox'),
	"id" => "custom_css",
	"std" => "",
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Google Analytics Snippet', 'flatbox'),
	"desc" => __('Paste your Google Analytics (or other) tracking code here. This will be added into the head section of your website (must include script tags).', 'flatbox'),
	"id" => "tracking_header",
	"std" => '',
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Style Settings','flatbox'),
	"type" => "heading"
);

$of_options[] = array(
	"name" => __('Base Color','flatbox'),
	"desc" => __('Select the main color of the theme (leave field empty for default theme color).', 'flatbox'),
	"id" => "color_base",
	"std" => '',
	"type" => "color"
);

$of_options[] = array(
	"name" => __('Second Color','flatbox'),
	"desc" => __('Select the color of the secondary theme color in the content area (leave field empty for default theme color).', 'flatbox'),
	"id" => "color_link",
	"std" => '',
	"type" => "color"
);


// Home
$of_options[] = array(
	"name" => __('Home Page', 'flatbox'),
	"type" => "heading"
);

$homepage_blocks = array(
	"enabled" => array (
		"placebo" => "placebo", // REQUIRED!
		"intro_text" => __('Introduction Text', 'flatbox'),
		"call_to_action" => __('Call-To-Action Box', 'flatbox'),
	),
	"disabled" => array (
		"placebo" => "placebo", // REQUIRED!
		"flexslider_simple" => __('Simple Flexslider', 'flatbox'),
		"flexslider_detailed" => __('Detailed Flexslider', 'flatbox'),
		"roundabout" => __('RoundAbout Slider', 'flatbox'),
		"panorama360" => __('Panorama 360&deg;', 'flatbox'),
		"video" => __('Video Player', 'flatbox'),
		"general" => __('General Text', 'flatbox'),
		"features" => __('Features', 'flatbox'),
		"work" => __('Latest Work', 'flatbox'),
		"clients" => __('Clients', 'flatbox'),
		"quotes" => __('Quotes', 'flatbox'),
		"twitters" => __('Twitter', 'flatbox'),
		"toggles" => __('Toggles', 'flatbox'),
		"blog" => __('Recent Blog Posts', 'flatbox'),
		"progress1" => __('Progress bar', 'flatbox'),
		"progress2" => __('Progress circle', 'flatbox'),
		"showcase" => __('Showcase image', 'flatbox'),
	),
);

$new_homepage_blocksnew = array(
	"enabled" => array (
		"placebo" => "placebo", // REQUIRED!
		"intro_text" => __('Introduction Text', 'flatbox'),
		"call_to_action" => __('Call-To-Action Box', 'flatbox'),
	),
	"disabled" => array (
		"placebo" => "placebo", // REQUIRED!
		"Slider" => __('Slider', 'flatbox'),
		"features" => __('Features', 'flatbox'),
		"features_2" => __('Features 2', 'flatbox'),
		"posts" => __('Latest Posts', 'flatbox'),
		"milestone" => __('Milestones', 'flatbox'),
		"about" => __('About Us', 'flatbox'),
		"about_2" => __('About Us 2', 'flatbox'),
		"quotes" => __('Quotes', 'flatbox'),
		"social" => __('Social Boxes', 'flatbox'),
		"twitters" => __('Twitter', 'flatbox'),
		"contact" => __('Contact Us', 'flatbox'),
		"html1" => __('HTML 1', 'flatbox'),
		"html2" => __('HTML 2', 'flatbox'),
		"html3" => __('HTML 3', 'flatbox'),
		"html4" => __('HTML 4', 'flatbox'),
	),
);

$of_options[] = array(
	"name" => __('Homepage Layout Manager', 'flatbox'),
	"desc" => __('Organize what sections of the layout you want to appear on the homepage and their order. Use drag and drop to manage them.', 'flatbox'),
	"id" => "homepage_blocks3",
	"std" => $new_homepage_blocksnew,
	"type" => "sorter"
);

$of_options[] = array(
	"name" => __('Introduction Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('Homepage Introduction Text Header', 'flatbox'),
	"desc" => __('Introduce the heading text used for the Introduction Text section.', 'flatbox'),
	"id" => "homepage_intro_header",
	"std" => __('Flat design just blows my mind', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Homepage Introduction Paragraph', 'flatbox'),
	"desc" => __('Introduce the paragraph text used for the Introduction Text section.', 'flatbox'),
	"id" => "homepage_intro_text",
	"std" => __('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor aenean massaret. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus pellentesque eu pretium quis sem.', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Introduction Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the Introduction section.', 'flatbox'),
	"id" => "Introduction_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('Introduction Background Color','flatbox'),
	"desc" => __('Select the background color of Introduction section.', 'flatbox'),
	"id" => "Introduction_color",
	"std" => '',
	"type" => "color"
);


$of_options[] = array(
	"name" => __('Sliders Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Layer Slider ID', 'flatbox'),
	"desc" => __('Set the slider ID.', 'flatbox'),
	"id" => "ls_id",
	"std" => __('1', 'flatbox'),
	"type" => "text"
);
// $of_options[] = array(
// 	"name" => __('Homepage Slider Images', 'flatbox'),
// 	"desc" => __('Manage slides that will be use in Simple Flexslider, Detailed Flexslider and RoundAbout Slider. You can use drag and drop to sort the slides.', 'flatbox'),
// 	"id" => "homepage_slider",
// 	"std" => "",
// 	"type" => "new_slider"
// );

// $of_options[] = array(
// 	"name" => __('Resize Homepage Slider Images', 'flatbox'),
// 	"desc" => __('Resizes and optimizes images to a fixed 940x480 standard. If this option is turned off then original unmodified images will be used.', 'flatbox'),
// 	"id" => "homepage_slider_resize",
// 	"std" => 0,
// 	"type" => "switch"
// );

$of_options[] = array(
	"name" => __('Call us Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Call-To-Action Title', 'flatbox'),
	"desc" => __('Set the title of the Call-To-Action section (used if enabled).', 'flatbox'),
	"id" => "call_to_action_title",
	"std" => __('Hello, we are flatbox! Need more support or a free quote?', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Call-To-Action Text', 'flatbox'),
	"desc" => __('Set the text of the Call-To-Action section (used if enabled).', 'flatbox'),
	"id" => "call_to_action_text",
	"std" => __('Call Us (+1) 234 567 89 tellus curcus commondo, please contact us for everything you need.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Call-To-Action Button Text', 'flatbox'),
	"desc" => __('Set the text of the button in Call-To-Action section (used if enabled).', 'flatbox'),
	"id" => "call_to_action_button_text",
	"std" => __('Get in touch with us', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Call-To-Action Button URL', 'flatbox'),
	"desc" => __('Set the URL of the button in Call-To-Action section (used if enabled).', 'flatbox'),
	"id" => "call_to_action_button_url",
	"std" => __('mailto:name@yourdomain.com?subject=flatbox%20is%20great%21', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('call Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to this section.', 'flatbox'),
	"id" => "call_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('call Background Color','flatbox'),
	"desc" => __('Select the background color of this section.', 'flatbox'),
	"id" => "call_color",
	"std" => '',
	"type" => "color"
);

$of_options[] = array(
	"name" => __('Features Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Features Title', 'flatbox'),
	"desc" => __('Set the title of Features section.', 'flatbox'),
	"id" => "features_title",
	"std" => __('OUR SERVICES', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features Text', 'flatbox'),
	"desc" => __('Set the text of the Features section.', 'flatbox'),
	"id" => "features_text",
	"std" => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features Tagline', 'flatbox'),
	"desc" => __('Set the Tagline of the Features section.', 'flatbox'),
	"id" => "features_tagline",
	"std" => __('we now offer 24/7 phone and email customer support.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features Columns', 'flatbox'),
	"desc" => __('Sets the columns used for the Features section. Please introduce 4 slides for the columns to be well balanced.<br> Images Must be larger than 100*100 !', 'flatbox'),
	"id" => "features_slider",
	"std" => "",
	"type" => "slider"
);

$of_options[] = array(
	"name" => __('Features 2 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Features 2 Title', 'flatbox'),
	"desc" => __('Set the title of Features 2 section.', 'flatbox'),
	"id" => "features_title2",
	"std" => __('OUR SERVICES', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features 2 Text', 'flatbox'),
	"desc" => __('Set the text of the Features 2 section.', 'flatbox'),
	"id" => "features_text2",
	"std" => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features 2 Tagline', 'flatbox'),
	"desc" => __('Set the Tagline of the Features 2 section.', 'flatbox'),
	"id" => "features_tagline2",
	"std" => __('we now offer 24/7 phone and email customer support.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features 2 Columns', 'flatbox'),
	"desc" => __('Sets the columns used for the Features 2 section. Please introduce 4 slides for the columns to be well balanced.<br> Images Must be larger than 100*100 !', 'flatbox'),
	"id" => "features_slider2",
	"std" => "",
	"type" => "slider"
);
$of_options[] = array(
	"name" => __('Milestone Options','flatbox'),
	"desc" => __('Select the background color of Milestone section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Milestone Columns', 'flatbox'),
	"desc" => __('Sets the columns used for the Milestone section. Please introduce 4 slides for the columns to be well balanced.<br> Images Must be larger than 100*100 !', 'flatbox'),
	"id" => "milestone_slider",
	"std" => "",
	"type" => "slider"
);

$of_options[] = array(
	"name" => __('Milestone Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to this section.', 'flatbox'),
	"id" => "milestone_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('Milestone Background Color','flatbox'),
	"desc" => __('Select the background color of this section.', 'flatbox'),
	"id" => "milestone_color",
	"std" => '',
	"type" => "color"
);


//		testimonials ::::::::::::::::::::
$of_options[] = array(
	"name" => __('Testimonials Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('testimonials Image', 'flatbox'),
	"desc" => __('Upload an image to be the background of the testimonials section of the homepage.', 'flatbox'),
	"id" => "testimonials_image",
	"type" => "media"
);

$of_options[] = array(
	"name" => __('testimonials Background Color','flatbox'),
	"desc" => __('Select the background color of this section.', 'flatbox'),
	"id" => "testimonials_color",
	"std" => '',
	"type" => "color"
);

$of_options[] = array(
	"name" => __('About Us Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('About title', 'flatbox'),
	"desc" => __('Set the title for the About section.', 'flatbox'),
	"id" => "about_title",
	"std" => __('ABOUT US', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('About Us Description', 'flatbox'),
	"desc" => __('Set the text that will be displayed in the About section.', 'flatbox'),
	"id" => "about_info",
	"std" => __('We provide intelligent information to the world’s businesses and professionals, serving four primary customer groups. We have a leading market position, with well recognized and respected brands in each of our principal markets..', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Team tagline', 'flatbox'),
	"desc" => __('Set the tagline for the team section.', 'flatbox'),
	"id" => "about_tagline",
	"std" => __('Say <span class="blue-text">Hello</span> to our Team', 'flatbox'),
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Enable Join Us', 'flatbox'),
	"desc" => __('Enable & disable Join Us section inside team members', 'flatbox'),
	"id" => "join_us_switch",
	"std" => 1,
	"type" => "switch"
);

$of_options[] = array(
	"name" => __('Join Title', 'flatbox'),
	"desc" => __('Set the join title', 'flatbox'),
	"id" => "join_us_title",
	"std" => __('JOIN US', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Join tagline', 'flatbox'),
	"desc" => __('Set the join tagline', 'flatbox'),
	"id" => "join_us_tagline",
	"std" => __('We need a Secretary', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Join Us text', 'flatbox'),
	"desc" => __('Set the text that will be displayed in join section.', 'flatbox'),
	"id" => "join_us_text",
	"std" => __('Duis aute irure dolor in Boeing is the worlds leading aerosp ace company and the largest manufacturer of comm ercial jetliners and milit ary aircraft combined.', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Join button text', 'flatbox'),
	"desc" => __('Set the join button text', 'flatbox'),
	"id" => "join_us_but_text",
	"std" => __('Apply Now', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Join button link', 'flatbox'),
	"desc" => __('Set the join button link', 'flatbox'),
	"id" => "join_us_but",
	"std" => __('', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('About Us 2 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('About 2 title', 'flatbox'),
	"desc" => __('Set the title for the About section.', 'flatbox'),
	"id" => "about_title2",
	"std" => __('ABOUT US', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('About Us 2 Description', 'flatbox'),
	"desc" => __('Set the text that will be displayed in the About 2 section.', 'flatbox'),
	"id" => "about_info2",
	"std" => __('We provide intelligent information to the world’s businesses and professionals, serving four primary customer groups. We have a leading market position, with well recognized and respected brands in each of our principal markets..', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Team 2 tagline', 'flatbox'),
	"desc" => __('Set the tagline for the team 2 section.', 'flatbox'),
	"id" => "about_tagline2",
	"std" => __('Say <span class="blue-text">Hello</span> to our Team', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Team  Image', 'flatbox'),
	"desc" => __('Upload an image to be used as a team photo.', 'flatbox'),
	"id" => "team_img",
	"type" => "media"
);

$of_options[] = array(
	"name" => __('team Title', 'flatbox'),
	"desc" => __('Set the team title', 'flatbox'),
	"id" => "team_title",
	"std" => __('JOIN US', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team tagline', 'flatbox'),
	"desc" => __('Set the team tagline', 'flatbox'),
	"id" => "team_tagline",
	"std" => __('We need a Secretary', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team Us text', 'flatbox'),
	"desc" => __('Set the text that will be displayed in team section.', 'flatbox'),
	"id" => "team_text",
	"std" => __('Duis aute irure dolor in Boeing is the worlds leading aerosp ace company and the largest manufacturer of comm ercial jetliners and milit ary aircraft combined.', 'flatbox'),
	"type" => "textarea"
);


$of_options[] = array(
	"name" => __('team facebbok', 'flatbox'),
	"desc" => __('Set the team link', 'flatbox'),
	"id" => "team_facebook",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team twitter', 'flatbox'),
	"desc" => __('Set the team link', 'flatbox'),
	"id" => "team_twitter",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team forrst', 'flatbox'),
	"desc" => __('Set the team link', 'flatbox'),
	"id" => "team_forrst",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team dribbble', 'flatbox'),
	"desc" => __('Set the team link', 'flatbox'),
	"id" => "team_dribbble",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Enable Join Us', 'flatbox'),
	"desc" => __('Enable & disable Join Us section inside team members', 'flatbox'),
	"id" => "join_us_switch2",
	"std" => 1,
	"type" => "switch"
);

$of_options[] = array(
	"name" => __('Join Title', 'flatbox'),
	"desc" => __('Set the join title', 'flatbox'),
	"id" => "join_us_title2",
	"std" => __('JOIN US', 'flatbox'),
	"fold" 		=> "join_us_switch2",
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Join Us text', 'flatbox'),
	"desc" => __('Set the text that will be displayed in join section.', 'flatbox'),
	"id" => "join_us_text2",
	"std" => __('Duis aute irure dolor in Boeing is the worlds leading aerosp ace company and the largest manufacturer of comm ercial jetliners and milit ary aircraft combined.', 'flatbox'),
	"fold" 		=> "join_us_switch2",
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Join button text', 'flatbox'),
	"desc" => __('Set the join button text', 'flatbox'),
	"id" => "join_us_but_text2",
	"std" => __('Apply Now', 'flatbox'),
	"fold" 		=> "join_us_switch2",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Join button link', 'flatbox'),
	"desc" => __('Set the join button link', 'flatbox'),
	"id" => "join_us_but2",
	"std" => __('', 'flatbox'),
	"fold" 		=> "join_us_switch2",
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Twitter Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Twitter ID', 'flatbox'),
	"desc" => __('<strong> HOW TO CREATE A VALID ID TO USE: </strong>
		<br>
      * Go to www.twitter.com and sign in as normal, go to your settings page.
		<br>
      * Go to "Widgets" on the left hand side.
		<br>
      * Create a new widget for what you need eg "user timeline" or "search" etc. 
		<br>
      * Feel free to check "exclude replies" if you dont want replies in results.
		<br>
      * Now go back to settings page, and then go back to widgets page, you should
		<br>
      * see the widget you just created. Click edit.
		<br>
      * Now look at the URL in your web browser, you will see a long number like this:
		<br>
      * 377205624066433024
		<br>
      * Write this id here!
      ', 'flatbox'),
	"id" => "twitter_id",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Twitter Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to this section.', 'flatbox'),
	"id" => "twitter_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('Twitter Background Color','flatbox'),
	"desc" => __('Select the background color of this section.', 'flatbox'),
	"id" => "twitter_color",
	"std" => '',
	"type" => "color"
);


$of_options[] = array(
	"name" => __('Google Map Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Google Map Link', 'flatbox'),
	"desc" => __('<strong>Input google map link</strong>', 'flatbox'),
	"id" => "map_link",
	"std" => __('', 'flatbox'),
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Blog','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sep1",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Blog Title', 'flatbox'),
	"desc" => __('Set the section text.', 'flatbox'),
	"id" => "blog_text",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Blog Description', 'flatbox'),
	"desc" => __('Set the text that will be displayed in the blog homepage section=.', 'flatbox'),
	"id" => "home_blog_tagline",
	"std" => __('Please set your description regarding your clients.', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Blog button', 'flatbox'),
	"desc" => __('Set the button text.', 'flatbox'),
	"id" => "blog_button",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Blog button link', 'flatbox'),
	"desc" => __('Set the button link.', 'flatbox'),
	"id" => "blog_button_link",
	"std" => __('', 'flatbox'),
	"type" => "text"
);


//	HTML 1
$of_options[] = array(
	"name" => __('HTML 1 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('HTML 1 Text', 'flatbox'),
	"desc" => __('HTML  text used inside the section.', 'flatbox'),
	"id" => "html1_text",
	"std" => __('', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('HTML 1 Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the HTML 1 section.', 'flatbox'),
	"id" => "html1_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('HTML 1 Background Color','flatbox'),
	"desc" => __('Select the background color of HTML  section.', 'flatbox'),
	"id" => "html1_color",
	"std" => '',
	"type" => "color"
);

//	HTML 2
$of_options[] = array(
	"name" => __('HTML 2 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('HTML 2 Text', 'flatbox'),
	"desc" => __('HTML  text used inside the section.', 'flatbox'),
	"id" => "html2_text",
	"std" => __('', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('HTML 2 Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the HTML 1 section.', 'flatbox'),
	"id" => "html2_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('HTML 1 Background Color','flatbox'),
	"desc" => __('Select the background color of HTML  section.', 'flatbox'),
	"id" => "html2_color",
	"std" => '',
	"type" => "color"
);

//	HTML 3
$of_options[] = array(
	"name" => __('HTML 3 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('HTML 3 Text', 'flatbox'),
	"desc" => __('HTML  text used inside the section.', 'flatbox'),
	"id" => "html3_text",
	"std" => __('', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('HTML 3 Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the HTML 1 section.', 'flatbox'),
	"id" => "html3_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('HTML 3 Background Color','flatbox'),
	"desc" => __('Select the background color of HTML  section.', 'flatbox'),
	"id" => "html3_color",
	"std" => '',
	"type" => "color"
);

//	HTML 4
$of_options[] = array(
	"name" => __('HTML 1 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('HTML 4 Text', 'flatbox'),
	"desc" => __('HTML  text used inside the section.', 'flatbox'),
	"id" => "html4_text",
	"std" => __('', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('HTML 4 Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the HTML 1 section.', 'flatbox'),
	"id" => "html4_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('HTML 1 Background Color','flatbox'),
	"desc" => __('Select the background color of HTML  section.', 'flatbox'),
	"id" => "html4_color",
	"std" => '',
	"type" => "color"
);















































// Home 2
$of_options[] = array(
	"name" => __('Home Page 2', 'flatbox'),
	"type" => "heading"
);

$homepage_blocks = array(
	"enabled" => array (
		"placebo" => "placebo", // REQUIRED!
		"intro_text" => __('Introduction Text', 'flatbox'),
		"call_to_action" => __('Call-To-Action Box', 'flatbox'),
	),
	"disabled" => array (
		"placebo" => "placebo", // REQUIRED!
		"flexslider_simple" => __('Simple Flexslider', 'flatbox'),
		"flexslider_detailed" => __('Detailed Flexslider', 'flatbox'),
		"roundabout" => __('RoundAbout Slider', 'flatbox'),
		"panorama360" => __('Panorama 360&deg;', 'flatbox'),
		"video" => __('Video Player', 'flatbox'),
		"general" => __('General Text', 'flatbox'),
		"features" => __('Features', 'flatbox'),
		"work" => __('Latest Work', 'flatbox'),
		"clients" => __('Clients', 'flatbox'),
		"quotes" => __('Quotes', 'flatbox'),
		"twitters" => __('Twitter', 'flatbox'),
		"toggles" => __('Toggles', 'flatbox'),
		"blog" => __('Recent Blog Posts', 'flatbox'),
		"progress1" => __('Progress bar', 'flatbox'),
		"progress2" => __('Progress circle', 'flatbox'),
		"showcase" => __('Showcase image', 'flatbox'),
	),
);

$new_homepage_blocksnew = array(
	"enabled" => array (
		"placebo" => "placebo", // REQUIRED!
		"intro_text" => __('Introduction Text', 'flatbox'),
		"call_to_action" => __('Call-To-Action Box', 'flatbox'),
	),
	"disabled" => array (
		"placebo" => "placebo", // REQUIRED!
		"Slider" => __('Slider', 'flatbox'),
		"features" => __('Features', 'flatbox'),
		"features_2" => __('Features 2', 'flatbox'),
		"posts" => __('Latest Posts', 'flatbox'),
		"milestone" => __('Milestones', 'flatbox'),
		"about" => __('About Us', 'flatbox'),
		"about_2" => __('About Us 2', 'flatbox'),
		"quotes" => __('Quotes', 'flatbox'),
		"social" => __('Social Boxes', 'flatbox'),
		"twitters" => __('Twitter', 'flatbox'),
		"contact" => __('Contact Us', 'flatbox'),
		"html1" => __('HTML 1', 'flatbox'),
		"html2" => __('HTML 2', 'flatbox'),
		"html3" => __('HTML 3', 'flatbox'),
		"html4" => __('HTML 4', 'flatbox'),
	),
);

$of_options[] = array(
	"name" => __('Homepage Layout Manager', 'flatbox'),
	"desc" => __('Organize what sections of the layout you want to appear on the homepage and their order. Use drag and drop to manage them.', 'flatbox'),
	"id" => "my2_homepage_blocks3",
	"std" => $new_homepage_blocksnew,
	"type" => "sorter"
);

$of_options[] = array(
	"name" => __('Introduction Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('Homepage Introduction Text Header', 'flatbox'),
	"desc" => __('Introduce the heading text used for the Introduction Text section.', 'flatbox'),
	"id" => "my2_homepage_intro_header",
	"std" => __('Flat design just blows my mind', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Homepage Introduction Paragraph', 'flatbox'),
	"desc" => __('Introduce the paragraph text used for the Introduction Text section.', 'flatbox'),
	"id" => "my2_homepage_intro_text",
	"std" => __('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor aenean massaret. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus pellentesque eu pretium quis sem.', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Introduction Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the Introduction section.', 'flatbox'),
	"id" => "my2_Introduction_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('Introduction Background Color','flatbox'),
	"desc" => __('Select the background color of Introduction section.', 'flatbox'),
	"id" => "my2_Introduction_color",
	"std" => '',
	"type" => "color"
);


$of_options[] = array(
	"name" => __('Sliders Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Layer Slider ID', 'flatbox'),
	"desc" => __('Set the slider ID.', 'flatbox'),
	"id" => "my2_ls_id",
	"std" => __('1', 'flatbox'),
	"type" => "text"
);
// $of_options[] = array(
// 	"name" => __('Homepage Slider Images', 'flatbox'),
// 	"desc" => __('Manage slides that will be use in Simple Flexslider, Detailed Flexslider and RoundAbout Slider. You can use drag and drop to sort the slides.', 'flatbox'),
// 	"id" => "my2_homepage_slider",
// 	"std" => "",
// 	"type" => "new_slider"
// );

// $of_options[] = array(
// 	"name" => __('Resize Homepage Slider Images', 'flatbox'),
// 	"desc" => __('Resizes and optimizes images to a fixed 940x480 standard. If this option is turned off then original unmodified images will be used.', 'flatbox'),
// 	"id" => "my2_homepage_slider_resize",
// 	"std" => 0,
// 	"type" => "switch"
// );

$of_options[] = array(
	"name" => __('Call us Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Call-To-Action Title', 'flatbox'),
	"desc" => __('Set the title of the Call-To-Action section (used if enabled).', 'flatbox'),
	"id" => "my2_call_to_action_title",
	"std" => __('Hello, we are flatbox! Need more support or a free quote?', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Call-To-Action Text', 'flatbox'),
	"desc" => __('Set the text of the Call-To-Action section (used if enabled).', 'flatbox'),
	"id" => "my2_call_to_action_text",
	"std" => __('Call Us (+1) 234 567 89 tellus curcus commondo, please contact us for everything you need.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Call-To-Action Button Text', 'flatbox'),
	"desc" => __('Set the text of the button in Call-To-Action section (used if enabled).', 'flatbox'),
	"id" => "my2_call_to_action_button_text",
	"std" => __('Get in touch with us', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Call-To-Action Button URL', 'flatbox'),
	"desc" => __('Set the URL of the button in Call-To-Action section (used if enabled).', 'flatbox'),
	"id" => "my2_call_to_action_button_url",
	"std" => __('mailto:name@yourdomain.com?subject=flatbox%20is%20great%21', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('call Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to this section.', 'flatbox'),
	"id" => "my2_call_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('call Background Color','flatbox'),
	"desc" => __('Select the background color of this section.', 'flatbox'),
	"id" => "my2_call_color",
	"std" => '',
	"type" => "color"
);

$of_options[] = array(
	"name" => __('Features Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Features Title', 'flatbox'),
	"desc" => __('Set the title of Features section.', 'flatbox'),
	"id" => "my2_features_title",
	"std" => __('OUR SERVICES', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features Text', 'flatbox'),
	"desc" => __('Set the text of the Features section.', 'flatbox'),
	"id" => "my2_features_text",
	"std" => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features Tagline', 'flatbox'),
	"desc" => __('Set the Tagline of the Features section.', 'flatbox'),
	"id" => "my2_features_tagline",
	"std" => __('we now offer 24/7 phone and email customer support.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features Columns', 'flatbox'),
	"desc" => __('Sets the columns used for the Features section. Please introduce 4 slides for the columns to be well balanced.<br> Images Must be larger than 100*100 !', 'flatbox'),
	"id" => "my2_features_slider",
	"std" => "",
	"type" => "slider"
);

$of_options[] = array(
	"name" => __('Features 2 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Features 2 Title', 'flatbox'),
	"desc" => __('Set the title of Features 2 section.', 'flatbox'),
	"id" => "my2_features_title2",
	"std" => __('OUR SERVICES', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features 2 Text', 'flatbox'),
	"desc" => __('Set the text of the Features 2 section.', 'flatbox'),
	"id" => "my2_features_text2",
	"std" => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features 2 Tagline', 'flatbox'),
	"desc" => __('Set the Tagline of the Features 2 section.', 'flatbox'),
	"id" => "my2_features_tagline2",
	"std" => __('we now offer 24/7 phone and email customer support.', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Features 2 Columns', 'flatbox'),
	"desc" => __('Sets the columns used for the Features 2 section. Please introduce 4 slides for the columns to be well balanced.<br> Images Must be larger than 100*100 !', 'flatbox'),
	"id" => "my2_features_slider2",
	"std" => "",
	"type" => "slider"
);
$of_options[] = array(
	"name" => __('Milestone Options','flatbox'),
	"desc" => __('Select the background color of Milestone section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Milestone Columns', 'flatbox'),
	"desc" => __('Sets the columns used for the Milestone section. Please introduce 4 slides for the columns to be well balanced.<br> Images Must be larger than 100*100 !', 'flatbox'),
	"id" => "my2_milestone_slider",
	"std" => "",
	"type" => "slider"
);

$of_options[] = array(
	"name" => __('Milestone Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to this section.', 'flatbox'),
	"id" => "my2_milestone_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('Milestone Background Color','flatbox'),
	"desc" => __('Select the background color of this section.', 'flatbox'),
	"id" => "my2_milestone_color",
	"std" => '',
	"type" => "color"
);


//		testimonials ::::::::::::::::::::
$of_options[] = array(
	"name" => __('Testimonials Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('testimonials Image', 'flatbox'),
	"desc" => __('Upload an image to be the background of the testimonials section of the homepage.', 'flatbox'),
	"id" => "my2_testimonials_image",
	"type" => "media"
);

$of_options[] = array(
	"name" => __('testimonials Background Color','flatbox'),
	"desc" => __('Select the background color of this section.', 'flatbox'),
	"id" => "my2_testimonials_color",
	"std" => '',
	"type" => "color"
);

$of_options[] = array(
	"name" => __('About Us Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('About title', 'flatbox'),
	"desc" => __('Set the title for the About section.', 'flatbox'),
	"id" => "my2_about_title",
	"std" => __('ABOUT US', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('About Us Description', 'flatbox'),
	"desc" => __('Set the text that will be displayed in the About section.', 'flatbox'),
	"id" => "my2_about_info",
	"std" => __('We provide intelligent information to the world’s businesses and professionals, serving four primary customer groups. We have a leading market position, with well recognized and respected brands in each of our principal markets..', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Team tagline', 'flatbox'),
	"desc" => __('Set the tagline for the team section.', 'flatbox'),
	"id" => "my2_about_tagline",
	"std" => __('Say <span class="blue-text">Hello</span> to our Team', 'flatbox'),
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Enable Join Us', 'flatbox'),
	"desc" => __('Enable & disable Join Us section inside team members', 'flatbox'),
	"id" => "my2_join_us_switch",
	"std" => 1,
	"type" => "switch"
);

$of_options[] = array(
	"name" => __('Join Title', 'flatbox'),
	"desc" => __('Set the join title', 'flatbox'),
	"id" => "my2_join_us_title",
	"std" => __('JOIN US', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Join tagline', 'flatbox'),
	"desc" => __('Set the join tagline', 'flatbox'),
	"id" => "my2_join_us_tagline",
	"std" => __('We need a Secretary', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Join Us text', 'flatbox'),
	"desc" => __('Set the text that will be displayed in join section.', 'flatbox'),
	"id" => "my2_join_us_text",
	"std" => __('Duis aute irure dolor in Boeing is the worlds leading aerosp ace company and the largest manufacturer of comm ercial jetliners and milit ary aircraft combined.', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Join button text', 'flatbox'),
	"desc" => __('Set the join button text', 'flatbox'),
	"id" => "my2_join_us_but_text",
	"std" => __('Apply Now', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Join button link', 'flatbox'),
	"desc" => __('Set the join button link', 'flatbox'),
	"id" => "my2_join_us_but",
	"std" => __('', 'flatbox'),
	"fold" 		=> "join_us_switch",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('About Us 2 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('About 2 title', 'flatbox'),
	"desc" => __('Set the title for the About section.', 'flatbox'),
	"id" => "my2_about_title2",
	"std" => __('ABOUT US', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('About Us 2 Description', 'flatbox'),
	"desc" => __('Set the text that will be displayed in the About 2 section.', 'flatbox'),
	"id" => "my2_about_info2",
	"std" => __('We provide intelligent information to the world’s businesses and professionals, serving four primary customer groups. We have a leading market position, with well recognized and respected brands in each of our principal markets..', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Team 2 tagline', 'flatbox'),
	"desc" => __('Set the tagline for the team 2 section.', 'flatbox'),
	"id" => "my2_about_tagline2",
	"std" => __('Say <span class="blue-text">Hello</span> to our Team', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Team  Image', 'flatbox'),
	"desc" => __('Upload an image to be used as a team photo.', 'flatbox'),
	"id" => "my2_team_img",
	"type" => "media"
);

$of_options[] = array(
	"name" => __('team Title', 'flatbox'),
	"desc" => __('Set the team title', 'flatbox'),
	"id" => "my2_team_title",
	"std" => __('JOIN US', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team tagline', 'flatbox'),
	"desc" => __('Set the team tagline', 'flatbox'),
	"id" => "my2_team_tagline",
	"std" => __('We need a Secretary', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team Us text', 'flatbox'),
	"desc" => __('Set the text that will be displayed in team section.', 'flatbox'),
	"id" => "my2_team_text",
	"std" => __('Duis aute irure dolor in Boeing is the worlds leading aerosp ace company and the largest manufacturer of comm ercial jetliners and milit ary aircraft combined.', 'flatbox'),
	"type" => "textarea"
);


$of_options[] = array(
	"name" => __('team facebbok', 'flatbox'),
	"desc" => __('Set the team link', 'flatbox'),
	"id" => "my2_team_facebook",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team twitter', 'flatbox'),
	"desc" => __('Set the team link', 'flatbox'),
	"id" => "my2_team_twitter",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team forrst', 'flatbox'),
	"desc" => __('Set the team link', 'flatbox'),
	"id" => "my2_team_forrst",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('team dribbble', 'flatbox'),
	"desc" => __('Set the team link', 'flatbox'),
	"id" => "my2_team_dribbble",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Enable Join Us', 'flatbox'),
	"desc" => __('Enable & disable Join Us section inside team members', 'flatbox'),
	"id" => "my2_join_us_switch2",
	"std" => 1,
	"type" => "switch"
);

$of_options[] = array(
	"name" => __('Join Title', 'flatbox'),
	"desc" => __('Set the join title', 'flatbox'),
	"id" => "my2_join_us_title2",
	"std" => __('JOIN US', 'flatbox'),
	"fold" 		=> "join_us_switch2",
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Join Us text', 'flatbox'),
	"desc" => __('Set the text that will be displayed in join section.', 'flatbox'),
	"id" => "my2_join_us_text2",
	"std" => __('Duis aute irure dolor in Boeing is the worlds leading aerosp ace company and the largest manufacturer of comm ercial jetliners and milit ary aircraft combined.', 'flatbox'),
	"fold" 		=> "join_us_switch2",
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Join button text', 'flatbox'),
	"desc" => __('Set the join button text', 'flatbox'),
	"id" => "my2_join_us_but_text2",
	"std" => __('Apply Now', 'flatbox'),
	"fold" 		=> "join_us_switch2",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Join button link', 'flatbox'),
	"desc" => __('Set the join button link', 'flatbox'),
	"id" => "my2_join_us_but2",
	"std" => __('', 'flatbox'),
	"fold" 		=> "join_us_switch2",
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Twitter Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Twitter ID', 'flatbox'),
	"desc" => __('<strong> HOW TO CREATE A VALID ID TO USE: </strong>
		<br>
      * Go to www.twitter.com and sign in as normal, go to your settings page.
		<br>
      * Go to "Widgets" on the left hand side.
		<br>
      * Create a new widget for what you need eg "user timeline" or "search" etc. 
		<br>
      * Feel free to check "exclude replies" if you dont want replies in results.
		<br>
      * Now go back to settings page, and then go back to widgets page, you should
		<br>
      * see the widget you just created. Click edit.
		<br>
      * Now look at the URL in your web browser, you will see a long number like this:
		<br>
      * 377205624066433024
		<br>
      * Write this id here!
      ', 'flatbox'),
	"id" => "my2_twitter_id",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Twitter Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to this section.', 'flatbox'),
	"id" => "my2_twitter_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('Twitter Background Color','flatbox'),
	"desc" => __('Select the background color of this section.', 'flatbox'),
	"id" => "my2_twitter_color",
	"std" => '',
	"type" => "color"
);


$of_options[] = array(
	"name" => __('Google Map Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Google Map Link', 'flatbox'),
	"desc" => __('<strong>Input google map link</strong>', 'flatbox'),
	"id" => "my2_map_link",
	"std" => __('', 'flatbox'),
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Blog','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sep1",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Blog Title', 'flatbox'),
	"desc" => __('Set the section text.', 'flatbox'),
	"id" => "my2_blog_text",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Blog Description', 'flatbox'),
	"desc" => __('Set the text that will be displayed in the blog homepage section=.', 'flatbox'),
	"id" => "my2_home_blog_tagline",
	"std" => __('Please set your description regarding your clients.', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Blog button', 'flatbox'),
	"desc" => __('Set the button text.', 'flatbox'),
	"id" => "my2_blog_button",
	"std" => __('', 'flatbox'),
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Blog button link', 'flatbox'),
	"desc" => __('Set the button link.', 'flatbox'),
	"id" => "my2_blog_button_link",
	"std" => __('', 'flatbox'),
	"type" => "text"
);


//	HTML 1
$of_options[] = array(
	"name" => __('HTML 1 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('HTML 1 Text', 'flatbox'),
	"desc" => __('HTML  text used inside the section.', 'flatbox'),
	"id" => "my2_html1_text",
	"std" => __('', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('HTML 1 Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the HTML 1 section.', 'flatbox'),
	"id" => "my2_html1_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('HTML 1 Background Color','flatbox'),
	"desc" => __('Select the background color of HTML  section.', 'flatbox'),
	"id" => "my2_html1_color",
	"std" => '',
	"type" => "color"
);

//	HTML 2
$of_options[] = array(
	"name" => __('HTML 2 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('HTML 2 Text', 'flatbox'),
	"desc" => __('HTML  text used inside the section.', 'flatbox'),
	"id" => "my2_html2_text",
	"std" => __('', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('HTML 2 Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the HTML 1 section.', 'flatbox'),
	"id" => "my2_html2_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('HTML 1 Background Color','flatbox'),
	"desc" => __('Select the background color of HTML  section.', 'flatbox'),
	"id" => "my2_html2_color",
	"std" => '',
	"type" => "color"
);

//	HTML 3
$of_options[] = array(
	"name" => __('HTML 3 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('HTML 3 Text', 'flatbox'),
	"desc" => __('HTML  text used inside the section.', 'flatbox'),
	"id" => "my2_html3_text",
	"std" => __('', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('HTML 3 Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the HTML 1 section.', 'flatbox'),
	"id" => "my2_html3_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('HTML 3 Background Color','flatbox'),
	"desc" => __('Select the background color of HTML  section.', 'flatbox'),
	"id" => "my2_html3_color",
	"std" => '',
	"type" => "color"
);

//	HTML 4
$of_options[] = array(
	"name" => __('HTML 1 Options','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "my2_sadasd",
	"std" => '',
	"type" => "separator"
);


$of_options[] = array(
	"name" => __('HTML 4 Text', 'flatbox'),
	"desc" => __('HTML  text used inside the section.', 'flatbox'),
	"id" => "my2_html4_text",
	"std" => __('', 'flatbox'),
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('HTML 4 Background Image', 'flatbox'),
	"desc" => __('Upload an image to be used au a background to the HTML 1 section.', 'flatbox'),
	"id" => "my2_html4_bg",
	"type" => "media"
);
$of_options[] = array(
	"name" => __('HTML 1 Background Color','flatbox'),
	"desc" => __('Select the background color of HTML  section.', 'flatbox'),
	"id" => "my2_html4_color",
	"std" => '',
	"type" => "color"
);











































// Contact Form
$of_options[] = array(
	"name" => __('Contact Page', 'flatbox'),
	"type" => "heading"
);

$of_options[] = array(
	"name" => __('Contact Email', 'flatbox'),
	"desc" => __('Introduce your email address that will receive all messages from the contact form. The email will not be displayed in the HTML source file, only used to send the email.', 'flatbox'),
	"id" => "contact_email",
	"std" => '',
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Contact Email Subject', 'flatbox'),
	"desc" => __('Introduce the subject of the email you\'ll see in your inbox.', 'flatbox'),
	"id" => "contact_subject",
	"std" => 'Message received from the website contact form',
	"type" => "text"
);




$of_options[] = array(
	"name" => __('Contact Section title', 'flatbox'),
	"desc" => __('The title of the contact section.', 'flatbox'),
	"id" => "contact_title",
	"std" => 'CONTACT US',
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Contact Headline', 'flatbox'),
	"desc" => __('write a headline for the contact page.', 'flatbox'),
	"id" => "contact_headline",
	"std" => 'Here are some more information about us, you can get in touch with us any time you want.',
	"type" => "textarea"
);

$of_options[] = array(
	"name" => __('Address', 'flatbox'),
	"desc" => __('write your Location to be used in the additional info.', 'flatbox'),
	"id" => "contact_location",
	"std" => 'New York City',
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Email', 'flatbox'),
	"desc" => __('write your email to be used in the additional info.', 'flatbox'),
	"id" => "contact_info_email",
	"std" => 'my@gmail.com',
	"type" => "text"
);




$of_options[] = array(
	"name" => __('Phone Number', 'flatbox'),
	"desc" => __('write your Phone number to be used in the additional info.', 'flatbox'),
	"id" => "contact_phone",
	"std" => '+00951 985 427 81',
	"type" => "text"
);


$of_options[] = array(
	"name" => __('Contact note', 'flatbox'),
	"desc" => __('The note the contact section.', 'flatbox'),
	"id" => "contact_note",
	"std" => '',
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Contact wp-content Directory', 'flatbox'),
	"desc" => __('Introduce your wp-content directory name if different from <strong>wp-content</strong>. This will be used by the external sendmail.php script.', 'flatbox'),
	"id" => "contact_wpcontent_dir",
	"std" => 'wp-content',
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Subscribe Section','flatbox'),
	"desc" => __('Select the background color of progress section.', 'flatbox'),
	"id" => "wenak5sep1",
	"std" => '',
	"type" => "separator"
);

$of_options[] = array(
	"name" => __('Enable Subscribe Section', 'flatbox'),
	"desc" => __('Enable & disable Subscribe section in the footer', 'flatbox'),
	"id" => "subscribe_switch",
	"std" => 1,
	"type" => "switch"
);


$of_options[] = array(
	"name" => __('Subscribe Section title', 'flatbox'),
	"desc" => __('The title of the Subscribe section.', 'flatbox'),
	"id" => "subscribe_title",
	"std" => 'Subscribe to Our Newsletter!',
	"type" => "text"
);

$of_options[] = array(
	"name" => __('Subscribe Headline', 'flatbox'),
	"desc" => __('write a headline for the Subscribe page.', 'flatbox'),
	"id" => "subscribe_headline",
	"std" => 'Subscribe to our weekly newsletter to receive the latest freebies in your inbox!',
	"type" => "textarea"
);


// Footer
$of_options[] = array(
	"name" => __('Footer Area', 'flatbox'),
	"type" => "heading"
);

$footer_social2 = array(
	"enabled" => array (
		"placebo" => "placebo", // REQUIRED!
	
	),
	"disabled" => array (
		"placebo" => "placebo", // REQUIRED!
		"facebook" => __('Facebook', 'flatbox'),
		"youtube" => __('youtube', 'flatbox'),
		"twitter" => __('twitter', 'flatbox'),
		"rss" => __('rss', 'flatbox'),
		"amazon" => __('amazon', 'flatbox'),
		"behance" => __('behance', 'flatbox'),
		"blogger" => __('blogger', 'flatbox'),
		"deviantart" => __('deviantart', 'flatbox'),
		"digg" => __('digg', 'flatbox'),
		"dribbble" => __('dribbble', 'flatbox'),
		"dropbox" => __('dropbox', 'flatbox'),
		"ebay" => __('ebay', 'flatbox'),
		"flickr" => __('flickr', 'flatbox'),
		"forrst" => __('forrst', 'flatbox'),
		"google" => __('google', 'flatbox'),
		"instagram" => __('instagram', 'flatbox'),
		"linkedin" => __('linkedin', 'flatbox'),
		"myspace" => __('myspace', 'flatbox'),
		"paypal" => __('paypal', 'flatbox'),
		"pinterest" => __('pinterest', 'flatbox'),
		"skype" => __('skype', 'flatbox'),
		"soundcloud" => __('soundcloud', 'flatbox'),
		"tumblr" => __('tumblr', 'flatbox'),
		"twitter" => __('twitter', 'flatbox'),
		"vimeo" => __('vimeo', 'flatbox'),
		"wordpress" => __('wordpress', 'flatbox'),
		"yahoo" => __('yahoo', 'flatbox'),
		

	),
);

$of_options[] = array(
	"name" => __('Footer Text', 'flatbox'),
	"desc" => __('You can use the following shortcodes in your footer text: [wp-link] [loginout-link] [blog-title] [blog-link] [the-year]', 'flatbox'),
	"id" => "footer_text",
	"std" => __('&copy; [the-year] [blog-title]. All Rights Reserved.', 'flatbox'),
	"type" => "textarea"
);


// Footer social links
$of_options[] = array(
	"name" => __('Facebook Profile', 'flatbox'),
	"desc" => __('Input your Facebook Profile URL.', 'flatbox'),
	"id" => "footer-facebook",
	"type" => "text"
);

$of_options[] = array(
	"name" => __('twitter Profile', 'flatbox'),
	"desc" => __('Input your twitter Profile URL.', 'flatbox'),
	"id" => "footer-twitter",
	"type" => "text"
);



$of_options[] = array(
	"name" => __('dribbble Profile', 'flatbox'),
	"desc" => __('Input your dribbble Profile URL.', 'flatbox'),
	"id" => "footer-dribbble",
	"type" => "text"
);


$of_options[] = array(
	"name" => __('forrst Profile', 'flatbox'),
	"desc" => __('Input your forrst Profile URL.', 'flatbox'),
	"id" => "footer-forrst",
	"type" => "text"
);


// 404
$of_options[] = array(
	"name" => __('Not Found 404', 'flatbox'),
	"type" => "heading"
);

$of_options[] = array(
	"name" => __('404 Image', 'flatbox'),
	"desc" => __('Select an image to be used as a 404 page not found graphics.', 'flatbox'),
	"id" => "404_image",
	"std" => '',
	"type" => "media"
);

$of_options[] = array(
	"name" => __('404 Text', 'flatbox'),
	"desc" => __('Input your error message that gets displayed on the 404 page not found template.', 'flatbox'),
	"id" => "404_text",
	"std" => 'The page you are looking for has vanished. Maybe it was never here or it was moved to a better place. You\'ll never know.',
	"type" => "textarea"
);

// Support
$of_options[] = array(
	"name" => __('Support', 'flatbox'),
	"type" => "heading"
);

$star_img = '<img src="' . get_template_directory_uri() . '/utils/admin/assets/images/icon-star2.png" />';
$of_options[] = array(
	"name" => __('Support', 'flatbox'),
	"id" => "updates_info",
	"std" => __('<strong>When encountering any issue please consult the documentation of this theme (from main purchased file) and do a quick internet search related to the issue - it might be a WordPress issue and not theme related.</strong> <br /><br />If you have no luck then send us a message via ThemeForest so we can validate your purchase first - please include your preview URL or temporary access to your WordPress admin in order for us to take a look as quick as possible. we will do our best to help out. <br /><br /> <a class="button-secondary rate" href="http://themeforest.net/downloads" target="_blank">Rate the theme first ' . $star_img . $star_img . $star_img . $star_img . $star_img . '</a> <a class="button-primary" href="http://themeforest.net/user/wenak" target="_blank">Send us a private message</a>', 'flatbox'),
	"type" => "info"
);

// Backup Options
$of_options[] = array(
	"name" => __('Backup Options', 'flatbox'),
	"type" => "heading"
);

$of_options[] = array(
	"name" => __('Backup and Restore Options', 'flatbox'),
	"id" => "of_backup",
	"std" => "",
	"type" => "backup",
	"desc" => __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'flatbox'),
);

$of_options[] = array(
	"name" => __('Transfer Theme Options Data', 'flatbox'),
	"id" => "of_transfer",
	"std" => "",
	"type" => "transfer",
	"desc" => __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".', 'flatbox'),
);

}
}
?>
