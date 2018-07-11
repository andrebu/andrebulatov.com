function setwatermark(txtidstr, watermarkstr) {
    if (jQuery('#' + txtidstr).val() == "") {
        jQuery('#' + txtidstr).val(watermarkstr);
    }
    jQuery('#' + txtidstr).focus(function () {
        if (this.value == watermarkstr) {
            this.value = "";
        }
    }).blur(function () {
        if (this.value == "") {
            this.value = watermarkstr;
        }
    });
}

function webovalidEmail(email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if(emailReg.test(email)) {
    return true;
  } else {
    return false;
  }
}

function webovalidNumber(number) {
	return (!(isNaN(number)))
}

function weboupdatemsg(idorclassstr, msgstr, timeval) {
	jQuery(idorclassstr).html(msgstr);
		setTimeout(function() { 
		jQuery(idorclassstr).html('&nbsp;');
	}, timeval);
}

function webomsg(idorclassstr, msgstr) {
	jQuery(idorclassstr).html(msgstr);
}

function webodialogmsg(dialogidstr, dialogmsgidstr, titlestr, msgstr, heightstr, widthstr) {
	jQuery('#' + dialogmsgidstr).html(msgstr);
	jQuery('#' + dialogidstr).dialog({ title: titlestr, height: heightstr, width: widthstr, modal: true, 
		buttons: { 
			'Close' : function () { 
				jQuery('#' + dialogidstr).dialog('close'); 
			}
		}
	});
}

function webourldecode(str) {
   return decodeURIComponent((str+'').replace(/\+/g, '%20'));
}

function weborandomstr(strlengthi) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < strlengthi; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}

function webogetquerystrbyname(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.search);
    if (results == null)
        return "-1";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function webovaliddomainname(str) {
	var domainReg = /^[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/;
	if(domainReg.test(str)) {
		return true;
	} else {
		return false;
	}
}