/* This is a PHP code that creates a form to insert a new service into a database. It starts by
checking if the user is logged in and if they have the necessary permissions to create a new
service. If the form is submitted via POST method, it checks if the required fields are filled and
if the service name already exists in the database. If everything is valid, it inserts the new
service into the database. Finally, it includes the header and footer files for the page.


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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = $_POST['service_name'] ?? '';
    $price = $_POST['price'] ?? '';
    if (empty($service_name) || empty($price)) {
        echo "<script>alert('Please fill in all fields!');window.location.href = 'insert.php';</script>";
        exit;
    }
    //Check if service name already exists in SERVICES table
    $serv_check = "SELECT * FROM SERVICES WHERE SERV_NAME = '$service_name'";
    $result = mysqli_query($conn, $serv_check);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Service already exists!');window.location.href = 'insert.php';</script>";
        exit;
    } else {
        $result = insert_service_data($conn, $service_name, $price);
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col pt-5">
            <h2>Create Service</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="service_name">Service Name</label>
                    <input type="text" name="service_name" class="form-control" id="service_name">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" class="form-control" id="price">
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