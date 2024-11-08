<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "breathewise";

// Create connection
$conn = mysqli_connect($serverName, $username, $password, $dbName);

$con = new PDO("mysql:host=localhost;dbname=breathewise", 'root', '');

?>


