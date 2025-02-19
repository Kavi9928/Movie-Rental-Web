<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate the data
    if (isset($data['title'], $data['genre'], $data['releaseYear'], $data['rating'])) {
        // Sanitize input data
        $title = htmlspecialchars($data['title']);
        $genre = htmlspecialchars($data['genre']);
        $releaseYear = htmlspecialchars($data['releaseYear']);
        $rating = htmlspecialchars($data['rating']);
        $available = 'true'; // Assuming the movie is available upon addition

        // Load the existing XML file
        $xmlFile = 'movies.xml';
        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);
        } else {
            // If the XML file doesn't exist, create a new one
            $xml = new SimpleXMLElement('<movies></movies>');
        }

        // Create a new movie entry
        $movie = $xml->addChild('movie');
        $movie->addChild('title', $title);
        $movie->addChild('genre', $genre);
        $movie->addChild('releaseYear', $releaseYear);
        $movie->addChild('rating', $rating);
        $movie->addChild('available', $available);

        // Save the updated XML
        if ($xml->asXML($xmlFile)) {
            // Return a success response
            echo json_encode(['success' => true, 'message' => 'Movie added successfully.']);
        } else {
            // Return an error response for file saving issues
            echo json_encode(['success' => false, 'message' => 'Failed to save movie.']);
        }
    } else {
        // Return an error response for invalid movie data
        echo json_encode(['success' => false, 'message' => 'Invalid movie data.']);
    }
} else {
    // Return an error response for unsupported request methods
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
