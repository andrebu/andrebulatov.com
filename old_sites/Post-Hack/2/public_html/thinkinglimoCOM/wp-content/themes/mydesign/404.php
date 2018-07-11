<?php get_header(); ?>

  <div id="banner"  style="background:#fff;"></div>   
      <div class="bg-projects">
          <!-- The container is a centered 960px -->
          <div class="container" style="background:#fff; ">
              <!-- Give column value in word form (one, two..., twelve) -->
              <div class="blog_header">
                  <div class="service-title fadeitin"><?php _e( '404 Error ', 'flatbox' ); wp_title('-', true); ?></div>
                  <div class="data-content-service fadeitin">
                		<?php echo $smof_data['404_text'] ?>
                		<p></p>
                		                  	<?php if(!empty($smof_data['404_image'])) { ?>
<img src="<?php echo $smof_data['404_image'] ?>" class="scale" alt="" />
<?php } else { ?>
<img src="<?php echo get_template_directory_uri(); ?>/img/404.png" class="scale" alt="" />
<?php }  ?>
            		</div>
              </div>
              <!-- Sweet nested columns cleared with a clearfix class -->
              <div class="sixteen columns clearfix">
                  <!-- In nested columns give the first column a class of alpha
                  and the second a class of omega -->
                  <div class="four columns alpha" style="background:#fff;color:#fff;">

<div class="call-clear"></div>
                      <p></p>

                  </div>
                 <div class="nine columns omega" style="background:#fff;color:#fff;">
                    <?php get_search_form(); ?>
                    <p></p>
                    <p> </p>
                    <div class="call-clear"></div>
                  </div>
              </div>
          </div>
      </div>



<?php get_footer(); ?>