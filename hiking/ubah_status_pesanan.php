<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "mb_paradise";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['id_pesanan']) || !isset($_GET['status'])) {
    echo "<script>alert('ID Pesanan atau Status tidak ditemukan!'); window.history.back();</script>";
    exit();
}

$id_pesanan = intval($_GET['id_pesanan']);
$status = $conn->real_escape_string($_GET['status']);

// Perbarui status pesanan
$query = "UPDATE pesanan SET status_pesanan = '$status' WHERE id_pesanan = $id_pesanan";
if ($conn->query($query) === TRUE) {
    echo "<script>alert('Status pesanan berhasil diperbarui!'); window.location.href='pesanan_login.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui status pesanan: " . $conn->error . "');</script>";
}

$conn->close();
?>
