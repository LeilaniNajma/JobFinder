<?php
include 'config.php';

$subkategori = $_GET['subkategori'] ?? '';

// Query berdasarkan sub-kategori
$query = "SELECT * FROM lowongan WHERE subkategori = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $subkategori);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Rekomendasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            padding: 40px;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .subinfo {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .lowongan-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 0 auto 20px;
            max-width: 600px;
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
            margin-top: 50px;
            font-size: 18px;
        }

        a.kembali {
            display: inline-block;
            margin-top: 40px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
        }

        a.kembali:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Daftar Rekomendasi</h2>
<div class="subinfo">Menampilkan lowongan untuk sub-kategori: <strong><?= htmlspecialchars($subkategori) ?></strong></div>

<!-- Hasil Lowongan -->
<div class="results">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="lowongan-card">
                <div class="judul"><?= htmlspecialchars($row['judul']) ?></div>
                <div class="lokasi"><?= htmlspecialchars($row['lokasi']) ?></div>
                <a class="lihat-detail" href="detail.php?id=<?= $row['id'] ?>">Lihat Detail</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="kosong">Belum ada lowongan untuk sub-kategori ini 😢</div>
    <?php endif; ?>
</div>

<div style="text-align: center;">
    <a href="rekomendasi.php" class="kembali">← Kembali ke Form</a>
</div>

</body>
</html>
