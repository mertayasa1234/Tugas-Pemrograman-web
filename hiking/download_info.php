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

if (!isset($_GET['id_pesanan'])) {
    echo "<script>alert('ID Pesanan tidak ditemukan!'); window.history.back();</script>";
    exit();
}

$id_pesanan = intval($_GET['id_pesanan']);

// Ambil informasi pendakian dari database
$query = "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Informasi_Pendakian_{$id_pesanan}.txt\"");

    echo "Informasi Pendakian\n";
    echo "====================\n";
    echo "ID Pesanan: " . $data['id_pesanan'] . "\n";
    echo "Tanggal Mendaki: " . $data['tanggal_mendaki'] . "\n";
    echo "Jumlah Orang: " . $data['jumlah_orang'] . "\n";
    echo "Catatan: " . $data['catatan'] . "\n";
} else {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.history.back();</script>";
}

$conn->close();
?>
