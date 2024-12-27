<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit;
}

include('db.php');
$employee_id = $_SESSION['employee_id'];

// Fetch current employee data
$query = "SELECT * FROM employees WHERE id = $employee_id";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data and update the employee's profile
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    $id_card_type = mysqli_real_escape_string($conn, $_POST['id_card_type']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);

    // Update query
    $update_query = "UPDATE employees SET 
                        name = '$name',
                        age = '$age',
                        email = '$email',
                        dob = '$dob',
                        profession = '$profession',
                        id_card_type = '$id_card_type',
                        experience = '$experience' 
                    WHERE id = $employee_id";

    if (mysqli_query($conn, $update_query)) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
        }

        h1 {
            color: #4A90E2;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .button {
            width: 100%;
            background-color: #4A90E2;
            color: #fff;
            padding: 15px;
            font-size: 18px;
            border-radius: 5px;
            text-align: center;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #357ABD;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .back-button {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #4A90E2;
            text-decoration: none;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Employee Profile</h1>

        <?php if (isset($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $employee['name']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $employee['age']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $employee['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $employee['dob']; ?>" required>
            </div>

            <div class="form-group">
                <label for="profession">Profession:</label>
                <select id="profession" name="profession" required>
                    <option value="Electrician" <?php echo ($employee['profession'] == 'Electrician') ? 'selected' : ''; ?>>Electrician</option>
                    <option value="Plumber" <?php echo ($employee['profession'] == 'Plumber') ? 'selected' : ''; ?>>Plumber</option>
                    <option value="Gardener" <?php echo ($employee['profession'] == 'Gardener') ? 'selected' : ''; ?>>Gardener</option>
                    <option value="Chef" <?php echo ($employee['profession'] == 'Chef') ? 'selected' : ''; ?>>Chef</option>
                    <option value="Cleaning" <?php echo ($employee['profession'] == 'Cleaning') ? 'selected' : ''; ?>>Cleaning</option>
                    <option value="Caretaker" <?php echo ($employee['profession'] == 'Caretaker') ? 'selected' : ''; ?>>Caretaker</option>
                </select>
            </div>

            <div class="form-group">
                <label for="id_card_type">ID Card Type:</label>
                <select id="id_card_type" name="id_card_type" required>
                    <option value="Aadhar" <?php echo ($employee['id_card_type'] == 'Aadhar') ? 'selected' : ''; ?>>Aadhar</option>
                    <option value="Voter ID" <?php echo ($employee['id_card_type'] == 'Voter ID') ? 'selected' : ''; ?>>Voter ID</option>
                    <option value="License" <?php echo ($employee['id_card_type'] == 'License') ? 'selected' : ''; ?>>License</option>
                </select>
            </div>

            <div class="form-group">
                <label for="experience">Experience:</label>
                <textarea id="experience" name="experience" rows="4" required><?php echo $employee['experience']; ?></textarea>
            </div>

            <button type="submit" class="button">Update Profile</button>
        </form>

        <a href="empdash.php" class="back-button">Back to Dashboard</a>
    </div>

</body>
</html>
