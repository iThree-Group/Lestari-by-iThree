<?php
session_start();  // Memulai sesi

require '../controller/config.php';  // File koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Email dan password harus diisi!";
        exit;
    }

    // Query untuk cek user berdasarkan email
    $sql = "SELECT * FROM users WHERE user_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['user_password'])) {
            // Login sukses: Set session
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['user_email'];
            $_SESSION['user_name'] = $user['user_name'];  // Menyimpan nama pengguna dalam sesi


            // Redirect ke landing page
            header("Location: ../landing-page.php");
            exit;
        } else {
            echo "<script>alert('Password Salah');
            window.location.href = '../user/signin.php';</script>";
        }
    } else {
        echo "<script>alert('Email tidak terdaftar');
        window.location.href = '../user/signin.php';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
