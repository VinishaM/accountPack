//follow tutorial at https://scotch.io/tutorials/creating-a-single-page-todo-app-with-node-and-angular
var express = require('express');
var app = express();
var mongoose = require('mongoose');                    
var morgan = require('morgan');             
var bodyParser = require('body-parser');    
var methodOverride = require('method-override');

app.use(express.static(__dirname + '/public')); 

app.get('/', function (req, res) {
    //res.send('Hello World!');
    res.sendFile('login.html', {root: __dirname + '/public/'})
});

app.post('/account', function(req, res) {
	//res.sendFile('dashboard.html', {root: __dirname + '/public/'}
});
app.listen(3000, function () {
  console.log('Example app listening on port 3000!');
});
