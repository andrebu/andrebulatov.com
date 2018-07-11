(function(jQuery) {
// JavaScript Document
jQuery(document).ready(function() {

	/*global jQuery:false */
	var obert=false;

	jQuery('ul.slideshow li').addClass('ocult');
	jQuery('ul.slideshow li:first-child').removeClass('ocult').addClass('visi');

	function mostra(){
		if(!jQuery('.slideshow .visi').next().length){
			jQuery('.slideshow .visi').removeClass('visi').addClass('ocult');
			jQuery('ul.slideshow li:first-child').removeClass('ocult').addClass('visi');
		}else{
			jQuery('.slideshow .visi').removeClass('visi').addClass('ocult').next().removeClass('ocult').addClass('visi');
		}
	}

	// ----------- FREEBIES IPHONE SLIDESHOW ----------- //
	var i=0;
	var timer=null;

	function start(){
		timer = setInterval(function() {mostra(i);}, 4000);
	}

	start();

// ----------- TEAM SOCIAL MENU ----------- //

	// jQuery(".photo-footer").mouseenter(function() {
	// 		jQuery(".plus-btn", this).stop().animate({top:70},'fast');
	// });

	// jQuery(".photo-footer").mouseleave(function() {
	// 		jQuery(".plus-btn", this).stop().animate({top:0},'fast');
	// });
	
	// ----------- TEAM NEXT/PREV ----------- //

	// var y=0;

	// jQuery(".dir-right").click(function() {
	// 	if(!jQuery(this).hasClass('disable-2')){
	// 		jQuery(".jump"+(y+1)).click();
	// 	}
	// });

	// jQuery(".dir-left").click(function() {
	// 	if(!jQuery(this).hasClass('disable')){
	// 		jQuery(".jump"+(y-1)).click();
	// 	}
	// });

	// var teams = jQuery('.team li');
	// var dotsul = '';
	// teams.each(function (index) {
	// 	if (index===0){dotsul = '<ul class="dotsmenu">';}
	// 	dotsul += '<li class="dots jump' + index + '" id="' + index + '"></li>';
	// 	if (index===teams.length-1) {
	// 		dotsul += '</ul>';
	// 		jQuery('.team').after(dotsul);
	// 	}
	// });
	// ----------- TEAM DOTS ----------- //


	jQuery(".dots").click(function() {

			jQuery(".teamshow").stop().animate({scrollLeft:pos[jQuery(this).attr('id')]},'slow');
			jQuery('.activo').removeClass('activo');
			jQuery(this).addClass('activo');
			y=parseInt(jQuery(this).attr('id'),10);

			if(y===0){jQuery('.dir-left').addClass('disable');}else{jQuery('.dir-left').removeClass('disable');}

			if(tamany>2){
				if(y===2){jQuery('.dir-right').addClass('disable-2');}else{jQuery('.dir-right').removeClass('disable-2');}
			}else
			if(tamany===2){
				if(y===8){jQuery('.dir-right').addClass('disable-2');}else{jQuery('.dir-right').removeClass('disable-2');}
			}else
			if(tamany===1){
				if(y===8){jQuery('.dir-right').addClass('disable-2');}else{jQuery('.dir-right').removeClass('disable-2');}
			}
	});

	var res= null;
	var tamany= null;
	var pos= null;
	var old= null;
	recalcul();

	jQuery(window).bind("resize", function(){
		old=tamany;
		recalcul();
		if(old!==tamany){
			jQuery(".jump0").click();
			if(obert===true){obre(jQueryactual.attr('id'));}
		}
		
		magia();
	});

	function recalcul(){
		res=jQuery(window).width();
		if (res > 959) { tamany=4; pos=[0,900,1800];} else
		if (res > 767) { tamany=3; pos=[0,780,1555]; } else
		if (res > 479) { tamany=2; pos=[0, 302, 604, 903, 1204, 1507, 1782, 2085, 2385];} else
		if (res < 480) { tamany=1; pos=[0, 302, 604, 903, 1204, 1507, 1782, 2085, 2385]; }
	}

// ----------- PROJECT WINDOW SHOW/HIDE ----------- //

// 	var jQueryactual= null;

// 	jQuery(".ch-grid").click(function() {
// 			jQuery.scrollTo( jQuery('#project-show'), 800, {offset:-130});
// 			obre(jQuery(this).attr('id'));
// 			jQueryactual=jQuery(this);
// //			alert(jQuery('.project-content').position().top)
// //			jQuery('html,body').animate({scrollTop:(jQuery('.project-content').position().top)+165}, 1000);
// 	});

// 	jQuery(".portfolio-btn").click(function() {
// 			obert=false;
// 	});
			
// 	function obre(quin){
// 	jQuery.ajax({
// 		//type: "POST",
// 		//data: { id: jQuery(this).attr('cid')},
// 		url: quin,
// 		success: function(data) {


// 			jQuery('.project-content').html(data);
			
// 			/*  Gallery Works */
// 			function portfolio(){
				
// 			l = jQuery(".thumb-project li").length;
// 			ample=jQuery(".img-project").width();
// 			jQuery('.thumb-project').css('width',ample*l)
// 			jQuery('.thumb-project li').css('width',ample)
			
// 			ini = 1;
// 			jQuery(".img-prev").css('display', 'none');
// 			jQuery(".thumb-project").stop().animate({scrollLeft:0},'fast');
			
// 			jQuery(".img-next").click(function(){
// 			  jQuery(".img-project").stop().animate({scrollLeft:"+="+ample},'slow');
// 			  ini++;
// 			  if(ini>=l){
// 			  ini=l;
// 			  jQuery(".img-next").css('display', 'none');
// 			  }else{
// 				  jQuery(".img-prev").css('display', 'block');
// 			  }
// 			  //alert(ini);
// 		  	 });
		   
// 			jQuery(".img-prev").click(function(){
// 			  jQuery(".img-project").stop().animate({scrollLeft:"-="+ample},'slow');
// 			  ini--;
// 			  if(ini<=1){
// 			  ini=1;
// 			  jQuery(".img-prev").css('display', 'none');
			  
// 			  }else{
// 				 jQuery(".img-next").css('display', 'block'); 
// 			  }
// 			  //alert(ini);
// 		   	});
			
// 			/*if(ini=1){
// 			  jQuery(".img-prev").css('display', 'none');
// 			  }else{
// 			  jQuery(".img-prev").css('display', 'block');	
// 			}
// 			if(ini=l){
// 			  jQuery(".img-next").css('display', 'none');
// 			  }else{
// 			  jQuery(".img-next").css('display', 'block');	
// 			}*/
			
// 		}
// 		portfolio();
		
// 		tanca();
// 		dots();
// 		canvia();
// 		if( obert===false){jQuery(".project-window").slideDown("slow");}
// 		obert=true;
			
// 		//per calcular la alçada per animar
// /*        var jQuerynewHTML  = jQuery('<div class="dummy" style="position : absolute; left : -9999px;">' + data + '</div>').appendTo('body'),
//         theHeight = jQuerynewHTML.height();
// 		alert(theHeight)
// 		jQuery('.project-content').css('height',theHeight);
//         jQuery('.dummy').remove();*/
			
// 			/*  end Gallery Works */
// 		}
// 	});
// 	}


	// function tanca(){

	// 	jQuery(".close").click(function() {
	// 		jQuery(".project-window").slideUp("slow");
	// 		obert=false;
	// 	});

	// }


	// function seguent(){
	// 	if(jQueryactual.parent().next().hasClass('final')){
	// 		jQueryactual=jQuery(jQuery('.inici').next().children('.ch-grid'));
	// 	}else{
	// 		jQueryactual=jQuery(jQueryactual.parent().next().children('.ch-grid'));
	// 	}

	// 	if(jQueryactual.parent().hasClass('isotope-hidden')){
	// 		seguent();
	// 	}else{
	// 		obre(jQueryactual.attr('id'));
	// 	}
	// }

	// function enrera(){
	// 	if(jQueryactual.parent().prev().hasClass('inici')){
	// 		jQueryactual=jQuery(jQuery('.final').prev().children('.ch-grid'));
	// 	}else{
	// 		jQueryactual=jQuery(jQueryactual.parent().prev().children('.ch-grid'));
	// 	}

	// 	if(jQueryactual.parent().hasClass('isotope-hidden')){
	// 		enrera();
	// 	}else{
	// 		obre(jQueryactual.attr('id'));
	// 	}
	// }

	// function canvia(){

	// 	jQuery('.btn-next').click(function() {
	// 		seguent();
	// 	});
	// 	jQuery('.btn-prev').click(function() {
	// 		enrera();
	// 	});
	// }


	// // ----------- PORTFOLIO DOTS ----------- //
	// function dots(){

	// jQuery(".jump12").click(function() {
	// 		jQuery(".img-project").stop().animate({scrollLeft:0},'slow');
	// 		jQuery('.activo2').removeClass('activo2');
	// 		jQuery(this).addClass('activo2');
	// });

	// jQuery(".jump22").click(function() {
	// 		jQuery(".img-project").stop().animate({scrollLeft:694},'slow');
	// 		jQuery('.activo2').removeClass('activo2');
	// 		jQuery(this).addClass('activo2');
	// });

	// jQuery(".jump32").click(function() {
	// 		jQuery(".img-project").stop().animate({scrollLeft:1388},'slow');
	// 		jQuery('.activo2').removeClass('activo2');
	// 		jQuery(this).addClass('activo2');
	// });

	// jQuery(".jump42").click(function() {
	// 		jQuery(".img-project").stop().animate({scrollLeft:2082},'slow');
	// 		jQuery('.activo2').removeClass('activo2');
	// 		jQuery(this).addClass('activo2');
	// });
	// jQuery(".jump52").click(function() {
	// 		jQuery(".img-project").stop().animate({scrollLeft:2776},'slow');
	// 		jQuery('.activo2').removeClass('activo2');
	// 		jQuery(this).addClass('activo2');
	// });
	// jQuery(".jump62").click(function() {
	// 		jQuery(".img-project").stop().animate({scrollLeft:3470},'slow');
	// 		jQuery('.activo2').removeClass('activo2');
	// 		jQuery(this).addClass('activo2');
	// });

	// jQuery(".jump72").click(function() {
	// 		jQuery(".img-project").stop().animate({scrollLeft:4164},'slow');
	// 		jQuery('.activo2').removeClass('activo2');
	// 		jQuery(this).addClass('activo2');
	// });
	// jQuery(".jump82").click(function() {
	// 		jQuery(".img-project").stop().animate({scrollLeft:4857},'slow');
	// 		jQuery('.activo2').removeClass('activo2');
	// 		jQuery(this).addClass('activo2');
	// });
	// }


	// // ----------------- EASING ANCHORS ------------------ //

	jQuery('a[href*=#]').click(function() {

     if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {

             var jQuerytarget = jQuery(this.hash);

             jQuerytarget = jQuerytarget.length && jQuerytarget || jQuery('[name=' + this.hash.slice(1) +']');

             if (jQuerytarget.length) {

                 var targetOffset = jQuerytarget.offset().top;

                 jQuery('html,body').animate({scrollTop: targetOffset-100}, 1000);

                 return false;

            }

       }

   });

 //   //parallax

	// jQuery(window).bind("scroll", function(){//when the user is scrolling...
	// 	Move('.paraOn'); //move the background images in relation to the movement of the scrollbar
	// });

	// function Move(seccio){
	// 	jQuery(seccio).each(function(){
	// 		if(jQuery(this).attr('id')==='banner'){
	// 			jQuery(this).css('background-position', '0 '+jQuery(window).scrollTop()/3+'px');
	// 		}else{
	// 			jQuery(this).css('background-position', '0 '+((jQuery(window).scrollTop()+jQuery(window).height()-jQuery(this).attr('yPos'))/3+jQuery(this).height())+'px');
	// 		}
	// 	});
	// }

   //inview

//    jQuery('.parallax').bind('inview', function (event, visible) {
// 		if (visible === true) {
// 		// element is now visible in the viewport
// 		var offset = jQuery(this).offset();
// 		jQuery(this).addClass('paraOn').attr('yPos',offset.top);
// 		} else {
// 		// element has gone out of viewport
// 		jQuery(this).removeClass('paraOn');
// 		}
// });

});// JavaScript Document
})(jQuery);


