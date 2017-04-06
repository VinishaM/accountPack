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
	if (req.session.userId != undefined) {
		res.sendFile('dashboard.html', {root: __dirname + '/public/'});
	} else {
		res.sendFile('login.html', {root: __dirname + '/public/'});
	}
});

//validate login and redirect as needed.
app.post('/login', function(req, res) {
	var username = req.body.name;
    var password = req.body.password;
    //verify login
	connection.query("SELECT * FROM users WHERE username='" + username + "' AND password='" + password + "'", function(err, rows, fields) {
		console.log(rows);
		if (!err) {
		  	if (rows[0] != undefined) {
		  		//set session to userId
		  		req.session.userId = rows[0].userid;
		  		req.session.firstName = rows[0].firstName;
		  		if (req.session.userId != undefined) {
		  			//tell browser to redirect to home to display dashboard
		  			console.log('Access Granted');
		  			res.send({redirect: true, user: {name: rows[0].firstName, id: rows[0].userid}});
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
	var first = req.body.Fname;
	var last = req.body.Lname;
	var username = req.body.username;
    var password = req.body.password;
    var email = req.body.email;

    console.log(first);
    console.log(last);
    console.log(username);
    console.log(password);
    console.log(email);

    //verify the username does not exist
    //connection.connect();
	connection.query("SELECT * FROM users WHERE email='" + email + "'", function(err, rows, fields) {
		console.log(rows);
		if (!err) {
			//if not, create a new user 
			if (rows[0] == undefined) {
				connection.query("INSERT INTO users(email, username, password, firstName, lastName) VALUES('" + email+ "','" + username+ "','" + password + "','" + first + "','" + last + "')", function(err, rows, fields) {
					if (!err) {
						console.log('New user created');
						//set the new userid as the session variable and redirect to homepageC
						connection.query("SELECT * from users WHERE email='" + email + "'", function(err, rows, feilds) {
							if (!err) {
								//set session to userId
								console.log(req.session);
		  						req.session.userId = rows[0].userid;
		  						req.session.firstName = rows[0].firstName;
		  						res.send({redirect: true, user: {name: rows[0].firstName, id: rows[0].userid}});
							}	
						});	
					}
				});
			} else {
				res.send({result : 'An account with this email already exists.'});
			}
		} else {
			res.send({result : 'An error occured. Please try again.'});
		}
	});
});

//check if user is logged in
app.get("/checkUser", function(req, res) {
	if (req.session.userId != undefined) {
		res.send({name: req.session.firstName, id: req.session.userid});
	} else {
		res.send({result : "no user defined"});
	}
});

//take user information to create dashboard 
app.post('/account', function(req, res) {
	//res.sendFile('dashboard.html', {root: __dirname + '/public/'}
});

app.get('/logout', function(req, res) {
	//log user out
	if (req.session.userId != undefined) {
		console.log("logging out");
		req.session.destroy();
		res.redirect('/');
	} 
});

//initialize app
app.listen(3000, function () {
  console.log('Example app listening on port 3000!');
});
