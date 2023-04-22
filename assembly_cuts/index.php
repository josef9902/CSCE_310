<?php 
session_start();

	include("conn.php");
	include("func.php");

	$user_data = check_login($con);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
    </head>

    <body>
        <a href="login.php">Logout</a> 
        <h1>Assembly Cuts</h1>
        <p>IN PROGRESS</p>

    </body>
</html>