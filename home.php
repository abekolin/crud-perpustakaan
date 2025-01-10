<?php

require 'connection.php';

session_start();

// Cek apakah sesi login tersedia
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('Location: login.php');
    exit();
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            background-color: #f0f0f0;
            /* warna abu-abu muda */
        }
                /* Fade-in effect for the page */


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

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .sidebar {
            transition: left 0.3s ease-in-out;
        }

        .btn-danger {
            transition: box-shadow 0.3s;
        }

        .btn-danger:hover {
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.7);
        }
    </style>
</head>

<body>
    <!-- Tombol Toggle (Hanya Muncul di Mobile) -->
    <button class="btn btn-dark d-md-none" id="sidebarToggle"
        style="position: fixed; top: 20px; left: 190px; z-index: 1000; ">
        ☰ Menu
    </button>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar" style="background-color: rgba(0, 0, 0, 0.5); z-index: 2; /* Hitam dengan transparansi 50% */
">
        <div class="nav-header">
        <img width="50" height="50" src="https://img.icons8.com/clouds/100/book.png" alt="book"/>BookSphere
        </div>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="#" style="color:whitesmoke;">
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
                    <i class="bi bi-person-lines-fill" style="font-style:normal;"> Author</i>
                    <!-- Ikon orang dengan garis -->
                </a>
            </li>
        </ul>
    </div>
    <!-- Main Content -->
    <div class="content">
        <nav class="navbar fix navbar-expand-lg navbar-dark bg-dark sticky-top" style="margin-top: -20px;
    margin-right: -20px;
    margin-left: -100%;
    z-index: 1; padding-bottom: 70px;">
        </nav>
        <div class="container mt-4 pb-4 pt-4" style="background-color:white;">
            <p style="margin-left:100px;">Selamat Datang <?= $_SESSION['username'] ?> di Halaman Utama BookSphere</p>
            <div class="container mt-5">
                <div class="container mb-4">
                    <h2>Admin BookSphere</h2>
                </div>
                <div class="border border-color mb-4"></div>
                <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
                    <!-- User Card -->
                    <div class="col">
                        <div class="card">
                            <?php $users = query("SELECT COUNT(*) AS jumlah_pengguna FROM users;"); ?>
                            <div class="card-body" style="background-color:whitesmoke;">
                                <h5 class="card-title"><img width="40" height="50"
                                        src="https://img.icons8.com/ultraviolet/40/user.png" alt="user" />
                                    <?= $users[0]['jumlah_pengguna']; ?> User</h5>
                                <a href="users.php" class="card-text text-secondary" style="text-decoration:none;">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>

                    <!-- Books Card -->
                    <div class="col">
                        <div class="card">
                            <?php $buku = query("SELECT COUNT(*) AS jumlah_buku FROM buku WHERE isdel IS NULL;"); ?>
                            <div class="card-body" style="background-color:whitesmoke;">
                                <h5 class="card-title"><img width="48" height="48"
                                        src="https://img.icons8.com/color/48/books.png" alt="books" />
                                    <?= $buku[0]['jumlah_buku'] ?> Books</h5>
                                <a href="books.php" class="card-text text-secondary" style="text-decoration:none;">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>

                    <!-- Author Card -->
                    <div class="col">
                        <div class="card">
                            <?php $penulis = query("SELECT COUNT(*) AS jumlah_penulis FROM penulis WHERE isdel IS NULL;"); ?>
                            <div class="card-body" style="background-color:whitesmoke;">
                                <h5 class="card-title"><img width="50" height="50"
                                        src="https://img.icons8.com/ios-filled/50/document-writer.png"
                                        alt="document-writer" /> <?= $penulis[0]['jumlah_penulis'] ?> Author</h5>
                                <a href="authors.php" class="card-text text-secondary"
                                    style="text-decoration:none;">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <!-- Card Slideshow -->
                    <div class="col-md-6">
                        <canvas id="grafikBuku"></canvas>
                    </div>

                    <!-- Card Introduction -->
                    <div class="col-md-6">
                        <div class="card">
                            <!-- <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Introduction Image"> -->
                            <div class="card-body">
                                <h6 class="card-header bg-success-subtle">BookSphere</h6>
                                <p class="card-text text-center">
                                    <br>
                                    <b style="font-size:smaller;">Selamat Datang di Dashboard Admin Booksphere Library</b>
                                    <br>
                                   <p style="font-size:smaller; text-align:center;">Halo <?= $_SESSION['username'] ?>, selamat datang di pusat kendali utama Booksphere
                                    Library!
                                    Di sini, Anda dapat dengan mudah mengelola berbagai aspek perpustakaan, mulai dari
                                    koleksi buku, penulis, hingga pengguna. Kami menyediakan alat yang intuitif untuk
                                    membantu Anda menjaga efisiensi pengelolaan perpustakaan serta memberikan pengalaman
                                    terbaik bagi para pengguna.
                                    </p>
                                </p>
                                <h6 class="card-footer">Introduction</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <p id="datetime"
        style="color:white; margin-top: 26px; margin-left:80%; position:absolute; position:fixed; z-index:1;"></p>
    <a href="logout.php" class="btn btn-danger"
        style="margin-left:94%; position:absolute; margin-top: 20px; position:fixed; z-index:1;">
        Logout</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="js/script.js"></script>
    <script>
        $(document).ready(function () {
            // Fungsi untuk menampilkan waktu dengan jQuery
            function updateDateTime() {
                const now = new Date();
                const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                const day = days[now.getDay()];
                const date = now.getDate();
                const month = now.getMonth() + 1;
                const year = now.getFullYear();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const seconds = now.getSeconds().toString().padStart(2, '0');

                const dateTimeString = `${day}, ${date}/${month}/${year} - ${hours}:${minutes}:${seconds}`;
                $("#datetime").text(dateTimeString);
            }
            // Perbarui waktu setiap detik
            setInterval(updateDateTime, 1000);
            updateDateTime();

            // Tombol toggle sidebar
            $("#sidebarToggle").click(function () {
                $("#sidebar").toggleClass("active");
            });
        });
    </script>

    <script>
        // Ambil data dari backend menggunakan fetch API
        fetch('getData.php')
            .then(response => response.json())
            .then(data => {
                // Pisahkan nama penulis dan jumlah buku
                const namaPenulis = data.map(item => item.nama_penulis);
                const jumlahBuku = data.map(item => item.jumlah_buku);
                // Buat grafik
                const ctx = document.getElementById('grafikBuku').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // Grafik batang
                    data: {
                        labels: namaPenulis, // Nama penulis
                        datasets: [{
                            label: 'Jumlah Buku',
                            data: jumlahBuku, // Data jumlah buku
                            backgroundColor: '#d1e7dd', // Warna latar belakang batang
                            borderColor: 'rgb(180, 180, 180)', // Warna border batang
                            borderWidth: 2, // Ketebalan border
                            borderRadius: 10, // Membulatkan sudut batang
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top', // Posisi legend
                                labels: {
                                    font: {
                                        size: 16 // Ukuran font legend
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)', // Warna tooltip
                                titleColor: '#fff', // Warna judul tooltip
                                bodyColor: '#fff', // Warna teks tooltip
                                padding: 10 // Padding tooltip
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    font: {
                                        size: 14 // Ukuran font pada sumbu X
                                    },
                                    autoSkip: false // Mencegah pemotongan label
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    font: {
                                        size: 14 // Ukuran font pada sumbu Y
                                    }
                                }
                            }
                        }
                    }
                });
            })
    </script>


</body>

</html>