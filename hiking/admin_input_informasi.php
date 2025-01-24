<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data pesanan dengan jadwal guide dan no_telepon_guide
$query_pesanan = "SELECT p.id_pesanan, jg.waktu_mulai, jg.lokasi_kumpul, g.nama_guide, g.no_hp AS no_telepon_guide, p.tanggal_mendaki
                   FROM pesanan p
                   JOIN jadwal_guide jg ON p.id_pesanan = jg.id_pesanan
                   JOIN guide g ON jg.id_guide = g.id_guide
                   WHERE p.id_pesanan NOT IN (SELECT id_pesanan FROM informasi_pendakian)";
$result_pesanan = $conn->query($query_pesanan);

// Proses form input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pesanan = $_POST['id_pesanan'];
    $informasi_tambahan = $_POST['informasi_tambahan'];
    $tanggal_dibuat = date('Y-m-d H:i:s');

    // Ambil data waktu pendakian, lokasi kumpul, nama guide, dan nomor telepon guide dari jadwal_guide
    $query_jadwal = "SELECT jg.waktu_mulai, jg.lokasi_kumpul, g.nama_guide, g.no_hp AS no_telepon_guide
                     FROM jadwal_guide jg
                     JOIN guide g ON jg.id_guide = g.id_guide
                     WHERE jg.id_pesanan = '$id_pesanan'";
    $result_jadwal = $conn->query($query_jadwal);
    $jadwal = $result_jadwal->fetch_assoc();

    if ($jadwal) {
        $waktu_pendakian = $jadwal['waktu_mulai'];
        $lokasi_kumpul = $jadwal['lokasi_kumpul'];
        $nama_guide = $jadwal['nama_guide'];
        $no_telepon_guide = $jadwal['no_telepon_guide'];

        // Insert data ke tabel informasi_pendakian
        $query_insert = "INSERT INTO informasi_pendakian (id_pesanan, waktu_pendakian, lokasi_kumpul, nama_guide, no_telepon_guide, informasi_tambahan, tanggal_dibuat)
                         VALUES ('$id_pesanan', '$waktu_pendakian', '$lokasi_kumpul', '$nama_guide', '$no_telepon_guide', '$informasi_tambahan', '$tanggal_dibuat')";
        if ($conn->query($query_insert) === TRUE) {
            echo "<script>alert('Informasi pendakian berhasil dikirim ke pelanggan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan informasi pendakian: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Data jadwal tidak ditemukan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Informasi Pendakian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function updateFields() {
            const select = document.getElementById('id_pesanan');
            const selectedOption = select.options[select.selectedIndex];
            const data = JSON.parse(selectedOption.getAttribute('data-info'));

            document.getElementById('no_telepon_guide').value = data.no_telepon_guide || '';
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Input Informasi Pendakian</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="id_pesanan" class="form-label">Pesanan</label>
            <select name="id_pesanan" id="id_pesanan" class="form-select" required onchange="updateFields()">
                <option value="">Pilih Pesanan</option>
                <?php while ($pesanan = $result_pesanan->fetch_assoc()): ?>
                    <option value="<?php echo $pesanan['id_pesanan']; ?>" data-info='<?php echo json_encode($pesanan); ?>'>
                        <?php echo "Pesanan #" . $pesanan['id_pesanan'] . " - Guide: " . $pesanan['nama_guide'] . " - Tanggal: " . $pesanan['tanggal_mendaki']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="informasi_tambahan" class="form-label">Informasi Tambahan</label>
            <textarea name="informasi_tambahan" id="informasi_tambahan" class="form-control" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label for="no_telepon_guide" class="form-label">Nomor Telepon Guide</label>
            <input type="text" name="no_telepon_guide" id="no_telepon_guide" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary w-100">Kirim Informasi Ke Pelanggan</button>
        <a href="admin_informasi_pendakian.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
