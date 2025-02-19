<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data
    $input = json_decode(file_get_contents('php://input'), true);
    $oldTitle = htmlspecialchars($input['oldTitle']);
    $newTitle = htmlspecialchars($input['title']);
    $genre = htmlspecialchars($input['genre']);
    $releaseYear = htmlspecialchars($input['releaseYear']);
    $rating = htmlspecialchars($input['rating']);
    $available = htmlspecialchars($input['available']);

    // Load the XML file
    $xml = simplexml_load_file('movies.xml');

    // Find the movie by the old title
    $movieFound = false;
    foreach ($xml->movie as $movie) {
        if ($movie->title == $oldTitle) {
            // Update the movie details
            $movie->title = $newTitle;
            $movie->genre = $genre;
            $movie->releaseYear = $releaseYear;
            $movie->rating = $rating;
            $movie->available = $available;
            $movieFound = true;
            break;
        }
    }

    // Check if the movie was found and updated
    if ($movieFound) {
        // Save the updated XML back to the file
        $xml->asXML('movies.xml');
        echo json_encode(['success' => true, 'message' => 'Movie updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Movie not found!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method!']);
}
?>
