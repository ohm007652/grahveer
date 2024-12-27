<?php
$email = $_GET['email'];

// Simulating the email sending process.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            text-align: center;
        }
        h1 {
            font-size: 28px;
            color: #4A90E2;
            animation: fadeIn 1.5s ease-in-out;
        }
        .button {
            display: inline-block;
            background-color: #4A90E2;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            margin: 20px 10px;
            border-radius: 5px;
            font-size: 18px;
            transition: transform 0.3s ease, background-color 0.3s ease;
            text-align: center;
        }
        .button:hover {
            background-color: #357ABD;
            transform: scale(1.1);
        }
        a {
            color: #fff;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <h1>Confirmation mail sent to <?php echo $email; ?>!</h1>
    <a href="empdash.php" class="button">Back to Dashboard</a>
</body>
</html>
