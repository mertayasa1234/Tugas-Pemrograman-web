<?php
session_start();

// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "mb_paradise";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah ID Pesanan dikirim
if (isset($_GET['id_pesanan'])) {
    $id_pesanan = $_GET['id_pesanan'];

    // Update status pesanan menjadi "Dikonfirmasi"
    $query = "UPDATE pesanan SET status_pesanan = 'Dikonfirmasi' WHERE id_pesanan = '$id_pesanan'";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Pesanan berhasil dikonfirmasi!');</script>";
        header("Location: pesanan_login.php"); // Redirect ke halaman pesanan
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
    }
} else {
    echo "<script>alert('ID Pesanan tidak ditemukan!');</script>";
    header("Location: pesanan_login.php");
}

$conn->close();
?>
