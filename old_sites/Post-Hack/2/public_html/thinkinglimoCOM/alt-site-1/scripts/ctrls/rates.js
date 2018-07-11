var app = angular.module('app', []);

function RatesCtrl($scope, $http) {
	$scope.city = null;
	$scope.country = null;
	$scope.price = null;
	$scope.vehicleRates = null;
	$scope.isBusy = false;
    
	$scope.init = function () {
	};

	$scope.selectCity = function (companyId, city, country) {
		$scope.city = city;
		$scope.country = country;
	    $scope.getCityPriceRates(companyId);
	};

    $scope.getCityPriceRates = function(companyId) {
    	$scope.isBusy = true;
    	$http.get("/api/companies/" + companyId + "/rates", { headers: { "Accept": "application/vnd.clickataxi.v2+json" } })
            .success(function(data, status, headers, config) {
                $scope.vehicleRates = data;
                $scope.isBusy = false;
            })
            .error(function(data, status, headers, config) {
            	$scope.isBusy = false;
            	$scope.price = null;
                $scope.vehicleRates = null;
            });
    };
}
