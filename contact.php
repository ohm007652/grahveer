<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form data
    $name = trim($_POST['name']); 
    $phone = trim($_POST['phone']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST['message']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Validate non-empty fields
    if (empty($name) || empty($phone) || empty($email) || empty($message)) {
        echo "All fields are required!";
        exit;
    }

    // Sanitize string fields to avoid potential XSS attacks
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "finalprj";  // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and insert data into database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, phone, email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $email, $message);

    // Execute and check if insertion was successful
    if ($stmt->execute()) {
        echo "Your message has been saved to the database.";
    } else {
        echo "Error saving message to database: " . $stmt->error;
    }

    // Close database connection
    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request.";
}
?>
