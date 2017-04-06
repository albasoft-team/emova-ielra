'use strict';
var emovaApp = angular.module("emovaApp", []);


emovaApp.config(['$interpolateProvider',function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
}]);