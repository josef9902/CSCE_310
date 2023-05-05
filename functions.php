
/**
The following functions are used for all four functionality sets, and are helper functions to
create read, update, and delete entries in tables in the database. 

THese functions were created by various group members
*/

<?php
require_once('connection.php');


/**
 * The function retrieves all appointments from the database and displays them in a table format with
 * options to view, edit, and delete each appointment.
 * 
 * This is used for Functionality Set Two (Scheduling), assigned to Thierry David
 */
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

/**
 * This function retries all barbers within the database and returns it as an array of results
 * 
 * Created by: Charles Walker (used for Functionality Set Three: Services)
 */
function get_barber_rows()
{
    global $conn;

    $query = "SELECT * FROM BARBER";
    $result = mysqli_query($conn, $query);

    $rows = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }

    return $rows;
}

/**
 * This function returns all barbers who provide a certain service
 * 
 * Created by: Charles Walker (used for Functionality Set Three: Services)
 */

function get_matching_barbers($barbers, $serv_id)
{
    $matching_barbers = array();

    foreach ($barbers as $barber) {
        if ($barber['SERV_ID'] == $serv_id) {
            $matching_barbers[] = $barber;
        }
    }

    return $matching_barbers;
}


/**
 * The function retrieves the first and last name of barbers from a database and returns them as a
 * string.
 * 
 * @param matching_barbers It is an array of barbers that match a certain criteria, such as
 * availability or location.
 * @param conn  is a variable that represents the connection to a MySQL database. It is likely
 * created using the mysqli_connect() function and contains information such as the host, username,
 * password, and database name. This connection is necessary to execute SQL queries on the database.
 * 
 * @return a string containing the first and last names of the barbers whose IDs are in the array
 * . The names are retrieved from the database using the provided  connection
 * object.
 * 
 * 
 * Created by: Charles Walker (used for Functionality Set Three: Services)
 */
function print_matching_barbers($matching_barbers, $conn)
{
    $returnString = '';
    foreach ($matching_barbers as $barber) {
        $user_result = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $barber['BARBER_ID']);
        $user_row = mysqli_fetch_assoc($user_result);
        $returnString .= $user_row['FIRST_NAME'] . ' ' . $user_row['LAST_NAME'] . '<br>';
    }
    return $returnString;
}

/**
 * The function retrieves all service data from the database and displays it in a table format with
 * options to view, edit, and delete services if the user is an admin.
 * 
 * 
 * Charles Walker (used for Functionality Set Three: Services)
 * 
 */

function get_all_service_data()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM SERVICES");

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="col-12 pt-5"><h1>Services</h1></div>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<th scope="row">' . $row['SERV_ID'] . '</th>';
            echo '<td>' . $row['SERV_NAME'] . '</td>';
            echo '<td>' . $row['PRICE'] . '</td>';
            echo '<td>';
            echo '<div class="btn-group">';
            echo '<a href="single.php?id=' . $row['SERV_ID'] . '" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">View</a>';
            //Check if admin is logged in
            if (is_admin($conn, $_SESSION['USER_ID'])) {
                echo '<a href="update.php?id=' . $row['SERV_ID'] . '" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Edit</a>';
                echo '<a href="delete.php?id=' . $row['SERV_ID'] . '" class="btn btn-sm btn-outline-danger" role="button" aria-pressed="true">Delete</a>';
            }
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo "<h3>No services as of this moment. Create one now!</h3>";
    }
}

/**
 * This function retrieves all review data from the database and displays it in a table format,
 * including the barber and customer names, rating, description, and options to view, edit, or delete
 * the review.
 * 
 * 
 * Created by Josef Munduchirakal (used for Functionality Set Four: Reviews)
 */
