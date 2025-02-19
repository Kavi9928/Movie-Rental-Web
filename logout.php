<?php
session_start(); // Start the session

// Destroy the session to log out the user
session_destroy();

// Redirect to the index page
header('Location: index.html'); // Change 'index.php' to your desired home page file
exit();
?>
