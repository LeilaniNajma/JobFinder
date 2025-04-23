<?php
session_start();
include 'config.php';

if (!isset($_GET['id'])) {
  echo "<p>ID tidak ditemukan.</p>";
  exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM lowongan WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
  echo "<p>Lowongan tidak ditemukan.</p>";
  exit;
}

$data = mysqli_fetch_assoc($result);

// Cek asal halaman
$from = isset($_GET['from']) ? $_GET['from'] : 'index';
$kembaliKe = $from === 'rekomendasi' ? 'rekomendasi.php' : 'index.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Lowongan - <?php echo htmlspecialchars($data['judul']); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/style.css">
  <script defer src="assets/script.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold text-blue-600 mb-2"><?php echo htmlspecialchars($data['judul']); ?></h1>
    <p class="text-gray-600 mb-4">Kategori: <?php echo htmlspecialchars($data['kategori']); ?> | Lokasi: <?php echo htmlspecialchars($data['lokasi']); ?></p>
    
    <div class="mb-4">
      <h2 class="text-lg font-semibold mb-1">Deskripsi Pekerjaan:</h2>
      <p><?php echo nl2br(htmlspecialchars($data['deskripsi'])); ?></p>
    </div>

   <!-- Tombol aksi -->
    <div class="flex flex-wrap items-center space-x-4 mt-6">
      <?php
      // Tambahan pengecekan aman
      $isPerusahaanLogin = isset($_SESSION['perusahaan_id']) && isset($data['user_id']) && $_SESSION['perusahaan_id'] == $data['user_id'];
      ?>

      <?php if ($isPerusahaanLogin): ?>
        <a href="form.php?id=<?php echo $data['id']; ?>" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500">Edit</a>
        <a href="delete.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Yakin ingin menghapus lowongan ini?')" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus</a>
      <?php else: ?>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="lamar.php?id=<?php echo $data['id']; ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Lamar</a>
        <?php endif; ?>
      <?php endif; ?>
      <a href="<?php echo $kembaliKe; ?>" class="ml-auto text-blue-600 hover:underline">← Kembali</a>
    </div>
  </div>
</body>
</html>
