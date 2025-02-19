<?php
session_start(); // Start the session to store user data

$message = ''; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Set default role to "user"
    $role = 'user'; // Automatically assign the role "user"

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Load the existing XML file or create a new one
        $file_path = 'users.xml';
        if (file_exists($file_path)) {
            libxml_use_internal_errors(true); // Suppress errors and allow us to handle them
            $xml = simplexml_load_file($file_path);
            if ($xml === false) {
                // Handle XML errors
                $message = "Failed to load XML file: ";
                foreach (libxml_get_errors() as $error) {
                    $message .= $error->message;
                }
                libxml_clear_errors();
            }
        } else {
            $xml = new SimpleXMLElement('<users></users>');
        }

        // Check for existing username
        foreach ($xml->user as $user) {
            if ((string)$user->username === $username) {
                $message = "Username already exists.";
                break;
            }
        }

        // If username is unique, create a new user entry
        if (empty($message)) {
            // Hash the password before saving (for security)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Create a new user entry
            $new_user = $xml->addChild('user');
            $new_user->addChild('username', htmlspecialchars($username));
            $new_user->addChild('password', htmlspecialchars($hashed_password)); // Store the hashed password
            $new_user->addChild('email', htmlspecialchars($email)); // Optionally store email
            $new_user->addChild('role', htmlspecialchars($role)); // Store the user role ("user")
            $rentals = $new_user->addChild('rentals');

            // Save the XML file
            if ($xml->asXML($file_path) !== false) {
                $message = "Registration successful! You can now <a href='login.php'>login</a>.";
            } else {
                $message = "Failed to save XML file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Rental - Registration Form</title>
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
        .btn-container {
    display: flex;
    justify-content: center;
    gap: 20px; /* Adds space between the buttons */
}

.register-btn, .login-btn {
    width: 150px; /* Adjust the width if needed */
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s;
}

.register-btn {
    background: linear-gradient(135deg, #006f02, #21bf12); /* Green gradient */
}

.register-btn:hover {
    background: linear-gradient(135deg, #004d01, #1a7f0e);
    transform: translateY(-2px);
}

.login-btn {
    background: linear-gradient(135deg, #006f62, #0e3f50); /* Teal gradient */
}

.login-btn:hover {
    background: linear-gradient(135deg, #0dbd5c, #1fe54a);
    transform: translateY(-2px);
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

        .message.success {
            color: #008000; /* Green for success messages */
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }

        .btn-container a {
            width: 48%; /* Ensure both buttons take up the same width */
        }

        .btn-container button {
            width: 100%; /* Ensure buttons take up full width within their container */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register for Movie Rental</h2>
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'successful') !== false ? 'success' : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <div class="btn-container">
                <button type="submit" class="register-btn">Register</button> 
            </div>
        </form>
    </div>
</body>
</html>
