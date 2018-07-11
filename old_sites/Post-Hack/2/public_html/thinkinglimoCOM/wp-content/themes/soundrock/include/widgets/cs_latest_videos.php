<?php
class latest_videos extends WP_Widget
{
  function latest_videos()
  {
    $widget_ops = array('classname' => 'latest-videos', 'description' => 'Please paste embed code of Latest Video.' );
    $this->WP_Widget('latest_videos', 'ChimpS : Latest Video', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$embed_code = isset( $instance['embed_code'] ) ? esc_attr( $instance['embed_code'] ) : '';
	$short_description = isset( $instance['short_description'] ) ? esc_attr( $instance['short_description'] ) : '';	
	$show_all_videos = isset( $instance['show_all_videos'] ) ? esc_attr( $instance['show_all_videos'] ) : '';?>
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
		Title: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p> 
  <p>
  <label for="<?php echo $this->get_field_id('embed_code'); ?>">
		Video Embed Code: <br />
      <textarea rows="3"  cols="35" class="upcoming" id="<?php echo $this->get_field_id('embed_code'); ?>" name="<?php echo $this->get_field_name('embed_code'); ?>"><?php echo esc_attr($embed_code); ?></textarea>
  </label>
  </p>   
  <p>
  <label for="<?php echo $this->get_field_id('short_description'); ?>">
		Short Description:<br />
      <textarea rows="2"  cols="35" class="upcoming" id="<?php echo $this->get_field_id('short_description'); ?>" name="<?php echo $this->get_field_name('short_description'); ?>"><?php echo esc_attr($short_description); ?></textarea>
  </label>
  </p>
  <p>
  <label for="<?php echo $this->get_field_id('show_all_videos'); ?>">
		Show All Link:
	  <input class="upcoming" id="<?php echo $this->get_field_id('show_all_videos'); ?>" size="40" name="<?php echo $this->get_field_name('show_all_videos'); ?>" type="text" value="<?php echo esc_attr($show_all_videos); ?>" />
  </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['embed_code'] = $new_instance['embed_code'];
    $instance['short_description'] = $new_instance['short_description'];		
	$instance['show_all_videos'] = $new_instance['show_all_videos'];
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$embed_code = empty($instance['embed_code']) ? ' ' : apply_filters('widget_title', $instance['embed_code']);
		$short_description = empty($instance['short_description']) ? ' ' : apply_filters('widget_title', $instance['short_description']);
		$show_all_videos = empty($instance['show_all_videos']) ? ' ' : apply_filters('widget_title', $instance['show_all_videos']);						

		echo $before_widget;	
		// WIDGET display CODE Start
		if (!empty($title))
			echo $before_title;
			echo 'Latest Video';
			echo $after_title;
			global $wpdb, $post;?>
                <div class="video">
                    <?php echo html_entity_decode($embed_code);?>
                </div>
                <div class="desc">
                    <h4><a class="white"><?php echo $title;?></a></h4>
                    <p><?php echo $short_description;?></p>
                    <a href="<?php echo $show_all_videos;?>" class="buttonone">View All Videos</a>
                </div>            
	<?php echo $after_widget; ?>
		<?php } 
				}
add_action( 'widgets_init', create_function('', 'return register_widget("latest_videos");') );?>
