<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM employees WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $employee = mysqli_fetch_assoc($result);

        if (password_verify($password, $employee['password'])) {
            // Start session
            session_start();
            // Store employee details in session
            $_SESSION['employee_id'] = $employee['id'];
            $_SESSION['employee_name'] = $employee['name'];
            $_SESSION['employee_profession'] = $employee['profession'];

            // Redirect to dashboard
            header("Location: empdash.php");
            exit;
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Email not found!";
    }
}
?>

