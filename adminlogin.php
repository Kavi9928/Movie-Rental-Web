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
    <title>Movie Rental - Admin Login Form</title>
    <style>
        /* Apply full-page background with gradient colors */
        body {
            background: linear-gradient(135deg, #2d1c11, #616562); /* Gradient background */
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container for the form */
        .form-container {
            background-color: #fff; /* White background for contrast */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1); /* Soft shadow for a 3D effect */
            width: 400px;
            text-align: center;
            animation: slideIn 1s ease-in-out; /* Subtle slide-in animation */
        }

        /* Heading style */
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        /* Style for each input field */
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

        /* Focused input field appearance */
        input:focus {
            border-color: #91493e;
            background-color: #eef2f9;
            outline: none;
        }

        /* Button style */
        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, #5c2316, #43220d); /* Button gradient */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        /* Hover effect for button */
        .login-btn:hover {
            background: linear-gradient(135deg, #5c0dbd, #e54a1f); /* Darker gradient on hover */
            transform: translateY(-2px); /* Slight lift effect on hover */
        }

        /* Form container animation */
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

        /* Extra option link style */
        .extra-option {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .extra-option a {
            color: #6a11cb;
            text-decoration: none;
        }

        .extra-option a:hover {
            text-decoration: underline;
        }

        /* Message style */
        .message {
            margin-bottom: 20px;
            color: #ff0000; /* Red for error messages */
            font-size: 16px;
        }

        .message.success {
            color: #008000; /* Green for success messages */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login to Movie Rental Admin panel</h2>
        <?php if ($message): ?>
            <div class="message <?php echo $authenticated ? 'success' : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="adminlogin.php" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        
    </div>
</body>
</html>
