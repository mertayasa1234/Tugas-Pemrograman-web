<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data ulasan dari database
$query_ulasan = "
    SELECT ulasan.id_ulasan, 
           ulasan.ulasan, 
           ulasan.rating, 
           ulasan.tanggal_ulasan, 
           paket.nama_paket, 
           users.username AS nama_pelanggan
    FROM ulasan
    JOIN pesanan ON ulasan.id_pesanan = pesanan.id_pesanan
    JOIN paket ON pesanan.id_paket = paket.id_paket
    JOIN users ON pesanan.id_pelanggan = users.id_pelanggan
    ORDER BY ulasan.tanggal_ulasan DESC";
$result_ulasan = $conn->query($query_ulasan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .review-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }
        .review-card h4 {
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        .review-card .rating {
            font-size: 1rem;
            color: #ffc107;
        }
        .review-card .username {
            font-size: 0.9rem;
            color: #555;
        }
        .review-card .date {
            font-size: 0.8rem;
            color: #999;
        }
        .review-card .content {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #333;
        }
        .back-button {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">Ulasan Pelanggan</h2>
    <?php if ($result_ulasan->num_rows > 0): ?>
        <?php while ($row = $result_ulasan->fetch_assoc()): ?>
            <div class="review-card">
                <h4><?php echo htmlspecialchars($row['nama_paket']); ?></h4>
                <div class="rating">Rating: <?php echo str_repeat('★', $row['rating']); ?></div>
                <div class="username">Oleh: <?php echo htmlspecialchars($row['nama_pelanggan']); ?></div>
                <div class="date">Tanggal: <?php echo $row['tanggal_ulasan']; ?></div>
                <div class="content"><?php echo htmlspecialchars($row['ulasan']); ?></div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center">Belum ada ulasan dari pelanggan.</p>
    <?php endif; ?>
    <div class="back-button">
        <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
