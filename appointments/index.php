<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
include ('header.php');
?>

<div class="container py-5">
    <!-- Add an insert button to go to the insert page -->
    <a href="insert.php" class="btn btn-primary">Create Appointment</a>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Barber</th>
                <th scope="col">Customer</th>
                <th scope="col">Time</th>
                <th scope="col">View/Edit/Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php get_all_data();?>
        </tbody>
    </table>
</div>
<?php
include ('footer.php');
?>