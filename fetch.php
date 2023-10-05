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
    $check = "SELECT `slot_id` FROM `booking` WHERE `bookingDate` LIKE '$date'";
    $res = mysqli_query($conn, $check);
    if($res) {
        if(mysqli_num_rows($res) > 0) {
            $responseArray = array();
            while ($row = mysqli_fetch_assoc($res)) {
            $responseArray[] = implode(", ", $row);
        }

        $responseString = implode(", ", $responseArray);
        echo $responseString;
    }
    else {
            
    } 
}
else {
    echo "connection failed";
}
} else {
    echo "Invalid request";
}
?>