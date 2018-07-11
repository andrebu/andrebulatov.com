
<?php
$root = "../wp-content/themes/bigbangwp";
$root_ = "wp-content/themes/bigbangwp";
$name = "icon_boxes";
$submit = "Insert row with 3/4 icon boxes";
?>

<div id="shortcodes_<?php echo $name; ?>-form">
<script language="JavaScript" type="text/javascript">
jQuery(document).ready(function($){  
	
	field_id = "#shortcodes_icon_boxes-icon_0";
	value = "../" + $(field_id).attr('value'); 

	$("#td_icon_0 img").attr("src", value);
	$(field_id).change(function()
	{
	   value = "../" + $(this).attr('value');
	   $("#td_icon_0 img").attr("src", value);
		
	});
	
	field_id = "#shortcodes_icon_boxes-icon_1";
	value = "../" + $(field_id).attr('value'); 

	$("#td_icon_1 img").attr("src", value);
	$(field_id).change(function()
	{
	   value = "../" + $(this).attr('value');
	   $("#td_icon_1 img").attr("src", value);
		
	});
	
	field_id = "#shortcodes_icon_boxes-icon_2";
	value = "../" + $(field_id).attr('value'); 

	$("#td_icon_2 img").attr("src", value);
	$(field_id).change(function()
	{
	   value = "../" + $(this).attr('value');
	   $("#td_icon_2 img").attr("src", value);
		
	});
	
	field_id = "#shortcodes_icon_boxes-icon_3";
	value = "../" + $(field_id).attr('value'); 

	$("#td_icon_3 img").attr("src", value);
	$(field_id).change(function()
	{
	   value = "../" + $(this).attr('value');
	   $("#td_icon_3 img").attr("src", value);
		
	});
	
	
	
});
</script>

<img src="<?php echo $root; ?>/includes/icon_boxes.jpg" width="640"/>
<table id="shortcodes_<?php echo $name; ?>-table" class="form-table">

    <tr><?php $field_ = "Caption 1"; $field = "caption_0"; $default = "Branding"; $description = ""; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>         
    </tr>
    
    <tr><?php $field_ = "Icon 1"; $field = "icon_0"; $description = "Icon below the title"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value=""></option>
          <?php
          $icons_urls = glob("../images/icons/*.*");
          foreach ($icons_urls as $icon_url)
          {
              $icon_url = $root_.substr($icon_url, 2);
              $icon_url_ = substr($icon_url, strpos($icon_url, "/icons/") + 7);
          ?>
            <option value="<?php echo $icon_url; ?>"><?php echo $icon_url_; ?></option>
          <?php
          }
          ?>
          </select>
<div id="td_icon_0"><img src="" /></div>
          <br />
      	  <small><?php echo $description; ?></small>
	  	   </td>
    </tr>
	
    <tr><?php $field_ = "URL 1"; $field = "url_0"; $default = "http://www.brankic1979.com"; $description = ""; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>         
    </tr>
    
    <tr><?php $field_ = "Target 1"; $field = "target_0"; $description = "Open in same window/tab or new one"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="_self">Same window/tab</option>
          <option value="_blank">New window/tab</option> 
          </select>
          <br />
            <small><?php echo $description; ?></small>
             </td>
    </tr>
    
	<tr class="bottom_border"><?php $field_ = "About 1"; $field = "about_0"; $default = "Lorem ipsum dolor set amet"; $description = "Block of text"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><textarea style="width:400px" name="<?php echo $field; ?>" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $default; ?></textarea>
        <br />
        <small><?php echo $description; ?></small></td>
    </tr>
    
    
    
    <tr><?php $field_ = "Caption 2"; $field = "caption_1"; $default = "Logo design"; $description = ""; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>
         
    </tr>	
	
	<tr><?php $field_ = "Icon 2"; $field = "icon_1"; $description = "Icon below the title"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value=""></option>
          <?php
          $icons_urls = glob("../images/icons/*.*");
          foreach ($icons_urls as $icon_url)
          {
              $icon_url = $root_.substr($icon_url, 2);
              $icon_url_ = substr($icon_url, strpos($icon_url, "/icons/") + 7);
          ?>
            <option value="<?php echo $icon_url; ?>"><?php echo $icon_url_; ?></option>
          <?php
          }
          ?>
          </select>
