<!-- /* This is a PHP code that creates a form for creating a new appointment. It starts by starting a
session and including a file with some functions. It then checks if the user is logged in and if
they are a barber, admin, or customer. It includes a header file and checks if the request method is
POST. If it is, it gets the barber ID, customer ID, and appointment time from the form and inserts
them into the database. If the insertion is successful, it displays a success message and redirects
to the index page. If not, it displays an error message. It then fetches the available barber and
customer IDs from the database and displays them in dropdown menus. It also displays a form for
entering the appointment time and a submit button. Finally, it includes a function that gets all the
appointment data for editing. It ends by including a footer file.

Author: Thierry David
Functionality Set Two (Scheduling)

*/ -->
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
$barber_check = is_barber($conn, $user_dta['USER_ID']);
$admin_check = is_admin($conn, $user_dta['USER_ID']);
$customer_check = is_customer($conn, $user_dta['USER_ID']);
include('header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barber_id = $_POST['barber_id'] ?? '';
    $customer_id = $_POST['customer_id'] ?? '';
    $time = $_POST['time'] ?? '';

    if (!empty($barber_id) && !empty($customer_id) && !empty($time)) {
        $result = insert_data($conn, $barber_id, $customer_id, $time);
        if ($result) {
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
$customer_options = get_customer_options($conn);

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
                        <?php if ($admin_check || $barber_check) : ?>
                            <?php echo $customer_options; ?>
                        <?php else : ?>
                            <option value="<?php echo $_SESSION['USER_ID']; ?>"><?php echo $user_dta['FIRST_NAME'] . ' ' . $user_dta['LAST_NAME']; ?></option>
                        <?php endif; ?>
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
include('footer.php');
?>