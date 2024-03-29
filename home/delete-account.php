<!-- /* This PHP code is deleting a user account from a database and destroying the session associated with
that user. It first checks if the user is a barber, admin, or customer, and then removes all
references to the user in the database, including appointments, reviews, and any entries in the
BARBERS and CUSTOMERS tables. Finally, it destroys the session and redirects the user to the login
page, displaying a JavaScript alert to confirm that the account has been deleted.

Author: Nitin Pendekanti
Functionality Set One (User Accounts)

*/ -->
<?php
session_start();
include("../connection.php");
include("../functions.php");
$user_dta = check_if_user_login($conn);
$barber_check = is_barber($conn, $user_dta['USER_ID']);
$admin_check = is_admin($conn, $user_dta['USER_ID']);
$customer_check = is_customer($conn, $user_dta['USER_ID']);


// Remove all references to the user in the database
$user_id = $user_dta['USER_ID'];
mysqli_query($conn, "DELETE FROM APPOINTMENTS WHERE CUSTOMER_ID = $user_id OR BARBER_ID = $user_id");
//Remove references in REVIEWS table
mysqli_query($conn, "DELETE FROM REVIEW WHERE CUST_ID = $user_id OR BARBER_ID = $user_id");
//Remove references in BARBERS and CUSTOMERS tables
mysqli_query($conn, "DELETE FROM BARBER WHERE BARBER_ID = $user_id");
mysqli_query($conn, "DELETE FROM CUSTOMER WHERE CUSTOMER_ID = $user_id");
mysqli_query($conn, "DELETE FROM USERS WHERE USER_ID = $user_id");

// Destroy the session and redirect to login page
session_destroy();
//Show js alert before redirecting to login page
echo '<script>alert("Account deleted.");window.location.href="../home/login.php";</script>';
die;
