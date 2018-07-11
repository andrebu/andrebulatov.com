<?php get_header();
global $post_id; 
$post_xml = get_post_meta($post->ID, "cs_event_meta", true);
	if ( $post_xml <> "" ) {
		$xmlObject = new SimpleXMLElement($post_xml);
			$cs_layout = $xmlObject->cs_layout;
			$cs_sidebar_left = $xmlObject->cs_sidebar_left;
			$cs_sidebar_right = $xmlObject->cs_sidebar_right;
			if ( $cs_layout == "left" ) {
				$cs_layout = "columns-sec twocol left_sidebar";
				$show_sidebar = $cs_sidebar_left;
			}
			else if ( $cs_layout == "right" ) {
				$cs_layout = "columns-sec twocol";
				$show_sidebar = $cs_sidebar_right;
			}
			else $cs_layout = "col4";
	}	

	$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
	if ( $cs_event_meta <> "" ) {
		$cs_event_meta = new SimpleXMLElement($cs_event_meta);
	}

	$cs_event_loc = get_post_meta($xmlObject->event_address, "cs_event_loc_meta", true);
	if ( $cs_event_loc <> "" ) {
		$cs_event_loc = new SimpleXMLElement($cs_event_loc);
			$event_loc_lat = $cs_event_loc->event_loc_lat;
			$event_loc_long = $cs_event_loc->event_loc_long;
			$event_loc_zoom = $cs_event_loc->event_loc_zoom;
			$loc_address = $cs_event_loc->loc_address;
			$loc_city = $cs_event_loc->loc_city;
			$loc_postcode = $cs_event_loc->loc_postcode;
			$loc_region = $cs_event_loc->loc_region;
			$loc_country = $cs_event_loc->loc_country;
	}
	else {
		$event_loc_lat = '';
		$event_loc_long = '';
		$event_loc_zoom = '';
		$loc_address = '';
		$loc_city = '';
		$loc_postcode = '';
		$loc_region = '';
		$loc_country = '';
	}
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
var map;
		var myLatLng = new google.maps.LatLng(<?php echo $event_loc_lat;?>, <?php echo $event_loc_long;?>)
        //Initialize MAP
		var myOptions = {
          zoom: <?php echo $event_loc_zoom;?>,
          center: myLatLng,
		  disableDefaultUI: true,
		  zoomControl: true,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map_canvas'),myOptions);
		//End Initialize MAP
		//Set Marker
        var marker = new google.maps.Marker({
          position: map.getCenter(),
          map: map
        });
		marker.getPosition();
		//End marker
		
		//Set info window
		var infowindow = new google.maps.InfoWindow({
			content: '',
			position: myLatLng
		});
		infowindow.open(map);
    });

	
