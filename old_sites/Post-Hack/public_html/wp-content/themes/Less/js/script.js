/* <!-- Console Message Code --> */	
/*     <script type='text/javascript'> */
    
	    (function(){
		    try{
        	 var msg = '\n       d8888               888                      888888b.            888          888                     \n      d88888               888                      888  "88b           888          888                     \n     d88P888               888                      888  .88P           888          888                     \n    d88P 888 88888b.   .d88888 888d888 .d88b.       8888888K.  888  888 888  8888b.  888888 .d88b.  888  888 \n   d88P  888 888 "88b d88" 888 888P"  d8P  Y8b      888  "Y88b 888  888 888     "88b 888   d88""88b 888  888 \n  d88P   888 888  888 888  888 888    88888888      888    888 888  888 888 .d888888 888   888  888 Y88  88P \n d8888888888 888  888 Y88b 888 888    Y8b.          888   d88P Y88b 888 888 888  888 Y88b. Y88..88P  Y8bd8P  \nd88P     888 888  888  "Y88888 888     "Y8888       8888888P"   "Y88888 888 "Y888888  "Y888 "Y88P"    Y88P   \n';
                msg += '============================================================================================================\n01000001 01101110 01100100 01110010 01100101  01000010 01110101 01101100 01100001 01110100 01101111 01110110\n============================================================================================================\nHeya! How\'s it going? I see you opened the console! What ya doing here? Know some code, do you? Want to work\nfor one of the best people around? Seriously, I\'m awesome! Contact me  @     http://andrebulatov.com/contact\n============================================================================================================\n';
                console.log(msg);
            }catch(e){}
        })()
        
/*     </script>  */
/* <!-- END Console Message Code -->	 */





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

function applyHeader()
{
	$('.jumbotron').css({ height: ($(window).height()) +'px' });
	
	lazyLoad($('.jumbotron'));
}	

function lazyLoad(poContainer)
{
	/*var lstrSource   = poContainer.attr('data-src');
	var lstrPosition = poContainer.attr('data-position');

	$('<img>').attr('src', lstrSource).load(function()
	{
		poContainer.css('background-image', 'url("'+ lstrSource +'")');
		poContainer.css('background-position', lstrPosition);
		poContainer.css('-ms-filter', '"progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + lstrSource + '\', sizingMethod=\'scale\')"');
		poContainer.css('filter', 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + lstrSource + '\', sizingMethod=\'scale\'');
	});*/
}





/* NAVIGATION FUNCTIONS */

function applyNavigation()
{
	applyClickEvent();
	applyNavigationFixForPhone();
	applyScrollSpy();
	applyStickyNavigationPage();
//	applyStickyNavigationSite();
	navToggleAction();
}

function applyClickEvent()
{
	$('a[href*=#]').on('click', function(e)
	{
		e.preventDefault();
		
		if( $( $.attr(this, 'href') ).length > 0 )
		{
			$('html, body').animate(
			{
				scrollTop: $( $.attr(this, 'href') ).offset().top
			}, 400);
		}
		return false;
	});
}

function applyNavigationFixForPhone()
{
	$('#navbar-page li a').click(function(event) 
	{
		$('.navbar-collapse').removeClass('in').addClass('collapse');
	});
}

function applyScrollSpy()
{
	$('#navbar-page').on('activate.bs.scrollspy', function() 
	{
		window.location.hash = $('.navbar-page .nav .active a').attr('href').replace('#', '#/');
	});
}

function applyStickyNavigationPage()
{
	lnStickyNavigationPage = $('.scroll-down-page').offset().top + 20;
	
	$(window).on('scroll', function() 
	{  
		stickyNavigationPage();  
	});  
	
	stickyNavigationPage();
}

function stickyNavigationPage()
{         
	if($(window).scrollTop() > lnStickyNavigationPage) 
	{   
		$('body').addClass('fixed-page');  
	} 
	else 
	{  
		$('body').removeClass('fixed-page');   
	}  
}