function get_all_review_data()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM REVIEW ORDER BY BARBER_ID ASC");

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="col-12 pt-5"><h1>Reviews</h1></div>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<th scope="row">' . $row['REV_ID'] . '</th>';
            //Get the name of the barber from the USERS table
            $barber_id = $row['BARBER_ID'];
            $barber_name = mysqli_query($conn, "SELECT * FROM USERS WHERE USER_ID = '$barber_id'");
            $barber_name = mysqli_fetch_assoc($barber_name);
            echo '<td>' . $barber_name['FIRST_NAME'] . ' ' . $barber_name['LAST_NAME'] . '</td>';
            //Get the name of the customer from the USERS table
            $customer_id = $row['CUST_ID'];
            $customer_name = mysqli_query($conn, "SELECT * FROM USERS WHERE USER_ID = '$customer_id'");
            $customer_name = mysqli_fetch_assoc($customer_name);

            //Get the review from the REVIEW table
            $rating = $row['RATING'];
            $description = $row['DESCRIPTION'];
            //Format the time to be more readable
            echo '<td>' . $customer_name['FIRST_NAME'] . ' ' . $customer_name['LAST_NAME'] . '</td>';
            echo '<td>' . $rating . '</td>';
            echo '<td>' . $description . '</td>';
            echo '<td>';
            echo '<div class="btn-group">';
            echo '<a href="single.php?id=' . $row['REV_ID'] . '" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">View</a>';
            if (is_admin($conn, $_SESSION['USER_ID'])) {
                echo '<a href="update.php?id=' . $row['REV_ID'] . '" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Edit</a>';
                echo '<a href="delete.php?id=' . $row['REV_ID'] . '" class="btn btn-sm btn-outline-danger" role="button" aria-pressed="true">Delete</a>';
            }
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo "<h3>No reviews as of this moment. Create one now!</h3>";
    }
}

/**
 * This function retrieves all review data for a specific barber and displays it in a table format.
 * 
 * @param barber_id The ID of the barber for whom we want to retrieve all the reviews.
 * 
 * 
 * Created by Josef Munduchirakal (used for Functionality Set Four: Reviews)
 */
function get_all_review_data_by_barber($barber_id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM REVIEW WHERE BARBER_ID = '$barber_id'");

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="col-12 pt-5"><h1>Reviews</h1></div>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<th scope="row">' . $row['REV_ID'] . '</th>';
            //Get the name of the barber from the USERS table
            $barber_id = $row['BARBER_ID'];
            $barber_name = mysqli_query($conn, "SELECT * FROM USERS WHERE USER_ID = '$barber_id'");
            $barber_name = mysqli_fetch_assoc($barber_name);
            echo '<td>' . $barber_name['FIRST_NAME'] . ' ' . $barber_name['LAST_NAME'] . '</td>';
            //Get the name of the customer from the USERS table
            $customer_id = $row['CUST_ID'];
            $customer_name = mysqli_query($conn, "SELECT * FROM USERS WHERE USER_ID = '$customer_id'");
            $customer_name = mysqli_fetch_assoc($customer_name);

            //Get the review from the REVIEW table
            $rating = $row['RATING'];
            $description = $row['DESCRIPTION'];
            //Format the time to be more readable
            echo '<td>' . $customer_name['FIRST_NAME'] . ' ' . $customer_name['LAST_NAME'] . '</td>';
            echo '<td>' . $rating . '</td>';
            echo '<td>' . $description . '</td>';
            echo '<td>';
            echo '<div class="btn-group">';
            echo '<a href="single.php?id=' . $row['REV_ID'] . '" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">View</a>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo "<h3>No reviews as of this moment. </h3>";
    }
}


/**
 * This function retrieves review data for a specific customer and displays it in a table format with
 * options to view, edit, or delete each review.
 * 
 * @param customer_name_curr The current customer's ID for whom the reviews are being fetched.
 * 
 * 
 * Created by Josef Munduchirakal (used for Functionality Set Four: Reviews)
 */
function get_my_review_data($customer_name_curr)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM REVIEW WHERE CUST_ID = '$customer_name_curr' ");

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="col-12 pt-5"><h1>My Reviews</h1></div>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<th scope="row">' . $row['REV_ID'] . '</th>';
            //Get the name of the barber from the USERS table
            $barber_id = $row['BARBER_ID'];
            $barber_name = mysqli_query($conn, "SELECT * FROM USERS WHERE USER_ID = '$barber_id'");
            $barber_name = mysqli_fetch_assoc($barber_name);
            echo '<td>' . $barber_name['FIRST_NAME'] . ' ' . $barber_name['LAST_NAME'] . '</td>';
            //Get the name of the customer from the USERS table
            $customer_id = $row['CUST_ID'];
            $customer_name = mysqli_query($conn, "SELECT * FROM USERS WHERE USER_ID = '$customer_id'");
            $customer_name = mysqli_fetch_assoc($customer_name);

            //Get the review from the REVIEW table
            $rating = $row['RATING'];
            $description = $row['DESCRIPTION'];
            //Format the time to be more readable
            echo '<td>' . $customer_name['FIRST_NAME'] . ' ' . $customer_name['LAST_NAME'] . '</td>';
            echo '<td>' . $rating . '</td>';
            echo '<td>' . $description . '</td>';
            echo '<td>';
            echo '<div class="btn-group">';
            echo '<a href="single.php?id=' . $row['REV_ID'] . '" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">View</a>';
            echo '<a href="update.php?id=' . $row['REV_ID'] . '" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Edit</a>';
            echo '<a href="delete.php?id=' . $row['REV_ID'] . '" class="btn btn-sm btn-outline-danger" role="button" aria-pressed="true">Delete</a>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo "<h3>No reviews as of this moment. Create one now!</h3>";
    }
}

