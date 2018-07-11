<?php
	$re_captcha = "";
	$cs_public_key = "";
	$cs_gs_google_recaptcha_keys = get_option( "cs_gs_google_recaptcha_keys" );
		if ( $cs_gs_google_recaptcha_keys <> "" ) {
			$sxe = new SimpleXMLElement($cs_gs_google_recaptcha_keys);
				$re_captcha = $sxe->re_captcha;
				$cs_public_key = $sxe->cs_public_key;
		}
?>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/validation/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/validation/jquery.validate.js"></script>
<script type="text/javascript">
	$().ready(function() {
		var container = $('');
		var validator = $("#frm<?php echo $counter_gal?>").validate({
			errorContainer: container,
			errorLabelContainer: $(container),
			errorElement:'div',
			errorClass:'frm_error',
			meta: "validate"
		});
	});
	function frm_recapcha_verify<?php echo $counter_gal?>(){
		$("#submit_btn<?php echo $counter_gal?>").hide();
		$("#loading_div<?php echo $counter_gal?>").html('<img src="<?php echo get_template_directory_uri()?>/images/ajax_loading.gif" />');
		$.ajax({
			type:'POST', 
			url: '<?php echo get_template_directory_uri()?>/include/recaptcha_verify.php',
			data:$('#frm<?php echo $counter_gal?>').serialize(), 
			success: function(response) {
				if ( response == "Valid" ) {
					frm_submit();
				}
				else {
					$("#loading_div<?php echo $counter_gal?>").hide();
					$("#submit_btn<?php echo $counter_gal?>").show('');
					$("#recaptcha_mess<?php echo $counter_gal?>").show('');
					$("#recaptcha_mess<?php echo $counter_gal?>").html(response);
					Recaptcha.reload();
				}
			}
		});
	}
	function frm_submit<?php echo $counter_gal?>(){
		$("#submit_btn<?php echo $counter_gal?>").hide();
		$("#loading_div<?php echo $counter_gal?>").html('<img src="<?php echo get_template_directory_uri()?>/images/ajax_loading.gif" />');
		$.ajax({
			type:'POST', 
			url: '<?php echo get_template_directory_uri()?>/page_contact_submit.php',
			data:$('#frm<?php echo $counter_gal?>').serialize(), 
			success: function(response) {
				//$('#frm').get(0).reset();
				$("#loading_div<?php echo $counter_gal?>").html('');
				$("#frm_area<?php echo $counter_gal?>").hide();
				$("#succ_mess<?php echo $counter_gal?>").show('');
				$("#succ_mess<?php echo $counter_gal?>").html(response);
				//$('#frm_slide').find('.form_result').html(response);
			}
		});
	}
</script>
<div class="clear"></div>
<div class="contact" style="padding-top:20px;">
<div class="contact-page"><?php echo $cs_contact_map_db?></div>
<div class="clear"></div>
    <!-- Quick Inquary Start -->
    <div class="succ_mess" id="succ_mess<?php echo $counter_gal?>"></div>
    <div class="inquiry" id="frm_area<?php echo $counter_gal?>">
        <h1 class="heading colr">Quick Inquiry</h1>
        <form id="frm<?php echo $counter_gal?>" name="frm<?php echo $counter_gal?>" method="post" action="javascript:<?php if($re_captcha=="on")echo "frm_recapcha_verify".$counter_gal."()";else echo "frm_submit".$counter_gal."()";?>">
            <ul>
                <li>
                    <label class="txt">Enter Name:</label>
                    <input type="text" name="contact_name" id="contact_name" value="" class="{validate:{required:true}}" />
                </li>
                <li>
                    <label class="txt">Enter Email:</label>
                    <input type="text" name="contact_email" id="contact_email" value="" class="{validate:{required:true,email:true}}" />
                </li>
                <li>
                    <label class="txt">Enter Contact No.</label>
                    <input type="text" name="contact_no" id="contact_no" value="" class="{validate:{number:true}}" />
                </li>
                <li>
                    <label class="txt">Enter Message:</label>
                    <textarea name="contact_msg" id="contact_msg" class="{validate:{required:true}}" /></textarea>
                </li>
                	<?php if($re_captcha=="on") {?>
                        <li>
							<script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=<?php echo $cs_public_key?>"></script>
                            <noscript><iframe src="https://www.google.com/recaptcha/api/noscript?k=<?php echo $cs_public_key?>" height="300" width="500" frameborder="0"></iframe></noscript>
                            <?php
                                //require_once(TEMPLATEPATH.'/include/recaptchalib.php');
                                //$publickey = "6Lc5qdISAAAAAMo4aGZxGOKUXCcSeplzeZlx2ugn";
                                //echo recaptcha_get_html($publickey);
                            ?>
                            <div id="recaptcha_mess<?php echo $counter_gal?>"></div>
                         </li>
                	<?php }?>
                <li>
                    <input type="hidden" name="cs_contact_email" value="<?php echo $cs_contact_email_db?>" />
                    <input type="hidden" name="cs_contact_succ_msg" value="<?php echo $cs_contact_succ_msg_db?>" />
                    <input id="submit_btn<?php echo $counter_gal?>" type="submit" value="Submit"/>
                    <div id="loading_div<?php echo $counter_gal?>"></div>
                </li>
            </ul>
        </form>
    </div>
</div>
<!-- Quick Inquary End -->
<div class="clear"></div>