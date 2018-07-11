
<?php
require('../../../../wp-blog-header.php');
$root = "../wp-content/themes/bigbangwp";  
$name = "list";
$submit = "Insert list wrapper";
?>

<div id="shortcodes_<?php echo $name; ?>-form">

<table id="shortcodes_<?php echo $name; ?>-table" class="form-table">
	
    <tr><?php $field_ = "Style"; $field = "style"; $description = "List style"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="check-list">Check list</option>
          <option value="star-list">Star list</option> 
          <option value="arrow-list">Arrow list</option>
          <option value="colored-counter-list">Colored counter list</option>
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