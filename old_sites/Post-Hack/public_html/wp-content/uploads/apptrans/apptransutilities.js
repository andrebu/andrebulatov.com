var ge1doot = ge1doot || {
	screen: {
		elem: null,
		callback: null,
		width:  0,
		height: 0,
		left:   0,
		top:    0,
		init: function (id, callback, initRes) {
			this.elem = document.getElementById(id);
			this.callback = callback || null;
			window.addEventListener('resize', function () {
				ge1doot.screen.resize();
			}, false);
			initRes && this.resize();
		},
		resize: function () {
			var o = this.elem;
			this.width  = o.offsetWidth;
			this.height = o.offsetHeight;
			for (this.left = 0, this.top = 0; o != null; o = o.offsetParent) {
			this.left += o.offsetLeft;
			this.top  += o.offsetTop;
			}
			this.callback && this.callback();
		}
	},
	drag: {
		screen: null,
		x:  0,
		y:  0,
		xs: 0,
		ys: 0,
		bx: 0,
		by: 0,
		xp: 0,
		yp: 0,
		active: false,
		down: function (e, touch) {
			e.preventDefault();
			var pointer = touch ? e.touches[0] : e;
			(!touch && document.setCapture) && document.setCapture();
			this.xp = this.xs = pointer.clientX;
			this.yp = this.ys = pointer.clientY;
			this.active = true;
		},
		up: function (e, touch) {
			e.preventDefault();
			(!touch && document.releaseCapture) && document.releaseCapture();
			this.bx = this.x;
			this.by = this.y;
			this.active = false;
		},
		move: function (e, touch) {
			e.preventDefault();
			if (this.active) {
				var pointer = touch ? e.touches[0] : e;
				this.xp = pointer.clientX;
				this.yp = pointer.clientY;
				this.x = this.bx - (this.xp - this.xs);
				this.y = this.by - (this.yp - this.ys);
			}
		},
		init: function (screen) {
			var self = this;
			this.screen = screen.elem;
			if ('ontouchstart' in window) {
				// touch
				this.screen.ontouchstart  = function (e) { self.down(e, true); }
				this.screen.ontouchmove   = function (e) { self.move(e, true); }
				this.screen.ontouchend    = function (e) { self.up(e, true);   }
				this.screen.ontouchcancel = function (e) { self.up(e, true);   }
			}
			// mouse
			document.addEventListener("mousedown", function (e) { self.down(e, false); }, true);
			document.addEventListener("mousemove", function (e) { self.move(e, false); }, true);
			document.addEventListener("mouseup",   function (e) { self.up  (e, false); }, true);
		}
	},
	Ease: function (speed, val) {
		this.speed = speed;
		this.target = val;
		this.value = val;
	}
}

ge1doot.Ease.prototype.ease = function (target) {
	this.value += (target - this.value) * this.speed;
}


/* =======================================================
 *  ---- HTML5 CSS 3D demo - no preserve-3d ----
 * script: Gerard Ferrandez - 24 January 2015
 * Released under the MIT license
 * http://www.dhteumeuleu.com/LICENSE.html
 * ======================================================= */

!function () {
	window.addEventListener('load', function () {
		"use strict";
		var Xi = 0, Yi = 0, Zi = 0, rotation;
		var faces, localTransform = [];
		var screen = ge1doot.screen;
		var drag = ge1doot.drag;
		var perp = new ge1doot.Ease(0.01, 50);
		// ==== init script ====
		screen.init("screen", function () { }, true);
		drag.init(screen);
		faces = document.getElementById("scene").getElementsByTagName("img");
		rotation = {
			ex:  0,
			ey:  0,
			x:   0,
			y:   0,
			tz:  0,
			tx:  0,
			ttx: 0,
			tty: 0,
			ttz: 0,
			speedx: 0.1,
			speedz: 0.1,
			ease: function (x, y) {
				this.y = -(this.ey += (x - this.ey) * 0.06) / 3;
				this.x =  (this.ex += (y - this.ex) * 0.06) / 3;
				var a = this.y * Math.PI / 180;
				var x = -Math.sin(a) * this.speedx;
				var z =  Math.cos(a) * this.speedz;
				this.tx += x;
				this.tz += z;
				if (drag.active) {
					if ((this.tx > 260 && x > 0) || (this.tx < -260 && x < 0)) this.speedx *= 0.9;
					else {
						if (this.speedx < 0.1) this.speedx = 1;
						if (this.speedx < 5) this.speedx *= 1.1;
					}
					if ((this.tz > 260 && z > 0) || (this.tz < -260 && z < 0)) this.speedz *= 0.9;
					else {
						if (this.speedz < 0.1) this.speedz = 1;
						if (this.speedz < 5) this.speedz *= 1.1;
					}
				} else {
					this.speedx *= 0.9;
					this.speedz *= 0.9;
				}
				a = Math.cos(this.x * Math.PI / 180);
				this.ttx = -(Math.cos((this.y - 90) * Math.PI / 180) * a) * 400;
				this.ttz = -(Math.sin((this.y - 90) * Math.PI / 180) * a) * 400;
				this.tty = Math.sin(this.x * Math.PI / 180) * 100;
			}
		}
		// ==== init faces ====
		for (var i = 0, n = faces.length; i < n; i++) {
			var elem = faces[i];
			var s = elem.getAttribute("data-transform");
			elem.style.transform = s;
			elem.style.webkitTransform = s;
			elem.style.visibility = "visible";
			localTransform.push(s);
		}
		// ==== main loop ====
		function run () {
			requestAnimationFrame(run); 
			perp.ease(drag.active ? 300 : 500);
			if (drag.y > 270) drag.y = drag.by = 270;
			if (drag.y < -270) drag.y = drag.by = -270;
			rotation.ease(drag.x, drag.y);
			var globalRotation = "perspective(" + perp.value + "px) rotateX(" + rotation.x + "deg) " + "rotateY(" + rotation.y + "deg) translateX("+(rotation.tx + rotation.ttx)+"px) translateY("+rotation.tty+"px) translateZ("+(rotation.tz + rotation.ttz)+"px)";
			// ==== anim faces ====
			for (var i = 0, n = faces.length; i < n; i++) {
				var elem = faces[i];
				var s =  globalRotation + localTransform[i];
				elem.style.transform = s;
				elem.style.webkitTransform = s;
			}
		}
		// ==== start animation ====
		requestAnimationFrame(run); 
	}, false);
}();
