<?php
class facebook_module extends WP_Widget
{
  function facebook_module()
  {
    $widget_ops = array('classname' => 'facebook_module', 'description' => 'Facebook widget like box total customized with theme.' );
    $this->WP_Widget('facebook_module', 'ChimpS : Facebook', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';
	$showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';
	$showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';
	$showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';
	//$likebox_width = isset( $instance['likebox_width'] ) ? esc_attr( $instance['likebox_width'] ) : '';
	$likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';						
?>
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
	  Title: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size='40' name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p> 
  <p>
  <label for="<?php echo $this->get_field_id('pageurl'); ?>">
	  Page URL: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('pageurl'); ?>" size='40' name="<?php echo $this->get_field_name('pageurl'); ?>" type="text" value="<?php echo esc_attr($pageurl); ?>" />
	<br />
      <small>Please enter your page or User profile url example: http://www.facebook.com/profilename OR <br />
      https://www.facebook.com/pages/wxyz/123456789101112
	</small><br />
    <!--<strong>Only People Will Be Shown Please Use Height to Manage Your View.</strong>-->
  </label>
  </p> 
  <p>
  <label for="<?php echo $this->get_field_id('showfaces'); ?>">
	  Number of peoples to show: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('showfaces'); ?>" size='2' name="<?php echo $this->get_field_name('showfaces'); ?>" type="text" value="<?php echo esc_attr($showfaces); ?>" />
  </label>
  </p>
  <p>
  <label for="<?php echo $this->get_field_id('showstream'); ?>">
	  Show Stream: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('showstream'); ?>" name="<?php echo $this->get_field_name('showstream'); ?>" type="checkbox" <?php if(esc_attr($showstream) != '' ){echo 'checked';}?> />
  </label>
  </p> 
  <!--<p>
  <label for="<?php echo $this->get_field_id('likebox_width'); ?>">
	  Like Box Width:
	  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_width'); ?>" size='5' name="<?php echo $this->get_field_name('likebox_width'); ?>" type="text" value="<?php echo esc_attr($likebox_width); ?>" />
  </label>
  </p>-->
  <p>
  <label for="<?php echo $this->get_field_id('likebox_height'); ?>">
	  Like Box Height:
	  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_height'); ?>" size='2' name="<?php echo $this->get_field_name('likebox_height'); ?>" type="text" value="<?php echo esc_attr($likebox_height); ?>" />
  </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['pageurl'] = $new_instance['pageurl'];
	$instance['showfaces'] = $new_instance['showfaces'];	
	$instance['showstream'] = $new_instance['showstream'];
	$instance['showheader'] = $new_instance['showheader'];	
	//$instance['likebox_width'] = $new_instance['likebox_width'];
	$instance['likebox_height'] = $new_instance['likebox_height'];			
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$pageurl = empty($instance['pageurl']) ? ' ' : apply_filters('widget_title', $instance['pageurl']);
		$showfaces = empty($instance['showfaces']) ? ' ' : apply_filters('widget_title', $instance['showfaces']);
		$showstream = empty($instance['showstream']) ? ' ' : apply_filters('widget_title', $instance['showstream']);
		$showheader = empty($instance['showheader']) ? ' ' : apply_filters('widget_title', $instance['showheader']);
		//$likebox_width = empty($instance['likebox_width']) ? ' ' : apply_filters('widget_title', $instance['likebox_width']);								
		$likebox_height = empty($instance['likebox_height']) ? ' ' : apply_filters('widget_title', $instance['likebox_height']);													
		
		echo $before_widget;	
		// WIDGET display CODE Start
		if (!empty($title))
			echo $before_title;
			echo $title;
			echo $after_title;
			global $wpdb, $post;?>
<?php
		$profile_id = '';
		if(preg_match('@^(https?://)?(www\.)?facebook\.com/((pages/([^/]+)/(\d+))|([^/]+))@', $pageurl, $matches)) {
			if(ctype_alpha($matches[3])){
				$link = json_decode(file_get_contents('http://graph.facebook.com/'.$matches[3].''));
				$profile_id = $link->id;	
			} else if(ctype_digit($matches[6])){$profile_id = $matches[6];};
		}
		if($likebox_height == ' ' || $likebox_height == ''){$likebox_height = '315';}?>         
		<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US"></script>
        <script type="text/javascript">FB.init("3b7fb25a343af2a2f5266fb03e54789a");</script>
        <fb:fan profile_id="<?php echo $profile_id;?>" stream="<?php echo $showstream;?>" connections="<?php echo $showfaces;?>" logobar="0" width="260" height="<?php echo $likebox_height;?>" css="<?php echo get_template_directory_uri(); ?>/css/facebook.css?126"></fb:fan>
    
	<?php echo $after_widget;
		}
		
	}
add_action( 'widgets_init', create_function('', 'return register_widget("facebook_module");') );?>