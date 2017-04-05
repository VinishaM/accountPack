var app = angular.module('a', []);

app.controller('loginForms', function($scope, $http){
    $scope.registered = true;
    
    $scope.newUser={};
    
    $scope.User = {};
    
    $scope.message = "";

    $scope.validate = '';
    
    $scope.checkLogin= function(){
        if (angular.equals({}, $scope.User)) {
            $scope.message = 'Enter a username and password to log in.';
        } else {
            //validate login
            $http({
              method: 'POST',
              url: '/login',
              data: $scope.User
            }).then(function successCallback(response) {
                // this callback will be called asynchronously when the response is available
                if (response.data.result != undefined) {
                    $scope.message = response.data.result;
                } else if (response.data.redirect == true) {
                    window.location = '/';
                } else {
                  $scope.message = "Login Failed, please try again.";
                }

              }, function errorCallback(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                $scope.message = 'Login Failed, please try again.';
              });
        }   
    }
    
    $scope.checkRegister= function(){
        console.log($scope.newUser);
        if (angular.equals({}, $scope.newUser)) {
            $scope.message = 'Enter a valid name, password and email to register';
        } else {
             //validate new user
            $http({
              method: 'POST',
              url: '/register',
              data: $scope.newUser
            }).then(function successCallback(response) {
                // this callback will be called asynchronously when the response is available
                console.log('registered');
                //$scope.validate = response.data.result
                if (response.data.result != undefined) {
                    $scope.message = response.data.result;
                } else if (response.data.redirect == true) {
                    window.location = '/'
                } else {
                  $scope.message = "Login Failed, please try again."
                }

              }, function errorCallback(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                $scope.message = 'Registration Failed, please try again.';
              });
        } 
    }
});