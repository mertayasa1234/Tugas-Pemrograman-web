<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "mb_paradise";

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id_guide'])) {
    $id_guide = $conn->real_escape_string($_GET['id_guide']);

    // Query untuk menghapus guide
    $query_delete = "DELETE FROM guide WHERE id_guide = '$id_guide'";
    if ($conn->query($query_delete) === TRUE) {
        echo "<script>alert('Guide berhasil dihapus!'); window.location.href = 'admin_view_guide.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus guide: " . $conn->error . "'); window.location.href = 'admin_view_guide.php';</script>";
    }
} else {
    echo "<script>alert('ID Guide tidak ditemukan!'); window.location.href = 'admin_view_guide.php';</script>";
}

$conn->close();
?>