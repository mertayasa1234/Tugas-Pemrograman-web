<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "mb_paradise";

$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani form POST untuk penolakan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_bukti']) && isset($_POST['alasan_penolakan'])) {
    $id_bukti = $conn->real_escape_string($_POST['id_bukti']);
    $alasan_penolakan = $conn->real_escape_string($_POST['alasan_penolakan']);

    // Update status dan alasan penolakan di tabel bukti_pembayaran
    $query_update_bukti = "UPDATE bukti_pembayaran SET status = 'Ditolak', alasan_penolakan = '$alasan_penolakan' WHERE id_bukti = '$id_bukti'";
    if ($conn->query($query_update_bukti) === TRUE) {
        // Ambil ID pesanan dari tabel bukti_pembayaran
        $query_get_pesanan = "SELECT id_pesanan FROM bukti_pembayaran WHERE id_bukti = '$id_bukti'";
        $result_get_pesanan = $conn->query($query_get_pesanan);

        if ($result_get_pesanan->num_rows > 0) {
            $row = $result_get_pesanan->fetch_assoc();
            $id_pesanan = $row['id_pesanan'];

            // Update status pesanan di tabel pesanan
            $query_update_pesanan = "UPDATE pesanan SET status_pesanan = 'Ditolak' WHERE id_pesanan = '$id_pesanan'";
            if ($conn->query($query_update_pesanan) === TRUE) {
                echo "<script>alert('Pembayaran berhasil ditolak dan kedua tabel telah diperbarui.');</script>";
            } else {
                echo "<script>alert('Gagal memperbarui status pesanan: " . $conn->error . "');</script>";
            }
        }
        header("Location: admin_verifikasi_pembayaran.php");
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui status bukti pembayaran: " . $conn->error . "');</script>";
        header("Location: admin_verifikasi_pembayaran.php");
        exit();
    }
}

// Menangani GET untuk status diterima
if (isset($_GET['id_bukti']) && isset($_GET['status'])) {
    $id_bukti = $conn->real_escape_string($_GET['id_bukti']);
    $status = $conn->real_escape_string($_GET['status']);

    // Validasi status
    if (!in_array($status, ['Diterima', 'Ditolak'])) {
        echo "<script>alert('Status tidak valid!');</script>";
        header("Location: admin_verifikasi_pembayaran.php");
        exit();
    }

    // Update status di tabel bukti_pembayaran
    $query_update_bukti = "UPDATE bukti_pembayaran SET status = '$status' WHERE id_bukti = '$id_bukti'";
    if ($conn->query($query_update_bukti) === TRUE) {
        // Ambil ID pesanan dari tabel bukti_pembayaran
        $query_get_pesanan = "SELECT id_pesanan FROM bukti_pembayaran WHERE id_bukti = '$id_bukti'";
        $result_get_pesanan = $conn->query($query_get_pesanan);

        if ($result_get_pesanan->num_rows > 0) {
            $row = $result_get_pesanan->fetch_assoc();
            $id_pesanan = $row['id_pesanan'];

            // Update status pesanan
            $status_pesanan = ($status === 'Diterima') ? 'Lunas' : 'Ditolak';
            $query_update_pesanan = "UPDATE pesanan SET status_pesanan = '$status_pesanan' WHERE id_pesanan = '$id_pesanan'";
            
            if ($conn->query($query_update_pesanan) === TRUE) {
                echo "<script>alert('Status pesanan berhasil diperbarui menjadi $status_pesanan!');</script>";
            } else {
                echo "<script>alert('Gagal memperbarui status pesanan: " . $conn->error . "');</script>";
            }
        }
        header("Location: admin_verifikasi_pembayaran.php");
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui status: " . $conn->error . "');</script>";
        header("Location: admin_verifikasi_pembayaran.php");
        exit();
    }
} else {
    echo "<script>alert('Data tidak lengkap!');</script>";
    header("Location: admin_verifikasi_pembayaran.php");
    exit();
}

$conn->close();
?>
