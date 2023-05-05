<!-- /* This PHP code is starting a session, including a file with functions, checking if a user is logged
in, and deleting a service.

Author: Charles Walker
Functionality Set Three: Services
*/ -->
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
delete_service();
