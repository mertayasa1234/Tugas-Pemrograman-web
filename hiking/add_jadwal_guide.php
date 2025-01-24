<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil daftar guide
$query_guide = "SELECT * FROM guide";
$result_guide = $conn->query($query_guide);

// Ambil daftar pesanan yang belum memiliki guide
$query_pesanan = "SELECT pesanan.id_pesanan, paket.nama_paket, pesanan.tanggal_mendaki 
                   FROM pesanan 
                   JOIN paket ON pesanan.id_paket = paket.id_paket
                   WHERE pesanan.id_guide IS NULL";
$result_pesanan = $conn->query($query_pesanan);

// Proses form tambah jadwal guide
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_guide = $_POST['id_guide'];
    $id_pesanan = $_POST['id_pesanan'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $lokasi_kumpul = $_POST['lokasi_kumpul'];

    // Ambil tanggal mendaki dari pesanan
    $query_tanggal = "SELECT tanggal_mendaki FROM pesanan WHERE id_pesanan = '$id_pesanan'";
    $result_tanggal = $conn->query($query_tanggal);
    if ($result_tanggal && $result_tanggal->num_rows > 0) {
        $tanggal = $result_tanggal->fetch_assoc()['tanggal_mendaki'];
    } else {
        die("<script>alert('Pesanan tidak ditemukan!');</script>");
    }

    // Update pesanan untuk menambahkan guide
    $query_update = "UPDATE pesanan SET id_guide = '$id_guide' WHERE id_pesanan = '$id_pesanan'";
    if ($conn->query($query_update) === TRUE) {
        // Tambahkan jadwal guide
        $query_insert = "INSERT INTO jadwal_guide (id_guide, id_pesanan, tanggal, waktu_mulai, waktu_selesai, lokasi_kumpul) 
                         VALUES ('$id_guide', '$id_pesanan', '$tanggal', '$waktu_mulai', '$waktu_selesai', '$lokasi_kumpul')";
        if ($conn->query($query_insert) === TRUE) {
            echo "<script>alert('Jadwal guide berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan jadwal guide: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Gagal memperbarui pesanan: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 500px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-back {
            margin-top: 10px;
            width: 100%;
            background-color: #6c757d;
            color: white;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">Tambah Jadwal Guide</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="id_guide" class="form-label">Guide</label>
            <select name="id_guide" id="id_guide" class="form-select" required>
                <option value="">Pilih Guide</option>
                <?php while ($guide = $result_guide->fetch_assoc()): ?>
                    <option value="<?php echo $guide['id_guide']; ?>"><?php echo htmlspecialchars($guide['nama_guide']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_pesanan" class="form-label">Pesanan</label>
            <select name="id_pesanan" id="id_pesanan" class="form-select" required>
                <option value="">Pilih Pesanan</option>
                <?php while ($pesanan = $result_pesanan->fetch_assoc()): ?>
                    <option value="<?php echo $pesanan['id_pesanan']; ?>">
                        <?php echo htmlspecialchars($pesanan['nama_paket']) . " - " . htmlspecialchars($pesanan['tanggal_mendaki']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
            <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
            <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lokasi_kumpul" class="form-label">Lokasi Kumpul</label>
            <input type="text" name="lokasi_kumpul" id="lokasi_kumpul" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Tambah Jadwal</button>
        <a href="admin_manajemen_guide.php" class="btn btn-back text-center">Kembali</a>
    </form>
</div>
</body>
</html>
