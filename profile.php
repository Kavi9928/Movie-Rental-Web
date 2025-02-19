<?php
session_start(); // Start the session to access user data

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Load the existing XML file
$file_path = 'users.xml';
$xml = simplexml_load_file($file_path);

// Find the logged-in user
$current_user = null;
foreach ($xml->user as $user) {
    if ((string)$user->username === $_SESSION['username']) {
        $current_user = $user;
        break;
    }
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $new_password = $_POST['new_password'];
    $new_confirm_password = $_POST['new_confirm_password'];

    // Basic validation
    if (empty($new_username) || empty($new_email)) {
        $message = "All fields are required.";
    } elseif ($new_password !== $new_confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Update user details
        $current_user->username = htmlspecialchars($new_username);
        $current_user->email = htmlspecialchars($new_email);

        // Update password if provided
        if (!empty($new_password)) {
            $current_user->password = password_hash($new_password, PASSWORD_DEFAULT);
        }

        // Save the updated XML file
        $xml->asXML($file_path);
        $message = "Profile updated successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Movie Rental</title>
    <style>
        body {
            background: linear-gradient(135deg, #ece9e6, #ffffff);
            font-family: 'Roboto', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
        }
        .form-container {
            background-color: #f4f4f9;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #333;
            font-size: 26px;
            margin-bottom: 25px;
            font-weight: 500;
        }
        .input-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
            text-align: left;
        }
        input {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s, background-color 0.3s;
        }
        input:focus {
            border-color: #3f72af;
            background-color: #e9f1fa;
            outline: none;
        }
        .update-btn {
            width: 100%;
            background: linear-gradient(135deg, #3f72af, #db7093);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
        }
        .update-btn:hover {
            background: linear-gradient(135deg, #355070, #b56576);
            transform: translateY(-2px);
        }
        .message {
            margin-bottom: 20px;
            color: #ff4d4d; /* Red for error messages */
            font-size: 16px;
        }
        a {
            text-decoration: none;
            color: #3f72af;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #db7093;
        }
    </style>
</head>
<body>
    <div class="form-wrapper">
        <div class="form-container">
            <h2>User Profile</h2>
            <?php if (isset($message)): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
            <form action="profile.php" method="POST">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo (string)$current_user->username; ?>" required>
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo (string)$current_user->email; ?>" required>
                </div>
                <div class="input-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password">
                </div>
                <div class="input-group">
                    <label for="new_confirm_password">Confirm New Password:</label>
                    <input type="password" id="new_confirm_password" name="new_confirm_password">
                </div>
                <button type="submit" class="update-btn">Update Profile</button>
            </form>
         
        </div>
    </div>
</body>
</html>
