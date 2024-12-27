<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'finalprj');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Validate password
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        $conn->close();
        exit; // Stop further execution if validation fails
    }

    // Check if the email is already registered
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email is already registered!";
    } else {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            // Registration successful, redirect to services page
            header("Location: service.html");
            exit; // Stop further execution after redirection
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    $conn->close();
}
?>
