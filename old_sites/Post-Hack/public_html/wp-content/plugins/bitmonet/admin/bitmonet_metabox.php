<?php if (!defined('ABSPATH')) die(); ?>

<select name="bitmonet_status">
  <option value="0"<?php echo $status == 0?' selected':''; ?>><?php _e('Enabled', self::ld); ?></option>
  <option value="1"<?php echo $status == 1?' selected':''; ?>><?php _e('Disabled', self::ld); ?></option>
</select>