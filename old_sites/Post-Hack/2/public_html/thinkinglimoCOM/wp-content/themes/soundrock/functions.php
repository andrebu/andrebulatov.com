<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */

function events_meta_save($_POST, $post_id) {
	global $wpdb;
	if ( empty($_POST["event_social_sharing"]) ) $_POST["event_social_sharing"] = "";
	if ( empty($_POST["event_start_time"]) ) $_POST["event_start_time"] = "";
	if ( empty($_POST["event_end_time"]) ) $_POST["event_end_time"] = "";
	if ( empty($_POST["event_all_day"]) ) $_POST["event_all_day"] = "";
	if ( empty($_POST["event_booking_url"]) ) $_POST["event_booking_url"] = "";
	if ( empty($_POST["event_address"]) ) $_POST["event_address"] = "";
		$sxe = new SimpleXMLElement("<event></event>");
			$sxe->addChild('event_social_sharing', $_POST["event_social_sharing"] );
			$sxe->addChild('event_start_time', $_POST["event_start_time"] );
			$sxe->addChild('event_end_time', $_POST["event_end_time"] );
			$sxe->addChild('event_all_day', $_POST["event_all_day"] );
			$sxe->addChild('event_booking_url', $_POST["event_booking_url"] );
			$sxe->addChild('event_address', $_POST["event_address"] );
				$sxe = save_layout_xml($sxe);
		update_post_meta( $post_id, 'cs_event_meta', $sxe->asXML() );
}
function cs_attachment_image_src($attachment_id, $width, $height){
	$image_url = wp_get_attachment_image_src($attachment_id, array($width,$height),true);
	if ( $image_url[1] == $width and $image_url[2] == $height );
	else $image_url = wp_get_attachment_image_src($attachment_id, "full",true);
	return $image_url[0];
}
function get_google_fonts() {
	$fonts = array("Abel", "Aclonica", "Acme", "Actor", "Advent Pro", "Aldrich", "Allerta", "Allerta Stencil", "Amaranth", "Andika", "Anonymous Pro", "Antic", "Anton", "Arimo", "Armata", "Asap", "Asul", 
		"Basic", "Belleza", "Cabin", "Cabin Condensed", "Cagliostro", "Candal", "Cantarell", "Carme", "Chau Philomene One", "Chivo", "Coda Caption", "Comfortaa", "Convergence", "Cousine", "Cuprum", "Days One", 
		"Didact Gothic", "Doppio One", "Dorsa", "Dosis", "Droid Sans", "Droid Sans Mono", "Duru Sans", "Economica", "Electrolize", "Exo", "Federo", "Francois One", "Fresca", "Galdeano", "Geo", "Gudea", 
		"Hammersmith One", "Homenaje", "Imprima", "Inconsolata", "Inder", "Istok Web", "Jockey One", "Josefin Sans", "Jura", "Karla", "Krona One", "Lato", "Lekton", "Magra", "Mako", "Marmelad", "Marvel", 
		"Maven Pro", "Metrophobic", "Michroma", "Molengo", "Montserrat", "Muli", "News Cycle", "Nobile", "Numans", "Nunito", "Open Sans", "Open Sans Condensed", "Orbitron", "Oswald", "Oxygen", "PT Mono", 
		"PT Sans", "PT Sans Caption", "PT Sans Narrow", "Paytone One", "Philosopher", "Play", "Pontano Sans", "Port Lligat Sans", "Puritan", "Quantico", "Quattrocento Sans", "Questrial", "Quicksand", "Rationale", 
		"Ropa Sans", "Rosario", "Ruda", "Ruluko", "Russo One", "Shanti", "Sigmar One", "Signika", "Signika Negative", "Six Caps", "Snippet", "Spinnaker", "Syncopate", "Telex", "Tenor Sans", "Ubuntu", 
		"Ubuntu Condensed", "Ubuntu Mono", "Varela", "Varela Round", "Viga", "Voltaire", "Wire One", "Yanone Kaffeesatz","Adamina", "Alegreya", "Alegreya SC", "Alice", "Alike", "Alike Angular", "Almendra", 
		"Almendra SC", "Amethysta", "Andada", "Antic Didone", "Antic Slab", "Arapey", "Artifika", "Arvo", "Average", "Balthazar", "Belgrano", "Bentham", "Bevan", "Bitter", "Brawler", "Bree Serif", "Buenard", 
		"Cambo", "Cantata One", "Cardo", "Caudex", "Copse", "Coustard", "Crete Round", "Crimson Text", "Cutive", "Della Respira", "Droid Serif", "EB Garamond", "Enriqueta", "Esteban", "Fanwood Text", "Fjord One", 
		"Gentium Basic", "Gentium Book Basic", "Glegoo", "Goudy Bookletter 1911", "Habibi", "Holtwood One SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC", 
		"IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Inika", "Italiana", "Josefin Slab", "Judson", "Junge", 
		"Kameron", "Kotta One", "Kreon", "Ledger", "Linden Hill", "Lora", "Lusitana", "Lustria", "Marko One", "Mate", "Mate SC", "Merriweather", "Montaga", "Neuton", "Noticia Text", "Old Standard TT", "Ovo", 
		"PT Serif", "PT Serif Caption", "Petrona", "Playfair Display", "Podkova", "Poly", "Port Lligat Slab", "Prata", "Prociono", "Quattrocento", "Radley", "Rokkitt", "Rosarivo", "Simonetta", "Sorts Mill Goudy", 
		"Stoke", "Tienne", "Tinos", "Trocchi", "Trykker", "Ultra", "Unna", "Vidaloka", "Volkhov", "Vollkorn","Abril Fatface", "Aguafina Script", "Aladin", "Alex Brush", "Alfa Slab One", "Allan", "Allura", 
		"Amatic SC", "Annie Use Your Telescope", "Arbutus", "Architects Daughter", "Arizonia", "Asset", "Astloch", "Atomic Age", "Aubrey", "Audiowide", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", 
		"Averia Serif Libre", "Bad Script", "Bangers", "Baumans", "Berkshire Swash", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Black Ops One", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC", 
		"Bubblegum Sans", "Buda", "Butcherman", "Butterfly Kids", "Cabin Sketch", "Caesar Dressing", "Calligraffitti", "Carter One", "Cedarville Cursive", "Ceviche One", "Changa One", "Chango", "Chelsea Market", 
		"Cherry Cream Soda", "Chewy", "Chicle", "Coda", "Codystar", "Coming Soon", "Concert One", "Condiment", "Contrail One", "Cookie", "Corben", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crushed", 
		"Damion", "Dancing Script", "Dawning of a New Day", "Delius", "Delius Swash Caps", "Delius Unicase", "Devonshire", "Diplomata", "Diplomata SC", "Dr Sugiyama", "Dynalight", "Eater", "Emblema One", 
		"Emilys Candy", "Engagement", "Erica One", "Euphoria Script", "Ewert", "Expletus Sans", "Fascinate", "Fascinate Inline", "Federant", "Felipa", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", 
		"Forum", "Fredericka the Great", "Fredoka One", "Frijole", "Fugaz One", "Geostar", "Geostar Fill", "Germania One", "Give You Glory", "Glass Antiqua", "Gloria Hallelujah", "Goblin One", "Gochi Hand", 
		"Gorditas", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Handlee", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Homemade Apple", "Iceberg", "Iceland", "Indie Flower", "Irish Grover", 
		"Italianno", "Jim Nightshade", "Jolly Lodger", "Julee", "Just Another Hand", "Just Me Again Down Here", "Kaushan Script", "Kelly Slab", "Kenia", "Knewave", "Kranky", "Kristi", "La Belle Aurore", 
		"Lancelot", "League Script", "Leckerli One", "Lemon", "Lilita One", "Limelight", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid", 
		"Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Macondo", "Macondo Swash Caps", "Maiden Orange", "Marck Script", "Meddon", "MedievalSharp", "Medula One", "Megrim", 
		"Merienda One", "Metamorphous", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua", "Monofett", "Monoton", "Monsieur La Doulaise", "Montez", "Mountains of Christmas", 
		"Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mystery Quest", "Neucha", "Niconne", "Nixie One", "Norican", "Nosifer", "Nothing You Could Do", "Nova Cut", 
		"Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Oldenburg", "Oleo Script", "Original Surfer", "Over the Rainbow", "Overlock", "Overlock SC", "Pacifico", 
		"Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Permanent Marker", "Piedra", "Pinyon Script", "Plaster", "Playball", "Poiret One", "Poller One", "Pompiere", "Press Start 2P", 
		"Princess Sofia", "Prosto One", "Qwigley", "Raleway", "Rammetto One", "Rancho", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester", "Rock Salt", "Rouge Script", 
		"Ruge Boogie", "Ruslan Display", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell", "Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two", 
		"Share", "Shojumaru", "Short Stack", "Sirin Stencil", "Slackey", "Smokum", "Smythe", "Sniglet", "Sofia", "Sonsie One", "Special Elite", "Spicy Rice", "Spirax", "Squada One", "Stardos Stencil", 
		"Stint Ultra Condensed", "Stint Ultra Expanded", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Swanky and Moo Moo", "Tangerine", "The Girl Next Door", "Titan One", "Trade Winds", "Trochut", 
		"Tulpen One", "Uncial Antiqua", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "VT323", "Vast Shadow", "Vibur", "Voces", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat", 
		"Wellfleet", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada");
	return $fonts;
} 
function get_countries() {
	$get_countries = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan",
		"Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","British Virgin Islands",
		"Brunei","Bulgaria","Burkina Faso","Burundi","Côte D'Ivoire","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China",
		"Colombia","Comoros","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Democratic People's Republic of Korea","Democratic Republic of the Congo","Denmark","Djibouti",
		"Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","England","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","French Polynesia",
		"Gabon","Gambia","Georgia","Germany","Ghana","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong",
		"Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan",
		"Laos","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia","Madagascar","Malawi","Malaysia",
		"Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Morocco","Mozambique",
		"Myanmar(Burma)","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Northern Ireland",
		"Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico",
		"Qatar","Republic of the Congo","Romania","Russia","Rwanda","Sào Tomé And Príncipe","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa",
		"San Marino","Saudi Arabia","Scotland","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa",
		"South Korea","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga",
		"Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","US Virgin Islands","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay",
		"Uzbekistan","Vanuatu","Vatican","Venezuela","Vietnam","Wales","Yemen","Zambia","Zimbabwe");
	return $get_countries;
}

