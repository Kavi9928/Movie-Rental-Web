<?php 
session_start(); // Start the session to store user data

$message = ''; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the username and password from the form
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Load the XML file
    $xml = simplexml_load_file('users.xml');

    // Initialize a flag to check if user is authenticated
    $authenticated = false;
    $userRole = ''; // Variable to hold user role

    // Loop through each user in the XML
    foreach ($xml->user as $user) {
        // Compare the username and check hashed password
        if ((string)$user->username === $username && password_verify($password, (string)$user->password)) {
            $authenticated = true;
            $userRole = (string)$user->role; // Get the user role
            break; // Exit the loop once we find a match
        }
    }

    // Check if authentication was successful
    if ($authenticated) {
        // Set session variable
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $userRole; // Store user role in session

        // Redirect based on user role
        if ($userRole === 'admin') {
            header('Location: admin.php'); // Redirect to admin panel
        } else {
            header('Location: dashboard.php'); // Redirect to user dashboard
        }
        exit(); // Ensure no further code is executed
    } else {
        // Set error message
        $message = "Invalid username or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Rental - Login Form</title>
    <style>
        body {
            background: linear-gradient(135deg, #2d1c11, #616562);
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            animation: slideIn 1s ease-in-out;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s, background-color 0.3s;
        }

        input:focus {
            border-color: #91493e;
            background-color: #eef2f9;
            outline: none;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .login-btn, .register-btn {
            width: 48%;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            text-decoration: none;
            text-align: center;
        }

        /* Change button background colors */
        .login-btn {
            background-color: #007bff; /* Blue background for Login */
        }

        .login-btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .register-btn {
            background-color: #28a745; /* Green background for Register */
        }

        .register-btn:hover {
            background-color: #218838; /* Darker green on hover */
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message {
            margin-bottom: 20px;
            color: #ff0000; /* Red for error messages */
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login to Movie Rental</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
            <a href="register.php" class="register-btn">Register</a>
        </form>
    </div>
</body>
</html>
