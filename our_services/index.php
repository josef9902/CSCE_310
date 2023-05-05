<!-- /* This is a PHP code that displays a table of services with their IDs, names, prices, and actions. It
also includes a button to create a new service, but only if the user is an admin. The code starts by
starting a session and requiring a functions file. It then checks if the user is a barber, admin, or
customer using functions from the functions file. It includes a header file for the appointments
page and displays the table of services using a function called `get_all_service_data()`. Finally,
it includes a footer file.

Author: Charles Walker
Functionality Set Three: Services
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

<div class="container py-5">
    <?php if ($admin_check) : ?>
        <a href="insert.php" class="btn btn-primary">Create a service</a>
    <?php endif; ?>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Service ID</th>
                <th scope="col">Service Name</th>
                <th scope="col">Price</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php get_all_service_data() ?>
        </tbody>
    </table>
</div>

<?php
include('footer.php');
?>