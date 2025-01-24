<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil jadwal berdasarkan tanggal
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');
$query_jadwal = "SELECT jadwal_guide.*, guide.nama_guide, paket.nama_paket 
                 FROM jadwal_guide 
                 JOIN guide ON jadwal_guide.id_guide = guide.id_guide 
                 JOIN pesanan ON jadwal_guide.id_pesanan = pesanan.id_pesanan 
                 JOIN paket ON pesanan.id_paket = paket.id_paket 
                 WHERE jadwal_guide.tanggal = '$tanggal'";
$result_jadwal = $conn->query($query_jadwal);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px auto;
            max-width: 800px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-top: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-primary {
            margin-top: 10px;
        }

        .no-data {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Jadwal Guide</h1>
        <form method="GET" class="d-flex justify-content-center mb-4">
            <label for="tanggal" class="me-2">Pilih Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control w-auto me-2" value="<?php echo htmlspecialchars($tanggal); ?>" required>
            <button type="submit" class="btn btn-primary">Lihat Jadwal</button>
        </form>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Jadwal</th>
                    <th>Guide</th>
                    <th>Paket</th>
                    <th>Waktu</th>
                    <th>Lokasi Kumpul</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_jadwal->num_rows > 0): ?>
                    <?php while ($jadwal = $result_jadwal->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $jadwal['id_jadwal']; ?></td>
                            <td><?php echo htmlspecialchars($jadwal['nama_guide']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal['nama_paket']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal['waktu_mulai']) . ' - ' . htmlspecialchars($jadwal['waktu_selesai']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal['lokasi_kumpul']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-data">Tidak ada jadwal untuk tanggal ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="admin_manajemen_guide.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
