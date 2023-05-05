/* This is a PHP code that displays a table of appointments. It starts a session, includes a file with
necessary functions, checks if the user is logged in, and includes a header file. It then creates a
container with a button to create a new appointment and a table to display all appointments. The
table has columns for ID, Barber, Customer, Time, and View/Edit/Delete buttons. The `get_all_data()`
function is called to retrieve all appointment data and display it in the table. Finally, a footer
file is included.

Author: Thierry David
Functionality Set Two (Scheduling)

*/
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
include('header.php');
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
            <?php get_all_data(); ?>
        </tbody>
    </table>
</div>
<?php
include('footer.php');
?>