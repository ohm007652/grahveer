<?php
include('db.php');

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Encrypt password
$job_type = mysqli_real_escape_string($conn, $_POST['job_type']);

$query = "INSERT INTO employee (name, email, password, job_type) VALUES ('$name', '$email', '$password', '$job_type')";

if (mysqli_query($conn, $query)) {
    header('Location: admindash.php');
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

