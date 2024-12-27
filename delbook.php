<?php
include('db.php'); // Database connection file

// Handle delete booking request
if (isset($_POST['delete_booking'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $query = "DELETE FROM bookings WHERE id = $booking_id";
    if (mysqli_query($conn, $query)) {
        $message = "Booking with ID $booking_id has been deleted.";
    } else {
        $message = "Error deleting booking: " . mysqli_error($conn);
    }
}

// Handle delete user request
if (isset($_POST['delete_user'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $query = "DELETE FROM users WHERE id = $user_id";
    if (mysqli_query($conn, $query)) {
        $message = "User with ID $user_id has been deleted.";
    } else {
        $message = "Error deleting user: " . mysqli_error($conn);
    }
}

// Fetch bookings and users for display
$bookings_query = "SELECT id, service, name, email, phone, booking_date FROM bookings";
$bookings_result = mysqli_query($conn, $bookings_query);

$users_query = "SELECT id, name, email, role FROM users";
$users_result = mysqli_query($conn, $users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings and Users</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            background: #d4edda;
            color: #155724;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Bookings and Users</h2>

        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Delete Booking Form -->
        <form method="POST">
            <h3>Delete Booking</h3>
            <label for="booking_id">Enter Booking ID:</label>
            <input type="number" name="booking_id" id="booking_id" required>
            <button type="submit" name="delete_booking">Delete Booking</button>
        </form>

        <!-- Delete User Form -->
        <form method="POST">
            <h3>Delete User</h3>
            <label for="user_id">Enter User ID:</label>
            <input type="number" name="user_id" id="user_id" required>
            <button type="submit" name="delete_user">Delete User</button>
        </form>

        <!-- Display Bookings -->
        <h3>Booking List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Booking Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($booking = mysqli_fetch_assoc($bookings_result)): ?>
                    <tr>
                        <td><?php echo $booking['id']; ?></td>
                        <td><?php echo $booking['service']; ?></td>
                        <td><?php echo $booking['name']; ?></td>
                        <td><?php echo $booking['email']; ?></td>
                        <td><?php echo $booking['phone']; ?></td>
                        <td><?php echo $booking['booking_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Display Users -->
        <h3>User List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo ucfirst($user['role']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div> 
    <a href="adminnew.php">
    <button>Go Back to Dashboard</button>
</body>
</html>
