<?php get_header(); 
global $Product,$Cart;
?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/slider.js"></script>
<div id="contentarea" class="clearfix">
	<div id="contenttop">
		<?php
			if(function_exists('dynamic_sidebar') && (is_sidebar_active(1))) // Show on the front page
			{
				dynamic_sidebar(1);
			} 
        ?>
        </div> <!-- contenttop #end -->
<!-- banner #end -->


		<?php include(TEMPLATEPATH . '/library/includes/tpl_latest_products.php'); ?>


<?php get_sidebar(); ?>
<!-- container 16-->

</div> <!-- content area #end -->