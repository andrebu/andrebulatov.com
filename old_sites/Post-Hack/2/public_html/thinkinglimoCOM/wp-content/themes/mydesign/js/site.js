jQuery(window).load(function() {
	if (jQuery('.flexslider').length > 0) {
		jQuery('.flexslider.simple').flexslider({
			animation      : "slide",
			animationSpeed : 750,
			easing         : "easeInOutCirc",
			useCSS         : false,
			smoothHeight   : false,
			controlNav     : false,
			start          : function() {
				jQuery('html').removeClass('loading');
			}
		});
		jQuery('.flexslider.detailed').flexslider({
			animation      : "fade",
			animationSpeed : 500,
			controlNav     : false,
			start          : function() {
				jQuery('html').removeClass('loading');
			}
		});
	} else {
		jQuery('html').removeClass('loading');
	}

	if (jQuery('.roundabout').length > 0) {
		jQuery('.roundabout ul').roundabout({
			responsive    : true,
			enableDrag    : true,
			easing        : "easeInOutCirc",
			dropEasing    : 'easeOutBounce',
			minScale      : 0.6,
			duration      : 400,
			dropDuration  : 500
		}, function() {
			jQuery(this).fadeTo(500, 1);
		});
	}

	if (jQuery('.panorama-view').length > 0) {
		jQuery('.panorama-view').panorama360({
			sliding_direction   : 1,
			sliding_controls    : true,
			sliding_interval    : 20
		});
	}

});


//*** Progress Bar Jquery ***//
function progress(percent, element, color) {
var progressBarWidth = percent * element.width() / 100;
element.find('div').css('background', color);
element.find('div').animate({ width: progressBarWidth }, 6000).html("<div class='progress-meter'>"+percent+"%&nbsp;</div>");

}


//	Testmonials
jQuery(document).ready(function(){


	var heights = jQuery(".tiledesc").map(function ()
    {
        return jQuery(this).height();
    }).get();

    maxHeight = Math.max.apply(null, heights);
    
jQuery('.tiledesc').stop(true,true).animate({
				'height' : maxHeight
			},{queue:false, duration:450, easing: 'easeOutCubic'});	


//	Twitter Feeds :
//3 = date
		var tid = '345170787868762112';
		var src2 = $('img[alt="tval"]').attr('src');
		tid = src2;
      twitterFetcher.fetch(tid, '', 3, true, true, false, '', false, handleTweets);
      function handleTweets(tweets){
          var x = tweets.length;
          var n = 0;
          var element = document.getElementById('ftwitter');
          var html = '<ul class="ftwitt">';
          while(n < x) {
            html += '<li>' + tweets[n] + '</li>';
            n++;
          }
          html += '</ul>';
          element.innerHTML = html;

          jQuery('#ftwitter a').attr ('target', '_blank');

          jQuery('.flattwitter').fadeIn(1500);

          jQuery('.ftwitt').list_ticker({
			speed:4000,
			effect:'fade'
		});
      }

jQuery('audio,video').mediaelementplayer();

	var src = $('img[alt="quote_back"]').attr('src');

	jQuery('.flatquote').css('background-image', 'url(' + src + ')');


		jQuery('.fade').list_ticker({
			speed:6000,
			effect:'fade'
		});
		jQuery('.slide').list_ticker({
			speed:2000,
			effect:'slide'
		});	
		jQuery('.once').list_ticker({
			speed:2000,
			effect:'fade',
			run_once:true
		});	
		jQuery('.random').list_ticker({
			speed:2000,
			effect:'fade',
			random:true
		});
	})


