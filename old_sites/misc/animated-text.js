var 
	introContent = $('.content'),
	mobileBGs = $('.mobileBGs'),
	h1 = $('.content h1'),
	h2 = $('.content .answer h2'),
	h3 = $('.content h3'),
	button = $('.content a'),
	hr = $('.content hr'),
	video = $('video')[0],
	overlay = $('.overlay'),
	answerTL, wideIntroTL, mobileIntroTL, mobileTimerTween, hrW, curScene = 0, curTime, maxScenes, videoNewSection = false, imageDownloadCount = 0, mobileBGList = [], downloadTimer,
	/* answer text for each slide */
	answers = [
	    		"Share your story.",
	    		"Persuade voters.",
	    		"Inspire action.",
	    		"Change the world.",
	    		"We can help."
		    ],
	/* what time each slide begins */
	times = [
	    		3,
	    		8,
	    		14,
	    		20,
	    		26
    ],
	/* how long each slide plays for on mobile */
	mobileTimes = [8,5,5,5,7],
	/* opacity of the video's overlay */
	overlays = [
	    		.4,
	    		.6,
	    		.65,
	    		.6,
	    		.65
	],
	mobileImages = [
		"/sites/all/themes/blueprint/images/mobile_feature_1.jpg",
		"/sites/all/themes/blueprint/images/mobile_feature_2.jpg",
		"/sites/all/themes/blueprint/images/mobile_feature_3.jpg",
		"/sites/all/themes/blueprint/images/mobile_feature_4.jpg",
		"/sites/all/themes/blueprint/images/mobile_feature_5.jpg"
	],
	videoSrc = "/sites/all/themes/blueprint/video/ck71utubgm8v6903nlez6r2lbkg89hra.mp4";
;

function initWideFeature() {console.log("initWideFeature");
	maxScenes = answers.length;
	
	h2.text(answers[curScene]);
	hrW = h2.width() + 15; //console.log("hrW: " + hrW);
	
	TweenMax.set([h1, h3, button], {opacity: 0, y: 40});
	TweenMax.set(h2, {opacity: 0});
	TweenMax.set(hr, {width: "1px", transformOrigin: "50%, 0", opacity: 0});
	TweenMax.set(video, {display: "block"});
	
	video.addEventListener("timeupdate", function(event) {
		curTime = parseInt(this.currentTime);
		//console.log("curTime: " + curTime);
		if(curTime >= times[curScene]) {
			if(!videoNewSection) {console.log("new section");
				//videoNewSection = true;
				animateNewWideAnswer();
			}
		}
	});
	video.addEventListener("ended", function(event) {
		curScene = 0;
		times[0] = 0;
		video.currentTime = 0;
		video.play();
	});
	video.addEventListener("playing", function(event) {
		animateWideIntroScene();
	});
	video.src = videoSrc;
	video.play();
}

function initMobileFeature() {console.log("initMobileFeature");
	maxScenes = answers.length;
	
	//var downloadingImage;
	var element;
	for(var i = 0; i < maxScenes; i++) {
		//console.log("i: " + i);
		element = '<div class="bg' + i + '"></div>'; //console.log("element: " + element);
		mobileBGs.append(element);	//console.log("ELEMENT: " + element);
		mobileBGList[i] = mobileBGs.find('div:nth-of-type(' + (i + 1) + ')');
		var downloadingImage = new Image();
		downloadingImage.num = i;
		downloadingImage.onload = function() {
			//console.log("Set bg of <div class='bg" + this.num + "' to " + mobileImages[this.num]);
			TweenMax.set(mobileBGList[this.num], {backgroundImage: "url(" + mobileImages[this.num] + ")"});
			imageDownloadCount++;
			//console.log("Image " + this.num + " downloaded");
		}
		//console.log("Downloading image " + i + ": " + mobileImages[i]);
		downloadingImage.src = mobileImages[i];
	}
	downloadTimer = setInterval(function(e) {
		//console.log("Check if all images downloaded");
		if(imageDownloadCount == maxScenes) {	console.log("***ALL IMAGES DOWNLOADED***");
			clearInterval(downloadTimer);
										 
			h2.text(answers[curScene]);
			hrW = h2.width() + 15; //console.log("hrW: " + hrW);

			TweenMax.set([h1, h3, button], {opacity: 0, y: 40});
			TweenMax.set(h2, {opacity: 0});
			TweenMax.set(hr, {width: "1px", transformOrigin: "50%, 0", opacity: 0});
			TweenMax.set(mobileBGs, {display: "block"});
			TweenMax.set(mobileBGList[curScene], {opacity: 1});

			animateMobileIntroScene();
		}
		
	}, 500);
}

