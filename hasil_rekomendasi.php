<?php
include 'config.php';

$subkategori = $_GET['subkategori'] ?? '';

// Query berdasarkan sub-kategori saja
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
    <title>Hasil Rekomendasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
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
            font-size: 18px;
        }

        .posisi {
            color: #007bff;
            margin-top: 5px;
        }

        .kosong {
            text-align: center;
            color: gray;
            margin-top: 50px;
        }

        a.kembali {
            display: inline-block;
            margin-top: 30px;
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

<h2>Lowongan untuk Sub-Kategori: <?= htmlspecialchars($subkategori) ?></h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="lowongan-card">
            <div class="judul"><?= htmlspecialchars($row['judul']) ?></div>
            <div class="posisi">Posisi: <?= htmlspecialchars($row['posisi']) ?></div>
            <p><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="kosong">Belum ada lowongan untuk sub-kategori ini 😢</div>
<?php endif; ?>

<div style="text-align: center;">
    <a href="rekomendasi.php" class="kembali">← Kembali ke Form</a>
</div>

</body>
</html>
