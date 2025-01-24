<?php
session_start();

$host = "localhost"; // Ganti sesuai konfigurasi Anda
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "mb_paradise"; // Nama database

$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Silakan login terlebih dahulu!');</script>";
    header("Location: login.php");
    exit();
}

// Mendapatkan ID Pesanan dari URL
$id_pesanan = $_GET['id_pesanan'] ?? null;

if (!$id_pesanan) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location.href='pesanan_login.php';</script>";
    exit();
}

// Mendapatkan data pesanan
$query = "SELECT pesanan.*, paket.nama_paket, paket.kuota_min, paket.kuota_max FROM pesanan JOIN paket ON pesanan.id_paket = paket.id_paket WHERE pesanan.id_pesanan = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pesanan);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_assoc();

if (!$pesanan) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location.href='pesanan_login.php';</script>";
    exit();
}

// Memproses form edit pesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_paket = $_POST['id_paket'];
    $jumlah_orang = $_POST['jumlah_orang'];
    $tanggal_mendaki = $_POST['tanggal_mendaki'];
    $catatan = $_POST['catatan'];

    // Validasi jumlah orang sesuai paket
    $query_paket = "SELECT kuota_min, kuota_max FROM paket WHERE id_paket = ?";
    $stmt_paket = $conn->prepare($query_paket);
    $stmt_paket->bind_param("i", $id_paket);
    $stmt_paket->execute();
    $result_paket = $stmt_paket->get_result();
    $paket = $result_paket->fetch_assoc();

    if ($jumlah_orang < $paket['kuota_min'] || $jumlah_orang > $paket['kuota_max']) {
        echo "<script>alert('Jumlah orang harus sesuai dengan kuota paket: minimal " . $paket['kuota_min'] . " dan maksimal " . $paket['kuota_max'] . " orang.');</script>";
    } else {
        $update_query = "UPDATE pesanan SET id_paket = ?, jumlah_orang = ?, tanggal_mendaki = ?, catatan = ? WHERE id_pesanan = ?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("iissi", $id_paket, $jumlah_orang, $tanggal_mendaki, $catatan, $id_pesanan);
        $stmt_update->execute();

        echo "<script>alert('Pesanan berhasil diperbarui!'); window.location.href='pesanan_login.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
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
        main {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        select, input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #27ae60;
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
            <li><a href="pesanan_login.php" class="active">Pesanan</a></li>
            <li><a href="about_login.php">About</a></li>
        </ul>
        <div class="user-menu">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </header>

    <main>
        <h2 style="text-align: center;">Edit Pesanan</h2>
        <form method="POST">
            <label for="id_paket">Nama Paket</label>
            <select id="id_paket" name="id_paket" required>
                <?php
                $query_paket = "SELECT id_paket, nama_paket FROM paket";
                $result_paket = $conn->query($query_paket);
                while ($paket = $result_paket->fetch_assoc()):
                ?>
                    <option value="<?php echo $paket['id_paket']; ?>" <?php echo ($paket['id_paket'] == $pesanan['id_paket']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($paket['nama_paket']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="jumlah_orang">Jumlah Orang</label>
            <input type="number" id="jumlah_orang" name="jumlah_orang" value="<?php echo $pesanan['jumlah_orang']; ?>" required>

            <label for="tanggal_mendaki">Tanggal Mendaki</label>
            <input type="date" id="tanggal_mendaki" name="tanggal_mendaki" value="<?php echo $pesanan['tanggal_mendaki']; ?>" required>

            <label for="catatan">Catatan</label>
            <textarea id="catatan" name="catatan"><?php echo htmlspecialchars($pesanan['catatan']); ?></textarea>

            <button type="submit">Update</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Mount Batur Paradise. All rights reserved.</p>
    </footer>
</body>
</html>
 