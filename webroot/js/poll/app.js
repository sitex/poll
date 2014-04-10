var app = angular.module('poll', ['ui'], function($routeProvider, $locationProvider) {

	$routeProvider.when('/edit_poll/:poll_id', {
		templateUrl: baseURL+'/js/template/add_option.html',
		controller: PollsController
	});
});