<div id="td_icon_1"><img src="" /></div>
          <br />
      	  <small><?php echo $description; ?></small>
	  	   </td>
    </tr>
    
    <tr><?php $field_ = "URL 2"; $field = "url_1"; $default = "http://www.brankic1979.com"; $description = ""; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>         
    </tr>
    
    <tr><?php $field_ = "Target 2"; $field = "target_1"; $description = "Open in same window/tab or new one"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="_self">Same window/tab</option>
          <option value="_blank">New window/tab</option> 
          </select>
          <br />
            <small><?php echo $description; ?></small>
             </td>
    </tr>

	<tr class="bottom_border"><?php $field_ = "About 2"; $field = "about_1"; $default = "Lorem ipsum dolor set amet"; $description = "Block of text"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><textarea style="width:400px" name="<?php echo $field; ?>" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $default; ?></textarea>
        <br />
        <small><?php echo $description; ?></small></td>
    </tr>
    
    
    
    
    <tr><?php $field_ = "Caption 3"; $field = "caption_2"; $default = "Print"; $description = ""; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>
         
    </tr>	
	
	<tr><?php $field_ = "Icon 3"; $field = "icon_2"; $description = "Icon below the title"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value=""></option>
          <?php
          $icons_urls = glob("../images/icons/*.*");
          foreach ($icons_urls as $icon_url)
          {
              $icon_url = $root_.substr($icon_url, 2);
              $icon_url_ = substr($icon_url, strpos($icon_url, "/icons/") + 7);
          ?>
            <option value="<?php echo $icon_url; ?>"><?php echo $icon_url_; ?></option>
          <?php
          }
          ?>
          </select>
<div id="td_icon_2"><img src="" /></div>
          <br />
      	  <small><?php echo $description; ?></small>
	  	   </td>
    </tr>
    
    <tr><?php $field_ = "URL 3"; $field = "url_2"; $default = "http://www.brankic1979.com"; $description = ""; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>         
    </tr>
    
    <tr><?php $field_ = "Target 3"; $field = "target_2"; $description = "Open in same window/tab or new one"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="_self">Same window/tab</option>
          <option value="_blank">New window/tab</option> 
          </select>
          <br />
            <small><?php echo $description; ?></small>
             </td>
    </tr>
	
	<tr class="bottom_border"><?php $field_ = "About 3"; $field = "about_2"; $default = "Lorem ipsum dolor set amet"; $description = "Block of text"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><textarea style="width:400px" name="<?php echo $field; ?>" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $default; ?></textarea>
        <br />
        <small><?php echo $description; ?></small></td>
    </tr>
    
    
    
	
    <tr><?php $field_ = "Caption 4"; $field = "caption_3"; $default = ""; $description = ""; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>
         
    </tr>
    	
	<tr><?php $field_ = "Icon 4"; $field = "icon_3"; $description = "Icon below the title"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value=""></option>
          <?php
          $icons_urls = glob("../images/icons/*.*");
          foreach ($icons_urls as $icon_url)
          {
              $icon_url = $root_.substr($icon_url, 2);
              $icon_url_ = substr($icon_url, strpos($icon_url, "/icons/") + 7);
          ?>
            <option value="<?php echo $icon_url; ?>"><?php echo $icon_url_; ?></option>
          <?php
          }
          ?>
          </select>
<div id="td_icon_3"><img src="" /></div>
          <br />
      	  <small><?php echo $description; ?></small>
	  	   </td>
    </tr>
    
    <tr><?php $field_ = "URL 4"; $field = "url_3"; $default = ""; $description = ""; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>         
    </tr>
    
    <tr><?php $field_ = "Target 4"; $field = "target_3"; $description = "Open in same window/tab or new one"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="_self">Same window/tab</option>
          <option value="_blank">New window/tab</option> 
          </select>
          <br />
            <small><?php echo $description; ?></small>
             </td>
    </tr>
	

	
	<tr><?php $field_ = "About 4"; $field = "about_3"; $default = ""; $description = "Block of text"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><textarea style="width:400px" name="<?php echo $field; ?>" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $default; ?></textarea>
        <br />
        <small><?php echo $description; ?></small></td>
    </tr>
	

    
    


    

                      
	</table>
<p class="submit">
	<input type="button" id="shortcodes_<?php echo $name; ?>-submit" class="button-primary" value="<?php echo $submit; ?>" name="submit" />
</p>
</div>