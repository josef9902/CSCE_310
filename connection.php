<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "group10";

//Connecting to db
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Check if db is fine, if not report error
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>