/*
function applyStickyNavigationSite()
{
	lnStickyNavigationSite = $('.scroll-down-site').offset().top + 0;
	
	$(window).on('scroll', function() 
	{  
		stickyNavigationSite();  
	});  
	
	stickyNavigationSite();
}

function stickyNavigationSite()
{         
	if($(window).scrollTop() > lnStickyNavigationSite) 
	{   
		$('body').addClass('fixed-site');  
	} 
	else 
	{  
		$('body').removeClass('fixed-site');   
	}  
}
*/
function navToggleAction() {
	var $navToggle = $('#navToggle');
	var $navContainer = $('#navContainer');
	$navToggle.on({
		click: function (event){
			$navContainer.toggleClass('navClosed');
		}
	});
}





/* MAILTO FUNCTION */

function applyMailTo()
{
	$('a[href*=mailto]').on('click', function(e)
	{
		var lstrEmail = $(this).attr('href').replace('mailto:', '');
		console.log(lstrEmail);
		lstrEmail = lstrEmail.split('').reverse().join('')
		console.log(lstrEmail);
		
		$(this).attr('href', 'mailto:' + lstrEmail);
	});
}





/* RESIZE FUNCTION */

function applyResize()
{
	$(window).on('resize', function() 
	{  
		lnStickyNavigation = $('.scroll-down-page').offset().top + 20;
	
		$('.jumbotron').css({ height: ($(window).height()) +'px' });
	}); 
}





/* HASH FUNCTION */

function checkHash()
{
	lstrHash = window.location.hash.replace('#/', '#');
	
	if($('a[href="'+ lstrHash +'"]').length > 0)
	{
		$('a[href="'+ lstrHash +'"]').trigger('click');
	}
}





/* IE7- FALLBACK FUNCTIONS */

/*
function checkBrowser()
{
	var loBrowserVersion = getBrowserAndVersion();
	
	if(loBrowserVersion.browser == 'Explorer' && loBrowserVersion.version < 8)
	{ 
		$('#upgrade-dialog').modal({
			backdrop: 'static',
			keyboard: false
		});
	}
}

function getBrowserAndVersion() 
{
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

function searchString(paData) 
{
	for(var i = 0; i < paData.length; i++)	
	{
		var lstrDataString 	= paData[i].string;
		var lstrDataProp 	= paData[i].prop;
		
		this.versionSearchString = paData[i].versionSearch || paData[i].identity;
		
		if(lstrDataString) 
		{
			if(lstrDataString.indexOf(paData[i].subString) != -1)
			{
				return paData[i].identity;
			}
		}
		else if(lstrDataProp)
		{
			return paData[i].identity;
		}
	}
}
	
function searchVersion(pstrDataString) 
{
	var lnIndex = pstrDataString.indexOf(this.versionSearchString);
	
	if(lnIndex == -1) 
	{
		return;
	}
	
	return parseFloat(pstrDataString.substring(lnIndex + this.versionSearchString.length + 1));
}	
*/



    /* Check User Agent (Browser) for a particular browser type */  
    /* http://stackoverflow.com/questions/14718033/responsive-images-wont-scale-with-firefox-as-screen-size-is-adjusted-works-in */
    function checkBrowserName(name){  
       var agent = navigator.userAgent.toLowerCase();  
       if (agent.indexOf(name.toLowerCase())>-1) {  
         return true;  
       }  
       return false;  
     }  

    if(checkBrowserName('MSIE')){  
      console.log('Du bist ein Explorer!');  
    }  
      
    if(checkBrowserName('opera')){  
      console.log('Aha, ein Opernfreund!');  
    }  
      
    if(checkBrowserName('firefox')){  
      console.log('Füchse vor!');  
    }  
          
    if(checkBrowserName('safari')){  
      console.log('Auf geht\'s zur Safari!');  
      for (var i = 0; i < document.getElementsByTagName("img").length; i++) {
		  document.getElementsByTagName("img")[i].style.width = "auto";
		  }
    }