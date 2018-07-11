	function getBrowInfo() {
		var browStatus = document.querySelector('#brow-status');
		if (browStatus.className == 'success') {
			return;
		}
		browStatus.innerHTML = "Identified!";
		browStatus.className = 'success';
	
	    $('#brow-code').html(navigator.appCodeName);
	    $('#brow-name').html(navigator.appName);
	    $('#brow-ver').html(navigator.appVersion);
	    $('#brow-cookies').html(navigator.cookieEnabled);
	    $('#brow-lang').html(navigator.language);
	    $('#brow-on').html(navigator.onLine);
	    $('#ua-platform').html(navigator.platform);
	    $('#ua-header').html(navigator.userAgent);
/*
	    $.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase()); 
		$.browser.mozilla = /firefox/.test(navigator.userAgent.toLowerCase()); 	    
		$.browser.msie = /msie/.test(navigator.userAgent.toLowerCase()); 
		$.browser.opera = /opera/.test(navigator.userAgent.toLowerCase()); 	    
		if($.browser.chrome) {
		   alert(1);
		} else if ($.browser.mozilla) {
		   alert(2);
		} else if ($.browser.msie) {
		   alert(3);
		} else if ($.broswer.opera) {
			alert(4);
		}
*/
    }

	function getUserInfo() {
		function getCurrentTime() {
			var current_date_time = function(d){
				var weekDay = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][d.getDay()];
			    var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
			    var date = month[d.getMonth()] + " " + d.getDate() + ", " +  d.getFullYear();
			    var time = d.toLocaleTimeString().toLowerCase();
			    return (weekDay + ", " + date + " at " + time); 
			}(new Date());
		    $('#current-date-time').html(current_date_time);
		}
		getCurrentTime();
	
		function getViaTelize() {
			$.getJSON("http://www.telize.com/geoip",
				function(location) {
					console.log(location);
					var infoStatus = document.querySelector('#info-status');
					if (infoStatus.className == 'success') {
						return;
					}
					$('#ipAddress').attr('placeholder', location.ip);
				    $('#city').html(location.city);
				    $('#region-name').html(location.region);
				    $('#region-code').html(location.region_code);
				    $('#areacode').html(location.area_code);
				    $('#dma-code').html(location.dma_code);
				    $('#ip').html(location.ip);
				    $('#latitude').html(location.latitude);
				    $('#longitude').html(location.longitude);
				    $('#country-name').html(location.country);
				    $('#country-code').html(location.country_code);
				    $('#country-code3').html(location.country_code3);
				    $('#continent-code').html(location.continent_code);
				    $('#zipcode').html(location.postal_code);
				    $('#timezone').html(location.timezone);
				    $('#latLongLink').attr('href', '//www.google.com/maps/preview/@' + location.latitude + ',' + location.longitude + ',15z');
				    $('#timeZoneLink').attr('href', '//en.wikipedia.org/wiki/' + location.timezone);
				    $('#autonomous-system-number').html(location.asn);
				    $('#isp').html(location.isp);
					var geoipLonLat = location.latitude.toString() + ',' + location.longitude.toString();
					$('#latlng').attr('placeholder', geoipLonLat);
					infoStatus.innerHTML = "Got it!";
					infoStatus.className = 'success';
				}
			);
		}
		getViaTelize();
		
		function getViaFreeGeoIp() {
			$.ajax( { 
				url: '//freegeoip.net/json/', 
				type: 'POST', 
				dataType: 'jsonp',
				success: function(location) {
					var infoStatus = document.querySelector('#info-status');
					if (infoStatus.className == 'success') {
						return;
					}
					$('#ipAddress').attr('placeholder', location.ip);
				    $('#city').html(location.city);
				    $('#region-code').html(location.region_code);
				    $('#region-name').html(location.region_name);
				    $('#areacode').html(location.metro_code);
				    $('#ip').html(location.ip);
				    $('#zipcode').html(location.zipcode);
				    $('#latitude').html(location.latitude);
				    $('#longitude').html(location.longitude);
				    $('#country-name').html(location.country_name);
				    $('#country-code').html(location.country_code);
				    $('#zipcode').html(location.zip_code);
				    $('#timezone').html(location.time_zone);
				    $('#latLongLink').attr('href', '//www.google.com/maps/preview/@' + location.latitude + ',' + location.longitude + ',15z');
				    $('#timeZoneLink').attr('href', '//en.wikipedia.org/wiki/' + location.time_zone);
					var geoipLonLat = location.latitude.toString() + ',' + location.longitude.toString();
					$('#latlng').attr('placeholder', geoipLonLat);
					infoStatus.innerHTML = "Got it!";
					infoStatus.className = 'success';
				}
			});
		}
		//getViaFreeGeoIp();
	}
    
	function createMapContainer() {
		var mapcanvas = document.createElement('div');
		mapcanvas.id = 'mapcanvas';
		mapcanvas.style.height = '403px';
		mapcanvas.style.width = '100%';
		
		document.querySelector('#mapContainer').appendChild(mapcanvas);
	}
	
	//function addGoogleMap() {
		var geocoder;
		var map;
		var infowindow = new google.maps.InfoWindow();
		var marker;
		function initialize() {
			var s = document.querySelector('#map-status');
			var d = document.querySelector('#current-address');
			
			if (s.className == 'success') {
			// not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back    
			return;
			}
			
			
		  geocoder = new google.maps.Geocoder();
		  var input = document.getElementById('latlng').placeholder;
		  var latlngStr = input.split(',', 2);
		  var lat = parseFloat(latlngStr[0]);
		  var lng = parseFloat(latlngStr[1]);
		  var latlng = new google.maps.LatLng(lat, lng);
		  var mapOptions = {
		    zoom: 15,
		    center: latlng,
		    mapTypeId: 'roadmap'
		  }
		  map = new google.maps.Map(document.getElementById('mapcanvas'), mapOptions);
			geocoder.geocode({'latLng': latlng}, function(results, status) {
				var s = document.querySelector('#map-status');
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[1]) {
						s.innerHTML = "Found you!";
						s.className = 'success';
						d.innerHTML = results[1].formatted_address;
						infowindow.setContent(results[1].formatted_address);
						infowindow.open(map, marker);
					} else {
						s.innerHTML = "No results found!";
						s.className = 'warning';
					}
				} else {
					s.className = 'fail';
					s.innerHTML = 'Geocoder failed due to: ' + status;
				}
			});
		}
	//}
	
	function codeLatLng() {
		var s = document.querySelector('#map-status');
		s.className = '';
		var input = document.getElementById('latlng').value;
		var latlngStr = input.split(',', 2);
		var lat = parseFloat(latlngStr[0]);
		var lng = parseFloat(latlngStr[1]);
		var latlng = new google.maps.LatLng(lat, lng);
		geocoder.geocode({'latLng': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					//map.setZoom(11);
					marker = new google.maps.Marker({
					    position: latlng,
					    map: map,
						title:"You are here! (at least within a "+position.coords.accuracy+" meter radius)"
					});
					infowindow.setContent(results[1].formatted_address);
					infowindow.open(map, marker);
				} else {
					s.className = 'warning';
					s.innerHTML = "No results found!";
				}
			} else {
				s.className = 'fail';
				s.innerHTML = 'Geocoder failed due to: ' + status;
			}
		});
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);


	function navigatorMap() {
		function success(position) {
			var infowindow = new google.maps.InfoWindow();

		  var s = document.querySelector('#navigator-status');
		  
		  if (s.className == 'success') {
		    // not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back    
		    return;
		  }
		  
		  s.innerHTML = "Found you!";
		  s.className = 'success';
		  
		  var mapcanvas = document.createElement('div');
		  mapcanvas.id = 'navigatorMap';
		  mapcanvas.style.height = '403px';
		  mapcanvas.style.width = '100%';
		    
		  document.querySelector('#navigatorMapContainer').appendChild(mapcanvas);
		  
		  var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		  var myOptions = {
		    zoom: 15,
		    center: latlng,
		    mapTypeControl: false,
		    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		  };
		  var map = new google.maps.Map(document.getElementById("navigatorMap"), myOptions);
		  
		  var marker = new google.maps.Marker({
		      position: latlng, 
		      map: map, 
		      title:"You are here! (at least within a "+position.coords.accuracy+" meter radius)"
		  });
		}
		
		function error(msg) {
		  var s = document.querySelector('#navigator-status');
		  s.innerHTML = typeof msg == 'string' ? msg : "failed";
		  s.className = 'fail';
		  
		  // console.log(arguments);
		}
		
		if (navigator.geolocation) {
		  navigator.geolocation.getCurrentPosition(success, error);
		} else {
		  error('not supported');
		}
	}

	getBrowInfo();
	getUserInfo();
	createMapContainer();
	//addGoogleMap();
	navigatorMap();
