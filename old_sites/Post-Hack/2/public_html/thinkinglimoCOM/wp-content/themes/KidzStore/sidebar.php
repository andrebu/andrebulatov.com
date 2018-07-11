<?php
/*
 * @package WordPress
 * @subpackage Kidzstore
*/
?>
<?php 
global $Cart,$General;
$itemsInCartCount = $Cart->cartCount();
$cartAmount = $Cart->getCartAmt();
?>
<div id="sidebar">

	 <div id="flickr">
    <div class="flickr_bottom clearfix">
             <h5><?php 
				 global $current_user;
				if($current_user->data->ID)
			   {
			   ?>
                <?php _e(WELCOME_TEXT);?> <strong><?php echo $current_user->data->user_nicename;?></strong>
     		<?php }else
			{
				?>
                <?php _e(HELLO_GUEST_TEXT);?>,
                <?php	
			}?></h5>
           
           
            
            <?php 
				 global $current_user;
				if($current_user->data->ID)
			   {
			   ?>
      
       <ul>
       		<li><a href="<?php echo get_option('siteurl'); ?>/?page=myaccount"><?php _e(MY_ACCOUNT_TEXT);?></a> </li>
       		<li><a href="<?php echo get_option('siteurl'); ?>/?page=login&amp;action=logout"><?php _e(LOGOUT_TEXT);?></a> </li>
       
       
		<?php
		   }else
			   {
			   ?>
                   
                   
     					
                   <ul> 
                       <li><a href="<?php echo get_option('siteurl'); ?>/?page=login"><?php _e(LOGIN_TEXT);?></a> </li>
                       <li><a href="<?php echo get_option('siteurl'); ?>/?page=login"><?php _e(REGISTER_TEXT);?></a> </li>
     			 	<?php
				   }
					?>
            
            		<li>  <a href="<?php echo get_option('siteurl'); ?>/?page=cart"><?php _e('Cart Detail');?></a></li>
                    <?php
						if($_REQUEST['page']=='cart'){
						?>
						 <li>  <a href="<?php echo get_option('siteurl'); ?>/?page=checkout"><?php _e('Checkout');?></a></li>
						<?php	
						}else{
						?>
						 <li>  <a href="<?php echo get_option('siteurl'); ?>/?page=cart"><?php _e('Checkout');?></a></li>
						<?php }?>
                   
            
             </ul>
	
    </div>
</div>

    <?php
    if(function_exists('dynamic_sidebar') && (is_sidebar_active(1))) // Show on the front page
    {
        dynamic_sidebar(2);
    } 
    ?>
</div> <!-- sidebar #end -->