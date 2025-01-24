<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form input guide
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_guide = $_POST['nama_guide'];
    $no_hp = $_POST['no_hp'];

    $query_insert = "INSERT INTO guide (nama_guide, no_hp) VALUES ('$nama_guide', '$no_hp')";
    if ($conn->query($query_insert) === TRUE) {
        echo "<script>alert('Guide berhasil ditambahkan!'); window.location.href='admin_manajemen_guide.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan guide: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Tambah Guide</h1>
        <div class="card shadow-lg mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama_guide" class="form-label">Nama Guide</label>
                        <input type="text" class="form-control" name="nama_guide" id="nama_guide" placeholder="Masukkan nama guide" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="Masukkan nomor HP" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="admin_manajemen_guide.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Tambah Guide</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
