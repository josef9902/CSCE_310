<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
include ('header.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barber_id = $_POST['barber_id'] ?? '';
    $customer_id = $_POST['customer_id'] ?? '';
    $time = $_POST['time'] ?? '';

    if(!empty($barber_id) && !empty($customer_id) && !empty($time)) {
        $result = insert_data($conn, $barber_id, $customer_id, $time);
        if($result) {
            echo "<script>alert('Appointment inserted successfully!');window.location.href = 'index.php';</script>";
            exit;
        } else {
            echo "<h3>Error: Appointment was not inserted!</h3>";
        }
    } else {
        echo "<h4>Please fill all fields</h4>";
    }
}

// Fetch available barber IDs from the database
$barber_options = get_barber_options($conn);

// Fetch available customer IDs from the database
$customer_options = get_customer_options($conn, $_SESSION['user_id']);

?>

<div class="container">
    <div class="row">
        <div class="col pt-5">
            <h2>Create Appointment</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="barber_id">Barber ID</label>
                    <select name="barber_id" class="form-control" id="barber_id">
                        <?php echo $barber_options; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="customer_id">Customer ID</label>
                    <select name="customer_id" class="form-control" id="customer_id">
                        <?php echo $customer_options; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="time">Appointment Time</label>
                    <input type="datetime-local" name="time" class="form-control" id="time">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <hr>
            <?php get_all_edit_data() ?>
        </div>
    </div>
</div>


<?php
include ('footer.php');
?>




