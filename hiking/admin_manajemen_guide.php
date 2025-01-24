<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data admin berdasarkan ID
$query = "SELECT NAMA_ADMIN, FOTO_PROFIL, USERNAME, EMAIL FROM Admin WHERE ID_ADMIN = 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    $nama_admin = $admin['NAMA_ADMIN'] ?? 'Tidak tersedia';
    $foto_profil = $admin['FOTO_PROFIL'] ?? 'assets/admin/poto.jpg';
    $username = $admin['USERNAME'] ?? 'Tidak tersedia';
    $email = $admin['EMAIL'] ?? 'Tidak tersedia';
} else {
    $nama_admin = 'Admin';
    $foto_profil = 'assets/profile/default.jpg';
    $username = 'Tidak tersedia';
    $email = 'Tidak tersedia';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Guide - Admin</title>
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
        .menu-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s ease;
            background-color: #ffffff;
        }
        .menu-card:hover {
            transform: scale(1.05);
        }
        .menu-card i {
            font-size: 40px;
            color: #0d6efd;
        }
        .menu-card .btn {
            background-color: #0d6efd;
            color: #fff;
            border: none;
        }
        .menu-card .btn:hover {
            background-color: #0b5ed7;
        }
        .section-title {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <!-- Modal untuk Informasi Admin -->
    <div class="modal fade" id="adminInfoModal" tabindex="-1" aria-labelledby="adminInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminInfoLabel">Informasi Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img src="<?php echo $foto_profil; ?>" alt="Foto Profil" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Nama:</strong> <?php echo $nama_admin; ?></li>
                        <li class="list-group-item"><strong>Username:</strong> <?php echo $username; ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo $email; ?></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <a href="edit_admin.php" class="btn btn-primary">Edit Profil</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

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
        <div class="profile" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#adminInfoModal">
            <span><?php echo $nama_admin; ?></span>
            <img src="<?php echo $foto_profil; ?>" alt="Foto Profil">
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <h1 class="section-title">Manajemen Guide</h1>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="menu-card p-4 text-center">
                    <i class="fas fa-calendar-plus"></i>
                    <h5 class="mt-3">Tambah Jadwal Guide</h5>
                    <a href="add_jadwal_guide.php" class="btn mt-2">Lihat Detail</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="menu-card p-4 text-center">
                    <i class="fas fa-calendar-alt"></i>
                    <h5 class="mt-3">Jadwal Guide</h5>
                    <a href="admin_view_jadwal_guide.php" class="btn mt-2">Lihat Detail</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="menu-card p-4 text-center">
                    <i class="fas fa-user-plus"></i>
                    <h5 class="mt-3">Tambah Guide</h5>
                    <a href="admin_add_guide.php" class="btn mt-2">Lihat Detail</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="menu-card p-4 text-center">
                    <i class="fas fa-users"></i> 
                    <h5 class="mt-3">Daftar Guide</h5>
                    <a href="admin_view_guide.php" class="btn mt-2">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
