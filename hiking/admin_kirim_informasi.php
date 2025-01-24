<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah parameter id_pesanan diterima
if (isset($_GET['id_pesanan'])) {
    $id_pesanan = $_GET['id_pesanan'];

    // Update status_pesanan menjadi "Dikirim"
    $query_update = "UPDATE pesanan SET status_pesanan = 'Dikirim' WHERE id_pesanan = '$id_pesanan'";
    if ($conn->query($query_update) === TRUE) {
        echo "<script>
                alert('Informasi pendakian berhasil dikirim!');
                window.location.href = 'admin_informasi_pendakian.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengirim informasi: " . $conn->error . "');
                window.location.href = 'admin_informasi_pendakian.php';
              </script>";
    }
} else {
    echo "<script>
            alert('ID Pesanan tidak ditemukan.');
            window.location.href = 'admin_informasi_pendakian.php';
          </script>";
}
?>
