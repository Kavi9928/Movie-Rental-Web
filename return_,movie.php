<?php
// Only process if there's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Ensure the title is set and not empty
    if (isset($data['title']) && !empty($data['title'])) {
        $title = htmlspecialchars($data['title']);

        // Load the movies.xml file
        $xml = simplexml_load_file('movies.xml');
        $movieFound = false;

        // Find the movie and set it as available
        foreach ($xml->movie as $movie) {
            if ((string)$movie->title === $title) {
                $movie->available = 'true';
                $movieFound = true;
                break;
            }
        }

        // Save the updated XML if movie was found
        if ($movieFound) {
            $xml->asXML('movies.xml');
            echo 'Movie returned successfully.';
        } else {
            echo 'Movie not found.';
        }
    } else {
        echo 'Movie title is required.';
    }
} else {
    echo 'Invalid request method.';
}
?>
