<?php
session_start();
include 'config.php';

// Pastikan cuma perusahaan yang bisa akses
if (!isset($_SESSION['perusahaan_id'])) {
    header("Location: login_perusahaan.php");
    exit;
}

$perusahaan_id = intval($_SESSION['perusahaan_id']);

// Ambil profil perusahaan
$query = "
    SELECT * 
    FROM perusahaan_profiles
    WHERE user_id = $perusahaan_id
";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $perusahaan = mysqli_fetch_assoc($result);
} else {
    session_destroy();
    header('Location: login_perusahaan.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Perusahaan - JobFinder</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-600">JobFinder - Perusahaan</h1>
    <nav class="space-x-4">
      <a href="form_lowongan.php" class="text-gray-700 hover:text-blue-600">Tambah Lowongan</a>
      <a href="pelamar.php" class="text-gray-700 hover:text-blue-600">Lihat Pelamar</a>
      <a href="edit_perusahaan.php" class="text-gray-700 hover:text-blue-600">Profil Perusahaan</a>
      <a href="#" onclick="confirmLogout()" class="text-red-500 hover:underline">Logout</a>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="bg-blue-500 text-white text-center py-12">
    <h2 class="text-3xl font-bold mb-2">
      Halo, <?php echo htmlspecialchars($perusahaan['nama_perusahaan']); ?> 👋
    </h2>
    <p class="text-lg">Kelola lowongan dan pantau pelamar dengan mudah di sini.</p>
  </section>

  <!-- Konten utama -->
  <section class="p-6 max-w-4xl mx-auto">
    <h3 class="text-xl font-semibold mb-4">Statistik Singkat</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
      <!-- Total Lowongan -->
      <div class="bg-white p-4 rounded shadow">
        <?php
        $q1 = "SELECT COUNT(*) AS total 
               FROM lowongan 
               WHERE perusahaan_id = $perusahaan_id";
        $r1 = mysqli_query($conn, $q1);
        $d1 = mysqli_fetch_assoc($r1);
        ?>
        <p class="text-gray-600">Total Lowongan Diposting</p>
        <p class="text-2xl font-bold text-blue-600"><?php echo $d1['total']; ?></p>
      </div>

      <!-- Total Pelamar -->
      <div class="bg-white p-4 rounded shadow">
        <?php
        $q2 = "SELECT COUNT(*) AS total 
               FROM aplikasi a 
               JOIN lowongan l ON a.lowongan_id = l.id 
               WHERE l.perusahaan_id = $perusahaan_id";
        $r2 = mysqli_query($conn, $q2);
        $d2 = mysqli_fetch_assoc($r2);
        ?>
        <p class="text-gray-600">Total Pelamar Masuk</p>
        <p class="text-2xl font-bold text-green-600"><?php echo $d2['total']; ?></p>
      </div>
    </div>

    <!-- Daftar Lowongan yang Diposting -->
    <h3 class="text-xl font-semibold mb-4">Lowongan yang Anda Posting</h3>
    <?php
    $q3 = "SELECT * 
           FROM lowongan 
           WHERE perusahaan_id = $perusahaan_id
           ORDER BY created_at DESC";
    $r3 = mysqli_query($conn, $q3);
    ?>

    <?php if (mysqli_num_rows($r3) > 0): ?>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
          <thead class="bg-blue-100">
            <tr>
              <th class="px-4 py-2 text-left">Judul</th>
              <th class="px-4 py-2 text-left">Kategori</th>
              <th class="px-4 py-2 text-left">Lokasi</th>
              <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($r3)): ?>
              <tr class="border-t">
                <td class="px-4 py-2"><?php echo htmlspecialchars($row['judul']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($row['kategori']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($row['lokasi']); ?></td>
                <td class="px-4 py-2 space-x-2">
                  <a href="form_lowongan.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                  <a href="hapus_lowongan.php?id=<?php echo $row['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus lowongan ini?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="text-gray-600">Belum ada lowongan yang Anda posting.</p>
    <?php endif; ?>
  </section>

  <!-- Script konfirmasi logout -->
  <script>
    function confirmLogout() {
      if (confirm("Yakin ingin logout?")) {
        window.location.href = "logout.php";
      }
    }
  </script>

</body>
</html>
