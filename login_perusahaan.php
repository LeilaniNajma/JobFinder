<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM perusahaan_profiles WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        if (password_verify($password, $data['password'])) {
            // Simpan data login ke session sesuai struktur tabel
            $_SESSION['perusahaan_id'] = $data['user_id']; // pastikan kolomnya emang 'user_id'
            $_SESSION['nama_perusahaan'] = $data['nama_perusahaan'];
            $_SESSION['email_perusahaan'] = $data['email'];

            header("Location: dashboard_perusahaan.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perusahaan - JobFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4 text-center text-blue-600">Login Perusahaan</h2>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Email Perusahaan *</label>
                <input type="email" name="email" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label class="block text-sm font-medium">Password *</label>
                <input type="password" name="password" required class="w-full border p-2 rounded">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Login</button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-center mt-4 text-sm">Belum punya akun? <a href="registrasi_perusahaan.php" class="text-blue-600 hover:underline">Daftar Sekarang</a></p>
        </div>
    </div>
</body>
</html>
