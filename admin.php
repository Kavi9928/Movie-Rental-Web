<?php 
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Load movies from XML for display
$xml = simplexml_load_file('movies.xml');
$movies = $xml->movie;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Movies</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
        }

        header {
            background: #2980b9;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            color: #f39c12;
        }

        main {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2980b9;
            color: white;
        }

        td {
            color: #34495e;
        }

        button {
            padding: 8px 12px;
            background: #2980b9;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #1f628d;
        }

        #edit-movie-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #edit-movie-modal input, #edit-movie-modal select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #edit-movie-modal button {
            padding: 12px 20px;
            background: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #edit-movie-modal button:hover {
            background: #1f628d;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel - Manage Movies</h1>
        <nav>
            <a href="admin.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Movie Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Release Year</th>
                    <th>Rating</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="movie-table-body">
                <?php foreach ($movies as $movie): ?>
                    <tr data-title="<?php echo $movie->title; ?>">
                        <td><?php echo htmlspecialchars($movie->title); ?></td>
                        <td><?php echo htmlspecialchars($movie->genre); ?></td>
                        <td><?php echo htmlspecialchars($movie->releaseYear); ?></td>
                        <td><?php echo htmlspecialchars($movie->rating); ?></td>
                        <td><?php echo $movie->available === 'true' ? 'Yes' : 'No'; ?></td>
                        <td>
                            <button class="edit-btn" data-title="<?php echo htmlspecialchars($movie->title); ?>">Edit</button>
                            <button class="delete-btn" data-title="<?php echo htmlspecialchars($movie->title); ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Add New Movie</h3>
        <form id="add-movie-form">
            <input type="text" id="new-title" placeholder="Title" required>
            <input type="text" id="new-genre" placeholder="Genre" required>
            <input type="number" id="new-release-year" placeholder="Release Year" required>
            <input type="text" id="new-rating" placeholder="Rating" required>
            <label for="new-available">Available:</label>
            <select id="new-available">
                <option value="true">Yes</option>
                <option value="false">No</option>
            </select>
            <button type="submit">Add Movie</button>
        </form> <br>

        <h3>Return Movie</h3>
        <form id="return-movie-form">
            <input type="text" id="return-title" placeholder="Enter Movie Title to Return" required>
            <button type="submit">Return Movie</button>
        </form>
    </main>

    <!-- Edit Movie Modal -->
    <div id="edit-movie-modal">
        <h3>Edit Movie</h3>
        <form id="edit-movie-form">
            <input type="hidden" id="edit-title-old" />
            <input type="text" id="edit-title" placeholder="Title" required>
            <input type="text" id="edit-genre" placeholder="Genre" required>
            <input type="number" id="edit-release-year" placeholder="Release Year" required>
            <input type="text" id="edit-rating" placeholder="Rating" required>
            <label for="edit-available">Available:</label>
            <select id="edit-available">
                <option value="true">Yes</option>
                <option value="false">No</option>
            </select>
            <button type="submit">Update Movie</button>
            <button type="button" id="close-edit-modal">Cancel</button>
        </form>
    </div>

    <script>
        // Add new movie
        document.getElementById('add-movie-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const title = document.getElementById('new-title').value;
            const genre = document.getElementById('new-genre').value;
            const releaseYear = document.getElementById('new-release-year').value;
            const rating = document.getElementById('new-rating').value;
            const available = document.getElementById('new-available').value;

            fetch('add_movie.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ title, genre, releaseYear, rating, available })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
        });

        // Open edit modal and pre-fill data
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const title = this.getAttribute('data-title');
                const row = document.querySelector(`tr[data-title="${title}"]`);
                const genre = row.children[1].textContent;
                const releaseYear = row.children[2].textContent;
                const rating = row.children[3].textContent;
                const available = row.children[4].textContent === 'Yes' ? 'true' : 'false';

                document.getElementById('edit-title-old').value = title;
                document.getElementById('edit-title').value = title;
                document.getElementById('edit-genre').value = genre;
                document.getElementById('edit-release-year').value = releaseYear;
                document.getElementById('edit-rating').value = rating;
                document.getElementById('edit-available').value = available;

                document.getElementById('edit-movie-modal').style.display = 'block';
            });
        });

        // Close edit modal
        document.getElementById('close-edit-modal').addEventListener('click', function() {
            document.getElementById('edit-movie-modal').style.display = 'none';
        });

        // Update movie
        document.getElementById('edit-movie-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const oldTitle = document.getElementById('edit-title-old').value;
            const title = document.getElementById('edit-title').value;
            const genre = document.getElementById('edit-genre').value;
            const releaseYear = document.getElementById('edit-release-year').value;
            const rating = document.getElementById('edit-rating').value;
            const available = document.getElementById('edit-available').value;

            fetch('edit_movie.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ oldTitle, title, genre, releaseYear, rating, available })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
        });

        // Delete movie
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const title = this.getAttribute('data-title');
                if (confirm(`Are you sure you want to delete "${title}"?`)) {
                    fetch('delete_movie.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ title })
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    });
                }
            });
        });

        // Return movie
        document.getElementById('return-movie-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const title = document.getElementById('return-title').value;
            fetch('return_movie.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ title })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            });
        });
    </script>
</body>
</html>
