<?php
include 'config.php';

// Cek apakah sedang dalam mode edit
$edit = false;
$judul = $lokasi = $kategori = $deskripsi = "";

if (isset($_GET['id'])) {
  $edit = true;
  $id = $_GET['id'];
  $result = mysqli_query($conn, "SELECT * FROM lowongan WHERE id = $id");
  $data = mysqli_fetch_assoc($result);
  $judul = $data['judul'];
  $lokasi = $data['lokasi'];
  $kategori = $data['kategori'];
  $deskripsi = $data['deskripsi'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $edit ? "Edit" : "Tambah" ?> Lowongan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/style.css">
  <script defer src="assets/script.js"></script>

</head>
<body class="bg-gray-100 text-gray-800">
  <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded mt-10">
    <h2 class="text-2xl font-bold mb-6 text-blue-600">
      <?= $edit ? "Edit Lowongan" : "Tambah Lowongan" ?>
    </h2>
    <form action="process.php" method="POST" id="jobForm">
      <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
      <?php endif; ?>

      <label class="block mb-2">Judul Pekerjaan</label>
      <input type="text" name="judul" value="<?= $judul ?>" required class="w-full p-2 border rounded mb-4">

      <label class="block mb-2">Lokasi</label>
      <input type="text" name="lokasi" value="<?= $lokasi ?>" required class="w-full p-2 border rounded mb-4">

      <label class="block mb-2">Kategori</label>
      <select name="kategori" class="w-full p-2 border rounded mb-4" required>
        <option value="">Pilih Kategori</option>
        <option value="IT" <?= $kategori == "IT" ? "selected" : "" ?>>IT</option>
        <option value="Finance" <?= $kategori == "Finance" ? "selected" : "" ?>>Finance</option>
        <option value="Marketing" <?= $kategori == "Marketing" ? "selected" : "" ?>>Marketing</option>
      </select>

      <label class="block mb-2">Deskripsi</label>
      <textarea name="deskripsi" rows="5" required class="w-full p-2 border rounded mb-4"><?= $deskripsi ?></textarea>

      <button type="submit" name="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        <?= $edit ? "Update" : "Simpan" ?>
      </button>
    </form>
  </div>
</body>
</html>