/* <!-- Console Message Code --> */	
/*     <script type='text/javascript'> */
    
	    (function(){
		    try{
        	 var msg = '%c \n       d8888               888                      888888b.            888          888                     \n      d88888               888                      888  "88b           888          888                     \n     d88P888               888                      888  .88P           888          888                     \n    d88P 888 88888b.   .d88888 888d888 .d88b.       8888888K.  888  888 888  8888b.  888888 .d88b.  888  888 \n   d88P  888 888 "88b d88" 888 888P"  d8P  Y8b      888  "Y88b 888  888 888     "88b 888   d88""88b 888  888 \n  d88P   888 888  888 888  888 888    88888888      888    888 888  888 888 .d888888 888   888  888 Y88  88P \n d8888888888 888  888 Y88b 888 888    Y8b.          888   d88P Y88b 888 888 888  888 Y88b. Y88..88P  Y8bd8P  \nd88P     888 888  888  "Y88888 888     "Y8888       8888888P"   "Y88888 888 "Y888888  "Y888 "Y88P"    Y88P   \n';
                msg += '============================================================================================================\n01000001 01101110 01100100 01110010 01100101  01000010 01110101 01101100 01100001 01110100 01101111 01110110\n============================================================================================================\nHeya! How\'s it going? I see you opened the console! What ya doing here? Know some code, do you? Want to work\nfor one of the best people around? Seriously, I\'m awesome! Contact me  @     http://andrebulatov.com/contact\n============================================================================================================\n';
                var msgStyle = "background: -webkit-linear-gradient(rgb(81,162,189), rgb(68,105,133)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 1px 1px 0px rgba(0,0,0, .2); color: white; color: rgb(68,105,133); background: -webkit-linear-gradient(rgb(99,199,231), rgb(68,105,133)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 3px 3px 0px rgba(0,0,0, .2), 0px 0px 20px rgba(128,190,220, 1.0);";
                console.log(msg, msgStyle);
            }catch(e){}
        })()
        
/*     </script>  */
/* <!-- END Console Message Code -->	 */


// Enable bootstrap's tooltip	
$(function () {
	$('[data-toggle="tooltip"]').tooltip({'placement': 'top'})
})



var lnStickyNavigation;

$(document).ready(function()
{	
	applyHeader();
	applyNavigation(); 
	applyMailTo();
	applyResize();
	checkHash();
/* 	checkBrowser(); */
});

/* HEADER FUNCTIONS */

function applyHeader() {
	//$('.jumbotron').css({ height: ($(window).height()) +'px' });
	lazyLoad($('.jumbotron'));
}	

function lazyLoad(poContainer) {
	var lstrSource   = poContainer.attr('data-src');
	var lstrPosition = poContainer.attr('data-position');
	$('<img>').attr('src', lstrSource).load(function() {
		poContainer.css('background-image', 'url("'+ lstrSource +'")');
		poContainer.css('background-position', lstrPosition);
		poContainer.css('-ms-filter', '"progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + lstrSource + '\', sizingMethod=\'scale\')"');
		poContainer.css('filter', 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + lstrSource + '\', sizingMethod=\'scale\'');
	});
}





/* NAVIGATION FUNCTIONS */

function applyNavigation() {
	applyClickEvent();
	applyNavigationFixForPhone();
	applyScrollSpy();
	applyStickyNavigationPage();
//	applyStickyNavigationSite();
	applyNavToggleAction();
	navUpDownBtns();
}

function applyClickEvent() {
	$('a[href*=#]').on('click', function(e) {
		e.preventDefault();
		if( $( $.attr(this, 'href') ).length > 0 ) {
			$('html, body').animate({
				scrollTop: $( $.attr(this, 'href') ).offset().top
			}, 400);
		}
		return false;
	});
}

function applyNavigationFixForPhone() {
	$('#navbar-page li a').click(function(event) {
		$('.navbar-collapse').removeClass('in').addClass('collapse');
	});
}

function applyScrollSpy() {
	$('#navbar-page').on('activate.bs.scrollspy', function() {
		window.location.hash = $('.navbar-page .nav .active a').attr('href').replace('#', '#/');
	});
}

