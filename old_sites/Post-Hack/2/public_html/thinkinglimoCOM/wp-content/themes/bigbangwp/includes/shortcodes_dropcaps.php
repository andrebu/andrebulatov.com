
<?php
require('../../../../wp-blog-header.php');
$root = "../wp-content/themes/bigbangwp";  
$name = "dropcaps";
$submit = "Insert dropcap";
?>

<div id="shortcodes_<?php echo $name; ?>-form">

<table id="shortcodes_<?php echo $name; ?>-table" class="form-table">

    <tr><?php $field_ = "Letter"; $field = "letter"; $default = "A"; $description = "Letter to be dropcapped"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:50px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>    
    </tr>
	
    <tr><?php $field_ = "Style"; $field = "style"; $description = "Dropcap style"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="dropcap1">Big letter</option>
          <option value="dropcap2">Inverse in square</option> 
          <option value="dropcap3">Inverse in circle</option>
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