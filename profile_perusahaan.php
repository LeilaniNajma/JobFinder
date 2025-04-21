<?php
session_start();
include 'config.php';

// Proses form registrasi perusahaan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email            = mysqli_real_escape_string($conn, $_POST['email']);
    $password         = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_perusahaan  = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $bidang           = mysqli_real_escape_string($conn, $_POST['bidang']);
    $alamat           = mysqli_real_escape_string($conn, $_POST['alamat']);
    $deskripsi        = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Cek apakah email sudah digunakan
    $check = mysqli_query($conn, "SELECT user_id FROM perusahaan_profiles WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email sudah digunakan.";
    } else {
        // Masukkan ke tabel perusahaan_profiles
        $insertPerusahaan = mysqli_query($conn, "INSERT INTO perusahaan_profiles (nama_perusahaan, bidang, alamat, deskripsi, email, password) 
                                                 VALUES ('$nama_perusahaan', '$bidang', '$alamat', '$deskripsi', '$email', '$password')");
        if ($insertPerusahaan) {
            $perusahaan_id = mysqli_insert_id($conn);
            // Set session perusahaan_id
            $_SESSION['perusahaan_id'] = $perusahaan_id;
            // Setelah berhasil, arahkan ke dashboard perusahaan
            header('Location: dashboard_perusahaan.php');
            exit;
        } else {
            $error = "Gagal registrasi perusahaan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Perusahaan - JobFinder</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-8">
  <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center text-blue-600">Registrasi Perusahaan</h2>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Email Perusahaan *</label>
        <input type="email" name="email" required class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm font-medium">Password *</label>
        <input type="password" name="password" required class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm font-medium">Nama Perusahaan *</label>
        <input type="text" name="nama_perusahaan" required class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm font-medium">Bidang Usaha</label>
        <input type="text" name="bidang" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm font-medium">Alamat</label>
        <textarea name="alamat" rows="3" class="w-full border p-2 rounded"></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium">Deskripsi Perusahaan</label>
        <textarea name="deskripsi" rows="4" class="w-full border p-2 rounded"></textarea>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Daftar Sekarang</button>
    </form>

    <div class="mt-4 text-center">
    <p class="text-center mt-4 text-sm">Sudah punya akun? <a href="login_perusahaan.php" class="text-blue-600 hover:underline">Login</a></p>
    </div>
  </div>
</body>
</html>
