<?php
    $servername = "localhost"; 
    $username = "id21350575_root"; 
    $password = "Codilar123#"; 
    $database = "id21350575_conferenceroom_user";  
    
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

session_start();

if (isset($_POST['login'])) {
    $mailPhone = $_POST['email_phone'];
    $query = "SELECT * FROM `user` WHERE `email` = ? OR `phone` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $mailPhone, $mailPhone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res_fetch = mysqli_fetch_assoc($result);
            if (password_verify($_POST['password'], $res_fetch['password'])) {
                $_SESSION['username'] = $res_fetch['name'];
                $_SESSION['phone'] = $res_fetch['phone'];
                $_SESSION['email'] = $res_fetch['email'];
                $_SESSION['id'] = $res_fetch['id'];
                header("Location: booking.php");
                exit();
            } else {
                echo "<script>
                        alert('Wrong password');
                        window.location.href = 'index.php';
                      </script>";
                exit();
            }
        } else {
            echo "<script>
                    alert('User does not exist');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                alert('Error!');
                window.location.href = 'index.php';
              </script>";
        exit();
    }
}
?>