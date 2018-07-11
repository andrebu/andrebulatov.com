(function($) {

$(function () {	
	/*var jslibval = $('#jslib').val();
	switch(jslibval) {
		case 'product':
			alert('product');
			break;
	}*/
	$('.fancybox-effects-c').fancybox({
		wrapCSS    : 'fancybox-custom',
		closeClick : true,
		openEffect : 'fade',
		helpers : {
			title : { type : 'inside' },
			overlay : { css : { 'background' : 'rgba(238,238,238,0.85)' } }
		}
	});
	$('.numbersOnly').keyup(function () { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	});
});

})(jQuery);