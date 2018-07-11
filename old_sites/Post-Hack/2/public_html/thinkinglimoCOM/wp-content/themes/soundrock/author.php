<?php get_header(); ?>
<?php if ( have_posts() )	the_post(); ?>
		<?php 
		global $post_id;
		        $cs_default_pages = get_option("cs_default_pages");
                if ( $cs_default_pages <> "" ) {
                    $xmlObject = new SimpleXMLElement($cs_default_pages);
                        $cs_layout = $xmlObject->cs_layout;
                        $cs_sidebar_left = $xmlObject->cs_sidebar_left;
                        $cs_sidebar_right = $xmlObject->cs_sidebar_right;
                        $cs_pagination = $xmlObject->cs_pagination;
                        $record_per_page = $xmlObject->record_per_page;
						if($cs_pagination == 'Single Page'){$record_per_page = '-1';}						
                }
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
			<?php if($cs_layout == 'columns-sec twocol'){echo '<div class="col3">';}else if($cs_layout == 'columns-sec twocol left_sidebar'){echo '<div class="col3">';}?>
				<div class="blog">
					<?php if ( get_the_author_meta( 'description' ) ) :?>
						<div class="in-sec" style="margin-bottom:20px;">
                            <div class="about-author">
                                <div class="avatars">
                                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'PixFill_author_bio_avatar_size', 53 ) ); ?>
                                </div>
                                <div class="desc">
                                    <h5><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">About <?php echo get_the_author(); ?></a></h5>
                                    <p class="txt">
                                        <?php the_author_meta( 'description' ); ?>
                                    </p>
                                    <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>                            
					<?php endif; ?>			
					<h1 class="heading colr"><?php echo get_the_author()?> Posts</h1>					
					<?php
						if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
							if ( $cs_pagination == "Single Page" ) $cs_pagination = -1;
							if(!isset($_GET["author"])){$_GET["author"] = '';}							
							$newpost = 'posts_per_page=-1&author='.$_GET["author"].'&post_type=post';
							$newquery_dd = new WP_Query($newpost);
								$count_post = 0;
									while ( $newquery_dd->have_posts() ) : $newquery_dd->the_post(); 
											$count_post++;						
									endwhile;
	
							$new = 'posts_per_page='.$record_per_page.'&author='.$_GET["author"].'&paged='.$_GET["page_id_all"].'';
								$newquery = new WP_Query($new);
									while ( $newquery->have_posts() ) : $newquery->the_post();?>
                   <!-- Post Start -->
                        <div class="post no_image_found">
                            <div class="desc">
                            	<div class="date">
                                	<h1><?php echo date("d", strtotime(get_the_date()));?></h1>
                                	<h1><?php echo date("M", strtotime(get_the_date()));?></h1>                                    
                                </div>
                                <div class="desc-sec">
                                        <h3><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h3>
                                        <div class="post-opts">
                                            <p>by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author();?></a></p>
                                            <p><?php echo get_the_time('F jS, Y');?></p>
                                            <p><a href="<?php echo get_permalink();?>#comments"><?php echo get_comments_number($post->ID);?> Comments</a></p>
                                            <p>
                                                <?php $counterr = 0;
                                                        foreach(get_the_category($post->ID) as $values){
                                                            if($counterr == 0){ echo 'Category:  ';}
                                                            $counterr++;
                                                            echo '<a href="'.get_category_link($values->term_id).'">'.$values->name.'</a>  ';}?> 
                                            </p>
                                            <p>
                                            <?php
                                            $tag_post = wp_get_post_tags( $post->ID );									
                                            $counterr = 0;
                                            foreach($tag_post as $values){
                                                if($counterr == 0){ echo 'Tag:  ';}
                                                $counterr++;
                                                echo '<a href="'.get_term_link($values->slug,$values->taxonomy).'">'.$values->name.'</a>  ';											
                                                }										
                                            ?> 
                                            </p>                                            
                                        </div>
                                        <p>
                                            <?php the_excerpt();?>
                                        </p>
                                        <a href="<?php echo get_permalink();?>" class="readmore">Continue Reading</a>
                                </div>
                            </div>
                        </div>
                        <!-- Post End -->
					<?php endwhile;	?>
                    <?php
					// pagination start					
						$qrystr = '';
						if (cs_pagination($count_post, $record_per_page,$qrystr)){					
							if ( $cs_pagination == "Show Pagination" and $record_per_page > 0 ) {
								echo "<div class='paging'><ul>";
									$qrystr = '';
									if ( isset($_GET['author']) ) $qrystr = "&author=".$_GET['author'];
								echo cs_pagination($count_post, $record_per_page,$qrystr);
								echo "</ul></div>";
							}							
						}
					// pagination end						
					?>
		</div>                    
			<?php if($cs_layout <> 'col4'){echo '</div>';}?>    

            
     <?php if($cs_layout != "col4"){?>
        <!--Sidebar Start-->
            <div class="col1 hidemobile">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) : ?>
                <?php endif; ?>   
            </div>            
        <!--Sidebar Ends-->  
        <?php }?>
                  
			</div>
           
<?php get_footer(); ?>