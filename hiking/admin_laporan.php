<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan data laporan
$query_pesanan = "SELECT COUNT(*) AS total_pesanan FROM pesanan";
$query_pelanggan = "SELECT COUNT(*) AS total_pelanggan FROM users";

// Query untuk Total Pendapatan
$query_pendapatan = "SELECT SUM(total_harga) AS total_pendapatan FROM pesanan WHERE status_pesanan = 'Selesai'";
$result_pendapatan = $conn->query($query_pendapatan);
$total_pendapatan = $result_pendapatan->fetch_assoc()['total_pendapatan'] ?? 0;

$total_pesanan = $conn->query($query_pesanan)->fetch_assoc()['total_pesanan'];

$total_pelanggan = $conn->query($query_pelanggan)->fetch_assoc()['total_pelanggan'];

// Data bulanan untuk grafik pesanan
$query_grafik = "SELECT MONTH(tanggal_pesan) AS bulan, COUNT(*) AS jumlah_pesanan 
                 FROM pesanan GROUP BY MONTH(tanggal_pesan)";
$result_grafik = $conn->query($query_grafik);
$grafik_bulan = [];
$grafik_pesanan = [];
while ($row = $result_grafik->fetch_assoc()) {
    $grafik_bulan[] = date("F", mktime(0, 0, 0, $row['bulan'], 10)); // Nama bulan
    $grafik_pesanan[] = $row['jumlah_pesanan'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan dan Statistik</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: white;
            margin: 10px 0;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar {
            margin-left: 250px;
            background-color: #f8f9fa;
            height: 60px;
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            border-bottom: 1px solid #dee2e6;
        }
        .navbar .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">Admin Dashboard</h4>
        <ul class="nav flex-column px-3">
            <li class="nav-item">
                <a href="admin_dashboard.php" class="nav-link"><i class="fas fa-home me-2"></i> Beranda</a>
            </li>
            <li class="nav-item">
                <a href="admin_manage_paket.php" class="nav-link" ><i class="fas fa-box me-2"></i> Manajemen Paket</a>
            </li>
            <li class="nav-item">
                <a href="admin_verifikasi_pembayaran.php" class="nav-link"><i class="fas fa-money-check-alt me-2"></i> Verifikasi Pembayaran</a>
            </li>
            <li class="nav-item">
                <a href="admin_manajemen_guide.php" class="nav-link"><i class="fas fa-user-tie me-2"></i> Manajemen Guide</a>
            </li>
            <li class="nav-item">
                <a href="admin_informasi_pendakian.php" class="nav-link"><i class="fas fa-info-circle me-2"></i> Informasi Pendakian</a>
            </li>
            <li class="nav-item">
                <a href="admin_laporan.php" class="nav-link"><i class="fas fa-chart-bar me-2"></i> Laporan & Statistik</a>

            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </li>
        </ul>
    </div>
    <!-- Navbar -->
    <div class="navbar">
        <div class="profile">
            <span>Welcome, Admin!</span>
            <img src="assets/admin/poto.jpg" alt="Admin Profile">
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <h2 class="text-center">Laporan dan Statistik</h2>
        <div class="row">
            <div class="col-md-4 text-center">
                <h4>Total Pesanan</h4>
                <p><?php echo $total_pesanan; ?></p>
            </div>
            <div class="col-md-4 text-center">
                <h4>Total Pendapatan</h4>
                <p>Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></p>
            </div>
            <div class="col-md-4 text-center">
                <h4>Total Pelanggan</h4>
                <p><?php echo $total_pelanggan; ?></p>
            </div>
        </div>

        <canvas id="pesananChart" width="400" height="200" class="mt-5"></canvas>

    </div>

    <script>
        const ctx = document.getElementById('pesananChart').getContext('2d');
        const pesananChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($grafik_bulan); ?>,
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: <?php echo json_encode($grafik_pesanan); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
