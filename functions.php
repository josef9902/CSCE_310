<?php
require_once('connection.php');


//The following function generates a view of the appointments table
function get_all_data()
{

    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM APPOINTMENTS");

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="col-12 pt-5"><h1>All Appointments</h1></div>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<th scope="row">' . $row['APP_ID'] . '</th>';
            //Get the name of the barber from the USERS table
            $barber_id = $row['BARBER_ID'];
            $barber_name = mysqli_query($conn, "SELECT * FROM USERS WHERE USER_ID = '$barber_id'");
            $barber_name = mysqli_fetch_assoc($barber_name);
            echo '<td>' . $barber_name['FIRST_NAME'] . ' ' . $barber_name['LAST_NAME'] . '</td>';
            //Get the name of the customer from the USERS table
            $customer_id = $row['CUSTOMER_ID'];
            $customer_name = mysqli_query($conn, "SELECT * FROM USERS WHERE USER_ID = '$customer_id'");
            $customer_name = mysqli_fetch_assoc($customer_name);

            //Get the time of the appointment from the APPOINTMENTS table
            $time = $row['TIME'];
            //Format the time to be more readable
            $time = date("F j, Y, g:i a", strtotime($time));
            echo '<td>' . $customer_name['FIRST_NAME'] . ' ' . $customer_name['LAST_NAME'] . '</td>';
            echo '<td>' . $time . '</td>';
            echo '<td>';
            echo '<div class="btn-group">';
            echo '<a href="single.php?id=' . $row['APP_ID'] . '" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">View</a>';
            echo '<a href="update.php?id=' . $row['APP_ID'] . '" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Edit</a>';
            echo '<a href="delete.php?id=' . $row['APP_ID'] . '" class="btn btn-sm btn-outline-danger" role="button" aria-pressed="true">Delete</a>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo "<h3>No appointments as of this moment. Create one now!</h3>";
    }
}

function get_all_edit_data()
{
    global $conn;
    $get_data = mysqli_query($conn, "SELECT * FROM APPOINTMENTS");
    if (mysqli_num_rows($get_data) > 0) {
        echo '<table>
              <tr>
                <th><h2>Edit Data</h2></th>
              </tr>
                <tr>
                    <th>APPOINTMENT ID</th>
                    <th>BARBER_ID</th>
                    <th>CUSTOMER_ID</th>
                    <th>TIME</th>
                    <th>Action</th>
                </tr>'

              ;
        while ($row = mysqli_fetch_assoc($get_data)) {

            $customer_name = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $row['CUSTOMER_ID']);
            $customer_name = mysqli_fetch_assoc($customer_name);

            $barber_name = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $row['BARBER_ID']);
            $barber_name = mysqli_fetch_assoc($barber_name);

            $time = $row['TIME'];
            $time = date("F j, Y, g:i a", strtotime($time));

            echo '<tr>
            <td>' . $row['APP_ID'] . '</td>
            <td>' . $barber_name['FIRST_NAME'] . '</td>
            <td>' . $customer_name['FIRST_NAME'] . '</td>
            <td>' . $time . '</td>
            <td>
            <a href="update.php?id=' . $row['APP_ID'] . '">Edit</a> |
            <a href="delete.php?id=' . $row['APP_ID'] . '">Delete</a>
            </td>
            </tr>';
        }
        echo '</table>';
    } else {
        echo "<h3>Please add some appointments</h3>";
    }
}

//Insert.php - Insert Data into appointments table
function get_barber_options($conn)
{
    $barber_result = mysqli_query($conn, "SELECT BARBER_ID FROM BARBER");
    $barber_options = "";
    while ($row = mysqli_fetch_assoc($barber_result)) {
        $barber_name = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $row['BARBER_ID']);
        $barber_row = mysqli_fetch_assoc($barber_name);
        $barber_options .= "<option value='" . $row['BARBER_ID'] . "'>" . $barber_row['FIRST_NAME'] . ' ' . $barber_row['LAST_NAME'] . "</option>";
    }

    return $barber_options;
}
function get_customer_options($conn)
{
    $customer_result = mysqli_query($conn, "SELECT CUSTOMER_ID FROM CUSTOMER");
    $customer_options = "";
    while ($row = mysqli_fetch_assoc($customer_result)) {
        $customer_name = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $row['CUSTOMER_ID']);
        $customer_row = mysqli_fetch_assoc($customer_name);
        $customer_options .= "<option value='" . $row['CUSTOMER_ID'] . "'>" . $customer_row['FIRST_NAME'] . ' ' . $customer_row['LAST_NAME'] . "</option>";
    }

    return $customer_options;
}

