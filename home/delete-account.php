<?php
session_start();
include("../connection.php");
include("../functions.php");
$user_dta = check_if_user_login($conn);

// Remove all references to the user in the database
$user_id = $user_dta['USER_ID'];
mysqli_query($conn, "DELETE FROM APPOINTMENTS WHERE CUSTOMER_ID = $user_id OR BARBER_ID = $user_id");
//Remove references in REVIEWS table
mysqli_query($conn, "DELETE FROM REVIEWS WHERE CUSTOMER_ID = $user_id OR BARBER_ID = $user_id");
//Remove references in BARBERS and CUSTOMERS tables
mysqli_query($conn, "DELETE FROM BARBER WHERE BARBER_ID = $user_id");
mysqli_query($conn, "DELETE FROM CUSTOMER WHERE CUSTOMER_ID = $user_id");
mysqli_query($conn, "DELETE FROM USERS WHERE USER_ID = $user_id");

// Destroy the session and redirect to login page
session_destroy();
//Show js alert before redirecting to login page
echo '<script>alert("Account deleted.");window.location.href="../login.php";</script>';
die;
