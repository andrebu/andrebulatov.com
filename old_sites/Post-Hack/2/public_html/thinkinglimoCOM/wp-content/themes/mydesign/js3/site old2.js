   // jQuery $('document').ready(); function
    $('document').ready(function(){
        // Calling LayerSlider on your selected element after the document loaded
        $('#layerslider').layerSlider({
 
    autoStart               : true,
    responsive              : true,
    responsiveUnder         : 959,
    sublayerContainer       : 0,
    firstLayer              : 1,
    twoWaySlideshow         : false,
    randomSlideshow         : false,
    keybNav                 : true,
    touchNav                : true,
    imgPreload              : true,
    navPrevNext             : true,
    navStartStop            : false,
    navButtons              : false,
    thumbnailNavigation     : 'hover',
    tnWidth                 : 100,
    tnHeight                : 60,
    tnContainerWidth        : '60%',
    tnActiveOpacity         : 35,
    tnInactiveOpacity       : 100,
    hoverPrevNext           : false,
    hoverBottomNav          : false,
    skin                    : 'fullwidth',
    skinsPath               : 'layerslider/skins/',
    pauseOnHover            : false,
    globalBGColor           : 'transparent',
    globalBGImage           : false,
    animateFirstLayer       : true,
    yourLogo                : false,
    yourLogoStyle           : 'position: absolute; z-index: 1001; left: 10px; top: 10px;',
    yourLogoLink            : false,
    yourLogoTarget          : '_blank',
    loops                   : 0,
    forceLoopNum            : true,
    autoPlayVideos          : true,
    autoPauseSlideshow      : 'auto',
    youtubePreview          : 'maxresdefault.jpg',
    showBarTimer        : false,
    showCircleTimer     : true,
 
    // you can change this settings separately by layers or sublayers with using html style attribute
 
    slideDirection          : 'right',
    slideDelay              : 4000,
    durationIn              : 1000,
    durationOut             : 1000,
    easingIn                : 'easeInOutQuint',
    easingOut               : 'easeInOutQuint',
    delayIn                 : 0,
    delayOut                : 0		});

   $('#layerslider2').layerSlider({
 
    autoStart               : true,
    responsive              : true,
    responsiveUnder         : 0,
    sublayerContainer       : 1,
    firstLayer              : 1,
    twoWaySlideshow         : false,
    randomSlideshow         : false,
    keybNav                 : true,
    touchNav                : true,
    imgPreload              : true,
    navPrevNext             : true,
    navStartStop            : false,
    navButtons              : false,
    thumbnailNavigation     : 'hover',
    tnWidth                 : 100,
    tnHeight                : 60,
    tnContainerWidth        : '60%',
    tnActiveOpacity         : 35,
    tnInactiveOpacity       : 100,
    hoverPrevNext           : false,
    hoverBottomNav          : false,
    skin                    : 'fullwidth',
    skinsPath               : 'layerslider/skins/',
    pauseOnHover            : true,
    globalBGColor           : 'transparent',
    globalBGImage           : false,
    animateFirstLayer       : true,
    yourLogo                : false,
    yourLogoStyle           : 'position: absolute; z-index: 1001; left: 10px; top: 10px;',
    yourLogoLink            : false,
    yourLogoTarget          : '_blank',
    loops                   : 0,
    forceLoopNum            : true,
    autoPlayVideos          : true,
    autoPauseSlideshow      : 'auto',
    youtubePreview          : 'maxresdefault.jpg',
    showBarTimer        : true,
    showCircleTimer     : false,
 
    // you can change this settings separately by layers or sublayers with using html style attribute
 
    slideDirection          : 'right',
    slideDelay              : 3000,
    durationIn              : 1000,
    durationOut             : 1000,
    easingIn                : 'easeInOutQuint',
    easingOut               : 'easeInOutQuint',
    delayIn                 : 0,
    delayOut                : 0     });
    });



	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));



	

$(window).load(function(){                      
    var $item_mask = $("<div />", {"class": "item-mask"});
    $("ul.shaped .item-container, ul.comment-list .avatar").append($item_mask)





var heights = jQuery(".team-text").map(function ()
    {
        return jQuery(this).height();
    }).get();

    maxHeight = Math.max.apply(null, heights);
    
jQuery('.team-text').stop(true,true).animate({
                'height' : maxHeight
            },{queue:false, duration:450, easing: 'easeOutCubic'}); 


var heights2 = jQuery(".tile-text").map(function ()
    {
        return jQuery(this).height();
    }).get();

    maxHeight2 = Math.max.apply(null, heights2);
    
jQuery('.tile-text').stop(true,true).animate({
                'height' : maxHeight2
            },{queue:false, duration:450, easing: 'easeOutCubic'}); 






    var tid = '377205624066433024';
    var user_id = jQuery('#ftwitter').attr('user-id');

       // var src2 = $('img[alt="tval"]').attr('src');
        tid = user_id;
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
})



if (jQuery('#contact_form').length > 0) {
        jQuery('#contact_form').ajaxForm({ target: '#contact_alert' });
    }

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

 



    
 }); // end scroll function








$('#fade').list_ticker({
      speed:4000,
      effect:'fade'
    });

  $(function(){
	
	var $container = $('#container2');

	$container.isotope({
	  itemSelector : '.element'
	});
	
/*	$(window).bind("resize", function(){
	  	vell=tam;
		calcul();
		if(vell!=tam){
			$container.isotope( 'reLayout')
		}
	});
*/
	
	var $optionSets = $('#options .option-set'),
		$optionLinks = $optionSets.find('a');

	$optionLinks.click(function(){
		$(".project-window").slideUp("slow");
	  var $this = $(this);
	  // don't proceed if already selected
	  if ( $this.hasClass('selected') ) {
		return false;
	  }
	  var $optionSet = $this.parents('.option-set');
	  $optionSet.find('.selected').removeClass('selected');
      $optionSet.find('.selected').find('.portfolio-btn').removeClass('selected');
	  $this.addClass('selected');
      $this.find('.portfolio-btn').addClass('selected');
      

	  // make option object dynamically, i.e. { filter: '.my-filter-class' }
	  var options = {},
		  key = $optionSet.attr('data-option-key'),
		  value = $this.attr('data-option-value');
	  // parse 'false' as false boolean
	  value = value === 'false' ? false : value;
	  options[ key ] = value;
	  if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
		// changes in layout modes need extra logic
		changeLayoutMode( $this, options )
	  } else {
		// otherwise, apply new options
		$container.isotope( options );
	  }
	  
	  return false;
	});
  });