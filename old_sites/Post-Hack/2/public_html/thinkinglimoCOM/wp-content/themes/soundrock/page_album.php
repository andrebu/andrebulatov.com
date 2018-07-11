<div class="clear"></div>
<div id='album-shelves'>

	<?php 
    $row = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_album_cat_db ."'" );
    //if(isset($row->name)){echo $row->name;} 
    ?>

<?php
if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
$count_post = 0;
query_posts( array( 'posts_per_page' => '-1', 'post_type' => 'albums', 'album-category' => "$row->name" ) ); 
	while ( have_posts()) : the_post();
		$count_post++;
	endwhile;
	if ( $cs_album_pagination_db == "Single Page" or $cs_album_filterable_db == "On" ) $cs_album_per_page_db = -1;
	if($cs_album_filterable_db == "On"){?>	

<script src="<?php echo get_template_directory_uri();?>/scripts/frontend/jquery-filterable.js" type="text/javascript"></script>
<script>
jQuery(window).load(function() {
	var filter_container = jQuery('#portfolio-item-holder<?php echo $counter_gal?>');

	filter_container.children().css('position','absolute');	
	filter_container.masonry({
		singleMode: true,
		itemSelector: '.portfolio-item:not(.hide)',
		animate: true,
		animationOptions:{ duration: 800, queue: false }
	});	
	jQuery(window).resize(function(){
		var temp_width =  filter_container.children().filter(':first').width() + 20;
		filter_container.masonry({
			columnWidth: temp_width,
			singleMode: true,
			itemSelector: '.portfolio-item:not(.hide)',
			animate: true,
			animationOptions:{ duration: 800, queue: false }
		});		
	});	
	jQuery('ul#portfolio-item-filter<?php echo $counter_gal?> a').click(function(e){	

		jQuery(this).addClass("active");
		jQuery(this).parents("li").siblings().children("a").removeClass("active");
		e.preventDefault();
		
		var select_filter = jQuery(this).attr('data-value');
		
		if( select_filter == "All" || jQuery(this).parent().index() == 0 ){		
			filter_container.children().each(function(){
				if( jQuery(this).hasClass('hide') ){
					//jQuery(this).removeClass('hide').animate({opacity:1});
					jQuery(this).removeClass('hide');
					jQuery(this).fadeIn();
				}
			});
		}else{
			filter_container.children().not('.' + select_filter).each(function(){
				if( !jQuery(this).hasClass('hide') ){
					//jQuery(this).addClass('hide').animate({opacity:0});
					jQuery(this).addClass('hide');
					jQuery(this).fadeOut();
				}
			});
			filter_container.children('.' + select_filter).each(function(){
				if( jQuery(this).hasClass('hide') ){
					//jQuery(this).removeClass('hide').animate({opacity:1});
					jQuery(this).removeClass('hide');
					jQuery(this).fadeIn();
				}
			});
		}
		
		filter_container.masonry();	
		
	});
});
</script>
                    <div class="gallery-head">
                       <h1 class="colr"><?php if(isset($row->name)){echo $row->name;} ?> </h1>
						<ul id="portfolio-item-filter<?php echo $counter_gal?>" class="filter-nav">
                            <li><a data-value="all" class="gdl-button active" href="#">all</a></li>
							<?php
                             $categories = get_categories( array('child_of' => $row->term_id, 'taxonomy' => 'album-category', 'hide_empty' => 0) );
                                if($categories <> ""){
                                    foreach ( $categories as $category ) {
                                ?>
							<li><a data-value="<?php echo $category->term_id;?>" class="gdl-button" href="#"><?php echo $category->name;?></a></li>                                
								<?php }?>
                            <?php }?>                            
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
				<?php }else{?>
                	<h1 class="heading colr"><?php if(isset($row->name)){echo $row->name;} ?> </h1>
                <?php } //End Condition of Filterable ?>                    
                    <!-- Gallery Four Column Start -->
						<ul class="album-list prod-list portfolio-item-holder" id="portfolio-item-holder<?php echo $counter_gal?>">
							<?php if($row <> ''){
								query_posts( array( 'posts_per_page' => "$cs_album_per_page_db", 'paged' => $_GET['page_id_all'], 'post_type' => 'albums', 'album-category' => "$row->name" ) ); 
								}else{
									query_posts( array( 'posts_per_page' => "$cs_album_per_page_db", 'paged' => $_GET['page_id_all'], 'post_type' => 'albums',) ); 
									}
								//print_r($wpdb->last_query );
								//print_r($wpdb->num_rows );
								
									$counter_album_db = 0;
									while ( have_posts()) : the_post();
										$counter_album_db++;
							?>                        
							<li class="all portfolio-item 
							<?php
							$categories = get_the_terms( $post->ID, 'album-category' );
								if($categories <> ''){
									foreach ( $categories as $category ) {
										echo $category->term_id." ";
									}
								}
							?>">
								<a href="<?php echo get_permalink();?>" class="thumb">                                         
									<?php
                                        $image_id = get_post_thumbnail_id ( $post->ID );
										if ( $image_id <> "" ) {
											//$image_url = wp_get_attachment_image_src($image_id, array(208,208),true);
											$image_url = cs_attachment_image_src($image_id, 210, 210);
											echo "<img src='".$image_url."' />";
										}
										else {
											echo "<img src='".get_template_directory_uri()."/images/no_image.jpg' />";
										}
                                    ?>	
                                </a>
                                <div class="clear"></div>
                                <h3>
                                	<a class="colr" href="<?php echo get_permalink();?>">
                                        <?php 
										echo substr($post->post_title, 0, 20);
                                        if ( strlen($post->post_title) > 20 ) echo "...";
										?>
                                    </a>
                                </h3>	
                                <p>
                                <?php
								if ( $post->post_excerpt <> "" ) $get_the_excerpt = $post->post_excerpt;
								else $get_the_excerpt = $post->post_content;
									$get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU','', $get_the_excerpt ));
									echo substr($get_the_excerpt, 0, "90");
									if ( strlen( $get_the_excerpt ) > "90" ) {
										echo '... <a href="'.get_permalink().'"> Read more</a>';
									}
                            		?>
                                </p>
			                    <a href="<?php echo get_permalink();?>" class="bigbutton">VIEW DETAIL</a>                                									                                
                            </li>
                            <?php endwhile;?>
						</ul>                       
					<div class="clear"></div>              
                <?php
					$qrystr = '';
    				if (cs_pagination($count_post, $cs_album_per_page_db,$qrystr) <> ''){
					// pagination start
						if ( $cs_album_pagination_db == "Show Pagination" and $cs_album_per_page_db > 0 and $cs_album_filterable_db == "Off" ) {
							echo "<div class='paging'><ul>";
								$qrystr = '';
								if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
							echo cs_pagination($count_post, $cs_album_per_page_db,$qrystr);
							echo "</ul></div>";
						}
					}
					// pagination end
                        ?>
</div>						