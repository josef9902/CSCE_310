<!-- /* This is a PHP code that is establishing a connection to a MariaDB (MySQL) database. It sets the server name,
username, password, and database name as variables, and then uses the `mysqli_connect()` function to
connect to the database. It also checks if the connection was successful, and if not, it reports an
error message using the `die()` function. 

Created by: Thierry David 

*/ -->
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