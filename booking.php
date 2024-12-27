<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finalprj";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service = $_POST['service'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $description = $_POST['description'];  // Get description from the form

    // Calculate cost based on the service
    $cost = 0;
    switch($service) {
        case 'gardener':
            $cost = 100;
            break;
        case 'plumber':
            $cost = 150;
            break;
        case 'electrician':
            $cost = 200;
            break;
        case 'chef':
            $cost = 120;
            break;
        case 'cleaning':
            $cost = 80;
            break;
        case 'caretaker':
            $cost = 180;
            break;
    }

    // Prepare and bind the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO bookings (service, name, email, phone, address, description, cost) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssd", $service, $name, $email, $phone, $address, $description, $cost);

    if ($stmt->execute()) {
        // Successfully inserted, get the booking ID
        $booking_id = $stmt->insert_id;

        // Redirect to the payment page with the booking ID as a URL parameter
        header("Location: confirm_booking.php?booking_id=" . $booking_id);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();