</script>
 	<?php if($event_loc_lat <> "" && $event_loc_long <>""){?>         
    <!-- Banner Start -->
    <div id="sub-banner">
    	<div class="in">
				<div id="map_canvas" style="height:210px"></div>
        </div>
    </div>
    <!-- Banner End -->
        <?php }?>
	<div id="content-sec">
    	<div class="inner">
	        <div class="<?php echo $cs_layout;?>">
				<?php if($cs_layout <> 'col4'){echo '<div class="col3">';}?>
				<?php
				$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
				if ( $cs_event_meta <> "" ) {$cs_event_meta = new SimpleXMLElement($cs_event_meta);}?>
			<div class="blog">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post();?>
                <?php 
				$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
				$event_to_date = get_post_meta($post->ID, "cs_event_to_date", true);?>
                <h1 class="heading colr"><?php echo get_the_title();?></h1>
					<!-- Post Detail Start -->										
                        <div class="post-detail" id="post-<?php the_ID(); ?>">
                        	<?php
							$image_id = get_post_thumbnail_id ( $post->ID );
							if($image_id <> ''){
								$image_url = cs_attachment_image_src($image_id, 680, 274);?>
                                <div class="thumb">
                                    <a href="<?php echo get_permalink();?>">
                                        <?php echo "<img src='".$image_url."' />";?>
                                    </a>
                                </div>
							<?php }?>
                            <div class="desc">
                                <div class="post-opts">
                                	<p>By <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author();?></a></p>
                                    <p> Starting On:
									<?php
										$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
										$event_to_date = get_post_meta($post->ID, "cs_event_to_date", true);
										echo date( get_option("date_format"), strtotime($event_from_date) );
                                     ?>
                                    </p>
									<?php if ( $event_from_date < $event_to_date ) {?>
	                                    <p>Ending On: <?php echo date( get_option("date_format"), strtotime($event_to_date) );?></p>
                                    <?php }?>
                                    <p><a href="<?php echo get_permalink();?>#comments"><?php echo get_comments_number($post->ID);?> Comments</a></p>
                                    <p>
									<?php if($cs_event_meta->event_start_time <> '' || $cs_event_meta->event_end_time <> ''){
												echo "<p class='time'>";
												if ( $cs_event_meta->event_all_day == "" ) {
													echo $cs_event_meta->event_start_time . " &ndash; " . $cs_event_meta->event_end_time;
												}
												else echo "All Day";
												echo "</p>";
                                            }
                                        ?>
                                    </p>
                                    <p>
                                    <?php 
									$tag_post = wp_get_post_terms($post->ID,'event-tag');
									$counterr = 0;
                                    foreach($tag_post as $values){
                                        if($counterr == 0){ echo 'Tag:  ';}
	                                        $counterr++;
                                        	echo $values->name.' - ' ;}?> 
                                    </p>
                                    <p>
										<?php 
										$event_cate = get_the_terms( $post->ID, 'event-category' );
                                        $counter = 0;
                                                foreach($event_cate as $value){
                                                    if($counter == 0){ echo 'Category:  ';}
                                                    $counter++;
                                                    echo '<a href="'.get_term_link(intval($value->term_id), $value->taxonomy).'">'.$value->name.'</a> || ';}?> 
                                    </p>
                                    <p><?php echo ' (Organizer: '.get_the_author().')';?></p>                                    
                                </div>
								<p><?php echo get_the_content(); ?></p>
                                <div class="clear"></div>  
                                <?php if($cs_event_meta->event_booking_url <> "" || $cs_event_meta->event_address <> ""){ ?>
                                <div class="ev-loc">
                                    <ul>
                                        <?php if($cs_event_meta->event_address <> ""){?>
											<li class="loc-head"><h4 class="colr">LOCATION</h4></li>
											<li class="txt">
                                            <?php
												if ( $xmlObject->event_address <> "" ) {
													echo get_the_title( "$xmlObject->event_address" );
														if ( $loc_address <> "" ) echo ", " . $loc_address;
														if ( $loc_city <> "" ) echo ", " . $loc_city;
														if ( $loc_postcode <> "" ) echo ", " . $loc_postcode;
														if ( $loc_region <> "" ) echo ", " . $loc_region;
														if ( $loc_country <> "" ) echo ", " . $loc_country;
												}
											?>
                                            </li>
                                        <?php }?>
                                        <?php if($cs_event_meta->event_booking_url <> ""){?>
                                            <li class="btn"><a href="<?php echo $cs_event_meta->event_booking_url; ?>" class="buttonone">BUY NOW</a></li>
                                        <?php }?>
                                    </ul>
                                </div>
                                <?php }?>                              
                                <?php if ( $cs_event_meta->event_social_sharing == "on" ) { ?>
										<?php $cs_social_share = get_option("cs_social_share");							
                                        if($cs_social_share != ''){
                                          $xmlObject_event = new SimpleXMLElement($cs_social_share);
                                                $twitter = $xmlObject_event->twitter;
                                                $facebook = $xmlObject_event->facebook;
                                                $linkedin = $xmlObject_event->linkedin;
                                                $digg = $xmlObject_event->digg;
                                                $delicious = $xmlObject_event->delicious;
                                                $google_plus = $xmlObject_event->google_plus;
                                                $google_buzz = $xmlObject_event->google_buzz;
                                                $google_bookmark = $xmlObject_event->google_bookmark;
                                                $myspace = $xmlObject_event->myspace;
                                                $reddit = $xmlObject_event->reddit;
                                                $stumbleupon = $xmlObject_event->stumbleupon;
                                                $yahoo_buzz = $xmlObject_event->yahoo_buzz;
                                                $rss = $xmlObject_event->rss;
                                                    if($twitter == 'on' or $facebook == 'on' or $linkedin == 'on' or $digg == 'on' or $delicious == 'on' or $google_plus == 'on' or $google_buzz == 'on' or $google_bookmark == 'on' or $myspace == 'on' or $reddit == 'on' or $stumbleupon == 'on' or $yahoo_buzz == 'on' or $rss == 'on'){
                                                        $pageurl = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>
                                                <div class="post-share">
                                                    <ul>
                                                        <li><h4 class="colr">Share This</h4></li>
                                                        <?php if($twitter == 'on'){?><li><a href="http://twitter.com/home?status=<?php the_title();?> - <?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/twitter.png" alt="" /></a><?php }?>
                                                        <?php if($facebook == 'on'){?><li><a href="http://www.facebook.com/share.php?u=<?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/facebook.png" alt="" /></a><?php }?>
                                                        <?php if($linkedin == 'on'){?><li><a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/linkedin.png" alt="" /></a><?php }?>
                                                        <?php if($digg == 'on'){?><li><a href="http://digg.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/digg.png" alt="" /></a><?php }?>												
                                                        <?php if($delicious == 'on'){?><li><a href="http://delicious.com/post?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/delicious.png" alt="" /></a><?php }?>
                                                        <?php if($google_bookmark == 'on'){?><li><a href="http://www.google.com/bookmarks/mark?op=edit&#038;bkmk=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_bookmark.png" alt="" /></a><?php }?>
                                                        <?php if($google_buzz == 'on'){?><li><a href="http://www.google.com/reader/link?title=<?php the_title();?>&url=<?php the_permalink();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_buzz.png" alt="" /></a><?php }?>												
                                                        <?php if($google_plus == 'on'){?><li><a href="https://plus.google.com/share?url=<?php the_permalink();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_plus.png" alt="" /></a><?php }?>																																																
                                                        <?php if($myspace == 'on'){?><li><a href="http://www.myspace.com/Modules/PostTo/Pages/?u=<?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/myspace.png" alt="" /></a><?php }?>
                                                        <?php if($reddit == 'on'){?><li><a href="http://reddit.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/reddit.png" alt="" /></a><?php }?>
                                                        <?php if($stumbleupon == 'on'){?><li><a href="http://www.stumbleupon.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/stumbleupon.png" alt="" /></a><?php }?>
                                                        <?php if($rss == 'on'){?><li><a href="#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/rss.png" alt="" /></a><?php }?>												
                                                	</ul>
                                            	</div>
										<?php }?>
    	                            <?php }?>
								<?php }?>                                                                                                          
                            </div>
                        </div>
                        <div class="clear"></div>
                        <!-- Post Detail End -->
                        <?php if ( get_the_author_meta( 'description' ) ) :?>
                        <div class="in-sec">
                            <div class="about-author">
                                <div class="avatars">
                                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'PixFill_author_bio_avatar_size', 53 ) ); ?>
                                </div>
                                <div class="desc">
                                    <h5><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">About <?php echo get_the_author(); ?></a></h5>
                                    <p class="txt">
                                        <?php the_author_meta( 'description' ); ?>
                                    </p>
                                    <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                         </div>   
                        <?php endif; ?>		
                    <?php comments_template( '', true ); ?>                    
			<?php endwhile; // end of the loop. ?>
                <?php if($cs_layout <> 'col4'){echo '</div>';}?>    
			</div><!-- #content -->
         <!-- two-thirds end -->
            <?php if($cs_layout != "col4"){?>
            <!--Sidebar Start-->
                <div class="col1 hidemobile">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) : ?>
                    <?php endif; ?>   
                </div>
            <?php }?>
        </div><!-- #container -->
        <div class="clear"></div>
	</div>
<?php get_footer(); ?>
<div class="clear"></div>
