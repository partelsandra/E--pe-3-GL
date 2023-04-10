<?php
$servername = "localhost";
$username = "partelsandra_abul1";
$password = "qwerty12345qwerty";
$dbname = "partelsandra_HARJUTUS";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
