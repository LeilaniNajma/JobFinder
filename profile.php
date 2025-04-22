<?php
session_start();
include 'config.php';

// jika belum login, kembali ke register/login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// saat form disubmit, simpan ke tabel baru `profiles` atau update tabel users
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $hp         = mysqli_real_escape_string($conn, $_POST['hp']);
  $negara     = $_POST['negara'];
  $provinsi   = $_POST['provinsi'];
  $kota       = $_POST['kota'];
  $alamat     = mysqli_real_escape_string($conn, $_POST['alamat']);
  $kelamin    = $_POST['kelamin'];
  $tgl_lahir  = $_POST['tgl_lahir'];
  $summary    = mysqli_real_escape_string($conn, $_POST['summary']);

  // simpan atau update ke tabel profiles
  $sql = "REPLACE INTO profiles
          (user_id, hp, negara, provinsi, kota, alamat, kelamin, tgl_lahir, summary)
          VALUES
          ($user_id, '$hp', '$negara', '$provinsi', '$kota', '$alamat', '$kelamin', '$tgl_lahir', '$summary')";
  mysqli_query($conn, $sql);

  // selesai lengkapi, arahkan ke dashboarddddddd
  header("Location: dashboard.php");
  exit;
}

// ambil data jika sudah ada
$check = mysqli_query($conn, "SELECT * FROM profiles WHERE user_id = $user_id");
$data = mysqli_fetch_assoc($check);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Lengkapi Data Diri</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Lengkapi Data Diri</h2>
    <form method="POST" class="space-y-4">
      <div>
        <label>No. HP*</label>
        <input type="text" name="hp" value="<?= htmlspecialchars($data['hp'] ?? '') ?>" required class="w-full border p-2 rounded">
      </div>
      <div class="grid grid-cols-3 gap-4">
        <div>
          <label>Negara*</label>
          <select name="negara" required class="w-full border p-2 rounded">
            <option value="Indonesia" <?= (isset($data['negara']) && $data['negara'] == 'Indonesia') ? 'selected' : '' ?>>Indonesia</option>
            <!-- Tambah opsi lain jika perlu -->
          </select>
        </div>
        <div>
          <label>Provinsi*</label>
          <input type="text" name="provinsi" value="<?= htmlspecialchars($data['provinsi'] ?? '') ?>" required class="w-full border p-2 rounded">
        </div>
        <div>
          <label>Kota*</label>
          <input type="text" name="kota" value="<?= htmlspecialchars($data['kota'] ?? '') ?>" required class="w-full border p-2 rounded">
        </div>
      </div>
      <div>
        <label>Alamat Lengkap</label>
        <input type="text" name="alamat" value="<?= htmlspecialchars($data['alamat'] ?? '') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label>Jenis Kelamin</label>
        <div class="space-x-4">
          <label><input type="radio" name="kelamin" value="Pria" <?= (isset($data['kelamin']) && $data['kelamin'] == 'Pria') ? 'checked' : '' ?>> Pria</label>
          <label><input type="radio" name="kelamin" value="Wanita" <?= (isset($data['kelamin']) && $data['kelamin'] == 'Wanita') ? 'checked' : '' ?>> Wanita</label>
        </div>
      </div>
      <div>
        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" value="<?= htmlspecialchars($data['tgl_lahir'] ?? '') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label>Ringkasan Profil</label>
        <textarea name="summary" rows="4" class="w-full border p-2 rounded"><?= htmlspecialchars($data['summary'] ?? '') ?></textarea>
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan dan Ke Dashboard</button>
    </form>
  </div>
</body>
</html>