/**
 * The function retrieves all appointment data from the database and displays it in a table with
 * options to edit or delete each appointment.
 * 
 * This is used for Functionality Set Two (Scheduling), assigned to Thierry David
 */
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
                </tr>';
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

/**
 * The function retrieves a list of barbers from a database and creates HTML options for a dropdown
 * menu.
 * 
 * @param conn  is a variable that represents the database connection object. It is used to
 * establish a connection to the database and execute SQL queries.
 * 
 * @return a string of HTML options for a select element, where each option represents a barber's name
 * and ID.
 * 
 * Created by: Thierry David (used in various Functionality Sets)
 */
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

/**
 * The function retrieves a list of customer IDs from a database and generates HTML options with the
 * corresponding customer names.
 * 
 * @param conn  is a variable that holds the connection to the database. It is used to execute SQL
 * queries and retrieve data from the database.
 * 
 * @return a string of HTML options for a select element, where each option represents a customer's
 * name and ID.
 * 
 * 
 * Created by: Thierry David (used in various Functionality Sets)
 */
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

/**
 * The function retrieves a list of customer names from a database and returns them as HTML options,
 * with ONLY the currently selected customer name being highlighted.
 * 
 * @param conn The database connection object.
 * @param customer_name_curr The current customer name that is selected in the dropdown list.
 * 
 * @return a string of HTML options for a select element, where each option represents a customer's
 * name and ID. The selected option is the one that matches the provided ``
 * parameter.
 * 
 * Created by: Josef Munduchirakal (used for Functionality Set Four: Reviews)
 */
function get_customer_option($conn, $customer_name_curr)
{
    $customer_result = mysqli_query($conn, "SELECT CUSTOMER_ID FROM CUSTOMER");
    $customer_options = "";
    while ($row = mysqli_fetch_assoc($customer_result)) {
        $customer_name = mysqli_query($conn, "SELECT FIRST_NAME, LAST_NAME FROM USERS WHERE USER_ID = " . $row['CUSTOMER_ID']);
        $customer_row = mysqli_fetch_assoc($customer_name);
        if ($row['CUSTOMER_ID'] == $customer_name_curr)
            $customer_options .= "<option value='" . $row['CUSTOMER_ID'] . "'>" . $customer_row['FIRST_NAME'] . ' ' . $customer_row['LAST_NAME'] . "</option>";
    }

    return $customer_options;
}

/**
 * The function retrieves a list of services from a database and generates HTML options for a dropdown
 * menu, with the option corresponding to the barber's current service pre-selected.
 * 
 * @param conn The  parameter is a variable that holds the connection to the database. It is used
 * to execute SQL queries and retrieve data from the database.
 * 
 * @return a string variable named `` which contains HTML `<option>` tags for each
 * service in the database. The selected option is based on the service name associated with the
 * barber's ID stored in the `['USER_ID']` variable.
 * 
 * 
 * Created by Nitin Pendekanti (used for Functionality Set One (User Accounts).
 */
