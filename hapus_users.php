<?php
require 'connection.php';
session_start();

// Cek apakah user login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Cek apakah parameter ID ada
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: home.php');
    exit();
}

$id = intval($_GET['id']);
$delete = mysqli_query($conn, "DELETE FROM users WHERE id = $id");

if ($delete) {
    echo "<script>alert('Data berhasil dihapus!'); window.location.href='home.php';</script>";
} else {
    echo "<script>alert('Data gagal dihapus!'); window.location.href='home.php';</script>";
}
?>
