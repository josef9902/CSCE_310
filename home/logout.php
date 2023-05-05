/* This PHP code is destroying the current session and redirecting the user to the login page while
displaying a window alert message that confirms the user has been logged out.

Author: Nitin Pendekanti
Functionality Set One (User Accounts)
*/
<?php
session_start();
session_destroy();
//Create window alert to confirm logout, and redirect to login page
echo "<script type='text/javascript'>alert('You have been logged out.');window.location.href = 'login.php';</script>";
exit;
?>