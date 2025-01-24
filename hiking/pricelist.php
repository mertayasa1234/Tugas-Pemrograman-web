<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricelist - Mount Batur Paradise</title>
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

        .pricelist-hero {
            padding: 50px 20px;
            text-align: center;
            color: #fff;
            background: url('assets/bc-paket.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .pricelist-hero h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .pricelist-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background-color: transparent;
            flex-grow: 1;
        }

        .pricelist-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            text-align: center;
            transition: transform 0.3s;
        }

        .pricelist-card:hover {
            transform: scale(1.05);
        }

        .pricelist-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .pricelist-card h2 {
            font-size: 1.5em;
            margin: 15px 0;
        }

        .pricelist-card p {
            color: #666;
            font-size: 1em;
            margin: 0 15px 15px;
        }

        .pricelist-card .price {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 15px;
            color: #27ae60;
        }

        .pricelist-card a {
            display: inline-block;
            padding: 10px 20px;
            background: #1abc9c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .pricelist-card a:hover {
            background: #16a085;
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
                <li><a href="pricelist.php" class="active">Pricelist</a></li>
                <li><a href="pesanan.php">Pesanan</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
            <a href="login.php" class="login-button">Login/Daftar</a>
        </nav>
    </header>

    <section class="pricelist-hero">
        <h1>Pricelist</h1>
        <p>Choose the best package for your hiking experience</p>
    </section>

    <section class="pricelist-container">
        <div class="pricelist-card">
            <img src="assets/private.jpg" alt="Private Package">
            <h2>Private Package</h2>
            <p>Experience an exclusive hiking trip with personalized service.</p>
            <p class="price">Rp 500,000 / person</p>
            <a href="pesanan.php">Book Now</a>
        </div>

        <div class="pricelist-card">
            <img src="assets/sharing.jpg" alt="Sharing Package">
            <h2>Sharing Package</h2>
            <p>Join a group and enjoy a fun and social hiking adventure.</p>
            <p class="price">Rp 350,000 / person</p>
            <a href="pesanan.php">Book Now</a>
        </div>

        <div class="pricelist-card">
            <img src="assets/group.jpg" alt="Group Package">
            <h2>Group Package</h2>
            <p>Perfect for families, friends, or corporate outings.</p>
            <p class="price">Rp 300,000 / person</p>
            <a href="pesanan.php">Book Now</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Mount Batur Paradise. All rights reserved.</p>
    </footer>
</body>
</html>
