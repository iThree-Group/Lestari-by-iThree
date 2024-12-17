<?php
session_start();  // Memulai sesi
require '../controller/config.php';  // File koneksi ke database

// Menangani POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Email dan password harus diisi!";
        header("Location: ../user/signin-form.php");
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

        // Cek apakah akun terkunci
        if ($user['lockout_until'] && strtotime($user['lockout_until']) > time()) {
            $remaining = ceil((strtotime($user['lockout_until']) - time()) / 60);
            $_SESSION['error_message'] = "Akun Anda terkunci! Silakan coba lagi dalam $remaining menit.";
            header("Location: ../user/signin.php");
            exit;
        }

        // Verifikasi password
        if (password_verify($password, $user['user_password'])) {
            // Jika login sukses, reset percobaan gagal
            $stmt = $conn->prepare("UPDATE users SET failed_attempts = 0, lockout_until = NULL WHERE user_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            // Set session
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['user_email'];
            $_SESSION['user_name'] = $user['user_name'];  // Menyimpan nama pengguna dalam sesi

            // Redirect ke landing page
            header("Location: ../landing-page.php");
            exit;
        } else {
            // Jika password salah, tambahkan percobaan gagal
            $failed_attempts = $user['failed_attempts'] + 1;

            if ($failed_attempts >= 3) {
                // Set waktu blokir 3 menit
                $lockout_until = date('Y-m-d H:i:s', strtotime('+3 minutes'));
                $stmt = $conn->prepare("UPDATE users SET failed_attempts = ?, lockout_until = ? WHERE user_email = ?");
                $stmt->bind_param("iss", $failed_attempts, $lockout_until, $email);
                $stmt->execute();

                $_SESSION['error_message'] = "Akun Anda terkunci setelah 3 kali percobaan salah.";
                header("Location: ../user/signin.php");
                exit;
            } else {
                // Update percobaan gagal
                $stmt = $conn->prepare("UPDATE users SET failed_attempts = ? WHERE user_email = ?");
                $stmt->bind_param("is", $failed_attempts, $email);
                $stmt->execute();

                $_SESSION['error_message'] = "Password salah! Percobaan ke-$failed_attempts.";
                header("Location: ../user/signin.php");
                exit;
            }
        }
    } else {
        $_SESSION['error_message'] = "Email tidak terdaftar!";
        header("Location: ../user/signin.php");
        exit;
    }

    $stmt->close();
}
$conn->close();
?>
