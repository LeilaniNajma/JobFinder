<?php
session_start();
include 'config.php';

$isLoggedIn = isset($_SESSION['user_id']); // Cek jika pengguna sudah login
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JobFinder</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/style.css">
  <script defer src="assets/script.js"></script>
</head>

<body class="bg-gray-100 text-gray-800">
  <!-- Navbar -->
  <header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-600">JobFinder</h1>
    <nav class="space-x-4">
      <a href="index.php" class="text-gray-700 hover:text-blue-600">Beranda</a>

      <?php if ($isLoggedIn): ?>
        <!-- Jika sudah login -->
        <a href="dashboard.php" class="text-gray-700 hover:text-blue-600">Dashboard</a>
        <a href="profile.php" class="text-gray-700 hover:text-blue-600">Profil</a>
        <a href="logout.php" class="text-red-500">Logout</a>
      <?php else: ?>
        <!-- Jika belum login -->
        <a href="profile_perusahaan.php" class="text-gray-700 hover:text-blue-600">Untuk Perusahaan</a>
        <a href="login.php" class="text-gray-700 hover:text-blue-600">Login</a>
        <a href="daftar.php" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Daftar</a>
      <?php endif; ?>
    </nav>
  </header>

  <!-- Hero -->
  <section class="bg-blue-500 text-white text-center py-12">
    <h2 class="text-3xl font-bold mb-4">Cari Kerja #makin mudah</h2>
    <p class="text-lg">Dapatkan Informasi Lowongan yang cocok dengan profil Anda</p>
  </section>

  <!-- Search & Filter -->
  <section class="p-6">
    <div class="max-w-4xl mx-auto grid gap-4 sm:grid-cols-3">
      <input type="text" id="searchInput" placeholder="Cari posisi..." class="p-2 border rounded col-span-2">
      <select id="categoryFilter" class="p-2 border rounded">
        <option value="">Semua Kategori</option>
        <option value="IT">IT</option>
        <option value="Finance">Finance</option>
        <option value="Marketing">Marketing</option>
      </select>
    </div>
  </section>

  <!-- Job List -->
  <section class="p-6">
    <div class="max-w-4xl mx-auto grid gap-4" id="jobList">
      <?php
      // Query untuk mengambil lowongan
      $query = "SELECT * FROM lowongan ORDER BY id DESC";
      $result = mysqli_query($conn, $query);

      // Menampilkan lowongan
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='bg-white p-4 rounded shadow job-card' data-category='" . htmlspecialchars($row['kategori']) . "'>
                <h3 class='text-xl font-bold'>" . htmlspecialchars($row['judul']) . "</h3>
                <p class='text-gray-600'>" . htmlspecialchars($row['lokasi']) . "</p>
                <a href='detail.php?id=" . $row['id'] . "' class='text-blue-600 mt-2 inline-block'>Lihat Detail</a>
              </div>";
      }
      ?>
    </div>
  </section>

</body>
</html>
