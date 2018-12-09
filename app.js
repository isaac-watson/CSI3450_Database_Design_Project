/**
 * app.js
 * The main js class looked for to run the express web server with the node command.
 * Establishes the app module dependencies and express routes for the url in the browser as well as path names in the project.
 * Opens the webserver at localhost on port 3000
 * 
 */
var express = require("express");
var app = express();
//var db = require("./db_connection.js");

var phpExpress = require('php-express')({
    binPath: 'php'
});

app.set('views', './views');
app.engine('php', phpExpress.engine);
app.set('view engine', 'php');
app.all(/.+\.php$/, phpExpress.router);

var path = __dirname + '/views/';
  
app.get("/",function(req,res){
    res.sendFile(path + "index.html");
});

app.get("/about",function(req,res){
    res.sendFile(path + "about.html");
});

app.get("/sell.php",function(req,res){
    res.sendFile(path + "sell.php");
});

app.get("/browse.php",function(req,res){
    res.sendFile(path + "browse.php");
});

app.use(express.static(path));
app.use(express.static(__dirname + '/src/'));

app.listen(3000,function(){
console.log("Live at Port 3000");
});
  