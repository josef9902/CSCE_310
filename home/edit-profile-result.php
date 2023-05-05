<!-- /* This is a PHP code block that updates the user's profile information in the database. It starts by
starting a session and including necessary files for database connection and functions. It then
checks if the request method is POST and retrieves the user's input data from the form. If the user
is a barber, it updates the service they offer. It then updates the user's information in the
database and sets a success or error message in the session depending on the result. Finally, it
redirects the user to the edit profile page.

Author: Nitin Pendekanti
Functionality Set One (User Accounts)

*/ -->
<?php
session_start();
include("../connection.php");
include("../functions.php");
$user_dta = check_if_user_login($conn);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $first_name = mysqli_real_escape_string($conn, $_POST['first-name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last-name']);
  $phone_number = mysqli_real_escape_string($conn, $_POST['phone-number']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  if (is_barber($conn, $_SESSION['USER_ID'])) {
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $query = "UPDATE BARBER SET SERV_ID = '$service' WHERE BARBER_ID = " . $user_dta['USER_ID'];
    $result = mysqli_query($conn, $query);
  }
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $query = "UPDATE USERS SET FIRST_NAME = '$first_name', LAST_NAME = '$last_name', PH_NUM = '$phone_number', LOCATION = '$location'";
  if (!empty($password)) {
    $query .= ", PASSWORD = '$password'";
  }
  $query .= " WHERE USER_ID = " . $user_dta['USER_ID'];
  $result = mysqli_query($conn, $query);
  echo 'waiting';
  if ($result) {
    $_SESSION["SUCCESS_MESSAGE"] = "Profile updated.";
  } else {
    $_SESSION["ERROR_MESSAGE"] = "Profile update failed.";
  }
  header("Location: edit-profile.php");
  die;
}
?>