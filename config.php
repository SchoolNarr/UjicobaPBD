<?php
$host = "localhost";  // Sesuaikan dengan host Anda
$user = "root";       // Ganti jika ada username lain
$password = "";       // Ganti jika ada password
$dbname = "rentalkendaraan";  // Nama database Anda

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
