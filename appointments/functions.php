<?php 
require_once ('connection.php');

function get_all_data(){

global $conn;
$result = mysqli_query($conn,"SELECT * FROM APPOINTMENTS");

    if(mysqli_num_rows($result) > 0){
        echo '<div class="col-12 pt-5"><h1>All Appointments</h1></div>';  
        
        while($row = mysqli_fetch_assoc($result)){  
            echo'<tr>';
            echo '<th scope="row">'.$row['APP_ID'].'</th>';
            //Get the name of the barber from the USERS table
            $barber_id = $row['BARBER_ID'];
            $barber_name = mysqli_query($conn,"SELECT * FROM USERS WHERE USER_ID = '$barber_id'");
            $barber_name = mysqli_fetch_assoc($barber_name);
            echo '<td>'.$barber_name['FIRST_NAME'].' '.$barber_name['LAST_NAME'].'</td>';
            //Get the name of the customer from the USERS table
            $customer_id = $row['CUSTOMER_ID'];
            $customer_name = mysqli_query($conn,"SELECT * FROM USERS WHERE USER_ID = '$customer_id'");
            $customer_name = mysqli_fetch_assoc($customer_name);
            echo '<td>'.$customer_name['FIRST_NAME']. '</td>';
            echo '<td>';
            echo '<div class="btn-group">';
            echo '<a href="single.php?id='.$row['APP_ID'].'" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">View</a>';
            echo '<a href="update.php?id='.$row['APP_ID'].'" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Edit</a>';
            echo '<a href="delete.php?id='.$row['APP_ID'].'" class="btn btn-sm btn-outline-danger" role="button" aria-pressed="true">Delete</a>';
            echo '</div>';
            echo '</td>';
            echo'</tr>';
        }

    }

    else{
        echo "<h3>No appointments as of this moment. Create one now!</h3>";
    }

}

function get_all_edit_data(){
    global $conn;
    $get_data = mysqli_query($conn,"SELECT * FROM APPOINTMENTS");
    if(mysqli_num_rows($get_data) > 0){
        echo '<table>
              <tr>
                <th><h2>Edit Data</h2></th>
              </tr>';
        while($row = mysqli_fetch_assoc($get_data)){
           
            echo '<tr>
            <td>'.$row['APP_ID'].'</td>
            <td>
            <a href="update.php?id='.$row['APP_ID'].'">Edit</a> |
            <a href="delete.php?id='.$row['APP_ID'].'">Delete</a>
            </td>
            </tr>';

        }
        echo '</table>';
    }else{
        echo "<h3>Please add some appointments</h3>";
    }
}

//Insert.php - Insert Data

if(isset($_POST['barber_id']) && isset($_POST['customer_id']) && isset($_POST['time'])){

    // check barber_id, customer_id and time fields are not empty
    if(!empty($_POST['barber_id']) && !empty($_POST['customer_id']) && !empty($_POST['time'])){

        // Escape special characters.
        $barber_id = mysqli_real_escape_string($conn, $_POST['barber_id']);
        $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);  

        // Insert data into database
        $insert_query = mysqli_query($conn,"INSERT INTO APPOINTMENTS(BARBER_ID,CUSTOMER_ID,TIME) VALUES('$barber_id','$customer_id','$time')");

        //Check if 

        // Check if data has been inserted
        if($insert_query){
            echo "<script>alert('Appointment inserted successfully!');window.location.href = 'index.php';</script>";
            exit;
        }else{
            echo "<h3>Error: Appointment was not inserted!</h3>";
        }

    }else{
        echo "<h4>Please fill all fields</h4>";
    }

}


//Update.php - Collect Data

function update_get(){
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    global $conn;
    $id = $_GET['id'];
    $get_id = mysqli_query($conn,"SELECT * FROM APPOINTMENTS WHERE APP_ID='$id'");
        if(mysqli_num_rows($get_id) === 1){
            $row = mysqli_fetch_assoc($get_id);
            return($row);
        }
    } 
}

//Update.php - Update data

if(isset($_POST['update_title']) && isset($_POST['update_content'])){

//check if items are empty

if(!empty($_POST['update_title']) && !empty($_POST['update_content'])){

    // Escape special characters.

    $title = mysqli_real_escape_string($conn, htmlspecialchars($_POST['update_title']));
    $content = mysqli_real_escape_string($conn, htmlspecialchars($_POST['update_content']));

    $id = $_GET['APP_ID'];
                        
    $update_query = mysqli_query($conn,"UPDATE posts SET title='$title',content='$content' WHERE id=$id");

    if($update_query){
        echo "<script>alert('Post Updated');window.location.href = 'index.php';</script>";
        exit;
    }else{
        echo "<h3>Sorry, that didn't work</h3>";
    }
}else{
    echo "<h4>Please fill all fields</h4>";
    }
}

//Delete.php

function delete(){
    global $conn;
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $userid = $_GET['id'];
        $delete_user = mysqli_query($conn,"DELETE FROM APPOINTMENTS WHERE APP_ID='$userid'");
        
        if($delete_user){
            echo "<script>alert('Appointment removed.');window.location.href = 'index.php';</script>";
            exit;
            
        }else{
        echo "I think something went wrong"; 
        }
    }
}