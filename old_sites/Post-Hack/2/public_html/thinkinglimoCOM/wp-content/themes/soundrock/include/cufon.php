<?php
function cufon() {
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
	
	$message = '';
	$message_upload = '';
	
	if ( isset($submit) ) {
		$heading_font = get_option("heading_font");
		$body_font = get_option("body_font");
			update_option( "heading_font", $h1_font );
			update_option( "body_font", $b_font );
			$message = "<div class='form-msgs'><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p>Selected Heading and Body Fonts Applied</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
			$message .= "<script>slideout();</script>";
	}
	if ( isset($submit_upload) ) {
		//$file_name = $_FILES['uploadedfile']['name'];
		$target_path = get_template_directory()."/cufon/".trim($title).".js";
		if ( file_exists($target_path) ) {
			$message_upload = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>Cufon Already Exist</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
			$message_upload .= "<script>slideout();</script>";
		}
		else {
			if ( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path) ) {
				//echo "Allah Is The Greatest <br />";
				chmod($target_path,0777);
				$message_upload = "<div class='form-msgs'><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p>Cufon Uploaded</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
				$message_upload .= "<script>slideout();</script>";
			}
			else {
				$message_upload = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>Cufon Not Uploaded</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
				$message_upload .= "<script>slideout();</script>";
			}
		}
	}

	$heading_font = get_option("heading_font");
	$body_font = get_option("body_font");
	$fonts = get_google_fonts();
?>
<div class="theme-wrap fullwidth">


	<?php include("theme_leftnav.php");?>
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">Font Settings</h4>
            
            <div class="clear"></div>
        </div>
        <!-- Header End -->
        <!-- Content Section Start -->
    	<div class="tab-section">
            <div class="tab_menu_container">
                <ul id="tab_menu">  
                    <li><a href="#choosefonts" class="current" rel="tab-choosefont"><span>Choose Fonts</span></a></li>
                    <li><a href="#cufonupload" class="" rel="tab-uploadcufon"><span>Cufon Upload</span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tab_container">
                <div class="tab_container_in">
					<?php echo $message;?>
					<?php echo $message_upload;?>
                    <!-- Choose Fonts Start -->
                    <div id="tab-choosefont" class="tab-list">
                        <div class="option-sec">
                        	<form method="post" action="">
                            	<div class="opt-head">
                                    <h6>Choose Fonts</h6>
                                    <p>Theme Heading font(H1,H2,H3,H4,H5,H6) and Body font setting.</p>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Heading Font</label>
                                        </li>
                                        <li class="to-field">
                                            <select name="h1_font">
                                            	<option value="0">Default Font</option>
                                                <optgroup label="Cufons"></optgroup>
                                                    <?php
                                                        foreach (glob(get_template_directory()."/cufon/*.js") as $filename) {
                                                            //echo "$filename size " . filesize($filename) . "\n";
                                                            $vals = str_replace(get_template_directory()."/cufon/","",$filename);
                                                            $vals = str_replace(".js","",$vals);
                                                    ?>
                                                            <option <?php if($heading_font=="cufon:".$vals){echo "selected";}?> value="cufon:<?php echo $vals; ?>"> &nbsp; <?php echo $vals; ?></option>  
                                                    <?php
                                                        }
                                                    ?>
                                                <optgroup label="Google Fonts"></optgroup>
                                                    <?php foreach( $fonts as $key => $font ): ?>  
                                                        <option <?php if($heading_font=="google:".$font){echo "selected";}?> value="google:<?php echo $font; ?>"> &nbsp; <?php echo $font; ?></option>  
                                                    <?php endforeach; ?>  
                                            </select>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Select any Font(Google Font, Cufon Font) to apply on heading. List of all Google Fonts and Custom Cufon available.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Body Font</label>
                                        </li>
                                        <li class="to-field">
                                            <select name="b_font">  
                                            	<option value="0">Default Font</option>
                                                <optgroup label="Google Fonts"></optgroup>
                                                    <?php foreach( $fonts as $key => $font ): ?>  
                                                        <option <?php if($body_font=="google:".$font){echo "selected";}?> value="google:<?php echo $font; ?>"> &nbsp; <?php echo $font; ?></option>  
                                                    <?php endforeach; ?>  
                                            </select>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Select any Font(Google Font, Cufon Font) to apply on Body. List of all Google Fonts and Custom Cufon available.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                                
                                        </li>
                                        <li class="to-field">
                                            <input class="butnthree" type="submit" name="submit" value="Save" />
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Choose Fonts End -->
                    <!-- Upload Cufon Tabs -->
                    <div id="tab-uploadcufon" class="tab-list">
                        <div class="option-sec">
                        	<form id="frm" enctype="multipart/form-data" action="" method="POST">
                            	<div class="opt-head">
                                    <h6>Cufon Upload</h6>
                                    <p>Upload new cufon .js file.</p>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Upload Cufon</label>
                                        </li>
                                        <li class="to-field">
                                            <input id="uploadedfile" name="uploadedfile" type="file" style="display: none;" onchange="document.getElementById('uploadedfile_text').value = this.value;">
                                            <div class="fakefile">
                                                <input class="bar {validate:{required:true,accept:'js'}}" id="uploadedfile_text" type="text" readonly>
                                                <input class="left" type="button" onclick="document.getElementById('uploadedfile').click();" value="Upload">
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Upload cufon only .js file format accepted.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Cufon Title</label>
                                        </li>
                                        <li class="to-field">
                                            <input class="bar {validate:{required:true}}" type="text" name="title" size="40" />
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Please enter the name of cufon file(newcufon.js).
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                                
                                        </li>
                                        <li class="to-field">
                                            <input class="butnthree" type="submit" name="submit_upload" value="Upload Cufon" />
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Upload Cufon End -->
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <!-- Content Section End -->
    </div>
    <div class="clear"></div>
    <!-- Right Column End -->
