<?php
class featured_album extends WP_Widget
{
  function featured_album()
  {
    $widget_ops = array('classname' => 'top-seller', 'description' => 'Please select an album for featured.' );
    $this->WP_Widget('featured_album', 'ChimpS : Featured Album', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'widget_names_events' =>'new') );
    $title = $instance['title'];
	$get_names_albums = isset( $instance['get_names_albums'] ) ? esc_attr( $instance['get_names_albums'] ) : '';
?>
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
	  Title: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p>
  <p>
  <label for="<?php echo $this->get_field_id('get_names_albums'); ?>">
	  Featured Album:
	  <select id="<?php echo $this->get_field_id('get_names_albums'); ?>" name="<?php echo $this->get_field_name('get_names_albums'); ?>" style="width:225px">
		<?php
        global $wpdb,$post;
		wp_reset_query();
        query_posts( array( 'posts_per_page' => '-1', 'post_type' => 'albums', ) );
				while ( have_posts() ): the_post(); ?>
                    <option <?php if(esc_attr($get_names_albums) == $post->ID){echo 'selected';}?> value="<?php echo $post->ID;?>" >
	                    <?php echo substr(get_the_title($post->ID), 0, 20);	if ( strlen(get_the_title($post->ID)) > 20 ) echo "...";?>
                    </option>						
			<?php endwhile;
			wp_reset_query();
			?>
      </select>
  </label>
  </p>  
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['get_names_albums'] = $new_instance['get_names_albums'];	
    return $instance;
  }
 
	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$get_names_albums = isset( $instance['get_names_albums'] ) ? esc_attr( $instance['get_names_albums'] ) : '';
		// WIDGET display CODE Start
			echo $before_widget;
			if($title <> ""){
			echo $before_title;
			echo $title;
			echo $after_title;
			}

		global $wpdb, $post;
		if($instance['get_names_albums'] <> ''){
		 $image_id = get_post_thumbnail_id ( $instance['get_names_albums'] );
		 //$image_url = wp_get_attachment_image_src($image_id, array(210,210),true);
		 if($image_id <> ''){
			 $image_url = cs_attachment_image_src($image_id, 210, 210);?>
		        <!-- Top Sellers Start -->
                <div class="thumb">
                    <a href="<?php echo get_permalink($instance['get_names_albums']);?>"><img width="260" height="260" src="<?php echo $image_url;?>" alt="<?php echo get_the_title($instance['get_names_albums']);?>" /></a>
                </div>
            <?php }?>
            <div class="desc">
                <h4><a href="<?php echo get_permalink($instance['get_names_albums']);?>" class="white"><?php echo get_the_title($instance['get_names_albums']);?></a></h4>
                <p>
                    <?php
						$content_of_post = get_post($instance['get_names_albums']);
						$content = $content_of_post->post_content;
						$content = apply_filters('the_content', $content); 
						echo substr($content, 0, "150");?>
                </p>
			</div>
        <!-- Top Sellers End -->
        <?php }?>
			<?php echo $after_widget;	// WIDGET display CODE End
		}
	}
add_action( 'widgets_init', create_function('', 'return register_widget("featured_album");') );?>