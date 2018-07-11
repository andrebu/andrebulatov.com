<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Mobile Specific Metas
================================================== -->

<title>
<?php
	global $page, $paged;
	wp_title( '|', true, 'right' );

	bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'rockit' ), max( $paged, $page ) );

?>
    </title>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/base.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/layout.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/player.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/fancybox.css" />
<?php if ( get_option( "cs_gs_responsive" ) == "on" ) { ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/skeleton.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php }?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/color.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/prettyPhoto.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/fullcalendar.css" />
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--// Javascript //-->

<?php 
if ( is_singular() && get_option( 'thread_comments' ) ) 	wp_enqueue_script( 'comment-reply' );
wp_head();
// genereal setting start
$cs_style_sheet = '';
	$cs_gs_color_style = get_option( "cs_gs_color_style" );
		if ( $cs_gs_color_style <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_color_style);
				$cs_color_scheme = $sxe->cs_color_scheme;
				$cs_style_sheet = $sxe->cs_style_sheet;
		}
	$cs_gs_logo = get_option( "cs_gs_logo" );
		if ( $cs_gs_logo <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_logo);
				$cs_logo = $sxe->cs_logo;
				$cs_width = $sxe->cs_width;
				$cs_height = $sxe->cs_height;
		}
	$cs_gs_header_script = get_option( "cs_gs_header_script" );
		if ( $cs_gs_header_script <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_header_script);
				echo $sxe->cs_header_code;
				$cs_fav_icon = $sxe->cs_fav_icon;
		}
// genereal setting end

?>
    <!-- RTL style sheet start -->
    <?php
    if ( get_option("lang_style") == "rtl" ){
    ?>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/rtl.css" />
    <?php
    }
    ?>
    <!-- RTL style sheet end -->

<!--// Favicons //-->
<link rel="shortcut icon" href="<?php echo $cs_fav_icon?>" />

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/lightbox.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.countdown.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/scrolltopcontrol.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.mCustomScrollbar.js"></script>