</div>

	<script type="text/javascript">
		$().ready(function() {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
    </script>


<?php
}
			add_action( 'wp_head', 'font_head' );  
			function font_head() {
				$heading_font = get_option("heading_font");
				$body_font = get_option("body_font");
				$body_font_parts = explode(":",$body_font);
				$parts = explode(":",$heading_font);
					echo '<style>';
						echo "@import url(http://fonts.googleapis.com/css?family=".str_replace(" ","+",$body_font_parts[1]).");";
						echo 'body  { font-family:' . $body_font_parts[1] . ', sans-serif !important; } ';
					echo '</style>';  
					if ( $parts[0] == "google" ) {
						echo '<style>';
							echo "@import url(http://fonts.googleapis.com/css?family=".str_replace(" ","+",$parts[1]).");";
							echo "h1  { font-family:'" . $parts[1] . "', sans-serif !important; } ";
							echo 'h2  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo 'h3  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo 'h4  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo 'h5  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.top-links > li > a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.navigation > div > ul > li > a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.navigation ul ul a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.countdown_amount  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.upcoming-eve a.viewfullcal  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo 'ul.news-list li .desc p.post-opts  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.albums-widget .desc p.date  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_archive ul li  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_tag_cloud a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_categories ul li { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_nav_menu ul li  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_links ul li  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_meta ul li  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_pages ul li  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_recent_comments ul li  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_recent_entries ul li  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.widget_rss ul li a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '#wp-calendar thead  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '#wp-calendar tfoot a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.paging ul li a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo 'div.succ_mess  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo 'p.release  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.gallery-head ul.filter-nav li a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.ft-left div ul li a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.ft-left ul#menu-footer li a  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.contact-us p  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo 'a.buttonsmall  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo 'a.bigbutton  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.fc td  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo '.fc th  { font-family:' . $parts[1] . ', sans-serif !important; } ';
							echo 'div.jp-type-playlist div.jp-playlist span.jp-free-media  { font-family:' . $parts[1] . ', sans-serif !important; } ';
						echo '</style>';  
					}
					else{
						if (isset($parts[1])){
						echo "<script type='text/javascript' src='".get_template_directory_uri()."/scripts/cufon-yui.js'></script>";
						echo "<script type='text/javascript' src='".get_template_directory_uri()."/cufon/".$parts[1].".js'></script>";
						echo "<script type='text/javascript' src='".get_template_directory_uri()."/scripts/cufon.js'></script>";
						}
					}
			}
?>