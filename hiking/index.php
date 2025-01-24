<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mount Batur Paradise</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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
    </style>
</head>
<body>
    <div style="display: flex; flex-direction: column; min-height: 100vh;">
        <header>
            <nav class="navigation">
                <div class="logo">
                    <img src="assets/logo.png" alt="Mount Batur Logo">
                    <span>Mount Batur Paradise</span>
                </div>
                <ul class="nav-links">
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="pricelist.php">Pricelist</a></li>
                    <li><a href="pesanan.php">Pesanan</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
                <a href="login.php" class="login-button">Login/Daftar</a>
            </nav>
        </header>

        <section class="hero" style="background: url('assets/background.jpg') no-repeat center center; background-size: cover; height: auto; flex-grow: 1;">
            <h1>Let’s Hiking with Us and Enjoy the Sunrise in Mount Batur</h1>
            <p>Book trips and get new experiences</p>
            <a href="pricelist.php" class="btn">Explore Packages</a>
            <br>
            <br>
            <br>
            <a href="lihat_ulasan.php" class="btn">Lihat Ulasan</a>
        </section>

        <footer style="margin-top: auto; padding: 10px; background-color: #333; color: #fff; text-align: center;">
            <p>&copy; 2025 Mount Batur Paradise. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
