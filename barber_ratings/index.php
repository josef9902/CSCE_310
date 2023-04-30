<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
include ('../appointments/header.php');
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
            </tr>
        </thead>
        <tbody>
            <?php get_all_review_data();?>
        </tbody>
    </table>
</div>
<?php
include ('footer.php');
?>