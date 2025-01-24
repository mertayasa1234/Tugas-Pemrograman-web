<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$id_admin = 2; // Sesuaikan dengan ID admin yang login
$nama = $conn->real_escape_string($_POST['nama']);
$username = $conn->real_escape_string($_POST['username']);
$email = $conn->real_escape_string($_POST['email']);
$password = isset($_POST['password']) && !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

// Proses upload foto (jika ada)
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "assets/admin/";
    $file_name = basename($_FILES['foto']['name']);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file gambar
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Format file tidak didukung. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.");
    }

    // Simpan file
    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
        die("Gagal mengunggah foto.");
    }

    // Update foto profil di database
    $foto_query = "FOTO_PROFIL = '$target_file',";
} else {
    $foto_query = "";
}

// Buat query update
$query = "UPDATE Admin SET 
    NAMA_ADMIN = '$nama', 
    USERNAME = '$username', 
    EMAIL = '$email', 
    $foto_query 
    ".($password ? "PASSWORD = '$password'" : "")."
    WHERE ID_ADMIN = $id_admin";

// Jalankan query
if ($conn->query($query)) {
    echo "<script>alert('Profil berhasil diperbarui.'); window.location.href='admin_dashboard.php';</script>";
} else {
    echo "Gagal memperbarui profil: " . $conn->error;
}

$conn->close();
?>
