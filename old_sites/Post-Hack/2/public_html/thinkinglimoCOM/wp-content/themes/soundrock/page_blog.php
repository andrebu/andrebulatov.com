<h1 class="heading colr">
    <?php 
	global $post_id;
    //$row = $wpdb->get_row("SELECT name from ".$wpdb->prefix."terms WHERE term_id = " . $cs_blog_cat_db );
    //echo $row->name; 
	echo $cs_blog_title_db;
    ?>
</h1>
	<?php
		if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		$count_post = 0;
		query_posts( array( 'posts_per_page' => '-1', 'post_type' => 'post', 'category_name' => "$cs_blog_cat_db" ) );
			while ( have_posts()) : the_post();
				$count_post++;
			endwhile;
			if ( $cs_blog_pagination_db == "Single Page" ) $cs_blog_num_post_db = -1;

		query_posts( array( 'posts_per_page' => "$cs_blog_num_post_db", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_blog_cat_db" ) ); 
			$counter = 0;
			while ( have_posts()) : the_post();
				$image_id = get_post_thumbnail_id ( $post->ID );?>
					<div class="post <?php if($image_id == ''){echo 'no-image';}?>">
							<?php if($image_id != ''){?>
                                    <div class="thumb-sec">
                                        <?php
                                        // getting featured image start
											$image_url = cs_attachment_image_src($image_id, 680, 274);
                                            echo "<a href='".get_permalink()."' class='thumb'><img src='".$image_url."' /></a>";
                                        // getting featured image end?>
                                    </div>
                                    
                                <?php }?>
							<div class="desc">
                            	<div class="date">
                                	<h1><?php echo date("d", strtotime(get_the_date()));?></h1>
                                	<h1><?php echo date("M", strtotime(get_the_date()));?></h1>                                    
                                </div>
                                <div class="desc-sec">
                                	<h3><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h3>
                                    <div class="post-opts">
                                    	<p>by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author();?></a></p>
                                        <p><?php echo get_the_date(get_option('date_format'));?></p>
                                        <p><a href="<?php echo get_permalink();?>#comments"><?php echo get_comments_number($post_id);?> Comments</a></p>
                                    </div>
                                    <p>
                                    	<?php
											//echo get_the_excerpt()."<br /><br />";
											$get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU','', get_the_excerpt()));
											echo substr($get_the_excerpt, 0, "$cs_blog_excerpt_db");
											if ( strlen( $get_the_excerpt ) > "$cs_blog_excerpt_db" ) {
												echo '... <a class="read-cont" href="'.get_permalink().'"> Continue Reading</a>';
											}
                                        ?>
                                    </p>
                                </div>
                            </div>  
                          </div>             
						<?php
				endwhile;
				$qrystr = '';
				if (cs_pagination($count_post, $cs_blog_num_post_db,$qrystr) <> ''){
					// pagination start
					if ( $cs_blog_pagination_db == "Show Pagination" and $cs_blog_num_post_db > 0 ) {
						echo "<div class='paging'><ul>";						
							if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
						echo cs_pagination($count_post, $cs_blog_num_post_db,$qrystr);
						echo "</ul></div>";
					}
				// pagination end
				}


        ?>

