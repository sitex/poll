function PollsController($scope, $routeParams, $http) {
	$scope.answers = [];

	$http.get(baseURL+'polls/get_answers/'+$routeParams.poll_id).success(function(data) {
		$scope.answers = data;
	});

	$scope.addAnswer = function() {
		$scope.answers.push({text:$scope.answerText, ordered:$scope.answerOrder});
		$scope.answerText = '';
		$scope.answerOrder = $scope.answerOrder + 1;
	};
	$scope.removeAnswer = function($index) {
		$scope.answers.splice($index, 1);
	};

}

//the following will declare a new directive that
// may be used like
app.directive('poll', function(){
  // The above name 'myDirective' will be parsed out as 'my-directive'
  // for in-markup uses.
  return {
    // restrict to an element (A = attribute, C = class, M = comment)
    // or any combination like 'EACM' or 'EC'
    restrict: 'E',
    scope: {
        pollId: "&pollId"                 // to the name attribute on the directive element.
    },
    //the template for the directive.
    templateUrl: baseURL+'js/template/poll.html',
    //the controller for the directive
    controller: function($scope, $http) {
    	$scope.selectedAns = {selectedOption: ''};
    	$scope.graph = 0;
    	$scope.enableButton = '';
    	$scope.pollId = ($scope.pollId() === undefined) ? '' : $scope.pollId();

    	$http.get(baseURL+'polls/get_poll/'+$scope.pollId).success(function(res) {
    		$scope.graph = res.graph;
    		$scope.pollId = res.poll_id;
    		$scope.question = res.question;
    		$scope.description = res.description;
    		$scope.answers = res.answers;
    		$scope.total_votes = res.total_votes;
    	});

		//change template
		$scope.getTemplate = function(){
			if($scope.graph == 0){
				return baseURL+'js/template/poll_form.html';
			}
			return baseURL+'js/template/poll_graph.html';
		};

		//if radio checked, enable button Vote
		$scope.hasChoice = function(){
			$scope.enableButton = true;
		};

	    //excute submit poll
	    $scope.doVote = function(){
	    	selectedOption = $scope.selectedAns.selectedOption;
	    	$http({
	    		url: baseURL+'polls/submit_poll',
	    		method: "POST",
	    		headers: {'content-type': 'application/json' },
	    		data: {'PollVote': {'poll_id' : $scope.pollId, 'poll_option_id' : selectedOption}},
	    	}).success(function(data, status, headers, config) {
	    		if(data == 1){
			    	//if vote successful - refresh data
			    	$http.get(baseURL+'polls/get_poll/'+$scope.pollId).success(function(res) {
			    		$scope.graph = res.graph;
			    		$scope.pollId = res.poll_id;
			    		$scope.question = res.question;
			    		$scope.description = res.description;
			    		$scope.answers = res.answers;
			    		$scope.total_votes = res.total_votes;
			    		$scope.getTemplate();
			    	});
			    }
			}).error(function(data, status, headers, config) {
				console.log(status);
			});
		}
	},
    replace: true, //replace the directive element with the output of the template.
    //the link method does the work of setting the directive
    // up, things like bindings, jquery calls, etc are done in here
    link: function(scope, elem, attr) {
		// scope is the directive's scope,
		// elem is a jquery lite (or jquery full) object for the directive root element.
		// attr is a dictionary of attributes on the directive element.
		elem.bind('dblclick', function() {
		});
	}
};
});

