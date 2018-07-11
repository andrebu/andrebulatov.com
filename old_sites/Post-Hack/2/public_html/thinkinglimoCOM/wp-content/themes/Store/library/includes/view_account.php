<?php
global $Cart,$General,$wpdb;
$userInfo = $General->getLoginUserInfo();
global $current_user;
if(!$current_user->data->ID)
{
	wp_redirect(get_option( 'siteurl' ).'/?page=login');
	exit;
}
?>
<?php get_header(); ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery.js"></script>
<div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix">
        <div id="content">        
<h1 class="head"><?php _e('My Account'); ?></h1>
                <div class="breadcrumb clearfix">
                	<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; My Account'); } ?>
                </div>
 
     	 <div class="fr"><a href="<?php echo get_option('siteurl'); ?>/?page=login&amp;action=logout" class="fr"><u><?php _e("Logout");?></u></a></div>
		<?php  //AFFILIATE START
		if($General->is_active_affiliate())
		{
			global $current_user;
			get_currentuserinfo();
			$user_id = $current_user->data->ID;
			$user_role = get_usermeta($user_id,'wp_capabilities');
			if(!$user_role['affiliate'])
			{
			?>
				<h6><b><?php _e('want to become our affiliate?');?> <a href="<?php echo get_option('siteurl');?>/?page=setasaff"><u>Click here &raquo;</u></a></b> </h6> <br />
				<?php
			} 
			
		} //AFFILIATE END
		?>
            <?php
         if($_REQUEST['type']=="editprofile")
		 {
		 	include_once(TEMPLATEPATH . '/library/includes/edit_profile.php');
		}else
		{
			if(!$General->is_storetype_catalog())
			 {
				 include_once(TEMPLATEPATH . '/library/includes/view_orders.php');
				 echo "<br /><br /><br />";
				 if($General->is_storetype_digital())
				 {
				 	 include_once(TEMPLATEPATH . '/library/includes/view_downloads.php');
				}
			 }
			$userInfo = $General->getLoginUserInfo();
			$user_address_info = unserialize(get_user_option('user_address_info', $userInfo['ID']));
			?>
       
        <table width="100%" class="table">
          <tr>
            <td colspan="2" class="title"><?php _e('My Personal Information'); ?> </td>
          </tr>
          <tr>
            <td class="row1" ><?php _e('Display Name'); ?> : </td>
            <td class="row1" ><?php echo $userInfo['display_name'];?></td>
          </tr>
          <tr>
            <td class="row1"  ><?php _e('Email Address'); ?> : </td>
            <td class="row1" ><?php echo $userInfo['user_email'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e('Address 1'); ?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_add1'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e('Address 2'); ?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_add2'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e('City'); ?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_city'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e('State'); ?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_state'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e('Country'); ?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_country'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e('Postal Code'); ?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_postalcode'];?></td>
          </tr>
           <tr>
            <td class="row1" ><?php _e(PHONE_NUMBER_TEXT);?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_phone'];?></td>
          </tr>
          <tr>
            <td class="row1" ></td>
            <td class="row1" ><a href="<?php echo get_option('siteurl'); ?>/?page=myaccount&type=editprofile" class="highlight_button fr" >Edit Profile</a></td>
          </tr>
        </table>
         <?php
			////////AFFILIATE CODING//////////
			if($General->is_active_affiliate())
			{
				@include_once(TEMPLATEPATH . '/library/includes/affiliates/affiliate_account.php');		
			}
		}
		 ?>
		
 	                    
  			  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->

 <?php get_footer(); ?>