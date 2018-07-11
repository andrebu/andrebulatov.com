(function($) {

$(function () {	
	var jslibval = $('#jslib').val();
	switch(jslibval) {
		case 'settings':
			$('#wpordercart-tabs-settings').tabs();
			$('#btnupdategeneralsettings').live('click',function() {
				var wpordercartdefaultcurrencyval = $('#ddlwpordercartcurrency').val();
				var wpordercartshowpriceval = $('#ddlwpordercartshowprice').val();				
				var wpordercartorderemailval = $('#txtwpordercartorderemail').val();
				var wpordercartorderbuttoncssclassval = $('#txtwpordercartorderbtncssclass').val();
                var wpordercartorderinstructionsval = $('#txtwpordercartorderinstructions').val();
                if (wpordercartorderinstructionsval == '') {
                    wpordercartorderinstructionsval == 'We will then receive the order details and will be in contact with you shortly after that';
                }
				var wpordercartorderthankyoumsgval = $('#txtwpordercartorderthankyoumsg').val();
				var wpordercartorderemailthankyoumsgval = $('#txtwpordercartorderemailthankyoumsg').val();
				var checkout_page_idval = $('#checkout_page_id').val();
				var validationerrormsg = '';
				if (wpordercartorderemailval == '' || !webovalidEmail(wpordercartorderemailval)) {
					validationerrormsg = 'Valid email address required.';
				}
				if (wpordercartorderthankyoumsgval == '' || wpordercartorderemailthankyoumsgval == '') {
					validationerrormsg = 'Thank you messages required.';
				}
				if (validationerrormsg != '') {
					webodialogmsg('wpocshoppingcartwidget-admin-dialog-msg', 'wpocshoppingcartwidget-div-admin-dialog-msg-content', 'Form validation error', validationerrormsg, 250, 600);	
				} else {
					$('#spanupdategeneralsettingsloading').fadeIn();
					$.ajax({ 
						type : 'POST', 
						url : WPOrderCartAdminAjaxO.ajaxurl,  
						dataType : 'json', 
						data: { action : 'wpordercart-admin-ajax-submit', cmd: 'update-settings-general', wpordercartdefaultcurrency: wpordercartdefaultcurrencyval, wpordercartshowprice: wpordercartshowpriceval, checkout_page_id: checkout_page_idval, wpordercartorderemail: wpordercartorderemailval, wpordercartorderbuttoncssclass: wpordercartorderbuttoncssclassval, wpordercartorderinstructions: wpordercartorderinstructionsval, wpordercartorderthankyoumsg: wpordercartorderthankyoumsgval, wpordercartorderemailthankyoumsg: wpordercartorderemailthankyoumsgval }, 
						success : function(data) {
							$('#spanupdategeneralsettingsloading').fadeOut();
							if (data.error) {
								webodialogmsg('wpocshoppingcartwidget-admin-dialog-msg', 'wpocshoppingcartwidget-div-admin-dialog-msg-content', 'Server error', 'Could not update settings, please try again later.', 250, 600);
							} else {
								webodialogmsg('wpocshoppingcartwidget-admin-dialog-msg', 'wpocshoppingcartwidget-div-admin-dialog-msg-content', 'Server error', 'WP Order Cart settings updated.', 250, 600);
							}
						} 
					});
				}
			});
			break;
	}
});

})(jQuery);