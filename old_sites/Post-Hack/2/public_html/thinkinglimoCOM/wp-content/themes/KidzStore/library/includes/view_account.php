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
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			<h2>
			<?php 
			if($_REQUEST['type']=="editprofile")
			{
				_e(EDIT_PROFILE_PAGE_TITLE);
			}else
			{
				_e(VIEW_ACCOUNT_PAGE_TITLE);
			}
			?>
            </h2>
             <div class="breadcrumb clearfix">
			 <?php 
			  if($_REQUEST['type']=="editprofile")
			  {
				 $myaccountlink = ' &raquo; <a href="'.get_option('siteurl').'?page=myaccount">'.VIEW_ACCOUNT_PAGE_TITLE.'</a>';
			  }
			 if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',$myaccountlink.' &raquo; '.EDIT_PROFILE_PAGE_TITLE); } ?>
             </div>
		</div>
	</div>
</div>


   
  <div class="container_16 clearfix">
    <div id="content" class="grid_11">

		
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
				<h6><b><?php _e(WANT_TO_BECOME_AFF_TEXT);?> <a href="<?php echo get_option('siteurl');?>/?page=setasaff"><u><?php _e('Click here');?> &raquo;</u></a></b> </h6>
				<?php
			} 
			
		} //AFFILIATE END
		?>
      <div class="content_spacer">
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
            <td colspan="2" class="title"><?php _e(PERSONAL_INFO_TEXT);?> </td>
          </tr>
          <tr>
            <td class="row1" ><?php _e(NAME_TEXT);?> : </td>
            <td class="row1" ><?php echo $userInfo['display_name'];?></td>
          </tr>
          <tr>
            <td class="row1"  ><?php _e(EMAIL_TEXT);?> : </td>
            <td class="row1" ><?php echo $userInfo['user_email'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e(ADDRESS1_TEXT);?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_add1'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e(ADDRESS2_TEXT);?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_add2'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e(CITY_TEXT);?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_city'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e(STATE_TEXT);?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_state'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e(COUNTRY_TEXT);?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_country'];?></td>
          </tr>
          <tr>
            <td class="row1" ><?php _e(POSTAL_CODE_TEXT);?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_postalcode'];?></td>
          </tr>
           <tr>
            <td class="row1" ><?php _e(PHONE_NUMBER_TEXT);?> : </td>
            <td class="row1" ><?php echo $user_address_info['user_phone'];?></td>
          </tr>
          <tr>
            <td class="row1" ></td>
            <td class="row1" ><a href="<?php echo get_option('siteurl'); ?>/?page=myaccount&type=editprofile" class="highlight_button fr" ><?php _e(EDIT_PROFILE_TEXT);?></a></td>
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
      </div>
      
    </div>
    <!-- content-in #end -->
    <?php get_sidebar(); ?>
  </div>
  <!-- container 16-->
<?php get_footer(); ?>