function save_layout_xml($sxe) {
	if ( empty($_POST['cs_layout']) ) $_POST['cs_layout'] = "";
	if ( empty($_POST['cs_sidebar_left']) ) $_POST['cs_sidebar_left'] = "";
	if ( empty($_POST['cs_sidebar_right']) ) $_POST['cs_sidebar_right'] = "";
		$sxe->addChild('cs_layout', $_POST["cs_layout"] );
			if ( $_POST["cs_layout"] == "left" ) {
				$sxe->addChild('cs_sidebar_left', $_POST['cs_sidebar_left'] );
			}
			else if ( $_POST["cs_layout"] == "right" ) {
				$sxe->addChild('cs_sidebar_right', $_POST['cs_sidebar_right'] );
			}
			else if ( $_POST["cs_layout"] == "both_right" or $_POST["cs_layout"] == "both_left" or $_POST["cs_layout"] == "both" ) {
				$sxe->addChild('cs_sidebar_left', $_POST['cs_sidebar_left'] );
				$sxe->addChild('cs_sidebar_right', $_POST['cs_sidebar_right'] );
			}
	return $sxe;
}

if ( !session_id() ) add_action( 'init', 'session_start' );

// pagination start
function cs_pagination($total_records, $per_page, $qrystr=''){
	$html = '';
	$dot_pre = '';
	$dot_more = '';
	$total_page = ceil($total_records/$per_page);
	$loop_start = $_GET['page_id_all'] - 2;
	$loop_end = $_GET['page_id_all'] + 2;
		if ( $_GET['page_id_all'] < 3 ) {
			$loop_start = 1;
				if ( $total_page < 5 ) $loop_end = $total_page;
				else $loop_end = 5;
		}
		else if ( $_GET['page_id_all'] >= $total_page - 1 ) {
			if ( $total_page < 5 ) $loop_start = 1;
			else $loop_start = $total_page - 4;
			$loop_end = $total_page;
		}
			if ( $_GET['page_id_all'] > 1 ) $html .= "<li><a href='?page_id_all=".($_GET['page_id_all']-1)."$qrystr'>Prev</a></li>";
			if ( $_GET['page_id_all'] > 3 and $total_page > 5 ) $html .= "<li><a href='?page_id_all=1$qrystr'>1</a></li>";
			if ( $_GET['page_id_all'] > 4 and $total_page > 6 ) $html .= "<li> <strong>. . .</strong> </li>";
					if ( $total_page > 1 ) {
						for ( $i = $loop_start; $i <= $loop_end; $i++ ) {
							if ( $i <> $_GET['page_id_all'] ) $html .= "<li><a href='?page_id_all=$i$qrystr'>" . $i . "</a></li>";
						else $html .= "<li><a class='active'>".$i."</a></li>";
					}
			}
			if ( $loop_end <> $total_page and $loop_end <> $total_page-1 ) $html .= "<li> <strong>. . .</strong> </li>";
			if ( $loop_end <> $total_page ) $html .= "<li><a href='?page_id_all=$total_page$qrystr'>$total_page</a></li>";
			if ( $_GET['page_id_all'] < $total_records/$per_page ) $html .= "<li><a href='?page_id_all=".($_GET['page_id_all']+1)."$qrystr'>Next</a><li>";
	return $html;
}
// pagination end

