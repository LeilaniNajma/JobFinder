<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email sudah digunakan!');</script>";
    } else {
        $query = "INSERT INTO users (nama, email, password) 
                  VALUES ('$nama', '$email', '$password')";
        if (mysqli_query($conn, $query)) {
            $user_id = mysqli_insert_id($conn);
            $_SESSION['user_id'] = $user_id;
            $_SESSION['nama']    = $nama;

            echo "<script>alert('Registrasi berhasil!'); window.location.href='profile.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pencari Kerja - JobFinder</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <form method="POST" class="bg-white p-6 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-4 text-center text-blue-600">Daftar Akun</h2>

    <label class="block mb-2">Nama Lengkap</label>
    <input type="text" name="nama" required class="w-full p-2 border rounded mb-4">

    <label class="block mb-2">Email</label>
    <input type="email" name="email" required class="w-full p-2 border rounded mb-4">

    <label class="block mb-2">Password</label>
    <input type="password" name="password" required class="w-full p-2 border rounded mb-4">

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full hover:bg-blue-700 transition">Daftar</button>

    <p class="text-center mt-4 text-sm">Sudah punya akun? <a href="login.php" class="text-blue-600 hover:underline">Login</a></p>
  </form>
</body>
</html>
