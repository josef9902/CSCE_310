<?php
require_once 'functions.php';
include ('header.php');


// Fetch available barber IDs from the database
$barber_result = mysqli_query($conn, "SELECT BARBER_ID FROM BARBER");
$barber_options = "";
while ($row = mysqli_fetch_assoc($barber_result)) {
    $barber_options .= "<option value='".$row['BARBER_ID']."'>".$row['BARBER_ID']."</option>";
}

// Fetch available customer IDs from the database
//TODO: When login functionality is implemented, make it where the user can only select their own customer ID
$customer_result = mysqli_query($conn, "SELECT CUSTOMER_ID FROM CUSTOMER");
$customer_options = "";
while ($row = mysqli_fetch_assoc($customer_result)) {
    $customer_options .= "<option value='".$row['CUSTOMER_ID']."'>".$row['CUSTOMER_ID']."</option>";
}
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