function applyStickyNavigationPage() {
	lnStickyNavigationPage = $('.scroll-down-page').offset().top + 20;
	$(window).on('scroll', function() {  
		stickyNavigationPage();  
	});  
	stickyNavigationPage();
}

function stickyNavigationPage() {         
	if($(window).scrollTop() > lnStickyNavigationPage) {   
		$('body').addClass('fixed-page');  
	} 
	else {  
		$('body').removeClass('fixed-page');   
	}  
}

function navUpDownBtns() {
	var upBtn = $('#scroll-up');
	var downBtn = $('#scroll-down');
	// pressing top and bottom arrow buttons on floating nav menu action
	function prevSection() {
		if ($('.nav li.active').prev().hasClass('scroller')) return;
		$('.nav li.active').prev().find('a').click();
	}
	function nextSection() {
		if ($('.nav li.active').next().hasClass('scroller')) return;
		$('.nav li.active').next().find('a').click();
	}
	upBtn.on('click', function() { prevSection() });
	downBtn.on('click', function() { nextSection() });
	// key up and down action
	var allowed = true;
	$(document).on("keydown", function(e) {
		if (event.repeat != undefined) {
			allowed = !event.repeat;
		}
		if (!allowed) return;
		allowed = false;
		switch (e.keyCode) {
			// up
			case 38: e.preventDefault(); prevSection(); break;
			// down
			case 40: e.preventDefault(); nextSection(); break;
		}
	});
	$(document).keyup(function(e) { 
		allowed = true;
	});
	$(document).focus(function(e) { 
		allowed = true;
	});
}

/*
function applyStickyNavigationSite() {
	lnStickyNavigationSite = $('.scroll-down-site').offset().top + 0;
	$(window).on('scroll', function() {  
		stickyNavigationSite();  
	});  
	stickyNavigationSite();
}

function stickyNavigationSite() {
	if($(window).scrollTop() > lnStickyNavigationSite) {   
		$('body').addClass('fixed-site');  
	} 
	else {  
		$('body').removeClass('fixed-site');   
	}  
}
*/
function applyNavToggleAction() {
	var $navToggle = $('#navToggle');
	var $navContainer = $('#navContainer');
	var $navHover = $('#navToggle, #navContainer');
/*
	function openNav() {
		$navToggle.toggleClass('navOpen');
		$navContainer.toggleClass('navClosed');
	}
	function closeNav() {
		$navToggle.toggleClass('navOpen');
		$navContainer.toggleClass('navClosed');
	}
*/
	function toggleNav() {
		$navToggle.toggleClass('navOpen');
		$navContainer.toggleClass('navClosed');
	}
	$navToggle.on('mouseenter touchstart', function (e){
			toggleNav()
	});
	$navContainer.on('mouseleave', function (e){
			toggleNav()
/*
			if(e.target.id != 'navContainer' || e.target.id != 'navToggle') {
				e.preventDefault();
			}
*/
	});
	$(':not(#navContainer)').on('touchstart', function(e){ 
		$navToggle.removeClass('navOpen');
		$navContainer.addClass('navClosed');
	});
}


