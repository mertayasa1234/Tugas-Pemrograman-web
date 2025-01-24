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

// Mendapatkan username dari sesi
$username = $_SESSION['username'];

// Mendapatkan ID Pelanggan dari tabel users
$query = "SELECT id_pelanggan FROM users WHERE username = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_pelanggan = $row['id_pelanggan'];
} else {
    echo "<script>alert('User tidak ditemukan!');</script>";
    exit();
}

// Pencarian
$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
}

// Mendapatkan data pesanan dari tabel
$query_pesanan = "
    SELECT pesanan.id_pesanan, 
           pesanan.tanggal_pesan, 
           pesanan.tanggal_mendaki, 
           pesanan.jumlah_orang,
           pesanan.status_pesanan, 
           paket.nama_paket, 
           paket.harga, 
           (pesanan.jumlah_orang * paket.harga) AS total_harga, 
           pesanan.catatan, 
           IF(ulasan.id_ulasan IS NOT NULL, 1, 0) AS ulasan_terisi
    FROM pesanan
    LEFT JOIN paket ON pesanan.id_paket = paket.id_paket
    LEFT JOIN ulasan ON pesanan.id_pesanan = ulasan.id_pesanan
    WHERE pesanan.id_pelanggan = '$id_pelanggan'";


if (!empty($search)) {
    $query_pesanan .= " AND (paket.nama_paket LIKE '%$search%' OR pesanan.catatan LIKE '%$search%')";
}

$result_pesanan = $conn->query($query_pesanan);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - Mount Batur Paradise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
            position: sticky;
            top: 0;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-links a.active,
        .nav-links a:hover {
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f9f9f9;
        }

        .button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .confirm-button {
            background-color: #f39c12;
            color: white;
        }
    </style>
    <script>
        function openPaymentModal(orderId) {
            document.querySelector('#paymentMethodModal').setAttribute('data-order-id', orderId);
            new bootstrap.Modal(document.getElementById('paymentMethodModal')).show();
        }

        function selectPayment(method) {
            const orderId = document.querySelector('#paymentMethodModal').getAttribute('data-order-id');
            if (method === 'gateway') {
                window.location.href = `payment_gateway.php?order_id=${orderId}`;
            } else if (method === 'transfer') {
                window.location.href = `transfer_bank.php?order_id=${orderId}`;
            } else if (method === 'cod') {
                window.location.href = `cod_process.php?order_id=${orderId}`;
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/logo.png" alt="Mount Batur Logo">
            <span>Mount Batur Paradise</span>
        </div>
        <nav class="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="pricelist_login.php">Pricelist</a>
            <a href="pesanan_login.php" class="active">Pesanan</a>
            <a href="about_login.php">About</a>
        </nav>
        <div>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </header>

    <main>
        <h1>Status Pesanan</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Paket</th>
                    <th>Tanggal Pesan</th>
                    <th>Tanggal Mendaki</th>
                    <th>Jumlah Orang</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                    <th>Status Pesanan</th>
                    <th>Detail Bukti Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_pesanan->num_rows > 0): ?>
                    <?php while ($row = $result_pesanan->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id_pesanan']; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_paket']); ?></td>
                            <td><?php echo $row['tanggal_pesan']; ?></td>
                            <td><?php echo $row['tanggal_mendaki']; ?></td>
                            <td><?php echo $row['jumlah_orang']; ?></td>
                            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['catatan']); ?></td>
                            <td>
                                <?php if ($row['status_pesanan'] == 'Menunggu Konfirmasi'): ?>
                                    <button class="button confirm-button" 
                                            onclick="window.location.href='konfirmasi_pesanan.php?id_pesanan=<?php echo $row['id_pesanan']; ?>'">
                                        Konfirmasi
                                    </button>
                                    <button class="button edit-button" 
                                            onclick="window.location.href='edit_pesanan.php?id_pesanan=<?php echo $row['id_pesanan']; ?>'">
                                        Edit
                                    </button>
                                <?php elseif ($row['status_pesanan'] == 'Menunggu Pembayaran'): ?>
                                    <button class="button confirm-button" onclick="openPaymentModal(<?php echo $row['id_pesanan']; ?>)">Menunggu Pembayaran</button>
                                    <?php elseif ($row['status_pesanan'] === 'Dikirim'): ?>
                                    <button class="btn btn-success btn-sm" 
                                            onclick="window.location.href='selesai_pendakian.php?id_pesanan=<?php echo $row['id_pesanan']; ?>'">
                                        Pendakian Telah Selesai</button>
                                <?php else: ?>
                                    <span><?php echo htmlspecialchars($row['status_pesanan']); ?></span>
                                <?php endif; ?>
                            </td>

                            <td><?php echo htmlspecialchars($row['status_pesanan']); ?></td>
                                <td>
                                    <?php if ($row['status_pesanan'] === 'Selesai' && $row['ulasan_terisi'] == 0): ?>
                                        <a href="beri_ulasan.php?id_pesanan=<?php echo $row['id_pesanan']; ?>" class="btn btn-primary btn-sm">
                                            Berikan Ulasan
                                        </a>
                                    <?php elseif ($row['status_pesanan'] === 'Selesai' && $row['ulasan_terisi'] == 1): ?>
                                        <span class="text-success">Anda telah memberikan Ulasan, Terima Kasih</span>
                                    
                                    <?php elseif ($row['status_pesanan'] === 'Dikirim'): ?>
                                        <a href="detail_informasi_pendakian.php?id_pesanan=<?php echo $row['id_pesanan']; ?>" 
                                        class="btn btn-primary btn-sm">Lihat Informasi Pendakian</a>
                                    <?php elseif (in_array($row['status_pesanan'], ['Lunas', 'Ditolak'])): ?>
                                        <a href="verifikasi_detail.php?id_pesanan=<?php echo $row['id_pesanan']; ?>" 
                                        class="btn btn-primary btn-sm">Lihat Informasi</a>
                                    <?php else: ?>
                                        <span>Belum ada informasi</span>
                                    <?php endif; ?>
                                </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10">Tidak ada pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <!-- Modal Pilihan Metode Pembayaran -->
    <div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentMethodLabel">Pilih Metode Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Silakan pilih metode pembayaran:</p>
                    <div class="d-grid gap-3">
                        <button class="btn btn-secondary" onclick="selectPayment('transfer')">Transfer Bank</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
