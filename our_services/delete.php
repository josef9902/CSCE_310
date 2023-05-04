<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
delete_service();
