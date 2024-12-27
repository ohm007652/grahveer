<?php
// Fetch booking details from the database
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Create a database connection
    $conn = new mysqli('localhost', 'root', '', 'finalprj');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the booking data
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if (!$booking) {
        echo "Booking not found!";
        exit();
    }

    // Booking details
    $service = $booking['service'];
    $name = $booking['name'];
    $email = $booking['email'];
    $cost = $booking['cost'];
    $address = $booking['address'];

    $stmt->close();
    $conn->close();
} else {
    echo "No booking ID provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Grahveer</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 70%;
            margin: 50px auto;
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #4A90E2;
            margin-bottom: 30px;
        }
        .details {
            margin-bottom: 30px;
        }
        .details div {
            margin-bottom: 10px;
        }
        .payment-options {
            display: flex;
            justify-content: space-around;
        }
        .payment-option {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .payment-option:hover {
            transform: scale(1.05);
        }
        .payment-option img {
            width: 60px;
            height: 60px;
        }
        .payment-option h3 {
            color: #4A90E2;
        }
        .pay-now {
            text-align: center;
            margin-top: 20px;
        }
        .pay-now button {
            background-color: #4A90E2;
            color: white;
            padding: 15px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .pay-now button:hover {
            background-color: #357ABD;
        }
    </style>
</head>
<body>
    
<button onclick="history.back()">Back</button>

<div class="container">
    <h2>Payment - Grahveer</h2>

    <!-- Booking Details -->
    <div class="details">
        <div><strong>Name:</strong> <?php echo $name; ?></div>
        <div><strong>Email:</strong> <?php echo $email; ?></div>
        <div><strong>Service:</strong> <?php echo $service; ?></div>
        <div><strong>Cost:</strong> $<?php echo $cost; ?></div>
        <div><strong>Address:</strong> <?php echo $address; ?></div>
    </div>

    <!-- Payment Options -->
    <div class="payment-options">
        <!-- COD Option -->
        <div class="payment-option" onclick="selectPayment('COD')">
            <img src="cod.png" alt="Cash on Delivery">
            <h3>Cash on Delivery</h3>
        </div>
        <!-- Google Pay Option -->
        <div class="payment-option" onclick="selectPayment('Google Pay')">
            <img src="gpay.png" alt="Google Pay">
            <h3>Google Pay</h3>
        </div>
        <!-- PhonePay Option -->
        <div class="payment-option" onclick="selectPayment('PhonePay')">
            <img src="phonepe.png" alt="PhonePay">
            <h3>PhonePay</h3>
        </div>
    </div>

    <!-- Pay Now Button -->
    <div class="pay-now">
        <button id="payButton" disabled>Proceed to Payment</button>
    </div>
</div>

<script>
    function selectPayment(paymentMethod) {
        // Enable the Pay Now button when a payment method is selected
        document.getElementById('payButton').disabled = false;

        // Set up your payment processing logic here, such as redirecting or showing a modal for payment
        document.getElementById('payButton').onclick = function() {
            alert("Proceeding with " + paymentMethod + " payment.");
            // Redirect or further process the payment method here
            // For now, we just simulate success
            window.location.href = "paid.php?payment_method=" + paymentMethod + "&booking_id=<?php echo $booking_id; ?>";
        };
    }
</script>

</body>
</html>
