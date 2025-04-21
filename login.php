<?php
session_start();
include 'config.php';

// Jika sudah login, arahkan ke dashboard sesuai tipe
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['tipe'] === 'perusahaan') {
        header('Location: dashboard_perusahaan.php');
    } else {
        header('Location: dashboard.php');
    }
    exit;
}

// Saat form login dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query  = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama']    = $user['nama'] ?? '';
            $_SESSION['tipe']    = $user['tipe'] ?? 'user'; // fallback kalau kolom kosong

            // Redirect sesuai tipe user
            if ($_SESSION['tipe'] === 'perusahaan') {
                header('Location: dashboard_perusahaan.php');
            } else {
                header('Location: dashboard.php');
            }
            exit;
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Email tidak ditemukan!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Login - JobFinder</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Login</h2>
    
    <?php if (!empty($error)): ?>
      <div class="text-red-600 mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium">Email</label>
        <input
          type="email"
          name="email"
          id="email"
          required
          class="w-full px-3 py-2 border rounded"
        >
      </div>
      <div>
        <label for="password" class="block text-sm font-medium">Password</label>
        <input
          type="password"
          name="password"
          id="password"
          required
          class="w-full px-3 py-2 border rounded"
        >
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        Masuk
      </button>
    </form>
    <p class="text-sm text-center mt-4">
      Belum punya akun?
      <a href="daftar.php" class="text-blue-600 hover:underline">Daftar</a>
    </p>
  </div>
</body>
</html>
