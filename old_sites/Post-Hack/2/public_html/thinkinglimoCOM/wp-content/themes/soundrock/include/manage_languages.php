<?php
function manage_languages() {
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
	
	$message_upload = '';
	if ( empty($mess) ) $mess = '';
	$lang_theme_db = '';
	$lang_theme_db = get_option("lang_theme");
	//$lang_style_db = get_option("lang_style");
	if ( isset($submit_upload) ) {
		//$file_name = $_FILES['uploadedfile']['name'];
		$target_path_mo = ABSPATH."wp-content/languages/".trim($title).".mo";
		$target_path_po = ABSPATH."wp-content/languages/".trim($title).".po";
		$target_path_style = ABSPATH."wp-content/languages/".trim($title).".php";
		if ( file_exists($target_path_mo) ) {
			$message_upload = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>This Language Already Exist</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
		}
		else {
			if ( move_uploaded_file($_FILES['uploadedfileMO']['tmp_name'], $target_path_mo) ) {
				//echo "Allah Is The Greatest <br />";
				chmod($target_path_mo,0777);
				$message_upload = "<div class='form-msgs'><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p>New Language Uploaded (MO)</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
			}
			if ( move_uploaded_file($_FILES['uploadedfilePO']['tmp_name'], $target_path_po) ) {
				//echo "Allah Is The Greatest <br />";
				chmod($target_path_po,0777);
				$message_upload .= "<div class='form-msgs'><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p>New Language Uploaded (PO)</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
			}
			else $message_upload = "<div class='form-msgs'><div class='to-notif error-box'><span class='error'>&nbsp;</span><p>Language Not Uploaded</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
		}
		$message_upload .= "<script>slideout();</script>";
	}
?>
<div class="theme-wrap fullwidth">


	<?php include("theme_leftnav.php");?>
    <!-- Right Column Start -->
    <div class="col2 left">
		<!-- Header Start -->
        <div class="wrap-header">
            <h4 class="bold">Manage Languages</h4>
            
            <div class="clear"></div>
        </div>
        <!-- Header End -->
        <!-- Content Section Start -->
        <div class="tab-section">
            <div class="tab_menu_container">
                <ul id="tab_menu">  
                    <li><a href="#chooselang" class="current" rel="tab-chooselang"><span>Choose Language</span></a></li>
                    <li><a href="#uploadlang" class="" rel="tab-uploadlang"><span>Upload New Languages</span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="tab_container">
                <div class="tab_container_in">
						<?php 
						echo $message_upload;
                        if ( $mess == 1 ) {
							echo "<div class='form-msgs'><div class='to-notif success-box'><span class='tick'>&nbsp;</span><p>Selected Language loaded</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
							echo "<script>slideout();</script>";
                        }
                        ?>
                    <!-- Choose Fonts Start -->
                    <div id="tab-chooselang" class="tab-list">
                        <div class="option-sec">
                        	<form id="frm" method="post" action="<?php echo get_template_directory_uri(); ?>/include/load_languages.php">
                            	<div class="opt-head">
                                    <h6>Choose Languages</h6>
                                    <p>Please choose language to apply on theme.</p>
                                </div>
                                <div class="opt-conts">
									<ul class="form-elements">
                                        <li class="to-label">
                                            <label>Select Language</label>
                                        </li>
                                        <li class="to-field">
                                            <?php ?>
                                                <select name="lang_theme">
                                                    <option>English</option>
                                                    <?php
                                                            foreach (glob(ABSPATH."wp-content/languages/*.mo") as $filename) {
                                                            //echo "$filename size " . filesize($filename) . "\n";
                                                            $vals = str_replace(ABSPATH."wp-content/languages/","",$filename);
                                                            $vals = str_replace(".mo","",$vals);
                                                    ?>
                                                            <option <?php if($lang_theme_db==$vals){echo "selected";}?> value="<?php echo $vals?>"><?php echo $vals; ?> &nbsp; </option>  
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Select desired language to apply on theme.
                                            </p>
                                        </li>
                                    </ul>
                                    
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                                
                                        </li>
                                        <li class="to-field">
                                            <input type="submit" name="submit_upload" value="Save" />
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Choose Fonts End -->
                    <!-- Upload Cufon Tabs -->
                    <div id="tab-uploadlang" class="tab-list">
                        <div class="option-sec">
                        	<form id="frm2" enctype="multipart/form-data" action="admin.php?page=<?php echo $page?>" method="POST">
                            	<div class="opt-head">
                                    <h6>Upload Languages</h6>
                                    <p>Upload new language.</p>
                                </div>
                                <div class="opt-conts">
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Upload Language (MO File)</label>
                                        </li>
                                        <li class="to-field">
                                            <input id="uploadedfileMO" name="uploadedfileMO" type="file" style="display: none;" onchange="document.getElementById('uploadedfileMO_text').value = this.value;">
                                            <div class="fakefile">
                                                <input class="{validate:{required:true,accept:'mo'}}" id="uploadedfileMO_text" name="uploadedfileMO_text" type="text" readonly>
                                                <input class="left" type="button" onclick="document.getElementById('uploadedfileMO').click();" value="Upload">
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Please upload .MO format file here.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                            <label>Upload Language(PO File)</label>
                                        </li>
                                        <li class="to-field">
                                            <input id="uploadedfilePO" name="uploadedfilePO" type="file" style="display: none;" onchange="document.getElementById('uploadedfilePO_text').value = this.value;">
                                            <div class="fakefile">
                                                <input class="{validate:{required:true,accept:'po'}}" id="uploadedfilePO_text" name="uploadedfilePO_text" type="text" readonly>
                                                <input class="left" type="button" onclick="document.getElementById('uploadedfilePO').click();" value="Upload">
                                            </div>
                                        </li>
                                        <li class="to-desc">
                                            <p>
                                                Please upload .PO format file here.
                                            </p>
                                        </li>
                                    </ul>
                                    <ul class="form-elements">
                                        <li class="to-label">
                                        	<label>Language Title</label>        
                                        </li>
                                        <li class="to-field">
                                            <input class="{validate:{required:true}} bar" type="text" name="title" size="40" />
                                        </li>
                                    </ul>
                                    <ul class="form-elements noborder">
                                        <li class="to-label">
                                                
                                        </li>
                                        <li class="to-field">
                                            <input type="submit" name="submit_upload" value="Upload Language" />
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
			var validator = $("#frm2").validate({
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
?>