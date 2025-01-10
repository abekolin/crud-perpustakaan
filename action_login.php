<?php

require 'connection.php';
session_start();

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND active = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['username'] = ucfirst($_SESSION['username']);

            header('Location: home.php');
            exit();
        } else {
            echo "<script>alert('Password salah!');
            window.location.href = 'login.php';
            </script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');
         window.location.href = 'login.php';</script>";
    }

    $conn->close();
}
