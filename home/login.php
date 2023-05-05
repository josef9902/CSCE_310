/* This is a PHP code that handles user login functionality. It starts a session, includes necessary
files for database connection and functions, and checks if the request method is POST. If it is, it
retrieves the username and password from the form data, checks if they are not empty, and queries
the database to find a user with the given username. If a user is found, it checks if the password
matches and sets the user ID in the session. If the login is successful, it redirects the user to
the index page. If the login fails, it displays an error message. The script also includes HTML code
for a login form and a button to create a new account.

Author: Nitin Pendekanti
Functionality Set One (User Accounts)

*/
<?php

session_start();

include("../connection.php");
include("../functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (!empty($username) && !empty($password)) {
    $query = "select * from USERS where USERNAME = '$username' limit 1";
    $res = mysqli_query($conn, $query);




    if ($res) {
      if ($res && mysqli_num_rows($res) > 0) {
        $user_dta = mysqli_fetch_assoc($res);


        if ($user_dta['PASSWORD'] === $password) {
          $_SESSION['USER_ID'] = $user_dta['USER_ID'];
          header("Location: index.php");
          die;
        }
      }
    }

    echo "Username or password is incorrect";
  } else {
    echo "Username or password is incorrect";
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
      <div class="company-info">
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
        <button type="reset" id="create-btn" name="create-btn" onclick="window.location.href='register.php'">Create new account</button>
      </div>
    </div>
  </main>
</body>

</html>