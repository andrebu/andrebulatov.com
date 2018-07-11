
<?php
require('../../../../wp-blog-header.php');
$root = "../wp-content/themes/bigbangwp";  
$name = "team_member";
$submit = "Insert team member section";
?>

<div id="shortcodes_<?php echo $name; ?>-form">
<script language="JavaScript" type="text/javascript">
jQuery(document).ready(function($){  	
});
</script>
<img src="<?php echo $root; ?>/includes/team_member.jpg" width="200" class="demo_image"/>
<table id="shortcodes_<?php echo $name; ?>-table" class="form-table">

    <tr><?php $field = "member_name"; $field_ = "Name"; $default = "John Doe"; $description = "First line below the image"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br />
        <small><?php echo $description; ?></small>
		</td>
    </tr>
    
    <tr><?php $field = "member_position"; $field_ = "Position"; $default = "Developer"; $description = "First line below the name"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br />
        <small><?php echo $description; ?></small>
        </td>
    </tr>
    
    <tr><?php $field = "member_img_src"; $field_ = "IMG SRC"; $default = ""; $description = "Full SRC of the image (you can also insert image directly into HTML editor inside the shortcode"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" size="100"/><br />
        <small><?php echo $description; ?></small>
        </td>
    </tr>

    
    <tr><?php $field = "member_text"; $field_ = "About"; $default = "Seded ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam."; $description = "Some text about this member (you can edit this text in HTML editor"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><textarea style="width:400px" name="<?php echo $field; ?>" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $default; ?></textarea>
        <br />
        <small><?php echo $description; ?></small></td>
    </tr>
    
    <tr><?php $field_ = "Number of columns"; $field = "member_columns"; $description = "How many columns you want to show"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">

    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>

          </select>
          <br />
            <small><?php echo $description; ?></small>
             </td>
    </tr>
    
    <tr><?php $field = "member_social_list"; $field_ = "List of links (comma separated values)"; $default = "Twitter, http://twitter.com/brankic1979"; $description = "text, URL, text, URL, text, URL"; ?>
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