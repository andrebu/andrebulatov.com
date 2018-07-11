<?php
global $General,$wpdb;
$userInfo = $General->getLoginUserInfo();
$orderId = $_REQUEST['id'];
$product_id = $_REQUEST['pid'];
$order_number = preg_replace('/([0-9]*([_]))/','',$orderId);
$userId = preg_replace('/([_])([0-9]*)/','',$orderId);
if($userInfo['ID'] == $userId)
{	
	$data = get_post_meta($product_id, 'key', true );
	$product_image = $data['productimage'];
	$digital_product = $data['digital_product'];
	//if($digital_product == '' || !file_exists(WP_CONTENT_DIR.str_replace(get_option( 'siteurl' ).'/wp-content','',$digital_product)))
	if($digital_product == '')
	{
		?>
<?php get_header(); ?>
<div id="page" class="clearfix">

<div class="breadcrumb clearfix">
    <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; Download Page'); } ?>
 </div> <!-- breadcrumbs #end -->
            
            
     <div id="content">      
 
            <h1 class="head"><?php _e("Download Page");?></h1>
  
      <table>
        <tr>
          <td><h2 style="color:#FF0000;"><?php _e("Sorry, The file you are trying to Download is not available right now.");?></h2></td>
        </tr>
      </table>
 	                    
      </div> <!-- content #end -->
 <?php get_sidebar(); ?>
</div> <!-- page #end -->
<?php get_footer(); ?>
<?php
	}else
	{
		$digital_product_arr = explode('.',$digital_product);
		$file_extension = strtolower($digital_product_arr[count($digital_product_arr)-1]);
		//This will set the Content-Type to the appropriate setting for the file
		switch($file_extension)
		{
			case 'exe': $ctype='application/octet-stream'; break;
			case 'zip': $ctype='application/zip'; break;
			case 'mp3': $ctype='audio/mpeg'; break;
			case 'mpg': $ctype='video/mpeg'; break;
			case 'avi': $ctype='video/x-msvideo'; break;
			default:    $ctype='application/force-download';
		}
		header('Content-Description: File Transfer');
		header('Content-Type: '.$ctype);
	   	header('Content-Disposition: inline; filename="' . $digital_product . '"');
		header('Content-Transfer-Encoding: binary');

		set_time_limit(0);
		echo file_get_contents($digital_product);
		flush();
		ob_flush();
		exit;
	}
}else
{
	?>
  <?php get_header(); ?>
<div id="page" class="clearfix">

<div class="breadcrumb clearfix">
    <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; Download Page'); } ?>
 </div> <!-- breadcrumbs #end -->
            
            
     <div id="content">      
 
            <h1 class="head"><?php _e("Download Page");?></h1>
      <table>
        <tr>
          <td><h2 style="color:#FF0000;"><?php _e("The link you are trying to download is not a Valid link. Please Check once.");?></h2></td>
        </tr>
      </table>
 	                    
      </div> <!-- content #end -->
 <?php get_sidebar(); ?>
</div> <!-- page #end -->
<?php get_footer(); ?>
<?php
}
?>
