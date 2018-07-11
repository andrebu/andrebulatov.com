<?php
/*
Template Name: Blog 5
*/ 
get_header(); 
?>

<?php while ( have_posts() ) : the_post(); ?>
<?php
$subtitle = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."subtitle", true);
$hide_title = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."hide_title", true); 
$centered_title = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."centered_title", true);
$select_blog_category = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."select_blog_category", true); 
$sidebar = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."select_sidebar", true); 


if ($hide_title != "yes")
{
?>
    <div class="section-title">
    
        <h1 class="title"><?php the_title(); if ($subtitle != "") { ?> <span><?php echo $subtitle; ?></span><?php } ?></h1>
                        
    </div><!--END SECTION TITLE-->
<?php
}
?>  

<?php
if ($centered_title != "")
{
?>
    <div class="section-title text-align-center">
    
        <h1 class="title"><?php echo $centered_title; ?></h1>
<?php if ($subtitle != "") { ?> <p><?php echo $subtitle; ?></p><?php } ?>
                        
    </div><!--END SECTION TITLE-->
<?php
}
?> 
    <div id="inner-content" class="blog5"> 
    <?php
    the_content();
    ?>
<?php
    $args=array(
    'cat' => $select_blog_category,
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $paged
    );
    $temp = $wp_query;
    $wp_query = new WP_Query( $args );

// The Loop
while ( $wp_query->have_posts() ) : $wp_query->the_post();
$featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' ); 
$featured_image = $featured_image_array[0];
?>

            <div class="post">
            
                <div class="post-title">                
                    <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </div><!--END POST-TITLE-->
                
                <div class="post-meta">                
                    <ul>
                        <li><span><?php _e('Posted by', BRANKIC_THEME_SHORT); ?></span> <?php the_author_link(); ?></li>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_cats_blog_page") == "yes") { ?><li><span><?php _e('in', BRANKIC_THEME_SHORT); ?></span> <?php the_category(', '); ?></li><?php } ?>
<?php if (get_option(BRANKIC_VAR_PREFIX."show_tags_blog_page") == "yes") { ?><li><span><?php _e(' Tagged with', BRANKIC_THEME_SHORT); ?></span> <?php the_tags('', ', ', ''); ?></li><?php } ?>
                    </ul>
                </div><!--END POST-META-->
                
                <div class="post-media">
                <?php
                    $video_link = get_post_meta(get_the_ID(), BRANKIC_VAR_PREFIX."video_link", true);

                    if ($video_link != "")
                    {
                        if (bra_is_mov($video_link) || bra_is_swf($video_link))
                        {
                        ?>
                        <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php
                        }
                        if (bra_is_vimeo($video_link) || bra_is_youtube($video_link))
                        {
                            if (bra_is_vimeo($video_link))
                            {
                                $video_link = "http://player.vimeo.com/video/" . bra_get_vimeo_id($video_link);
                            }
                            if (bra_is_youtube($video_link))
                            {
                                $video_link = "http://www.youtube.com/embed/" . bra_get_youtube_id($video_link);
                            }
                            ?>
                            <iframe src="<?php echo $video_link; ?>" width="100%" height="400" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            <?php
                        }
                    }
                    else
                    {
                    ?>
                        <?php if (extra_images_exists()) { include ("slider.inc.php"); } else { ?>         
                        <a href="<?php the_permalink(); ?>"><img src="<?php echo $featured_image; ?>" alt="" width="700" /></a>
                        <?php } ?>
                    <?php } ?> 
                </div><!--END POST-MEDIA-->
            
                <div class="post-info">                        
                    <div class="date"><span class="month"><?php the_time('M'); ?></span><span class="day"><?php the_time('d'); ?></span><span class="month"><?php the_time('Y'); ?></span></div>                    
                    <div class="comments"><?php comments_popup_link('<span>0</span> Comments', '<span>1</span> Comment', '<span>%</span> Comments'); ?></div>                            
                </div><!--END POST-INFO-->        
                
                <div class="post-content">    
                        
<?php
the_excerpt();
?>
<p><a href="<?php the_permalink(); ?>" class="more-link"><?php _e('Continue reading &rarr;', BRANKIC_THEME_SHORT); ?></a></p>
                </div><!--END POST-CONTENT -->
                
            </div><!--END POST-->
<?php
endwhile;
if(function_exists('wp_pagenavi_bra')) { wp_pagenavi_bra(); }  
?>  
        
        </div><!--END INNER-CONTENT-->
<?php 

get_sidebar(); 

$wp_query = $temp;  //reset back to original query
?>

<?php endwhile; // end of the loop. ?> 		
<?php get_footer(); ?>
			