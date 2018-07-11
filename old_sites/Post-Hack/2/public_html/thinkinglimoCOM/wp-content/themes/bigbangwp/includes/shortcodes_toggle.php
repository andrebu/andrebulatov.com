
<?php
require('../../../../wp-blog-header.php');
$root = "../wp-content/themes/bigbangwp";  
$name = "toggle";
$submit = "Insert toggle element";
?>

<div id="shortcodes_<?php echo $name; ?>-form">

<table id="shortcodes_<?php echo $name; ?>-table" class="form-table">

    <tr><?php $field_ = "Caption"; $field = "caption"; $default = "Developer"; $description = "Second line below the image"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field_; ?>" value="<?php echo $default; ?>" /><br />
        <small><?php echo $description; ?></small></td>
    </tr>
    
    <tr><?php $field_ = "Text"; $field = "text"; $default = "Dummy text"; $description = "Text to be highlighted"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><textarea style="width:400px" name="<?php echo $field; ?>" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $default; ?></textarea>
        <br />
        <small><?php echo $description; ?></small></td>
    </tr>
    
    <tr><?php $field_ = "Type"; $field = "collapsable"; $description = "Toggle or Accordion"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="no">Toggle</option>
          <option value="yes">Accordion</option> 
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