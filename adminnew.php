<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        /* Background Image */
        .background {
            background-image: url(''); /* Replace with your home service-related image URL */
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: absolute;
            width: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }

        h1 {
            font-size: 36px;
            color: #fff;
            text-align: center;
            margin-top: 40px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 40px;
            z-index: 1;
        }

        .card {
            width: 300px;
            padding: 25px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            border-radius: 10px;
            margin: 20px;
            text-align: center;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card h3 {
            margin-bottom: 20px;
            font-size: 22px;
            color: #333;
        }

        .card a {
            text-decoration: none;
            color: #fff;
            background-color: #4285F4;
            padding: 15px 20px;
            border-radius: 5px;
            font-size: 18px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .card a:hover {
            background-color: #34A853;
        }

        .card i {
            font-size: 40px;
            margin-bottom: 15px;
            color: #4285F4;
        }

        button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357ABD;
        }
        
    </style>
</head>
<body>

    <div class="background"></div>
    <h1>Admin Dashboard</h1>

    <div class="container">
        <div class="card">
            <i class="fas fa-calendar-check"></i>
            <h3>Bookings</h3>
            <a href="delbook.php">Manage Bookings</a>
        </div>
        <div class="card">
            <i class="fas fa-users"></i>
            <h3>User Management</h3>
            <a href="delbook.php">Delete Users</a>
        </div>
        <div class="card">
            <i class="fas fa-user-cog"></i>
            <h3>Employee Management</h3>
            <a href="manageemp.php">Manage Employees</a>
        </div>
    </div>

    <a href="login.html">
        <button>Back</button>
    </a>

</body>
</html>
