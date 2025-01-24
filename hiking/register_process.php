<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ubah sesuai konfigurasi MySQL Anda
$password = "";     // Kosongkan jika tidak ada password
$dbname = "mb_paradise";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST["nama"]); // Ambil data nama dari form
    $username = $conn->real_escape_string($_POST["username"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $address = $conn->real_escape_string($_POST["address"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $confirm_password = $conn->real_escape_string($_POST["confirm_password"]);

    // Validasi password
    if ($password !== $confirm_password) {
        die("Password and Confirm Password do not match!");
    }

    // Hash password untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Query untuk memasukkan data ke tabel
    $sql = "INSERT INTO users (nama, username, email, address, password) 
            VALUES ('$nama', '$username', '$email', '$address', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! <a href='login.php'>Click here to login</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>
