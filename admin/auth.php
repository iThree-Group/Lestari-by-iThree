<?php
session_start();
include('../controller/config.php'); // Include file konfigurasi database

// Fungsi untuk mengalihkan ke halaman login dengan pesan tertentu
function redirectWithMessage($message, $email = null) {
    $_SESSION['login_message'] = $message;
    if ($email) {
        $_SESSION['email_attempt'] = $email; // Menyimpan email terakhir untuk diisi ulang
    }
    header('Location: login.php');
    exit();
}

// Periksa apakah ada data yang dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['admin_email']);
    $password = trim($_POST['admin_password']);

    // Ambil data admin berdasarkan email
    $stmt = $conn->prepare("SELECT admin_id, bank_id, admin_password, failed_attempts, lockout_until FROM admin WHERE admin_email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Ambil data admin
            $stmt->bind_result($admin_id, $bank_id, $hashed_password, $failed_attempts, $lockout_until);
            $stmt->fetch();

            $currentTime = new DateTime();
            $lockoutUntilTime = $lockout_until ? new DateTime($lockout_until) : null;

            // Periksa apakah akun terkunci
            if ($lockoutUntilTime && $currentTime < $lockoutUntilTime) {
                $remainingTime = $lockoutUntilTime->getTimestamp() - $currentTime->getTimestamp();
                $remainingMinutes = ceil($remainingTime / 60);
                redirectWithMessage("Akun terkunci! Silakan tunggu $remainingMinutes menit sebelum mencoba lagi.", $email);
            }

            // Verifikasi password
            if (password_verify($password, $hashed_password)) {
                // Reset percobaan gagal jika login berhasil
                $resetStmt = $conn->prepare("UPDATE admin SET failed_attempts = 0, lockout_until = NULL WHERE admin_id = ?");
                $resetStmt->bind_param("i", $admin_id);
                $resetStmt->execute();

                // Set session untuk login berhasil
                $_SESSION['admin_id'] = $admin_id;
                $_SESSION['bank_id'] = $bank_id;

                // Redirect ke dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                // Password salah, tambahkan failed_attempts
                $failedAttempts = $failed_attempts + 1;
                if ($failedAttempts >= 3) {
                    // Kunci akun selama 3 menit jika gagal 3 kali
                    $lockoutUntil = $currentTime->add(new DateInterval('PT3M'))->format('Y-m-d H:i:s');
                    $updateStmt = $conn->prepare("UPDATE admin SET failed_attempts = ?, lockout_until = ? WHERE admin_id = ?");
                    $updateStmt->bind_param("isi", $failedAttempts, $lockoutUntil, $admin_id);
                } else {
                    // Hanya tambahkan failed_attempts
                    $updateStmt = $conn->prepare("UPDATE admin SET failed_attempts = ? WHERE admin_id = ?");
                    $updateStmt->bind_param("ii", $failedAttempts, $admin_id);
                }
                $updateStmt->execute();

                if ($failedAttempts >= 3) {
                    redirectWithMessage("Akun Anda terkunci! Silakan coba lagi dalam 3 menit.", $email);
                } else {
                    $remainingAttempts = 3 - $failedAttempts;
                    redirectWithMessage("Password salah! Anda memiliki $remainingAttempts percobaan lagi.", $email);
                }
            }
        } else {
            // Email tidak ditemukan
            redirectWithMessage("Email tidak ditemukan.");
        }
        $stmt->close();
    } else {
        die("Error pada prepare statement: " . $conn->error);
    }
}

$conn->close();
?>
