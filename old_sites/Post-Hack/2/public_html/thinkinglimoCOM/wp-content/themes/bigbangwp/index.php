<?php get_header(); ?>
<?php
$paged = (get_query_var("paged")) ? get_query_var("paged") : 1;
                
if (is_month()) 
{
    $title = __("Monthly archive", BRANKIC_THEME_SHORT);
    $subtitle = __("for ", BRANKIC_THEME_SHORT) . single_month_title('', false);
    if ($paged > 1) $subtitle .= " - " . __("page", BRANKIC_THEME_SHORT) . " " . $paged;
}

if (is_tag()) 
{
    $title = __("Tag archive", BRANKIC_THEME_SHORT);
    $subtitle = __("for ", BRANKIC_THEME_SHORT) . single_tag_title('', false);
    if ($paged > 1) $subtitle .= " - " . __("page", BRANKIC_THEME_SHORT) . " " . $paged;
}
if (is_search()) 
{
    $title = __("Search results", BRANKIC_THEME_SHORT);
    $subtitle = __("for ", BRANKIC_THEME_SHORT) . $_GET["s"];
    if ($paged > 1) $subtitle .= " - " . __("page", BRANKIC_THEME_SHORT) . " " . $paged;
}
if (is_category()) 
{
    $title = __("Archive", BRANKIC_THEME_SHORT);
    $subtitle = __("for ", BRANKIC_THEME_SHORT) . single_cat_title('', false);
    if ($paged > 1) $subtitle .= " - " . __("page", BRANKIC_THEME_SHORT) . " " . $paged;
}
if (is_home()) 
{
    $title = get_option('blogname');
    $subtitle = get_option('blogdescription');
    if ($paged > 1) $subtitle .= " - " . __("page", BRANKIC_THEME_SHORT) . " " . $paged;
}
?>
    <div class="section-title">
    
        <h1 class="title"><?php echo $title; ?> <span><?php echo $subtitle; ?></span></h1>
                        
    </div><!--END SECTION TITLE-->
    <div id="inner-content" class="blog1"> 
<?php if(have_posts()) : while ( have_posts() ) : the_post(); 

$featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' ); 
$featured_image = $featured_image_array[0];
?>

            <div class="post">
            
                <div class="post-info">                        
                    <div class="date"><span class="month"><?php the_time('M'); ?></span><span class="day"><?php the_time('d'); ?></span><span class="month"><?php the_time('Y'); ?></span></div>                    
                    <div class="comments"><?php comments_popup_link('<span>0</span> Comments', '<span>1</span> Comment', '<span>%</span> Comments'); ?></div>                            
                </div><!--END POST-INFO-->        
                
                <div class="post-content">    
            
                    <div class="post-media">        
                        <a href="<?php the_permalink(); ?>"><img src="<?php echo $featured_image; ?>" alt="" width="600" /></a>
                    </div><!--END POST-MEDIA-->
                
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
<?php
the_excerpt();
?>
<p><a href="<?php the_permalink(); ?>" class="more-link"><?php _e('Continue reading &rarr;', BRANKIC_THEME_SHORT); ?></a></p>
                </div><!--END POST-CONTENT -->
                
            </div><!--END POST-->



<?php endwhile; // End the loop. Whew. ?>

<?php else: //If no posts are present ?>
    
                <div class="entry">                        
                    <p><?php _e('No posts were found.', BRANKIC_THEME_SHORT); ?></p>    
                </div>
                
<?php endif; ?>

<?php
if(function_exists('wp_pagenavi_bra')) { wp_pagenavi_bra(); }  
?>   
        </div><!--END INNER-CONTENT-->  
<?php
get_sidebar();
?> 
			
<?php get_footer(); ?>
			