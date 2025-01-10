<?php

session_start();

// Cegah pengguna yang sudah login mengakses halaman ini
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    header('Location: home.php');
    exit();
}

// Cegah caching halaman login
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header("Pragma: no-cache");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
    <style>
        body {
            background-image: url('img/library.avif');
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>
    <form action="action_login.php" method="post">
        <div class="login-container text-light" style="background-color: rgba(0, 0, 0, 0.5);">
            <h2 class="login-title" style="margin-left:-20px; color:white;"><img width="100" height="100" src="https://img.icons8.com/clouds/100/book.png" alt="book"/><b style="font-weight:lighter;">Login!</b></h2>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" id="username" class="form-control" name="username" placeholder="Enter your username" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" required>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-dark">Login</button>
            </div>
        </div>
    </form>
</body>

</html>