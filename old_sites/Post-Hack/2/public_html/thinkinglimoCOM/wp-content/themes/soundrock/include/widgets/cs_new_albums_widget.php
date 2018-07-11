<?php
class otheralbums extends WP_Widget
{
  function otheralbums()
  {
    $widget_ops = array('classname' => 'albums-widget', 'description' => 'New Albums widget listing of albums from album category.' );
    $this->WP_Widget('otheralbums', 'ChimpS : New Albums', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$get_cate_albums = isset( $instance['get_cate_albums'] ) ? esc_attr( $instance['get_cate_albums'] ) : '';	
	$numalbums = isset( $instance['numalbums'] ) ? esc_attr( $instance['numalbums'] ) : '';
?>
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
	  Title: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p>
  <p>
  <label for="<?php echo $this->get_field_id('get_cate_albums'); ?>">
	  Select Album Category:
	  <select id="<?php echo $this->get_field_id('get_cate_albums'); ?>" name="<?php echo $this->get_field_name('get_cate_albums'); ?>" style="width:225px">
		<?php
        global $wpdb,$post;
		wp_reset_query();
			$categories = get_terms("album-category");
			if($categories <> ""){
				foreach ( $categories as $category ) {?>
					<option <?php if($get_cate_albums == $category->term_id){echo 'selected';}?> value="<?php echo $category->term_id;?>" ><?php echo $category->name;?></option>						
	            <?php }?>
            <?php }?>            
      </select>
  </label>
  </p>   
  <p>
  <label for="<?php echo $this->get_field_id('numalbums'); ?>">
	  Number of Albums To Display:
	  <input class="upcoming" id="<?php echo $this->get_field_id('numalbums'); ?>" size='2' name="<?php echo $this->get_field_name('numalbums'); ?>" type="text" value="<?php echo esc_attr($numalbums); ?>" />
  </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['get_cate_albums'] = $new_instance['get_cate_albums'];	
	$instance['numalbums'] = $new_instance['numalbums'];
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$get_cate_albums = empty($instance['get_cate_albums']) ? ' ' : apply_filters('widget_title', $instance['get_cate_albums']);		
		$numalbums = empty($instance['numalbums']) ? ' ' : apply_filters('widget_title', $instance['numalbums']);				
		if($numalbums == ""){$numalbums = '-1';}
		echo $before_widget;	
		// WIDGET display CODE Start
		if (!empty($title))
			echo $before_title;
			echo $title;
			echo $after_title;
			global $wpdb, $post;?>
            <!-- Recent Posts Start -->
            <ul>
                <?php 
				
					$args = array(
						'posts_per_page' => $numalbums,
						'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'album-category',
								'field' => 'term_id',
								'terms' => array( $get_cate_albums )
							)
						)
					);
					$my_query = new WP_Query($args);
				if ( have_posts() <> "" ) {
					while ( $my_query->have_posts() ): $my_query->the_post(); ?>
				<!-- Upcoming Widget Start -->
					<li>
                        <?php
						$cs_album = get_post_meta($post->ID, "cs_album", true);
						if ( $cs_album <> "" ) {
							$xmlObject = new SimpleXMLElement($cs_album);
						}
						$image_id = get_post_thumbnail_id ($post->ID);	
						if ( $image_id <> "" ) {
							//$image_url = wp_get_attachment_image_src($image_id, 'full',true);
							$image_url = cs_attachment_image_src($image_id, 120, 104);
							?>
                                <a href="<?php echo get_permalink();?>" class="thumb">
                                    <img src="<?php echo $image_url ?>" alt="<?php echo get_the_title();?>" />
                                </a>                                                      
					<?php	}
						else {
							echo "<a href='' class='thumb'><img width='60' height='60' src='".get_template_directory_uri()."/images/no_image.jpg' /></a>";
						}
						?>
                        <div class="desc">
							<h4><a href="<?php echo get_permalink()?>"><?php echo substr(get_the_title ( ), 0, 20); if ( strlen(get_the_title ( )) > 20 ) echo "...";?></a></h4>
                            <p class="date">
								<?php echo 'Release: '.$xmlObject->album_release_date;?>
                            </p>
                            <p class="txt">
							<?php
								if ( $post->post_excerpt <> "" ) $get_the_excerpt = $post->post_excerpt;
								else $get_the_excerpt = $post->post_content;
									$get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU','', $get_the_excerpt ));
									echo substr($get_the_excerpt, 0, "40");
									if ( strlen( $get_the_excerpt ) > "40" ) {
										echo '... <br /><a class="buttonsmaller" href="'.get_permalink().'"> Read more</a>';
									}
                            ?>
                            </p>                        
                        </div>
					</li>                 
                    <?php endwhile; ?>
            </ul>
		<?php }else{
			
			echo '<h4>There is no album to show.</h4>';
			}
	echo $after_widget;
		}
		
	}
add_action( 'widgets_init', create_function('', 'return register_widget("otheralbums");') );?>