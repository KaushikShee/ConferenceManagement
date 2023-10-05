<?php
    $servername = "localhost"; 
    $username = "id21350575_root"; 
    $password = "Codilar123#"; 
    $database = "id21350575_conferenceroom_user";  
    
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $date = $_POST['date'];
        $id = $_POST['id'];

        echo $id, $date;
        $delete = "DELETE FROM `booking` WHERE `bookingDate` = '$date' AND `slot_id` = '$id'";
        $res = mysqli_query($conn, $delete);

        if($res) echo "Deleted Successfull!";
    }
?>