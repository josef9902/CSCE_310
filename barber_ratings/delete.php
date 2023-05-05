/* This PHP code is starting a session, including a file with functions, checking if a user is logged
in, and deleting a review.

Author: Josef Munduchirakal
Functionality Set Four: Reviews
*/
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
delete_review();
