<!-- /* This is a PHP code that generates the navigation bar for a website. It starts by checking if a
session is set and starts one if it is not set. It then includes the connection.php file which
contains the database connection details. It then checks if the user is logged in and if they are an
admin, customer, or barber. Based on this, it displays different links in the navigation bar.
Finally, it generates the HTML code for the navigation bar using Bootstrap classes.

Author: Thierry David
Functionality Set Two (Scheduling)
*/ -->
<?php
if (!isset($_SESSION))
  session_start();
include("../connection.php");
// include("../functions.php");
$user_dta = check_if_user_login($conn);
$admin_check = is_admin($conn, $user_dta['USER_ID']);
$customer_check = is_customer($conn, $user_dta['USER_ID']);
$barber_check = is_barber($conn, $user_dta['USER_ID']);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Assembly Cuts</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="../home/index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../appointments/index.php">Appointments</a>
        </li>
        <?php if ($customer_check || $barber_check) : ?>
          <li class="nav-item">
            <a class="nav-link" href="../my_reviews/index.php">My Reviews</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="../barber_ratings/index.php">Barber Ratings</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../our_services/index.php">Services</a>
        </li>
        <?php if ($user_dta != NULL) : ?>
          <li class="nav-item">
            <a class="nav-link" href="../home/logout.php">Logout</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../home/edit-profile.php">Edit Profile</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>