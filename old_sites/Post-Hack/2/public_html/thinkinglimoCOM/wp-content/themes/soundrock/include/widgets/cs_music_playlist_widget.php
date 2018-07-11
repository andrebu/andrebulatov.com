<?php
class cs_music_player extends WP_Widget
{
  function cs_music_player()
  {
    $widget_ops = array('classname' => 'cs_music_player', 'description' => 'Select Album to For Playlist.' );
    $this->WP_Widget('cs_music_player', 'ChimpS : MusicPlayList', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$select_title = isset( $instance['select_title'] ) ? esc_attr( $instance['select_title'] ) : '';
	$numtrack = isset( $instance['numtrack'] ) ? esc_attr( $instance['numtrack'] ) : '';

?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">
          <span>Title: </span>
          <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
      </label>
    </p>
    <br />
    
    <p>
      <label for="<?php echo $this->get_field_id('select_title'); ?>">
          <span>Album for Playlist:</span>
          <br /><br />

          <select name="<?php echo $this->get_field_name('select_title'); ?>" style="width:225px;">
          <?php
                global $wpdb;
                $args = array( 'post_type' => 'albums', 'posts_per_page' => -1,'post_status'=> 'publish');
                $loop = new WP_Query( $args );
                while ( $loop->have_posts() ) : $loop->the_post();
            ?>	
                    <option <?php if($select_title == get_the_id()){echo 'selected';}?> value="<?php the_ID();?>">
					<?php echo substr(get_the_title(), 0, 20);	if ( strlen(get_the_title()) > 20 ) echo "...";?>
					</option>
                <?php endwhile;  ?>
          </select>
      </label>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('noot'); ?>">
          <span>No Of Tracks To Play: </span>
          <input class="upcoming" id="<?php echo $this->get_field_id('numtrack'); ?>" size="2" name="<?php echo $this->get_field_name('numtrack'); ?>" type="text" value="<?php echo esc_attr($numtrack); ?>" />
      </label>
    </p>    
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['select_title'] = $new_instance['select_title'];
	$instance['numtrack'] = $new_instance['numtrack'];	
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$select_title = empty($instance['select_title']) ? ' ' : apply_filters('widget_title', $instance['select_title']);		
		 echo $before_widget;
		// WIDGET display CODE Start
		if (!empty($title))
			
			echo $before_title . $title . $after_title;
			global $wpdb;
			if($select_title <> ''){
			 $album_buy_amazon_db ='';
			 $album_buy_apple_db = '';
			 $album_buy_groov_db ='';
			 $album_buy_cloud_db = '';			 
			 $cs_album = get_post_meta($instance['select_title'], "cs_album", true);
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
                                jPlayer: "#jquery_jplayer_<?php echo $instance['select_title'];?>",
                                cssSelectorAncestor: "#jp_container_<?php echo $instance['select_title'];?>"
                            }, [                                         
                                 <?php	
                                     $my_counter = 0;
                                     foreach ( $xmlObject as $track ){
                                         if ( $track->getName() == "track" ) {
                                             if ( $my_counter < $instance['numtrack'] ) {
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
                            <h5><?php if($instance['select_title'] <> ''){echo get_the_title($instance['select_title']);}?></h5>
                            <p>by: <?php echo get_the_author();?> - <?php if(isset($album_release_date_db)){echo 'Release Date : '.$album_release_date_db;}?></p>
                            <div id="jquery_jplayer_<?php echo $instance['select_title'];?>" class="jp-jplayer"></div>
                            <div id="jp_container_<?php echo $instance['select_title'];?>" class="jp-audio">
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
                                    <h2>There is no track to play</h2>
                          <?php
						  } 
		} // if Album is not Selected 
		else{
			echo '<h2>There is no Track to Play</h2>';
			
			}
	echo $after_widget;
	}
}
	
add_action( 'widgets_init', create_function('', 'return register_widget("cs_music_player");') );?>