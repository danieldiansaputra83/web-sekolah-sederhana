<?php
session_start();
session_destroy(); // Hancurkan semua data sesi
header("location:index.php"); // Kembalikan ke halaman login
?>