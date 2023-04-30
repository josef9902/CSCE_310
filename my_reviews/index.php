<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
include ('../appointments/header.php');
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
                <th scope="col">Edit/Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php get_my_review_data($user_dta['USER_ID']);?>
        </tbody>
    </table>
</div>
<?php
include ('footer.php');
?>