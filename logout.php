<?php
session_start();
session_unset(); // menghapus semua data sesi
session_destroy(); // menghancurkan sesi

// redirect ke halaman homepage
header("Location: index.php");
exit;
?>
