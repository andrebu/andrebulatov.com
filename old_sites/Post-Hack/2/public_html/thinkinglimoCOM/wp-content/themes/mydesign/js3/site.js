var twitterFetcher=function(){
    function x(e){
        return e.replace(/<b[^>]*>(.*?)<\/b>/gi,function(c,e){return e}).replace(/class=".*?"|data-query-source=".*?"|dir=".*?"|rel=".*?"/gi,"")
    }
    function p(e,c){
        for(var g=[],f=RegExp("(^| )"+c+"( |jQuery)"),a=e.getElementsByTagName("*"),h=0,d=a.length;h<d;h++)f.test(a[h].className)&&g.push(a[h]);return g
    }
    var y="",l=20,s=!0,k=[],t=!1,q=!0,r=!0,u=null,v=!0,z=!0,w=null,A=!0;
    return{
        fetch:function(e,c,g,f,a,h,d,b,m,n){
            void 0===g&&(g=20);
            void 0===f&&(s=!0);
            void 0===a&&(a=!0);
            void 0===h&&(h=!0);
            void 0===d&&(d="default");
            void 0===b&&(b=!0);
            void 0===m&&(m=null);
            void 0===n&&(n=!0);
            t?k.push({id:e,domId:c,maxTweets:g,enableLinks:f,showUser:a,showTime:h,dateFunction:d,showRt:b,customCallback:m,showInteraction:n}):(t=!0,y=c,l=g,s=f,r=a,q=h,z=b,u=d,w=m,A=n,c=document.createElement("script"),c.type="text/javascript",c.src="//cdn.syndication.twimg.com/widgets/timelines/"+e+"?&lang=en&callback=twitterFetcher.callback&suppress_response_codes=true&rnd="+Math.random(),document.getElementsByTagName("head")[0].appendChild(c))},
callback:function(e){
    var c=document.createElement("div");
    c.innerHTML=e.body;
    "undefined"===typeof c.getElementsByClassName&&(v=!1);
    e=[];
    var g=[],f=[],a=[],h=[],d=0;
    if(v)for(c=c.getElementsByClassName("tweet");d<c.length;){
        0<c[d].getElementsByClassName("retweet-credit").length?a.push(!0):a.push(!1);
        if(!a[d]||a[d]&&z)e.push(c[d].getElementsByClassName("e-entry-title")[0]),h.push(c[d].getAttribute("data-tweet-id")),g.push(c[d].getElementsByClassName("p-author")[0]),f.push(c[d].getElementsByClassName("dt-updated")[0]);
        d++}
        else for(c=p(c,"tweet");d<c.length;)e.push(p(c[d],"e-entry-title")[0]),h.push(c[d].getAttribute("data-tweet-id")),g.push(p(c[d],"p-author")[0]),f.push(p(c[d],"dt-updated")[0]),0<p(c[d],"retweet-credit").length?a.push(!0):a.push(!1),d++;e.length>l&&(e.splice(l,e.length-l),g.splice(l,g.length-l),f.splice(l,f.length-l),a.splice(l,a.length-l));c=[];d=e.length;for(a=0;a<d;){if("string"!==typeof u){var b=new Date(f[a].getAttribute("datetime").replace(/-/g,"/").replace("T"," ").split("+")[0]),b=u(b);
        f[a].setAttribute("aria-label",b);if(e[a].innerText)if(v)f[a].innerText=b;else{var m=document.createElement("p"),n=document.createTextNode(b);m.appendChild(n);m.setAttribute("aria-label",b);f[a]=m}else
        f[a].textContent=b}
        b="";


        s?(r&&(b+='<div class="twitter-title">'+x(g[a].innerHTML)+"</div>"),
        b+='<p class="twitter-text">'+x(e[a].innerHTML)+"</p>",
        q&&(b+='<p class="timePosted">'+f[a].getAttribute("aria-label")+"</p>")):e[a].innerText?(r&&(b+='<p class="user">'+g[a].innerText+"</p>"),
        b+='<p class="tweet">'+e[a].innerText+"</p>",q&&(b+='<p class="timePosted">'+f[a].innerText+"</p>")):(r&&(b+='<p class="user">'+g[a].textContent+"</p>"),
        b+='<p class="tweet">'+e[a].textContent+"</p>",q&&(b+='<p class="timePosted">'+f[a].textContent+"</p>"));



        A&&(b+='');c.push(b);a++}if(null==w){e=c.length;g=0;f=document.getElementById(y);for(h="<ul>";g<e;)h+="<li>"+c[g]+"</li>",g++;f.innerHTML=h+"</ul>"}else w(c);t=!1;0<k.length&&(twitterFetcher.fetch(k[0].id,k[0].domId,k[0].maxTweets,k[0].enableLinks,k[0].showUser,k[0].showTime,k[0].dateFunction,k[0].showRt,k[0].customCallback,k[0].showInteraction),k.splice(0,1))}}}();





