<?php
function newsletter_manage() {
	global $wpdb;
		$show_newsletter = '';
		$show_newsletter = get_option("cs_show_newsletter");
?>
<div class="theme-wrap fullwidth">
	<?php include("theme_leftnav.php");?>
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">Newsletter Management</h4>
            
            <div class="clear"></div>
        </div>
        <!-- Header End -->
        <!-- Content Section Start -->
    	<div class="elements-in">
			<div class='form-msgs' style="display:none"><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p></p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>
        	<div class="option-sec">
                <div class="opt-head">
                    <h6>Newsletter</h6>
                    <p>Switch it on if you want to show Newsletter</p>
                </div>
                <div class="opt-conts">
                    	<ul class="form-elements">
                            <li class="to-label">
                                <label>Download Newsletter</label>
                            </li>
                            <li class="to-field">
                                <a href="<?php echo get_template_directory_uri(); ?>/include/newsletter_export.php" class="button">Download CSV</a>
                            </li>
                            <li class="to-desc">
                                <p>
                                    Downloaded All Newsletter Subscribers In CSV Format
                                </p>
                            </li>
                        </ul>
                        
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        
        <!-- Content Section End -->
    </div>
    <div class="clear"></div>
    <!-- Right Column End -->
</div>

<?php
}
?>