<?php
// Add connection to your database here
include('db.php');

// Fetch bookings and users
$bookings_query = "SELECT id, service, name FROM bookings";
$bookings = mysqli_query($conn, $bookings_query);

$users_query = "SELECT id, name, role FROM users";
$users = mysqli_query($conn, $users_query);

// Handle role change
if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];
    
    // Prevent changing admin role
    $role_check_query = "SELECT role FROM users WHERE id = '$user_id'";
    $role_check_result = mysqli_query($conn, $role_check_query);
    $user = mysqli_fetch_assoc($role_check_result);
    
    if ($user['role'] != 'admin') {  // Only allow role change if user is not an admin
        $update_role_query = "UPDATE users SET role = '$new_role' WHERE id = '$user_id'";
        mysqli_query($conn, $update_role_query);
        header('Location: admindash.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        h2 {
            color: #4285F4; /* Google Blue */
        }
        a {
            color: #EA4335; /* Google Red */
            text-decoration: none;
        }
        .button {
            padding: 10px;
            background-color: #34A853; /* Google Green */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #FBBC05; /* Google Yellow */
        }
        ul {
            list-style-type: none;
        }
        li {
            background-color: #f0f0f0;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        select {
            padding: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Dashboard</h2>

    <!-- Manage Bookings -->
    <h3>Manage Bookings:</h3>
    <ul>
        <?php while ($booking = mysqli_fetch_assoc($bookings)) { ?>
            <li><?php echo "Service: " . $booking['service'] . " - User: " . $booking['name']; ?> 
                <a href="delbook.php?id=<?php echo $booking['id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
            </li>
        <?php } ?>
    </ul>

    <!-- Manage Users and Change Role -->
    <h3>Manage Users:</h3>
    <ul>
        <?php while ($user = mysqli_fetch_assoc($users)) { ?>
            <li><?php echo "User: " . $user['name'] . " - Role: " . $user['role']; ?>
                <?php if ($user['role'] != 'admin') { ?>
                    <form action="admindash.php" method="POST" style="display: inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <select name="role">
                            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                            <option value="employee" <?php if ($user['role'] == 'employee') echo 'selected'; ?>>Employee</option>
                        </select>
                        <button type="submit" name="update_role" class="button">Update Role</button>
                    </form>
                    <a href="deluser.php?id=<?php echo $user['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>

    <!-- Add Employee -->
    <?php


// Handle adding a new employee
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_employee'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);

    $query = "INSERT INTO employee (name, email, password, job_type) VALUES ('$name', '$email', '$password', '$job_type')";

    if (mysqli_query($conn, $query)) {
        header('Location: admindash.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Handle updating an employee's job type
if (isset($_POST['update_job'])) {
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);

    $query = "UPDATE employee SET job_type='$job_type' WHERE id='$employee_id'";
    if (mysqli_query($conn, $query)) {
        header('Location: admindash.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Handle deleting an employee
if (isset($_GET['id'])) {
    $employee_id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM employee WHERE id='$employee_id'";
    if (mysqli_query($conn, $query)) {
        header('Location: admindash.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h3 {
            text-align: center;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #5cb85c;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }
        button:hover {
            background: #4cae4c;
        }
        .button {
            display: inline-block;
        }
        .toggle-btn {
            background: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .toggle-btn:hover {
            background: #0056b3;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
        }
        .checkbox-label input {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h3>Add New Employee:</h3>
    <form action="admindash.php" method="POST">
        <input type="text" name="name" placeholder="Employee Name" required>
        <input type="email" name="email" placeholder="Employee Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label for="job_type">Choose Job Type:</label>
        <select id="job_type" name="job_type" required>
            <option value="plumbing">Plumbing</option>
            <option value="electrician">Electrician</option>
            <option value="gardener">Gardener</option>
            <option value="cleaning">Cleaning</option>
            <option value="caretaker">Caretaker</option>
            <option value="chef">Chef</option>
        </select>
        <button type="submit" name="add_employee" class="button">Add Employee</button>
    </form>

    <h3>Manage Employees:</h3>
    <ul>
        <?php
        // Fetch employees from the 'employee' table
        $employees = mysqli_query($conn, "SELECT * FROM employee");
        while ($employee = mysqli_fetch_assoc($employees)) { ?>
            <li><?php echo "Employee: " . $employee['name'] . " - Job: " . $employee['job_type']; ?>
                <form action="admindash.php" method="POST" style="display: inline;">
                    <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
                    <select name="job_type">
                        <option value="plumbing" <?php if ($employee['job_type'] == 'plumbing') echo 'selected'; ?>>Plumbing</option>
                        <option value="electrician" <?php if ($employee['job_type'] == 'electrician') echo 'selected'; ?>>Electrician</option>
                        <option value="gardener" <?php if ($employee['job_type'] == 'gardener') echo 'selected'; ?>>Gardener</option>
                        <option value="cleaning" <?php if ($employee['job_type'] == 'cleaning') echo 'selected'; ?>>Cleaning</option>
                        <option value="caretaker" <?php if ($employee['job_type'] == 'caretaker') echo 'selected'; ?>>Caretaker</option>
                        <option value="chef" <?php if ($employee['job_type'] == 'chef') echo 'selected'; ?>>Chef</option>
                    </select>
                    <button type="submit" name="update_job" class="button">Update Job</button>
                </form>
                <a href="admindash.php?id=<?php echo $employee['id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
            </li>
        <?php }     ?>
    </ul>
    <button onclick="history.back()">Back</button>


</body>
</html>
