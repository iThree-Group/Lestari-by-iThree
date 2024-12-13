<?php
include('../controller/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi user ID
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Anda harus login terlebih dahulu.');</script>";
        exit;
    }

    // Ambil data dari form
    $user_id = $_SESSION['user_id'];
    $product_name = htmlspecialchars(trim($_POST['marketplace_product_name']));
    $product_price = filter_var($_POST['marketplace_price'], FILTER_VALIDATE_FLOAT);
    $product_stock = filter_var($_POST['marketplace_stock'], FILTER_VALIDATE_INT);
    $product_description = htmlspecialchars(trim($_POST['marketplace_description']));

    // Validasi input
    if (!$product_price || !$product_stock) {
        echo "<script>alert('Harga dan stok harus berupa angka.');</script>";
        exit;
    }

    // Direktori untuk menyimpan gambar
    $target_dir = "../images/user/products/";
    
    // Buat direktori jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Penamaan file unik
    $file_name = uniqid() . "_" . basename($_FILES["marketplace_image"]["name"]);
    $target_file = $target_dir . $file_name;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi tipe file
    $allowed_types = array("jpg", "jpeg", "png", "gif");
    if (!in_array($image_file_type, $allowed_types)) {
        echo "<script>alert('Format file gambar tidak valid. Hanya JPG, JPEG, PNG, dan GIF diperbolehkan.');
        window.location.href = '../user/marketplace/upload.php';</script>";
        exit;
    }
    
    
    // Batas ukuran file (contoh: 2MB)
    $max_file_size = 2 * 1024 * 1024; // 2MB
    if ($_FILES["marketplace_image"]["size"] > $max_file_size) {
        echo "<script>alert('Ukuran file terlalu besar. Maksimal 2MB.');
        window.location.href = '../user/marketplace/upload.php';</script>";
        exit;
    }

    // Proses upload file
    if (!move_uploaded_file($_FILES["marketplace_image"]["tmp_name"], $target_file)) {
        echo "<script>alert('Gagal mengupload file. Periksa izin folder.');
        window.location.href = '../user/marketplace/upload.php';</script>";
        exit;
    }

    // Simpan data ke database
    $sql = "INSERT INTO marketplace (marketplace_id, user_id, marketplace_product_name, marketplace_description, marketplace_price, marketplace_stock, marketplace_image, marketplace_created_at, marketplace_updated_at) 
            VALUES (NULL, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("isssis", $user_id, $product_name, $product_description, $product_price, $product_stock, $file_name);
        if ($stmt->execute()) {
            echo "<script>alert('Produk berhasil diupload!');</script>";
            header("Location: ../user/marketplace/marketplace.php");
            exit;
        } else {
            echo "<script>alert('Database Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database Error: " . $conn->error . "');</script>";
    }
}
?>
