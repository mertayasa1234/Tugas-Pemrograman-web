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

if (!isset($_GET['order_id'])) {
    echo "<script>alert('ID pesanan tidak ditemukan!');</script>";
    header("Location: pesanan_login.php");
    exit();
}

$order_id = $_GET['order_id'];

// Mendapatkan data pesanan berdasarkan ID
$query_pesanan = "SELECT * FROM pesanan WHERE id_pesanan = '$order_id'";
$result_pesanan = $conn->query($query_pesanan);

if ($result_pesanan->num_rows === 0) {
    echo "<script>alert('Pesanan tidak ditemukan!');</script>";
    header("Location: pesanan_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data dari form
    $bank = $_POST['bank'];
    $target_dir = "uploads/";
    $file_name = basename($_FILES["bukti_pembayaran"]["name"]);
    $target_file = $target_dir . $file_name;
    $upload_ok = true;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $tanggal_upload = date('Y-m-d H:i:s');

    // Validasi file
    if ($file_type !== "jpg" && $file_type !== "jpeg" && $file_type !== "png") {
        $upload_ok = false;
        echo "<script>alert('Hanya file JPG, JPEG, dan PNG yang diperbolehkan!');</script>";
    }

    if ($upload_ok) {
        if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
            // Kirim data ke tabel bukti_pembayaran
            $query_bukti = "INSERT INTO bukti_pembayaran (id_pesanan, file_bukti, tanggal_upload, status) 
                            VALUES ('$order_id', '$target_file', '$tanggal_upload', 'Menunggu Verifikasi')";
            if ($conn->query($query_bukti) === TRUE) {
                // Update tabel pesanan
                $query_update_pesanan = "UPDATE pesanan SET bukti_pembayaran = '$target_file', status_pesanan = 'Menunggu Verifikasi' WHERE id_pesanan = '$order_id'";
                if ($conn->query($query_update_pesanan) === TRUE) {
                    echo "<script>alert('Bukti pembayaran berhasil diunggah!');</script>";
                    header("Location: pesanan_login.php");
                    exit();
                } else {
                    echo "<script>alert('Terjadi kesalahan saat memperbarui tabel pesanan: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Terjadi kesalahan saat menyimpan data ke tabel bukti_pembayaran: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Gagal mengunggah file!');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Bank - Mount Batur Paradise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 500px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        #bankDetails {
            background-color: #f1f1f1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Transfer Bank</h2>
    <p>Pilih bank tujuan dan unggah bukti pembayaran Anda.</p>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="bank" class="form-label">Pilih Bank</label>
            <select name="bank" id="bank" class="form-select" onchange="showBankDetails(this.value)" required>
                <option value="">-- Pilih Bank --</option>
                <option value="BCA">BCA</option>
                <option value="BRI">BRI</option>
                <option value="BNI">BNI</option>
                <option value="Mandiri">Mandiri</option>
            </select>
        </div>
        <div id="bankDetails" style="display: none;">
            <p><strong>Nomor Rekening:</strong> <span id="rekening"></span></p>
            <p><strong>Atas Nama:</strong> Mertayasa</p>
        </div>
        <div class="mb-3">
            <label for="bukti_pembayaran" class="form-label">Unggah Bukti Pembayaran</label>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Unggah Bukti Pembayaran</button>
    </form>
</div>

<script>
    function showBankDetails(bank) {
        const bankDetails = document.getElementById('bankDetails');
        const rekening = document.getElementById('rekening');

        if (bank === 'BCA') {
            rekening.textContent = '0012345678';
        } else if (bank === 'BRI') {
            rekening.textContent = '010123456789';
        } else if (bank === 'BNI') {
            rekening.textContent = '120025';
        } else if (bank === 'Mandiri') {
            rekening.textContent = '9808';
        } else {
            bankDetails.style.display = 'none';
            return;
        }

        bankDetails.style.display = 'block';
    }
</script>
</body>
</html>
