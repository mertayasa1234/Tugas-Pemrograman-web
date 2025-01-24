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

        .hero {
            text-align: center;
            padding: 50px 20px;
            background: url('assets/background.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            flex: 1;
        }

        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .hero .btn {
            background-color: #fff;
            color: #1abc9c;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .hero .btn:hover {
            background-color: #16a085;
            color: #fff;
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
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="pricelist_login.php">Pricelist</a></li>
            <li><a href="pesanan_login.php">Pesanan</a></li>
            <li><a href="about_login.php">About</a></li>
        </ul>
        <div class="user-menu">
            <span class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </header>

    <section class="hero">
        <br>
        <br>
        <br>
        <h1>Let’s Hiking with Us and Enjoy the Sunrise in Mount Batur</h1>
        <p>Book trips and get new experiences</p>
        <br>
        <br>
        <a href="pricelist_login.php" class="btn">Explore Packages</a>
        <br>
        <br>
        <br>
        <a href="lihat_ulasan.php" class="btn">Lihat Ulasan</a>
    </section>

    <footer>
        <p>&copy; 2025 Mount Batur Paradise. All rights reserved.</p>
    </footer>
</body>
</html>