function get_services_choice($conn)
{
    $service_result = mysqli_query($conn, "SELECT * FROM SERVICES");
    //Get barber's SERV_NAME
    $barber_service_name = mysqli_query($conn, "SELECT SERV_ID FROM BARBER WHERE BARBER_ID = " . $_SESSION['USER_ID']);
    $barber_service_name = mysqli_fetch_assoc($barber_service_name);
    $service_name = mysqli_query($conn, "SELECT SERV_NAME FROM SERVICES WHERE SERV_ID = " . $barber_service_name['SERV_ID']);
    $service_name = mysqli_fetch_assoc($service_name);
    $service_options = "";
    while ($row = mysqli_fetch_assoc($service_result)) {
        echo 'test';
        if ($row['SERV_NAME'] == $service_name['SERV_NAME']) {
            $service_options .= "<option value='" . $row['SERV_ID'] . "' selected>" . $row['SERV_NAME'] . "</option>";
        } else {
            $service_options .= "<option value='" . $row['SERV_ID'] . "'>" . $row['SERV_NAME'] . "</option>";
        }
    }

    return $service_options;
}
/**
 * The function inserts appointment data into a database and displays a success message or an error
 * message.
 * 
 * @param conn The database connection object.
 * @param barber_id The ID of the barber who will be performing the appointment.
 * @param customer_id The ID of the customer who is booking the appointment.
 * @param time The time parameter is the date and time of the appointment that is being inserted into
 * the database. It is being escaped using the mysqli_real_escape_string function to prevent SQL
 * injection attacks.
 * 
 * This is used for Functionality Set Two (Scheduling), assigned to Thierry David
 */
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


/**
 * The function inserts review data into a database and displays a success or failure message.
 * 
 * @param conn The database connection object.
 * @param barber_id The ID of the barber being reviewed.
 * @param customer_id The ID of the customer who is leaving the review.
 * @param rating The rating given by the customer for the barber's service. It is a numerical value.
 * @param description The description of the review that the customer has left for the barber.
 * 
 * 
 * Created by: Josef Munduchirakal (used for Functionality Set Four: Reviews)
 */
function insert_review_data($conn, $barber_id, $customer_id, $rating, $description)
{
    // Escape special characters.
    $barber_id = mysqli_real_escape_string($conn, $barber_id);
    $customer_id = mysqli_real_escape_string($conn, $customer_id);
    $rating = mysqli_real_escape_string($conn, $rating);
    $description = mysqli_real_escape_string($conn, $description);

    // Insert data into database
    $insert_query = mysqli_query($conn, "INSERT INTO REVIEW(BARBER_ID, CUST_ID, RATING, DESCRIPTION) VALUES('$barber_id', '$customer_id', '$rating', '$description')");
    echo "test";

    // Check if data has been inserted
    if ($insert_query) {
        echo "<script>alert('Review inserted successfully!');window.location.href = 'index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Review was not inserted!');window.location.href = 'index.php';</script>";
    }
}


/**
 * This function inserts service data into a database and displays a success or failure message.
 * 
 * @param conn The database connection object.
 * @param service_name The name of the service that needs to be inserted into the database.
 * @param price The price of a service that is being inserted into a database.
 * 
 * Created by: Charles Walker (used for Functionality Set Three: Services)
 */
function insert_service_data($conn, $service_name, $price)
{
    // Escape special characters.
    $service_name = mysqli_real_escape_string($conn, $service_name);
    $price = mysqli_real_escape_string($conn, $price);

    // Insert data into database
    $insert_query = mysqli_query($conn, "INSERT INTO SERVICES(SERV_NAME, PRICE) VALUES('$service_name', '$price')");

    // Check if data has been inserted
    if ($insert_query) {
        echo "<script>alert('Service inserted successfully!');window.location.href = 'index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Service was not inserted!');window.location.href = 'index.php';</script>";
    }
}



/**
 * This function retrieves appointment data from the database based on the ID passed through the GET
 * request.
 * 
 * @return an associative array containing the details of an appointment with the specified ID, if it
 * exists in the database. If the appointment does not exist or the ID is not valid, the function does
 * not return anything.
 * 
 * This is used for Functionality Set Two (Scheduling), assigned to Thierry David
 */
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

/**
 * The function retrieves a review from the database based on its ID.
 * 
 * @return an associative array containing the data of a single review from the database, based on the
 * REV_ID passed through the GET request.
 * 
 * Created by: Josef Munduchirakal (used for Functionality Set Four: Reviews)
 */
function reviews_get()
{
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        global $conn;
        $id = $_GET['id'];
        $get_id = mysqli_query($conn, "SELECT * FROM REVIEW WHERE REV_ID='$id'");
        if (mysqli_num_rows($get_id) === 1) {
            $row = mysqli_fetch_assoc($get_id);
            return ($row);
        }
    }
}

