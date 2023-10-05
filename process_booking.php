<?php
session_start();
$servername = "localhost"; 
$username = "id21350575_root"; 
$password = "Codilar123#"; 
$database = "id21350575_conferenceroom_user";  

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}


$id = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $slotId = $_POST['timeSlotId'];
    $title = $_POST['title'];
    $desc = $_POST['description'];

    echo $slotId, $time, $date,  $title, $desc;
    $check = "SELECT `user_id` FROM `booking` WHERE `bookingTime` LIKE '$time' AND `bookingDate` LIKE '$date'";
    $res = mysqli_query($conn, $check);
    if($res) {
        if(mysqli_num_rows($res) > 0) echo "user exist";
        else {
            $insert = "INSERT INTO `booking` (`user_id`, `bookingTime`, `bookingDate`, `bookingTitle`, `bookingDetails`, `slot_id`) VALUES ('$id', '$time', '$date', '$title', '$desc', '$slotId')";
            $res = mysqli_query($conn, $insert);
        } 
    }
    else {
        echo "connection failed";
    }
} else {
    echo "Invalid request";
}
?>
