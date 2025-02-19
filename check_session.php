<?php
session_start();
$response = array();

if (isset($_SESSION['username'])) {
    $response['loggedIn'] = true;
} else {
    $response['loggedIn'] = false;
}

echo json_encode($response);
?>
