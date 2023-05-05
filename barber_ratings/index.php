/* This is a PHP code that displays a table of all reviews in a website. It starts by starting a
session, requiring a functions file, and checking if the user is logged in. It then includes a
header file for the appointments page. The code then displays a table with columns for ID, Barber,
Customer, Rating, Description, and Actions. The data for the table is obtained by calling the
`get_all_review_data()` function. Finally, the code includes a footer file.


Author: Josef Munduchirakal
Functionality Set Four: Reviews

*/
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
include('../appointments/header.php');
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
            <?php get_all_review_data(); ?>
        </tbody>
    </table>
</div>
<?php
include('footer.php');
?>