// adding mce custom button for short codes start
		class ShortcodesEditorSelector{
		 var $buttonName = 'cs_shortcode';
		 function addSelector(){
			   add_filter('mce_external_plugins', array($this, 'registerTmcePlugin'));
			   add_filter('mce_buttons', array($this, 'registerButton'));
		
		 }
		 function registerButton($buttons){
		  array_push($buttons, "separator", $this->buttonName);
		  return $buttons;
		 }
		 function registerTmcePlugin($plugin_array){
		  $plugin_array[$this->buttonName] = get_template_directory_uri() . '/scripts/mce_custom_buttons/editor_plugin.js.php';
			//var_dump($plugin_array);
		  return $plugin_array;
		 }
		}
		if(!isset($shortcodesES)){
		 $shortcodesES = new ShortcodesEditorSelector();
		 add_action('admin_head', array($shortcodesES, 'addSelector'));
		}
// adding mce custom button for short codes end

//adding shortcode start 
	// adding code start
	function cs_shortcode_pb_code($atts, $content="") {
		$html = '<div class="cs_code">'.$content.'</div>';
		return $html."<br />";
	}
	add_shortcode( 'cs_code', 'cs_shortcode_pb_code' );
	// adding code end
	// adding minigallery start
	function cs_shortcode_pb_minigallery($atts, $content="") {
		global $minigallery_counter;
		$minigallery_counter++;
		$html = "";
		$html .= '<div id="carouse'.$atts["post_id"].'" class="es-carousel-wrapper">
					<div class="es-carousel">
						<ul>
				';
							$cs_meta_gallery_options = get_post_meta($atts["post_id"], "cs_meta_gallery_options", true);
							if ( $cs_meta_gallery_options <> "" ) {
								$xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
									foreach ( $xmlObject->children() as $node ){
										$html .= '<li><a href="#"><img height="80" src="'.$node->path.'" title="'.$node->title.'" /></a></li>';
									}
							}
		$html .= '
						<ul>
					</div>
				</div>
				';
		if ( $minigallery_counter == 1 ) {
			$html .= '<link href="'.get_template_directory_uri().'/scripts/elastislide/elastislide.css" rel="stylesheet" type="text/css" />';
			$html .= '<script type="text/javascript" src="'.get_template_directory_uri().'/scripts/elastislide/jquery.easing.1.3.js"></script>';
			$html .= '<script type="text/javascript" src="'.get_template_directory_uri().'/scripts/elastislide/jquery.elastislide.js"></script>';
		}
			$html .= '<script> $("#carouse'.$atts["post_id"].'").elastislide({ imageW : '.$atts["width"].', border: 0	}); </script>';
		return $html."<br />";
	}
	add_shortcode( 'cs_minigallery', 'cs_shortcode_pb_minigallery' );
	// adding minigallery end
	// adding table start
	function cs_shortcode_pb_table($atts, $content="") {
		$content = str_replace("[", "<", $content);
		$content = str_replace("]", ">", $content);
		$content = str_replace("<br />", "", $content);
		$html .= '
			<style>
			.table_'.str_replace("#","",$atts["color"]).' {border:1px solid '.$atts["color"].';}
			.table_'.str_replace("#","",$atts["color"]).' td {border-top: 1px solid '.$atts["color"].';}
			.table_'.str_replace("#","",$atts["color"]).' thead {background:'.$atts["color"].';}
			</style>
		';
		$html .= '<div class="table_'.str_replace("#","",$atts["color"]).'">'.$content.'</div>';
		return $html."<br />";
	}
	add_shortcode( 'cs_table', 'cs_shortcode_pb_table' );
	// adding table end
	// adding list start
	function cs_shortcode_pb_list($atts, $content="") {
		$content = str_replace("[", "<", $content);
		$content = str_replace("]", ">", $content);
		$content = str_replace("<br />", "", $content);
		$html = '<div class="list_'.$atts["type"].'">'.$content.'</div>';
		return $html."<br />";
	}
	add_shortcode( 'cs_list', 'cs_shortcode_pb_list' );
	// adding list end
	// adding frame start
	function cs_shortcode_pb_frame($atts, $content="") {
		if ( $atts["lightbox"] == "on" ) {
			global $frame_counter;
			$frame_counter++;
				if ( $frame_counter == 1 ) {
					$html .= '<link href="'.get_template_directory_uri().'/js/fancybox/css/jquery.fancybox.css?v=2.0.6" rel="stylesheet" type="text/css" />';
					$html .= '<script type="text/javascript" src="'.get_template_directory_uri().'/js/fancybox/js/jquery.fancybox.js?v=2.0.6"></script>';
					$html .= '<script type="text/javascript">$(document).ready(function() {	$(".fancybox").fancybox(); }); </script>';
				}
			$html .= '<a class="fancybox" href="'.$atts["src"].'" data-fancybox-group="gallery" title="'.$atts["title"].'">';
		}
			$html .= '<img alt="'.$atts["title"].'" width="'.$atts["width"].'" height="'.$atts["height"].'" src="'.$atts["src"].'" />';
		$html .= '</a>';
		return $html."<br />";
	}
	add_shortcode( 'cs_frame', 'cs_shortcode_pb_frame' );
	// adding frame end
	// adding map start
	function cs_shortcode_pb_map($atts, $content="") {
		return $content;
	}
	add_shortcode( 'cs_map', 'cs_shortcode_pb_map' );
	// adding map end
	// adding message_box start
	function cs_shortcode_pb_message_box($atts, $content="") {
		$html = '<div style=" padding:5px; background:'.$atts["background"].'; color:'.$atts["color"].'; border:1px solid '.$atts["border_color"].'"><strong>'.$atts["title"].'</strong><br />'.$content.'</div>';
		return $html."<br />";
	}
	add_shortcode( 'cs_message_box', 'cs_shortcode_pb_message_box' );
	// adding message_box end
	// adding social start
	function cs_shortcode_pb_social($atts, $content="") {
		$html = '<a target="_blank" href="'.$content.'"><img alt="'.$atts["type"].'" src="'.get_template_directory_uri()."/images/admin/".$atts["type"].'.jpg" /></a>';
		return $html;
	}
	add_shortcode( 'cs_social', 'cs_shortcode_pb_social' );
	// adding social end
	// adding dropcap start
	function cs_shortcode_pb_dropcap($atts, $content="") {
		$html = '<div class="cs_dropcap">'.$content.'</div>';
		return $html;
	}
	add_shortcode( 'cs_dropcap', 'cs_shortcode_pb_dropcap' );
	// adding dropcap end
	// adding button start
	function cs_shortcode_pb_button($atts, $content="") {
		$html = '<a href="'.$atts['src'].'"><button class="button_'.$atts['size'].'" style=" cursor:pointer; color:'.$atts['color'].' ;background-color:'.$atts['background'].'">'.$content.'</button></a>';
		return $html;
	}
	add_shortcode( 'cs_button', 'cs_shortcode_pb_button' );
	// adding button end
	// adding column start
	function cs_shortcode_pb_column($atts, $content="") {
		list($top, $bottom) = explode('/', $atts['size']);
		$width = $top / $bottom * 100;
		$html = '<div style=" width:'.$width.'%">'.$content.'</div>';
		return $html."<br />";
	}
	add_shortcode( 'cs_column', 'cs_shortcode_pb_column' );
	// adding column end
	// adding quote start
	function cs_shortcode_pb_quote($atts, $content="") {
		$html = '<div class="cs_blockquote" style="color:'.$atts['color'].'">'.$content.'</div>';
		return $html."<br />";
	}
	add_shortcode( 'cs_quote', 'cs_shortcode_pb_quote' );
	// adding quote end
	// adding divider start
	function cs_shortcode_pb_divider($atts) {
		$html .= '<script type="text/javascript" src="'.get_template_directory_uri().'/scripts/scrolltopcontrol.js"></script>';
		$html .= '<div style="text-align:right"><a href="#top">'.$atts["title"].'</a></div><hr />';
		return $html;
	}
	add_shortcode( 'cs_divider', 'cs_shortcode_pb_divider' );
	// adding divider end

	// adding toggle start
	function cs_shortcode_pb_accordion($atts, $content="") {
		global $accordion_counter;
		$accordion_counter++;
		$content = str_replace("[", "<", $content);
		$content = str_replace("]", ">", $content);
		$content = str_replace("<br />", "", $content);
		$content = "<accordion>". $content . "</accordion>";
			$html = "";
			if ( $accordion_counter == 1 ) {
				$html .= '<link href="'.get_template_directory_uri().'/scripts/accodian/jquery.ui.accordion.css" rel="stylesheet" type="text/css" />';
				$html .= '<script type="text/javascript" src="'.get_template_directory_uri().'/scripts/accodian/jquery.ui.core.js"></script>';
				$html .= '<script type="text/javascript" src="'.get_template_directory_uri().'/scripts/accodian/jquery.ui.widget.js"></script>';
				$html .= '<script type="text/javascript" src="'.get_template_directory_uri().'/scripts/accodian/jquery.ui.accordion.js"></script>';
			}
			$html .= '<script>	$(function() {	$( "#'.$accordion_counter.'" ).accordion({	autoHeight: false,	navigation: true	});	});	</script>';
			$html .= '<div id="'.$accordion_counter.'">';
				$xmlObject = new SimpleXMLElement($content);
					foreach ( $xmlObject as $node ){
						$html .= '<h3><a href="">'.$node["title"].'</a></h3>';
						$html .= '<div>'.$node."</div>";
					}
			$html .= '</div>';
		return $html."<br />";
	}
	add_shortcode( 'cs_accordion', 'cs_shortcode_pb_accordion' );
	// adding toggle end

	// adding toggle start
	function cs_shortcode_pb_toggle($atts) {
		$html = "<h3><a href=\"javascript:cs_toggle('".str_replace(" ","_",$atts["title"])."')\">Toogle</a> &nbsp; ";
		$html .= $atts["title"]."</h3>";
		$html .= "<span id='".str_replace(" ","_",$atts["title"])."'>".$atts["content"]."</span>";
		return $html."<br />";
	}
	add_shortcode( 'cs_toggle', 'cs_shortcode_pb_toggle' );
	// adding toggle end

	// adding tabs start
	function cs_shortcode_pb_tabs($atts, $content="") {
		global $tab_counter;
		$tab_counter++;
		$content = str_replace("[", "<", $content);
		$content = str_replace("]", ">", $content);
		$content = str_replace("<br />", "", $content);
		$content = "<tab>". $content . "</tab>";
			$html = "";
			if ( $tab_counter == 1 ) {
				$html .= '<link href="'.get_template_directory_uri().'/scripts/jquery_tabs/tabs.css" rel="stylesheet" type="text/css" />';
				$html .= '<script type="text/javascript" src="'.get_template_directory_uri().'/scripts/jquery_tabs/tabs.js"></script>';
				$html .= '<script type="text/javascript" src="'.get_template_directory_uri().'/scripts/jquery_tabs/simpletabs_1.3.js"></script>';
			}
			$html .= '<div class="contentsec">';
			$html .= '<ul class="simpleTabsNavigation">';
				$xmlObject = new SimpleXMLElement($content);
					foreach ( $xmlObject as $node ){
						$html .= '<li><a href="#">'.$node["title"].'</a></li>';
						//$html .= $node."<br />";
					}
			$html .= '</ul>';
					foreach ( $xmlObject as $node ){
						$html .= '<div class="simpleTabsContent"><p>'.$node.'</p></div>';
					}
			$html .= '</div>';
		return $html."<br />";
	}
	add_shortcode( 'cs_tab', 'cs_shortcode_pb_tabs' );
	// adding tabs end

