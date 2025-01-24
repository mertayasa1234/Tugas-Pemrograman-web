<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "mb_paradise";

$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['id_pesanan'])) {
    echo "<script>alert('ID pesanan tidak ditemukan!');</script>";
    header("Location: pesanan_login.php");
    exit();
}

$id_pesanan = $_GET['id_pesanan'];

// Update status pesanan
$query_update = "UPDATE pesanan SET status_pesanan = 'Menunggu Pembayaran' WHERE id_pesanan = '$id_pesanan'";
if ($conn->query($query_update) === TRUE) {
    echo "<script>alert('Pesanan berhasil dikonfirmasi!');</script>";
    header("Location: pesanan_login.php");
    exit();
} else {
    echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
}
?>