function animateNewWideAnswer() {console.log("animateNewWideAnswer");
	overlay.css("opacity", overlays[curScene]);
	TweenMax.set(h2, {opacity: 0});
	h2.text(answers[curScene]);
	hrW = Math.round(h2.width() + 15); //console.log("hrW: " + hrW);
	
	answerTL = null;
	answerTL = new TimelineMax({paused: true, repeat: 0});
	answerTL
		//.set(h2, {opacity: 0})
		.to(hr, .5, {width: hrW, transformOrigin: "50%, 0", ease: Circ.easeInOut})
		.set(h2, {opacity: 1, text: {value:" "}})
		.call(addClass, [h2, "hasCursor"], this)
		.to(h2, 1.5, {text: {value: answers[curScene], delimiter: "", padSpace: false}, ease: Linear.easeNone})
		.call(removeClass, [h2, "hasCursor"], this, "+=.25");
                                 
	answerTL.play();
	curScene++;
	videoNewSection = false;
}

function animateNewMobileAnswer() {	
    console.log("animateNewMobileAnswer");
	overlay.css("opacity", overlays[curScene]);
	TweenMax.set(h2, {opacity: 0});
	h2.text(answers[curScene]);
	hrW = Math.round(h2.width() + 15); 
    console.log("hrW: " + hrW);
//console.log(mobileBGList);
	//answerTL = null;
	answerTL = new TimelineMax({paused: true, repeat: 0});
	answerTL
		.set(h2, {opacity: 0})
		.set([curScene - 1], {opacity: 0})
		.set(mobileBGList[curScene], {opacity: 1})
		.to(hr, .5, {width: hrW, transformOrigin: "50%, 0", ease: Circ.easeInOut})
		.set(h2, {opacity: 1, text: {value:" "}})
		.call(addClass, [h2, "hasCursor"], this)
		.to(h2, 1.4, {text: {value: answers[curScene], delimiter: "", padSpace: false}, ease: Linear.easeNone})
		.call(removeClass, [h2, "hasCursor"], this, "+=.25")
	;
	answerTL.play();
	
	console.log("show current scene for " + mobileTimes[curScene - 1] + " seconds");
	mobileTimerTween = TweenMax.to(window, mobileTimes[curScene], {
		curTime: 0, 
		onComplete: function(e) {
			console.log("curScene: " + curScene);
			
			if(curScene <= maxScenes - 2) {
				curScene++;
				TweenMax.to(mobileBGList[curScene], 1, {opacity: 1, onComplete: function(e) {
					TweenMax.set(mobileBGList[curScene - 1], {opacity: 0});
				}});
			} else {
				curScene = 0;
				TweenMax.set(mobileBGList[0], {opacity: 1});
				TweenMax.to(mobileBGList[maxScenes - 1], 1, {opacity: 0});
			}

			animateNewMobileAnswer();
		}
	});
}

function animateWideIntroScene() {console.log("animateIntroScene");
	wideIntroTL = new TimelineMax({paused: true, repeat: 0});
	wideIntroTL
		.set(introContent, {opacity: 1})
		.to(h1, 1, {opacity: 1, ease: Linear.easeNone})
		.to(h1, 1, {y: 0, ease: Power1.easeOut}, "-=1")
		.set(hr, {opacity: 1}, "+=.15")
		.to(hr, 1.25, {width: hrW, transformOrigin: "50%, 0", ease: Circ.easeInOut})
		//.call(animateNewAnswer)
		.to(h3, 1, {opacity: 1, ease: Linear.easeNone}, "+=.5")
		.to(h3, 1, {y: 0, ease: Power1.easeOut}, "-=1")
		.to(button, 1, {opacity: 1, ease: Linear.easeNone}, "-=.5")
		.to(button, 1, {y: 0, ease: Power1.easeOut}, "-=1")
	;
	
	TweenMax.delayedCall(1, wideIntroTL.play, [], wideIntroTL);		
}

