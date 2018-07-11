<div id="sidebar_l">
    <ul>
 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
      <?php /* Menu for subpages of current page (copied from K2 theme) */
    global $notfound;
    if (is_page() and ($notfound != '1')) {
        $current_page = $post->ID;
        while($current_page) {
            $page_query = $wpdb->get_row("SELECT ID, post_title, post_status, post_parent FROM $wpdb->posts WHERE ID = '$current_page'");
            $current_page = $page_query->post_parent;
        }
        $parent_id = $page_query->ID;
        $parent_title = $page_query->post_title;

        // if ($wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' AND post_status != 'attachment'")) {
        if ($wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' AND post_type != 'attachment'")) {
    ?>
     <?php } } ?>
     <li>
     <h3 class="sidebartitle">
        <?php _e('Category'); ?>
      </h3>
    	<ul>
        <?php wp_list_categories('orderby=name&title_li'); ?>
      </ul>
    </li>
    <li>
      <h3 class="sidebartitle">
        <?php _e('Recent Comments'); ?>
      </h3>
      <?php include (TEMPLATEPATH . '/simple_recent_comments.php'); /* recent comments plugin by: www.g-loaded.eu */?>
      <?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments(5, 60, '', ''); } ?>
    </li>
    <li><h3 class="sidebartitle">
        <?php _e('Archives'); ?>
      </h3>
     <ul>
        <?php wp_get_archives('type=monthly'); ?>
      </ul>
    </li>
    <?php endif; ?>
  </ul>
 
 
     
  </div>
<!--/sidebar -->