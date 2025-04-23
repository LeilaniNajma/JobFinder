<?php
session_start();
include 'config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil data user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - JobFinder</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-blue-950 text-gray-900">

  <!-- Navbar -->
  <header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-600">JobFinder</h1>
    <nav class="space-x-4">
      <a href="rekomendasi.php" class="text-gray-700 hover:text-blue-600">Rekomendasi</a>
      <a href="##" class="text-gray-700 hover:text-blue-600">Status Lamaran</a>
      <a href="profile.php" class="text-gray-700 hover:text-blue-600">Profile</a>
      <!-- Tombol Logout dengan konfirmasi -->
      <a href="#" onclick="confirmLogout()" class="text-red-500 hover:underline">Logout</a>
    </nav>
  </header>

  <!-- Hero -->
  <section class="bg-blue-500 text-white text-center py-12">
    <h2 class="text-3xl font-bold mb-4">Selamat datang, <?php echo htmlspecialchars($user['nama']); ?></h2>
    <p class="text-lg">Temukan pekerjaan idamanmu</p>
  </section>

  <!-- Dashboard Content -->
  <section class="p-6" id="status">
  <div class="max-w-4xl mx-auto">
    <h3 class="text-xl font-semibold mb-4 text-white">Lowongan yang Anda Lamar</h3>
    <div class="bg-white p-4 rounded shadow-md">
      <?php
        // Bagian data lamaran di-nonaktifkan
        echo "<p>Tidak ada lowongan yang Anda lamar.</p>";
      ?>
    </div>
  </div>
</section>
 

  <!-- Script Konfirmasi Logout -->
  <script>
    function confirmLogout() {
      if (confirm("Apakah kamu yakin ingin logout?")) {
        window.location.href = "logout.php";
      }
    }
  </script>

</body>
</html>
