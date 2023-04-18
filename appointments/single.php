<?php
require_once 'functions.php';
include ('header.php');
$row = update_get();
?>

<div class="container">
    <div class="row">
    <div class="col-12 pt-5">
    <img class="card-img-top" src="https://i1.wp.com/media.premiumtimesng.com/wp-content/files/sites/2/2017/07/Barbers-Shop.jpg" alt="Card image cap">
    <h2 class="pt-5"><?php echo 'BARBER ID: ' .$row['BARBER_ID'] ?></h2>
    <p><?php echo 'CUSTOMER_ID: '. $row['CUSTOMER_ID'] ?></p></div>
    </div>
</div>

<?php
include ('footer.php');
?>