<?php global $General;?>
<div id="sidebar_r">
   
     <?php if ( function_exists('dynamic_sidebar') && (is_sidebar_active(4)) ) { // Show on the front page ?>
                <?php dynamic_sidebar(4); ?>  
         <?php } ?>
    
 
  
  
  <h3><?php _e('Our Products');?></h3>
   
 <ul class="sf-menu sf-vertical "> 
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
    
    
</div> <!-- sidebar_r #end -->