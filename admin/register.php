<?php
session_start();
include('../config/db_connection.php'); // Pastikan file koneksi database benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_email = trim($_POST['admin_email']);
    $admin_password = trim($_POST['admin_password']);
    $bank_id = 1; // Nilai default untuk bank_id, sesuaikan dengan kebutuhan

    // Validasi email
    if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } else {
        // Hash password untuk keamanan
        $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

        // Cek apakah email sudah terdaftar
        $stmt = $conn->prepare("SELECT admin_email FROM admin WHERE admin_email = ?");
        $stmt->bind_param("s", $admin_email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // Simpan data admin baru ke dalam database
            $stmt->close(); // Tutup statement sebelumnya
            $stmt = $conn->prepare("INSERT INTO admin (admin_email, admin_password, bank_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $admin_email, $hashed_password, $bank_id);

            if ($stmt->execute()) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Terjadi kesalahan saat registrasi: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
</head>
<body>
    <h2>Registrasi Admin</h2>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <?php if (isset($success)) { echo "<p style='color:green;'>$success</p>"; } ?>
    <form action="register.php" method="POST">
        <label for="admin_email">Email:</label>
        <input type="email" id="admin_email" name="admin_email" required><br><br>
        
        <label for="admin_password">Password:</label>
        <input type="password" id="admin_password" name="admin_password" required><br><br>
        
        <button type="submit">Register</button>
    </form>
</body>
</html>

