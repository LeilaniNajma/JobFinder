<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Rekomendasi Pekerjaan</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 80%;
      max-width: 700px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }
    .row {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    .column {
      flex: 1;
      min-width: 200px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      color: #444;
    }
    select, button {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    button {
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
      margin-top: 10px;
    }
    button:hover {
      background-color: #0056b3;
    }
    .job-card {
      background-color: #f1f3f5;
      margin-top: 15px;
      padding: 15px;
      border-radius: 10px;
    }
    .job-card h3 {
      margin: 0 0 5px;
    }
    .job-card p {
      margin: 0;
    }
  </style>
</head>
<body>

<?php
$minat = $_GET['minat'] ?? '';
$sub = $_GET['sub'] ?? '';
?>

<div class="container">
  <h1>Rekomendasi Pekerjaan</h1>

  <!-- FORM -->
  <form method="GET" action="rekomendasi.php">
    <div class="row">
      <div class="column">
        <label for="minat">Minat Utama:</label>
        <select name="minat" id="minat" onchange="updateSubKategori()">
          <option value="">-- Pilih Minat --</option>
          <option value="IT" <?= $minat == 'IT' ? 'selected' : '' ?>>IT</option>
          <option value="Keuangan" <?= $minat == 'Keuangan' ? 'selected' : '' ?>>Keuangan</option>
        </select>
      </div>
      <div class="column">
        <label for="sub">Sub-Kategori:</label>
        <select name="sub" id="sub">
          <option value="">-- Pilih Sub-Kategori --</option>
        </select>
      </div>
    </div>

    <button type="submit">Cari Lowongan</button>
  </form>

  <!-- HASIL -->
  <?php
  include 'config.php'; // koneksi DB

  if ($minat && $sub) {
    $query = "SELECT * FROM lowongan WHERE kategori='$minat' AND sub_kategori='$sub'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='job-card'>";
        echo "<h3>" . htmlspecialchars($row['judul']) . "</h3>";
        echo "<p><strong>Lokasi:</strong> " . htmlspecialchars($row['lokasi']) . "</p>";
        echo "<p><strong>Perusahaan:</strong> " . htmlspecialchars($row['perusahaan']) . "</p>";
        echo "</div>";
      }
    } else {
      echo "<p style='margin-top: 20px;'>Tidak ada lowongan yang cocok.</p>";
    }
  }
  ?>
</div>

<!-- JAVASCRIPT -->
<script>
  const subKategori = {
    IT: ["Web Developer", "UI/UX Designer", "Front-End", "Back-End"],
    Keuangan: ["Akuntan", "Auditor", "Analis Keuangan"]
  };

  function updateSubKategori() {
    const minat = document.getElementById("minat").value;
    const sub = document.getElementById("sub");
    const selected = "<?= $sub ?>";

    sub.innerHTML = '<option value="">-- Pilih Sub-Kategori --</option>';

    if (subKategori[minat]) {
      subKategori[minat].forEach(item => {
        const opt = document.createElement("option");
        opt.value = item;
        opt.text = item;
        if (item === selected) opt.selected = true;
        sub.appendChild(opt);
      });
    }
  }

  // Jalankan saat halaman pertama kali dibuka
  window.onload = updateSubKategori;
</script>

</body>
</html>
