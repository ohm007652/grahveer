<?php
$servername = "localhost";
$username = "root"; // Default WAMP username
$password = "";     // No password by default
$dbname = "finalprj"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
