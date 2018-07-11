<?php
function general_options() {
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
$cs_color_scheme = "";
$cs_style_sheet = "";
	$cs_gs_color_style = get_option( "cs_gs_color_style" );
		if ( $cs_gs_color_style <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_color_style);
				$cs_color_scheme = $sxe->cs_color_scheme;
				$cs_style_sheet = $sxe->cs_style_sheet;
		}
	$cs_gs_logo = get_option( "cs_gs_logo" );
		if ( $cs_gs_logo <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_logo);
				$cs_logo = $sxe->cs_logo;
				$cs_width = $sxe->cs_width;
				$cs_height = $sxe->cs_height;
		}
					if ( $cs_width == "" ) $cs_width = 1;
					if ( $cs_height == "" ) $cs_height = 1;
	$cs_gs_header_script = get_option( "cs_gs_header_script" );
		if ( $cs_gs_header_script <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_header_script);
				$cs_header_code = $sxe->cs_header_code;
				$cs_fav_icon = $sxe->cs_fav_icon;
		}
	$cs_gs_footer_settings = get_option( "cs_gs_footer_settings" );
		if ( $cs_gs_footer_settings <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_footer_settings);
				$cs_footer_logo = $sxe->cs_footer_logo;
				$cs_copyright = $sxe->cs_copyright;
				$cs_powered_by = $sxe->cs_powered_by;
				$cs_powered_icon = $sxe->cs_powered_icon;
				$cs_analytics = $sxe->cs_analytics;
				$cs_footer_contact = $sxe->cs_footer_contact;
		}
	$cs_gs_google_recaptcha_keys = get_option( "cs_gs_google_recaptcha_keys" );
		$re_captcha = "";
		$cs_public_key = "";
		$cs_private_key = "";
			if ( $cs_gs_google_recaptcha_keys <> "" ) {
				$sxe = new SimpleXMLElement($cs_gs_google_recaptcha_keys);
					$re_captcha = $sxe->re_captcha;
					$cs_public_key = $sxe->cs_public_key;
					$cs_private_key = $sxe->cs_private_key;
			}
	$cs_gs_responsive = get_option( "cs_gs_responsive" );
		$responsive = "";
			if ( $cs_gs_responsive <> "" ) {
				$responsive = $cs_gs_responsive;
			}
?>

<div class="theme-wrap fullwidth">


	<?php include("theme_leftnav.php");?>
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">General Settings</h4>
            
            <div class="clear"></div>
        </div>

        <!-- Header End -->
        <script type="text/javascript">