jQuery(document).ready(function() {



jQuery('#closesearch').hide();
 jQuery('.searchbar').css('display','none'); //hide the searchbar when page first load

$testo = true;
 jQuery('.search_butt').click(function() {
  jQuery('.searchbar').slideToggle('fast'); //set it to slide down and up fastly

if ($testo) {
	 jQuery('#opensearch').hide();
     jQuery('#closesearch').show();
     

	jQuery('.gn-menu-wrapper').stop(true,true).animate({
				'top' : 174
			},{queue:false, duration:450, easing: 'easeOutCubic'});	

	 $testo=false;
 }else{
 	jQuery('#closesearch').hide();
     jQuery('#opensearch').show();
     
     jQuery('.gn-menu-wrapper').stop(true,true).animate({
				'top' : 106
			},{queue:false, duration:450, easing: 'easeOutCubic'});	
     $testo=true;
 };


 });
 
 jQuery(".search_input").focus(function(){
	jQuery(this).filter(function(){
		return jQuery(this).val() == "" || jQuery(this).val() == "Search..."
	}).val("").css("color","#000");
 });

 jQuery(".search_input").blur(function(){
	jQuery(this).filter(function(){
	return jQuery(this).val() == ""
	}).val("Search...").css("color","#808080");
 });


	jQuery('html').removeClass('no-js');

	jQuery('#menu li').hover(
		function () { jQuery(this).addClass("hover"); },
		function () { jQuery(this).removeClass("hover"); }
	);

	jQuery('#menu li.arrow a').click( function (e) {
		$el = jQuery(this).parent();
		if ($el.hasClass('arrow')) {
			$el.toggleClass("hover");
			if ($el.parents('#menu').hasClass('mobile')) {
				$el.toggleClass('show-menu');
				e.preventDefault();
			}
			//e.preventDefault();
		}
	});

	jQuery('#switch').click(function(e){
		jQuery(this).toggleClass('on');
		jQuery('#menu').toggleClass('mobile');
		return false;
	});

	jQuery('.accordion .accordion-title').click(function(e){
		$li = jQuery(this).parent('li');
		$ul = $li.parent('.accordion');
		if ($ul.hasClass('only-one-visible')) {
			jQuery('li',$ul).not($li).removeClass('active');
		}
		$li.toggleClass('active');
		e.preventDefault();
	});

	jQuery(document).click(function(e){
		if (jQuery(e.target).parents('#menu').length > 0) return;
		jQuery('#menu #switch').removeClass('on');
		jQuery('#menu').removeClass('mobile');
	});

	jQuery('#top-link').click(function(e){
		jQuery('html, body').animate({scrollTop:0}, 750, 'linear');
		e.preventDefault();
		return false;
	});

	var window_width = jQuery('.container').width();
	jQuery(window).smartresize(function() {
		if (jQuery('.container').width() != window_width) {
			window_width = jQuery('.container').width();
			jQuery('#menu #switch').removeClass('on');
			jQuery('#menu').removeClass('mobile');
			if (jQuery('.isotope').length > 0) {
				jQuery('.isotope').isotope("reLayout");
			}
		}
	});

charts = jQuery(".progress-bar");
jQuery(window).scroll(function(d,h) {
    charts.each(function(i) {
        a = jQuery(this).offset().top + jQuery(this).height();
        b = jQuery(window).scrollTop() + jQuery(window).height();
        if (a < b){ 
		var bar = jQuery(this);
		var percentage = jQuery(this).attr('data-percent');
		var p_color = jQuery(this).attr('data-color');
		progress(percentage, bar,p_color);
        }   	
    });
});


charts2 = jQuery(".firaschart");

jQuery(".circular-bar").donutchart({'size': 150});
jQuery(window).scroll(function(d,h) {
    charts2.each(function(i) {
        a = jQuery(this).offset().top + jQuery(this).height();
        b = jQuery(window).scrollTop() + jQuery(window).height();
        if (a < b){ 
var c_color = jQuery(this).attr('data-color');
jQuery(this).donutchart({'size': 150, 'fgColor': c_color });
jQuery(this).donutchart("animate");
jQuery(this).removeClass('firaschart');
charts2 = jQuery(".firaschart");
        }   	
    });
});





	tiles2 = jQuery(".fadeitin");
 	tiles2.each(function(i) {
  	a = jQuery(this).offset().top + jQuery(this).height();
        b = jQuery(window).scrollTop() + jQuery(window).height();
        if (a > b) jQuery(this).fadeTo(0, 0);
    });

	jQuery(window).scroll(function(d,h) {
    tiles2.each(function(i) {
        a = jQuery(this).offset().top + jQuery(this).height();
        b = jQuery(window).scrollTop() + jQuery(window).height();
        if (a < b){ jQuery(this).stop(true,false).fadeTo(1600,1);
        	jQuery(this).removeClass('fadeitin');
        	tiles2 = jQuery(".fadeitin");
        }
    	
    });
});

	if (true) {
		jQuery(window).bind('scroll',smallNav);
	};
	function smallNav(){

		var $offset = jQuery(window).scrollTop();
		var $windowWidth = jQuery(window).width();
		
	if($offset > 65 && $windowWidth >= 1000) {
	 jQuery('.searchbar').hide(450);

	if ($testo === false) {
 		jQuery('#closesearch').hide();
    	jQuery('#opensearch').show();
     	$testo=true;
 	};
	}

		if($offset > 200 && $windowWidth >= 1000) {

			jQuery('.gn-menu-main').stop(true,true).animate({
									'height' : 71,
									'z-index' : 1000
								},{queue:false, duration:450, easing: 'easeOutCubic'});	

			jQuery('.gn-menu-wrapper').stop(true,true).animate({
								'top' : 70,
								'z-index' : 1000
							},{queue:false, duration:450, easing: 'easeOutCubic'});	

			jQuery('.flatheader').stop(true,true).animate({
				'margin-top' : -1,
			},{queue:false, duration:450, easing: 'easeOutCubic'});	


			jQuery('#menu').stop(true,true).animate({
				'height' : 50
			},{queue:false, duration:450, easing: 'easeOutCubic'});	


			jQuery('.searchimg').stop(true,true).animate({
				'margin-top' : 1
			},{queue:false, duration:450, easing: 'easeOutCubic'});	

			
			jQuery('#menu > a').stop(true,true).animate({
				'height' : 65,
				'line-height' : '60px'
			},{queue:false, duration:450, easing: 'easeOutCubic'});	

			jQuery('#menu > ul > li > a').stop(true,true).animate({
				'height' : 65,
				'line-height' : '60px'
			},{queue:false, duration:450, easing: 'easeOutCubic'});	

			jQuery('#logo h1').stop(true,true).animate({
						'line-height' : '15px',
						'margin-top' : '7px',
						'margin-bottom' : '15px',
						'max-height' : '50px',
					},{queue:false, duration:450, easing: 'easeOutCubic'});	

			jQuery('#logo p.text-version').stop(true,true).animate({
						'line-height' : '30px',
						'margin-bottom' : '20px'
					},{queue:false, duration:450, easing: 'easeOutCubic'});	

			jQuery('#logo h1 a img').stop(true,true).animate({
						'max-height' : '50px'
					},{queue:false, duration:450, easing: 'easeOutCubic'});	
		 

			jQuery('#header #logo h5').fadeOut('fast');
	
			jQuery(window).unbind('scroll',smallNav);
			jQuery(window).bind('scroll',bigNav);
		}
	}
	
	function bigNav(){

		var $offset = jQuery(window).scrollTop();
		var $windowWidth = jQuery(window).width();

		if($offset > 65 && $windowWidth >= 1000) {
	 jQuery('.searchbar').hide(700);

if ($testo === false) {
 	jQuery('#closesearch').hide();
     jQuery('#opensearch').show();
     $testo=true;
 };
	}
		if($offset == 0 && $windowWidth >= 1000) {
			

			jQuery('#menu').stop(true,true).animate({
				'height' : 100
			},{queue:false, duration:250, easing: 'easeOutCubic'});	
		

				jQuery('.flatheader').stop(true,true).animate({
				'margin-top' : 0,
				'opacity' : '1',
				'filter' : 'alpha(opacity=100)'
			},{queue:false, duration:450, easing: 'easeOutCubic'});	

			jQuery('.searchimg').stop(true,true).animate({
							'margin-top' : 15
						},{queue:false, duration:450, easing: 'easeOutCubic'});	


			jQuery('.gn-menu-main').stop(true,true).animate({
						'height' : 106
					},{queue:false, duration:450, easing: 'easeOutCubic'});	


			jQuery('.gn-menu-wrapper').stop(true,true).animate({
							'top' : 106
						},{queue:false, duration:450, easing: 'easeOutCubic'});	


			jQuery('#menu > a').stop(true,true).animate({
				'height' : 100,
				'line-height' : '96px',
			},{queue:false, duration:250, easing: 'easeOutCubic'});	

			jQuery('#menu > ul > li > a').stop(true,true).animate({
				'height' : 100,
				'line-height' : '96px',
			},{queue:false, duration:250, easing: 'easeOutCubic'});	


			jQuery('#logo h1').stop(true,true).animate({
						'line-height' : '27px',
						'margin-top' : '21px',
						'margin-bottom' : '19px',
						'max-height' : '67px',
					},{queue:false, duration:250, easing: 'easeOutCubic'});	

			jQuery('#logo p.text-version').stop(true,true).animate({
						'line-height' : '45px',
						'margin-top' : '20px',
						'margin-bottom' : '5px'
					},{queue:false, duration:250, easing: 'easeOutCubic'});	

			jQuery('#logo h1 a img').stop(true,true).animate({
						'max-height' : '67px'
					},{queue:false, duration:250, easing: 'easeOutCubic'});	


			jQuery('#header #logo h5').fadeIn('fast');

				jQuery(window).unbind('scroll',bigNav);
				jQuery(window).bind('scroll',smallNav);
		}
	}


	jQuery(window).scroll(function() {

  jQuery('.flatblog, .flatvideo').stop(true,true).animate({
						'background-position-y' : parseInt(jQuery(this).scrollTop()*0.15)
					},{queue:false, duration:250, easing: 'easeOutCubic'});	


		$el = jQuery('#top-link');

		if (jQuery(window).scrollTop() >= 300) {
			$el.fadeIn(500);
		} else {
			$el.fadeOut(250);	
		}
		
	});

	jQuery('.tabs').tabify();

	if (jQuery('#contact_form').length > 0) {
		jQuery('#contact_form').ajaxForm({ target: '#contact_alert' });
	}

	if (jQuery('.lightbox, .button-fullsize, .fullsize').length > 0) {
		jQuery('.lightbox, .button-fullsize, .fullsize').fancybox({
			padding    : 0,
			maxHeight  : '90%',
			maxWidth   : '90%',
			loop       : true,
			fitToView  : true,
			mouseWheel : false,
			autoSize   : false,
			closeClick : false,
			overlay    : { showEarly  : true },
			helpers    : { media : {} }
		});
	}

	if (jQuery('.isotope').length > 0) {
		$isotope = jQuery('.isotope');
		$isotope.imagesLoaded(function(){
			$isotope.isotope({
				itemSelector    : '.isotope .isotope-item:visible',
				animationEngine : 'jquery',
				resizable       : true
			});
		});
		jQuery('.isotope.infinitescroll').infinitescroll({
			navSelector  : '.pagination',
			nextSelector : '.pagination a.next',
			itemSelector : '.isotope .isotope-item',
			bufferPx     : 140,
			loading      : {
				finishedMsg: 'No more items to load.',
				msgText : "Loading new posts...",
				img: 'http://i.imgur.com/6RMhx.gif'
			}
		}, function( newElements ) {
			var $newElems = jQuery(newElements);
			$newElems.each(function() {
				jQuery(this).css({ opacity: 0 });
				var selector = jQuery('.isotope-filter a.active').data('value');
				if (selector != 'all') {
					if (jQuery(this).data('type') != selector) jQuery(this).hide();
				}
			});
			$newElems.imagesLoaded(function(){
				$newElems.animate({ opacity: 1 });
				$isotope.isotope( 'appended', $newElems, true );
			});
		});

		jQuery('.isotope-filter a').click(function(ev) {
			$this = jQuery(this);
			if ($this.hasClass('active')) return;
			$this.parent().children('a').removeClass('active');
			$this.addClass('active');
			var selector = $this.data('value');
			if (selector == 'all') {
				selector = '.col';
			} else {
				selector = '.col[data-type~=' + selector + ']';
			}
			jQuery('.isotope').isotope({ filter: selector });
			return false;
		});
	}

});