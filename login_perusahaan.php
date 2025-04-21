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
            $_SESSION['perusahaan_id'] = $data['user_id']; // <-- user_id sesuai tabel
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
