<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "Assembly_Cuts_DB";

if(!$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) die("Could not connect!");
?>