<?php if ( $cs_style_sheet <> "custom" ) { ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custom_styles/<?php echo $cs_style_sheet?>.css" />
<?php
	} 
	else if ( $cs_style_sheet == "custom" ) { 
	?>
	<style>
		@charset "utf-8";
/* Text color */
#reply-title,.colr, 
.txthover:hover,
.widget_rss h1 a,
.ft-left ul.links li a:hover,
.post:hover .desc .date h1,
.post .desc .desc-sec h3 a:hover,
.post .desc .desc-sec .post-opts p a:hover,
.post-detail .desc h3 a:hover,
.post-detail .desc .post-opts p a:hover,
.comments ul li:hover .desc h5 a,
.tracklist li.title p a:hover,
.gig-post .desc .txt-sec h3 a:hover,
.gig-post:hover .date h1,
.gallery-head nav a:hover, 
.gallery-head nav a.active,
.post .desc .desc-sec h3 a,
#gallery #images .slide .caption h3 a										{color:<?php echo $cs_color_scheme?> !important;}



.bordercolr,
.bordercolrover:hover														{border-color:<?php echo $cs_color_scheme?> !important;}


#login-box 																	{border-top:<?php echo $cs_color_scheme?> 2px solid !important;}
.cs_gal_2_column li:hover													{border:<?php echo $cs_color_scheme?> solid 2px !important;}


.backcolr,
.backcolrhover:hover,
.navigation > div > ul > li:hover,
.nivo-prevNav:hover,
.nivo-nextNav:hover,
#wp-calendar thead,
#mcs5_container .dragger,
li.jp-playlist-current														{background-color:<?php echo $cs_color_scheme?> !important;}


.jp-title li:hover,
.jp-playlist li:hover,
a.ticket:hover,														
a.buttonone:hover,
a.buttonsmaller:hover,
.other-albums .desc a.buynow:hover,
.comments ul li .desc a.comment-reply-link:hover,
a.bigbutton:hover,
.tracklist li a.lyrics:hover,
.widget input[type="submit"],
.widget_tag_cloud a:hover,
.tracklist li a.download:hover												{background:<?php echo $cs_color_scheme?> !important;}



		
	</style>
<?php } ?>
<script type="text/javascript">
function cs_amimate(id){
	$("#"+id).animate({
		height: 'toggle'
		}, 200, function() {
		// Animation complete.
	});
}
</script>
</head>
<body <?php body_class( ); ?>>
<!-- Outer Wrapper Start -->
<div id="outer-wrapper">
	<div id="header">
    	<div class="inner">
        	<!-- Container Start -->
            <div class="container">
                <!-- Logo Start -->
                <div class="five columns left">
                    <a href="<?php echo home_url() ; ?>" class="logo">
                        <img src="<?php echo $cs_logo?>" alt="<?php echo bloginfo( 'name' )?>" width="<?php echo $cs_width?>px" height="<?php echo $cs_height?>px"/>
                    </a>
                </div>
                <!-- Logo End -->
                <div class="eleven columns right">
                    <!-- Top Links Start -->
                    <ul class="top-links">
                        <li>
                            <h4 class="colr">Search Music</h4>
                            <div id="search-box">
                                <form method="get" action="" id="searchform">
                                    <input name="s" id="s" value="Enter any keyword"
                                    onfocus="if(this.value=='Enter any keyword') {this.value='';}"
                                    onblur="if(this.value=='') {this.value='Enter any keyword';}" type="text" class="bar" />
                                    <button id="searchsubmit" name="" class="backcolr">Search</button>
                                </form>
                            </div>
                        </li>
                        <li>
                        	<?php  if ( is_user_logged_in() ) { ?>
                                <a href="<?php echo wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>">logout</a>
                                <a href="<?php echo home_url() ; ?>/wp-admin/">
									<?php 
                                    	global $current_user;
                                        echo $current_user->display_name;
                                    ?>
                                </a>
                            	<?php } else { ?>
                                <script>
                                    $(document).ready(function() {
                                        $('form[id=login_frm]').submit(function(){
                                            if ( $("#log").val() == "" || $("#pwd").val() == "" ) {
                                                $("#login_msg").html("Empty User name or pwd");
                                                return false;
                                            }
                                            else return true;
                                        });
                                    });
                                </script>
                            <a href="javascript:cs_amimate('login-box')" class="colr">LOG IN</a>
                            <div id="login-box">
                                <h4 class="white backcolr">User Login <a href="javascript:cs_amimate('login-box')" class="closeit">&nbsp;</a></h4>
                                <form action="<?php echo home_url(); ?>/wp-login.php" method="post">
                                <ul>
                                    <li>
                                        <input name="log" value="yourname@email.com" 
                                        onfocus="if(this.value=='yourname@email.com') {this.value='';}"
                                        onblur="if(this.value=='') {this.value='yourname@email.com';}" id="user_login" type="text" class="bar" />
                                    </li>
                                    <li>
                                        <input name="pwd" value="password"
                                        onfocus="if(this.value=='password') {this.value='';}"
                                        onblur="if(this.value=='') {this.value='password';}" type="password" class="bar" />
                                    </li>
                                    <li>
                                        <input type="hidden" name="redirect_to" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />                                        
                                        <input name="rememberme" value="forever" id="rememberme" type="checkbox" class="left" />
                                        <p>Remember me</p>
                                        <a href="<?php echo home_url() ; ?>/wp-login.php?action=lostpassword" class="right">Forget Password?</a>
                                    </li>
                                    <li>
                                        <button name="submit" class="backcolr">Login</button>
                                    </li>
                                </ul>
                                </form>
                                <div class="clear"></div>
                            </div>
                            <?php }?>
                            <?php
								if ( get_option("users_can_register") == 1 and !is_user_logged_in() ) {
							?>
								<a href="<?php echo home_url() ; ?>/wp-login.php?action=register">Signup</a>
							<?php }?>
                        </li>
                    </ul>
                    <!-- Top Links End -->
                </div>
                <!-- Navigation Start -->
                <div class="navigation">
                	<script>
						jQuery(document).ready(function($){	
							/* prepend menu icon */
							$('#smoothmenu1').prepend('<div id="menu-icon"><div>Menu<span>&nbsp;</span></div></div>');
							
							/* toggle nav */
							$("#menu-icon").on("click", function(){
								$(".main-navi").toggle();
								//$(this).toggleClass("active");
							});
						});
					</script>                                 
						<?php 
                            // Menu parameters		
                            $defaults = array(
                              'theme_location'  => 'top-menu',
                              'menu'            => '', 
                              'container'       => '', 
                              'container_class' => 'menu-{menu slug}-container', 
                              'container_id'    => '',
                              'menu_class'      => 'main-navi', 
                              'menu_id'         => '',
                              'echo'            => true,
                              'fallback_cb'     => '',
                              'before'          => '',
                              'after'           => '',
                              'link_before'     => '',
                              'link_after'      => '',
                              'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                              'depth'           => 0,
                              'walker'          => '',);				
							if(has_nav_menu('top-menu')){?>
                                <div id="smoothmenu1" class="ddsmoothmenu">
                                    <?php wp_nav_menu( $defaults); ?>
                                    <div class="clear"></div>
                                </div>
							<?php }else{
								$args = array(
                                    'sort_column' => 'menu_order, post_title',
                                    'menu_class'  => 'menu',
                                    'include'     => '',
                                    'exclude'     => '',
                                    'echo'        => true,
                                    'show_home'   => false,
                                    'link_before' => '',
                                    'link_after'  => '' );
									wp_page_menu( $args ); ?>                                 
							<?php }?>

                </div>
                <!-- Navigation End -->
                <div class="clear"></div>
            </div>
            <!-- Container End -->
        </div>
    </div>
    <!-- Header End -->
    <div class="clear"></div>
    <?php 