/**
 * This function retrieves a row from the SERVICES table based on the SERV_ID provided in the GET
 * request.
 * 
 * @return an associative array containing the details of a service with the specified ID. If the ID is
 * not valid or does not exist in the database, the function will not return anything.
 * 
 * Created by: Charles Walker (used for Functionality Set Three: Services)
 */
function services_get()
{
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        global $conn;
        $id = $_GET['id'];
        $get_id = mysqli_query($conn, "SELECT * FROM SERVICES WHERE SERV_ID='$id'");
        if (mysqli_num_rows($get_id) === 1) {
            $row = mysqli_fetch_assoc($get_id);
            return ($row);
        }
    }
}

/**
 * The function updates an appointment in a database with the given parameters.
 * 
 * @param id The ID of the appointment to be updated.
 * @param barber_id The ID of the barber assigned to the appointment.
 * @param customer_id The ID of the customer who made the appointment.
 * @param time The time parameter is the new date and time for the appointment in the format
 * 'YYYY-MM-DD HH:MM:SS'.
 * 
 * This is used for Functionality Set Two (Scheduling), assigned to Thierry David
 */
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

/**
 * The function updates a review in a database table and displays a success message or an error
 * message.
 * 
 * @param id The ID of the review to be updated.
 * @param barber_id The ID of the barber being reviewed.
 * @param customer_id The ID of the customer who wrote the review.
 * @param rating The rating given by the customer for the barber's service. It is a numerical value
 * usually ranging from 1 to 5, with 1 being the lowest and 5 being the highest.
 * @param description The description of the review that needs to be updated.
 * 
 * Created by: Josef Munduchirakal (used for Functionality Set Four: Reviews)
 */
function update_review($id, $barber_id, $customer_id, $rating, $description)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $barber_id = mysqli_real_escape_string($conn, $barber_id);
    $customer_id = mysqli_real_escape_string($conn, $customer_id);
    $rating = mysqli_real_escape_string($conn, $rating);
    $description = mysqli_real_escape_string($conn, $description);

    $update_query = mysqli_query($conn, "UPDATE REVIEW SET BARBER_ID='$barber_id', CUST_ID='$customer_id', RATING='$rating', DESCRIPTION='$description' WHERE REV_ID='$id'");
    #echo query
    if ($update_query) {
        echo "<script>alert('Review Updated');window.location.href = 'index.php';</script>";
        exit;
    } else {
        echo "<h3>Error updating reviews</h3>";
    }
}

/**
 * The function updates a service in a database using the provided service ID, connection, service
 * name, and price.
 * 
 * @param id The ID of the service to be updated in the database.
 * @param conn The database connection object.
 * @param serv_name The name of the service that needs to be updated.
 * @param price The price of the service being updated.
 * 
 * Created by: Charles Walker (used for Functionality Set Three: Services)
 */
function update_service($id, $conn, $serv_name, $price)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $serv_name = mysqli_real_escape_string($conn, $serv_name);
    $price = mysqli_real_escape_string($conn, $price);

    $update_query = mysqli_query($conn, "UPDATE SERVICES SET SERV_NAME='$serv_name', PRICE='$price' WHERE SERV_ID='$id'");
    #echo query
    if ($update_query) {
        echo "<script>alert('Service Updated');window.location.href = 'index.php';</script>";
        exit;
    } else {
        echo "<h3>Error updating services</h3>";
    }
}

/**
 * This function deletes an appointment from a database based on its ID and displays a success or error
 * message.
 * 
 * This is used for Functionality Set Two (Scheduling), assigned to Thierry David
 */
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


/**
 * This function deletes a review from a database based on its ID and displays a success or error
 * message.
 * 
 * Created by: Josef Munduchirakal (used for Functionality Set Four: Reviews)
 */
function delete_review()
{
    global $conn;
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $userid = $_GET['id'];
        $delete_user = mysqli_query($conn, "DELETE FROM REVIEW WHERE REV_ID='$userid'");

        if ($delete_user) {
            echo "<script>alert('Review removed.');window.location.href = 'index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Something went wrong. Review was not removed.');window.location.href = 'index.php';</script>";
        }
    }
}