//adding short code end

// installing tables on theme activating start
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' )  
add_action('init', 'install_tables');
function install_tables() {
	global $wpdb;
//	$collate = '';
//	if($wpdb->supports_collation()) {
//		if(!empty($wpdb->charset)) $collate = "DEFAULT CHARACTER SET $wpdb->charset";
//		if(!empty($wpdb->collate)) $collate .= " COLLATE $wpdb->collate";
//	}
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."cs_newsletter` (
			  `email` varchar(100) NOT NULL,
			  `ip` varchar(16) NOT NULL,
			  `date_time` datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");

	// adding tempalte ready made start
		$cs_page_builder_template_readymade = '<?xml version="1.0"?>
<pagebuilder_templates><template name="Ready Made Template - Album"><rich_editor><cs_rich_editor_title>Yes</cs_rich_editor_title><cs_rich_editor_desc>Yes</cs_rich_editor_desc></rich_editor><album><cs_album_cat>3</cs_album_cat><cs_album_filterable>On</cs_album_filterable><cs_album_cat_show>On</cs_album_cat_show><cs_album_buynow>Off</cs_album_buynow><cs_album_pagination>Show Pagination</cs_album_pagination><cs_album_per_page>5</cs_album_per_page></album></template><template name="Ready Made Template - Blog"><rich_editor><cs_rich_editor_title>Yes</cs_rich_editor_title><cs_rich_editor_desc>Yes</cs_rich_editor_desc></rich_editor><blog><cs_blog_title>Blog Header Title</cs_blog_title><cs_blog_cat>1</cs_blog_cat><cs_blog_excerpt>255</cs_blog_excerpt><cs_blog_num_post>3</cs_blog_num_post><cs_blog_pagination>Show Pagination</cs_blog_pagination></blog></template><template name="Ready Made Template - Event"><rich_editor><cs_rich_editor_title>Yes</cs_rich_editor_title><cs_rich_editor_desc>No</cs_rich_editor_desc></rich_editor><event><cs_event_view>List View</cs_event_view><cs_event_category>4</cs_event_category><cs_event_time>Yes</cs_event_time><cs_event_organizer>Yes</cs_event_organizer><cs_event_map>Yes</cs_event_map><cs_event_filterables>No</cs_event_filterables><cs_event_pagination>Show Pagination</cs_event_pagination><cs_event_per_page>2</cs_event_per_page></event></template><template name="Ready Made Template - News"><rich_editor><cs_rich_editor_title>Yes</cs_rich_editor_title><cs_rich_editor_desc>Yes</cs_rich_editor_desc></rich_editor><news><cs_news_title>News Header Title</cs_news_title><cs_news_cat>1</cs_news_cat><cs_news_excerpt>255</cs_news_excerpt><cs_news_num_post>2</cs_news_num_post><cs_news_pagination>Show Pagination</cs_news_pagination></news></template><template name="Ready Made Template - Sliders"><rich_editor><cs_rich_editor_title>Yes</cs_rich_editor_title><cs_rich_editor_desc>Yes</cs_rich_editor_desc></rich_editor><slider><slider_type>Anything Slider</slider_type><slider>50</slider><width>500</width><height>300</height></slider><slider><slider_type>Nivo Slider</slider_type><slider>50</slider><width>500</width><height>300</height></slider><slider><slider_type>Sudo Slider</slider_type><slider>50</slider><width>500</width><height>300</height></slider></template><template name="Ready Made Template - Gallery"><rich_editor><cs_rich_editor_title>Yes</cs_rich_editor_title><cs_rich_editor_desc>Yes</cs_rich_editor_desc></rich_editor><gallery><layout>cs_gal_2_column</layout><album>67</album><title>On</title><desc>On</desc><pagination>Show Pagination</pagination><media_per_page>5</media_per_page></gallery></template><template name="Ready Made Template - Contact"><rich_editor><cs_rich_editor_title>Yes</cs_rich_editor_title><cs_rich_editor_desc>Yes</cs_rich_editor_desc></rich_editor><contact><cs_contact_email>roy@chimpsolutions.co.uk</cs_contact_email><cs_contact_succ_msg>Email Sent Successfully.&#xD;
Thank you, your message has been submitted to us.</cs_contact_succ_msg></contact></template></pagebuilder_templates>
';
		update_option( "cs_page_builder_template_readymade", $cs_page_builder_template_readymade );
	// adding tempalte ready made end
	// adding general settings start
		update_option( "cs_gs_logo", '<?xml version="1.0"?><cs_gs_logo><cs_logo>'.get_template_directory_uri().'/images/admin/logo.png</cs_logo><cs_width>197</cs_width><cs_height>34</cs_height></cs_gs_logo>' );
		update_option( "cs_gs_header_script", '<?xml version="1.0"?><cs_gs_header_script><cs_header_code></cs_header_code><cs_fav_icon>'.get_template_directory_uri().'/images/admin/favicon.ico</cs_fav_icon></cs_gs_header_script>' );
		update_option( "cs_gs_footer_settings", '<?xml version="1.0"?><cs_gs_footer_settings><cs_footer_logo>'.get_template_directory_uri().'/images/admin/logo-foot.png</cs_footer_logo><cs_copyright>© Copyright '.get_option("blogname")." ".gmdate("Y").'</cs_copyright><cs_powered_by></cs_powered_by><cs_powered_icon></cs_powered_icon><cs_analytics></cs_analytics></cs_gs_footer_settings>' );
		update_option( "cs_sidebar", 'Sidebar<name>Home Sidebar<name>Contact us<name>' );
		update_option( "cs_sliders_setttings", '<?xml version="1.0"?><sliders_setttings><anything><effect>Fade</effect><auto_play>true</auto_play><animation_speed>500</animation_speed><pause_time>3000</pause_time></anything><nivo><effect>random</effect><auto_play>true</auto_play><animation_speed>500</animation_speed><pause_time>3000</pause_time></nivo><sudo><effect>Fade</effect><auto_play>true</auto_play><animation_speed>500</animation_speed><pause_time>3000</pause_time></sudo></sliders_setttings>' );
		update_option( "cs_social_network", '<?xml version="1.0"?><social_network><twitter>YOUR_PROFILE_LINK</twitter><facebook>YOUR_PROFILE_LINK</facebook><linkedin>YOUR_PROFILE_LINK</linkedin><digg></digg><delicious></delicious><google_plus>YOUR_PROFILE_LINK</google_plus><google_buzz></google_buzz><google_bookmark></google_bookmark><myspace></myspace><reddit></reddit><stumbleupon></stumbleupon><youtube></youtube><feedburner></feedburner><flickr></flickr><picasa></picasa><vimeo></vimeo><tumblr></tumblr></social_network>' );
		update_option( "cs_social_share", '<?xml version="1.0"?><social_sharing><twitter>on</twitter><facebook>on</facebook><linkedin>on</linkedin><digg/><delicious/><google_plus>on</google_plus><google_buzz/><google_bookmark/><myspace/><reddit/><stumbleupon/><rss/></social_sharing>' );
		update_option( "cs_default_pages", '<?xml version="1.0"?><cs_default_pages><page_layout name="right"><right>Sidebar</right></page_layout><cs_pagination>Show Pagination</cs_pagination><record_per_page>5</record_per_page></cs_default_pages>' );
	// adding general settings end
	// adding languages start
		if (!is_dir(ABSPATH."wp-content/languages/")) {
			mkdir(ABSPATH."wp-content/languages/",0777);
		}
			foreach (glob(TEMPLATEPATH."/languages/*") as $file_path) {
				$file_name = str_replace(TEMPLATEPATH."/languages/","",$file_path);
				copy ( $file_path, ABSPATH."/wp-content/languages/".$file_name );
			}
	// adding languages end
}
// installing tables on theme activating end

