<?php
    session_start();
    if(!($_SESSION['email'])){
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="booking.css">
    <title>Booking Page</title>
</head>

<body>
    <nav>
        <h1>Conference Booking</h1>
        <?php
            echo "<h3>Hi {$_SESSION['username']}!</h3>";
        ?>
        <form id="logout" action="logout.php">
            <input id="logout-btn" type="submit" value="Log Out">
        </form>
    </nav>
    <div class="booking-container">
        <div class="date-selection">
            <label for="date-picker">Select Date:</label>
            <input type="date" id="date-picker">
            <p>Selected Date: <span id="selected-date">-</span></p>
        </div>
        <div class="time-slots">

        </div>
        <div class="old-date">You choosed an old date! Please select a valid date</div>
    </div>
    <div class="modal" id="bookingModal">
        <div class="modal-content">
            <h2>Book Time Slot</h2>
            <form class="form" action id="bookingForm">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br><br>
                <label for="description">Description:</label>
                <input id="description" name="description" required></input><br><br>
                <input id="submit" type="submit" value="Book">
                <button id="cancel">Cancel</button>
            </form>
        </div>
    </div>

    <div class="modal" id="bookedModal">
        <div class="modal-content">
            <h2 id="booked">Booked Slot</h2>
            <div id="name"></div>
            <div id="titl"></div>
            <div id="desc"></div>
            <div class="btns">
                <button id="close">Close</button>
                <button class="cancelBook">Cancel Booking</button>
            </div>
        </div>
    </div>
    </div>


    <script src="booking.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>