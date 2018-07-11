<?php 
global $smof_data;
if(!empty($smof_data['color_link'])){ 
			
$color2=$smof_data['color_link'];
			echo '<style>

::-webkit-scrollbar-thumb {background: '.$color2.';-webkit-box-shadow: inset 1px 1px 2px rgba(155, 155, 155, 0.4);}

.normal_title, .normal_title a, .wtitle{
	color: '.$color2.';
}
			';
				echo '</style>';  			
		}?>


