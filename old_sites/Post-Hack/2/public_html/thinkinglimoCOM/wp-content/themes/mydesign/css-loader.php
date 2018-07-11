<?php 
global $smof_data;
if(!empty($smof_data['color_base'])){ 
			
$color=$smof_data['color_base'];
			echo '<style>

#header, .menu-select{ background: '.$color.'; }

#menu a {
	border-bottom: 6px solid '.$color.';
    }
.menubtn{
	border-bottom: 7px solid '.$color.';
}

			';
				echo '</style>';  			
		}?>