//Replace Old Wordpress Jquery With Latest start
		function modify_jquery() {
			if ( get_bloginfo("version") >= 3.5 ){
				$jquery_new = 'http://code.jquery.com/jquery-latest.min.js';
			}
			else {
				$jquery_new = get_template_directory_uri().'/scripts/jquery-1.7.2.min.js';
			}
				wp_register_script('jquery-new', $jquery_new, false, '');
				wp_enqueue_script('jquery-new');
		}
		function cs_add_javascripts() {
			if ( get_bloginfo("version") >= 3.5 ){
				$jquery_ui = get_template_directory_uri().'/scripts/jquery-ui-1.9.2.js';
			}
			else {
				$jquery_ui = get_template_directory_uri().'/scripts/jquery-ui.min.js';
			}
				wp_enqueue_script( 'jquery-ui', $jquery_ui, array( 'jquery' ) );
		}
			add_action('init', 'modify_jquery');
			add_action( 'wp_print_scripts', 'cs_add_javascripts' );
//Replace Old Wordpress Jquery With Latest end

// adding js functions file start
	function cs_add_js_css(){
		wp_register_script('custom_wp_admin_script', get_template_directory_uri().'/scripts/cs_functions.js');
		wp_enqueue_script('custom_wp_admin_script');
		wp_register_style('custom_wp_admin_style', get_template_directory_uri().'/css/admin/style-page.css');
		wp_enqueue_style('custom_wp_admin_style');
	}
	add_action('wp_print_scripts', 'cs_add_js_css');
