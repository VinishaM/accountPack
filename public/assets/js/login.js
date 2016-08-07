var app = angular.module('a', []);

app.controller('loginForms', function($scope){
    $scope.registered = true;
    
    $scope.newUser={};
    
    $scope.User = {};
    
    $scope.message = "";
    
    $scope.checkLogin= function(){
        if (angular.equals({}, $scope.User)) {
            $scope.message = 'Enter a username and password to log in.';
        } else {
            $scope.message = '';
        }   
    }
    
    $scope.checkRegister= function(){
        if (angular.equals({}, $scope.newUser)) {
            $scope.message = 'Enter a valid name, password and email to register!';
        } else {
            $scope.message = '';
        } 
    }
});