<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan - Mount Batur Paradise</title>
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

        .pesanan-hero {
            padding: 50px 20px;
            text-align: center;
            color: #fff;
            background: url('assets/pesanan.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .pesanan-hero h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .pesanan-info {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex-grow: 1;
        }

        .pesanan-info p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .pesanan-info a {
            display: inline-block;
            padding: 10px 20px;
            background: #1abc9c;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .pesanan-info a:hover {
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
                <li><a href="pricelist.php">Pricelist</a></li>
                <li><a href="pesanan.php" class="active">Pesanan</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
            <a href="login.php" class="login-button">Login/Daftar</a>
        </nav>
    </header>

    <section class="pesanan-hero">
        <h1>Pesanan</h1>
    </section>

    <section class="pesanan-info">
        <br>
        <br>
        <br>
        <br>
        <p>Silakan registrasi atau login terlebih dahulu untuk melanjutkan pemesanan.</p>
        <a href="login.php">Login/Daftar</a>
    </section>

    <footer>
        <p>&copy; 2025 Mount Batur Paradise. All rights reserved.</p>
    </footer>
</body>
</html>