function animateMobileIntroScene() {console.log("animateMobileIntroScene");
	mobileIntroTL = new TimelineMax({paused: true, repeat: 0});
	mobileIntroTL
		.set(introContent, {opacity: 1})
		.to(h1, 1, {opacity: 1, ease: Linear.easeNone})
		.to(h1, 1, {y: 0, ease: Power1.easeOut}, "-=1")
		.set(hr, {opacity: 1}, "+=.15")
		.to(hr, 1.25, {width: hrW, transformOrigin: "50%, 0", ease: Circ.easeInOut})
		.to(h3, 1, {opacity: 1, ease: Linear.easeNone}, "+=.5")
		.to(h3, 1, {y: 0, ease: Power1.easeOut}, "-=1")
		.to(button, 1, {opacity: 1, ease: Linear.easeNone}, "-=.5")
		.to(button, 1, {y: 0, ease: Power1.easeOut}, "-=1")
	;
	TweenMax.delayedCall(1, mobileIntroTL.play, [], mobileIntroTL);
                                    
	TweenMax.delayedCall(3, animateNewMobileAnswer);
                                    
    
}

function resetWideIntro() {		console.log("resetWideIntro");
	if(wideIntroTL.isActive()) {
		wideIntroTL.pause();
		wideIntroTL.kill();
		wideIntroTL = null;
	}
	if(answerTL.isActive()) {
		answerTL.pause();
		answerTL.kill();
	}
	TweenMax.killAll();
	curTime = 5;
	curScene = 0;
	video.pause();
	TweenMax.set(h2, {opacity: 0, text: {value:" "}});
	TweenMax.set(video, {display: "none"});
    TweenMax.set(mobileBGs, {display: "block"});
	removeClass(h2, "hasCursor");
}

function resetMobileIntro() {	console.log("resetMobileIntro");
	if(mobileIntroTL.isActive()) {
    	mobileIntroTL.pause();
		mobileIntroTL.kill();
	} 
	if(mobileTimerTween.isActive()) {
		mobileTimerTween.pause();
		mobileTimerTween.kill();
	}
	if(answerTL.isActive()) {
		answerTL.pause();
		answerTL.kill();
	}
                            
                             
                             
	TweenMax.killAll();
	curTime = 0;
	curScene = 0;
	TweenMax.set(h2, {opacity: 0, text: {value:" "}});
	removeClass(h2, "hasCursor");
    TweenMax.set(video, {display: "block"});
	TweenMax.set(mobileBGs, {display: "none"});
	for(var i = 0; i < mobileBGList.length; i++) {
		TweenMax.set(mobileBGList[i], {opacity: 0});
	}
}

function addClass(element, cls) {
	element.addClass(cls);
}

function removeClass(element, cls) {
	element.removeClass(cls);
}

function initBreakpoints() { 
    console.log("initBreakpoints");
	enquire.register("screen and (min-width: 800px)", {
        deferSetup:true,
			setup: function() {
				console.log("wide breakpoint setup");
				initWideFeature();
			},
			match: function() {
				console.log("wide breakpoint match");
			},
			unmatch: function() {
				console.log("wide breakpoint unmatch");
				resetWideIntro();

			}
		}, true)
        
        .register("screen and (max-width: 799px)", {
			deferSetup: true,
			setup: function() {
				console.log("mobile breakpoint setup");
				initMobileFeature();
//                 animateMobileIntroScene();
//                 animateNewMobileAnswer();
                
			},
			match: function() {
				console.log("mobile breakpoint match");
//                animateMobileIntroScene();
                TweenMax.delayedCall(150, animateNewMobileAnswer);
                animateMobileIntroScene();
               
      
			},
			unmatch: function() {
				console.log("mobile breakpoint unmatch");
				resetMobileIntro();
                initWideFeature();

            }
		}, true)
	;
}
initBreakpoints();