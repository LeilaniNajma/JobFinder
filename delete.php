<?php
include 'config.php';

// Cek apakah ID tersedia di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Hapus data berdasarkan ID
    $query = "DELETE FROM lowongan WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Lowongan berhasil dihapus.'); window.location.href='dashboard_perusahaan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus lowongan.'); window.location.href='dashboard_perusahaan.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan.'); window.location.href='dashboard_perusahaan.php';</script>";
}?>