$(function() {
	$( "#width-slider" ).slider({
		range: "min",
		value: <?php echo $cs_width;?>,
		min: 1,
		max: 400,
		slide: function( event, ui ) {
		$( "#width-value" ).val( ui.value);
   		}
  	});
  	$( "#width-value" ).val($( "#width-slider" ).slider( "value" ));
});
$(function() {
	$( "#height-slider" ).slider({
		range: "min",
		value: <?php echo $cs_height;?>,
		min: 1,
		max: 400,
		slide: function( event, ui ) {
		$( "#height-value" ).val( ui.value);
   		}
  	});
  	$( "#height-value" ).val($( "#height-slider" ).slider( "value" ));
});
				
			function gs_tab(id){
				$("#gs_tab_save"+id).hide();
				$("#gs_tab_loading"+id).show('');
				$.ajax({
					type:'POST', 
					url: '<?php echo get_template_directory_uri()?>/include/general_options_save.php', 
					data:$('#frm'+id).serialize(), 
					success: function(response) {
						//$('#frm_slide').get(0).reset();
						$(".form-msgs p").html(response);
						$(".form-msgs").show("");
						$("#gs_tab_save"+id).show('');
						$("#gs_tab_loading"+id).hide();
						slideout();
						//$('#frm_slide').find('.form_result').html(response);
					}
				});
			}
	
		$().ready(function() {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm1").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
		$().ready(function() {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm2").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
		$().ready(function() {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm3").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
		$().ready(function() {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm4").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
		$().ready(function() {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm5").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
			
		</script>
        <div class="tab-section">
            <div class="tab_menu_container">
                <ul id="tab_menu">  
                    <li><a href="#colorstyle" class="current" rel="tab-color"><span>Color and Style</span></a></li>
                    <li><a href="#logo" class="" rel="tab-logo"><span>Logo</span></a></li>
                    <li><a href="#headscript" class="" rel="tab-head-scripts"><span>Header Scripts</span></a></li>
                    <li><a href="#footersetting" class="" rel="tab-foot-setting"><span>Footer Settings</span></a></li>
                    <li><a href="#contact" class="" rel="tab-contact"><span>Re-Captcha Keys</span></a></li>
                    <li><a href="#responsive" class="" rel="tab-responsive"><span>Responsive</span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tab_container">
                <div class="tab_container_in">
					<div class='form-msgs' style="display:none"><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p></p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>
                    <!-- Color And Style Start -->
                    <div id="tab-color" class="tab-list">
                        <div class="elements">
                        	<form id="frm1" method="post" action="javascript:gs_tab(1)">
                                <div class="option-sec">
                                    <div class="opt-head">
                                        <h6>Color And Styles</h6>
                                        <p>Theme color scheme and styling setting.</p>
                                        <div id="gs_tab_loading1" class="ajax-loaders">
                                        	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                        </div>
                                    </div>
                                    <div class="opt-conts">
                                        <ul class="form-elements">
                                            <li class="to-label">
                                                <label>Select Stylesheet</label>
                                            </li>
                                            <li class="to-field">
                                                <select name="cs_style_sheet" onchange="hide_custom_color_scheme(this.value)">
                                                    <option value="">Default Color Scheme</option>
                                                    <?php 
                                                    foreach (glob(TEMPLATEPATH."/css/custom_styles/*.css") as $filename) {
                                                    //echo "$filename size " . filesize($filename) . "\n";
                                                    $vals = str_replace(TEMPLATEPATH."/css/custom_styles/","",$filename);
                                                    $vals = str_replace(".css","",$vals);
                                                    ?>
                                                    <option value="<?php echo $vals;?>" <?php if ($cs_style_sheet==$vals){echo "selected";}?> ><?php echo ucfirst($vals);?></option>
                                                    <?php } ?>
                                                    <option value="custom" <?php if ($cs_style_sheet=="custom"){echo "selected";}?> > -- Custom Color Scheme -- </option>
                                                </select>
                                            </li>
                                            <li class="to-desc">
                                                <p>
                                                    Please select stylesheet(color scheme) from dropdown.
                                                </p>
                                            </li>
                                        </ul>
                                        <ul class="form-elements" id="cs_color_scheme" <?php if($cs_style_sheet<>"custom")echo 'style="display:none"'?> >
                                            <li class="to-label">
                                                <label>Color Scheme</label>
                                            </li>
                                            <li class="to-field">
                                                <input type="text" name="cs_color_scheme" value="<?php echo $cs_color_scheme?>" class="color-picker" size="7" />
                                            </li>
                                            <li class="to-desc">
                                                <p>
                                                    Pick a custom color for Scheme of the theme e.g. #697e09
                                                </p>
                                            </li>
                                        </ul>
                                        <ul class="form-elements noborder">
                                            <li class="to-label">
                                                
                                            </li>
                                            <li class="to-field">
                                            	<input type="hidden" name="tab" value="color_style" />
                                                <input id="gs_tab_save1" class="submit butnthree" type="submit" value="Save"/>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Color And Style End -->
                    <!-- Logo Tabs -->
                    <div id="tab-logo" class="tab-list">
                        <form id="frm2" method="post" action="javascript:gs_tab(2)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Logo Settings</h6>
                                    <p>Add your company logo adjust image Width, Height.</p>
                                    <div id="gs_tab_loading2" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Upload Logo</label>
                                        </li>
                                        <li class="to-field">
                                    		<input id="cs_logo" name="cs_logo" value="<?php echo $cs_logo?>" type="text" class="{validate:{accept:'jpg|jpeg|gif|png|bmp'}}" size="36" />
                                            <input id="cs_log" name="cs_logo" type="button" class="uploadfile left" value="Browse"/>
                                        </li>
                                        <li class="to-desc">
                                            <div class="logo-thumb">
                                                <img id="cs_logo_img" width="<?php echo $cs_width?>" height="<?php echo $cs_height?>" src="<?php echo $cs_logo?>" />
                                                <a href="javascript:remove_logo()" class="closethumb">&nbsp;</a>
                                            </div>
                                        </li>
                                    </ul>	
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Width</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="slide-range">
                                                <div class="slidebar">
                                                    <div id="width-slider"></div>
                                                </div>
                                            </div>
                                            <div class="valueinput">
                                                <input type="text" name="cs_width" id="width-value" value="<?php echo $cs_width?>" style="border:0; color:#f6931f; font-weight:bold;" />
                                                <span>px</span>
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Please scroll left to right to increase the width of logo, Right to left decrease the logo width.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Height</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="slide-range">
                                                <div class="slidebar">
                                                    <div id="height-slider"></div>
                                                </div>
                                            </div>
                                            <div class="valueinput">
                                                <input type="text" name="cs_height" id="height-value" value="<?php echo $cs_height?>" style="border:0; color:#f6931f; font-weight:bold;" />
                                                <span>px</span>
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>
												Please scroll left to right to increase the Height of Logo, Right to left decrease the logo Height.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                            
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="logo" />
                                            <input id="gs_tab_save2" class="submit butnthree" type="submit" value="Save" onclick="update_logo()" />
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Logo Tabs End -->
                    <!-- Header Script -->
                    <div id="tab-head-scripts" class="tab-list">
                        <form id="frm3" method="post" action="javascript:gs_tab(3)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Header Scripts</h6>
                                    <p>Paste your Html or Css Code here.</p>
                                    <div id="gs_tab_loading3" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>FAV Icon</label>
                                        </li>
                                        <li class="to-field">
                                        	<input id="cs_fav_icon" name="cs_fav_icon" value="<?php echo $cs_fav_icon?>" type="text" size="36" class="{validate:{accept:'ico'}}" />
                                            <input id="cs_fav_icon" name="cs_fav_icon" type="button" class="uploadfile left" value="Browse" />
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                            	Browse a small fav icon. only ico format allowed.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Header Code</label>
                                        </li>
                                        <li class="to-field">
                                            <textarea rows="" cols="" name="cs_header_code"><?php echo $cs_header_code?></textarea>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Paste your Html or Css Code here.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                            
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="header_script" />
                                            <input id="gs_tab_save3" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Header Script End -->
                    <!-- Footer Settings -->
                    <div id="tab-foot-setting" class="tab-list">
                        <form id="frm4" method="post" action="javascript:gs_tab(4)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Footer Settings</h6>
                                    <p>Add footer setting detail.</p>
                                    <div id="gs_tab_loading4" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Footer Logo</label>
                                        </li>
                                        <li class="to-field">
                                        	<input id="cs_footer_logo" name="cs_footer_logo" value="<?php echo $cs_footer_logo?>" type="text" size="36" class="{validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
                                            <input id="cs_footer_log" name="cs_footer_logo" type="button" class="uploadfile left" value="Browse" />
                                        </li>
                                        <li class="to-desc">
                                            <p>Browse a small logo for footer only .JPG, JPEG, PNG, GIF .BMP allowed.</p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Custom Copyright</label>
                                        </li>
                                        <li class="to-field">
                                            <textarea rows="2" cols="4" name="cs_copyright"><?php echo $cs_copyright?></textarea>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Write Custom Copyright text.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Powered By Text</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="cs_powered_by" value="<?php echo $cs_powered_by?>" />
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Please enter powered by text.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Powered By Icon</label>
                                        </li>
                                        <li class="to-field">
                                            <input id="cs_powered_icon" name="cs_powered_icon" value="<?php echo $cs_powered_icon?>" type="text" size="36" class="{validate:{accept:'jpg|jpeg|gif|png|bmp'}}"/>
                                            <input id="cs_powered_ico" name="cs_powered_icon" type="button" class="uploadfile left" value="Browse"/>
                                        </li>
                                        <li class="to-desc">
                                            <p>
	                                            Please upload or paste link of image to use in powered by Icon only .JPG, JPEG, PNG, GIF .BMP allowed.
                                            </p>
                                        </li>                                                 
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Footer Contact Area</label>
                                        </li>
                                        <li class="to-field">
                                            <textarea rows="" cols="" name="cs_footer_contact"><?php echo $cs_footer_contact?></textarea>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Paste the plain text or html for Footer Contact Area
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Analytics Code</label>
                                        </li>
                                        <li class="to-field">
                                            <textarea rows="" cols="" name="cs_analytics"><?php echo $cs_analytics?></textarea>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Paste your Google Analytics (or other) tracking code here.<br /> This will be added into the footer template of your theme.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                            
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="footer_settings" />
                                            <input id="gs_tab_save4" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Footer Settings End -->
                    <!-- Contact Setting -->
                    <div id="tab-contact" class="tab-list"> 
                        <form id="frm5" method="post" action="javascript:gs_tab(5)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Google Re-Captcha Keys Setting</h6>
                                    <p>Please enter your Google Re-Captcha Keys (Public Key and Private Key).</p>
                                    <div id="gs_tab_loading5" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                	<ul class="form-elements">
                                        <li class="to-label">
                                            <label>Re-Captcha</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
                                            	<input type="checkbox" name="re_captcha" class="styled" <?php if($re_captcha=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>Make the Re-Captcha On/Off</p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Re-Captcha Public Key</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="cs_public_key" value="<?php echo $cs_public_key?>">
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Paste Re-Captcha Public Key Example: AIzaSyBL8zFissh_mJ6QVax****************.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Re-Captcha Private Key</label>
                                        </li>
                                        <li class="to-field">
                                            <input type="text" name="cs_private_key" value="<?php echo $cs_private_key?>">
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Paste Re-Captcha Private Key Example: AIzaSyBL8zFissh_mJ6QVax****************.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                            
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="google_recaptcha_keys" />
                                            <input id="gs_tab_save5" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Contact Setting End -->
                    
                    <div id="tab-responsive" class="tab-list"> 
                        <form id="frm6" method="post" action="javascript:gs_tab(6)">
                            <div class="option-sec">
                                <div class="opt-head">
                                    <h6>Responsive Setting</h6>
                                    <p>Set the responsive On/Off</p>
                                    <div id="gs_tab_loading5" class="ajax-loaders">
                                    	<img src="<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif" />
                                    </div>
                                </div>
                                <div class="opt-conts">
                                	<ul class="form-elements">
                                        <li class="to-label">
                                            <label>On / Off</label>
                                        </li>
                                        <li class="to-field">
                                            <div class="on-off">
                                            	<input type="checkbox" name="responsive" class="styled" <?php if($responsive=="on") echo "checked" ?> />
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>Set the responsive On/Off</p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                        </li>
                                        <li class="to-field">
                                           	<input type="hidden" name="tab" value="tab_responsive" />
                                            <input id="gs_tab_save6" class="submit butnthree" type="submit" value="Save"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
    <!-- Right Column End -->
</div>



<?php
}
?>