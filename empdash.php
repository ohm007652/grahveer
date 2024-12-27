<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit;
}

include('db.php');
$employee_id = $_SESSION['employee_id'];

// Fetch employee details
$query = "SELECT * FROM employees WHERE id = $employee_id";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .menu {
            display: flex;
            justify-content: space-between;
        }
        a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $employee['name']; ?></h1>
        <div class="menu">
            <a href="empprofile.php">View Profile</a>
            <a href="empviewbook.php">View Bookings</a>
        </div>
    </div>
    <a href="login.html">
    <button>Back</button>
</body>
</html>
