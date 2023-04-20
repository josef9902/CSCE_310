<?php
session_start();
    include("connection.php");
    include("functions.php");
    $user_data = check_if_login($connection);
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