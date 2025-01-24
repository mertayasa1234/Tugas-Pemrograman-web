<?php
session_start();

$host = "localhost"; // Ganti sesuai konfigurasi Anda
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "mb_paradise"; // Nama database

$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Silakan login terlebih dahulu!');</script>";
    header("Location: login.php");
    exit();
}

// Mendapatkan username dari sesi
$username = $_SESSION['username'];

// Mendapatkan ID Pelanggan dari tabel users
$query = "SELECT id_pelanggan FROM users WHERE username = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_pelanggan = $row['id_pelanggan'];
} else {
    echo "<script>alert('User tidak ditemukan!');</script>";
    exit();
}

// Mendapatkan data dari form booking
$id_paket = $_POST['paket_id'];
$person_count = $_POST['person_count'];
$preferred_date = $_POST['date'];
$notes = $_POST['notes'];
$tanggal_pesan = date('Y-m-d'); // Tanggal saat ini

// Ambil harga paket dari tabel paket
$query_harga = "SELECT harga FROM paket WHERE id_paket = '$id_paket'";
$result_harga = $conn->query($query_harga);

if ($result_harga->num_rows > 0) {
    $row_harga = $result_harga->fetch_assoc();
    $harga = $row_harga['harga']; // Harga per orang
    $total_harga = $harga * $person_count; // Total harga
} else {
    echo "<script>alert('Paket tidak ditemukan!');</script>";
    exit();
}

// Menyimpan data ke tabel pesanan
$query_insert = "INSERT INTO pesanan (id_pelanggan, id_paket, jumlah_orang, harga, total_harga, tanggal_pesan, tanggal_mendaki, catatan, status_pesanan) 
                 VALUES ('$id_pelanggan', '$id_paket', '$person_count', '$harga', '$total_harga', '$tanggal_pesan', '$preferred_date', '$notes', 'Menunggu Konfirmasi')";

if ($conn->query($query_insert) === TRUE) {
    echo "<script>alert('Booking berhasil!');</script>";
    header("Location: pesanan_login.php");
    exit();
} else {
    echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
}

$conn->close();
?>
