<?php 
session_start();

	include("../connection.php");
	include("../functions.php");

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$username = $_POST['username'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
		$password = $_POST['password'];
    $location = $_POST['location'];
    $user_type = $_POST['user-type'];


    if (!is_valid_location($location)) {
      //Generate a javascript alert that tells invalid location and redirect user to register page
      echo "<script>alert('Invalid Location!');window.location.href = 'register.php';</script>";
    }
		if(!empty($username) && !empty($password) && !empty($first_name) && !empty($last_name) && !empty($location) && !empty($user_type))
		{

      $query = "INSERT INTO USERS (USERNAME, FIRST_NAME, LAST_NAME, PH_NUM, LOCATION, PASSWORD) VALUES ('$username', '$first_name', '$last_name', '555-1234', '$location', '$password');";
      $result = mysqli_query($conn, $query);
      if ($user_type === "CUSTOMER") {
        //Insrt into customer id, the user id
        $customer_entry = "INSERT INTO CUSTOMER (CUSTOMER_ID) VALUES ((SELECT USER_ID FROM USERS WHERE USERNAME = '$username'));";
        $result = mysqli_query($conn, $customer_entry);
      } else if ($user_type === "BARBER") {
        //Insert into barber table, the user id
        $barber_entry = "INSERT INTO BARBER (BARBER_ID, SERV_NAME) VALUES ((SELECT USER_ID FROM USERS WHERE USERNAME = '$username'), 'Trim');";
        $result = mysqli_query($conn, $barber_entry);
      } else {
        //Generate a javascript alert that tells invalid user type and redirect user to register page
        echo "<script>alert('Invalid User Type!');window.location.href = 'register.php';</script>";
      }


      //Redirect user to login page
      header("Location: login.php");
			die;
		}
    else
		{
			echo "Please enter valid information.";
		}
	}

  //The following function checks if the location entered in the locatino field only contains letetrs and space (because a location does not have a number or any symbols)
  function is_valid_location($location) {
    return preg_match("/^[a-zA-Z ]*$/", $location);
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

                  <input type="text" class = "input" id="first-name" name="first-name" placeholder="First Name" aria-label="First Name" autofocus="1"></input>

                  <br><br>

                  <input type="text" class = "input" id="last-name" name="last-name" placeholder="Last Name" aria-label="Last Name" autofocus="1"></input>

                  <br><br>
                  <input type="password" class = "input" id="password" name="password" placeholder="Password" aria-label="Password" autofocus="1"></input>

                  <br><br>
                  <input type="text" class = "input" id="username" name="location" placeholder="Location" aria-label="Location" autofocus="1"></input>
                  
                  <br><br>
                  <label class = "header" for = "user-type">User Type:</label>
                  <select name="user-type" id="user-type">
                    <option value="BARBER">Barber</option>
                    <option value="CUSTOMER">Customer</option>
                  </select>
                  <br><br>
                  <input type="submit" id="create-btn" value="Create Account" name="submit"></input>
              </form>
              <button type="reset" class = "back-to-login" onclick="window.location.href = 'login.php';">Back to Login</button>
          </div>
    </main>
  </body>
</html>