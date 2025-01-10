<?php 

echo md5('abe123'.rand().date("H:i:s"));

echo "<br>";

echo sha1('abe123');

echo "<br>";


$password = 'abekolin2854';

// Hash password menggunakan PASSWORD_DEFAULT
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Tampilkan hasil hash
echo "Password asli: $password<br>";
echo "Password hash: $hashed_password<br>";

?>