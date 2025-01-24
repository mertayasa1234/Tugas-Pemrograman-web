<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID Pesanan dari URL
$id_pesanan = $_GET['id_pesanan'] ?? null;

// Validasi ID Pesanan
if (!$id_pesanan) {
    echo "<script>
            alert('ID Pesanan tidak ditemukan.');
            window.location.href = 'pesanan_login.php';
          </script>";
    exit();
}

// Proses pengisian ulasan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ulasan = $conn->real_escape_string($_POST['ulasan']);
    $rating = (int) $_POST['rating'];

    // Cek apakah ulasan sudah ada
    $query_check_ulasan = "SELECT COUNT(*) AS count FROM ulasan WHERE id_pesanan = '$id_pesanan'";
    $result_check_ulasan = $conn->query($query_check_ulasan);
    if ($result_check_ulasan->fetch_assoc()['count'] > 0) {
        echo "<script>
                alert('Anda telah memberikan ulasan untuk pesanan ini.');
                window.location.href = 'pesanan_login.php';
              </script>";
    } else {
        $query_insert = "INSERT INTO ulasan (id_pesanan, ulasan, rating, tanggal_ulasan) 
                         VALUES ('$id_pesanan', '$ulasan', '$rating', NOW())";
        if ($conn->query($query_insert) === TRUE) {
            echo "<script>
                    alert('Terima kasih atas ulasannya!');
                    window.location.href = 'pesanan_login.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal mengirim ulasan: " . $conn->error . "');
                  </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berikan Ulasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Berikan Ulasan</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="ulasan" class="form-label">Ulasan Anda</label>
            <textarea name="ulasan" id="ulasan" class="form-control" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <select name="rating" id="rating" class="form-select" required>
                <option value="5">5 - Sangat Baik</option>
                <option value="4">4 - Baik</option>
                <option value="3">3 - Cukup</option>
                <option value="2">2 - Buruk</option>
                <option value="1">1 - Sangat Buruk</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Kirim Ulasan</button>
        <a href="pesanan_login.php" class="btn btn-secondary w-100 mt-2">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
