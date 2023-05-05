<!-- /* This is a PHP code that displays a table of reviews based on the user's role (customer, barber, or
admin). It starts by starting a session and including a functions file. It then checks the user's
role using functions like `is_customer()` and `is_barber()`.

Author: Josef Munduchirakal
Functionality Set Four: Reviews
*/ -->
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
$barber_check = is_barber($conn, $user_dta['USER_ID']);
$admin_check = is_admin($conn, $user_dta['USER_ID']);
$customer_check = is_customer($conn, $user_dta['USER_ID']);
include('../appointments/header.php');
?>

<?php
if ($customer_check) {
?>
    <div class="container py-5">
        <!-- Add an insert button to go to the insert page -->
        <a href="insert.php" class="btn btn-primary">Write a Review</a>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Barber</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php get_my_review_data($user_dta['USER_ID']); ?>
            </tbody>
        </table>
    </div>
<?php
} else if ($barber_check) {
?>
    <div class="container py-5">
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Barber</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Description</th>
                    <th scope="col">View</th>
                </tr>
            </thead>
            <tbody>
                <?php get_all_review_data_by_barber($user_dta['USER_ID']) ?>
            </tbody>
        </table>
    </div>
<?php
} else {
?>
    <div class="container py-5">
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Barber</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php get_all_review_data() ?>
            </tbody>
        </table>
    </div>
<?php
}
?>

<?php
include('footer.php');
?>