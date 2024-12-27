<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'finalprj');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['id'];  // Get user ID from session

// Fetch user information from the database
$query = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Handle profile update if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Update user details in the database
    $update_query = "UPDATE users SET name='$name', email='$email' WHERE id = $user_id";
    if (mysqli_query($conn, $update_query)) {
        echo "<div class='alert success'>Profile updated successfully!</div>";
    } else {
        echo "<div class='alert error'>Error updating profile: " . mysqli_error($conn) . "</div>";
    }
}

// Handle password change if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password in the database
            $update_password_query = "UPDATE users SET password='$hashed_password' WHERE id = $user_id";
            if (mysqli_query($conn, $update_password_query)) {
                echo "<div class='alert success'>Password changed successfully!</div>";
            } else {
                echo "<div class='alert error'>Error changing password: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert error'>New password and confirmation do not match.</div>";
        }
    } else {
        echo "<div class='alert error'>Current password is incorrect.</div>";
    }
}

// Fetch user bookings from the 'bookings' table
$bookings_query = "SELECT * FROM bookings WHERE email = '".$user['email']."'";  // Match bookings by user email
$bookings_result = mysqli_query($conn, $bookings_query);

// Handle booking deletion if form is submitted
if (isset($_POST['delete_booking'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $delete_query = "DELETE FROM bookings WHERE id = $booking_id AND email = '".$user['email']."'"; // Ensure the booking belongs to the user
    if (mysqli_query($conn, $delete_query)) {
        echo "<div class='alert success'>Booking deleted successfully!</div>";
    } else {
        echo "<div class='alert error'>Error deleting booking: " . mysqli_error($conn) . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?php echo $user['name']; ?></h2>

    <!-- Profile Update Form -->
    <h3>Profile</h3>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>

        <button type="submit" name="update_profile">Update Profile</button>
    </form>

    <!-- Change Password Form -->
    <h3>Change Password</h3>
    <form method="POST">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" required><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" required><br>

        <button type="submit" name="change_password">Change Password</button>
    </form>

    <!-- User Bookings Table -->
    <h3>Your Bookings</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Service</th>
                <th>Booking Date</th>
                <th>Cost</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = mysqli_fetch_assoc($bookings_result)): ?>
            <tr>
                <td><?php echo $booking['id']; ?></td>
                <td><?php echo $booking['service']; ?></td>
                <td><?php echo $booking['booking_date']; ?></td>
                <td><?php echo $booking['cost']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                        <button type="submit" name="delete_booking">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<a href="service.html">
    <button>Go Back to Home</button>

</body>
</html>
