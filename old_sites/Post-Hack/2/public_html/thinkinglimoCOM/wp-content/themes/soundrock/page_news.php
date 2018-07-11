<div class="news">
    <h1 class="heading colr">
        <?php echo $cs_news_title_db;?>
    </h1>
    <!-- News List Start -->				
    <ul class="late-news">
	<?php
		if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		$count_post = 0;
		query_posts( array( 'posts_per_page' => '-1', 'post_type' => 'post', 'category_name' => "$cs_news_cat_db" ) );
			while ( have_posts()) : the_post();
				$count_post++;
			endwhile;
			if ( $cs_news_pagination_db == "Single Page" ) $cs_news_num_post_db = -1;
			query_posts( array( 'posts_per_page' => "$cs_news_num_post_db", 'paged' => $_GET['page_id_all'], 'cat' => "$cs_news_cat_db" ) ); 
			$counter = 0;
			while ( have_posts()) : the_post();
				$counter++;
				$image_id = get_post_thumbnail_id ( $post->ID );
				if($counter == 1 && $_GET['page_id_all'] == 1){?>
                    <li class="featured <?php if($image_id == ''){echo 'no-image';}?>">
                        <div class="thumb">
                      <?php $image_id = get_post_thumbnail_id ( $post->ID );
							if($image_id <> ''){?>
                                <a href="<?php echo get_permalink();?>">
	                                <?php $image_url = cs_attachment_image_src($image_id, 680, 274); echo "<img src='".$image_url."' />";?>
                                </a>
                      <?php }?>
                        </div>
                        <div class="desc">
                            <h3><a href="<?php echo get_permalink();?>" class="colr">
							<?php echo substr(get_the_title(), 0, 45); if ( strlen(get_the_title()) > 45 ) echo "..."; ?>
                            </a></h3>
                            <p class="date"><?php echo get_the_date();?></p>
                            <p><?php
                                if ( $post->post_excerpt <> "" ) $get_the_excerpt = $post->post_excerpt;
                                else $get_the_excerpt = $post->post_content;
                                    $get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU','', $get_the_excerpt ));
                                    echo substr($get_the_excerpt, 0, "$cs_news_excerpt_db");
                                    if ( strlen( $get_the_excerpt ) > "$cs_news_excerpt_db" ) {
                                        echo '... <a class="readmore" href="'.get_permalink().'"> Read more</a>';
                                    }
                            ?>
                            </p>
                        </div>
                    </li>		
                <?php }else{?>
					<li class="<?php if($image_id == ''){echo 'no-image';}?>">
                        <div class="thumb">
                            <a href="<?php echo get_permalink();?>">
                            <?php 
							$image_id = get_post_thumbnail_id ( $post->ID );
							if($image_id <> ''){
                                $image_url = cs_attachment_image_src($image_id, 210, 210);
                                echo "<img src='".$image_url."' />";
							}
                            ?>
                            </a>
                        </div>
                        <div class="desc">
                            <h3>
                                <a href="<?php echo get_permalink();?>" class="colr">
	                                <?php echo substr(get_the_title(), 0, 45); if ( strlen(get_the_title()) > 45 ) echo "..."; ?>
                                </a>
                            </h3>
                            <p class="date"><?php echo get_the_date();?></p>
                            <p><?php
                                if ( $post->post_excerpt <> "" ) $get_the_excerpt = $post->post_excerpt;
                                else $get_the_excerpt = $post->post_content;
                                    $get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU','', $get_the_excerpt ));
                                    echo substr($get_the_excerpt, 0, "$cs_news_excerpt_db");
                                    if ( strlen( $get_the_excerpt ) > "$cs_news_excerpt_db" ) {
                                        echo '... <a class="readmore" href="'.get_permalink().'"> Read more</a>';
                                    }
                            ?>
                            </p>
                        </div>
                    </li>
				<?php }?>		
			<?php endwhile;?>
        </ul>
        <!-- News List End -->
<?php
	// pagination start
	$qrystr = '';
	if (cs_pagination($count_post, $cs_news_num_post_db,$qrystr) <> ''){	
		if ( $cs_news_pagination_db == "Show Pagination" and $cs_news_num_post_db > 0 ) {
			echo "<div class='paging'><ul>";
				$qrystr = '';
				if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];		
			echo cs_pagination($count_post, $cs_news_num_post_db,$qrystr);
			echo "</ul></div>";
		}
	}
	// pagination end
?>
</div>