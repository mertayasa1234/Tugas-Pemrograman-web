<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_paket = $conn->real_escape_string($_POST['nama_paket']);
    $harga = $conn->real_escape_string($_POST['harga']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $durasi = $conn->real_escape_string($_POST['durasi']);
    $kuota_min = $conn->real_escape_string($_POST['kuota_min']);
    $kuota_max = $conn->real_escape_string($_POST['kuota_max']);

    // Validasi kuota
    if ($kuota_min > $kuota_max) {
        echo "<script>alert('Kuota minimal tidak boleh lebih besar dari kuota maksimal!');</script>";
    } else {
        // Proses upload file gambar
        $gambar = '';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $upload_dir = 'assets/paket/';
            $filename = basename($_FILES['gambar']['name']);
            $target_file = $upload_dir . $filename;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                $gambar = $target_file;
            } else {
                echo "<script>alert('Gagal mengupload gambar!');</script>";
            }
        }

        // Insert data ke tabel paket
        $query = "INSERT INTO paket (nama_paket, harga, deskripsi, gambar, durasi, kuota_min, kuota_max) 
                  VALUES ('$nama_paket', '$harga', '$deskripsi', '$gambar', '$durasi', '$kuota_min', '$kuota_max')";

        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Paket berhasil ditambahkan!'); window.location.href='admin_manage_paket.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan paket: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Paket - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            margin-top: 50px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Tambah Paket Baru</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama_paket" class="form-label">Nama Paket</label>
            <input type="text" class="form-control" id="nama_paket" name="nama_paket" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="durasi" class="form-label">Durasi</label>
            <input type="text" class="form-control" id="durasi" name="durasi" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kuota_min" class="form-label">Kuota Minimal</label>
                <input type="number" class="form-control" id="kuota_min" name="kuota_min" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kuota_max" class="form-label">Kuota Maksimal</label>
                <input type="number" class="form-control" id="kuota_max" name="kuota_max" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="admin_manage_paket.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