// NAV NAVIGATION MENU 
// http://codepen.io/lbebber/pen/zxpMZw
/*
var navBtn = $('.menu-button');
function openNav(){
	navBtn.addClass('open');
*/
//	navBtn.toggleClass('open');
//	$overlay.css({
//		display:"block"
//	})
//	TweenMax.to($overlay,0.1,{autoAlpha:1});
//	TweenMax.fromTo($obj,0.6,{y:-($(window).height()+$obj.height())},{delay:0.2,y:"0%",ease:Elastic.easeOut,easeParams:[1.1,0.7],force3D:true});
/*
}
function closeNav(){
	navBtn.removeClass('open');
*/
//	navBtn.toggleClass('open');
//	TweenMax.to($overlay,0.1,{delay:0.55,autoAlpha:0});
//	TweenMax.to($obj,0.55,{y:$(window).height()+$obj.height(),ease:Back.easeIn,force3D:true});
/*
}
$(".menu-button").click(function(){
    openNav();
})
$(".menu-button").click(function(){
	closeNav();
})
*/
/*
$(document).ready(function(){
  var $obj=$(".modal")
  		  ,$overlay=$(".modal-overlay")
    ,blur=$("#blur-filter").get(0)
  ;
  
  function setBlur(v){
    blur.setAttribute("stdDeviation", v);
  }
  function getPos(){
    return $obj.position();
  }
  
  var lastPos=getPos();
  function update(){
    var pos=getPos();
    var limit=20;
    var dx=Math.min(limit,Math.abs(pos.left-lastPos.left)*0.5);
    var dy=Math.min(limit,Math.abs(pos.top-lastPos.top)*0.5);
    setBlur(dx+","+dy);
    
    lastPos=pos;
    requestAnimationFrame(update);
  }
  update();
  
  var isOpen=false;
  	function openModal(){
      $overlay.css({
        display:"block"
      })
      TweenMax.to($overlay,0.1,{autoAlpha:1});
      
      TweenMax.fromTo($obj,0.6,{y:-($(window).height()+$obj.height())},{delay:0.2,y:"0%",ease:Elastic.easeOut,easeParams:[1.1,0.7],force3D:true});
  }
  function closeModal(){
    TweenMax.to($overlay,0.1,{delay:0.55,autoAlpha:0});
    TweenMax.to($obj,0.55,{y:$(window).height()+$obj.height(),ease:Back.easeIn,force3D:true});
  }
  $(".open-modal").click(function(){
	    openModal();
  })
  $(".close-modal,.modal-overlay,.input-submit").click(function(){
    closeModal();
  })
  
})
*/



/* MAILTO FUNCTION */
function applyMailTo() {
	$('a[href*=mailto]').on('click', function(e) {
		var lstrEmail = $(this).attr('href').replace('mailto:', '');
		lstrEmail = lstrEmail.split('').reverse().join('')
		$(this).attr('href', 'mailto:' + lstrEmail);
	});
}



/* RESIZE FUNCTION */
function applyResize() {
	var jTron = jQuery('.jumbotron, .overlay');
	jTron.css({ height: ($(window).height()) +'px' });
	function windowResize() {
		$(window).on('resize', function() {  
			lnStickyNavigation = $('.scroll-down-page').offset().top + 20;
			jTron.css({ height: ($(window).height()) +'px' });
		}); 
	}
	//windowResize();
	function resizeBackground() {
		jTron.height(jQuery(window).height());
	}
	//resizeBackground();
	//jQuery(window).resize(resizeBackground);
}



/* HASH FUNCTION */

function checkHash() {
	lstrHash = window.location.hash.replace('#/', '#');
	if($('a[href="'+ lstrHash +'"]').length > 0) {
		$('a[href="'+ lstrHash +'"]').trigger('click');
	}
}



/* IE7- FALLBACK FUNCTIONS */

/*
function checkBrowser() {
	var loBrowserVersion = getBrowserAndVersion();
	if(loBrowserVersion.browser == 'Explorer' && loBrowserVersion.version < 8) { 
		$('#upgrade-dialog').modal({
			backdrop: 'static',
			keyboard: false
		});
	}
}

function getBrowserAndVersion()  {
	var laBrowserData = [{
		string: 		navigator.userAgent,
		subString: 		'MSIE',
		identity: 		'Explorer',
		versionSearch: 	'MSIE'
	}];	
	return {
		browser: searchString(laBrowserData) || 'Modern Browser',
		version: searchVersion(navigator.userAgent) || searchVersion(navigator.appVersion) || '0.0'
	};
}

function searchString(paData) {
	for(var i = 0; i < paData.length; i++) {
		var lstrDataString 	= paData[i].string;
		var lstrDataProp 	= paData[i].prop;
		this.versionSearchString = paData[i].versionSearch || paData[i].identity;
		if (lstrDataString) {
			if (lstrDataString.indexOf(paData[i].subString) != -1) {
				return paData[i].identity;
			}
		}
		else if (lstrDataProp) {
			return paData[i].identity;
		}
	}
}
	
function searchVersion(pstrDataString) {
	var lnIndex = pstrDataString.indexOf(this.versionSearchString);
	if(lnIndex == -1) {
		return;
	}
	return parseFloat(pstrDataString.substring(lnIndex + this.versionSearchString.length + 1));
}	
*/


