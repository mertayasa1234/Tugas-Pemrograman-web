<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Mount Batur Paradise</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            flex-wrap: wrap;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
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
            margin: 0;
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

        .login-button {
            color: #000;
            border: 2px solid #000;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background-color: #000;
            color: #fff;
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
            flex-grow: 1;
        }

        .about-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: #fff;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navigation">
            <div class="logo">
                <img src="assets/logo.png" alt="Mount Batur Logo">
                <span>Mount Batur Paradise</span>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="pricelist.php">Pricelist</a></li>
                <li><a href="pesanan.php">Pesanan</a></li>
                <li><a href="about.php" class="active">About</a></li>
            </ul>
            <a href="login.php" class="login-button">Login/Daftar</a>
        </nav>
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
    </footer>
</body>
</html>
