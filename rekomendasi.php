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
    <title>Rekomendasi Pekerjaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            padding: 40px;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 600px;
            margin: 0 auto 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .form-group {
            display: flex;
            gap: 20px;
        }

        .form-group > div {
            flex: 1;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .results {
            max-width: 600px;
            margin: 0 auto;
        }

        .lowongan-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 12px rgba(0,0,0,0.05);
        }

        .judul {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .lokasi {
            color: #333;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .lihat-detail {
            color: #007bff;
            text-decoration: none;
        }

        .lihat-detail:hover {
            text-decoration: underline;
        }

        .kosong {
            text-align: center;
            color: gray;
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Rekomendasi Pekerjaan</h2>
    <form method="GET">
        <div class="form-group">
            <div>
                <label for="minat">Minat Utama:</label>
                <select id="minat" name="minat" required>
                    <option value="">-- Pilih Minat --</option>
                    <option value="IT" <?= $minat == 'IT' ? 'selected' : '' ?>>IT</option>
                    <option value="Finance" <?= $minat == 'Finance' ? 'selected' : '' ?>>Finance</option>
                    <option value="Marketing" <?= $minat == 'Marketing' ? 'selected' : '' ?>>Marketing</option>
                </select>
            </div>
            <div>
                <label for="subkategori">Sub-Kategori:</label>
                <select id="subkategori" name="subkategori" required>
                    <option value="">-- Pilih Sub-Kategori --</option>
                </select>
            </div>
        </div>
        <button type="submit">Cari Lowongan</button>
    </form>
</div>

<!-- Hasil Rekomendasi -->
<?php if ($subkategori): ?>
    <div class="results">
        <div class="subinfo" style="text-align:center; margin-bottom:20px;">
            Menampilkan lowongan untuk sub-kategori: <strong><?= htmlspecialchars($subkategori) ?></strong>
        </div>

        <?php if (count($lowongan) > 0): ?>
            <?php foreach ($lowongan as $row): ?>
                <div class="lowongan-card">
                    <div class="judul"><?= htmlspecialchars($row['judul']) ?></div>
                    <div class="lokasi"><?= htmlspecialchars($row['lokasi']) ?></div>
                    <a class="lihat-detail" href="detail.php?id=<?= $row['id'] ?>">Lihat Detail</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="kosong">Belum ada lowongan untuk sub-kategori ini 😢</div>
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
            if (sub === "<?= $subkategori ?>") option.selected = true;
            subKategoriSelect.appendChild(option);
        });
    }

    minatSelect.addEventListener('change', updateSubkategori);
    document.addEventListener('DOMContentLoaded', updateSubkategori);
</script>

</body>
</html>


