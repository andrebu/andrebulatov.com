<?php
global $options;
foreach ($options as $value) {
		global $$value['id'];
        if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
<a href="<?php echo "$pt_ad_two_link"; ?>"><img src="<?php echo "$pt_ad_two"; ?>" alt="" border="0"  class="advt_spacer" /></a>
 <a href="<?php echo "$pt_ad_three_link"; ?>"><img src="<?php echo "$pt_ad_three"; ?>" alt="" border="0"  class="advt_spacer" /></a>
 <a href="<?php echo "$pt_ad_four_link"; ?>"><img src="<?php echo "$pt_ad_four"; ?>" alt="" border="0"  class="advt_spacer" /></a>

 