<?php

require 'connection.php';

// ambil data di URL
$id = $_GET["id"];

// query data buku berdasarkan id
$books = query("SELECT * FROM buku WHERE id_buku = $id")[0];

// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

    //cek apakah data berhasil diubah  atau tidak 
    if (ubahbooks($_POST) > 0) {
        echo "
        <script>
        alert('data berhasil diubah!');
        document.location.href = 'books.php';
        </script>
        ";
    } else {
        echo "
        <script>
         alert('data gagal diubah!');
          document.location.href = 'books.php';
         </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #f0f0f0;
            /* warna abu-abu muda */
        }

        @media (max-width: 768px) {
            nav {
                z-index: 1 !important;
            }

            #datetime {
                margin-top: 28px;
                margin-left: 3% !important;
                position: absolute !important;
                z-index: 2 !important;
                position: fixed !important;

            }

            a.btn.btn-danger {
                margin-left: 80% !important;
                position: absolute !important;
                margin-top: 20px !important;
                z-index: 2 !important;
                position: fixed !important;
            }

            button.btn.btn-dark {
                margin-left: 100px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 250px;
            }

        }

        .color {
            color: #f0f0f0;

        }
    </style>
</head>

<body>
    <!-- Tombol Toggle (Hanya Muncul di Mobile) -->
    <button class="btn btn-dark d-md-none" id="sidebarToggle" style="position: fixed; top: 20px; left: 190px; z-index: 1000; ">
        ☰ Menu
    </button>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar" style="background-color: rgba(0, 0, 0, 0.5); z-index:2;/* Hitam dengan transparansi 50% */
">
        <div class="nav-header">
        <img width="50" height="50" src="https://img.icons8.com/clouds/100/book.png" alt="book"/>BookSphere
        </div>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="home.php" style="color:whitesmoke;">
                    <i class="bi bi-house" style="font-style:normal;"> Dashboard</i>
                </a>
            </li>
            <li class="nav-item mt-auto">
                <a class="nav-link" href="users.php" style="color:whitesmoke;">
                    <i class="bi bi-people" style="font-style:normal;"> Users</i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="books.php" style="color:whitesmoke;">
                    <i class="bi bi-book" style="font-style:normal;"> Books</i>
                </a>
            </li>
            <li class="nav-item mt-auto">
                <a class="nav-link" href="authors.php" style="color:whitesmoke;">
                    <i class="bi bi-person-lines-fill" style="font-style:normal;"> Author</i> <!-- Ikon orang dengan garis -->
                </a>
            </li>
        </ul>
    </div>
    <!-- Main Content -->
    <div class="content">
        <nav class="navbar fix navbar-expand-lg navbar-dark bg-dark sticky-top"
            style="margin-top: -20px;
    margin-right: -20px;
    margin-left: -100%;
    z-index: 1; padding-bottom: 70px;">
            <!-- <p id="datetime" style="margin-left:94%;"></p> -->
        </nav>
        <div class="container mt-4 pb-4 pt-4" style="background-color:white;">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-header">Edit Data Buku</h6>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_buku" value="<?= $books["id_buku"] ?>">
                        <input type="hidden" name="gambarLama" value="<?= $books["gambar"] ?>">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-md-6">
                                    <!-- b$books -->
                                    <style>
                                        input.form-control {
                                            width: 205%;
                                        }
                                        @media(max-width:768px){
                                            input.form-control {
                                            width: 100%;
                                        }
                                        }
                                    </style>
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" name="judul" id="judul" class="form-control" required value="<?= $books['judul'] ?>">
                                    </div>

                                    <!-- Asal -->
                                    <div class="mb-3">
                                        <label for="genre" class="form-label">Genre</label>
                                        <input type="text" name="genre" id="genre" class="form-control" required value="<?= $books['genre'] ?>">
                                    </div>

                                    <!-- Tanggal Lahir -->
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun Terbit</label>
                                        <input type="text" name="tahun" id="tahun" class="form-control" required value="<?= $books['tahun'] ?>">
                                    </div>

                                    <!-- Tanggal Lahir -->
                                    <div class="mb-3">
                                        <label for="penulis" class="form-label">Penulis</label>
                                        <select class="form-select" name="id_penulis" id="penulis" style="width:auto;">
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM penulis where isdel is null");
                                            while ($row = mysqli_fetch_assoc($result)) :
                                            ?>
                                                <option value="<?= $row['id_penulis'] ?>" <?= $row['id_penulis'] == $books['id_penulis'] ? 'selected' : '' ?>><?= $row['nama'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <!-- Gambar -->
                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <img src="img/<?= $books['gambar'] ?>" alt="" width="100" height="100"><br>
                                        <br>
                                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-start">
                                        <a href="books.php" class="btn btn-danger">Batal</a>&nbsp;
                                        <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <p id="datetime" style="color:white; margin-top: 26px; margin-left:83.5%; position:absolute; position:fixed; z-index:2;"></p>
    <a href="logout.php" class="btn btn-danger" style="margin-left:94%; position:absolute; margin-top: 20px; position:fixed; z-index:2;"> Logout</a>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        });

        function updateDateTime() {
            // Membuat objek tanggal dan waktu
            const now = new Date();

            // Array nama hari
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

            // Format tanggal (DD/MM/YYYY)
            const day = days[now.getDay()];
            const date = now.getDate();
            const month = now.getMonth() + 1; // Bulan dimulai dari 0
            const year = now.getFullYear();

            // Gabungkan semuanya
            const dateTimeString = `Today : ${date} - ${month} - ${year}`;

            // Menampilkan waktu dan tanggal di elemen dengan id "datetime"
            document.getElementById("datetime").textContent = dateTimeString;
        }

        // Update waktu setiap detik
        setInterval(updateDateTime, 1000);
        // Memanggil fungsi agar waktu langsung muncul saat pertama kali halaman dibuka
        updateDateTime();
    </script>
</body>

</html>