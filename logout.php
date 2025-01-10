<?php
session_start();
session_unset();  // Menghapus semua data session
session_destroy();  // Menghancurkan session
header('Location: login.php');  // Arahkan ke halaman login setelah logout
exit();
