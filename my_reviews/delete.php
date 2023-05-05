<!-- /* This PHP code starts a session, includes a file named "functions.php", checks if a user is logged in
using the "check_if_user_login" function from the included file, and then calls the "delete_review"
function. The purpose of the code depends on the implementation of the "delete_review" function, but
it likely deletes a review from a database or some other data storage system.

Author: Josef Munduchirakal
Functionality Set Four: Reviews
*/ -->
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
delete_review();
?>