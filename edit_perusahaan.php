<?php
session_start();
include 'config.php';

// Cek apakah perusahaan sudah login
if (!isset($_SESSION['perusahaan_id'])) {
    header('Location: login_perusahaan.php');
    exit;
}

$perusahaan_id = $_SESSION['perusahaan_id'];
$error = '';
$success = '';

// Ambil data perusahaan saat ini
$query = mysqli_query($conn, "SELECT * FROM perusahaan_profiles WHERE user_id = '$perusahaan_id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data perusahaan tidak ditemukan.");
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_perusahaan = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $bidang          = mysqli_real_escape_string($conn, $_POST['bidang']);
    $alamat          = mysqli_real_escape_string($conn, $_POST['alamat']);
    $deskripsi       = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $update = mysqli_query($conn, "UPDATE perusahaan_profiles 
                                   SET nama_perusahaan = '$nama_perusahaan', 
                                       bidang = '$bidang', 
                                       alamat = '$alamat', 
                                       deskripsi = '$deskripsi' 
                                   WHERE user_id = '$perusahaan_id'");

    if ($update) {
        $success = "Data berhasil diperbarui.";
        // refresh data
        $query = mysqli_query($conn, "SELECT * FROM perusahaan_profiles WHERE user_id = '$perusahaan_id'");
        $data = mysqli_fetch_assoc($query);
    } else {
        $error = "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil Perusahaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-8">
  <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center text-blue-600">Edit Profil Perusahaan</h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="bg-green-100 text-green-700 p-2 mb-4 rounded"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Nama Perusahaan</label>
        <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($data['nama_perusahaan']) ?>" required class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm font-medium">Bidang</label>
        <input type="text" name="bidang" value="<?= htmlspecialchars($data['bidang']) ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm font-medium">Alamat</label>
        <textarea name="alamat" class="w-full border p-2 rounded" rows="3"><?= htmlspecialchars($data['alamat']) ?></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium">Deskripsi</label>
        <textarea name="deskripsi" class="w-full border p-2 rounded" rows="4"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Simpan Perubahan</button>
    </form>
    <div class="mt-4 text-center">
      <a href="dashboard_perusahaan.php" class="text-blue-600 hover:underline">Kembali ke Dashboard</a>
    </div>
  </div>
</body>
</html>
