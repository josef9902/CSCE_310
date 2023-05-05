/* This is a PHP code that displays information about a specific service, including its name, price,
and available barbers who can provide the service. It starts by checking if the user is logged in
and their role (barber, admin, or customer) using functions from an external file. It then retrieves
information about the service from the database using its ID, including its name and price. It also
retrieves a list of all barbers and filters them to only show those who can provide the service.
Finally, it displays the information in an HTML format using Bootstrap classes and includes a footer
file.

Author: Charles Walker
Functionality Set Three: Services
*/
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
$barber_check = is_barber($conn, $user_dta['USER_ID']);
$admin_check = is_admin($conn, $user_dta['USER_ID']);
$customer_check = is_customer($conn, $user_dta['USER_ID']);
include('../appointments/header.php');
$row = services_get();
$all_barbers = get_barber_rows();
$matching_barbers = get_matching_barbers($all_barbers, $row['SERV_ID']);

$service_result = mysqli_query($conn, "SELECT SERV_NAME FROM SERVICES WHERE SERV_ID = " . $row['SERV_ID']);
$service_row = mysqli_fetch_assoc($service_result);
$service_price_result = mysqli_query($conn, "SELECT PRICE FROM SERVICES WHERE SERV_ID = " . $row['SERV_ID']);
$service_price_row = mysqli_fetch_assoc($service_price_result);


$theVariable = print_matching_barbers($matching_barbers, $conn);

?>

<div class="container">
    <div class="row">
        <div class="col-12 pt-5">
            <img class="card-img-top" src="https://i1.wp.com/media.premiumtimesng.com/wp-content/files/sites/2/2017/07/Barbers-Shop.jpg" width="200" height="500" alt="Card image cap">
            <h2 class="pt-5"><?php echo 'SERVICE NAME: ' . $service_row['SERV_NAME'] ?></h2>
            <h2 class="pt-3"><?php echo 'SERVICE PRICE: ' . $service_price_row['PRICE'] ?></p>
                <h2 class="pt-3">AVAILABLE BARBERS: </h2>
                <h3><?php echo $theVariable ?> </h3>
            </h2>
        </div>
    </div>






    <?php
    include('footer.php');
    ?>