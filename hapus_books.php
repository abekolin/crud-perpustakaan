<?php 

require 'connection.php';

$id = $_GET["id"];

if(hapusbooks($id) > 0){
    echo"
    <script>
    alert('data berhasil dihapus!');
    document.location.href = 'books.php';
    </script>
    ";
}else{
    echo"
    <script>
     alert('data gagal dihapus!');
      document.location.href = 'books.php';
     </script>
    ";
}
?>