<?php
session_start();
include("../connection.php");
include("../functions.php");
$user_dta = check_if_user_login($conn);
if($_SERVER['REQUEST_METHOD'] == "POST")
{
  $first_name = mysqli_real_escape_string($conn, $_POST['first-name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last-name']);
  $phone_number = mysqli_real_escape_string($conn, $_POST['phone-number']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
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