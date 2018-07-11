<?php
class recentposts extends WP_Widget
{
  function recentposts()
  {
    $widget_ops = array('classname' => 'latest-news', 'description' => 'Recent Posts from category.' );
    $this->WP_Widget('recentposts', 'ChimpS : Recent Posts', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$select_category = isset( $instance['select_category'] ) ? esc_attr( $instance['select_category'] ) : '';
	$numofposts = isset( $instance['numofposts'] ) ? esc_attr( $instance['numofposts'] ) : '';	
?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">
            Title: 
            <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </label>
    </p> 
    <p>
        <label for="<?php echo $this->get_field_id('select_category'); ?>">
          Select Category:            
          <select id="<?php echo $this->get_field_id('select_category'); ?>" name="<?php echo $this->get_field_name('select_category'); ?>" style="width:225px">
            <?php
			$category_ids = get_all_category_ids();
                if($category_ids <> ""){
                    foreach ( $category_ids as $cat_id ) {?>
                        <option <?php if($select_category == $cat_id){echo 'selected';}?> value="<?php echo $cat_id;?>" ><?php echo get_cat_name($cat_id);?></option>						
                    <?php }?>
                <?php }?>            
          </select>
        </label>
    </p>  
    <p>
        <label for="<?php echo $this->get_field_id('numofposts'); ?>">
            Number of Posts To Display:
            <input class="upcoming" id="<?php echo $this->get_field_id('numofposts'); ?>" size='2' name="<?php echo $this->get_field_name('numofposts'); ?>" type="text" value="<?php echo esc_attr($numofposts); ?>" />
        </label>
    </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['select_category'] = $new_instance['select_category'];
	$instance['numofposts'] = $new_instance['numofposts'];
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);		
		$numofposts = empty($instance['numofposts']) ? ' ' : apply_filters('widget_title', $instance['numofposts']);		
		if($instance['numofposts'] == ""){$instance['numofposts'] = '-1';}
		echo $before_widget;	
		// WIDGET display CODE Start
		if (!empty($title))
			echo $before_title;
			echo $title;
			echo $after_title;
			global $wpdb, $post;?>
            <!-- Recent Posts Start -->
				<ul class="news-list">
                <?php
			wp_reset_query();
			query_posts( array( 'posts_per_page' => "$numofposts",'post_type' => 'post','cat' => "$select_category") ); 
			if ( have_posts() <> "" ) {
			while ( have_posts()) : the_post();?>
				<!-- Upcoming Widget Start -->
					<li>

								<div class="thumb">
								<?php
                                    $image_id = get_post_thumbnail_id ($post->ID);	
                                    if ( $image_id <> "" ) {
                                        //$image_url = wp_get_attachment_image_src($image_id, array(120,104),true);
										$image_url = cs_attachment_image_src($image_id, 120, 104);
										?>
                                            <a href="<?php echo get_permalink();?>">
                                                <img src="<?php echo $image_url?>" alt="" />
                                            </a>                                                      
                                <?php	}
                                    else {
                                        echo "<a href='".get_permalink()."'><img width='120' height='80' src='".get_template_directory_uri()."/images/no_image.jpg' /></a>";
                                    }
                                    ?>
                                </div>
                        <div class="desc">
							<h5><a class="white" href="<?php echo get_permalink()?>"><?php echo substr(get_the_title ( ), 0, 20); if ( strlen(get_the_title ( )) > 20 ) echo "...";?></a></h5>
                            <p class="post-opts">
								<?php echo get_the_date();?> /
                                <a href="<?php echo get_permalink();?>#comments"><?php echo get_comments_number($post->ID);?> comments</a>
                            </p>
                            <p class="txt">
							<?php
								if ( $post->post_excerpt <> "" ) $get_the_excerpt = $post->post_excerpt;
								else $get_the_excerpt = $post->post_content;
									$get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU','', $get_the_excerpt ));
									echo substr($get_the_excerpt, 0, "60");
									if ( strlen( $get_the_excerpt ) > "60" ) {
										echo '... <a href="'.get_permalink().'"> Read more</a>';
									}
                            ?>
                            </p>
                        </div>
					</li>                 
                    <?php endwhile; ?>
            </ul>
			<a href="<?php echo get_category_link($select_category);?>" class="buttonone">View All Posts</a>
		<?php }else{
				echo '<h4>There is no post to show.</h4>';
			}?>
            <!-- Recent Posts End -->     
            
	<?php
	echo $after_widget;
		}
		
	}
add_action( 'widgets_init', create_function('', 'return register_widget("recentposts");') );?>