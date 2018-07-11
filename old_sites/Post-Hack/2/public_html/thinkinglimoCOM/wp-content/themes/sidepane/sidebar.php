<div id="sidebar-wrap">
	<div id="sidebar" class="clearfix">

		<div id="site-logo">
			<?php if(themify_get('setting-site_logo') == 'image' && themify_check('setting-site_logo_image_value')){ ?>
			<?php themify_image("src=".themify_get('setting-site_logo_image_value')."&w=".themify_get('setting-site_logo_width')."&h=".themify_get('setting-site_logo_height')."&alt=".get_bloginfo('name')."&before=<a href='".get_option('home')."'>&after=</a>"); ?>
			<?php } else { ?>
			<a href="<?php echo get_option('home'); ?>/">
			<?php bloginfo('name'); ?>
			</a>
			<?php } ?>
		</div>
		<!-- /#site-logo -->
		
		<div id="site-description">
			<?php bloginfo('description'); ?>
		</div>
		<!-- /#site-description -->
		
		<div id="main-nav-wrap">
			<?php
			if (function_exists('wp_nav_menu')) {
				wp_nav_menu(array('theme_location' => 'main-nav' , 'fallback_cb' => 'default_main_nav' , 'container'  => '' , 'menu_id' => 'main-nav' , 'menu_class' => 'clearfix'));
			}
			else {
				default_main_nav();
			}
			?>

			<?php if(!themify_check('setting-exclude_rss')): ?>
				<div class="rss"><a href="<?php if(themify_get('setting-custom_feed_url') != ""){ echo themify_get('setting-custom_feed_url'); } else { echo bloginfo('rss2_url'); } ?>">RSS</a></div>
			<?php endif ?>

		</div>

		<div class="social-widget">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Social_Widget') ) ?>
		</div>
		<!-- /.social-widget -->

		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_1') ) : ?>
			<div class="widget">
				<h4 class="widgettitle">
					<?php _e('Category','themify'); ?>
				</h4>
				<ul>
					<?php wp_list_categories('show_count=1&title_li='); ?>
				</ul>
			</div>
		<?php endif; ?>

		<div class="clearfix">
			<div class="secondary">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_2A') ); ?>
			</div>
			<div class="secondary last">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_2B') ); ?>
			</div>
		</div>

		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_3') ); ?>

		<div id="footer-text" class="footer-text">
			<?php if(themify_get('setting-footer_text_left') != ""){ echo themify_get('setting-footer_text_left'); } else { echo '&copy; <a href="'.get_option('home').'">'.get_bloginfo('name').'</a> '.date('Y') . '<br /> <a href="http://themify.me">Themify WordPress Themes</a>'; } ?>
		</div>
		<!-- /#footer-text -->

	</div>
	<!--/sidebar --> 

</div>
<!--/sidebar-wrap -->