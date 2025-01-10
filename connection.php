<?php 

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "library");

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

// Fungsi tambah data
function tambah($data){
    global $conn;

    // Cek apakah sesi sudah dimulai dan user_id ada
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('User belum login');</script>";
        return false;
    }

    $penulis = htmlspecialchars($data["nama"]);
    $asal = htmlspecialchars($data["asal"]);  // Anggap asal adalah string
    $tanggal_lahir = htmlspecialchars($data['tanggal_lahir']);
    $createdby = $_SESSION['user_id'];

    // Upload gambar
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    // Prepared statement untuk menghindari SQL Injection
    $query = "INSERT INTO penulis (nama, asal, tanggal_lahir, gambar, created_by, created_at, updated_by, updated_at, deleted_by, deleted_at) 
              VALUES (?, ?, ?, ?, ?, NOW(), NULL, NULL, NULL, NULL)";
    
    // Persiapkan statement
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
        echo "<script>alert('Gagal menyiapkan query SQL.');</script>";
        return false;
    }

    // Bind parameter dan eksekusi statement
    mysqli_stmt_bind_param($stmt, "sssss", $penulis, $asal, $tanggal_lahir, $gambar, $createdby);
    mysqli_stmt_execute($stmt);

    // Cek apakah data berhasil ditambahkan
    if(mysqli_affected_rows($conn) > 0){
        return true;
    } else {
        return false;
    }
}

// Fungsi upload gambar
function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
        return false;
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.',$namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>alert('Yang Anda upload bukan gambar!');</script>";
        return false;
    }

    // Cek jika ukuran gambar terlalu besar
    if($ukuranFile > 1000000){
        echo "<script>alert('Ukuran gambar terlalu besar!');</script>";
        return false;
    }

    // Lolos pengecekan, gambar siap diupload
    // Generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.' . $ekstensiGambar;

    // Pindahkan gambar ke direktori
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}
function hapus($id) {
    global $conn;

    session_start();

    $deleted_by =  $_SESSION['user_id']; // Ganti dengan ID pengguna yang melakukan penghapusan (misalnya, ID pengguna yang login)
    $deleted_at = date("Y-m-d H:i:s"); // Menyimpan waktu penghapusan

    // Query untuk memperbarui data (soft delete)
    $query = "UPDATE penulis SET
                deleted_by = $deleted_by,
                deleted_at = '$deleted_at',
                isdel = 1
              WHERE id_penulis = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
// fungsi update
function ubah($data){
    global $conn;

    session_start();

    $id = $data["id_penulis"];
    $updatedby = $_SESSION['user_id'];
    $penulis = htmlspecialchars($data["nama"]);
    $asal = htmlspecialchars($data["asal"]);  // Anggap asal adalah string
    $tanggal_lahir = htmlspecialchars($data['tanggal_lahir']);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    }else{
        $gambar = upload();
    }

    // query update data
    $query = "UPDATE penulis SET
               nama = '$penulis',
                asal = '$asal',
                tanggal_lahir = '$tanggal_lahir',
                gambar = '$gambar',
                updated_by = $updatedby,
                updated_at = NOW()
                   WHERE id_penulis = $id               
               ";

mysqli_query($conn, $query);

return mysqli_affected_rows($conn);
}
// Fungsi tambah data
function tambahbooks($data){
    global $conn;

    // Cek apakah sesi sudah dimulai dan user_id ada
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('User belum login');</script>";
        return false;
    }

    $judul = htmlspecialchars($data["judul"]);
    $genre = htmlspecialchars($data["genre"]);  // Anggap asal adalah string
    $tahun = htmlspecialchars($data['tahun_terbit']);
    $id_penulis = htmlspecialchars($data['id_penulis']);
    $createdby = $_SESSION['user_id'];

    // Upload gambar
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    // Prepared statement untuk menghindari SQL Injection
    $query = "INSERT INTO buku (judul, genre, tahun, gambar, id_penulis, created_by, created_at, updated_by, updated_at, deleted_by, deleted_at) 
              VALUES (?, ?, ?, ?, ?, ?, NOW(), NULL, NULL, NULL, NULL)";
    
    // Persiapkan statement
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
        echo "<script>alert('Gagal menyiapkan query SQL.');</script>";
        return false;
    }

    // Bind parameter dan eksekusi statement
    mysqli_stmt_bind_param($stmt, "ssssss", $judul, $genre, $tahun, $gambar, $id_penulis,  $createdby);
    mysqli_stmt_execute($stmt);

    // Cek apakah data berhasil ditambahkan
    if(mysqli_affected_rows($conn) > 0){
        return true;
    } else {
        return false;
    }
}
function hapusbooks($id) {
    global $conn;

    session_start();

    $deleted_by =  $_SESSION['user_id']; // Ganti dengan ID pengguna yang melakukan penghapusan (misalnya, ID pengguna yang login)
    $deleted_at = date("Y-m-d H:i:s"); // Menyimpan waktu penghapusan

    // Query untuk memperbarui data (soft delete)
    $query = "UPDATE buku SET
                deleted_by = $deleted_by,
                deleted_at = '$deleted_at',
                isdel = 1
              WHERE id_buku = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function ubahbooks($data) {
    global $conn;

    session_start();

    // Ambil data dari POST
    $id_buku = $data["id_buku"];
    $updated_by = $_SESSION ['user_id'];
    $judul = htmlspecialchars($data["judul"]);
    $genre = htmlspecialchars($data["genre"]);
    $tahun = htmlspecialchars($data["tahun"]);
    $id_penulis = $data["id_penulis"];
    $gambar = $_FILES["gambar"]["name"];

    // Jika ada gambar baru, upload gambar terlebih dahulu
    if ($gambar) {
        $gambar_tmp = $_FILES["gambar"]["tmp_name"];
        $gambar_path = "img/" . $gambar;
        move_uploaded_file($gambar_tmp, $gambar_path);
    } else {
        $gambar = $data["gambarLama"];  // Menggunakan gambar lama jika tidak ada gambar baru
    }

    // Update data buku
    $query = "UPDATE buku SET 
        judul = '$judul',
        genre = '$genre',
        tahun = '$tahun',
        id_penulis = '$id_penulis',
        gambar = '$gambar',
        updated_by = $updated_by,
        updated_at = NOW()
        WHERE id_buku = $id_buku";

    // Jalankan query dan cek apakah berhasil
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);  // Akan mengembalikan jumlah baris yang terpengaruh
    } else {
        return 0;  // Jika ada error, kembalikan 0
    }
}


?>
