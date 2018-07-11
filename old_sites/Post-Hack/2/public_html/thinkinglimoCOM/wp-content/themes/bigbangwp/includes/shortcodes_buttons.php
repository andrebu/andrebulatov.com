
<?php
require('../../../../wp-blog-header.php');
$root = "../wp-content/themes/bigbangwp"; 
$name = "buttons";
$submit = "Insert button";
?>

<div id="shortcodes_<?php echo $name; ?>-form">


<img src="<?php echo $root; ?>/includes/buttons.jpg"/>
<table id="shortcodes_<?php echo $name; ?>-table" class="form-table">

    <tr><?php $field_ = "Text on button"; $field = "text"; $default = "Button"; $description = "Button value"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:200px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>    
    </tr>
    
    <tr><?php $field_ = "URL"; $field = "url"; $default = "http://www.brankic1979.com"; $description = "URL of the button"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td><input style="width:400px" type="text" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $default; ?>" /><br><br>
        <small><?php echo $description; ?></small>
        </td>    
    </tr>
    
    <tr><?php $field_ = "Target"; $field = "target"; $description = "Open in same window/tab or new one"; ?>
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
    
    <tr><?php $field_ = "Size"; $field = "size"; $description = "Button size"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="small">Small</option>
          <option value="medium">Medium</option> 
          <option value="large">Large</option> 
          </select>
          <br />
      	  <small><?php echo $description; ?></small>
	  	   </td>
    </tr>
	
    <tr><?php $field_ = "Style"; $field = "style"; $description = "Button style"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="rounded">Rounded</option>
          <option value="">Rectangle</option> 
          </select>
          <br />
            <small><?php echo $description; ?></small>
             </td>
    </tr>
	
    <tr><?php $field_ = "Color"; $field = "color"; $description = "Button color"; ?>
        <th><label for="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>"><?php echo $field_; ?></label></th>
        <td>
          <select style="float:left" id="shortcodes_<?php echo $name; ?>-<?php echo $field; ?>" name="<?php echo $field; ?>">
          <option value="grey">Grey</option>
          <option value="yellow">Yellow</option>
          <option value="orange">Orange</option>
          <option value="green">Green</option>
          <option value="tealgreen">Teal Green</option>
          <option value="blue">Blue</option> 
          <option value="navyblue">Navy Blue</option>
          <option value="purple">Purple</option> 
          <option value="magenta">Magenta</option>
          <option value="pink">Pink</option> 
          <option value="red">Red</option>
          <option value="cream">Cream</option>  
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