if(is_front_page() or is_home()){
	$show_slider = "";
	$cs_home_page_slider = get_option("cs_home_page_slider");
	if ( $cs_home_page_slider <> "" ) {
		$xmlObject = new SimpleXMLElement($cs_home_page_slider);
			$show_slider = $xmlObject->show_slider;
			$node->slider_type = $xmlObject->slider_type;
			$node->slider = $xmlObject->slider_id;
	}
?>
  	<!-- Banner Start -->
        <?php
        if ($show_slider == 'on') {
			$counter_gal = 1;
			$node->width = 960;
			$node->height = 360;
		?>               	

                <?php include("page_slider.php")?>
		<?php }?> 
<?php 
	$show_album = "";
		$cs_home_page_album = get_option("cs_home_page_album");
			if ( $cs_home_page_album <> "" ) {
				$xmlObject = new SimpleXMLElement($cs_home_page_album);
					$show_album = $xmlObject->show_album;
					$album_title = $xmlObject->album_title;
					$album_cat = $xmlObject->album_cat;
					$album_id = $xmlObject->album_id;
			}
?>
<div id="content-sec">
    	<div class="inner">  
		<?php if($show_album == 'on'){?>
        <!--Album Home Page Area Started -->            
			<?php $row = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $album_cat ."'" );?>
        	<!-- Albums Start -->
        	<div class="albums">
            	<div id="albums">
                	<!-- About Albums Start -->
                    <div class="about-albums">
						<?php $term = get_term_by( 'slug', $album_cat, 'album-category');
                        if($term <> ''){?>
                            <h1 class="heading colr">
                                <?php echo substr($album_title, 0, 30);	if ( strlen($album_title) > 30 ) echo "...";?>                        
                            </h1>
                            <p>
                                <?php echo substr($term->description, 0, 430);	if ( strlen($term->description) > 430 ) echo "...";?>
                            </p>
                        <?php }?>
                        <!-- Albums Scroll Start -->
                        <div id="mcs5_container">
                            <div class="customScrollBox">
                                <div class="horWrapper"> 
                                    <div class="container">
                                        <div class="content">
                                            <ul id="listcyle">
											<?php
                                            if($row <> ''){
                                                    query_posts( array( 'posts_per_page' => "-1", 'post_type' => 'albums', 'album-category' => "$row->name" ) ); 
                                                }else{
                                                    query_posts( array( 'posts_per_page' => "-1", 'post_type' => 'albums' ) );
                                                }
                                                if(have_posts() == ''){echo '<h3>No Album for display in this category.</h3><br />';}
                                                
                                                while ( have_posts()) : the_post();
                                            ?>                                            
                                                <li>
                                                <a href="<?php echo get_permalink();?>">                                                
													<?php
                                                    $image_id = get_post_thumbnail_id ( $post->ID );
                                                        if ( $image_id <> "" ) {
															$image_url = cs_attachment_image_src($image_id, 60, 60);
                                                            echo "<img src='".$image_url."' />";
                                                        }
                                                        else {
                                                            echo "<img width='80' height='84' src='".get_template_directory_uri()."/images/no_image.jpg' />";
                                                        }
                                                    ?>	
                                                </a>
                                                </li>
                                                <?php endwhile;?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="dragger_container">
                                        <div class="dragger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Albums Scroll End -->
                    </div>
                    <!-- About Albums End -->
                    <!-- Now Playing Start -->
                    <?php
                    global $wpdb;
					$album_release_date_db	=	'';
					$album_buy_amazon_db	=	'';
					$album_buy_apple_db		=	'';
					$album_buy_groov_db		=	'';
					$album_buy_cloud_db		=	'';
			 $cs_album = get_post_meta("$album_id", "cs_album", true);
				 if ( $cs_album <> "" ) {
					 $xmlObject = new SimpleXMLElement($cs_album);
						 $album_release_date_db = $xmlObject->album_release_date;
						 $album_buy_amazon_db = $xmlObject->album_buy_amazon;
						 $album_buy_apple_db = $xmlObject->album_buy_apple;
						 $album_buy_groov_db = $xmlObject->album_buy_groov;
						 $album_buy_cloud_db = $xmlObject->album_buy_cloud;?>
						<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.jplayer.min.js"></script>
                        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jplayer.playlist.min.js"></script>
                        <script>
                        $(document).ready(function(){
                            new jPlayerPlaylist({
                                jPlayer: "#jquery_jplayer_<?php echo $album_id;?>",
                                cssSelectorAncestor: "#jp_container_<?php echo $album_id;?>"
                            }, [                                         
                                 <?php	
                                     $my_counter = 0;
                                     foreach ( $xmlObject as $track ){
                                         if ( $track->getName() == "track" ) {
                                             if ( $my_counter < 4 ) {
                                                 $album_track_title = $track->album_track_title;
                                                 $album_track_mp3_url = $track->album_track_mp3_url;
                                                 echo '{';
                                                 echo 'title:"'.$album_track_title.'",';
                                                 echo 'mp3:"'.$album_track_mp3_url.'"';
                                                 echo '},';
                                             }
                                             $my_counter++;
                                         }
                                     }
                        ?>
                            ], {
                                swfPath: "<?php echo get_template_directory_uri()?>/scripts/frontend/Jplayer.swf",
                                supplied: "mp3",
                                wmode: "window"
                            });
                        });                                                     
                        </script>                                         
                        <!-- Now Playing Start -->
                        <div class="nowplaying">
                            <h2 class="colr"><?php echo get_the_title("$album_id");?></h5>
                            <p>by: <?php echo get_the_author();?> - <?php if($album_release_date_db <> ''){echo 'Release Date : '.$album_release_date_db;}?></p>
                            <div id="jquery_jplayer_<?php if($album_id <> ''){ echo $album_id;}?>" class="jp-jplayer"></div>
                            <div id="jp_container_<?php if($album_id <> ''){ echo $album_id;}?>" class="jp-audio">
                                <div class="jp-type-playlist">
                                    <div class="jp-gui jp-interface">
                                        <ul class="jp-controls">
                                            <li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
                                            <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                                            <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                                            <li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
                                            <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                                            <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                                            <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                                            <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                                        </ul>
                                        <div class="jp-progress">
                                            <div class="jp-seek-bar">
                                                <div class="jp-play-bar"></div>
                                            </div>
                                        </div>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value"></div>
                                        </div>
                                        <div class="jp-current-time"></div>
                                        <div class="jp-duration"></div>
                                        <ul class="jp-toggles">
                                            <li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
                                            <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
                                            <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                                            <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                                        </ul>
                                    </div>
                                    <div class="jp-playlist">
                                        <ul>
                                            <li></li>
                                        </ul>
                                    </div>
                                    <div class="jp-no-solution">
                                        <span>Update Required</span>
                                        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php }else{?>
                    	<h1 class="heading colr">Playlist Widget</h1>
                        <h4>There is no track to play.</h4>
                    <?php }?>
					<!-- Now Playing End -->
                </div>
                <a href="#" class="togglebtn">&nbsp;</a>
            </div>
            <!-- Albums End -->    
			<script>
            $(document).ready(function(){
              $(".togglebtn").toggle(function(){
                $("#albums").animate({height:145},300);
              },function(){
                $("#albums").animate({height:295},300);
              });
            });
            </script>                  
	<?php }?>         
        <!-- Columns Section Start -->
        <div class="columns-sec shade">
            <div class="threecol">
                <!-- Column One Start -->
                <div class="col1">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('homepage-left') ) : ?>
                <?php endif; ?>
                </div>
                <!-- Column One End -->
                <!-- Column Two Start -->
                <div class="col2">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('homepage-center') ) : ?>
                <?php endif; ?>
                </div>
                <!-- Column Two End -->
                <!-- Column One Start -->
                <div class="col1 hidemobile">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('homepage-right') ) : ?>
                <?php endif; ?>
                </div>
                <!-- Column One End -->
            </div>
        </div>
        <!-- Columns Section End -->
    </div>
</div>		
<!-- Content Section End -->  
<div class="clear"></div>
<?php } ?>