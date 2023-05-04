<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
include('header.php');

// Fetch available barber IDs from the database
$barber_result = mysqli_query($conn, "SELECT BARBER_ID FROM BARBER");
$app_entry = mysqli_query($conn, "SELECT * FROM APPOINTMENTS WHERE APP_ID = " . $_GET['id']);
$app_row = mysqli_fetch_assoc($app_entry);
$barber_options = "";
while ($row = mysqli_fetch_assoc($barber_result)) {
    $barber_name = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $row['BARBER_ID']);
    $barber_row = mysqli_fetch_assoc($barber_name);
    //set the default value of the select box to the barber ID of the appointment being updated
    if ($row['BARBER_ID'] == $app_row['BARBER_ID']) {
        $barber_options .= "<option value='" . $row['BARBER_ID'] . "' selected>" . $barber_row['FIRST_NAME'] . ' ' . $barber_row['LAST_NAME'] . "</option>";
    } else {
        $barber_options .= "<option value='" . $row['BARBER_ID'] . "'>" . $barber_row['FIRST_NAME'] . ' ' . $barber_row['LAST_NAME'] . "</option>";
    }
}

// Fetch available customer IDs from the database
//TODO: When login functionality is implemented, make it where the user can only select their own customer ID
$customer_result = mysqli_query($conn, "SELECT CUSTOMER_ID FROM CUSTOMER");
$customer_options = "";
while ($row = mysqli_fetch_assoc($customer_result)) {
    $customer_name = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $row['CUSTOMER_ID']);
    $customer_row = mysqli_fetch_assoc($customer_name);

    //set the default value of the select box to the customer ID of the appointment being updated
    if ($row['CUSTOMER_ID'] == $app_row['CUSTOMER_ID']) {
        $customer_options .= "<option value='" . $row['CUSTOMER_ID'] . "' selected>" . $customer_row['FIRST_NAME'] . ' ' . $customer_row['LAST_NAME'] . "</option>";
    } else {
        $customer_options .= "<option value='" . $row['CUSTOMER_ID'] . "'>" . $customer_row['FIRST_NAME'] . ' ' . $customer_row['LAST_NAME'] . "</option>";
    }
}

$row = update_get();
if (isset($_POST['barber_id']) && isset($_POST['customer_id']) && isset($_POST['time'])) {
    $id = $_GET['id'];
    $barber_id = $_POST['barber_id'];
    $customer_id = $_POST['customer_id'];
    $time = $_POST['time'];
    update_appointment($id, $barber_id, $customer_id, $time);
}

?>

<div class="container">
    <div class="col pt-5">
        <h2>Update Data</h2>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['APP_ID']; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $row['APP_ID']; ?>">
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
                <!-- //Prefill the form with the current data -->
                <input type="datetime-local" name="time" class="form-control" id="time" value="<?php echo $row['TIME']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php
include('footer.php');
?>