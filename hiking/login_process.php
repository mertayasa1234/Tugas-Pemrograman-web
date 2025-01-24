<?php
session_start();

// Misalkan ID admin didapatkan dari database setelah login
$_SESSION['id_admin'] = $admin['id_admin'];
$host = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "mb_paradise";

$conn = new mysqli($host, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil input dari form login
$username = trim($conn->real_escape_string($_POST['username']));
$password = trim($_POST['password']); // Jangan di-hash di sini

// Cek di tabel admin terlebih dahulu
$query_admin = "SELECT * FROM admin WHERE username = '$username'";
$result_admin = $conn->query($query_admin);

if ($result_admin && $result_admin->num_rows > 0) {
    $admin = $result_admin->fetch_assoc();

    // Verifikasi password admin menggunakan bcrypt
    if (password_verify($password, $admin['password'])) {
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Password salah untuk admin!');</script>";
        header("Refresh:0; url=login.php");
        exit();
    }
}

// Jika tidak ditemukan di admin, cek di tabel users
$query_user = "SELECT * FROM users WHERE username = '$username'";
$result_user = $conn->query($query_user);

if ($result_user && $result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();

    // Verifikasi password user menggunakan bcrypt
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'user';
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Password salah untuk user!');</script>";
        header("Refresh:0; url=login.php");
        exit();
    }
}

// Jika username tidak ditemukan di kedua tabel
echo "<script>alert('Username tidak ditemukan!');</script>";
header("Refresh:0; url=login.php");
?>
