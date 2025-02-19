<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xmlData = file_get_contents('php://input');
    file_put_contents('rentals.xml', $xmlData);
    echo 'Rental record updated successfully.';
} else {
    echo 'Invalid request method.';
}
?>