jQuery(document).ready(function(){
   
         // Calling LayerSlider on your selected element after the document loaded
        jQuery('#layerslider').layerSlider({
 
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
    skin                    : 'mydesign',
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
    delayOut                : 0     });

   jQuery('#layerslider2').layerSlider({
 
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
    skin                    : 'mydesign',
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

   if (jQuery('#contact_form').length > 0) {
        jQuery('#contact_form').ajaxForm({ target: '#contact_alert' });
    }

var $windowWidth = jQuery(window).width();
if( $windowWidth >= 500) {
    tiles2 = jQuery('.fadeitin');
}

    tiles2.each(function(i) {
    a = jQuery(this).offset().top + jQuery(this).height();
        b = jQuery(window).scrollTop() + jQuery(window).height();
        if (a > b) jQuery(this).fadeTo(0, 0);
    });

  jQuery("#mmenu").hide();
    jQuery(".mtoggle").click(function() {
        jQuery("#mmenu").slideToggle(500);
    });
    
    


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

var heights4 = jQuery(".tile-title").map(function ()
    {
        return jQuery(this).height();
    }).get();

    maxHeight4 = Math.max.apply(null, heights4);
    
jQuery('.tile-title').stop(true,true).animate({
                'height' : maxHeight4
            },{queue:false, duration:450, easing: 'easeOutCubic'}); 







  var tid = '377205624066433024';
    var user_id = jQuery('#ftwitter').attr('user-id');

        tid = user_id;
   function handleTweets(tweets){
          var x = tweets.length;
          var n = 0;
          var element = document.getElementById('ftwitter');
          var html = '<ul class="ftwitt2">';
          while(n < x) {
            html += '<li>' + tweets[n] + '</li>';
            n++;
          }
          html += '</ul>';
          element.innerHTML = html;

          jQuery('#ftwitter a').attr ('target', '_blank');

          jQuery('.flattwitter').fadeIn(1500);

          jQuery('.ftwitt2').list_ticker({
            speed:4000,
            effect:'fade'
        });
      }
      twitterFetcher.fetch(tid, '', 3, true, true, false, '', false, handleTweets);








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








//*** Progress Bar Jquery ***//
function progress(percent, element, color) {
var progressBarWidth = percent * element.width() / 100;
element.find('div').css('background', color);
element.find('div').animate({ width: progressBarWidth }, 6000).html("<div class='progress-meter'>"+percent+"%&nbsp;</div>");

}


});

jQuery(window).scroll(function(d,h) {
    tiles2.each(function(i) {
        a = jQuery(this).offset().top + jQuery(this).height();
        b = jQuery(window).scrollTop() + jQuery(window).height();
        if (a < b){ jQuery(this).stop(true,false).fadeTo(1000,1);
          jQuery(this).removeClass('fadeitin');
          tiles2 = jQuery('.fadeitin');
        }
      
    });

 }); // end scroll function






jQuery(window).load(function(){
   
var heights3 = jQuery(".team-name").map(function ()
    {
        return jQuery(this).height();
    }).get();

    maxHeight3 = Math.max.apply(null, heights3);
    
jQuery('.team-name').stop(true,true).animate({
                'height' : maxHeight3
            },{queue:false, duration:450, easing: 'easeOutCubic'}); 


 }); 



  jQuery(function(){
    
    var jQuerycontainer = jQuery('#container2');

    jQuerycontainer.isotope({
      itemSelector : '.element'
    });
    

    
    var jQueryoptionSets = jQuery('#options .option-set'),
        jQueryoptionLinks = jQueryoptionSets.find('a');

    jQueryoptionLinks.click(function(){
        jQuery(".project-window").slideUp("slow");
      var jQuerythis = jQuery(this);
      // don't proceed if already selected
      if ( jQuerythis.hasClass('selected') ) {
        return false;
      }
      var jQueryoptionSet = jQuerythis.parents('.option-set');
      jQueryoptionSet.find('.selected').removeClass('selected');
      jQueryoptionSet.find('.selected').find('.portfolio-btn').removeClass('selected');
      jQuerythis.addClass('selected');
      jQuerythis.find('.portfolio-btn').addClass('selected');
      

      // make option object dynamically, i.e. { filter: '.my-filter-class' }
      var options = {},
          key = jQueryoptionSet.attr('data-option-key'),
          value = jQuerythis.attr('data-option-value');
      // parse 'false' as false boolean
      value = value === 'false' ? false : value;
      options[ key ] = value;
      if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
        // changes in layout modes need extra logic
        changeLayoutMode( jQuerythis, options )
      } else {
        // otherwise, apply new options
        jQuerycontainer.isotope( options );
      }
      
      return false;
    });
  });