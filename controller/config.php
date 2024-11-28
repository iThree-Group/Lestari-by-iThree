<?php
$host = 'localhost';        // Alamat host database
$username = 'admin';         // Username untuk login ke database
$password = 'admin';             // Password untuk login ke database
$dbname = 'db_sampah_2';    // Nama database Anda

// Mengaktifkan laporan kesalahan untuk koneksi mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Cek koneksi
$conn = new mysqli($host, $username, $password, $dbname);

try {
    // Cek apakah koneksi berhasil
    if ($conn->connect_error) {
        // Jika koneksi gagal, akan memunculkan pesan error
        throw new Exception("Koneksi gagal: " . $conn->connect_error);
    } 
    // Jika koneksi berhasil, tidak menampilkan pesan di produksi
    // echo "Koneksi berhasil!";
} catch (Exception $e) {
    // Menampilkan error jika koneksi gagal
    die("Terjadi kesalahan saat menghubungkan ke database: " . $e->getMessage());
}

// Tutup koneksi setelah penggunaan
// $conn->close();
?>
