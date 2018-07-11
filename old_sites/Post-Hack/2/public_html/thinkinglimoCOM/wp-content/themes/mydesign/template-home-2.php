<?php
/**
 *  Template Name: Homepage 2
 *
 * The template for displaying Homapage 2
 */

 get_header(); ?>
<div style="background:#fff;">
<div id="banner"></div><div id="href_home"></div> <?php
$homepage_blocks = (isset($smof_data['my2_homepage_blocks3'])) ? $smof_data['my2_homepage_blocks3']['enabled'] : array();
$i = 0;
$blockscount = count($homepage_blocks);
if ($blockscount > 0)
  foreach ($homepage_blocks as $key => $value) :
    $i++;
    switch ($key) :
        case 'Slider': ?>
            <!--LayerSlider begin-->
            <div class="bg-slider"><div id="href_slider"></div>   
                <?php if( function_exists('layerslider') ) layerslider($smof_data['my2_ls_id']); ?>
            </div>
             <!--LayerSlider end-->
        <?php 
        break;
        case 'html1': ?>
         <?php 
              if ((isset($smof_data['my2_html1_bg'] )) && ($smof_data['my2_html1_bg']!=="") ) {
                  $html1_bg = $smof_data['my2_html1_bg'];
                }else{
                  $html1_bg = "";
                }
                if ((isset($smof_data['my2_html1_color'] )) && ($smof_data['my2_html1_color']!=="") ) {
                  $html1_color = $smof_data['my2_html1_color'];
                }else{
                  $html1_color = "#fff";
                }

            ?>
               <section id="intro" class="bg-intro" style="background:url(<?php echo $html1_bg ;?>) <?php echo $html1_color ;?>;overflow:auto;">
                <div class="container">
                  <div class="section-html sixteen columns ">
                        <?php echo do_shortcode($smof_data['my2_html1_text']) ?>
                  </div>
                  </div>
              </section><!-- end Intro -->

        <?php 
        break;
        case 'html2': ?>
         <?php 
              if ((isset($smof_data['my2_html2_bg'] )) && ($smof_data['my2_html2_bg']!=="") ) {
                  $html2_bg = $smof_data['my2_html2_bg'];
                }else{
                  $html2_bg = "";
                }
                if ((isset($smof_data['my2_html2_color'] )) && ($smof_data['my2_html2_color']!=="") ) {
                  $html2_color = $smof_data['my2_html2_color'];
                }else{
                  $html2_color = "#fff";
                }

            ?>
               <section id="intro" class="bg-intro" style="background:url(<?php echo $html2_bg ;?>) <?php echo $html2_color ;?>;overflow:auto;">
                <div class="container">
                  <div class="section-html sixteen columns ">
                        <?php echo do_shortcode($smof_data['my2_html2_text']) ?>
                  </div>
                  </div>
              </section><!-- end Intro -->

        <?php 
        break;
        case 'html3': ?>
         <?php 
              if ((isset($smof_data['my2_html3_bg'] )) && ($smof_data['my2_html3_bg']!=="") ) {
                  $html3_bg = $smof_data['my2_html3_bg'];
                }else{
                  $html3_bg = "";
                }
                if ((isset($smof_data['my2_html3_color'] )) && ($smof_data['my2_html3_color']!=="") ) {
                  $html3_color = $smof_data['my2_html3_color'];
                }else{
                  $html3_color = "#fff";
                }

            ?>
               <section id="intro" class="bg-intro" style="background:url(<?php echo $html3_bg ;?>) <?php echo $html3_color ;?>;overflow:auto;">
                <div class="container">
                  <div class="section-html sixteen columns ">
                        <?php echo do_shortcode($smof_data['my2_html3_text']) ?>
                  </div>
                  </div>
              </section><!-- end Intro -->

        <?php 
        break;
        case 'html4': ?>
         <?php 
              if ((isset($smof_data['my2_html4_bg'] )) && ($smof_data['my2_html4_bg']!=="") ) {
                  $html4_bg = $smof_data['my2_html4_bg'];
                }else{
                  $html4_bg = "";
                }
                if ((isset($smof_data['my2_html4_color'] )) && ($smof_data['my2_html4_color']!=="") ) {
                  $html4_color = $smof_data['my2_html4_color'];
                }else{
                  $html4_color = "#fff";
                }

            ?>
               <section id="intro" class="bg-intro" style="background:url(<?php echo $html4_bg ;?>) <?php echo $html4_color ;?>;overflow:auto;">
                <div class="container">
                  <div class="section-html sixteen columns ">
                        <?php echo do_shortcode($smof_data['my2_html4_text']) ?>
                  </div>
                  </div>
              </section><!-- end Intro -->

        <?php 
        break;
        case 'intro_text': ?>
              <!--     Introduction Section     -->
              <?php 
              if ((isset($smof_data['my2_Introduction_bg'] )) && ($smof_data['my2_Introduction_bg']!=="") ) {
                  $Introduction_bg = $smof_data['my2_Introduction_bg'];
                }else{
                  $Introduction_bg = "";
                }
                if ((isset($smof_data['my2_Introduction_color'] )) && ($smof_data['my2_Introduction_color']!=="") ) {
                  $Introduction_color = $smof_data['my2_Introduction_color'];
                }else{
                  $Introduction_color = "#fff";
                }

            ?>
              <section id="intro" class="bg-intro" style="background:url(<?php echo $Introduction_bg ;?>) <?php echo $Introduction_color ;?>;overflow:auto;">
                  <div class="section-one sixteen columns clearfix">
                      <div class="intro-title fadeitin"><?php echo $smof_data['my2_homepage_intro_header'] ?></div>
                       <div class="data-content-one fadeitin">
                        <?php echo do_shortcode($smof_data['my2_homepage_intro_text']) ?>
                      </div>
                  </div>
              </section><!-- end Intro -->
        <?php 
        break;
        case 'features': ?>
              <!--     Services Section     -->
                  <section id="SERVICES" class="bg-one"><div id="href_features"></div>
                      <div class="section-one sixteen columns clearfix">
                        <div class="service-title fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/magic-hat.png" class="service-img" alt="designicon"><?php echo $smof_data['my2_features_title']; ?></div>
                          <div class="data-content-service fadeitin">
                            <?php echo $smof_data['my2_features_text']; ?>
                          </div>
                            <?php if (!empty($smof_data['my2_features_slider'])) { ?>
                              <div class="services-tiles">

                                <?php foreach ($smof_data['my2_features_slider'] as $key => $value) :
                                if (!empty($value['url'])) $thumb_image_url = aq_resize( $value['url'], 100, 100, false ); ?>

                            <div class="three columns tile-one"> <!-- Tile 1 -->
                            <?php if (!empty($value['url'])) : ?>
                                          <div class="tile-img fadeitin"><img src="<?php echo $thumb_image_url; ?>" alt="designicon"></div>
                                        <?php endif; ?>
                                          <?php if (!empty($value['title'])) : ?>
                                              <div class="tile-title fadeitin">
                                  <?php echo $value['title']; ?>
                                              </div>
                                          <?php endif; ?>
                                          <p class="tile-text fadeitin">
                                            <?php echo do_shortcode($value['description']); ?>
                                          </p>
                                          <div class="tile-button-div fadeitin">
                                            <a href="<?php echo $value['link']; ?>" class="tile-button">Click me</a>
                                          </div>
                                        </div><!-- end tile -->
                                      <?php endforeach; ?>

                              </div><!-- end Services Tiles -->
                          <?php } ?>
                          <div class="services-note fadeitin">
                              <p class="services-note-text"><?php echo do_shortcode($smof_data['my2_features_tagline']); ?></p>
                          </div>

                       </div>
                  </section><!--     End Services     -->
        <?php 
        break;
        case 'milestone': ?>


      <!--         MileStone Section           -->
        <?php
        if ((isset($smof_data['my2_milestone_bg'] )) && ($smof_data['my2_milestone_bg']!=="") ) {
                $milestone_bg = $smof_data['my2_milestone_bg'];
            }else{
                $milestone_bg = "";
            }
            if ((isset($smof_data['my2_milestone_color'] )) && ($smof_data['my2_milestone_color']!=="") ) {
                $milestone_color = $smof_data['my2_milestone_color'];
            }else{
                $milestone_color = "#2a323a";
            }
        ?>
        <section id="twitter" class="bg-nums" style="background:url(<?php echo $milestone_bg ;?>) <?php echo $milestone_color ;?>;overflow:auto;">
            <div class="section-one section-stone">
               
                 <div class="services-tiles services-tiles2">
                          <?php foreach ($smof_data['my2_milestone_slider'] as $key => $value) :
                  if (!empty($value['url'])) $thumb_image_url = aq_resize( $value['url'], 100, 100, false ); ?>

              <div class="three columns tile-one tile-one2"> <!-- Tile 1 -->
              <?php if (!empty($value['url'])) : ?>
                              <div class="stone-img fadeitin"><img src="<?php echo $value['url']; ?>" alt="designicon"></div>
                          <?php endif; ?>
                            <?php if (!empty($value['title'])) : ?>
                               <div class="stone-title fadeitin">
                               <?php echo do_shortcode($value['title']); ?>
                                </div>
                            <?php endif; ?>
                          </div><!-- end tile -->
                        <?php endforeach; ?>
                </div>

            </div>
         </section><!--         End MileStone Section        -->

        <?php 
        break;
        case 'features_2': ?>
               <!--        Services 2 Section       -->
              <section id="SERVICES" class="bg-one"><div id="href_features2"></div>
                  <div class="section-one">
                      <div class="service-title fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/magic-hat.png" class="service-img" alt="designicon"><?php echo $smof_data['my2_features_title2']; ?></div>
                      <div class="data-content-service fadeitin">
                          <?php echo $smof_data['my2_features_text2']; ?>
                      </div>
                          <?php if (!empty($smof_data['my2_features_slider2'])) { ?>
                              <div class="services-tiles services-tiles2">

                                  <?php foreach ($smof_data['my2_features_slider2'] as $key => $value) :
                                  if (!empty($value['url'])) $thumb_image_url = aq_resize( $value['url'], 80, 80, false ); ?>

                                      <div class="three columns tile-one tile-one2"> <!-- Tile 1 -->
                                      <?php if (!empty($value['url'])) : ?>
                                      <div class="c-img">
                                        <div class="tile-img fadeitin"><img src="<?php echo $thumb_image_url; ?>" alt="designicon"></div>
                                      </div>
                                      <?php endif; ?>
                                        <?php if (!empty($value['title'])) : ?>
                                              <div class="tile-title fadeitin">
                                                  <?php echo $value['title']; ?>
                                              </div>
                                        <?php endif; ?>
                                        <p class="tile-text fadeitin">
                                          <?php echo $value['description']; ?>
                                        </p>
                                        <div class="tile-button-div fadeitin">
                                          <a href="<?php echo $value['link']; ?>" class="tile-button">Click me</a>
                                        </div>
                                      </div><!-- end tile -->
                                  <?php   endforeach; ?>

                          </div><!-- end Services 2 Tiles -->
                      <?php } ?>
                      <div class="services-note fadeitin">
                          <p class="services-note-text"><?php echo do_shortcode($smof_data['my2_features_tagline2']); ?></p>
                      </div>

                   </div>
              </section><!--       End Services 2       -->
        <?php 
        break;
        case 'call_to_action': ?>
              <!--     Call Us Section    -->
              <?php
              if ((isset($smof_data['my2_call_bg'] )) && ($smof_data['my2_call_bg']!=="") ) {
                  $call_bg = $smof_data['my2_call_bg'];
                }else{
                  $call_bg = "";
                }
                if ((isset($smof_data['my2_call_color'] )) && ($smof_data['my2_call_color']!=="") ) {
                  $call_color = $smof_data['my2_call_color'];
                }else{
                  $call_color = "#f6653c";
                }
            ?>
              <section id="call" class="bg-call" style="background:url(<?php echo $call_bg ;?>) <?php echo $call_color ;?>;overflow:auto;">
                  <div class="section-one">
                      <div class="left-call">
                          <div class="call-text fadeitin">
                              <h3><?php echo $smof_data['my2_call_to_action_title']; ?></h3>
                              <p><?php echo $smof_data['my2_call_to_action_text']; ?></p>
                          </div>
                      </div>
                      <div class="right-call">
                          <div class="call-button-area fadeitin">
                              <a href="<?php echo $smof_data['my2_call_to_action_button_url']; ?>" class="call-button"><?php echo $smof_data['my2_call_to_action_button_text']; ?></a>
                          </div>
                      </div>
                      <div class="call-clearfix"></div>
                  </div>
                   
              </section><!--     End Call Section     -->
        <?php 
        break;
        case 'posts': ?>
              <!--     Latest Blog Section    -->     
              <div class="works-container bg-projects"><div id="href_blog"></div> 
                  <div class="section-two bottom-works sixteen columns clearfix">
                  <div class="works-header">
                      <div class="service-title fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/lamp.png" class="service-img" alt="designicon"><?php echo do_shortcode($smof_data['my2_blog_text']); ?></div>
                          <div class="data-content-service fadeitin">
                              <?php echo do_shortcode($smof_data['my2_home_blog_tagline']); ?> 
                          </div>
                      

              <?php if (!empty($journal_category) && $journal_category != 0 ) {
                  $categories = get_categories(array(
                    'child_of' => $journal_category,
                    'hide_empty' => 1
                  ));
                } else {
                  $categories = get_categories();
                }
                $count = count($categories); ?>

                
              <?php   if ( $count>1 ) : ?>
                    <div class="subtitle">
                      <p class="filter isotope-filter">
                        <!-- <a href="#" data-value="all" class="active"><?php _e( 'All', 'flatbox' ); ?></a> -->

                      </p>
                    </div>
                    <div class="clear"></div>
              <?php   endif; ?>




                  <div id="portfolio" class="container">
                    <div class="section portfoliocontent">
                      <section id="options" class="clearfix">
                          <div id="filters" class="option-set clearfix foliomenu fadeitin" data-option-key="filter">
                            <a href="#filter" data-option-value="*" class="folio-btn selected"><div class="portfolio-btn selected"><?php _e( 'All', 'flatbox' ); ?></div></a>
                            <?php foreach ($categories as $key => $value) : ?>
                                <a href="#filter" data-option-value=".<?php echo $value->slug; ?>" class="folio-btn"><div class="portfolio-btn"><?php echo $value->slug; ?></div></a>
                            <?php endforeach; ?>
                          </div>
                      </section> 
                      <div id="container2" class="clearfix">
                        <div class="inici"></div>

                    <?php
                    $page_no = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                      'post_type' => 'post',
                      'post_status' => 'publish',
                      'posts_per_page' => 9,
                      'paged' => $page_no
                    );
                    if (!empty($journal_category) && $journal_category != 0 ) {
                      $args['cat'] = $journal_category;
                    }
                    query_posts($args);
                    ?>
                        <div class="clear"></div>
                    <?php while(have_posts()) :
                        the_post();
                        $categories = get_the_category();
                        $filter = '';
                        foreach ($categories as $category_value) {
                          $filter .= '' . $category_value->slug . ' ';
                        }
                        $filter = trim($filter);
                        if ( (function_exists('has_post_thumbnail')) && has_post_thumbnail() ) :
                          $full_image_url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
                          $thumb_image_url = aq_resize( $full_image_url, 299, 200, true );
                        else :
                          $thumb_image_url = get_template_directory_uri().'/img/480x320.gif';
                        endif;

                        $post_type = rwmb_meta("post_type2");

                         ?>
  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <!--     Slider Post    -->
                    <?php if ($post_type == 'value3') :
                        $sfiles = rwmb_meta('sound_file',array('type' => 'file' ));
                    ?>
                        <div class="element <?php echo $filter; ?>">
                            <div class="work-slider-container fadeitin">
                                <div id="layerslider2" style="width: 100%; height: 200px;background:#333;">
                                <!--LayerSlider layer-->
                                <?php foreach ( $sfiles as $sfile ) :
                                    if (empty($sfile)) break;
                                        $thumb_image_url = aq_resize( $sfile['url'], 300, 220, true ); 
                                    ?>
                                    <div class="ls-layer smile-bg" style="background:#333; ">
                                    <img class="ls-s1" style="left: 50%; " src="<?php echo $thumb_image_url;?>" alt="layer2-background"/>
                                    </div>
                                  <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                   
                    <!--     Video Post    -->    
                    <?php elseif ($post_type == 'value2') : 
                       $videos = rwmb_meta('blog_video');
                    ?>             
                        <?php if ( $videos && count($videos)>0 ) :
                            foreach ( $videos as $video ) :
                                if (empty($video)) break; ?>
                                    <div class="element <?php echo $filter; ?>">
                                        <div class="video-container fadeitin">
                                           <?php echo $video; ?>
                                        </div>
                                    </div>
                                <?php break; endforeach; ?>
                        <?php endif; ?>

                      <!--     Note Post    -->
                      <?php elseif ($post_type == 'value4') : 
                    $notes = rwmb_meta('blog_note');
                    $a_note = rwmb_meta('blog_note_author');
                     ?>             
                           <div class="element <?php echo $filter; ?>">
                              <div class="note-container fadeitin">
                              <div class="quote-note">
                                                  <p>
                                                     <?php foreach ( $notes as $note ) :
                                                       if (empty($note)) break; ?>
                                                         <?php echo $note ?>
                                                    <?php  endforeach; ?>
                                                    <br><br>
                                                    <cite><?php the_time(get_option('date_format')); ?><br><span class="author"><?php echo $a_note ?></span></cite>
                                                  </p>
                                      <div class="clear"></div>
                              </div>
                              </div>
                          </div>

                    <!--     Link Post    -->
                    <?php elseif ($post_type == 'value5') : 

                    $b_link = rwmb_meta('blog_link_url');
                         ?>             
                              <div class="element element-link <?php echo $filter; ?>">
                              <div class="link-container fadeitin">
                              <div class="link_post">
                                  <h5 class="normal_title"><span class="link_post_img"></span>
                                      <a class="link_post_title" href="asdas"><?php the_title(); ?></a></h5>
                                      <a class="link-button" href="<?php echo $b_link ; ?>">Visite Project Website</a>
                              </div>
                              </div>
                          </div>
                
                    <!--     Normal Post    -->
                    <?php else :  ?>    
                        
                          <div class="element <?php echo $filter; ?>">
                          <div class="ch-grid fadeitin">
                                <div class="work-info"><a class="work_new_title" href="<?php the_permalink(); ?>" ><?php the_title(); ?></a><span class="work_text"><br><span class='bottom-text'><?php echo excerpt(15); ?></span></span><div class="home_likes"><div class="car_like2"><?php if( function_exists('zilla_likes') ) zilla_likes(); ?></div></div></div>
                                <!--[if lte IE 9]> <div class="ch-itemie9 ch-img-1"></div><![endif]--> 
                                <!--[if gt IE 9]><!--><div class="ch-item ch-img-221"> <img src="<?php echo $thumb_image_url; ?>" class="home_blog_img" alt=""  /></div><!--<![endif]--> 
                          </div>
                          </div>

                       
                            
                          
                    <?php endif; ?>
