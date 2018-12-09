/**
 * db_connection.js
 * 
 * Establishes a connection with MySQL and exports the connection "con" as a module that can be used in other js files such as app.js
 * 
 */
var mysql = require('mysql');

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "root",
    database: "mydb"
});

con.connect(function(err) {
    if (err) throw err;
    console.log("Connected!");
  });

module.exports = con;




    
    

  