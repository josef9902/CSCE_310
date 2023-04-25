<?php
session_start();
session_destroy();
//Create window alert to confirm logout, and redirect to login page
echo "<script type='text/javascript'>alert('You have been logged out.');window.location.href = 'login.php';</script>";
exit;
?>
