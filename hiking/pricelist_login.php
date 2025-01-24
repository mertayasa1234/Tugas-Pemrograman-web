<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect user to login page if not logged in
    header("Location: login.php");
    exit();
}

$host = "localhost"; // Ganti sesuai konfigurasi Anda
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "mb_paradise"; // Nama database

$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricelist - Mount Batur Paradise</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('assets/background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: rgba(255, 255, 255, 0.9);
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

        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-box {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            font-size: 14px;
        }

        .search-button {
            background-color: #f1c40f;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #d4a307;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
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

        main {
            flex: 1;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            margin: 20px;
        }

        .pricelist-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .pricelist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .pricelist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        justify-content: center; /* Item akan diratakan di tengah */
        }


        .package {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
        }

        .package img {
        object-fit: cover;
        height: 200px;
        width: 100%;
        }


        .package-content {
            padding: 20px;
        }

        .package-content h3 {
            margin-bottom: 10px;
            font-size: 1.5em;
        }

        .package-content p {
            margin-bottom: 10px;
            color: #666;
        }

        .package-content .price {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .package-content .btn {
            background-color: #1abc9c;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .package-content .btn:hover {
            background-color: #16a085;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .highlight {
            background-color: yellow;
            font-weight: bold;
        }

        #booking-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .popup-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .popup-header h2 {
            margin: 0;
        }

        .popup-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .popup-content input,
        .popup-content textarea,
        .popup-content button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .popup-content button {
            background-color: #1abc9c;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .popup-content button:hover {
            background-color: #16a085;
        }

        .selected-package {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .pricelist-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* Maksimal 5 kolom per baris */
    gap: 20px; /* Jarak antar item */
    justify-content: center; /* Pusatkan item jika kurang dari 5 */
}

@media (max-width: 1200px) {
    .pricelist-grid {
        grid-template-columns: repeat(4, 1fr); /* Maksimal 4 kolom untuk layar lebih kecil */
    }
}

@media (max-width: 992px) {
    .pricelist-grid {
        grid-template-columns: repeat(3, 1fr); /* Maksimal 3 kolom untuk tablet */
    }
}

@media (max-width: 768px) {
    .pricelist-grid {
        grid-template-columns: repeat(2, 1fr); /* Maksimal 2 kolom untuk perangkat kecil */
    }
}

@media (max-width: 576px) {
    .pricelist-grid {
        grid-template-columns: 1fr; /* Satu kolom untuk layar sangat kecil */
    }
}

    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchBox = document.querySelector('.search-box');
            const searchButton = document.querySelector('.search-button');

            searchButton.addEventListener('click', function () {
                highlightSearch();
            });

            searchBox.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    highlightSearch();
                }
            });

            function highlightSearch() {
                const query = searchBox.value.toLowerCase();
                const packages = document.querySelectorAll('.package-content');

                if (!query) {
                    alert('Please enter a search term');
                    return;
                }

                packages.forEach(package => {
                    const content = package.textContent.toLowerCase();
                    if (content.includes(query)) {
                        package.style.border = '2px solid yellow';
                        package.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        package.style.border = 'none';
                    }
                });
            }

            // Popup Logic
            const popup = document.getElementById('booking-popup');
            const bookButtons = document.querySelectorAll('.btn');
            const personCountInput = document.getElementById('person-count');

            bookButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const paketId = this.getAttribute('data-paket-id');
                    const paketName = this.getAttribute('data-paket-name');
                    const minPersons = this.getAttribute('data-min-persons');
                    const maxPersons = this.getAttribute('data-max-persons');

                    // Update hidden inputs and package details
                    document.getElementById('paket-id').value = paketId;
                    document.getElementById('paket-name').innerText = paketName;

                    // Set min and max for person count
                    personCountInput.setAttribute('min', minPersons);
                    personCountInput.setAttribute('max', maxPersons);

                    popup.style.display = 'flex';
                });
            });

            popup.addEventListener('click', function (event) {
                if (event.target === popup) {
                    popup.style.display = 'none';
                }
            });
        });
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/logo.png" alt="Mount Batur Logo">
            <span>Mount Batur Paradise</span>
        </div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="pricelist.php" class="active">Pricelist</a></li>
            <li><a href="pesanan_login.php">Pesanan</a></li>
            <li><a href="about_login.php">About</a></li>
        </ul>
        <div class="search-container">
            <input type="text" name="query" placeholder="Search..." class="search-box">
            <button type="button" class="search-button">Search</button>
            <div class="user-menu">
                <span class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </div>
    </header>

    <main>
        <div class="pricelist-header">
            <h1>Pricelist</h1>
            <p>Choose the best package for your hiking experience</p>
        </div>
        <div class="pricelist-grid">
            <?php
            $sql = "SELECT * FROM paket";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="package">';
                    echo '<img src="' . htmlspecialchars($row['gambar']) . '" alt="' . htmlspecialchars($row['nama_paket']) . '">';
                    echo '<div class="package-content">';
                    echo '<h3>' . htmlspecialchars($row['nama_paket']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['durasi']) . ' Jam</p>';
                    echo '<p>' . htmlspecialchars($row['deskripsi']) . '</p>';
                    echo '<p class="price">Rp ' . number_format($row['harga'], 0, ',', '.') . ' / person</p>';
                    echo '<a href="#" class="btn" data-paket-id="' . $row['id_paket'] . '" data-paket-name="' . htmlspecialchars($row['nama_paket']) . '" data-min-persons="' . $row['kuota_min'] . '" data-max-persons="' . $row['kuota_max'] . '">Book Now</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No packages available at the moment.</p>';
            }

            $conn->close();
            ?>
        </div>
    </main>

    <div id="booking-popup" style="display: none; align-items: center; justify-content: center;">
        <div class="popup-content">
            <div class="popup-header">
                <h2 style="margin: 0;">Booking Form</h2>
            </div>
            <p class="selected-package">Selected Package: <span id="paket-name"></span></p>
            <form id="booking-form" action="process_booking.php" method="POST">
                <input type="hidden" name="paket_id" id="paket-id">
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label for="person_count">Total Persons</label>
                    <input type="number" name="person_count" id="person-count" min="1" max="50" required>
                </div>
                <div>
                    <label for="date">Preferred Date</label>
                    <input type="date" name="date" id="date" required>
                </div>
                <div>
                    <label for="notes">Additional Notes</label>
                    <textarea name="notes" id="notes"></textarea>
                </div>
                <button type="submit">Submit Booking</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Mount Batur Paradise. All rights reserved.</p>
    </footer>
</body>
</html>
