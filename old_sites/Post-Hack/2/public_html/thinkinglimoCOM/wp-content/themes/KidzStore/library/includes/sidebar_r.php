<div id="sidebar_r">
                 		
                      <div class="featured_pro"> 
                        <h3>Featured Product</h3>
                        <p><a href="#">Coating Crumbs</a> </p>
                        
                        <a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/p1.png" alt=""  /></a>
                        
                        <p class="details"> <a href="#"> <img src="<?php bloginfo('template_directory'); ?>/images/spacer.png" alt="" class="arrow"  /> View Details</a></p>
                        
                      </div> <!-- featured pro #end -->
                      
                      
                      <h3>Our Products</h3>
                      
                     <ul>
					<?php
					$ex_catIdArr = get_categories('exclude=9999999' . get_inc_categories("cat_exclude_") .',1');
					$catIdArr = array();
					foreach($ex_catIdArr as $ex_catIdArrObj)
					{
						$catIdArr[] = $ex_catIdArrObj->term_id;
					}
					$includeCats = implode(',',$catIdArr);
					wp_list_categories('orderby=name&title_li=&include='.$includeCats);
					?>
                     </ul>
 			     <?php if ( function_exists('dynamic_sidebar') && (is_sidebar_active(2)) ) { // Show on the front page ?>
									<?php dynamic_sidebar(2); ?>  
                             <?php } ?>
                        <bR />
                   <?php
                   global $General;
				   $userInfo = $General->getLoginUserInfo();
				   if($General->getLoginUserInfo())
				   {
				   ?>
                   Welcome <?php echo $userInfo['display_name'];?>,<br />
                   <a href="<?php echo get_option('siteurl'); ?>/?page=myaccount">My Account</a><Br />
                   <a href="<?php echo get_option('siteurl'); ?>/?page=myaccount&type=editprofile">Edit Profile</a><Br />
                   <a href="<?php echo get_option('siteurl'); ?>/?page=login&action=logout">LogOut</a>
                   <?php
				   }else
				   {
				   ?>
                   <a href="<?php echo get_option('siteurl'); ?>/?page=login">LogIn</a>
                   <?php
				   }
				   ?>    
                    </div> <!-- sidebar_r #end -->