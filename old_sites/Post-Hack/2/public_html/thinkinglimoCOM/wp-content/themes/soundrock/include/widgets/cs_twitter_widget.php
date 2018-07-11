<?php
class cs_twitter_widget extends WP_Widget
{
  function cs_twitter_widget()
  {
    $widget_ops = array('classname' => 'cs_twitter_widget', 'description' => 'twitter widget' );
    $this->WP_Widget('cs_twitter_widget', 'ChimpS : Twitter Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
    $username = isset( $instance['username'] ) ? esc_attr( $instance['username'] ) : '';	
	$numoftweets = isset( $instance['numoftweets'] ) ? esc_attr( $instance['numoftweets'] ) : '';	
?>
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
	  <span>Title: </span>
	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p>
  <p>
  <label for="<?php echo $this->get_field_id('username'); ?>">
	  <span>User Name: </span>
	  <input class="upcoming" id="<?php echo $this->get_field_id('username'); ?>" size="40" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
  </label>
  </p>  
  <br />
      <div class="clear"></div>
  <p>
  <label for="<?php echo $this->get_field_id('numoftweets'); ?>">
	  <span>Num of Tweets: </span>
	  <input class="upcoming" id="<?php echo $this->get_field_id('numoftweets'); ?>" size="2" name="<?php echo $this->get_field_name('numoftweets'); ?>" type="text" value="<?php echo esc_attr($numoftweets); ?>" />
      <div class="clear"></div>
  </label>
  </p>   
      <div class="clear"></div>        
 
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['username'] = $new_instance['username'];
    $instance['numoftweets'] = $new_instance['numoftweets'];		
    return $instance;
  }
 
	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$username = $instance['username'];		
		$numoftweets = $instance['numoftweets'];		
	 	if($numoftweets == ''){$numoftweets = 5;}
		// WIDGET display CODE Start
		if (!empty($title))
			echo $before_widget;
			echo $before_title .$title. $after_title;
			if($username <> ''){
			?>
				<!-- Twitter Scroll End -->
				<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/frontend/jquery.tweetable.js"></script>
				<script type="text/javascript">
                    $(function(){
                        $('#tweet-links').tweetable({username: '<?php echo $username;?>', time: true, limit: <?php echo $numoftweets;?>, replies: true, position: 'append'});
                    });
                </script>
                <!-- Twitter End -->						                
                <div id="tweet-links"></div>
<?php
		}else{
             echo '<h4>No User information given.</h4>';
			}
			echo $after_widget;
		// WIDGET display CODE End
		}
	}
add_action( 'widgets_init', create_function('', 'return register_widget("cs_twitter_widget");') );?>