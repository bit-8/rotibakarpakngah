<?php
$host = "localhost";
$user = "root";
$pass = ""; // Ganti jika password root kamu di phpMyAdmin tidak kosong
$dbname = "rotilog";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
