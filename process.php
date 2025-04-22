<?php
include 'config.php';
session_start();

// Cek session perusahaan
if (!isset($_SESSION['perusahaan_id'])) {
  echo "<script>alert('Session perusahaan tidak ditemukan. Silakan login kembali.'); window.location.href='login_perusahaan.php';</script>";
  exit;
}

$perusahaan_id = intval($_SESSION['perusahaan_id']); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
  $judul = mysqli_real_escape_string($conn, $_POST['judul']);
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
  $subkategori = mysqli_real_escape_string($conn, $_POST['subkategori']);
  $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

  // Validasi input kosong
  if (empty($judul) || empty($kategori) || empty($subkategori) || empty($lokasi) || empty($deskripsi)) {
    echo "<script>alert('Semua field wajib diisi!'); history.back();</script>";
    exit;
  }

  if ($id > 0) {
    // UPDATE lowongan perusahaan (hanya milik perusahaan yang bersangkutan)
    $query = "UPDATE lowongan 
              SET judul='$judul', kategori='$kategori', subkategori='$subkategori', lokasi='$lokasi', deskripsi='$deskripsi' 
              WHERE id=$id AND perusahaan_id=$perusahaan_id";
  } else {
    // INSERT baru ke lowongan dengan perusahaan_id
    $query = "INSERT INTO lowongan (judul, kategori, subkategori, lokasi, deskripsi, perusahaan_id) 
              VALUES ('$judul', '$kategori', '$subkategori', '$lokasi', '$deskripsi', $perusahaan_id)";
  }

  if (mysqli_query($conn, $query)) {
    header("Location: dashboard_perusahaan.php");
  } else {
    echo "<script>alert('Gagal menyimpan data.'); history.back();</script>";
  }
} else {
  header("Location: dashboard_perusahaan.php");
  exit;
}
?>