/**
 * This function deletes a service from the SERVICES table in a database, but only if it is not
 * currently being used by a barber in the BARBER table.
 * 
 * Created by: Charles Walker (used for Functionality Set Three: Services)
 */
function delete_service()
{
    global $conn;
    if (isset($_GET['id'])) {
        $serv_id = $_GET['id'];

        //check if $serv_name is in BARBER table, if so, don't delete
        $check_barber = mysqli_query($conn, "SELECT * FROM BARBER WHERE SERV_ID='$serv_id'");
        if (mysqli_num_rows($check_barber) > 0) {
            echo "<script>alert('Service is currently in use by a barber.');window.location.href = 'index.php';</script>";
            exit;
        }
        $delete_user = mysqli_query($conn, "DELETE FROM SERVICES WHERE SERV_ID='$serv_id'");
        if ($delete_user) {
            echo "<script>alert('Service removed.');window.location.href = 'index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Something went wrong. Service was not removed.');window.location.href = 'index.php';</script>";
        }
    }
}


/**
 * This function checks if a user is logged in and returns their data, or redirects them to the login
 * page if not.
 * 
 * @param conn  is a variable that represents the database connection object. It is used to
 * establish a connection to the database and execute SQL queries.
 * 
 * @return the user data as an associative array if the user is logged in and their data is found in
 * the database. If the user is not logged in, the function redirects them to the login page and
 * terminates the script.
 * 
 * Created by Nitin Pendekanti (used for Functionality Set One (User Accounts).
 */
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



/**
 * The function checks if a user with a given ID is an admin in a database.
 * 
 * @param conn The  parameter is a variable that represents the database connection object. It is
 * used to establish a connection to the database and execute SQL queries.
 * @param user_id The user_id parameter is the ID of the user being checked for admin privileges.
 * 
 * @return The function is_admin returns a boolean value (true or false) depending on whether the user
 * with the given user_id exists in the ADMIN table of the database connected to by the 
 * parameter. If the user exists, the function returns true, otherwise it returns false.
 * 
 * Created by Nitin Pendekanti (used for Functionality Set One (User Accounts).
 */
function is_admin($conn, $user_id)
{
    $q = "select * from ADMIN where ADMIN_ID = '$user_id' limit 1";
    $res = mysqli_query($conn, $q);
    if ($res && mysqli_num_rows($res) > 0) {
        return true;
    }
    return false;
}


/**
 * The function checks if a user with a given ID is a barber in a database.
 * 
 * @param conn The  parameter is a variable that holds the connection to the database. It is
 * usually created using the mysqli_connect() function and contains information such as the host,
 * username, password, and database name.
 * @param user_id The user_id parameter is the unique identifier of a user in the BARBER table. This
 * function checks if the user with the given user_id is a barber or not by querying the BARBER table
 * in the database.
 * 
 * @return The function `is_barber` returns a boolean value (`true` or `false`) depending on whether
 * the given `` exists in the `BARBER` table of the database connected to by ``. If the
 * user exists, the function returns `true`, otherwise it returns `false`.
 * 
 * Created by Nitin Pendekanti (used for Functionality Set One (User Accounts).
 */
function is_barber($conn, $user_id)
{
    $q = "select * from BARBER where BARBER_ID = '$user_id' limit 1";
    $res = mysqli_query($conn, $q);
    if ($res && mysqli_num_rows($res) > 0) {
        return true;
    }
    return false;
}


/**
 * The function checks if a given user ID exists in the CUSTOMER table of a database.
 * 
 * @param conn The  parameter is a variable that holds the connection to the database. It is
 * usually created using the mysqli_connect() function and contains information such as the host,
 * username, password, and database name.
 * @param user_id The user_id parameter is the ID of the customer that we want to check if they exist
 * in the CUSTOMER table of the database.
 * 
 * @return a boolean value (true or false) depending on whether the given user ID exists in the
 * "CUSTOMER" table of the database connected to by the given connection object.
 * 
 * Created by Nitin Pendekanti (used for Functionality Set One (User Accounts).
 */
function is_customer($conn, $user_id)
{
    $q = "select * from CUSTOMER where CUSTOMER_ID = '$user_id' limit 1";
    $res = mysqli_query($conn, $q);
    if ($res && mysqli_num_rows($res) > 0) {
        return true;
    }
    return false;
}
