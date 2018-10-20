<?php
/*
Template Name: About
*/
?>



<?php get_header(); ?>





    <style type="text/css" media="screen">
      body {
        background-color: #f1f1f1;
        margin: 0;
      }
      body,
      input,
      button {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      }
      .container { margin: 30px auto 40px auto; width: 800px; text-align: center; }

      a { color: #4183c4; text-decoration: none; font-weight: bold; }
      a:hover { text-decoration: underline; }

      h3 { color: #666; }
      ul { list-style: none; padding: 25px 0; }
      li {
        display: inline;
        margin: 10px 50px 10px 0px;
      }
      input[type=text],
      input[type=password] {
        font-size: 13px;
        min-height: 32px;
        margin: 0;
        padding: 7px 8px;
        outline: none;
        color: #333;
        background-color: #fff;
        background-repeat: no-repeat;
        background-position: right center;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.075);
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-transition: all 0.15s ease-in;
        transition: all 0.15s ease-in;
        vertical-align: middle;
      }
      .button {
        position: relative;
        display: inline-block;
        margin: 0;
        padding: 8px 15px;
        font-size: 13px;
        font-weight: bold;
        color: #333;
        text-shadow: 0 1px 0 rgba(255,255,255,0.9);
        white-space: nowrap;
        background-color: #eaeaea;
        background-image: -moz-linear-gradient(#fafafa, #eaeaea);
        background-image: -webkit-linear-gradient(#fafafa, #eaeaea);
        background-image: linear-gradient(#fafafa, #eaeaea);
        background-repeat: repeat-x;
        border-radius: 3px;
        border: 1px solid #ddd;
        border-bottom-color: #c5c5c5;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        vertical-align: middle;
        cursor: pointer;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-appearance: none;
      }
      .button:hover,
      .button:active {
        background-position: 0 -15px;
        border-color: #ccc #ccc #b5b5b5;
      }
      .button:active {
        background-color: #dadada;
        border-color: #b5b5b5;
        background-image: none;
        box-shadow: inset 0 3px 5px rgba(0,0,0,.15);
      }
      .button:focus,
      input[type=text]:focus,
      input[type=password]:focus {
        outline: none;
        border-color: #51a7e8;
        box-shadow: inset 0 1px 2px rgba(0,0,0,.075), 0 0 5px rgba(81,167,232,.5);
      }
      #auth {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 50;
        min-height: 32px;
        background-color: rgba(53,95,120,.4);
        padding: 7px 10px;
        border-bottom-right-radius: 10px;
        border-bottom-left-radius: 10px;
        box-shadow: 0 3px 0 rgba(0, 0, 0, 0.28);
        display: none;
      }
      #auth h1, #auth p, #auth label {
        display: none;
      }
      .auth-form-body {
        display: inline;
      }
      #auth input[type=text],
      #auth input[type=password] {
        float: left;
        width: 175px;
        margin-right: 9px;
        border: 0;
        background-color: #f5f5f5;
      }
      #auth input[type=text]:focus,
      #auth input[type=password]:focus {
        background-color: #fff;
        box-shadow: 0 0 5px rgba(255,255,255,.5);
      }
      #auth .button {
        border: 0;
      }
      #auth .button:focus {
        box-shadow: 0 0 5px rgba(255,255,255,.5);
      }
      label[for=search] {
        display: block;
        text-align: left;
      }
      #search label {
        font-weight: 200;
        padding: 5px 0;
      }
      #search input[type=text] {
        font-size: 18px;
        width: 705px;
      }
      #search .button {
        padding: 10px;
        width: 90px;
      }
      .logo { display: inline-block; margin-top: 35px; }
      .logo-img-2x { display: none; }
      @media
      only screen and (-webkit-min-device-pixel-ratio: 2),
      only screen and (   min--moz-device-pixel-ratio: 2),
      only screen and (     -o-min-device-pixel-ratio: 2/1),
      only screen and (        min-device-pixel-ratio: 2),
      only screen and (                min-resolution: 192dpi),
      only screen and (                min-resolution: 2dppx) {
        .logo-img-1x { display: none; }
        .logo-img-2x { display: inline-block; }
      }
      #suggestions {
        margin-top: 35px;
        color: #ccc;
      }
      #suggestions a {
        color: #666666;
        font-weight: 200;
        font-size: 14px;
        margin: 0 10px;
      }

      #parallax_wrapper {
        position: relative;
        z-index: 0;
        -webkit-transition: all 0.25s ease-in;
        transition: all 0.25s ease-in;
      }
      #parallax_field {
        overflow: hidden;
        position: absolute;
        left: 0;
        top: 0;
        height: 370px;
        width: 100%;
      }
      #parallax_field #parallax_bg {
        position: absolute;
