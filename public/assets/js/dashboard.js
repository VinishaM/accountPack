var app = angular.module('dash', []);

app.controller('dashboard', function($scope, $http){    
    $scope.User = {};

    $scope.getUser = function() {
        console.log("here");
        $http({
            method: 'GET',
            url: '/checkUser'
        }).then(function successCallback(response) {
              //$scope.validate = response.data.result
              if (response.data.name != undefined) {
                  console.log(response.data);
                  $scope.User = response.data;
              }
          }, function errorCallback(response) {
              console.log("no user exists");
          });
    } 
    
    // $scope.checkLogin= function(){
    //     if (angular.equals({}, $scope.User)) {
    //         $scope.message = 'Enter a username and password to log in.';
    //     } else {
    //         //validate login
    //         $http({
    //           method: 'POST',
    //           url: '/login',
    //           data: {user: $scope.User.name, pass: $scope.User.password}
    //         }).then(function successCallback(response) {
    //             // this callback will be called asynchronously
    //             // when the response is available
    //             if (response.data.result != undefined) {
    //                 $scope.message = response.data.result;
    //             }  

    //           }, function errorCallback(response) {
    //             // called asynchronously if an error occurs
    //             // or server returns response with an error status.
    //             $scope.message = 'Login Failed, please try again.';
    //           });
    //     }   
    // }
    
    // $scope.checkRegister= function(){
    //     if (angular.equals({}, $scope.newUser)) {
    //         $scope.message = 'Enter a valid name, password and email to register';
    //     } else {
    //          //validate new user
    //         $http({
    //           method: 'POST',
    //           url: '/register',
    //           data: {user: $scope.newUser.name, pass: $scope.newUser.password, email: $scope.newUser.email}
    //         }).then(function successCallback(response) {
    //             // this callback will be called asynchronously
    //             // when the response is available
    //             console.log('registered');
    //             //$scope.validate = response.data.result
    //             if (response.data.result != undefined) {
    //                 $scope.message = response.data.result;
    //             } 

    //           }, function errorCallback(response) {
    //             // called asynchronously if an error occurs
    //             // or server returns response with an error status.
    //             $scope.message = 'Registration Failed, please try again.';
    //           });
    //     } 
    // }
  
});