/* This code starts a PHP session, includes a file named "functions.php", checks if a user is logged in
using the "check_if_user_login" function from the included file, and then calls the "delete"
function. The purpose and functionality of the "delete" function is not provided in the given code
snippet.

Author: Thierry David
Functionality Set Two (Scheduling)
*/
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
delete();
?>