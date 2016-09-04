//follow tutorial at https://scotch.io/tutorials/creating-a-single-page-todo-app-with-node-and-angular
var express = require('express');
var session = require('express-session');
var app = express();
var mongoose = require('mongoose');                    
var morgan = require('morgan');             
var bodyParser = require('body-parser');    
var methodOverride = require('method-override');
var mysql      = require('mysql');

//use bodyParser to read JSON requests 
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

//use cookies for user sessions
app.use(session({ secret: 'blahblah', cookie: {}}));

//define path to main files
app.use(express.static(__dirname + '/public')); 

//establish Db connection
var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'root',
	password : 'password',
	database : 'accountdb'
});
connection.connect();

//direct to login screen or dashboard if the user is logged in 
app.get('/', function (req, res) {
	if (req.session.userId) {
		res.sendFile('dashboard.html', {root: __dirname + '/public/'});
	} else {
		res.sendFile('login.html', {root: __dirname + '/public/'});
	}
});

//validate login and redirect as needed.
app.post('/login', function(req, res) {
	var username = req.body.user;
    var password = req.body.pass;

    //verify login
	connection.query("SELECT userid FROM users WHERE username='" + username + "' AND password='" + password + "'", function(err, rows, fields) {
		console.log(rows);
		if (!err) {
		  	if (rows[0] != undefined) {
		  		//set session to userId
		  		req.session.userId = rows[0].userid;
		  		console.log(rows[0].userid);
		  		if (req.session.userId != undefined) {
		  			//tell browser to redirect to home to display dashboard
		  			console.log('Access Granted');
		  			res.send({redirect: true});
		  		} else {
		  			//log out old user and log in new one
		  		}
		  	} else {
		  		res.send({result: 'Username or password was incorrect, please try again.'});
		  	} 	
	  	} else {
	  		res.send({result: 'An error occured. Please try again.'});
	 	}
	});
});

//create new user and redirect to dashboard 
app.post('/register', function(req, res){
	var username = req.body.user;
    var password = req.body.pass;
    var email = req.body.email;

    console.log(username);
    console.log(password);
    console.log(email);

    //verify the username does not exist
	connection.query('SELECT userId FROM users', function(err, rows, fields) {
	  	if (err) throw err;
	  	console.log('The solution is: ', rows[0].solution);
	});
});

//take user information to create dashboard 
app.post('/account', function(req, res) {
	//res.sendFile('dashboard.html', {root: __dirname + '/public/'}
});

app.get('/logout', function(req, res) {
	//verify and add user
	connection.end();
});

//initialize app
app.listen(3000, function () {
  console.log('Example app listening on port 3000!');
});
