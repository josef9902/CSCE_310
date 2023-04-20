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
              <form name="login-form" method="POST">
                <h1 class="header">Create new account<h1>
                  <input type="text" class = "input" id="username" name="username" placeholder="Username" aria-label="Username" autofocus="1"></input>

                  <br><br>

                  <input type="password" class = "input" id="password" name="password" placeholder="Password" aria-label="Password" autofocus="1"></input>

                  <br><br>
                  <input type="text" class = "input" id="username" name="location" placeholder="Location" aria-label="Location" autofocus="1"></input>
                  
                  <br><br>

                  <input type="submit" id="create-btn" value="Create Account" name="create-btn"></input>
              </form>
              <button type="reset" class = "back-to-login" onclick="window.location.href = 'login.php';">Back to Login</button>
          </div>
    </main>
  </body>
</html>