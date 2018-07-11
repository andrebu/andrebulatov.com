<div id="sidebar_l">

                     	
                        <?php if ( get_option('ptthemes_show_blog_title') ) { ?>
                
                  
                   <div class="blog-title"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a> </div>
                <p class="blog-description">
                  <?php bloginfo('description'); ?>
                </p>
                
                <?php } else { ?>
                <a href="<?php echo get_option('home'); ?>/"><img src="<?php if ( get_option('ptthemes_logo_url') <> "" ) { echo get_option('ptthemes_logo_url'); } else { echo get_bloginfo('template_directory').'/images/logo.png'; } ?>" alt="<?php bloginfo('name'); ?>" class="logo"  /></a>             
                <?php } ?>
                
                
                
                <p class="login">
                	<?php
                	global $current_user,$General;
					if($current_user->data->ID)
				   {
				   ?>
               		  <strong> <?php _e(WELCOME_TEXT);?> <strong><?php echo $current_user->data->user_nicename;?></strong>,</strong>  <a href="<?php echo get_option('siteurl'); ?>/?page=login&amp;action=logout"><?php _e(LOGOUT_TEXT);?></a>
                  <?php
				   }else
				   {
				   ?>
     				<strong><?php _e(HELLO_GUEST_TEXT);?>,</strong> <a href="<?php echo get_option('siteurl'); ?>/?page=login"><?php _e(LOGIN_TEXT);?></a> 
     			 	<?php
				   }
				   ?></p>
                 <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Navigation') ){}else{  ?>	
                 <ul class="sf-menu sf-vertical ">
                         <li class="hometab <?php if ( is_home() && $_GET['page']=='') { ?>current_page_item <?php } ?>"><a href="<?php echo get_option('home'); ?>/"><?php _e(HOME_TEXT); ?></a></li>
                           <?php
							if($General->is_show_storepage())
							{
							?>
							<li class="store <?php if ($_GET['page']=='store') { ?>current_page_item <?php } ?>"><a href="<?php echo get_option('siteurl')."/?page=store";?>"><?php _e(STORE_TEXT); ?></a></li>
							<?php
							}
							?>
							 <?php wp_list_pages('title_li=&exclude=' . get_inc_pages("pag_exclude_") .'&sort_column=menu_order'); ?>
                          <?php
							if($General->is_show_blogpage())
							{
								
							?>
							<?php $blogCategoryIdStr = get_inc_categories("cat_exclude_"); 
							$catlist = wp_list_categories ('title_li=&depth=0&include=' .$blogCategoryIdStr . '&sort_column=menu_order&echo=0'); 
							if(!strstr($catlist,'No categories'))
							{
								echo $catlist;
							}
							?>
                       		<?php
							}
							?>
						  <?php 
							if($current_user->data->ID)
						   {
						   ?>
                           <li class="hometab <?php if ($_GET['page']=='myaccount') { ?>current_page_item <?php } ?>" ><a href="<?php echo get_option('siteurl'); ?>/?page=myaccount"><?php _e(MY_ACCOUNT_TEXT);?></a></li>
                           <?php
                           }else
						   {
						   ?>
                           <li class="hometab <?php if ($_GET['page']=='login') { ?>current_page_item <?php } ?>" ><a href="<?php echo get_option('siteurl'); ?>/?page=login#register"><?php _e(REGISTER_TEXT);?></a></li>
                           <?php
						   }
						   ?>
                    </ul>
                        <?php }?>
                             
                             <div class="clearfix"></div>
                    <?php
                    if($General->is_storetype_shoppingcart() || $General->is_storetype_digital())
                    {?>
                    <div class="cart_section_l  clearfix">
                             	<div class="cart_section_top">
                                	<div class="cart_section_bottom ">
                                    	 
                                         <h4><?php _e(SHOPPING_CART_TEXT);?></h4>
                                         <p>
								     <?php 
										global $Cart,$General;
										$itemsInCartCount = $Cart->cartCount();
										$cartAmount = $Cart->getCartAmt();
										?>
										 <?php _e('You have'); ?><a href="<?php echo get_option('siteurl'); ?>/?page=cart"><strong> <span id="cart_information_span"><?php if($cartAmount>0){ echo $itemsInCartCount . "(".$General->get_amount_format($cartAmount).")";} else{ echo $itemsInCartCount;}?></span></strong></a> <?php _e(SHOPPING_CART_CONTENT_TEXT); ?></p>
                                         <center><a href="<?php echo get_option('siteurl'); ?>/?page=cart"><b><?php _e(CHECKOUT_TEXT);?> &raquo; </b></a></center>
                                    
                                    </div>
                                </div>
                    </div> <!-- Shopping Cart Section left #end -->
                    <?php
                    }
					?>
                    
                    
                      <?php if ( function_exists('dynamic_sidebar') && (is_sidebar_active(1)) ) { // Show on the front page ?>
									<?php dynamic_sidebar(1); ?>  
                             <?php } ?>
                    
                              
                             
                             <?php if ( get_option('ptthemes_footerpages') <> "" ) { ?>
                                <ul class="nav_sec">
                                <?php wp_list_pages('title_li=&depth=1&include=' . get_option('ptthemes_footerpages') . '&sort_column=menu_order'); ?>
                                </ul>
                            <?php } ?>
                  </div> <!-- sidebar_l #end -->