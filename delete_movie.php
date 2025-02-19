<?php
header('Content-Type: application/json');

$filename = 'movies.xml';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $titleToDelete = $data['title'];

    if (!$titleToDelete) {
        echo json_encode(['No title provided']);
        exit;
    }

    // Load the XML file
    $xml = simplexml_load_file($filename);

    // Find and remove the movie
    $movieFound = false;
    foreach ($xml->movie as $movie) {
        if ((string)$movie->title === $titleToDelete) {
            $dom = dom_import_simplexml($movie);
            $dom->parentNode->removeChild($dom);
            $movieFound = true;
            break;
        }
    }

    // Save changes back to XML
    if ($movieFound) {
        $xml->asXML($filename);
        echo json_encode(['Movie deleted successfully']);
    } else {
        echo json_encode(['Movie not found']);
    }
} else {
    echo json_encode([ 'Invalid request method']);
}