/*
        top: -20px;
        left: -20px;
*/
        width: 110%;
        height: 425px;
        z-index: 1;
      }
      #parallax_illustration {
        display: block;
        margin: 0 auto;
        width: 940px;
        height: 370px;
        position: relative;
        overflow: hidden;
        clear: both;
      }
      #parallax_illustration img {
        position: absolute;
      }
      #parallax_illustration #parallax_error_text {
        top: 72px;
        left: 72px;
        z-index: 10;
      }
      #parallax_illustration #parallax_octocat {
        top: 94px;
        left: 356px;
        z-index: 9;
      }
      #parallax_illustration #parallax_speeder {
        top: 150px;
        left: 432px;
        z-index: 8;
      }
      #parallax_illustration #parallax_octocatshadow {
        top: 297px;
        left: 371px;
        z-index: 7;
      }
      #parallax_illustration #parallax_speedershadow {
        top: 263px;
        left: 442px;
        z-index: 6;
      }
      #parallax_illustration #parallax_building_1 {
        top: 73px;
        left: 467px;
        z-index: 5;
      }
      #parallax_illustration #parallax_building_2 {
        top: 113px;
        left: 762px;
        z-index: 4;
      }
    </style>

  <body>


<!-- http://www.bustle.com/articles/107645-where-to-hear-more-eric-nally-music-now-that-his-appearance-with-macklemore-has-turned-you -->

<div class="site-body-container" style="display: block;">
          <div class="site-body-content">
            <div class="error-screen" id="error-screen">
              <div class="error-left" id="error-left">
                <img src="https://s3.amazonaws.com/assets.bustle.com/images/404.png" alt="Error 404">
                <div class="error-message">
                  <h1>OH DAAANG!</h1>
                  You just got  served a
                </div>
              </div>
              <div class="error-right" id="error-right">
                but check out this beautiful art
              </div>
              <div class="error-button error-prev-button" id="error-prev-button" onclick="prevSlide();">
                <i class="icon-arrow-up"></i>
              </div>
              <div class="error-button error-next-button visible" id="error-next-button" onclick="nextSlide();">
                <i class="icon-arrow-down"></i>
              </div>

              <div class="error-slide-placeholder" id="error-slide-placeholder-0" style="z-index: 10;">
                <div class="error-slide loaded" id="error-slide-0" style="z-index: 10; height: 1681px; position: relative; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0031.jpg);"></div>
              </div>
              <div class="error-slide-placeholder" id="error-slide-placeholder-1" style="z-index: 9;">
                <div class="error-slide loaded" id="error-slide-1" style="z-index: 9; height: 1681px; position: fixed; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0005.jpg);"></div>
              </div>
              <div class="error-slide-placeholder" id="error-slide-placeholder-2" style="z-index: 8;">
                <div class="error-slide loaded" id="error-slide-2" style="z-index: 8; height: 1681px; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0016.jpg);"></div>
              </div>
              <div class="error-slide-placeholder" id="error-slide-placeholder-3" style="z-index: 7;">
                <div class="error-slide loaded" id="error-slide-3" style="z-index: 7; height: 1681px; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0030.jpg);"></div>
              </div>
              <div class="error-slide-placeholder" id="error-slide-placeholder-4" style="z-index: 6;">
                <div class="error-slide loaded" id="error-slide-4" style="z-index: 6; height: 1681px; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0015.jpg);"></div>
              </div>
              <div class="error-slide-placeholder" id="error-slide-placeholder-5" style="z-index: 5;">
                <div class="error-slide loaded" id="error-slide-5" style="z-index: 5; height: 1681px; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0023.jpg);"></div>
              </div>
              <div class="error-slide-placeholder" id="error-slide-placeholder-6" style="z-index: 4;">
                <div class="error-slide loaded" id="error-slide-6" style="z-index: 4; height: 1681px; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0027.jpg);"></div>
              </div>
              <div class="error-slide-placeholder" id="error-slide-placeholder-7" style="z-index: 3;">
                <div class="error-slide loaded" id="error-slide-7" style="z-index: 3; height: 1681px; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0008.jpg);"></div>
              </div>
              <div class="error-slide-placeholder" id="error-slide-placeholder-8" style="z-index: 2;">
                <div class="error-slide loaded" id="error-slide-8" style="z-index: 2; height: 1681px; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0035.jpg);"></div>
              </div>
              <div class="error-slide-placeholder" id="error-slide-placeholder-9" style="z-index: 1;">
                <div class="error-slide loaded" id="error-slide-9" style="z-index: 1; height: 1681px; background-image: url(https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/0006.jpg);"></div>
              </div>

            </div>
          </div>
        </div>

