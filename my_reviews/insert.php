<!-- /* This is a PHP code that creates a form for users to submit a review for a barber. It starts by
starting a session and including necessary functions and headers. It then checks if the request
method is POST and retrieves the values submitted by the user. If all required fields are filled, it
inserts the review data into the database using the `insert_review_data()` function. If the
insertion is successful, it displays a success message and redirects the user to the index page. If
not, it displays an error message.

Author: Josef Munduchirakal
Functionality Set Four: Reviews
*/ -->
<?php
session_start();
require_once '../functions.php';
$user_dta = check_if_user_login($conn);
include('../appointments/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barber_id = $_POST['barber_id'] ?? '';
    $customer_id = $_POST['customer_id'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $description = $_POST['description'] ?? '';

    if (!empty($barber_id) && !empty($customer_id) && !empty($rating) && !empty($description)) {
        $result = insert_review_data($conn, $barber_id, $customer_id, $rating, $description);
        if ($result) {
            echo "<script>alert('Appointment inserted successfully!');window.location.href = 'index.php';</script>";
            exit;
        } else {
            echo "<h3>Error: Appointment was not inserted!</h3>";
        }
    } else {
        echo "<script>alert('Please enter valid information!');window.location.href = 'insert.php';</script>";
    }
}

// Fetch available barber IDs from the database
$barber_options = get_barber_options($conn);

// Fetch available customer IDs from the database
$customer_options = get_customer_option($conn, $user_dta['USERNAME']);

?>

<div class="container">
    <div class="row">
        <div class="col pt-5">
            <h2>Create Review</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="barber_id">Barber ID</label>
                    <select name="barber_id" class="form-control" id="barber_id">
                        <?php echo $barber_options; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="customer_id">Customer ID</label>
                    <input type="text" name="customer_id" class="form-control" id="time" value="<?php echo $user_dta['USER_ID']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="rating">Rating (1-5)</label>
                    <input type="number" name="rating" class="form-control" id="rating" min=1 max=5>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" class="form-control" id="description">
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