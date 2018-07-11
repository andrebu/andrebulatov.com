<?php

get_header();
?>

<?php
if (is_home()) :

// check if search page should be shown
if (strpos($_SERVER['REQUEST_URI'],'?s=') !== false) : ?>
 
  <div id="banner"  style="background:#fff;"></div>   
      <div class="bg-projects">
          <!-- The container is a centered 960px -->
          <div class="container" style="background:#fff; ">
              <!-- Give column value in word form (one, two..., twelve) -->
              <div class="blog_header">
                  <div class="service-title fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/lamp.png" class="service-img" alt="designicon"><?php _e( 'Search throughout the website', 'flatbox' ); ?></div>
              </div>
              <!-- Sweet nested columns cleared with a clearfix class -->
              <div class="sixteen columns clearfix">
                  <!-- In nested columns give the first column a class of alpha
                  and the second a class of omega -->
                  <div class="four columns alpha" style="background:#fff;color:#fff;">
                      <p></p>
                  </div>
                 <div class="nine columns omega" style="background:#fff;color:#fff;">
                    <?php get_search_form(); ?>
                  </div>
              </div>
          </div>
      </div>
  </div>

 <div id="banner"  style="background:#fff;"></div>   

<?php

endif; // check if empty search page visible
else: //is_home()

  // general category, tag, date, author and search listing
  $title = __( 'Results', 'flatbox' );
  if (is_search()) $title = sprintf( __( 'Search results for &#8216;%s&#8217;', 'flatbox' ), esc_attr( get_search_query() ) );
  elseif( is_category() ) $title = sprintf( __( 'Archive for the &#8216;%s&#8217; Category', 'flatbox' ), single_cat_title( '', FALSE ) );
  elseif( is_tag() ) $title = sprintf( __( 'Posts tagged &#8216;%s&#8217;', 'flatbox' ), single_tag_title( '', FALSE ) );
  elseif( is_day() ) $title = sprintf( __( 'Archive for %s', 'flatbox' ), get_the_time('F jS, Y') );
  elseif( is_month() ) $title = sprintf( __( 'Archive for %s', 'flatbox' ), get_the_time('F, Y') );
  elseif( is_year() ) $title = sprintf( __( 'Archive for %s', 'flatbox' ), get_the_time('Y') );
  elseif( is_author() ) $title = __( 'Author Archive', 'flatbox' );
  elseif ( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) $title = __( 'Blog Archives', 'flatbox' );
  elseif ( has_post_format('image') ) $title = __( 'Images', 'flatbox' );
  elseif ( has_post_format('video') ) $title = __( 'Videos', 'flatbox' ); ?>







  <div id="banner"  style="background:#fff;"></div>   
      <div class="bg-projects">
          <!-- The container is a centered 960px -->
          <div class="container" style="background:#fff; ">
              <!-- Give column value in word form (one, two..., twelve) -->
              <div class="blog_header">
                  <div class="service-title fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/lamp.png" class="service-img" alt="designicon"><?php echo $title; ?></div>
              </div>
              <!-- Sweet nested columns cleared with a clearfix class -->
              <div class="sixteen columns clearfix">
                  <!-- In nested columns give the first column a class of alpha
                  and the second a class of omega -->
                  <div class="four columns alpha" style="background:#fff;color:#fff;">
                      <p></p>
                  </div>
                 <div class="nine columns omega" style="background:#fff;color:#fff;">
                    <?php echo pagination_pages() ?>
                  </div>
              </div>

              <div class="sixteen columns clearfix">
                  <!-- In nested columns give the first column a class of alpha
                  and the second a class of omega -->
                  <div class="clearfix">
                    <div class="eleven columns alpha" style="background:#fff;color:#fff;">
                        <?php
