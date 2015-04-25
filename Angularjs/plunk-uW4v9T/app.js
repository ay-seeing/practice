var animateApp = angular.module('animateApp', ['ngRoute', 'ngAnimate']);

animateApp.config(function($routeProvider) {
    $routeProvider
        .when('/', {
        templateUrl: 'page-home.html',
            controller: 'mainController'
        })
        .when('/about', {
            templateUrl: 'page-about.html',
            controller: 'aboutController'
        })
        .when('/contact', {
            templateUrl: 'page-contact.html',
            controller: 'contactController'
        });

});

animateApp.controller('mainController', function($scope) {
    $scope.pageClass = 'page-home';
});

animateApp.controller('aboutController', function($scope) {
    $scope.pageClass = 'page-about';
});

animateApp.controller('contactController', function($scope) {
    $scope.pageClass = 'page-contact';
});