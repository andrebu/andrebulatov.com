<?php get_header();
global $post,$post_id; 
$post_xml = get_post_meta($post->ID, "post", true);
	if ( $post_xml <> "" ) {
		$xmlObject = new SimpleXMLElement($post_xml);
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
	}
	if(!isset($cs_layout)){$cs_layout = 'col4';}?>
    <!-- Banner End -->
	<div id="content-sec">
    	<div class="inner">
	        <div class="<?php echo $cs_layout;?>">
		<?php if($cs_layout <> 'col4'){echo '<div class="col3">';}
				if ( have_posts() ) while ( have_posts() ) : the_post();?>
				<div class="blog">
                        <!-- Post Detail Start -->
                        <h1 class="heading colr"><?php echo get_the_title();?></h1>
                        <div class="post-detail">
						<?php $image_id = get_post_thumbnail_id ( $post->ID );
								if($image_id <> ''){ $image_url = cs_attachment_image_src($image_id, 680, 274);?>
                                <div class="thumb">
                                    <a href="<?php echo get_permalink();?>"><img src="<?php echo $image_url;?>" alt="" /></a>
                                </div>
                            <?php }?>
                            <div class="desc">
                                <div class="post-opts">
                                    <p>by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author();?></a></p>
                                    <p><?php echo get_the_time(get_option('time_format'));?> -- <?php echo date(get_option('date_format'), strtotime(get_the_date()));?></p>
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
                                	<?php echo get_the_content();?>
		                            <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'PixFill' ), 'after' => '</div>' ) ); ?>
                                </p>
                                <div class="post-share">
										<?php 
                                        $post_social_sharing = '';
                                        $post_xml = get_post_meta($post->ID, "post", true);
                                        if ( $post_xml <> "" ) {
                                            $xmlObject = new SimpleXMLElement($post_xml);
                                                $post_social_sharing = $xmlObject->post_social_sharing;
                                        }
                                        if ( $post_social_sharing == "on" ) {
                                            $cs_social_share = get_option("cs_social_share");
                                              $xmlObject_album = new SimpleXMLElement($cs_social_share);
                                                    $twitter = $xmlObject_album->twitter;
                                                    $facebook = $xmlObject_album->facebook;
                                                    $linkedin = $xmlObject_album->linkedin;
                                                    $digg = $xmlObject_album->digg;
                                                    $delicious = $xmlObject_album->delicious;
                                                    $google_plus = $xmlObject_album->google_plus;
                                                    $google_buzz = $xmlObject_album->google_buzz;
                                                    $google_bookmark = $xmlObject_album->google_bookmark;
                                                    $myspace = $xmlObject_album->myspace;
                                                    $reddit = $xmlObject_album->reddit;
                                                    $stumbleupon = $xmlObject_album->stumbleupon;
                                                    $yahoo_buzz = $xmlObject_album->yahoo_buzz;
                                                    $rss = $xmlObject_album->rss;
                                                        if($twitter == 'on' or $facebook == 'on' or $linkedin == 'on' or $digg == 'on' or $delicious == 'on' or $google_plus == 'on' or $google_buzz == 'on' or $google_bookmark == 'on' or $myspace == 'on' or $reddit == 'on' or $stumbleupon == 'on' or $yahoo_buzz == 'on' or $rss == 'on'){
                                                            $pageurl = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>
                                                            <ul>
                                                            <?php if($twitter == 'on'){?><li><a href="http://twitter.com/home?status=<?php the_title();?> - <?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/twitter.png" alt="" /></a></li><?php }?>
                                                            <?php if($facebook == 'on'){?><li><a href="http://www.facebook.com/share.php?u=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/facebook.png" alt="" /></a></li><?php }?>
                                                            <?php if($linkedin == 'on'){?><li><a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/linkedin.png" alt="" /></a></li><?php }?>
                                                            <?php if($digg == 'on'){?><li><a href="http://digg.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/digg.png" alt="" /></a></li><?php }?>												
                                                            <?php if($delicious == 'on'){?><li><a href="http://delicious.com/post?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/delicious.png" alt="" /></a></li><?php }?>
                                                            <?php if($google_bookmark == 'on'){?><li><a href="http://www.google.com/bookmarks/mark?op=edit&#038;bkmk=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_bookmark.png" alt="" /></a></li><?php }?>
                                                            <?php if($google_buzz == 'on'){?><li><a href="http://www.google.com/reader/link?title=<?php the_title();?>&url=<?php the_permalink();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_buzz.png" alt="" /></a></li><?php }?>												
                                                            <?php if($google_plus == 'on'){?><li><a href="https://plus.google.com/share?url=<?php the_permalink();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_plus.png" alt="" /></a></li><?php }?>																																																
                                                            <?php if($myspace == 'on'){?><li><a href="http://www.myspace.com/Modules/PostTo/Pages/?u=<?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/myspace.png" alt="" /></a></li><?php }?>
                                                            <?php if($reddit == 'on'){?><li><a href="http://reddit.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/reddit.png" alt="" /></a></li><?php }?>
                                                            <?php if($stumbleupon == 'on'){?><li><a href="http://www.stumbleupon.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/stumbleupon.png" alt="" /></a></li><?php }?>
                                                            <?php if($yahoo_buzz == 'on'){?><li><a href="#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/yahoo_buzz.png" alt="" /></a><?php }?>                                                                                                                                
                                                            <?php if($rss == 'on'){?><li><a href="#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/rss.png" alt="" /></a></li><?php }?>												
					                                        <li class="right"><a href="#" class="print">Print</a></li>                                                            
                                                            </ul>
                                                        <?php }?>
                                            <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <!-- Post Detail End -->
							<?php if ( get_the_author_meta( 'description' ) ) :?>						
                                <div class="about-author">
                                    <div class="about-inner">
                                        <div class="avatar">
                                            <a href="#"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'PixFill_author_bio_avatar_size', 53 ) ); ?></a>
                                        </div>
                                        <div class="desc">
                                            <h4><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">About <?php echo get_the_author(); ?></a></h4>
                                            <span class="by">Admin</span>
                                            <div class="clear"></div>
                                            <p class="txt">
                                                <?php the_author_meta( 'description' ); ?>
                                            </p>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>      
                                <?php endif; ?>	                  
                            <div class="clear"></div>       
					    </div>        
			<?php comments_template( '', true ); ?> 
		<?php endwhile; // end of the loop. ?>
		<?php if($cs_layout <> 'col4'){echo '</div>';}?>    
         <!-- two-thirds end -->
            <?php if($cs_layout != "col4"){?>
            <!--Sidebar Start-->
                <div class="col1 hidemobile">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($show_sidebar) ) : ?>
                    <?php endif; ?>   
                </div>
            <?php }?>
        </div><!-- #container -->  
        <div class="clear"></div>

<?php get_footer(); ?>
<div class="clear"></div>
