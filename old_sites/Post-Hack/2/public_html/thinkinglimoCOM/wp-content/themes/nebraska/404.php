<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * lambda framework v 2.1
 * by www.unitedthemes.com
 * since lambda framework v 1.0
 */

//includes the header.php
get_header();

//includes the template-part-slider.php
//get_template_part( 'template-part', 'slider' );

//includes the template-part-teaser.php
//get_template_part( 'template-part', 'teaser' );

lambda_before_content($columns='');
?>

          
<div class="error_404_page">

<h1 style="font-size:22px;">Oops! It looks like you made a wrong turn!</h1>
  <h3>(Error 404 - Not Found)</h3>
          <p>Please check the spelling of your URL, or try our homepage:</p>         
          <p><a href="http://www.thinkinglimo.com">http://www.thinkinglimo.com</a></p>
          <p>If you need immediate assistance, call us at 1.888.961.9938.</p>
          <p>Our Customer Care team is available 24 hours a day, 7 days a week.</p>
  	  <p class="back_link"><a href="javascript:history.go(-1);">Back to previous page</a></p>

<p>Also, you can try searching.</p>
    <div class="row">
	<?php get_search_form(); ?>
	</div>
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

</div>




<?php
//content closer - this function can be found in functions/theme-layout-functions.php line 56-61
lambda_after_content();

//include the sidebar-page.php
get_sidebar();

//includes the footer.php
get_footer();
?>