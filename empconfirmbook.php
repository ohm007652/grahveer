<?php
include('db.php');
$booking_id = $_GET['booking_id'];

$query = "SELECT * FROM bookings WHERE id = $booking_id";
$result = mysqli_query($conn, $query);
$booking = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 24px;
            color: #4A90E2;
        }
        .booking-details {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .booking-details p {
            font-size: 18px;
            margin: 10px 0;
        }
        .booking-details strong {
            color: #4A90E2;
        }
        .button {
            display: inline-block;
            background-color: #4A90E2;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            margin: 20px 10px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #357ABD;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        a {
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Booking Details</h1>
    <div class="booking-details">
        <p><strong>Service:</strong> <?php echo $booking['service']; ?></p>
        <p><strong>Customer:</strong> <?php echo $booking['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $booking['email']; ?></p>
        <p><strong>Address:</strong> <?php echo $booking['address']; ?></p>
        <a href="sendmail.php?email=<?php echo $booking['email']; ?>" class="button">Send Confirmation Mail</a>
        <a href="empviewbook.php" class="button" style="background-color: #ccc;">Back to Bookings</a>
    </div>
</body>
</html>
