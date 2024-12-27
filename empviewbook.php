<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit;
}

include('db.php');
$employee_id = $_SESSION['employee_id'];

// Fetch employee profession
$query = "SELECT profession FROM employees WHERE id = $employee_id";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);
$profession = $employee['profession'];

// Fetch bookings
$bookings_query = "SELECT * FROM bookings WHERE service = '$profession'";
$bookings_result = mysqli_query($conn, $bookings_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 24px;
            color: #4A90E2;
        }
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #4A90E2;
            color: white;
        }
        table td {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #4A90E2;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Bookings for <?php echo ucfirst($profession); ?></h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Service</th>
                <th>Customer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = mysqli_fetch_assoc($bookings_result)): ?>
                <tr>
                    <td><?php echo $booking['id']; ?></td>
                    <td><?php echo $booking['service']; ?></td>
                    <td><?php echo $booking['name']; ?></td>
                    <td>
                        <a href="empconfirmbook.php?booking_id=<?php echo $booking['id']; ?>">Confirm Booking</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="back-link">
        <a href="empdash.php">Back to Dashboard</a>
    </div>
</body>
</html>
