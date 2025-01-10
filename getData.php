<?php

require 'connection.php';

// Query untuk jumlah buku per penulis
$sql = "SELECT penulis.nama AS nama_penulis, COUNT(buku.id_buku) AS jumlah_buku
    FROM buku
    JOIN penulis ON buku.id_penulis = penulis.id_penulis
    WHERE 
    buku.isdel IS NULL
    GROUP BY penulis.id_penulis 
    ORDER BY jumlah_buku DESC 
";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Kembalikan data sebagai JSON
echo json_encode($data);
$conn->close();
?>
