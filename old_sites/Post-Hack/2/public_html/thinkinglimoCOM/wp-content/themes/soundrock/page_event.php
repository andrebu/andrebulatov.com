<?php
	$meta_compare = '';
	$filter_category = '';
	if ( $node->cs_event_type == "Upcoming Events" ) $meta_compare = ">=";
	else if ( $node->cs_event_type == "Past Events" ) $meta_compare = "<";

	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $node->cs_event_category ."'" );
	//if ( empty ($row_cat->name) or $row_cat->name == "" ) $row_cat->name = "";
	if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
	else {
			if(isset($row_cat->slug)){
				$filter_category = $row_cat->slug;
			}
		}
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;

		$args = array(
					'posts_per_page'			=> "-1",
					'post_type'					=> 'events',
					'event-category'			=> "$filter_category",
					'post_status'				=> 'publish',
					'meta_key'					=> 'cs_event_to_date',
					'meta_value'				=> date('Y-m-d'),
					'meta_compare'				=> $meta_compare,
					'orderby'					=> 'meta_value',
					'order'						=> 'ASC',
				);
		query_posts($args);
		$count_post = 0;
			while ( have_posts()) : the_post();
				$count_post++;
			endwhile;		
		if ( $node->cs_event_pagination == "Single Page") $node->cs_event_per_page = -1;?>
            <h1 class="heading colr"><?php echo $node->cs_event_title?></h1>
            <?php if($node->cs_event_filterables == "On"){?>
            <div class="cat-select">
                <ul>
                    <li><h5>Select Events Category</h5></li>
                    <li>
                        <form action="" method="get">
                            <input type="hidden" name="page_id" value="<?php if (isset($_GET['page_id'])) echo $_GET['page_id']?>" />
                            <select name="filter_category" onchange="this.form.submit()">
                                <option><?php if(isset($row_cat->name)){echo $row_cat->name;}?></option>
                                <?php
                                    $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
                                    foreach ($categories as $category) {?>
                                    <option <?php if($filter_category==$category->cat_name) echo "selected";?> ><?php echo $category->cat_name?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </li>
                </ul>
            </div>
            <?php }?>
                    <!-- Gigs Tabs Start -->
			<?php if($node->cs_event_view == "List View"){?>
                    	<!-- Timeline Start -->
							<div class="gigs">
                                <!--<div class="month">
                                    <?php if($node->cs_event_type == "Upcoming Events"){?>
                                    	<a href="#" class="button">Upcomming Events</a>
									<?php }else{?>
										<a href="#" class="button">Past Events</a>	
									<?php }?>
                                </div>-->
                           <?php
							$args = array(
                                'posts_per_page'			=> "$node->cs_event_per_page",
                                'paged'						=> $_GET['page_id_all'],
                                'post_type'					=> 'events',
                                'event-category'			=> "$filter_category",
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'cs_event_to_date',
                                'meta_value'				=> date('Y-m-d'),
                                'meta_compare'				=> $meta_compare,
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',

                            );
                    query_posts($args);
                    if ( have_posts() <> "" ) {
						$counter_events = 0;
                        while ( have_posts() ): the_post();
							$counter_events++;
                            //$total_post_array[] = $post->ID;
                            $cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
                            if ( $cs_event_meta <> "" ) {
                                $cs_event_meta = new SimpleXMLElement($cs_event_meta);
                            }?>
                        <!-- GIG Post Start -->
                        <div class="gig-post">
                        	<div class="upper-sec">
                                <div class="date">
                                    <h1>
									<?php 
										$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
										$event_to_date = get_post_meta($post->ID, "cs_event_to_date", true);
										echo date("d", strtotime($event_from_date));
										?>
									</h1>
                                    <h1>
                                    <?php echo date("M", strtotime($event_from_date));?>
                                    </h1>
                                </div>
                                <div class="desc">
                                    <a href="<?php echo get_permalink();?>" class="thumb">
										<?php
                                            $image_id = get_post_thumbnail_id ( $post->ID );
                                            if ( $image_id <> "" ) {
                                                //$image_url = wp_get_attachment_image_src($image_id, array(120,95),true);
                                                $image_url = cs_attachment_image_src($image_id, 120, 104);
                                                echo "<img src='".$image_url."' />";
                                            }
                                            else {
                                                echo "<img width='120' height='104' src='".get_template_directory_uri()."/images/no_image.jpg' />";
                                            }
                                         ?>	
                                    </a>
                                    <div class="txt-sec">
                                        <h3>
                                            <a href="<?php echo get_permalink()?>">
                                                <?php echo substr(get_the_title(), 0, 45);  if ( strlen(get_the_title()) > 50 ) echo "..."; ?>
                                            </a>
                                        </h3>
										<?php 
                                            if($node->cs_event_time == 'Yes') {
												if($cs_event_meta->event_start_time <> '' || $cs_event_meta->event_end_time <> ''){
													echo "<p class='time'>";
													if ( $cs_event_meta->event_all_day == "" ) {
														echo $cs_event_meta->event_start_time . " &ndash; " . $cs_event_meta->event_end_time;
													}
													else echo "All Day";
													echo "</p>";
												}
                                            }
                                            ?>
											<?php
													$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);
													if ( $cs_event_loc <> "" ) {
														$xmlObject = new SimpleXMLElement($cs_event_loc);
															$event_loc_lat = $xmlObject->event_loc_lat;
															$event_loc_long = $xmlObject->event_loc_long;
															$event_loc_zoom = $xmlObject->event_loc_zoom;
													}
													else {
														$event_loc_lat = '';
														$event_loc_long = '';
														$event_loc_zoom = '';
													}
                                                ?>
                                        <p class="location"><?php if($cs_event_meta->event_address <> ''){echo get_the_title("$cs_event_meta->event_address");}?></p>
                                        <div class="clear"></div>
                                        <p class="txt">
											<?php
                                                $cs_news_excerpt_db = $node->cs_event_excerpt;
                                                if ( $post->post_excerpt <> "" ) $get_the_excerpt = $post->post_excerpt;
                                                else $get_the_excerpt = $post->post_content;
                                                    $get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU','', $get_the_excerpt ));
                                                    echo substr($get_the_excerpt, 0, "$cs_news_excerpt_db");
                                                    if ( strlen( $get_the_excerpt ) > "$cs_news_excerpt_db" ) {
                                                        echo '... <a class="readmore" href="'.get_permalink().'"> Read more</a>';
                                                    }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php if($counter_events == 1 && $_GET['page_id_all'] == 1){?>
                            <div class="map-sec <?php if($counter_events == 1){echo 'active';}?>" id="mapctr<?php echo $post->ID;?>" style="display:none;">
                                <div class="mapdiv<?php echo $post->ID;?> <?php if($counter_events == 1){echo 'active';}?>" id="map_canvas<?php echo $post->ID;?>" style="display:none; height:190px;"></div>
                            </div>
                            <script>                                     
							if( jQuery('.mapdiv<?php echo $post->ID;?>').hasClass('active')){
								 jQuery(document).ready(function($) {
								var map;
										var myLatLng = new google.maps.LatLng(<?php echo $event_loc_lat?>, <?php echo $event_loc_long?>)
										//Initialize MAP
										var myOptions = {
										  zoom: 16,
										  center: myLatLng,
										  disableDefaultUI: true,
										  zoomControl: true,
										  mapTypeId: google.maps.MapTypeId.ROADMAP
										};
										map = new google.maps.Map(document.getElementById('map_canvas<?php echo $post->ID;?>'),myOptions);
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
							}
                        </script>
                            <a onClick="showhide(<?php echo $event_loc_lat?>, <?php echo $event_loc_long?>, <?php echo $event_loc_zoom;?>, <?php echo $post->ID;?>);" class="mapbtn"></a>
                            
	                    <?php }else{?>
                            <div class="map-sec" id="mapctr<?php echo $post->ID;?>" style="display:none;">
                                <div class="mapdiv<?php echo $post->ID;?>" id="map_canvas<?php echo $post->ID;?>" style="display:none; height:190px;"></div>
                            </div>
                            <a onClick="showhide(<?php echo $event_loc_lat?>, <?php echo $event_loc_long?>, <?php echo $event_loc_zoom;?>, <?php echo $post->ID;?>);" class="mapbtn"></a>                        
                        <?php }?>
                       </div>
                        <!-- GIG Post End -->   
								<?php
                                    endwhile;
                                }else{?>
                                <h2>There is no event to display.</h2>
                                <?php }?>
                                    <div class="clear"></div>
                                    	<?php
										$qrystr = '';
										if(cs_pagination($count_post, $node->cs_event_per_page, $qrystr) <> ''){
                                        // pagination start
                                            if ( $node->cs_event_pagination == "Show Pagination" and $node->cs_event_per_page > 0 ) {
                                                echo "<div class='paging'><ul>";
													if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
													if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
                                                echo cs_pagination($count_post, $node->cs_event_per_page, $qrystr);
                                                echo "</ul></div>";
                                            }
                                        // pagination end
										}
										?>
                                </div>
                                <!-- Timeline End -->
								<script type="text/javascript">
                                
                                    function showhide(lat,long,zoom_get,map_canvas){
                                        $(".mapdiv"+map_canvas).slideToggle();
                                        hidefnc(map_canvas);
                                        $(".mapdiv"+map_canvas).html();
                                        initialize(lat, long, zoom_get, map_canvas);
                                        $("#maps"+map_canvas).addClass("active");
                                    }
                                    function hidefnc(map_canvas){
                                        $("#mapctr"+map_canvas).slideToggle();
                                        $("#map_canvas"+map_canvas).removeClass('active');
                                        $("#mapctr"+map_canvas).removeClass('active');				
                                    }
                                </script>
                                <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
                                <script type="text/javascript">
                                  var map;
                                  function initialize(lat, long, zoom_get, map_canvas) {
                                      var myLatLng = new google.maps.LatLng(lat, long)
                                            //Initialize MAP
                                      var myOptions = {
                                          zoom: zoom_get,
                                          center: myLatLng,
                                          disableDefaultUI: true,
                                          zoomControl: true,			  
                                          mapTypeId: google.maps.MapTypeId.ROADMAP
                                        };
                                        map = new google.maps.Map(document.getElementById('map_canvas'+map_canvas),myOptions);
                                      //End Initialize MAP
                                      //Set Marker
                                        var marker = new google.maps.Marker({
                                          position: map.getCenter(),
                                          map: map
                                        });
                                      marker.getPosition();
                                      google.maps.event.trigger(map, 'resize');
                                      //End marker
                                      //Set info window
                                      var infowindow = new google.maps.InfoWindow({
                                       content: '',
                                       position: myLatLng
                                      });
                                      infowindow.open(map);
                                      $("#maps").addClass("active"); 
                                       //end info window
                                  }
                                </script>
		<?php }else{
			$args = array(
					'posts_per_page'			=> "-1",
					'post_type'					=> 'events',
					'event-category'			=> "$filter_category",
					'post_status'				=> 'publish',
					'meta_key'					=> 'cs_event_to_date',
					'meta_value'				=> date('Y-m-d'),
					'meta_compare'				=> $meta_compare,
					'orderby'					=> 'meta_value',
					'order'						=> 'ASC',
				);
		query_posts($args);
		//query_posts( array( 'posts_per_page' => "-1", 'post_type' => 'events', 'cs_event_categories_tax' => "$filter_category" ) );
			if ( have_posts() <> "" ) {
				while ( have_posts() ): the_post();
					$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
					$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
					if ( $cs_event_meta <> "" ) {
						$cs_event_meta = new SimpleXMLElement($cs_event_meta);
					}
					$aaa[] = array(
						'title' => substr(get_the_title(), 0, 35).'....',
						'start' => date("Y-m-d", strtotime($event_from_date)),
						'url' => get_permalink()
					);
				endwhile;?>
  			 <!--Calendar View start-->
            <link rel='stylesheet' type='text/css' href='<?php echo get_template_directory_uri()?>/css/fullcalendar.css' />
            <script type='text/javascript' src='<?php echo get_template_directory_uri()?>/scripts/fullcalendar/fullcalendar.min.js'></script>
            <script type='text/javascript'>
                $(document).ready(function() {
                    $('#calendar').fullCalendar({
                        editable: false,
                        events: <?php echo json_encode( $aaa );?>,
                        eventDrop: function(event, delta) {
                            alert(event.title + ' was moved ' + delta + ' days\n' +
                                '(should probably update your database)');
                        },
                        loading: function(bool) {
                            if (bool) $('#loading').show();
                            else $('#loading').hide();
                        }
                    });
                });
            </script>
            <div id='loading' style='display:none'>loading...</div>
            <div class="in-sec in-sec-nopad">
                <div id='calendar'></div>
            </div>
        <!--Calendar View end -->
		<?php }else{?>
        	<h2>There is no event to display.</h2>
        <?php }?>    
</div>
<?php }?>
