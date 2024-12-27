<?php
include('db.php');

// Handle Add Employee
if (isset($_POST['add_employee'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_BCRYPT); // Hash the password
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $idcardtype = mysqli_real_escape_string($conn, $_POST['idcardtype']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);

    $query = "INSERT INTO employees (name, email, profession, password, age, dob, id_card_type, experience) 
              VALUES ('$name', '$email', '$role', '$password', '$age', '$dob', '$idcardtype', '$experience')";
    if (mysqli_query($conn, $query)) {
        $message = "Employee added successfully!";
    } else {
        $message = "Error adding employee: " . mysqli_error($conn);
    }
}

// Handle Delete Employee
if (isset($_POST['delete_employee'])) {
    $id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $query = "DELETE FROM employees WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        $message = "Employee deleted successfully!";
    } else {
        $message = "Error deleting employee: " . mysqli_error($conn);
    }
}

// Handle Update Employee Role
if (isset($_POST['update_role'])) {
    $id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $role = mysqli_real_escape_string($conn, $_POST['new_role']);
    $query = "UPDATE employees SET profession = '$role' WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        $message = "Employee role updated successfully!";
    } else {
        $message = "Error updating role: " . mysqli_error($conn);
    }
}

// Fetch Employees for Display
$employees = mysqli_query($conn, "SELECT * FROM employees");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 30px;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4A90E2;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #357ABD;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #4A90E2;
            color: #fff;
        }
        .message {
            background-color: #e0ffe0;
            border: 1px solid #aaffaa;
            color: #008800;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Employees</h2>

        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Add Employee Form -->
        <form method="POST">
            <h3>Add Employee</h3>
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label for="role">Role:</label>
                <select name="role" required>
                    <option value="electrician">Electrician</option>
                    <option value="plumber">Plumber</option>
                    <option value="gardener">Gardener</option>
                    <option value="cleaner">Cleaner</option>
                    <option value="chef">Chef</option>
                    <option value="caretaker">Caretaker</option>
                </select>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label for="age">Age:</label>
                <input type="number" name="age" required>
            </div>
            <div>
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" required>
            </div>
            <div>
                <label for="idcardtype">ID Card Type:</label>
                <select name="idcardtype" required>
                    <option value="Aadhar">Aadhar</option>
                    <option value="Voter ID">Voter ID</option>
                    <option value="License">License</option>
                    <option value="Identity Card">Identity Card</option>
                </select>
            </div>
            <div>
                <label for="experience">Experience:</label>
                <input type="text" name="experience" required>
            </div>
            <button type="submit" name="add_employee">Add Employee</button>
        </form>

        <!-- Delete Employee Form -->
        <form method="POST">
            <h3>Delete Employee</h3>
            <div>
                <label for="employee_id">Employee ID:</label>
                <input type="number" name="employee_id" required>
            </div>
            <button type="submit" name="delete_employee">Delete Employee</button>
        </form>

        <!-- Update Employee Role Form -->
        <form method="POST">
            <h3>Update Employee Role</h3>
            <div>
                <label for="employee_id">Employee ID:</label>
                <input type="number" name="employee_id" required>
            </div>
            <div>
                <label for="new_role">New Role:</label>
                <select name="new_role" required>
                    <option value="electrician">Electrician</option>
                    <option value="plumber">Plumber</option>
                    <option value="gardener">Gardener</option>
                    <option value="cleaner">Cleaner</option>
                    <option value="chef">Chef</option>
                    <option value="caretaker">Caretaker</option>
                </select>
            </div>
            <button type="submit" name="update_role">Update Role</button>
        </form>

        <!-- Display Employees -->
        <h3>Employee List</h3>
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
                <?php while ($row = mysqli_fetch_assoc($employees)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['profession']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <a href="adminnew.php">
    <button>Go Back to Dashboard</button>
</a>

</body>
</html>
