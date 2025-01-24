<?php
session_start();

// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "mb_paradise";

$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID Bukti dari URL
if (isset($_GET['id_bukti'])) {
    $id_bukti = $conn->real_escape_string($_GET['id_bukti']);

    // Query untuk mengambil data detail berdasarkan id_bukti
    $query_detail = "
        SELECT bukti_pembayaran.*, 
               pesanan.id_pesanan, 
               users.username AS nama_pembeli, 
               pesanan.tanggal_pesan, 
               pesanan.tanggal_mendaki 
        FROM bukti_pembayaran 
        JOIN pesanan ON bukti_pembayaran.id_pesanan = pesanan.id_pesanan 
        JOIN users ON pesanan.id_pelanggan = users.id_pelanggan 
        WHERE bukti_pembayaran.id_bukti = '$id_bukti'";
    $result_detail = $conn->query($query_detail);

    if ($result_detail && $result_detail->num_rows > 0) {
        $detail = $result_detail->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    echo "ID Bukti tidak ditemukan!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Bukti Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Detail Bukti Pembayaran</h1>
    <table class="table table-bordered">
        <tr>
            <th>ID Bukti</th>
            <td><?php echo htmlspecialchars($detail['id_bukti']); ?></td>
        </tr>
        <tr>
            <th>Nama Pembeli</th>
            <td><?php echo htmlspecialchars($detail['nama_pembeli']); ?></td>
        </tr>
        <tr>
            <th>ID Pesanan</th>
            <td><?php echo htmlspecialchars($detail['id_pesanan']); ?></td>
        </tr>
        <tr>
            <th>Tanggal Pesan</th>
            <td><?php echo htmlspecialchars($detail['tanggal_pesan']); ?></td>
        </tr>
        <tr>
            <th>Tanggal Mendaki</th>
            <td><?php echo htmlspecialchars($detail['tanggal_mendaki']); ?></td>
        </tr>
        <tr>
            <th>File Bukti</th>
            <td>
                <?php if (!empty($detail['file_bukti'])): ?>
                    <a href="<?php echo htmlspecialchars($detail['file_bukti']); ?>" target="_blank">Lihat Bukti</a>
                <?php else: ?>
                    Tidak ada file
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo htmlspecialchars($detail['status']); ?></td>
        </tr>
        <?php if ($detail['status'] == 'Ditolak'): ?>
        <tr>
            <th>Alasan Penolakan</th>
            <td><?php echo htmlspecialchars($detail['alasan_penolakan']); ?></td>
        </tr>
        <?php endif; ?>
    </table>
    <a href="admin_verifikasi_pembayaran.php" class="btn btn-primary">Kembali</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
