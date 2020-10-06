var app = angular.module("myApp", ['ngAnimate','ui.bootstrap','ngRoute','textAngular']);

// Collapse on index.php

app.controller('Collapse', function ($scope) {
	$scope.isNavCollapsed = true;
});

// routeProvider and locationProvider
    app.config(function($routeProvider) {
        $routeProvider

			.when('/home', {
                templateUrl : 'pages/start.html'
            })

            // route for the explore page
            .when('/explore', {
                templateUrl : 'pages/explore.php',
                controller  : 'exploreController'
            })

            // route for the create page
            .when('/create', {
                templateUrl : 'pages/create.php',
                controller  : 'createController'
            });
						
    });
	
	// exploreController
	
    app.controller('exploreController', function($scope,$route,$http) {
				
		// expl. message
		
        $scope.message = 'Explore Central!';
		
		// ng-show at explore.php
		
		$scope.value = false;
		
		$scope.hideTbl = function(){
			$scope.value = true;
		};
		
		// comments toggle delete
		
		$scope.show_send = function ($parent,$index) {
			$parent.toggle = !$parent.toggle;
			$parent.selectedIndex=$index;
		};
		
		// reloadPage after button click to go back to exploring

		$scope.reloadPage = function() {
			$route.reload();
		};		
		
		// display selected article info inside a prebuilt table
		
		$scope.selectedx = function($content_id,$content_title,$content_user,$content_likes) {
			
			$scope.selected_id = $content_id;
			$scope.selected_title = $content_title;
			$scope.selected_user = $content_user;
			$scope.selected_likes = $content_likes;	
		
		// ajax call to get selected article id for comments to be loaded
		
		$http({
              
              method: 'POST',
              url: 'pages/post.php',
			  dataType:'json',
				data: {
					data: $scope.selected_id
				}
              
          }).then(function (response) {
              
              // on success
			  $scope.data = response.data;
               
          }, function (response) {
              
              // on error
              console.log(response.data,response.status);
              
          });
		  
		 };
			
    });
	
	// message for people that are not logged in on create.php

    app.controller('createController', function($scope) {
        $scope.message = 'You must log in to start creating articles!';
    });
	
	// app for profile - home.php
		
	var userApp = angular.module("profileApp", ['ngAnimate','ui.bootstrap','textAngular']);

	userApp.controller('profileController', function($scope) {
		
		// ng-show at home.php
		
		$scope.button = false;
		$scope.edit = false;
		
		$scope.showEditButton = function(){
			$scope.button = true;
		};
		
		$scope.showEdit = function(){
			$scope.edit = true;
		};
		
		// status for username dropdown
		
		$scope.status = {
			isopen: false
		};	
		
		// display selected article info inside a prebuilt table at home.php
		
		$scope.selectedx = function($content_id,$content_title,$content_user,$content_likes) {
			$scope.selected_id = $content_id;
			$scope.selected_title = $content_title;
			$scope.selected_user = $content_user;
			$scope.selected_likes = $content_likes;
		};			

    });

	



