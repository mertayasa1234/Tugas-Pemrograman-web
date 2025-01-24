<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "mb_paradise");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data admin berdasarkan ID
$query = "SELECT * FROM Admin WHERE ID_ADMIN = 1"; // Sesuaikan dengan ID admin yang login
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    die("Admin tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Profil Admin</h2>
        <form action="update_admin.php" method="POST" enctype="multipart/form-data">
            <!-- Nama Admin -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Admin</label>
                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $admin['nama_admin']; ?>" required>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo $admin['username']; ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?php echo $admin['email']; ?>" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (Opsional)</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password baru">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                        <i id="eye-icon" class="fa fa-eye"></i>
                    </button>
                </div>
                <small>Kosongkan jika tidak ingin mengganti password.</small>
            </div>

            <!-- Foto Profil -->
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                <small>Biarkan kosong jika tidak ingin mengganti foto.</small>
            </div>

            <!-- Tampilkan Foto Profil Saat Ini -->
            <div class="mb-3">
                <label class="form-label">Foto Profil Saat Ini</label><br>
                <img src="<?php echo $admin['foto_profil']; ?>" alt="Foto Profil" style="width: 100px; height: 100px; border-radius: 50%;">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
