<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data admin berdasarkan ID
$query = "SELECT NAMA_ADMIN, FOTO_PROFIL, USERNAME, EMAIL FROM Admin WHERE ID_ADMIN = 1"; // Pastikan ID sesuai
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    $nama_admin = isset($admin['NAMA_ADMIN']) ? $admin['NAMA_ADMIN'] : 'Tidak tersedia';
    $foto_profil = isset($admin['FOTO_PROFIL']) ? $admin['FOTO_PROFIL'] : 'assets/admin/poto.jpg';
    $username = isset($admin['USERNAME']) ? $admin['USERNAME'] : 'Tidak tersedia';
    $email = isset($admin['EMAIL']) ? $admin['EMAIL'] : 'Tidak tersedia';
} else {
    $nama_admin = 'Admin';
    $foto_profil = 'assets/profile/default.jpg';
    $username = 'Tidak tersedia';
    $email = 'Tidak tersedia';
}


// Ambil data dari tabel informasi_pendakian
$query_informasi = "SELECT ip.*, p.status_pesanan 
                    FROM informasi_pendakian ip
                    JOIN pesanan p ON ip.id_pesanan = p.id_pesanan";
$result_informasi = $conn->query($query_informasi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Pendakian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
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
     <!-- Modal untuk Informasi Admin -->
<div class="modal fade" id="adminInfoModal" tabindex="-1" aria-labelledby="adminInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminInfoLabel">Informasi Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Foto Profil -->
                <div class="text-center mb-3">
                    <img src="<?php echo $foto_profil; ?>" alt="Foto Profil" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
                </div>
                <!-- Informasi Admin -->
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
        <h2 class="text-center">Informasi Pendakian</h2>
        <div class="mb-3 text-end">
            <a href="admin_input_informasi.php" class="btn btn-primary">Input Informasi</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Informasi</th>
                    <th>ID Pesanan</th>
                    <th>Waktu Pendakian</th>
                    <th>Lokasi Kumpul</th>
                    <th>Nama Guide</th>
                    <th>No Telepon Guide</th>
                    <th>Informasi Tambahan</th>
                    <th>Tanggal Dibuat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_informasi->num_rows > 0): ?>
                    <?php while ($row = $result_informasi->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id_informasi']; ?></td>
                            <td><?php echo $row['id_pesanan']; ?></td>
                            <td><?php echo $row['waktu_pendakian']; ?></td>
                            <td><?php echo $row['lokasi_kumpul']; ?></td>
                            <td><?php echo $row['nama_guide']; ?></td>
                            <td><?php echo $row['no_telepon_guide']; ?></td>
                            <td><?php echo $row['informasi_tambahan']; ?></td>
                            <td><?php echo $row['tanggal_dibuat']; ?></td>
                            <td><?php echo $row['status_pesanan']; ?></td>
                            <td>
                            <td>
                            <?php if ($row['status_pesanan'] === 'Selesai'): ?>
                                <span class="text-success">Sudah Dikirim</span>
                                <?php elseif ($row['status_pesanan'] !== 'Dikirim'): ?>
                                    <a href="admin_kirim_informasi.php?id_pesanan=<?php echo $row['id_pesanan']; ?>" 
                                       class="btn btn-success btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin mengirim informasi ini?')">Kirim Informasi</a>
                                <?php else: ?>
                                    <span class="text-success">Sudah Dikirim</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada informasi pendakian.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
