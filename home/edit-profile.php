<!-- /* This is a PHP code that displays a form for editing user profile information. It starts by starting
a session and including necessary files for database connection and functions. It then checks if the
user is logged in and if they are a barber, admin, or customer. If the user has any error or success
messages, they are displayed. If the user is a barber, a dropdown menu for selecting services is
displayed. The form includes fields for first name, last name, phone number, location, and password.
Finally, there are buttons for saving changes and deleting the account.

Author: Nitin Pendekanti
Functionality Set One (User Accounts)

*/ -->
<?php
session_start();
include("../connection.php");
include("../functions.php");
$user_dta = check_if_user_login($conn);
$barber_check = is_barber($conn, $user_dta['USER_ID']);
$admin_check = is_admin($conn, $user_dta['USER_ID']);
$customer_check = is_customer($conn, $user_dta['USER_ID']);
include('../appointments/header.php');

if (isset($_SESSION["ERROR_MESSAGE"])) {
  echo "<div class='alert alert-danger' role='alert'>" . $_SESSION["ERROR_MESSAGE"] . "</div>";
  unset($_SESSION["ERROR_MESSAGE"]);
}

if (isset($_SESSION["SUCCESS_MESSAGE"])) {
  echo "<div class='alert alert-success' role='alert'>" . $_SESSION["SUCCESS_MESSAGE"] . "</div>";
  unset($_SESSION["SUCCESS_MESSAGE"]);
}

if ($barber_check) {
  $service_options = get_services_choice($conn);
}
?>
<form method="post" action="edit-profile-result.php">
  <div class="form-group">
    <label for="first-name">First Name:</label>
    <input type="text" class="form-control" id="first-name" name="first-name" value="<?php echo $user_dta['FIRST_NAME']; ?>">
  </div>
  <div class="form-group">
    <label for="last-name">Last Name:</label>
    <input type="text" class="form-control" id="last-name" name="last-name" value="<?php echo $user_dta['LAST_NAME']; ?>">
  </div>
  <div class="form-group">
    <label for="phone-number">Phone Number:</label>
    <input type="text" class="form-control" id="phone-number" name="phone-number" value="<?php echo $user_dta['PH_NUM']; ?>">
  </div>
  <div class="form-group">
    <label for="location">Location:</label>
    <input type="text" class="form-control" id="location" name="location" value="<?php echo $user_dta['LOCATION']; ?>">
  </div>
  <?php if (is_barber($conn, $_SESSION['USER_ID'])) : ?>
    <div class="form-group">
      <label for="service">Service:</label>
      <select name="service" class="form-control" id="service">
        <?php echo $service_options; ?>
      </select>
    </div>
  <?php endif; ?>
  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Save Changes</button>
  <a href="delete-account.php" class="btn btn-danger">Delete Account</a>
</form>