<script type="text/javascript">  
function scrollTo(e, t) {
    function o(e) {
        document.documentElement.scrollTop = e,
        document.body.parentNode.scrollTop = e,
        document.body.scrollTop = e
    }
    var r = document.documentElement.scrollTop || document.body.parentNode.scrollTop || document.body.scrollTop
      , i = e - r
      , l = 0
      , n = 20
      , s = function() {
        l += n;
        var e = easeInOutQuad(l, r, i, t);
        o(e),
        t > l && requestAnimFrame(s)
    }
    ;
    s()
}
function easeInOutQuad(e, t, o, r) {
    return e /= r / 2,
    1 > e ? o / 2 * e * e + t : (e--,
    -o / 2 * (e * (e - 2) - 1) + t)
}
function scrolled() {
    var e = document.body.scrollTop
      , t = Math.floor(e / slideHeight) + 1;
    t !== prevFixedSlide && limit > t && (document.getElementById("error-slide-" + prevFixedSlide).style.position = "relative",
    prevFixedSlide = t,
    document.getElementById("error-slide-" + t).style.position = "fixed"),
    dragLength >= e ? (document.getElementById("error-prev-button").className = "error-button error-prev-button",
    document.getElementById("error-right").className = "error-right",
    document.getElementById("error-left").className = "error-left") : (document.getElementById("error-prev-button").className = "error-button error-prev-button visible",
    document.getElementById("error-right").className = "error-right hidden",
    document.getElementById("error-left").className = "error-left hidden"),
    e + 2 * slideHeight >= limit * slideHeight ? document.getElementById("error-next-button").className = "error-button error-next-button" : document.getElementById("error-next-button").className = "error-button error-next-button visible"
}
function resized() {
    var e = Math.floor(Math.max(document.body.clientHeight + 100, 1.3185 * Math.min(document.body.offsetWidth, maxWidth)));
    if (Math.abs(e - slideHeight) > 100) {
        slideHeight = e,
        slides = document.getElementsByClassName("error-slide");
        for (var t = 0; t < slides.length; t++)
            slides[t].style.height = slideHeight
    }
    scrolled()
}
function prevSlide() {
    var e = Math.ceil(document.body.scrollTop / slideHeight) - 1
      , t = e * slideHeight;
    scrollTo(t, 700)
}
function nextSlide() {
    var e = Math.floor(document.body.scrollTop / slideHeight) + 1
      , t = e * slideHeight;
    scrollTo(t, 700)
}
function init() {
    function e() {
        this.obj.style.backgroundImage = "url('https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/" + this.file + ".jpg')",
        this.obj.className = "error-slide loaded"
    }
    for (var t, o = [], r = 0; count > r; r++)
        t = "0000" + (r + 1),
        o[r] = t.substr(t.length - 4);
    for (var i, l, n = count - 1; limit >= count - n; n--)
        l = Math.floor(Math.random() * n),
        i = o[l],
        o[l] = o[n],
        o[n] = i;
    o = o.slice(count - limit);
    for (var s = 0, s = 0; limit > s; s++) {
        var d = document.getElementById("error-slide-" + s)
          , c = new Image;
        d.className = "error-slide",
        c.obj = d,
        c.file = o[s],
        c.onload = e,
        c.src = "https://s3.amazonaws.com/assets.bustle.com/images/404/compressed/" + c.file + ".jpg"
    }
    resized(),
    document.body.scrollTop = 0
}
var count = 39
  , limit = 10
  , maxWidth = 1600
  , dragLength = 15
  , slideHeight = 2e3
  , prevFixedSlide = 0
  , requestAnimFrame = function() {
    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function(e) {
        window.setTimeout(e, 1e3 / 60)
    }
}
();
window.onscroll = scrolled,
window.onresize = resized,
document.addEventListener("touchstart", function(e) {
    this.allowUp = this.body.scrollTop > 0,
    this.allowDown = this.body.scrollTop < this.body.scrollHeight - this.body.clientHeight,
    this.lastY = this.body.scrollTop,
    this.startY = e.touches[0].screenY
}
),
document.addEventListener("touchend", function(e) {
    var t = this.body.scrollTop - this.lastY
      , o = -dragLength > t
      , r = t > dragLength;
    this.lastY = this.body.scrollTop,
    o && this.allowUp ? prevSlide() : r && this.allowDown && nextSlide()
}
),
window.onload = init;
</script>




  </body>








<?php get_footer(); ?>




