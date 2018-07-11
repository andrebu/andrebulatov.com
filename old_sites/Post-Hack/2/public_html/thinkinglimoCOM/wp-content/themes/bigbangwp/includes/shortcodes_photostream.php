
<?php
require('../../../../wp-blog-header.php');
$root = "../wp-content/themes/bigbangwp";  
$name = "photostream";
$submit = "Insert photostream";
?>

<div id="shortcodes_<?php echo $name; ?>-form">

<table id="shortcodes_<?php echo $name; ?>-table" class="form-table">

    <tr><?php $field_ = "User"; $field = "user"; $default = "brankic1979"; $description = "Username"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:200px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>    
    </tr>
    
        <tr><?php $field_ = "Limit"; $field = "limit"; $default = "10"; $description = "Number of images to be shown"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:50px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>    
    </tr>

    
    <tr><?php $field_ = "Social Network"; $field = "social_network"; $description = "Select social network"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
            <option value="instagram">Instagram</option>
            <option value="dribbble">Dribbble</option>
            <option value="flickr">Flickr</option>
            <option value="pinterest">Pinterest</option>
          </select>
          <br />
            <small><?php echo $description; ?></small>
        </td>
    </tr>
    
    <tr><?php $field_ = "Layout"; $field = "layout"; $description = "Small (widget style) or full page"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
            <option value="small">Small (widget style)</option>
            <option value="2">2 columns</option>
            <option value="3">3 columns</option>
            <option value="4">4 columns</option>
          </select>
          <br />
            <small><?php echo $description; ?></small>
        </td>
    </tr>
    
    <tr><?php $field_ = "Shape"; $field = "shape"; $description = "Shaped or clear column layout"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
            <option value="none">None</option>
            <option value="triangle">Triangle</option>
            <option value="hexagon">Hexagon</option>
            <option value="circle">Circle</option>
          </select>
          <br />
            <small><?php echo $description; ?></small>
        </td>
    </tr>
    

                      
	</table>
<p class="submit">
	<input type="button" id="shortcodes_<?php echo $name; ?>-submit" class="button-primary" value="<?php echo $submit; ?>" name="submit" />
</p>
</div>