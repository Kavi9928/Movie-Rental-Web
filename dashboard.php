<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Hub</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f0f0f0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Header Styles */
        header {
            background-color: #333;
            padding: 15px 50px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .nav-links {
            list-style-type: none;
            display: flex;
            gap: 20px;
        }

        .nav-links li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        .nav-links li a:hover {
            color: #00aaff;
        }

        .search-signin {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-bar {
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            width: 220px;
            background-color: #eee;
            color: #333;
        }

        .search-bar::placeholder {
            color: #888;
        }

        .btn-signin {
            background-color: #00aaff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-signin:hover {
            background-color: #0088cc;
        }

        /* New Section: TV Concierge */
        .tv-concierge {
            margin-top: 100px; /* Adjust for fixed header */
            padding: 40px;
            background: linear-gradient(45deg, #0088cc, #66ffaa);
            color: #fff;
            text-align: center;
            border-radius: 20px;
            max-width: 900px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .tv-concierge h2 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .tv-concierge p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .tv-concierge .btn {
            background-color: #ffaa00;
            color: #fff;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .tv-concierge .btn:hover {
            background-color: #e69500;
        }

        

        /* Container for the content */
        .content-wrapper {
            background: linear-gradient(45deg, #ffaa66, #00aaff, #66ffcc);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            max-width: 900px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            margin-top: 40px;
            margin-bottom: 60px; /* Added space here */
        }

        h1 {
            font-size: 32px;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #ff8800, #00aaff);
            -webkit-background-clip: text;
            color: transparent;
        }

        p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* Button styles */
        .btn {
            background-color: #0088cc;
            color: #fff;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #00aaff;
        }

        /* Movie Cards Section */
        .movie-cards {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .movie-card {
            width: 150px;
            background: #fff;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .movie-card:hover {
            transform: scale(1.05);
        }

        .movie-card img {
            width: 100%;
            border-radius: 10px;
        }

        .movie-card h3 {
            color: #333;
            margin-top: 10px;
            font-size: 16px;
        }

        /* Footer Styles */
        footer.site-footer {
            background-color: #222;
            color: white;
            padding: 40px 0;
            text-align: center;
            width: 100%;
            position: relative;
            bottom: 0;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
            padding: 20px;
        }

        .footer-logo img {
            width: 80px;
            margin-bottom: 20px;
        }

        .footer-columns {
            display: flex;
            justify-content: space-around;
            width: 100%;
            flex-wrap: wrap;
        }

        .footer-column {
            flex: 1;
            margin: 20px;
        }

        .footer-column h4 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #ffaa00;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-column ul li a:hover {
            color: #ffaa00;
        }

        /* Social Icons */
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icons li {
            display: inline-block;
        }

        .social-icons li a {
            color: white;
            font-size: 20px;
        }

        .footer-bottom {
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #444;
        }

        .footer-bottom p {
            color: white;
            font-size: 14px;
        }

        .footer-bottom a {
            color: #ffaa00;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            text-decoration: underline;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .footer-columns {
                flex-direction: column;
            }

            .footer-column {
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>

    <!-- Header Navigation -->
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="browse.html">Browse Movies</a></li>
                <li><a href="rental-history.html">View Rental History</a></li>
                <li><a href="profile.php">My Profile</a></li>
            </ul>
        </nav>
        <div class="search-signin">
            <input type="text" placeholder="Search Movies" class="search-bar">
            <a href="logout.php" class="btn-signin">Sign Out</a>
        </div>
    </header>

    <!-- TV Concierge Section -->
    <div class="tv-concierge">
        <h2>Meet your Movie Guide.</h2>
        <p>Not sure what to watch next? We've got you covered! Dive into a world of free movies and TV shows from our vast collection, curated just for you.</p>
        <a href="trending.html" class="btn">Get started</a>
    </div>

    <!-- Main Content Section -->
    <div class="content-wrapper">
        <h1>Welcome to Movie Hub</h1>
        <p>Your one-stop destination for all the latest and greatest movies.</p>
        <a href="trending.html" class="btn">Explore Now</a>

        <!-- Movie Cards -->
        <div class="movie-cards">
            <div class="movie-card">
                <img src="m1.jpeg" alt="Movie 1">
                <h3>DADA</h3>
            </div>
            <div class="movie-card">
                <img src="m22.jpeg" alt="Movie 2">
                <h3>Good Night</h3>
            </div>
            <div class="movie-card">
                <img src="m3.jpeg" alt="Movie 3">
                <h3>Oh My Kadavule</h3>
            </div>
            <div class="movie-card">
                <img src="m6.jpg" alt="Movie 2">
                <h3>TYG2</h3>
            </div>
            <div class="movie-card">
                <img src="m5.jpg" alt="Movie 2">
                <h3>MUMMY</h3>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="site-footer">
        <div class="footer-container">
            
            <div class="footer-columns">
                <div class="footer-column">
                    <h4>About Movie Hub</h4>
                    <ul>
                        <li><a href="#">Company Info</a></li>
                        <li><a href="#">Our Team</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Help & Support</h4>
                    <ul>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Live Chat</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="social-icons">
            <ul>
                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Movie Hub. All rights reserved. <a href="#">Terms of Service</a> | <a href="#">Privacy Policy</a></p>
        </div>
    </footer>

</body>

</html>
