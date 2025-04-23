<?php
include 'config.php';

$subkategori = $_GET['subkategori'] ?? '';
$minat = $_GET['minat'] ?? '';
$lowongan = [];

if (!empty($subkategori)) {
    $query = "SELECT * FROM lowongan WHERE subkategori = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $subkategori);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $lowongan[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekomendasi Pekerjaan - JobFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Header -->
<header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-600">JobFinder</h1>
    <nav class="space-x-4">
        <a href="rekomendasi.php" class="text-blue-600 font-bold">Rekomendasi</a>
        <a href="##" class="text-gray-700 hover:text-blue-600">Tambah lamaran</a>
        <a href="status_lamaran.php" class="text-gray-700 hover:text-blue-600">Status Lamaran</a>
        <a href="profile.php" class="text-gray-700 hover:text-blue-600">Profile</a>
        <a href="#" onclick="confirmLogout()" class="text-red-500 hover:underline">Logout</a>
    </nav>
</header>

<!-- Konten utama (form dan hasil rekomendasi) -->
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Rekomendasi Pekerjaan</h2>
    <form method="GET" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="minat" class="block font-medium mb-1">Minat Utama:</label>
                <select id="minat" name="minat" required class="w-full border rounded-md p-2">
                    <option value="">-- Pilih Minat --</option>
                    <option value="IT" <?= $minat == 'IT' ? 'selected' : '' ?>>IT</option>
                    <option value="Finance" <?= $minat == 'Finance' ? 'selected' : '' ?>>Finance</option>
                    <option value="Marketing" <?= $minat == 'Marketing' ? 'selected' : '' ?>>Marketing</option>
                </select>
            </div>
            <div>
                <label for="subkategori" class="block font-medium mb-1">Sub-Kategori:</label>
                <select id="subkategori" name="subkategori" required class="w-full border rounded-md p-2">
                    <option value="">-- Pilih Sub-Kategori --</option>
                </select>
            </div>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Cari Lowongan</button>
    </form>
</div>

<!-- Hasil Rekomendasi -->
<?php if (!empty($subkategori)): ?>
    <div class="max-w-2xl mx-auto mt-8">
        <div class="text-center text-gray-700 mb-4">
            Menampilkan lowongan untuk sub-kategori: <strong><?= htmlspecialchars($subkategori) ?></strong>
        </div>

        <?php if (count($lowongan) > 0): ?>
            <?php foreach ($lowongan as $row): ?>
                <div class="bg-white p-5 rounded-lg shadow mb-4">
                    <div class="text-lg font-semibold"><?= htmlspecialchars($row['judul']) ?></div>
                    <div class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($row['lokasi']) ?></div>
                    <a href="detail.php?id=<?php echo $row['id']; ?>&from=rekomendasi" class="text-blue-500 underline">Lihat Detail</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-gray-500 text-lg mt-6">Belum ada lowongan untuk sub-kategori ini 😢</div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<script>
    const subKategoriOptions = {
        IT: ["Software Development", "IT Support", "Data & AI"],
        Finance: ["Accounting", "Financial Planning & Analysis"],
        Marketing: ["Digital Marketing", "Creative"]
    };

    const minatSelect = document.getElementById('minat');
    const subKategoriSelect = document.getElementById('subkategori');

    function updateSubkategori() {
        const selectedMinat = minatSelect.value;
        const subKategoris = subKategoriOptions[selectedMinat] || [];

        subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub-Kategori --</option>';
        subKategoris.forEach(sub => {
            const option = document.createElement('option');
            option.value = sub;
            option.textContent = sub;
            if (sub === <?= json_encode($subkategori) ?>) option.selected = true;
            subKategoriSelect.appendChild(option);
        });
    }

    minatSelect.addEventListener('change', updateSubkategori);
    document.addEventListener('DOMContentLoaded', updateSubkategori);

    function confirmLogout() {
        if (confirm("Yakin ingin logout?")) {
            window.location.href = "logout.php";
        }
    }
</script>
</body>
</html>