<?php
/*
Plugin Name: Visitor Stats  
Plugin URI: http://www.wpdownloadmanager.com/
Description: Real-time stats for your wordpress site.
Author: Shaon
Version: 1.5.0
Author URI: http://www.wpdownloadmanager.com/
*/
 
 function vsw_install(){
    global $wpdb;
    $rand = substr(str_shuffle("1234567890abcdefghijklmnopqrstuvwxyz"),0,12);
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');    
    update_option('siteid',$rand);      
     
}


 function vsw_widget(){     
     ?>
     <script type="text/javascript" src="http://widgets.amung.us/tab.js"></script>
     <script type="text/javascript">WAU_tab('<?php echo get_option('siteid'); ?>', '<?php echo get_option('vsw_pos'); ?>')</script>
     <?php
 }
 
 function vsw_options(){
     if($_POST){
         update_option('vsw_pos', $_POST['t']);
     }
      
?>


<!--//-->
<style type="text/css">
.options{}

.options p{ margin:2px 10px; padding:5px; font-family:Verdana, Geneva, sans-serif; font-size:14px}

.options label{ display: block; padding:7px 10px; width:200px}  


.optioncontainerL, .optioncontainerB, .optioncontainerR
{
	
-moz-border-radius: 5px;
border-radius: 5px;
margin:0 10px;
	
}

.optioncontainerL
{background:#FFFF99;}
	
	
.optioncontainerB
{background:#CCFFCC;}	
	
	
.optioncontainerR
{background:#99CCFF;}	

</style>
<div class="wrap">
<h2>Stats Widget Setup</h2>
Select the position of your screen you want to show the widget:<br/>

<form id="gencontent" method="post">
<table border="0" cellspacing="2" class="options">
  <tr>
    <td><img src="../wp-content/plugins/visitor-stats-widget/images/<?php echo get_option('vsw_pos','left-middle'); ?>.png" id="previewthumb" /></td>
    <td><img src="../wp-content/plugins/visitor-stats-widget/images/arrowcog.png" /></td>
    <td valign="top">
    
    
    <div class="optioncontainerL">
    <p>Left</p>
    <label><input type="radio" <?php echo get_option('vsw_pos')=='left-upper'?'checked=checked':''; ?> name="t" value="left-upper" /> Top</label>
    <label><input type="radio" <?php echo get_option('vsw_pos')=='left-middle'?'checked=checked':''; ?>  name="t" value="left-middle" checked="checked" /> Center</label>
    <label><input type="radio" <?php echo get_option('vsw_pos')=='left-lower'?'checked=checked':''; ?>  name="t" value="left-lower" /> Bottom</label>
    
    </div>
    
    </td>
    
    
    <td valign="top"> 
    <div class="optioncontainerB">
    <p>Bottom</p>
    <label><input type="radio" <?php echo get_option('vsw_pos')=='bottom-left'?'checked=checked':''; ?> name="t" value="bottom-left" /> Left</label>
    <label><input type="radio" <?php echo get_option('vsw_pos')=='bottom-center'?'checked=checked':''; ?> name="t" value="bottom-center" /> Center</label>
    <label><input type="radio" <?php echo get_option('vsw_pos')=='bottom-right'?'checked=checked':''; ?> name="t" value="bottom-right" /> Right</label>
    
    </div></td>
    
    
    <td valign="top"> 
    <div class="optioncontainerR">
    <p>Right</p>
    <label><input type="radio" <?php echo get_option('vsw_pos')=='right-upper'?'checked=checked':''; ?> name="t" value="right-upper" /> Top</label>
    <label><input type="radio" <?php echo get_option('vsw_pos')=='right-middle'?'checked=checked':''; ?> name="t" value="right-middle" /> Center</label>
    <label><input type="radio" <?php echo get_option('vsw_pos')=='right-lower'?'checked=checked':''; ?> name="t" value="right-lower" /> Bottom</label>
    
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;&nbsp;<input type="submit" value="Save Changes" class="button-primary" /></td>
  </tr>
</table>

</form>

<h2>My Other Plugins</h2>

<ul>
<li>
<img src="https://lh5.googleusercontent.com/-w_BqMviA28A/TfT93lUmhTI/AAAAAAAAAH8/snfSMhZXgKY/s800/download_manager.png" align="left" />
<h3>Download Manager</h3>
This plugin will help you to manage, track and control file downloads from your wordpress site. You can set password and set access level any of your downloadable files from your wordpress site. You can add/embed downloadable files anywhere in the post just pasting the embed code inside your post content.
<br/>
<br/>
<div style="font-weight: bold ;">
<a href="http://www.wpdownloadmanager.com/features/">Features</a> | <a href="http://www.wpdownloadmanager.com/download/">Download</a>
</div>
</li>
<li style="clear: both;"></li>
<li>
<img src="http://png-2.findicons.com/files/icons/2107/glossy_waxed_wood/128/wordpress_logo_square_webtreatsetc.png" style="margin-top: -15px;" align="left" />
<h3>WP Eden</h3>
Total collection of wp plugins and themes to make your site complete.<br/><br/>
<b><a href='http://www.wpeden.com'>Check here!</a></b>
</li>
<li style="clear: both;"></li>   
<li>

<img src="http://images-1.findicons.com/files/icons/2198/dark_glass/128/error.png" style="margin-top: -15px;" align="left" />
<h3>WP Quick Notice Bar</h3>
Highlight important contents of your site. Quick notice bar is the easiest way to highlight important contents on your site.<br/><br/>
<b><a href='http://quicknoticebar.com'>Check here!</a></b>
</li>
</ul>

 <script type="text/javascript">
 jQuery('#gencontent input[type=radio]').click(function(){
	 
	// alert();
	 
	 $img = jQuery(this).val();
	 $url = '../wp-content/plugins/visitor-stats-widget/images/';
	 
	 jQuery('#previewthumb').attr('src',$url+$img+'.png');
	 
	 
	 });
 </script>
</div>  
<?php     
 }
 
 function vsw_menu(){
    add_menu_page("Visitor Stats","Visitor Stats",'administrator','vsw','vsw_options');        
}

 add_action("admin_menu","vsw_menu");
 add_action("wp_head","vsw_widget");
 
 register_activation_hook(__FILE__,'vsw_install');

?>