function harlemShakeFunc() {
	javascript:(function(){function c(){var e=document.createElement("link");e.setAttribute("type","text/css");e.setAttribute("rel","stylesheet");e.setAttribute("href",f);e.setAttribute("class",l);document.body.appendChild(e)}
	function h(){var e=document.getElementsByClassName(l);for(var t=0;t<e.length;t++){document.body.removeChild(e[t])}}
	function p(){var e=document.createElement("div");e.setAttribute("class",a);document.body.appendChild(e);setTimeout(function(){document.body.removeChild(e)},100)}
	function d(e){return{height:e.offsetHeight,width:e.offsetWidth}}
	function v(i){var s=d(i);return s.height>e&&s.height<n&&s.width>t&&s.width<r}
	function m(e){var t=e;var n=0;while(!!t){n+=t.offsetTop;t=t.offsetParent}
	return n}
	function g(){var e=document.documentElement;if(!!window.innerWidth){return window.innerHeight}else if(e&&!isNaN(e.clientHeight)){return e.clientHeight}
	return 0}
	function y(){if(window.pageYOffset){return window.pageYOffset}
	return Math.max(document.documentElement.scrollTop,document.body.scrollTop)}
	function E(e){var t=m(e);return t>=w&&t<=b+w}
	function S(){var e=document.createElement("audio");e.setAttribute("class",l);e.src=i;e.loop=false;e.addEventListener("canplay",function(){setTimeout(function(){x(k)},500);setTimeout(function(){N();p();for(var e=0;e<O.length;e++){T(O[e])}},15500)},true);e.addEventListener("ended",function(){N();h()},true);e.innerHTML=" <p>If you are reading this, it is because your browser does not support the audio element. We recommend that you get a new browser.</p> <p>";document.body.appendChild(e);e.play()}
	function x(e){e.className+=" "+s+" "+o}
	function T(e){e.className+=" "+s+" "+u[Math.floor(Math.random()*u.length)]}
	function N(){var e=document.getElementsByClassName(s);var t=new RegExp("\\b"+s+"\\b");for(var n=0;n<e.length;){e[n].className=e[n].className.replace(t,"")}}
	var e=30;var t=30;var n=350;var r=350;var i="//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake.mp3";var s="mw-harlem_shake_me";var o="im_first";var u=["im_drunk","im_baked","im_trippin","im_blown"];var a="mw-strobe_light";var f="//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake-style.css";var l="mw_added_css";var b=g();var w=y();var C=document.getElementsByTagName("*");var k=null;for(var L=0;L<C.length;L++){var A=C[L];if(v(A)){if(E(A)){k=A;break}}}
	if(A===null){console.warn("Could not find a node of the right size. Please try a different page.");return}
	c();S();var O=[];for(var L=0;L<C.length;L++){var A=C[L];if(v(A)){O.push(A)}}})()
}
$('#harlem-shake').on('click', function(){harlemShakeFunc();});

function browserCheck() {
    /* Check User Agent (Browser) for a particular browser type */  
	function checkBrowserName(name){  
		var agent = navigator.userAgent.toLowerCase();  
		if (agent.indexOf(name.toLowerCase())>-1) {  
			return true;  
		}  
		return false;  
	}  
	if(checkBrowserName('MSIE')){  
		//console.log('Du bist ein Explorer!');  
	}  
	if(checkBrowserName('opera')){  
		//console.log('Aha, ein Opernfreund!');  
	}  
	if(checkBrowserName('firefox')){  
		//console.log('Füchse vor!');  
	}  
	if(checkBrowserName('safari')){  
		//console.log('Auf geht\'s zur Safari!');  
/*
		for (var i = 0; i < document.getElementsByTagName("img").length; i++) {
			document.getElementsByTagName("img")[i].style.width = "auto";
		}
*/
    }
}
//browserCheck();

// fitvids to make all videos full width http://fitvidsjs.com/  
// (function(e){"use strict";e(function(){e(".the-content").fitVids()})})(jQuery);