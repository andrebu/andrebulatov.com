/*--------------------------------------------------
		 COMMENT FORM CODE
---------------------------------------------------*/
jQuery(document).ready(function($){
/*	$('form#comment-form').submit(function() {
		$('form#comment-form .contact-error').remove();
		var hasError = false;
		$('form#comment-form .required').next('input').each(function() {
			if(jQuery.trim($(this).val()) == '') {
            	var labelText = $(this).prev('label').text();
            	$(this).parent().append('<span class="contact-error">Required</span>');
            	$(this).addClass('inputError');
            	hasError = true;
            } else if($(this).hasClass('email')) {
            	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            	if(!emailReg.test(jQuery.trim($(this).val()))) {
            		var labelText = $(this).prev('label').text();
            		$(this).parent().append('<span class="contact-error">Invalid</span>');
            		$(this).addClass('inputError');
            		hasError = true;
            	}
            }
		});
		if(!hasError) {
			var formInput = $(this).serialize();
			$.post($(this).attr('action'),formInput, function(data){
				$("form#comment-form").before('<div class="contact-success"><strong>THANK YOU!</strong><p>Your comment was successfully sent.</p></div>');
			});
		}


		return false;

	});*/
	$(".comment-list li").addClass("comment");
	$("#comment-form").addClass("form");
	$("#comment-form #submit").addClass("submit");
	$("#reply-title").addClass("title");
	$("#reply-title").after("<p>Make sure you fill in all mandatory fields.</p>")
});
       