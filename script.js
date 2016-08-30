	// create the module and name it scotchApp
	var app = angular.module('mainApp', ['ngRoute']);

	// configure our routes
	app.config(function($routeProvider, $locationProvider) {
		$routeProvider

			// route for the home page
			.when('/', {
				templateUrl : 'pages/home.html',
				controller  : 'mainController'
			})

			// route for the about page
			.when('/login', {
				templateUrl : 'pages/login.html',
				controller  : 'aboutController'
			})

			// route for the contact page
			.when('/register', {
				templateUrl : 'pages/register.html',
				controller  : 'contactController'
			})
       
         .otherwise({
             redirectTo: '/'
         });
         $locationProvider.html5Mode(true);

	});

	// create the controller and inject Angular's $scope
	app.controller('mainController', function($scope) {
		// create a message to display in our view
		$scope.message = 'Everyone come and see how good I look!';
	});

	app.controller('aboutController', function($scope) {
		$scope.message = 'Look! I am an about page.';
	});

	app.controller('contactController', function($scope) {
		$scope.message = 'Contact us! JK. This is just a demo.';
	});
