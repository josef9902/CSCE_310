/* This is a PHP code that starts a session, includes necessary files for database connection and
functions, checks if the user is logged in, and handles the logout functionality. It also includes a
header and footer file for the HTML code. The HTML code displays a greeting message to the user and
a logout button. When the user clicks on the logout button, the session is destroyed and the user is
redirected to the login page.

Author: Nitin Pendekanti
Functionality Set One (User Accounts)

*/
<?php
session_start();
include("../connection.php");
include("../functions.php");
$user_dta = check_if_user_login($conn);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: login.php");
        die;
    }
}
include('../appointments/header.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Page Title</title>
</head>

<body>
    <h1>Assembly Cuts</h1>
    <!-- Set greeting to user here -->
    <p>Howdy <?php echo $user_dta['FIRST_NAME']; ?>!</p>

    <form method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

</body>

</html>
<?php
include('../appointments/footer.php');
?>