</div>
              <?php endwhile; ?>

              <div class="clear"></div>


                  
                  <div class="final"></div>
                  <div class="call-clearfix"></div>
                
                  </div>


                  
                  <div class="services-note fadeitin">
                      <!-- <a class="load-more" href="f">Load More Projects</a> -->
                      <p></p>
                      <a id="loadbutton" href="<?php echo do_shortcode($smof_data['my2_blog_button_link']) ?>" class="load-more-button"><?php echo do_shortcode($smof_data['my2_blog_button']) ?></a>
                      
                  </div>

                
                  
                      <!-- Project -->
                      <div id="project-show"></div>
                      <div class="project-window">
                          <div class="project-content"></div><!-- AJAX Dinamic Content -->
                      </div><!-- end Project -->
                      
               </div> <!-- #container -->
                              
                          </div> <!-- /END ISOTOPE PORTFOLIO-->
                  </div><!-- end portfolio -->
              </div>
              </div>

        <?php 
        break;
        case 'quotes': ?>
              <!--     Quotes Section     -->
              <?php
                if ((isset($smof_data['my2_testimonials_image'] )) && ($smof_data['my2_testimonials_image']!=="") ) {
                    $testimonials_image = $smof_data['my2_testimonials_image'];
                  }else{
                    $testimonials_image = "";
                  }
                  if ((isset($smof_data['my2_testimonials_color'] )) && ($smof_data['my2_testimonials_color']!=="") ) {
                    $testimonials_color = $smof_data['my2_testimonials_color'];
                  }else{
                    $testimonials_color = "#263845";
                  }
              ?>
                <section id="freebies" class="bg-testmonials" style="background:url(<?php echo $testimonials_image ;?>) <?php echo $testimonials_color ;?>;overflow:auto;">
                    <div class="section-two section-test no-bottom sixteen columns clearfix">
                        <div class="title-two title-test fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/quote.png" alt="designicon"></div>
                        
                    </div>
                    <div class="window window-test">
                        <div class="content projectsContent">
                            <div class="anythingSlider anythingSlider-minimalist-round activeSlider" style="width: 100%; display: block; opacity: 1;">
                                <div class="anythingWindow" style="width: 100%; height: 50%;">
                                    <ul id="slider" class="anythingBase horizontal" style="width: 21600px;">
                  

                                      <?php
                            $page_no = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            query_posts(array(
                              'post_type' => array('testimonials'),
                              'post_status' => 'publish',
                              'paged' => $page_no
                            ));
                            if (have_posts()) :
                              while(have_posts()) :
                                the_post();
                                $author_name = rwmb_meta("testimonial_author_name");
                                $author_url = rwmb_meta("testimonial_author_url"); ?>


                                <li class="caseCount cloned panel" style="width: 1542px; height: auto;">
                                        <div class="testmonial-text fadeitin">
                                           <?php the_content(); ?>
                                        </div>
                                        <div class="call-clearfix"></div>

                                        <?php if ( (function_exists('has_post_thumbnail')) && has_post_thumbnail() ) :
                                  $full_image_url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
                                  $thumb_image_url = aq_resize( $full_image_url, 100, 100, false ); ?>
                                    <img class="qimg fadeitin" src="<?php echo $thumb_image_url; ?>" alt="" title="" />
                                  <?php else:
                                    $thumb_image_url = get_template_directory_uri().'/img/team/img1.png'; ?>
                                    <img class="fadeitin" src="<?php echo $thumb_image_url; ?>" alt="" title="">
                                  <?php   endif; ?>

                                        <div class="testmonial-author fadeitin">
                                           <?php echo $author_name; ?>
                                        </div>
                                    </li><!-- end Recent Work 1 -->
                                
                            <?php endwhile; endif; ?>    
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--  end Slider Recent Works -->
                        <div class="controller">
                          <!-- <div class="prev"></div> -->
                            <div class="bullets">
                              <ul>
                                <!-- Bullets -->
                                </ul>
                            </div>
                            <!-- <div class="next"></div> -->
                        </div>
                    </div>
                </section><!--End Quotes --> 
        <?php 
        break;
        case 'about': ?>
              <!--     About Us Section     -->
              <section id="team" class="bg-one"><div id="href_about"></div>
                  <div class="section-one section-team">
                      <div class="service-title fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/paper.png" class="service-img" alt="designicon"><?php echo $smof_data['my2_about_title']; ?></div>
                      <div class="data-content-about fadeitin">
                          <?php echo do_shortcode($smof_data['my2_about_info']); ?>
                      </div>
                      <div class="data-content-tagline fadeitin">
                          <?php echo do_shortcode($smof_data['my2_about_tagline']); ?>
                      </div>
                       <div class="services-tiles">
                          <?php
                              query_posts(array(
                                'post_type' => array('staff-members'),
                                'post_status' => 'publish',
                                'order' => 'ASC',
                                'orderby' => 'menu_order',
                                'posts_per_page' => -1
                              ));
                              if (have_posts()) :
                                while(have_posts()) :
                                  the_post();
                                  $facebook_url = rwmb_meta("social_link_facebook");
                                  $twitter_url = rwmb_meta("social_link_twitter");
                                  $googleplus_url = rwmb_meta("social_link_googleplus");
                                  $email_address = rwmb_meta("social_link_email");
                                  $linkedin_address = rwmb_meta("social_link_linkedin");
                                  $newgoogleplus_address = rwmb_meta("social_link_newgoogleplus");
                                  $m_tagline = rwmb_meta("member_tagline");
                                  ?>
                     <div class="three columns tile-one team-one"> <!-- team member 1 -->
                                 <div class="team-img-mask">
                              <?php if ( (function_exists('has_post_thumbnail')) && has_post_thumbnail() ) :
                        $full_image_url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
                          $thumb_image_url = aq_resize( $full_image_url, 480, 480, true ); ?>
                          <img class="team-img" src="<?php echo $thumb_image_url; ?>" alt="" title="">
                        <?php else: ?>
                          <img class="team-img" src="<?php echo get_template_directory_uri(); ?>/img/team/team1.jpg" alt="" title="">
                        <?php   endif; ?>
                                      <div class="team-mask">
                                      </div>
                                  </div>
                                  <div class="team-name fadeitin"><?php the_title(); ?></div>
                                  <div class="team-tag fadeitin"><?php echo $m_tagline; ?></div>
                                  <p class="team-text fadeitin">
                                    <?php $excerpt = strip_tags(get_the_excerpt());
                              echo $excerpt; ?>
                                  </p>
                                  <div class="social-links fadeitin">
                                  <?php if (!(empty($facebook_url))){ ?>
                                     <a href="<?php echo $facebook_url; ?>" class="facebook-link"></a>
                                  <?php } ?>
                                  <?php if (!(empty($twitter_url))){ ?>
                                    <a href="<?php echo $twitter_url; ?>" class="twitter-link"></a>
                                  <?php } ?>
                                  <?php if (!(empty($googleplus_url))){ ?>
                                    <a href="<?php echo $googleplus_url; ?>" class="forrst-link"></a>
                                  <?php } ?>
                                  <?php if (!(empty($email_address))){ ?>
                                    <a href="<?php echo $email_address; ?>" class="dribbble-link"></a>
                                  <?php } ?>
                                   <?php if (!(empty($linkedin_address))){ ?>
                                    <a href="<?php echo $linkedin_address; ?>" class="linkedin-link"></a>
                                  <?php } ?>
                                   <?php if (!(empty($newgoogleplus_address))){ ?>
                                    <a href="<?php echo $newgoogleplus_address; ?>" class="googleplus-link"></a>
                                  <?php } ?>
                                  

                                  </div>
                              </div><!-- end Team member -->

                              <?php endwhile; ?>

                          <?php endif; ?>

                                <?php if ($smof_data['my2_join_us_switch'] ) { ?>
                                 <div class="three columns tile-one team-one"> <!-- team member 1 -->
                                 <div class="team-img-mask">
                                    <img class="team-img" src="<?php echo get_template_directory_uri(); ?>/img/team/plus.png" alt="" title="">
                                      <div class="team-mask">
                                      </div>
                                      
                                  </div>
                                 
                                  <div class="team-name fadeitin"><?php echo $smof_data['my2_join_us_title']; ?></div>
                                  <div class="team-tag fadeitin"><?php echo $smof_data['my2_join_us_tagline']; ?></div>
                                  <p class="team-text fadeitin">
                                     <?php echo $smof_data['my2_join_us_text']; ?>
                                  </p>
                                  <a href="<?php echo $smof_data['my2_join_us_but']; ?>" class="team-button"><?php echo $smof_data['my2_join_us_but_text']; ?></a>
                                </div><!-- end Team member -->
                                <?php } ?>

                            </div><!-- end Services Tiles -->
           
                      </div>

                    </section><!-- end team -->
        <?php 
        break;
        case 'about_2': ?>
              <section id="team" class="bg-one"><div id="href_about2"></div>
                      <div class="section-one section-team">
                          <div class="service-title fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/paper.png" alt="" class="service-img"><?php echo $smof_data['my2_about_title2']; ?></div>
                          <div class="data-content-about fadeitin">
                              <?php echo do_shortcode($smof_data['my2_about_info2']); ?>
                          </div>
                          <div class="data-content-tagline fadeitin">
                              <?php echo do_shortcode($smof_data['my2_about_tagline2']); ?>
                          </div>

                                <div class="service-title">
                                  <?php $thumb_image_url = aq_resize( $smof_data['my2_team_img'] , 540, 200, true ); ?>
                                  <img class="team-img2 fadeitin" src="<?php echo $thumb_image_url; ?>" alt="" title="">
                                  </div>
                                    <div class="team-name fadeitin"><?php echo $smof_data['my2_team_title']; ?></div>
                                      <div class="team-tag fadeitin"><?php echo $smof_data['my2_team_tagline']; ?></div>
                                      <p class="team-text2 fadeitin">
                                         <?php echo $smof_data['my2_team_text']; ?>
                                      </p>
                                      <div class="social-links fadeitin">
                                        <?php if (!(empty($smof_data['my2_team_facebook']))){ ?>
                                        <a href="<?php echo $smof_data['my2_team_facebook']; ?>" class="facebook-link"></a>
                                        <?php } ?>
                                        <?php if (!(empty($smof_data['my2_team_twitter']))){ ?>
                                        <a href="<?php echo $smof_data['my2_team_twitter']; ?>" class="twitter-link"></a>
                                        <?php } ?>
                                        <?php if (!(empty($smof_data['my2_team_forrst']))){ ?>
                                        <a href="<?php echo $smof_data['my2_team_forrst']; ?>" class="forrst-link"></a>
                                        <?php } ?>
                                        <?php if (!(empty($smof_data['my2_team_dribbble']))){ ?>
                                        <a href="<?php echo $smof_data['my2_team_dribbble']; ?>" class="dribbble-link"></a>
                                        <?php } ?>
                                      
                                      </div>



                                      <?php if ($smof_data['my2_join_us_switch2'] ) { ?>
                                      <div class="join fadeitin">
                                        <div class="join-cont">
                                          <div class="join-title"><?php echo $smof_data['my2_join_us_title2']; ?></div>
                                          <div class="join-text">
                                              <?php echo $smof_data['my2_join_us_text2']; ?>
                                          </div>
                                          <div class="join-button">
                                            <a href="<?php echo $smof_data['my2_join_us_but2']; ?>" class="team-button"><?php echo $smof_data['my2_join_us_but_text2']; ?></a>
                                          </div>
                                          <div class="call-clearfix"></div>
                                        </div>
                                        <div class="call-clearfix"></div>
                                      </div>
                                      <?php } ?>

                          </div>
                        </section><!-- end team -->
        <?php 
        break;
        case 'social': ?>
             <section id="social-boxes" class="bg-social-boxes">
                    <div class="section-one section-twitter">
                                     
                        <div class="services-tiles services-tiles2">
                                  <div class="three columns tile-one boxe-one fadeitin"> <!-- Tile 1 -->
                                                           
                                     <div class="social-name">facebook</div>
                                     <div class="social-text"><span class="bold-social"><?php if( function_exists('get_scp_facebook') ) {echo get_scp_facebook(); } ?></span> <span class="light-social">Likes</span></div>
                                  </div><!-- end tile -->
                                  <div class="three columns tile-one boxe-two fadeitin"> <!-- Tile 1 -->
                                     <div class="social-name">twitter</div>
                                     <div class="social-text"><span class="bold-social"><?php if( function_exists('get_scp_twitter') ) {echo get_scp_twitter(); } ?></span> <span class="light-social">Followers</span></div>
                                  </div><!-- end tile -->
                                  <div class="three columns tile-one boxe-three fadeitin"> <!-- Tile 1 -->
                                     <div class="social-name">Google+</div>
                                     <div class="social-text"><span class="bold-social"><?php if( function_exists('get_scp_googleplus') ) {echo get_scp_googleplus(); } ?></span> <span class="light-social">Followers</span></div>
                                  </div><!-- end tile -->
                                  <div class="three columns tile-one boxe-four fadeitin"> <!-- Tile 1 -->
                                     <div class="social-name">Instagram</div>
                                     <div class="social-text"><span class="bold-social"><?php if( function_exists('get_scp_instagram') ) {echo get_scp_instagram(); } ?></span> <span class="light-social">Followers</span></div>
                                  </div><!-- end tile -->

                              </div><!-- end Services Tiles -->

                        <div class="call-clearfix"></div>
                      </div>
                  </section><!-- end social boxes -->
        <?php 
        break;
        case 'twitters': ?>
              <!--         Twitter Section           -->
              <?php
              if ((isset($smof_data['my2_twitter_bg'] )) && ($smof_data['my2_twitter_bg']!=="") ) {
                      $twitter_bg = $smof_data['my2_twitter_bg'];
                  }else{
                      $twitter_bg = "";
                  }
                  if ((isset($smof_data['my2_twitter_color'] )) && ($smof_data['my2_twitter_color']!=="") ) {
                      $twitter_color = $smof_data['my2_twitter_color'];
                  }else{
                      $twitter_color = "#5b9a68";
                  }
              ?>
              <section id="twitter" class="bg-twitter" style="background:url(<?php echo $twitter_bg ;?>) <?php echo $twitter_color ;?>;overflow:auto;">
                  <div class="section-one section-twitter">
                      <div class="title-two title-test fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/icon.png" alt=""></div>
                      <div id="ftwitter" user-id="<?php echo $smof_data['my2_twitter_id']; ?>">
                      </div>
                  </div>
               </section><!--         End Twitter Section        -->
        <?php 
        break;
         case 'contact': ?>
              <!--         Google Map Section         -->
              <?php if (!empty($smof_data['my2_map_link'])) { ?>
              <section id="map" class="bg-map">
                  <iframe style="width:100%;height:100%;" src="<?php echo $smof_data['my2_map_link']; ?>&amp;output=embed"></iframe>
              </section><!--         End Google Map Section         -->
              <?php } ?>
          
             
             <!--      Contact Us Section         -->
              <div id="contact" class="container bg-two"><div id="href_contact"></div> 
                  <div class="section-two">
                    <div class="service-title fadeitin"><img src="<?php echo get_template_directory_uri(); ?>/img/map.png" alt="" class="service-img"><?php echo $smof_data['my2_contact_title']; ?></div>
                      <div class="data-content-about">
                          <?php echo $smof_data['my2_contact_headline']; ?>
                      </div>
                       <div class="data-content-about">
                          <span class="contact-label1">Address: <span class="blue-text"><?php echo $smof_data['my2_contact_location']; ?></span></span>
                          <span class="contact-label2">Email: <span class="blue-text"><?php echo $smof_data['my2_contact_info_email']; ?></span></span>
                          <span class="contact-label2">Phone: <span class="blue-text"><?php echo $smof_data['my2_contact_phone']; ?></span></span>
                          
                      </div>

                     <div class="message" style="display:none"><div id="contact_alert" class="call-to-action clearfix"></div></div>

                       <form id="contact_form" action="<?php echo get_template_directory_uri(); ?>/sendmail.php">
                      <div class="element-contact">
                          <label class="data-form" for="nameform">Name</label>       
                          <input type="text" name="nameform" id="nameform">  
                      </div>
                      <div class="element-contact">
                          <label class="data-form" for="emailform">Email Address</label>
                          <input type="text" name="emailform" id="emailform">
                      </div>
                      <div class="element-contact">
                          <label class="data-form" for="subjectform">Subject</label>       
                          <input type="text" name="subjectform" id="subjectform">  
                      </div>
                      <div class="call-clearfix"></div>
                      <div class="element-contact">
                          <label class="data-form" for="messageform">Description</label>
                          <textarea name="messageform" id="messageform"></textarea>
                      </div>

                      <div class="call-clearfix"></div>
                      <p class="submit-text"><span class="submit-message"><?php echo $smof_data['my2_contact_note']; ?><span class="blue-text">* </span></span><input type="submit" value="<?php _e('Send Message', 'flatbox'); ?>" id="submit-but" class="submit"/></p> 

                      </form>
                  </div>
              </div><!-- end contact -->
        <?php 
        break; // Last Break
    endswitch;
  endforeach;
?>


</div>


<script>
    if ($('#contact_form').length > 0) {
        $('#contact_form').ajaxForm({ target: '#contact_alert' });
    }
</script>
<?php get_footer(); ?>