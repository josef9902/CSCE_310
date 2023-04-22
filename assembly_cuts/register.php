<?php 
session_start();

	include("conn.php");
	include("func.php");

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(!empty($username) && !empty($password))
		{
			$user_id = random_num(1000);
			$query = "insert into users (username,password) values ('$user_id', $username','$password')";

			$result = mysqli_query($con, $query);

			header("Location: login.php");
			die;
		}
    else
		{
			echo "Info not valid";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Assembly Cuts</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
  </head>
  <body>
    <main>
    <div id="login-form">
              <form name="login-form" method="post">
                <h1 class="header">Create new account<h1>
                  <input type="text" class = "input" id="username" name="username" placeholder="Username" aria-label="Username" autofocus="1"></input>

                  <br><br>

                  <input type="password" class = "input" id="password" name="password" placeholder="Password" aria-label="Password" autofocus="1"></input>

                  <br><br>
                  <input type="text" class = "input" id="username" name="location" placeholder="Location" aria-label="Location" autofocus="1"></input>
                  
                  <br><br>

                  <input type="submit" id="create-btn" value="Create Account" name="submit"></input>
              </form>
              <button type="reset" class = "back-to-login" onclick="window.location.href = 'login.php';">Back to Login</button>
          </div>
    </main>
  </body>
</html>