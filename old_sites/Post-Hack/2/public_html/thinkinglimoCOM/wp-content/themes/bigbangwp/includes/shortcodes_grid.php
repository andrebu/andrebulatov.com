
<?php
require('../../../../wp-blog-header.php');
$root = "../wp-content/themes/bigbangwp";  
$name = "grid";
$submit = "Insert grid section";
?>

<div id="shortcodes_<?php echo $name; ?>-form">
<script language="JavaScript" type="text/javascript">
jQuery(document).ready(function($){  	
});
</script>

<table id="shortcodes_<?php echo $name; ?>-table" class="form-table">
    
    <tr><?php $field_ = "Number of columns"; $field = "grid_columns"; $description = "How many columns you want to show"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">

    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>


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