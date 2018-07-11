<?php
class newsletter extends WP_Widget
{
  function newsletter()
  {
    $widget_ops = array('classname' => 'newsletter', 'description' => 'Newsletter or Subscription' );
    $this->WP_Widget('newsletter', 'ChimpS : Newsletter', $widget_ops);
  }
 
  function form($instance)
  {
	$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
	$title = $instance['title'];
	$short_desc = empty($instance['short_desc']) ? ' ' : apply_filters('widget_title', $instance['short_desc']);			
	?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">
            Title: 
            <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </label>
    </p>     
    <p>
      <label for="<?php echo $this->get_field_id('short_desc'); ?>">
            Short Description:<br />
          <textarea rows="2"  cols="35" class="upcoming" id="<?php echo $this->get_field_id('short_desc'); ?>" name="<?php echo $this->get_field_name('short_desc'); ?>"><?php echo esc_attr($short_desc); ?></textarea>
      </label>    
    </p>     
    <?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];	
    $instance['short_desc'] = $new_instance['short_desc'];		
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
	extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);	
		$short_desc = empty($instance['short_desc']) ? ' ' : apply_filters('widget_title', $instance['short_desc']);			
		echo $before_widget;	
			// WIDGET display CODE Start
			if (!empty($title))
				echo $before_title;
				echo $title;
				echo $after_title;
				global $wpdb, $post;

			?>
				<!-- Newsletter Start -->
					<script>
                        function frm_newsletter(){
                            $("#btn_newsletter").hide();
                            $("#process_newsletter").html('<img src="<?php echo get_template_directory_uri()?>/images/ajax_loading.gif" />');
                            $.ajax({
                                type:'POST', 
                                url: '<?php echo get_template_directory_uri()?>/include/newsletter_save.php',
                                data:$('#frm_newsletter').serialize(), 
                                success: function(response) {
                                    $('#frm_newsletter').get(0).reset();
                                    $('#newsletter_mess').show('');
                                    $('#newsletter_mess').html(response);
                                    $("#btn_newsletter").show('');
                                    $("#process_newsletter").html('');
                                    slideout_msgs();
                                    //$('#frm_slide').find('.form_result').html(response);
                                }
                            });
                        }
                    </script>
                    <!-- Newsletter End -->					
						<form id="frm_newsletter" action="javascript:frm_newsletter()">
                            <div id="newsletter_mess"></div>
								<?php if($short_desc != ''){ 
											echo '<p>';
											echo substr($short_desc, 0, 120); 
											if ( strlen($short_desc) > 120 ) echo "..."; 
											echo '</p>';
										}
								?>
								<input type="text" class="bar" name="newsletter_email" value="Enter Email Address" onfocus="if(this.value=='Enter Email Address') {this.value='';}" onblur="if(this.value=='') {this.value='Enter Email Address';}" />
								<button id="btn_newsletter" class="backcolr">Submit</button>
								<div id="process_newsletter"></div>                            
				        </form>
                    <!-- Newsletter End -->              
			<?php
		echo $after_widget;
		}
		
	}
add_action( 'widgets_init', create_function('', 'return register_widget("newsletter");') );?>