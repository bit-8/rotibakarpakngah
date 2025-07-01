<?php
session_start();
require 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    
    if (password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        header("Location: dasboard.html");
    } else {
        echo "Password salah. <a href='index.html'>Coba lagi</a>";
    }
} else {
    echo "Username tidak ditemukan. <a href='index.html'>Coba lagi</a>";
}

$stmt->close();
$conn->close();
?>
