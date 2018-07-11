<?php get_header(); 

	//showing meta start
	$cs_album = get_post_meta($post->ID, "cs_album", true);
	if ( $cs_album <> "" ) {
		$xmlObject = new SimpleXMLElement($cs_album);
			$cs_layout = $xmlObject->cs_layout;
			$cs_sidebar_left = $xmlObject->cs_sidebar_left;
			$cs_sidebar_right = $xmlObject->cs_sidebar_right;
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
	//showing meta end

?>

		<div id="content-sec">
    	<div class="inner">
	        <div class="<?php echo $cs_layout;?>">
			<?php if($cs_layout <> 'col4'){echo '<div class="col3">';}?>
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <div class="album-detail" id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom:0;">
                <h1 class="heading colr"><?php echo get_the_title();?></h1>
            <?php
                //showing meta start
                $cs_album = get_post_meta($post->ID, "cs_album", true);
                if ( $cs_album <> "" ) {
                    $xmlObject = new SimpleXMLElement($cs_album);
                        //$cs_layout = $xmlObject->page_layout['name'];
                        //$cs_sidebar_left = $xmlObject->page_layout->left;
                        //$cs_sidebar_right = $xmlObject->page_layout->right;
                            $album_release_date = $xmlObject->album_release_date;
                            $album_social_share = $xmlObject->album_social_share;
                            $album_buy_amazon = $xmlObject->album_buy_amazon;
                            $album_buy_apple = $xmlObject->album_buy_apple;
                            $album_buy_groov = $xmlObject->album_buy_groov;
                            $album_buy_cloud = $xmlObject->album_buy_cloud;
                }
                //showing meta end
            
            
            //showing meta end
            ?>
            <?php
            // getting featured image start
				$image_id = get_post_thumbnail_id ( $post->ID );
				if ( $image_id <> "" ) {
					//$image_url = wp_get_attachment_image_src($image_id, array(208,208),true);
					$image_url = cs_attachment_image_src($image_id, 210, 210);
					//$image_url_full = wp_get_attachment_image_src($image_id, 'full',true);
					$image_url_full = cs_attachment_image_src($image_id, 0, 0);
				}
				else {
					$image_url = get_template_directory_uri()."/images/admin/no_image.jpg";
					$image_url_full = get_template_directory_uri()."/images/admin/no_image.jpg";
				}
	//						$image_id = get_post_thumbnail_id ( $post->ID );
	//						$image_url = wp_get_attachment_image_src($image_id, array(208,198),true);
	//						$image_url_full = wp_get_attachment_image_src($image_id, 'full',true);
            // getting featured image end
            ?>
                            <div class="album-detail-sec album-tracks">
                                <div class="thumb <?php if($image_id == "") echo "no-img-found";?>">
                                    <a rel="prettyPhoto" name="<?php the_title(); ?>" href="<?php echo $image_url_full?>" class="thumb" >
                                        <?php echo "<img src='".$image_url."' />";?>
                                    </a>                        
                                </div>
                                <div class="desc">
                                    <p class="release">Release Date: <?php echo date( get_option("date_format") , strtotime($album_release_date) );?></p>
                                    <?php if ( $post->post_content <> "" ) {?>
                                        <p><?php echo $post->post_content;?></p>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <!-- Album List Start -->
                            <?php foreach ( $xmlObject as $track ){
                                if ( $track->getName() == "track" ) {?>
                                <div class="album-track-list">
                                <h2 class="heading colr">Album Tracks</h2>
                                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.jplayer.min.js"></script>
                                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/mod.js"></script>							
                                    <div class="tracklist album-tracks">
                                        <?php 
                                            $counter = 0;
                                            foreach ( $xmlObject as $track ){
                                                $counter++;
                                                if ( $track->getName() == "track" ) {
                                                    $album_track_title = $track->album_track_title;
                                                    echo "<ul>";
                                                        if ($track->album_track_playable == "Yes") {
                                                            echo '
                                                                <li class="play">
                                                                    <div class="cp-container cp_container_'.$counter.'">
                                                                        <ul class="cp-controls">
                                                                            <li><a style="display: block;" href="#" class="cp-play" tabindex="1">&nbsp;</a></li>
                                                                            <li><a href="#" class="cp-pause" style="display: none;" tabindex="1">&nbsp;</a></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div style="width: 0px; height: 0px;" class="cp-jplayer jquery_jplayer_'.$counter.'">
                                                                        <img style="width: 0px; height: 0px; display: none;" id="jp_poster_0">
                                                                        <audio src="'.$track->album_track_mp3_url.'" preload="metadata" ></audio>
                                                                    </div>
                                                                    <script>
                                                                        $(document).ready(function(){
                                                                            var myCirclePlayer = new CirclePlayer(".jquery_jplayer_'.$counter.'",
                                                                                {
                                                                                    mp3: "'.$track->album_track_mp3_url.'"
                                                                                }, {
                                                                                    cssSelectorAncestor: ".cp_container_'.$counter.'",
                                                                                    swfPath: "'.get_template_directory_uri().'/scripts/frontend/Jplayer.swf",
                                                                                    wmode: "window",
                                                                                    supplied: "mp3"
                                                                                });
                                                                        });
                                                                    </script>
                                                                </li>
                                                            ';
                                                        }
                                                        echo '<li class="title"><p><a href="#">'.$album_track_title.'</a></p></li>';
                                                        if ($track->album_track_downloadable == "Yes") echo '<li><a href="'.$track->album_track_mp3_url.'" class="download">&nbsp;<span>Download</span></a>';
                                                        if ($track->album_track_lyrics <> "") echo '<a href="#lyrics'.$counter.'" rel="prettyPhoto" title="'.$album_track_title.'" class="lyrics">&nbsp;<span>Lyrics</span></a></li>';
                                                    echo "</ul>";
                                                    echo '
                                                        <div id="lyrics'.$counter.'" style="display:none;">
                                                            '.$track->album_track_lyrics.'
                                                        </div>';
            
                                                }
                                            } ?>
                                </div>          
                                <?php	} ?>
                          
                                <?php } ?>  
                                <div class="clear"></div>
                                <?php if($album_buy_amazon != '' or $album_buy_apple != '' or $album_buy_groov != '' or $album_buy_cloud != ''){?>
                                <div class="buynow">
                                    <ul>
                                        <li><h4 class="colr">BUY NOW FROM</h4></li>
                                        <?php
                                            if ( $album_buy_amazon <> "" ) echo ' <li><a target="_blank" href="'.$album_buy_amazon.'"><img src="'.get_template_directory_uri().'/images/amazon.png" alt="" /></a></li> ';
                                            if ( $album_buy_apple <> "") echo '<li> <a target="_blank" href="'.$album_buy_apple.'" ><img src="'.get_template_directory_uri().'/images/itune.png" alt="" /></a> </li>';
                                            if ( $album_buy_groov <> "") echo ' <li><a target="_blank" href="'.$album_buy_groov.'" ><img src="'.get_template_directory_uri().'/images/grooveshark.png" alt="" /></a></li> ';
                                            if ( $album_buy_cloud <> "") echo ' <li><a target="_blank" href="'.$album_buy_cloud.'" ><img src="'.get_template_directory_uri().'/images/soundcloud.png" alt="" /></a></li> ';
                                        ?>
                                    </ul>
                                </div>
                             <?php }?>
                            <div class="clear"></div>
                                <?php $cs_social_share = get_option("cs_social_share");							
                                if($cs_social_share != ''){
                                  $xmlObject_album = new SimpleXMLElement($cs_social_share);
                                    if($album_social_share == 'Yes'){
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
                                        <div class="follow-us">
                                            <ul>
                                                <li><h4 class="colr">Share This</h4></li>
                                                <?php if($twitter == 'on'){?><li><a href="http://twitter.com/home?status=<?php the_title();?> - <?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/twitter.png" alt="" /></a><?php }?>
                                                <?php if($facebook == 'on'){?><li><a href="http://www.facebook.com/share.php?u=<?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/facebook.png" alt="" /></a><?php }?>
                                                <?php if($linkedin == 'on'){?><li><a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/linkedin.png" alt="" /></a><?php }?>
                                                <?php if($digg == 'on'){?><li><a href="http://digg.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/digg.png" alt="" /></a><?php }?>												
                                                <?php if($delicious == 'on'){?><li><a href="http://delicious.com/post?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/delicious.png" alt="" /></a><?php }?>
                                                <?php if($google_bookmark == 'on'){?><li><a href="http://www.google.com/bookmarks/mark?op=edit&#038;bkmk=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_bookmark.png" alt="" /></a><?php }?>
                                                <?php if($google_buzz == 'on'){?><li><a href="http://www.google.com/reader/link?title=<?php the_title();?>&url=<?php the_permalink();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_buzz.png" alt="" /></a><?php }?>												
                                                <?php if($google_plus == 'on'){?><li><a href="https://plus.google.com/share?url=<?php the_permalink();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/google_plus.png" alt="" /></a><?php }?>																																																
                                                <?php if($myspace == 'on'){?><li><a href="http://www.myspace.com/Modules/PostTo/Pages/?u=<?php echo $pageurl;?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/myspace.png" alt="" /></a><?php }?>
                                                <?php if($reddit == 'on'){?><li><a href="http://reddit.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/reddit.png" alt="" /></a><?php }?>
                                                <?php if($stumbleupon == 'on'){?><li><a href="http://www.stumbleupon.com/submit?url=<?php echo $pageurl;?>&#038;title=<?php the_title();?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/stumbleupon.png" alt="" /></a><?php }?>
                                                <?php if($rss == 'on'){?><li><a href="#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/admin/rss.png" alt="" /></a><?php }?>												
                                        </ul>
                                    </div>
                                            <?php }?>
                                    <?php }?>                        
                                <?php }?>   
                            </div>
                    <!-- Album List End -->        
					<?php if ( get_the_author_meta( 'description' ) ) :?>
                    <div class="in-sec" style="margin-top:20px;">
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
            <?php comments_template( '', true ); ?>
            </div>                    		
            <?php endwhile; // end of the loop. ?>
			<?php if($cs_layout <> 'col4'){echo '</div>';}?>    
            
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
