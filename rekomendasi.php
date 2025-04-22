<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekomendasi Pekerjaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 600px;
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
    </style>
</head>
<body>

<div class="card">
    <h2>Rekomendasi Pekerjaan</h2>
    <form action="hasil_rekomendasi.php" method="GET">
        <div class="form-group">
            <div>
                <label for="minat">Minat Utama:</label>
                <select id="minat" name="minat" required>
                    <option value="">-- Pilih Minat --</option>
                    <option value="IT">IT</option>
                    <option value="Finance">Finance</option>
                    <option value="Marketing">Marketing</option>
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

<script>
    const subKategoriOptions = {
        IT: ["Software Development", "IT Support", "Data & AI"],
        Finance: ["Accounting", "Financial Planning & Analysis"],
        Marketing: ["Digital Marketing", "Creative"]
    };

    const minatSelect = document.getElementById('minat');
    const subKategoriSelect = document.getElementById('subkategori');

    minatSelect.addEventListener('change', function () {
        const selectedMinat = this.value;
        const subKategoris = subKategoriOptions[selectedMinat] || [];

        // Reset sub-kategori
        subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub-Kategori --</option>';

        // Tambahkan sub-kategori yang sesuai
        subKategoris.forEach(sub => {
            const option = document.createElement('option');
            option.value = sub;
            option.textContent = sub;
            subKategoriSelect.appendChild(option);
        });
    });
</script>

</body>
</html>
