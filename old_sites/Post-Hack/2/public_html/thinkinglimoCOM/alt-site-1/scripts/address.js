(function($) {
	$.fn.addressSuggestion = function (options) {
		return new AddressSuggestion($(this).attr('id'));
	};
})(jQuery);

function AddressSuggestion(id) {

	this.timerSearch = null;
	this.timerAddressNotSelected = null;
	this.selectedRef = null;
	this.selectedAddress = null;
	this.selectedLocation = null;
	this.id = id;
	this.onSelected = null;
	var self = this;

	this.el = $("#" + id);
	this.el.on("keyup", function () { self.addressSearchKeyUp(this); });


	this.el.autocomplete({
		minLength: 3,
		autoFocus: true,
		source: function(request, response) {
			if ($.trim(request.term).length > 2) {

				var t = $(this.element).closest(".search-container");
				self.showSearchSpinner(t);

				$.ajax({
					url: addressApiUrl,
					dataType: "json",
					data: {
						query: request.term
					},
					headers: {
						Accept: "application/vnd.clickataxi.v2+json",
					},
					success: function(data) { self.fillupDropdown(data, response); },
					complete: function() {
						self.hideSearchSpinner(t);
					}
				});
			}
		},
		select: function(event, ui) {

			window.clearTimeout(self.timerAddressNotSelected);
			self.timerAddressNotSelected = null;
			self.selectedRef = ui.item.reference;
			self.selectedAddress = ui.item.value;
			self.el.addClass("_notDefault");
			self.getLocationDetails();

			if (ui.item && ui.item.latitude && ui.item.longitude) {
				self.setAddress(
					ui.item.countryName, ui.item.cityName, ui.item.cityId,
					ui.item.zipCode, ui.item.streetName, ui.item.houseNumber,
					ui.item.placeName, ui.item.latitude, ui.item.longitude
				);
			}
		},
		focus: function (event, ui) {
			$(event.currentTarget).find("li").each(function () {
				$(this).removeClass("item-focused");
			});
			$(event.currentTarget).find("a").each(function () {
				var el = $(this);
				if (el.text() == ui.item.label) {
					el.parent().addClass("item-focused");
				}
			});
			return false;
		},
		messages: {
			noResults: null,
			results: function() {
			}
		}
	})
	.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
		return $("<li>")
		  .removeClass("ui-menu-item")
		  .addClass("nearby-places")
		  .append( "<a>" + item.label + "</a>" )
		  .appendTo( ul );
	};

	this.fillupDropdown = function(data, response) {
		var results = [];
		$.map(data, function (item) {
			results.push({
				value: item.name,
				reference: item.ref,
				type: item.type,
				category: "Suggestions"
			});
		});
		if ($('#' + this.id + ':visible').length > 0)
			response(results);
	};

	this.showSearchSpinner = function(t) {
		this.timerSearch = window.setTimeout(function() {
			t.find(".search > i").hide();
			t.find(".search > img").show();
		}, 100);
	};

	this.hideSearchSpinner = function(t) {
		window.clearTimeout(this.timerSearch);
		t.find(".search > img").hide();
		t.find(".search > i").show();
	};

	this.addressSearchKeyUp = function (t) {
		if (this.getText() != this.selectedAddress) {
			this.selectedRef = null;
			this.el.removeClass("_notDefault");
		}
	};

	this.setAddress = function(countryName, cityName, cityId, zipCode, streetName, houseNumber, placeName, latitude, longitude) {

		//var order = ClickATaxi.CallCenter.InboundOrder;

		var validation = $(this.element).closest(".field-validation-error");
		validation.hide().data("valid", true);
		window.clearTimeout(this.timerAddressNotSelected);
		this.timerAddressNotSelected = null;

		//order.departureAddress.cityId = cityId;
		//order.departureAddress.streetName = streetName;
		//order.departureAddress.houseNumber = houseNumber;
		//order.departureAddress.latitude = latitude;
		//order.departureAddress.longitude = longitude;
	};

	this.isAddressValid = function() {
		var validation = $(this.element).closest(".field-validation-error");
		return this.timerAddressNotSelected == null && validation.is(":hidden");
	};

	this.getText = function () {
		return $("#" + this.id).val();
	};

	this.autoPickupAddress = function (callBack) {
		this.selectedRef = null;
		$.ajax({
			url: addressApiUrl,
			dataType: "json",
			data: {
				query: this.getText()
			},
			headers: {
				Accept: "application/vnd.clickataxi.v2+json",
			},
			success: function (data) {
				if (data.length > 0) {
					self.selectedRef = data[0].ref;
					self.selectedAddress = data[0].name;
					self.getLocationDetails(callBack);
				}
			},
		});
	};

	this.isEmpty = function() {
		return this.getText().length == 0 || this.getText() == this.el.attr('data-default-value');
	};

	this.getLocationDetails = function(callBack) {
		this.selectedLocation = null;
		var self = this;
		$.ajax({
			url: "/api/places/ref?ref=" + this.selectedRef + "&type=google",
			dataType: "json",
			headers: {
				Accept: "application/vnd.clickataxi.v2+json",
			},
			success: function(data) {
				self.selectedLocation = data.location;
				if (callBack) callBack(true);
				if (self.onSelected) self.onSelected(true);
			},
			error: function (data) {
				self.selectedLocation = null;
				self.selectedAddress = null;
				self.selectedRef = null;
				if (callBack) callBack(false);
				if (self.onSelected) self.onSelected(false);
			}
		});
	};
}