/*  Recent Works Slider */

function bullets(){ // Automatic Adding Bullets
	
	var q = jQuery("#slider li").length;
    fragment = document.createDocumentFragment(),

    li = document.createElement('li');
	while (q--) {
		fragment.appendChild(li.cloneNode(true));
	}
	jQuery('.bullets ul').append(fragment);
}// end Automatic Adding Bullets
bullets();

var n = jQuery("#slider li").length;


function magia(){
	res=jQuery(window).width();
	jQuery('#slider').css('width',res*n)
	jQuery('#slider li').css('width',res)
	
	jQuery('.bullets ul li').removeClass('selected');
	jQuery('.bullets ul li:first-child').addClass('selected');
	
	jQuery(".anythingSlider").stop().animate({scrollLeft:0},'fast');
}	


	var index = 0;
	var pos = 1;

	jQuery(".next").click(function(){
		if( index != jQuery(".bullets ul li").size()-1){
		  index++;
		  jQuery(".anythingSlider").stop().animate({scrollLeft:res*index},'slow');
		  pos++;
		  jQuery('.bullets ul li.selected').removeClass('selected').next().addClass('selected');
	}
	  //jQuery('.bullets ul li:nth-child("pos")').addClass('selected');
	  //alert(pos);
	  
   });
   
	jQuery(".prev").click(function(){
	  if( index!=0 ){
		  index--;
		  jQuery(".anythingSlider").stop().animate({scrollLeft:res*index},'slow');
		  pos--;
		  jQuery('.bullets ul li.selected').removeClass('selected').prev().addClass('selected');
	  }
	  //jQuery('.bullets ul li:nth-child("pos")').addClass('selected');
	  //alert(pos);
	  
   });
   
   jQuery(".bullets ul li").click(function(){
	   index = jQuery(this).index();
	   jQuery(".anythingSlider").stop().animate({scrollLeft:res*index},'slow');
	   jQuery('.bullets ul li').removeClass('selected');
	   jQuery(this).addClass('selected');
   });

magia();