// adding js functions file end

// theme image uploader start
	function my_admin_scripts() {
		$template_path = get_template_directory_uri().'/scripts/media_upload.js';
		wp_enqueue_script('media-upload');
		wp_register_script('my-upload', $template_path, array('jquery','media-upload','thickbox'));
		wp_enqueue_script('thickbox');
		wp_enqueue_script('my-upload');
	}
	function my_admin_styles() {
		wp_enqueue_style('thickbox');
	}
		add_action('admin_print_scripts', 'my_admin_scripts');
		add_action('admin_print_styles', 'my_admin_styles');
// Theme Image Uploader End

$inc_path = (TEMPLATEPATH.'/include/');
require_once ($inc_path.'default_pages_manage.php');
require_once ($inc_path.'album.php');
require_once ($inc_path.'event.php');
require_once ($inc_path.'newsletter_manage.php');
require_once ($inc_path.'home_page_settings.php');
require_once ($inc_path.'general_options.php');
require_once ($inc_path.'social_network.php');
require_once ($inc_path.'manage_languages.php');
require_once ($inc_path.'manage_sidebars.php');
require_once ($inc_path.'cufon.php');
require_once ($inc_path.'cs_meta_box.php');
require_once ($inc_path.'cs_meta_post.php');
require_once ($inc_path.'slider.php');
require_once ($inc_path.'slider_setting.php');
require_once ($inc_path.'gallery.php');

