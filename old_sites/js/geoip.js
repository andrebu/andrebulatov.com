	// javascript browser "mustuard test"
	//if ( 'querySelector' in document && 'addEventListener' in window ) {
	//	document.documentElement.className += 'js';
	//}

	//define global variables
	var nUa = navigator.userAgent;
	var httpPrefix = (window.location.protocol === 'http:' ? 'http:' : 'https:');
	var prevQuery = '';
	var infoTable = document.getElementById('geo-table');
	var geoMapCanv = document.getElementById('geo-map-canvas');
	var navTable = document.getElementById('navigator-table');
	var navMap = document.getElementById('navigator-map');
	var browStatus = document.querySelector('#browser-status');
	var infoStatus = document.querySelector('#info-status');
	var geoAdrs = document.querySelector('#current-address');
	var newyork = {lat: 40.7127, lng: -74.0059};
	var siberia = {lat: 60, lng: 105};
	var mapLoaded = false;

	// Get time and format
	function getSetTime() {
		var current_date_time = function(d){
			var weekDay = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][d.getDay()];
			var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
			var date = month[d.getMonth()] + " " + d.getDate() + ", " +  d.getFullYear();
			var time = d.toLocaleTimeString().toLowerCase();
			return (weekDay + ", " + date + " at " + time); 
		}(new Date());
		$('#current-date-time').html(current_date_time);
	}

	// Get browser info with native navigator
	function getBrowInfo() {
		browStatus.innerHTML = "Identified!";
		browStatus.className += ' success';
		$('#browser-code').html(navigator.appCodeName);
		$('#browser-name').html(navigator.appName);
		$('#browser-ver').html(navigator.appVersion);
		$('#browser-cookies').html(navigator.cookieEnabled);
		$('#browser-lang').html(navigator.language);
		$('#browser-on').html(navigator.onLine);
		$('#ua-platform').html(navigator.platform);
		$('#ua-header').html(nUa);

		// manual OS version detection
		function manualOSDetection() {
			var nAV = navigator.appVersion;
			var oSN='Unknown OS';
			if (nAV.indexOf('Win')!=-1) oSN='Windows';
			if (nAV.indexOf('Mac')!=-1) oSN='Mac OS X';
			if (nAV.indexOf('X11')!=-1) oSN='UNIX';
			if ( nAV.indexOf('Linux')!=-1) oSN='Linux';
			uOSN.addClass(oSN.toLowerCase()).html(oSN);
			var mOSXV = nUa.substring(nUa.lastIndexOf('Mac OS X')+9,nUa.indexOf(')')).replace(/_/g,'.');
			uOSVer.html('Version '+mOSXV);
		}
		// manual browser version
		function manualBrowserDetection() {
			var fVer  = ''+parseFloat(navigator.appVersion); 
			var majorVersion = parseInt(navigator.appVersion,10);
			var nameOffset,verOffset,ix;
			// In Opera, the true version is after "Opera" or after "Version"
			if ((verOffset=nUa.indexOf('Opera'))!=-1) {
				fVer = nUa.substring(verOffset+6);
				if ((verOffset=nUa.indexOf('Version'))!=-1) 
					fVer = nUa.substring(verOffset+8);
				uB.html('Opera').addClass('opera');
			}
			// In MSIE, the true version is after "MSIE" in userAgent
			else if ((verOffset=nUa.indexOf('MSIE'))!=-1) {
				fVer = nUa.substring(verOffset+5);
				uB.html('Internet Explorer').addClass('ie');
			}
			// In Chrome, the true version is after "Chrome" 
			else if ((verOffset=nUa.indexOf('Chrome'))!=-1) {
				fVer = nUa.substring(verOffset+7);
				fVer = fVer.substring(0, fVer.indexOf('Safari/'));
				uB.html('Chrome').addClass('chrome');
			}
			// In Safari, the true version is after "Safari" or after "Version" 
			else if ((verOffset=nUa.indexOf('Safari'))!=-1) {
				fVer = nUa.substring(verOffset+7);
				if ((verOffset=nUa.indexOf('Version'))!=-1) {
					fVer = nUa.substring(verOffset+8);}
				fVer = fVer.substring(0, fVer.indexOf('Safari/'));
				uB.html('Safari').addClass('safari');
			}
			// In Firefox, the true version is after "Firefox" 
			else if ((verOffset=nUa.indexOf('Firefox'))!=-1) {
				fVer = nUa.substring(verOffset+8);
				uB.html('FireFox').addClass('firefox');
			}
			// In most other browsers, "name/version" is at the end of userAgent 
			else if ( (nameOffset=nUa.lastIndexOf(' ')+1) < (verOffset=nUa.lastIndexOf('/')) ) {
				var browserName = nUa.substring(nameOffset,verOffset);
				fVer = nUa.substring(verOffset+1);
				if (browserName.toLowerCase()==browserName.toUpperCase()) {
						browserName = navigator.appName;
				}
				uB.html(''+browserName+'').addClass(''+browserName+'');
			}
			// trim the fVer string at semicolon/space if present
			if ((ix=fVer.indexOf(';'))!=-1)
				fVer=fVer.substring(0,ix);
			if ((ix=fVer.indexOf(' '))!=-1)
				fVer=fVer.substring(0,ix);
			uBVer.html('Version '+fVer);

			majorVersion = parseInt(''+fVer,10);
			if (isNaN(majorVersion)) {
				fVer  = ''+parseFloat(navigator.appVersion); 
				majorVersion = parseInt(navigator.appVersion,10);
			}
		}
		var uB = $('#user-browser .name');
		var uBVer = $('#user-browser .ver');
		var VuB = document.querySelector('#user-browser .name');
		var uOSN = $('#user-os .name');
		var uOSVer = $('#user-os .ver');		
		manualBrowserDetection();
		//if desktop or Mac, or no browser name (as it WURFL typically only detects mobile)
		//then detect browser and OS manually
		if (uOSN.hasClass('desktop') 
			|| uOSN.hasClass('mac') 
			|| !VuB.childNodes.length) {
			manualOSDetection();
		}
		$(document).ready(function() {
			var navTableHeight = document.getElementById('navigator-table').offsetHeight;
			navMap.style.height = navTableHeight+'px';
		});
    }

	function getViaTelize(ipAdrs) {
		getSetTime();
		infoStatus.classList.remove('success');
		var ipAddress = ipAdrs != null ? ipAdrs : '';
		if ( (ipAddress != '') && (!/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/gm.test(ipAddress)) ) { 
			infoStatus.className += ' warning';
			infoStatus.innerHTML = 'Please use valid IP';
			return 
		};
		if (prevQuery == queryUrl) return;
		infoStatus.innerHTML = '<i class="fa fa-spinner fa-pulse fa-fw"></i> Fetching data...';
		var queryUrl = httpPrefix + '//www.telize.com/geoip/' + ipAddress;
		prevQuery = queryUrl;
		$.getJSON(queryUrl,
			function(userData) {
				var uIp = userData.ip ? userData.ip : 'N/A';
				var uCi = userData.city ? userData.city : 'N/A';
				var uRe = userData.region ? userData.region : 'N/A';
				var uRc = userData.region_code ? userData.region_code : 'N/A';
				var uAc = userData.area_code ? userData.area_code : 'N/A';
				var uDc = userData.dma_code ? userData.dma_code : 'N/A';
				var uLa = userData.latitude ? userData.latitude : 'N/A';
				var uLo = userData.longitude ? userData.longitude : 'N/A';
				var uCo = userData.country ? userData.country : 'N/A';
				var uCc = userData.country_code ? userData.country_code : 'N/A';
				var uC3 = userData.country_code3 ? userData.country_code3 : 'N/A';
				var uCt = userData.continent_code ? userData.continent_code : 'N/A';
			    var cCd = ' (' + uCc + '/' + uC3 + ', ' + uCt + ')';
			    var uPc = userData.postal_code ? userData.postal_code : 'N/A';
			    var uTz = userData.timezone ? userData.timezone : 'N/A';
			    var gMU = '//www.google.com/maps/preview/@' + uLa + ',' + uLo + ',15z';
			    var uWU = '//en.wikipedia.org/wiki/' + uTz;
			    var uAs = userData.asn ? userData.asn : 'N/A';
			    var uIs = userData.isp ? userData.isp : 'N/A';
				var gLS = uLa.toString() + ', ' + uLo.toString();
				$('#ip-address').attr('placeholder', uIp);
			    $('#city').html(uCi);
			    $('#region').html(uRe + ' (' + uRc + ')');
			    $('#areacode').html(uAc + ' (' + uDc + ')');
			    $('#ip').html(uIp);
			    $('#latLong').html(uLa + ', ' + uLo);
			    $('#country').html(uCo);
			    $('#country-code').html(cCd);
			    $('#zipcode').html(uPc);
			    $('#timezone').html(uTz);
			    $('#latLongLink').attr('href', gMU);
			    $('#timeZoneLink').attr('href', uWU);
			    $('#autonomous-system-number').html(uAs);
			    $('#isp').html(uIs);
				$('#latlng').val('').attr('placeholder', gLS);
				infoStatus.classList.remove('warning');
				infoStatus.innerHTML = 'Got it!';
				infoStatus.className += ' success';
				var infoTableHeight = infoTable.offsetHeight;
				geoMapCanv.style.height = infoTableHeight+'px';
				if (mapLoaded) {
					geocodeLatLng(gGeocoder, gMap, gInfowindow);
				} else {
					initMap(uLa, uLo);
					$('#new-lookup').on('click', function() { 
						var newIp = $('#ip-address').val();
						getViaTelize(newIp);
					});
					mapLoaded = true;
				}
			}
		);
	}
    
	function initMaps() {
		var infoTableHeight = infoTable.offsetHeight;
		gMap = new google.maps.Map(geoMapCanv, {
			zoom: 15,
			center: newyork,
			mapTypeId: 'roadmap'
		});
		var marker = new google.maps.Marker({
			position: newyork,
			map: gMap,
			title: 'New York'
		});
		var laaat = parseFloat($('#latLong').text().split(',')[0]);
		var looon = parseFloat($('#latLong').text().split(',')[1]);
		//gMap.panBy(0,-50);		
		console.log(laaat, looon);
		infoStatus.innerHTML = 'Got it!';
		infoStatus.className += ' success';
		var infoTableHeight = infoTable.offsetHeight;
		geoMapCanv.style.height = infoTableHeight+'px';
		initMap(laaat, looon);
	}
	
	function initMap(uLat, uLon) {
		//var gMap;
		var gMS = document.querySelector('#map-status');
		if ( (uLat != '') || (uLon != '') ) {
			//google.maps.event.addListenerOnce(gMap, 'idle', function(){
				gMap = new google.maps.Map(geoMapCanv, {
					zoom: 15,
					center: {lat: uLat, lng: uLon},
					mapTypeId: 'roadmap'
				});
				var marker = new google.maps.Marker({
					position: {lat: uLat, lng: uLon},
					map: gMap,
					title: 'You are here!'
				});
				gGeocoder = new google.maps.Geocoder;
				gInfowindow = new google.maps.InfoWindow;
				gMS.innerHTML = 'Found you!';
				gMS.className += ' success';
				gGeocoder.geocode({'location': {lat: uLat, lng: uLon}}, function(results, status) {
					if (status === google.maps.GeocoderStatus.OK) {
						if (results[1]) {
							var frmtAddr = results[0].formatted_address;
							var gIWC = '<div id="gIWC"><span>You are in &nbsp;</span><span>'; 
							gIWC += ''+frmtAddr +'</span></div>';
							geoAdrs.innerHTML = frmtAddr;
							gInfowindow.setContent(gIWC);
							gInfowindow.open(gMap, marker);
							//gMap.panBy(1275,-50);
						}
					}
				});
			//});
		} else {
			gMS.className += ' warning';
			gMS.innerHTML = 'No lat./long.? :/';
		}
		
		document.getElementById('new-loc').addEventListener('click', function() {
			geocodeLatLng(gGeocoder, gMap, gInfowindow);
		});
	}
	
	function geocodeLatLng(geocoder, map, infowindow) {
		var newStatus = document.querySelector('#map-status');
		newStatus.innerHTML = '<i class="fa fa-refresh fa-pulse fa-fw"></i> Locating you...</span>';
		newStatus.className = 'query-status';
		var coordInput = document.getElementById('latlng');
		var inputVal = coordInput.value;
		var inputPH = coordInput.placeholder;
		var input = inputVal ? inputVal : inputPH;
		if (!/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/
		.test(input) ) { 
			newStatus.className += ' warning';
			newStatus.innerHTML = 'Please fix coordinates';
			return 
		};
		var latlngStr = input.split(',', 2);
		if (latlngStr.indexOf('N/A') > -1) {
			newStatus.className += ' warning';
			newStatus.innerHTML = 'No lat./long.? :/';
			geocoder.geocode({'location': siberia}, function(results, status) {
				if (status === google.maps.GeocoderStatus.OK) {
					if (results[1]) {
						var frmtAddr = results[1].formatted_address;
						geoAdrs.innerHTML = frmtAddr;
						var marker = new google.maps.Marker({
							position: latlng,
							map: map, 
							title: 'No latitudde or longitude coordinates, so I put you in Siberia!'
						});
						map.setCenter(new google.maps.LatLng(65, 105));
						map.setZoom(7);
						var sS = 'No geo-coordinates were provided so I put you in ';
						infowindow.setContent(sS + frmtAddr);
						//infowindow.open(map, marker);
					}
				}
			});
			return;
		};
		var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
		geocoder.geocode({'location': latlng}, function(results, status, error_message) {
			if (status === google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					var frmtAddr = results[0].formatted_address;
					newStatus.innerHTML = 'Found you!';
					newStatus.className += ' success';
					geoAdrs.innerHTML = frmtAddr;
					var marker = new google.maps.Marker({
						position: latlng,
						map: map,
						title: 'You are here!'
					});
					var gIWC = '<div id="gIWC"><span>You are in </span><span>'+frmtAddr +'</span></div>';
					infowindow.setContent(gIWC);
					//infowindow.open(map, marker);
				} else {
					newStatus.className += ' warning';
					newStatus.innerHTML = 'No results found!';
				}
			} else {
				console.log(latlng, status, error_message);
				newStatus.className += ' fail';
				newStatus.innerHTML = 'Ahh, Error!: ' + status;
			}
		});
	}



	function navigatorMap() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(mapCoords, showError);
		} else {
			showError('not supported');
		}
		function mapCoords(position) {
			var p = position;
			var pC = p.coords;
			var latC = pC.latitude;
			var lonC = pC.longitude;
			var accuracy = pC.accuracy;
			
			var s = document.querySelector('#navigator-status');
			if (s.className == 'success') {
				infowindow.setContent(infoWindowContent(pC));
				return;
			}
			s.innerHTML = 'Watching you!';
			s.className += ' success';
			
			var infowindow = new google.maps.InfoWindow();
		  
			var latlng = new google.maps.LatLng(latC, lonC);
			var myOptions = {
				zoom: 15,
				center: latlng,
				mapTypeControl: false,
				navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			
			var map = new google.maps.Map(navMap, myOptions);
			map.panBy(0,-80);		
			var marker = new google.maps.Marker({
				position: latlng, 
				map: map, 
				title:'You are here! (at least within a '+accuracy+' meter radius)'
			});
			infowindow.open(map, marker);
			function updateMap(posish) {
				var updatedCenter = new google.maps.LatLng(latC, lonC);
				map.panTo(updatedCenter);
				marker.setPosition(updatedCenter);
				infowindow.setContent(infoWindowContent(posish));
			};
			updateMap(p);
			navigator.geolocation.watchPosition(updateMap, showError);
		}
		function showError(error) {
			var eMA = {
				1: 'Permission denied',
				2: 'Position unavailable',
				3: 'Request timeout'
			};
			var eM = eMA[error.code];

			var s = document.querySelector('#navigator-status');
			s.className += ' fail';
			s.innerHTML = typeof eM == 'string' ? eM : 'failed';
		}
		function infoWindowContent(position) {
			console.log(position.coords);
			var pC = position.coords;
			var acc = pC.accuracy.toFixed(2);
			var pLat = pC.latitude;
			var pLon = pC.longitude;
			var latC = pLat.toFixed(7);
			var lonC = pLon.toFixed(7);
			var latDMS = DDtoDMS(Math.abs(pLat));
			var lonDMS = DDtoDMS(Math.abs(pLon));
			var latD = pLat >= 0 ? 'N' : 'S';
			var lonD = pLon >= 0 ? 'N' : 'S';
			var mH = pC.heading ? pC.heading.toFixed(2)+'°'  : 'Stopped';
			var mS = pC.speed ? ' at '+pC.speed.toFixed(2)+' m/s' : '';
			var alt = pC.altitude;
			var altRnd = alt != null ? alt.toFixed(2)+' m' : 'N/A';
			var altAcc = pC.altitudeAccuracy ? ' (±'+pC.altitudeAccuracy.toFixed(2)+' m)' : '';
			var iWC = '<div class="infoWindow">';
			iWC += '<p>You are within a '+acc+' meter radius of these coordinates</p>';
			iWC += '<div class="lat"><span class="coord-label">Latitude:</span>';
			iWC += '<span class="rad">'+latC+'</span><span class="deg">'+latDMS+' '+latD+'</span></div>';
			iWC += '<div class="lng"><span class="coord-label">Longitude:</span>';
			iWC += '<span class="rad">'+lonC+'</span><span class="deg">'+lonDMS+' '+lonD+'</span></div>';
			iWC += '<div class="heading"><span class="coord-label">Movement:</span> ';
			iWC += '<span class="rad">'+mH+mS+'</span></div>';
			iWC += '<div class="elevation"><span class="coord-label">Elevation:</span> ';
			iWC += '<span class="rad">'+altRnd+altAcc+'</span></div></div>';
			return iWC;
		}
	}



	function DDtoDMS (coords) {
		var d = Math.floor (coords);
		var minfloat = (coords-d)*60;
		var m = Math.floor(minfloat);
		var secfloat = (minfloat-m)*60;
		var s = secfloat.toFixed(2);
		return ('' + d + '° ' + m + '\' ' + s + '"');
	}



	getSetTime();
	getBrowInfo();
	//addGoogleMap();
	//getViaTelize();
	navigatorMap();
