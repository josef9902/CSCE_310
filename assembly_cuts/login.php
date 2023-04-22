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
			$query = "select * from users where username = '$username' limit 1";
			$result = mysqli_query($con, $query);
			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{
					$user_data = mysqli_fetch_assoc($result);
					if($user_data['password'] === $password)
					{
						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: index.php");
						die;
					}
				}
			}
			
			echo "Wrong username or password";
		}
    else
		{
			echo "Wrong username or password.";
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Assembly Cuts</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <main>
        <div class="login-div">
          <div class = "company-info">
            <h1 class="company-name">Assembly Cuts</h1> 
            <h2 class="subheading">Join us at Assembly Cuts to find professional barbers near you!
          </div>
          <div id="login-form">
              <form name="login-form" method="POST">
                  <input type="text" id="username" name="username" placeholder="Username" aria-label="Username" autofocus="1"></input>

                  <br><br>

                  <input type="password" id="password" name="password" placeholder="Password" aria-label="Password" autofocus="1"></input>

                  <br><br>

                  <input type="submit" id="login-btn" value="Log In" name="login-btn"></input>
              </form>
              <br>
              <hr>
              <br>
              <button type="reset" id="create-btn"name="create-btn" onclick="window.location.href='register.php'">Create new account</button>
          </div>
        </div>
    </main>
  </body>
</html>