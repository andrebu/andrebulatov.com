<?php get_header(); ?>

<?php
wp_reset_query();
if(is_front_page() || is_home()){}else{
	if ( has_post_thumbnail()) {?>
        <div id="sub-banner">
            <div class="in">
				<?php
                // getting featured image start
                    $image_id = get_post_thumbnail_id ( $post->ID );
					if($image_id <> ''){
						$image_url = cs_attachment_image_src($image_id, 960, 210);
						echo "<img src='".$image_url."' />";
					}
                // getting featured image end
                ?>
        	</div> 
		</div> 
<?php
	} // endif condition of banner

$cs_page_builder = get_post_meta($post->ID, "cs_page_builder", true);
	if($cs_page_builder == ''){
		// Sample page
		if(is_page(2) or is_page('sample-page') or is_page('Sample Page') ){?>
	<div id="content-sec">
    	<div class="inner"> 
    	<div class="col4">         
				<?php 	
				wp_reset_query();
				if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div class="blog"><div id="post-<?php the_ID(); ?>" <?php post_class(); ?>">
					<?php if ( is_front_page() ) { ?>
						<h1 class="heading colr"><?php the_title(); ?></h1>
					<?php } else { ?>
						<h1 class="heading colr"><?php the_title(); ?></h1>
					<?php } ?>

					<div class="desc">
						<div class="desc-sec">
						<p>
							<?php echo get_the_content(); ?>
                         </p>   
						</div>
					</div>
				<?php 
                	if(!is_page()){ 
                        comments_template( '', true ); 
                    }?>
			<?php endwhile; // end of the loop. ?>
				</div>
				</div>                
			</div>
		<?php
		}
		// Sample Page End		
				
	}else{
	$xmlObject = new SimpleXMLElement($cs_page_builder);
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

?>
	<div id="content-sec">
    	<div class="inner">
        <div class="<?php echo $cs_layout;?>">
        	<?php if($cs_layout <> 'col4'){echo '<div class="col3">';}?>
<?php
				$counter_gal = 0;
					foreach ( $xmlObject->children() as $node ){
						if ( $node->getName() == "rich_editor" ) {
							wp_reset_query();
							//get_template_part( 'loop', 'page' );
								if ( $node->cs_rich_editor_title == "Yes") echo '<h1 class="heading colr">'.get_the_title().'</h1>';
								if ( $node->cs_rich_editor_desc == "Yes") {
									$content_of_post = get_post($post->ID);
									$content = $content_of_post->post_content;
									$content = apply_filters('the_content', $content);
									//$content = str_replace(']]>', ']]>', $content);
									echo '<div class="static"><div class="desc"><div class="desc-sec">'.$content.'</div></div></div>';
								}
						}
						if ( $node->getName() == "gallery" ) {
							$counter_gal++;
							$cs_gal_layout_db = $node->layout;
							$cs_gal_album_db = $node->album;
							$cs_gal_title_db = $node->title;
							$cs_gal_desc_db = $node->desc;
							$cs_gal_pagination_db = $node->pagination;
							$cs_gal_media_per_page_db = $node->media_per_page;
								include("page_gallery.php");
						}
						else if ( $node->getName() == "slider" ) {
							$counter_gal++;
							include("page_slider.php");
						}
						else if ( $node->getName() == "event" ) {
							$counter_gal++;
							include("page_event.php");
							//get_template_part( 'page', 'event' );
						}
						else if ( $node->getName() == "blog" ) {
							$counter_gal++;
								$cs_blog_title_db = $node->cs_blog_title;
								$cs_blog_cat_db = $node->cs_blog_cat;
								$cs_blog_excerpt_db = $node->cs_blog_excerpt;
								$cs_blog_num_post_db = $node->cs_blog_num_post;
								$cs_blog_pagination_db = $node->cs_blog_pagination;
								include("page_blog.php");
						}
						else if ( $node->getName() == "contact" ) {
							$counter_gal++;
								$cs_contact_email_db = $node->cs_contact_email;
								$cs_contact_succ_msg_db = $node->cs_contact_succ_msg;
								$cs_contact_map_db = $node->cs_contact_map;
								include("page_contact.php");
						}
						else if ( $node->getName() == "news" ) {
							$counter_gal++;
								$cs_news_title_db = $node->cs_news_title;
								$cs_news_cat_db = $node->cs_news_cat;
								$cs_news_excerpt_db = $node->cs_news_excerpt;
								$cs_news_num_post_db = $node->cs_news_num_post;
								$cs_news_pagination_db = $node->cs_news_pagination;
								include("page_news.php");
						}
						else if ( $node->getName() == "album" ) {
							$counter_gal++;
								$cs_album_layout_db = $node->cs_album_layout;
								$cs_album_cat_db = $node->cs_album_cat;
								$cs_album_cat_show_db = $node->cs_album_cat_show;
								$cs_album_filterable_db = $node->cs_album_filterable;
								$cs_album_title_db = $node->cs_album_title;
								$cs_album_buynow_db = $node->cs_album_buynow;
								$cs_album_pagination_db = $node->cs_album_pagination;
								$cs_album_per_page_db = $node->cs_album_per_page;
								include("page_album.php");
						}						
					}
				
?>
<?php if($cs_layout <> 'col4'){echo '</div>';}?>    

    <!-- two-thirds end -->
    <?php if($cs_layout != "col4"){?>
    <!--Sidebar Start-->
        <div class="col1 hidemobile">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) : ?>
			<?php endif; ?>   
        </div>
	<?php }?>

    <!--Sidebar Ends-->    
	<div class="clear"></div>
</div><!-- Page End -->
<?php }?>
<div class="clear"></div>
<div style="display:none">
<?php 
	if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
	  the_post_thumbnail();
	} 
?>
	<?php posts_nav_link(); ?>
    <?php paginate_links(); ?>
    <?php next_posts_link(); ?>
    <?php previous_posts_link(); ?>
</div>
<?php }?>    
<?php get_footer(); ?>
<?php //get_sidebar(); ?>