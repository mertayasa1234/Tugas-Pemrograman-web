<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID Pesanan dari parameter URL
$id_pesanan = $_GET['id_pesanan'] ?? null;

if ($id_pesanan) {
    // Ambil data informasi pendakian berdasarkan ID Pesanan
    $query_informasi = "SELECT * FROM informasi_pendakian WHERE id_pesanan = '$id_pesanan'";
    $result_informasi = $conn->query($query_informasi);

    if ($result_informasi->num_rows > 0) {
        $informasi = $result_informasi->fetch_assoc();
    } else {
        die("Informasi pendakian tidak ditemukan.");
    }
} else {
    die("ID Pesanan tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Informasi Pendakian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Detail Informasi Pendakian</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID Pesanan</th>
            <td><?php echo $informasi['id_pesanan']; ?></td>
        </tr>
        <tr>
            <th>Waktu Pendakian</th>
            <td><?php echo $informasi['waktu_pendakian']; ?></td>
        </tr>
        <tr>
            <th>Lokasi Kumpul</th>
            <td><?php echo $informasi['lokasi_kumpul']; ?></td>
        </tr>
        <tr>
            <th>Nama Guide</th>
            <td><?php echo $informasi['nama_guide']; ?></td>
        </tr>
        <tr>
            <th>No Telepon Guide</th>
            <td><?php echo $informasi['no_telepon_guide']; ?></td>
        </tr>
        <tr>
            <th>Informasi Tambahan</th>
            <td><?php echo $informasi['informasi_tambahan']; ?></td>
        </tr>
        <tr>
            <th>Tanggal Dibuat</th>
            <td><?php echo $informasi['tanggal_dibuat']; ?></td>
        </tr>
    </table>
    <div class="alert alert-info" role="alert">
        Silakan Hubungi guide melalui <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $informasi['no_telepon_guide']); ?>" target="_blank">Whatsapp</a> di <?php echo $informasi['no_telepon_guide']; ?> untuk informasi tambahan.
    </div>
    <a href="pesanan_login.php" class="btn btn-secondary">Kembali</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
