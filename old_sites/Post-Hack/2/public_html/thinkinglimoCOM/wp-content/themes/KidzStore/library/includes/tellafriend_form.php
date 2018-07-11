<style>
.tellafriend  { position:relative; }
.tellafriend  h3 { margin:0 0 10px 0; padding:0; font:22px Arial, Helvetica, sans-serif; } 
.row { min-height:25px; margin-bottom:8px;  }
.row label { width:120px; margin-right:10px; float:left; }

.indicates { color:#990000; }

.tellafriend { font:12px Arial, Helvetica, sans-serif; color:#444; }
.textfield { border:1px solid #ccc; padding:3px; font-size:12px; width:390px; }
.textarea { border:1px solid #ccc; padding:3px; font:12px Arial, Helvetica, sans-serif; width:440px; height:250px; }
	
.button { -moz-border-radius-bottomleft:11px;
-moz-border-radius-bottomright:11px;
-moz-border-radius-topleft:11px;
-moz-border-radius-topright:11px;
-moz-box-sizing:content-box; 
border:1px solid #464646;
text-shadow:0 1px 0 #FFFFFF;
padding:5px 10px;
line-height:10px;
margin-top:10px;
color:#fff; background:#464646; cursor:pointer; font-size:12px; }
.button:hover, .button:focus { border:1px solid #333; background:#000; color:#fff; }
.button_spacer { margin-left:130px; margin-right:5px; clear:both; float:left;  }

a.close { position:absolute; right:0px; top:0px; padding:5px 8px; background:#333; color:#fff; -moz-border-radius:35px; cursor:pointer; font:bold 14px Arial, Helvetica, sans-serif; text-decoration:none; display:block }
a:hover.close  { background:#000; }
	 
 </style>
<?php
$pid = $_REQUEST['pid'];
query_posts("p=$pid");
if(have_posts())
{
while(have_posts())
{
	the_post();
}
}
?>
<form name="tellafrnd" action="<?php echo get_option('siteurl')."/?page=tellafriend";?>" method="post" onsubmit="hideform();">
  <input type="hidden" name="productid" value="<?php echo $post->ID;?>" />
  <div class="tellafriend" >
    <h3><?php _e(EMAIL_TO_FRIEND_PAGE_TITLE);?></h3>
    <div class="row">
      <label class="manda"><?php _e(YOUR_NAME_TEXT);?> <span class="indicates">*</span> </label>
      <input type="text" name="frnd_yourname" id="frnd_yourname" class="textfield"/>
    </div>
    <div class="row">
      <label class="manda"><?php _e(YOUR_EMAIL_ADDRESS_TEXT);?><span class="indicates">*</span> </label>
      <input type="text" name="frnd_youremail" id="frnd_youremail" class="textfield" />
    </div>
    <div class="row">
      <label class="manda"><?php _e(FRIEND_NAME_TEXT);?> <span class="indicates">*</span> </label>
      <input type="text" name="frnd_name" id="frnd_name" class="textfield" />
    </div>
    <div class="row">
      <label class="manda"><?php _e(FRIEND_EMAIL_ADDRESS_TEXT);?> <span class="indicates">*</span> </label>
      <input type="text" name="frnd_email" id="frnd_email" class="textfield" />
    </div>
    <div class="row">
      <label class="manda"><?php _e(SUBJECT_TEXT);?> <span class="indicates">*</span> </label>
      <input type="text" name="frnd_subject" value="Sending Information about <?php echo the_title();?>" id="frnd_subject" class="textfield"  />
    </div>
    <div class="row">
      <label class="manda"><?php _e(YOUR_COMMENTS_TEXT);?>  <span class="indicates">*</span> </label>
      <textarea name="frnd_comments" id="frnd_comments" cols="20" rows="5" class="textarea"><?php _e(FRND_MAIL_CONTNET1)?> &ldquo;<?php echo the_title();?>&rdquo;. <?php _e(FRND_MAIL_CONTNET2);?>
     </textarea>
    </div>
    <div class="row">
      <input type="submit" name="Send" value="Send Email" onclick="return check_frm()"  class="button button_spacer" />
    </div>
    <a href="#" onClick="hideform()" class="close" >X</a> </div>
  <!--tellafriend #end  -->
</form>
<script>
 function check_frm()
 {
	if(document.getElementById('frnd_yourname').value == '')
	{
		alert("<?php _e('Please enter '.YOUR_NAME_TEXT);?>");
		document.getElementById('frnd_yourname').focus();
		return false;
	}
	if(document.getElementById('frnd_youremail').value == '')
	{
		alert("<?php _e('Please enter '.YOUR_EMAIL_ADDRESS_TEXT);?>");
		document.getElementById('frnd_youremail').focus();
		return false;
	}
	if(document.getElementById('frnd_name').value == '')
	{
		alert("<?php _e('Please enter '.FRIEND_NAME_TEXT);?>");
		document.getElementById('frnd_name').focus();
		return false;
	}
	if(document.getElementById('frnd_email').value == '')
	{
		alert("<?php _e('Please enter '.EMAIL_ADDRESS_TEXT);?>");
		document.getElementById('frnd_email').focus();
		return false;
	}
	if(document.getElementById('frnd_subject').value == '')
	{
		alert("<?php _e('Please enter '.SUBJECT_TEXT);?>");
		document.getElementById('frnd_subject').focus();
		return false;
	}
	return true;
 }
 function hideform()
 {
 	window.parent.document.getElementById('infoBacking').style.display = 'none';
	window.parent.document.getElementById('info').style.display = 'none';
 }
</script>
<!-- <iframe id="tellafriend_iframe" name="tellafriend_iframe" style="border:0; height:0;"></iframe>-->
