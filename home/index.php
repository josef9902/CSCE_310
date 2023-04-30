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
    include ('../appointments/header.php');
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
include ('../appointments/footer.php');
?>