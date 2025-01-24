<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil daftar guide
$query_guide = "SELECT * FROM guide";
$result_guide = $conn->query($query_guide);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
        }

        table th, table td {
            text-align: center;
            padding: 10px;
            vertical-align: middle;
        }

        table th {
            background-color: #343a40;
            color: #fff;
        }

        .btn-primary, .btn-danger, .btn-warning {
            margin: 0 5px;
        }

        .back-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Guide</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Guide</th>
                    <th>Nama Guide</th>
                    <th>Nomor HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_guide->num_rows > 0): ?>
                    <?php while ($guide = $result_guide->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $guide['id_guide']; ?></td>
                            <td><?php echo htmlspecialchars($guide['nama_guide']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($guide['no_hp']); ?>
                                <a href="https://wa.me/<?php echo $guide['no_hp']; ?>" target="_blank" class="btn btn-success btn-sm">Hubungi</a>
                            </td>
                            <td>
                                <a href="edit_guide.php?id_guide=<?php echo $guide['id_guide']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_guide.php?id_guide=<?php echo $guide['id_guide']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus guide ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Tidak ada data guide.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="admin_manajemen_guide.php" class="btn btn-secondary back-btn">Kembali</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
