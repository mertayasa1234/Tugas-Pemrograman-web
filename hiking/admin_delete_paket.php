<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID Paket dari URL
if (!isset($_GET['id_paket'])) {
    echo "ID Paket tidak ditemukan!";
    exit();
}

$id_paket = $conn->real_escape_string($_GET['id_paket']);

// Hapus data paket dari database
$query = "DELETE FROM paket WHERE id_paket = '$id_paket'";

if ($conn->query($query) === TRUE) {
    echo "<script>alert('Paket berhasil dihapus!'); window.location.href='admin_manage_paket.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus paket: " . $conn->error . "'); window.location.href='admin_manage_paket.php';</script>";
}

$conn->close();
?>
