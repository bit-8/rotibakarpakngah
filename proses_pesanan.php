<?php
$koneksi = new mysqli("localhost", "root", "", "rotilog");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$nama = $_POST['nama'];
$jumlah = $_POST['jumlah'];
$catatan = $_POST['catatan'];
$total = $jumlah * 500;

$sql = "INSERT INTO pemesanan (nama_pemesan, jumlah_roti, total_harga, catatan)
        VALUES ('$nama', $jumlah, $total, '$catatan')";

if ($koneksi->query($sql) === TRUE) {
    header("Location: sukses.php");
    exit();
} else {
    echo "Gagal menyimpan: " . $koneksi->error;
}

$koneksi->close();
?>
