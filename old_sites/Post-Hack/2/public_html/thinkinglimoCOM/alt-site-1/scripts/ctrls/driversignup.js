var addressApiUrl = "/api/places/search";
var app = angular.module('app', []);

function DriverSignUpCtrl($scope, $http, $timeout) {
	$scope.driver = {
		companyId: null,
		firstName: null,
		lastName: null,
		phone: null,
		email: null,
		password: null,
		vatNumber: null,
		comment: null,
		addressRef: null,
		refererEmail: null,
		companyName: null,
		referenceWays: null,
		captchaChallenge: null,
		captchaResponse: null
	};

	$scope.companyName = null;
	$scope.referral = null;
	$scope.repwd = null;
	$scope.hearAboutDrivr = null;
	$scope.city = null;
	$scope.country = null;
	$scope.countryCode = null;
	$scope.phoneCode = null;
	$scope.phone = null;
	$scope.vatNumber = null;
	$scope.otherCars = 0;
	$scope.agree = false;

	$scope.error = null;
	$scope.registrationSuccess = false;
	$scope.validating = false;
	$scope.isBusy = false;

	$scope.cars = [
	];

	$scope.hearOptions = [
		"You stalked me at the airport",
		"I had a meeting with you",
		"I saw your advertisement",
		"I randomly found you",
		"A friend of me told me about you"
	];

	$scope.init = function () {
		$scope.getCars();
	};
	
	$scope.getCars = function() {
		$scope.isBusy = true;
		$http.get("/api/vehicles/search", { headers: { "Accept": "application/vnd.clickataxi.v1+json" } })
			.success(function(data, status, headers, config) {
				$scope.cars = [];
				for (var a=0; a<data.length; a++) {
					var i = data[a];
					$scope.cars.push({title: i.make + ' ' + i.model, count: 0});
				}
				$scope.cars.push({ title: "Other", count: 0, other: true });
				$scope.isBusy = false;
			})
			.error(function(data, status, headers, config) {
				$scope.handleErrorResponse(data, status);
			});
	}

	$scope.selectCity = function (companyId, city, country, countryCode, phoneCode) {
		$scope.driver.companyId = companyId;
		$scope.city = city;
		$scope.country = country;
		$scope.countryCode = countryCode;
		$scope.phoneCode = phoneCode;
	};

	$scope.getCarsPart = function (part) {
		for (var a = 0; a < $scope.cars.length; a++)
			$scope.cars[a].index = a;


		var start = 0;
		var end = Math.round($scope.cars.length / 2);
		if (part == 1) {
			start = end;
			end = $scope.cars.length;
		}
		return $scope.cars.slice(start, end);
	};

	$scope.submit = function () {
		$scope.error = null;

		$('input[ng-model], select[ng-model]').each(function () {
			angular.element(this).controller('ngModel').$setViewValue($(this).val());
		});

		$scope.driver.referenceWays = null;
		for (var a = 0; a < $scope.hearOptions.length; a++) {
			if ($('#option' + a).is(':checked'))
				$scope.driver.referenceWays = [$('#option' + a).val()];
		}

		$scope.agree = $('#agree').is(':checked');
		//$scope.driver.captchaChallenge = Recaptcha.get_challenge();
		//$scope.driver.captchaResponse = Recaptcha.get_response();

		$scope.validating = true;
		var d = $scope.driver;

		$timeout($scope.scrollToError, 100);

		if ($scope.isFirstNameInvalid()) return;
		if ($scope.isLastNameInvalid()) return;
		if ($scope.isPhoneInvalid()) return;
		if ($scope.isEmailInvalid()) return;
		if ($scope.isPwdInvalid()) return;
		if ($scope.isRePwdInvalid()) return;
		if ($scope.isAddressInvalid()) return;

		d.vehicles = $scope.getChosenCars();

		if (!$scope.agree) {
			alert('To proceed you must agree to the DRIVR oath of good driver conduct');
			return;
		}

		/*if (!$scope.driver.captchaResponse) {
			alert('Please enter human validation words');
			Recaptcha.focus_response_field();
			return;
		}*/

		if ($scope.phone)
			$scope.driver.phone = $scope.phoneCode + $scope.phone;
		else
			d.phone = null;

		if ($scope.vatNumber)
			d.vatNumber = $scope.countryCode + $scope.vatNumber;
		else
			d.vatNumber = null;

		d.addressRef = companyAddress.selectedRef;

		$scope.isBusy = true;
		$http.post('/api/signups', d, { headers: { "Accept": "application/vnd.clickataxi.v1+json" } })
					.success(function (data, status, headers, config) {
						$scope.registrationSuccess = true;
						$scope.isBusy = false;
						$timeout(function () { $scope.scrollToElement($('#driver-registered')); }, 100);
					})
					.error(function (data, status, headers, config) {
						$scope.handleErrorResponse(data, status);
						$scope.isBusy = false;
						$timeout(function () { $scope.scrollToElement($('#suerrors')); }, 100);
					});
	};

	$scope.scrollToError = function() {
		var invalidElements = $('#drive-for-us-form .error');
		if (invalidElements.size() > 0) {
			$scope.scrollToElement(invalidElements);
			$(invalidElements[0]).focus();
		}
	};

	$scope.scrollToElement = function (el) {
		var top = $(el).offset().top - 170;
		$('html, body').animate({
			scrollTop: top
		}, 500);
	};

	$scope.getChosenCars = function() {
		var c = $scope.cars;
		var v = [];
		for (var a = 0; a < c.length; a++) {
			if (c[a].count > 0) {
				v.push({ Item1: c[a].count, Item2: c[a].title });
			}
		}

		if ($scope.otherCars > 0) {
			v.push({ Item1: $scope.otherCars, Item2: "Other" });
		}
		return v;
	};

	$scope.isFirstNameInvalid = function() {
		return !$scope.validating || $scope.driver.firstName ? null : "error";
	};

	$scope.isLastNameInvalid = function () {
		return !$scope.validating || $scope.driver.lastName ? null : "error";
	};

	var PHONE_REGEXP = /^[\d]*$/;
	$scope.isPhoneInvalid = function () {
		return !$scope.validating || ($scope.phone && PHONE_REGEXP.test($scope.phone)) ? null : "error";
	};

	$scope.isEmailInvalid = function () {
		return !$scope.validating || $scope.driver.email ? null : "error";
	};

	$scope.isPwdInvalid = function () {
		return !$scope.validating || ($scope.driver.password && $scope.driver.password.length >= 6) ? null : "error";
	};

	$scope.isRePwdInvalid = function () {
		return !$scope.validating || ($scope.repwd && $scope.driver.password == $scope.repwd) ? null : "error";
	};

	$scope.isAddressInvalid = function () {
		return !$scope.validating || companyAddress.selectedRef ? null : "error";
	};
	
	$scope.handleErrorResponse = function (data, status) {
		$scope.isBusy = false;
		var msg = "";
		if (data != null) {
			$scope.error = data;
		} else {
			$scope.error = { message: "Failed by unknown reason: " + status };
		}
	};

	$scope.fixCheckboxes = function(isLast) {
		if (isLast) customCheckbox();
	};
}

var companyAddress;
$(document).ready(function () {
	companyAddress = $('#company-address').addressSuggestion();
});