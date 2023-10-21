<?php

/* 
Database Configuration Details

Username: root
Password: ""
*/

DEFINE ('DB_SERVER', 'localhost');
DEFINE ('DB_USERNAME', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_NAME', 'login');

// Connecting to the database
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Checking the connection
if($connect == false){
    dir('Error: Cannot connect');
}

?>