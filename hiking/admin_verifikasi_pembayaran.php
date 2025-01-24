<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "mb_paradise";

$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
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

// Query untuk mendapatkan data bukti pembayaran dengan nama pembeli
$query_bukti = "
    SELECT bukti_pembayaran.*, pesanan.id_pelanggan, users.username AS nama_pembeli 
    FROM bukti_pembayaran 
    JOIN pesanan ON bukti_pembayaran.id_pesanan = pesanan.id_pesanan 
    JOIN users ON pesanan.id_pelanggan = users.id_pelanggan 
    ORDER BY bukti_pembayaran.tanggal_upload DESC";
$result_bukti = $conn->query($query_bukti);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - Admin</title>
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


<!-- content -->
    <div class="container mt-5">
        <h1>Verifikasi Pembayaran</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Bukti</th>
                    <th>ID Pesanan</th>
                    <th>Nama Pembeli</th>
                    <th>File Bukti</th>
                    <th>Tanggal Upload</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    <th>detail Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_bukti && $result_bukti->num_rows > 0): ?>
                    <?php while ($row = $result_bukti->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_bukti']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_pesanan']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_pembeli']); ?></td>
                            <td>
                                <?php if (!empty($row['file_bukti'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['file_bukti']); ?>" target="_blank">Lihat Bukti</a>
                                <?php else: ?>
                                    Tidak Ada
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['tanggal_upload']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'Menunggu Verifikasi'): ?>
                                    <a href="admin_verifikasi_proses.php?id_bukti=<?php echo $row['id_bukti']; ?>&status=Diterima" class="btn btn-success btn-sm">Terima</a>
                                    <button 
                                        class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalTolak" 
                                        data-id="<?php echo $row['id_bukti']; ?>">Tolak</button>
                                <?php else: ?>
                                    <span class="text-success">Terverifikasi</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="admin_verifikasi_detail.php?id_bukti=<?php echo $row['id_bukti'];?> ">Lihat detail</a>
                                </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Tidak ada data bukti pembayaran.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal untuk Input Alasan Penolakan -->
    <div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form action="admin_verifikasi_proses.php" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTolakLabel">Alasan Penolakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_bukti" id="modalTolakId">
                        <div class="form-group">
                            <label for="alasan">Masukkan Alasan Penolakan:</label>
                            <textarea class="form-control" name="alasan_penolakan" id="alasan" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </div>
            </form>

        </div>
    </div> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Untuk menambahkan ID ke dalam modal saat tombol "Tolak" diklik
        const modalTolak = document.getElementById('modalTolak');
        modalTolak.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const idBukti = button.getAttribute('data-id');
            const modalInput = modalTolak.querySelector('#modalTolakId');
            modalInput.value = idBukti;
        });
    </script>
</body>
</html>
