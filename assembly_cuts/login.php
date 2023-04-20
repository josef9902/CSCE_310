<?php
session_start();
    $_SESSION;
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