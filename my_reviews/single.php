/* This is a PHP code that displays a review for a barber service. It retrieves data from a database
using SQL queries and displays it on a webpage using HTML and PHP. The code gets the barber name,
customer name, service name, rating, and description from the database and displays them on the
webpage. It also includes a header and footer file for the webpage.

Author: Josef Munduchirakal
Functionality Set Four: Reviews

*/
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
include('../appointments/header.php');
$row = reviews_get();

//Get the barber name and the customer name
$barber_result = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $row['BARBER_ID']);
$barber_row = mysqli_fetch_assoc($barber_result);
$customer_result = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $row['CUST_ID']);
$customer_row = mysqli_fetch_assoc($customer_result);
$service_result = mysqli_query($conn, "SELECT SERV_ID FROM BARBER WHERE BARBER_ID = " . $row['BARBER_ID']);
$service_row = mysqli_fetch_assoc($service_result);
$service_name_result = mysqli_query($conn, "SELECT SERV_NAME FROM SERVICES WHERE SERV_ID = " . $service_row['SERV_ID']);
$service_name_row = mysqli_fetch_assoc($service_name_result);
?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-5">
            <img class="card-img-top" src="https://i1.wp.com/media.premiumtimesng.com/wp-content/files/sites/2/2017/07/Barbers-Shop.jpg" width="200" height="500" alt="Card image cap">
            <h2 class="pt-5"><?php echo 'BARBER NAME: ' . $barber_row['FIRST_NAME'] . ' ' . $barber_row['LAST_NAME'] ?></h2>
            <h2 class="pt-3"><?php echo 'CUSTOMER NAME: ' . $customer_row['FIRST_NAME'] . ' ' . $customer_row['LAST_NAME'] ?></p>
            </h2>
            <h2 class="pt-3"><?php echo 'SERVICE: ' . $service_name_row['SERV_NAME'] ?></p>
                <h2 class="pt-3"><?php echo 'Rating: ' . $row['RATING']  ?></p>
                </h2>
                <p class="pt-3"><?php echo 'Description: ' . $row['DESCRIPTION'] ?></p>
        </div>
    </div>

    <?php
    include('footer.php');
    ?>