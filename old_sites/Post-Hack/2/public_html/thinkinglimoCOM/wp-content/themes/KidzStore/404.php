<?php
/*
 * @package WordPress
 * @subpackage Kidzstore
*/
?>
<?php get_header(); ?>

<div class="wrapper" >
  <div class="clearfix container_border">
    <h1 class="head">404 Error Page</h1>
    <div class="breadcrumb clearfix">
      <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
    </div>
  </div>
  <div class="container_12 clearfix ">
    <div id="content" class="grid_7 clearfix">
      <div class="content_spacer">
        <div class="pagespot">
          <div class="post archive-spot">
            <h2>Error 404 | Nothing found!</h2>
            <div class="cat-spot">
              <p>Sorry, but you are looking for something that is not here.</p>
            </div>
            <div class="fix"></div>
          </div>
          <!--/post-->
        </div>
        <!--/pagespot -->
      </div>
      <!-- content Spacer #end -->
    </div>
    <!-- content-in #end -->
    <?php get_sidebar(); ?>
  </div>
  <!-- container 16-->
</div>
<!-- wrapper #end -->
<?php get_footer(); ?>