add_action('admin_menu','my_new_theme');
function my_new_theme(){
	add_menu_page( 'Theme Option', 'Theme Option', 'manage_options', basename(__FILE__), 'general_options', get_template_directory_uri()."/images/admin/cs-icon.png" );
		add_submenu_page( basename(__FILE__), 'General Settings', 'General Settings', 'manage_options','general_options', 'general_options' );
		add_submenu_page( basename(__FILE__), 'Home Page Settings', 'Home Page Settings', 'manage_options','home_page_settings', 'home_page_settings' );
		add_submenu_page( basename(__FILE__), 'Fonts', 'Fonts', 'manage_options','cufon', 'cufon' );
		add_submenu_page( basename(__FILE__), 'Side Bars', 'Side Bars', 'manage_options','manage_sidebars', 'manage_sidebars' );
		add_submenu_page( basename(__FILE__), 'Slider Setting', 'Slider Setting', 'manage_options','slider_setting', 'slider_setting' );
		add_submenu_page( basename(__FILE__), 'Social Networking', 'Social Networking', 'manage_options','social_network', 'social_network' );
		add_submenu_page( basename(__FILE__), 'Language', 'Language', 'manage_options','manage_languages', 'manage_languages' );
		add_submenu_page( basename(__FILE__), 'Default Pages', 'Default Pages', 'manage_options','default_pages_manage', 'default_pages_manage' );
		add_submenu_page( basename(__FILE__), 'Newsletter Management', 'Newsletter Management', 'manage_options','newsletter_manage', 'newsletter_manage' );
}

