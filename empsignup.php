<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $dob = $_POST['dob'];
    $profession = $_POST['profession'];
    $id_card_type = $_POST['id_card_type'];
    $experience = $_POST['experience'];

    $query = "INSERT INTO employees (name, age, email, password, dob, profession, id_card_type, experience)
              VALUES ('$name', $age, '$email', '$password', '$dob', '$profession', '$id_card_type', '$experience')";

    if (mysqli_query($conn, $query)) {
        // Get the last inserted employee ID
        $employee_id = mysqli_insert_id($conn);

        // Start a session and set the employee ID
        session_start();
        $_SESSION['employee_id'] = $employee_id;

        // Redirect to the dashboard
        header("Location:empdash.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
