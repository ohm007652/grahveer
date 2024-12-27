<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finalprj";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$booking_id = filter_input(INPUT_GET, 'booking_id', FILTER_VALIDATE_INT);

if (!$booking_id) {
    die("Invalid booking ID.");
}

$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Booking not found.");
}

$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
</head>
<body>
    <h2>Confirm Your Booking</h2>
    <p>Service: <?= htmlspecialchars($booking['service']) ?></p>
    <p>Name: <?= htmlspecialchars($booking['name']) ?></p>
    <p>Email: <?= htmlspecialchars($booking['email']) ?></p>
    <p>Phone: <?= htmlspecialchars($booking['phone']) ?></p>
    <p>Address: <?= htmlspecialchars($booking['address']) ?></p>
    <p>Description: <?= htmlspecialchars($booking['description']) ?></p>
    <p>Cost: ₹<?= htmlspecialchars($booking['cost']) ?></p>
    <a href="payment.php?booking_id=<?= $booking['id'] ?>">Proceed to Payment</a>
</body>
</html>