if (have_posts()) :
  while(have_posts()) :
    the_post();
    if ( (function_exists('has_post_thumbnail')) && has_post_thumbnail() ) :
      $full_image_url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
      $thumb_image_url = aq_resize( $full_image_url, 480, 320, true );
    else :
      $thumb_image_url = get_template_directory_uri().'/img/480x320.gif';
    endif; 
    $post_type = rwmb_meta("post_type2");
    ?>
  
      
 <div id="post-<?php the_ID(); ?>" >


       <?php if ($post_type == 'value3') :
      $sfiles = rwmb_meta('sound_file',array('type' => 'file' ));
      ?>
              <div id="layerslider" style="width: 100%; height: 350px;background:#333;">
         
            <!--LayerSlider layer-->
            <?php foreach ( $sfiles as $sfile ) :
          if (empty($sfile)) break;

          $thumb_image_url = aq_resize( $sfile['url'], 640, 350, true ); 
          ?>
                    
                      <div class="ls-layer smile-bg" style="background:#333; ">
                    <img class="ls-s1" style="left: 50%; " src="<?php echo $thumb_image_url;?>" alt="layer2-background"/>
            </div>
          <?php
        endforeach; ?>
        
         
            
       
              </div>
            <div class="audio_blog_post blog_item">
      <?php elseif ($post_type == 'value2') : 
      $videos = rwmb_meta('blog_video');
       ?>             
            <?php if ( $videos && count($videos)>0 ) :
              foreach ( $videos as $video ) :
                if (empty($video)) break; ?>
              
                  <div class="blog_video">
                    <?php echo $video; ?>
                  </div>
              
            <?php break; endforeach; ?>
            <?php endif; ?>


            <div class="audio_blog_post blog_item">

        <?php elseif ($post_type == 'value4') : 
      $notes = rwmb_meta('blog_note');
      $a_note = rwmb_meta('blog_note_author');
       ?>             
            
      <div class="quote-note blog_note">
                              <blockquote>
                              <?php foreach ( $notes as $note ) :
                      if (empty($note)) break; ?>
                        <p><?php echo $note ?></p>
                  <?php  endforeach; ?>
                              
                                <cite class="author_note"><?php echo $a_note ?></cite></blockquote>
                              <div class="clear"></div>
                          </div>

            <div class="note_blog_post blog_item"> 

      <?php elseif ($post_type == 'value5') : 

      $b_link = rwmb_meta('blog_link_url');
       ?>             
      <div class="blog_link">
            
              
                
                <h5 class="normal_title"><span class="link_post_img"></span><a class="link_post_title" href="<?php echo $b_link ; ?>"><?php the_title(); ?></a></h5>
                <p>
                  <?php echo $b_link ; ?>
                </p>

      </div>

            <div class="link_blog_post blog_item"> 
      <?php else :  ?>    


         
                <a href="<?php the_permalink(); ?>">
                  <img src="<?php echo $thumb_image_url; ?>" class="blog_img" alt=""  />
                </a>
                <div class="info pattern">
                  <a href="<?php the_permalink(); ?>" class="button-link"></a>
                </div>
            
            <div class="blog_post blog_item"> 
      <?php endif; ?>

      <?php if (!($post_type == 'value5')) :  ?>    
              <h5 class="normal_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
      <?php endif; ?>      

              <div class="blog_meta fadeitin">
                <?php the_time(get_option('date_format') . ' ' . get_option('time_format')); ?>
                <?php if( function_exists('zilla_likes') ) {?>
              <span class="firasdate zlike">
                <?php if( function_exists('zilla_likes') ) zilla_likes(); ?>
              </span>
              <?php }?>
              </div>     
              
              <div class="clearfix"></div>
              <div class="blog_text fadeitin"><?php the_excerpt(); ?></div>
            </div>
</div>
<?php endwhile; ?>

    <?php pagination_links(); ?>
<?php
  else:
    get_template_part( 'noresult' );
  endif; ?>
                        <div class="clearfix">
                            <div style="height:80px;"></div>
                        </div>
                    </div>
                  <div class="five columns omega" style="background:#fff; ">
                      <?php if ( is_active_sidebar( 'page-sidebar' )) dynamic_sidebar( 'page-sidebar' ); ?>
                      <div class="clearfix">
                          <div style="height:80px;"></div>
                      </div>

                  </div>
                  </div>
              </div>
        </div>
  </div>

 <div id="banner"  style="background:#fff;"></div>   

<?php endif; //is_home() ?>
<script>
    if ($('#contact_form').length > 0) {
        $('#contact_form').ajaxForm({ target: '#contact_alert' });
    }
</script>

<?php get_footer(); ?>