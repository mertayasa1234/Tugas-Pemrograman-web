<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect user to login page if not logged in
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mount Batur Paradise</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            background-color: #f4f4f4;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex-wrap: wrap;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 15px;
            padding: 0;
            margin: 0 auto;
        }

        .nav-links li a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-links li a.active {
            background-color: #f1c40f;
            color: #fff;
        }

        .nav-links li a:hover {
            background-color: #f1c40f;
            color: #fff;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 20px;
        }

        .welcome {
            font-weight: bold;
        }

        .logout {
            background-color: #e74c3c;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        .about-hero {
            padding: 50px 20px;
            text-align: center;
            color: #fff;
            background: url('assets/about.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .about-hero h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .about-section {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: justify;
        }

        .about-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 20px;
            margin-top: auto;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <img src="assets/logo.png" alt="Mount Batur Logo">
        <span>Mount Batur Paradise</span>
    </div>
    <ul class="nav-links">
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="pricelist_login.php">Pricelist</a></li>
        <li><a href="pesanan_login.php">Pesanan</a></li>
        <li><a href="about_login.php" class="active">About</a></li>
    </ul>
    <div class="user-menu">
        <span class="welcome">Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>!</span>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</header>

<section class="about-hero">
    <h1>About Us</h1>
</section>

<section class="about-section">
    <h2>Welcome to Mount Batur Paradise</h2>
    <p>
        Mount Batur Paradise is your ultimate destination for unforgettable hiking adventures. Nestled in the heart of Bali, we offer breathtaking views, serene experiences, and an escape into nature like no other. Our dedicated team ensures that every hike is safe, enjoyable, and tailored to your preferences.
    </p>
    <p>
        Whether you're a solo traveler, part of a group, or looking for a private hiking experience, we have the perfect package for you. Join us as we explore the beauty of Mount Batur and create memories that will last a lifetime.
    </p>
    <p>
        Thank you for choosing Mount Batur Paradise. We look forward to being a part of your adventure.
    </p>
</section>

<footer>
    <p>&copy; 2025 Mount Batur Paradise. All rights reserved.</p>
    <div style="position: fixed; bottom: 20px; right: 20px;">
        <a href="https://wa.me/+6287885616042" target="_blank" style="text-decoration: none; color: white; background-color: #25D366; padding: 10px 20px; border-radius: 5px; font-weight: bold;">More Information</a>
    </div>
</footer>
</body>
</html>
