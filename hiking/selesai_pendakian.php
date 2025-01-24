<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID Pesanan dari URL
$id_pesanan = $_GET['id_pesanan'] ?? null;

if ($id_pesanan) {
    // Perbarui status pesanan menjadi Selesai
    $query_update = "UPDATE pesanan SET status_pesanan = 'Selesai' WHERE id_pesanan = '$id_pesanan'";
    if ($conn->query($query_update) === TRUE) {
        echo "<script>
                alert('Status pendakian berhasil diperbarui menjadi Selesai!');
                window.location.href = 'pesanan_login.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui status: " . $conn->error . "');
                window.location.href = 'pesanan_login.php';
              </script>";
    }
} else {
    echo "<script>
            alert('ID Pesanan tidak ditemukan.');
            window.location.href = 'pesanan_login.php';
          </script>";
}
?>
