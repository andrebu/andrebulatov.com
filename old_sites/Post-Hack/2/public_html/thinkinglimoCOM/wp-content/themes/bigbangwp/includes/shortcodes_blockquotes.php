
<?php
require('../../../../wp-blog-header.php');
$root = "../wp-content/themes/bigbangwp"; 
$name = "blockquotes";
$submit = "Insert blockquote";
?>

<div id="shortcodes_<?php echo $name; ?>-form">

<table id="shortcodes_<?php echo $name; ?>-table" class="form-table">

    
    <tr><?php $field_ = "Text"; $field = "text"; $default = "Dummy text"; $description = "Text to be highlighted"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><textarea style="width:400px" name="<?php echo $field; ?>" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $default; ?></textarea>
        <br />
        <small><?php echo $description; ?></small></td>
    </tr>
    
	
    <tr><?php $field_ = "Align"; $field = "align"; $description = "Blockquote alignment"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="">Left</option>
          <option value="right">Right</option> 
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