function insert_data($conn, $barber_id, $customer_id, $time)
{
    // Escape special characters.
    $barber_id = mysqli_real_escape_string($conn, $barber_id);
    $customer_id = mysqli_real_escape_string($conn, $customer_id);
    $time = mysqli_real_escape_string($conn, $time);

    // Insert data into database
    $insert_query = mysqli_query($conn, "INSERT INTO APPOINTMENTS(BARBER_ID, CUSTOMER_ID, TIME) VALUES('$barber_id', '$customer_id', '$time')");

    // Check if data has been inserted
    if ($insert_query) {
        echo "<script>alert('Appointment inserted successfully!');window.location.href = 'index.php';</script>";
        exit;
    } else {
        echo "<h3>Error: Appointment was not inserted!</h3>";
    }
}



//Update.php - Collect Data to update entry in appointments table

function update_get()
{
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        global $conn;
        $id = $_GET['id'];
        $get_id = mysqli_query($conn, "SELECT * FROM APPOINTMENTS WHERE APP_ID='$id'");
        if (mysqli_num_rows($get_id) === 1) {
            $row = mysqli_fetch_assoc($get_id);
            return ($row);
        }
    }
}

//Update.php - Update data from appointments table
function update_appointment($id, $barber_id, $customer_id, $time)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $barber_id = mysqli_real_escape_string($conn, $barber_id);
    $customer_id = mysqli_real_escape_string($conn, $customer_id);
    $time = mysqli_real_escape_string($conn, $time);
    #UPDATE APPOINTMENTS SET BARBER_ID='17', CUSTOMER_ID='19', TIME='2023-04-18 14:25:00' WHERE APP_ID='18'
    $update_query = mysqli_query($conn, "UPDATE APPOINTMENTS SET BARBER_ID='$barber_id', CUSTOMER_ID='$customer_id', TIME='$time' WHERE APP_ID='$id'");
    #echo query
    if ($update_query) {
        echo "<script>alert('Appointment Updated');window.location.href = 'index.php';</script>";
        exit;
    } else {
        echo "<h3>Error updating appointments</h3>";
    }
}

//Delete.php - Delete entry from appointments table
//The following function deletes an appointment entry from the appointments table. It grabs the id from the browser session
//and checks if it is found in the database. If it is, it deletes the entry. If not, it tells the user that something went wrong.
function delete()
{
    global $conn;
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $userid = $_GET['id'];
        $delete_user = mysqli_query($conn, "DELETE FROM APPOINTMENTS WHERE APP_ID='$userid'");

        if ($delete_user) {
            echo "<script>alert('Appointment removed.');window.location.href = 'index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Something went wrong. Appointment was not removed.');window.location.href = 'index.php';</script>";
        }
    }
}

//The following function checks if a user is logged in. It generates a SQL query which grabs the id from the 
//browser session and checks if it is found in the database. If it is, it returns the user data. If not, it redirects
//the user to the login page.
function check_if_user_login($conn)
{
    if (isset($_SESSION['USER_ID'])) {
        $id = $_SESSION['USER_ID'];
        $q = "select * from USERS where USER_ID = '$id' limit 1";
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            $user_data = mysqli_fetch_assoc($res);
            return $user_data;
        }
    }


    header("Location: ../home/login.php");
    die;
}



//This function will check if a user is an admin (meaning it's id is found in the admin table as a foreign key)
function is_admin($conn, $user_id)
{
    $q = "select * from ADMIN where USER_ID = '$user_id' limit 1";
    $res = mysqli_query($conn, $q);
    if ($res && mysqli_num_rows($res) > 0) {
        return true;
    }
    return false;
}

//This function will check if a user is a barber (meaning it's id is found in the barber table as a foreign key)
function is_barber($conn, $user_id)
{
    $q = "select * from BARBER where USER_ID = '$user_id' limit 1";
    $res = mysqli_query($conn, $q);
    if ($res && mysqli_num_rows($res) > 0) {
        return true;
    }
    return false;
}