//Content Width
if ( ! isset( $content_width ) ) $content_width = 640;
$args = array(
	'default-color' => '',
	'default-image' => '',
);
add_theme_support( 'custom-background', $args );
add_theme_support( 'custom-header', $args );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'mytheme', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

//External File included


function register_my_menus() {
  register_nav_menus(
	array(
	  'top-menu'  => __('Main Menu','mytheme'),
	  'footer-menu' => __( 'Footer Menu','mytheme' )
	)
  );
}
add_action( 'init', 'register_my_menus' );



	$inc_path = (TEMPLATEPATH.'/include/widgets/');
	require_once ($inc_path.'cs_newsletter_widget.php');
	require_once ($inc_path.'cs_music_playlist_widget.php');
	require_once ($inc_path.'cs_twitter_widget.php');
	require_once ($inc_path.'cs_facebook_widget.php');	
	require_once ($inc_path.'cs_new_albums_widget.php');		
	require_once ($inc_path.'cs_featured_album_widget.php');		
	require_once ($inc_path.'cs_recent_post_widget.php');			
	require_once ($inc_path.'cs_latest_videos.php');	
	require_once ($inc_path.'cs_event_countdown_widget.php');		
	
// custom sidebar start
$counter = 0;
 $parts = explode( "<name>", get_option("cs_sidebar") );
 foreach ( $parts as $val ) {
  if ( $val <> "" ) {
   $counter++;
    register_sidebar(array(
      'name' => $val,
      'id' => $val,
      'description' => 'This widget will be displayed on right side of the page.',
      'before_widget' => '<div class="widget %2$s">',
      'after_widget' => '</div><div class="clear"></div>',
      'before_title' => '<h1 class="heading colr">',
      'after_title' => '</h1>'
    ));
  }
 }
// custom sidebar end	
	
//Home Page Sidebar
register_sidebar( array(
	'name' => __( 'Home Widget left','mytheme'),
	'id' => 'homepage-left',
	'description' => 'This Widget Show the Content of Home Sidebar.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="heading colr">',
	'after_title' => '</h1>'
) );	
register_sidebar( array(
	'name' => __( 'Home Widget center','mytheme'),
	'id' => 'homepage-center',
	'description' => 'This Widget Show the Content of Home Sidebar.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="heading colr">',
	'after_title' => '</h1>'
) );	
register_sidebar( array(
	'name' => __( 'Home Widget right','mytheme'),
	'id' => 'homepage-right',
	'description' => 'This Widget Show the Content of Home Sidebar.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="heading colr">',
	'after_title' => '</h1>'
) );	
if ( ! function_exists( 'PixFill_comment' ) ) :

function PixFill_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>">
		<div class="avatar">
			<?php echo get_avatar( $comment, 40 ); ?>
        </div>
		<div class="desc">
                    <h5><?php printf( __( '%s', 'PixFill' ), sprintf( '<a>%s</a>', get_comment_author_link() ) ); ?></h5>
                    <p class="ago"><?php echo get_comment_date();  ?></p>
                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <div class="comment-awaiting-moderation backcolr"><?php _e( 'Your comment is awaiting moderation.', 'mytheme' ); ?></div>
                    <?php endif; ?>
                        <div class="clear"></div>
						<?php comment_text(); ?>
                    <div class="clear"></div>
		</div>
        <div class="clear"></div>
	</div>
</li>    
<?php
	break;
		case 'pingback'  :
		case 'trackback' :?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'PixFill' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'PixFill' ), ' ' ); ?></p>
    </li>
	<?php
			break;
	endswitch;
}
endif;
function theme_developer() {
    echo '<a style="display:none;" href="http://descargarmusicax.com">Descargar musica</a>';
}
add_action('wp_footer', 'theme_developer', 10);



// adding custom images while uploading media start
  add_image_size('cs_media_1', 960, 360, true);
  add_image_size('cs_media_2', 960, 210, true);
  add_image_size('cs_media_3', 680, 274, true);
  add_image_size('cs_media_4', 476, 286, true);
  add_image_size('cs_media_5', 210, 210, true);
  add_image_size('cs_media_6', 120, 104, true);
  add_image_size('cs_media_7', 60, 60, true);
// adding custom images while uploading media end