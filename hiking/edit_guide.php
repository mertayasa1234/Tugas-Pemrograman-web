<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "mb_paradise";

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id_guide'])) {
    $id_guide = $conn->real_escape_string($_GET['id_guide']);

    // Query untuk mengambil data guide berdasarkan ID
    $query_guide = "SELECT * FROM guide WHERE id_guide = '$id_guide'";
    $result_guide = $conn->query($query_guide);

    if ($result_guide->num_rows > 0) {
        $guide = $result_guide->fetch_assoc();
    } else {
        echo "<script>alert('Guide tidak ditemukan!'); window.location.href = 'admin_view_guide.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID Guide tidak ditemukan!'); window.location.href = 'admin_view_guide.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_guide = $conn->real_escape_string($_POST['nama_guide']);
    $no_hp = $conn->real_escape_string($_POST['no_hp']);

    // Query untuk memperbarui data guide
    $query_update = "UPDATE guide SET nama_guide = '$nama_guide', no_hp = '$no_hp' WHERE id_guide = '$id_guide'";

    if ($conn->query($query_update) === TRUE) {
        echo "<script>alert('Guide berhasil diperbarui!'); window.location.href = 'admin_view_guide.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui guide: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Guide</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="nama_guide" class="form-label">Nama Guide</label>
            <input type="text" name="nama_guide" id="nama_guide" class="form-control" value="<?php echo htmlspecialchars($guide['nama_guide']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor HP</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?php echo htmlspecialchars($guide['no_hp']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="admin_view_guide.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>