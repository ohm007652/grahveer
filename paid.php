<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if payment details are passed in the URL
if (isset($_GET['payment_method']) && isset($_GET['booking_id'])) {
    // Capture payment details and booking ID from the URL
    $payment_method = $_GET['payment_method'];
    $booking_id = $_GET['booking_id'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "finalprj";

    // Create connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the booking status to "Paid" and save the payment method
    $stmt = $conn->prepare("UPDATE bookings SET payment_status = ?, payment_method = ? WHERE id = ?");
    $payment_status = "Paid"; // You can change the status to 'Completed' or any other status as needed
    
    // Bind the parameters to the query
    $stmt->bind_param("ssi", $payment_status, $payment_method, $booking_id);
    
    if ($stmt->execute()) {
        // Payment updated successfully
        $stmt->close();
    } else {
        // Error while updating payment status
        echo "Error updating payment: " . $stmt->error;
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
} else {
    // Error message if payment details are not passed
    echo "<h1>Error: Payment details not provided.</h1>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>

    <!-- Bootstrap for styling and Popper for animations -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <style>
        /* Custom styles for the page */
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .container h1 {
            color: #4CAF50;
            font-size: 36px;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-out;
        }

        .container p {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            animation: fadeIn 1.5s ease-out;
        }

        .details-box {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            animation: slideUp 1s ease-out;
        }

        .details-box h3 {
            color: #007bff;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .details-box p {
            font-size: 16px;
            margin: 5px 0;
        }

        .thank-you {
            font-size: 20px;
            color: #555;
            margin-top: 30px;
            font-weight: bold;
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Button style */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            color: #fff;
            font-size: 18px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <div class="container" id="success-container">
        <h1> Congratulations! </h1>
        <p>Your booking has been successfully processed.</p>

        <div class="details-box">
            <h3>Booking Details</h3>
            <p><strong>Booking ID:</strong> <?php echo $booking_id; ?></p>
            <p><strong>Payment Method:</strong> <?php echo $payment_method; ?></p>
        </div>

        <div class="thank-you">
            <p>Thank you for booking with us! 💙</p>
            <a href="exit.html" class="btn-primary">Next</a>
        </div>
    </div>

    <!-- Script for animation pop-up -->
    <script>
        // Simulating a pop-up effect
        document.addEventListener('DOMContentLoaded', function () {
            let container = document.getElementById('success-container');
            setTimeout(function () {
                container.style.transform = 'scale(1.05)';
                container.style.transition = 'transform 0.5s ease-out';
            }, 100);

            // Optional: Display a "Thank You" message with animation
            setTimeout(function () {
                let thankYouMessage = document.querySelector('.thank-you');
                thankYouMessage.style.opacity = 1;
                thankYouMessage.style.transition = 'opacity 1s ease-out';
            }, 500);
        });
    </script>
</body>
</html>
