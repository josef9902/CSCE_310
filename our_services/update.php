<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
$barber_check = is_barber($conn, $user_dta['USER_ID']);
$admin_check = is_admin($conn, $user_dta['USER_ID']);
$customer_check = is_customer($conn, $user_dta['USER_ID']);
include('../appointments/header.php');


$row = services_get();
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = $_POST['service_name'] ?? '';
    $price = $_POST['price'] ?? '';

    echo $service_name;
    if (!empty($service_name) && !empty($price)) {
        $result = update_service($id, $conn, $service_name, $price);
        if ($result) {
            echo "<script>alert('Service updated!');window.location.href = 'index.php';</script>";
            exit;
        } else {
            echo "<h3>Error: Service was not updated!</h3>";
        }
    } else {
        echo "<h4>Please fill all fields</h4>";
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col pt-5">
            <h2>Update Service</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['SERV_ID']; ?>" method="post">
                <div class="form-group">
                    <label for="service_name">Service Name</label>
                    <input type="text" name="service_name" value="<?php echo $row['SERV_NAME']; ?>" class="form-control" id="service_name">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" value="<?php echo $row['PRICE']; ?>" class="form-control" id="price">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <hr>
        </div>
    </div>
</div>


<?php
include('footer.php');
?>