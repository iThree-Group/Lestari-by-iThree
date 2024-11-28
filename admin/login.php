<?php
session_start();
include('../controller/config.php'); // Pastikan ini adalah file koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_email = trim($_POST['admin_email']);
    $admin_password = trim($_POST['admin_password']);

    // Cek apakah email ada di database
    $stmt = $conn->prepare("SELECT admin_id, admin_password FROM admin WHERE admin_email = ?");
    $stmt->bind_param("s", $admin_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $admin_password_hash);
        $stmt->fetch();

        // Verifikasi password
        if (password_verify($admin_password, $admin_password_hash)) {
            $_SESSION['admin_id'] = $admin_id;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Email atau password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/styles.css" rel="stylesheet">
    <title>Masuk | Admin Lestari</title>
</head>
<body>
    <div class="flex justify-center bg-gradient-to-b from-green-admin to-dark-green-admin w-full h-screen p-[34px]">
        <div class="flex flex-col items-center bg-light w-[622px] h-auto rounded-[114px] py-[75px] px-[15px] text-dark gap-[21px] self-center">
            <div>
                <img src="../images/Logo admin.png" class="w-[314px] h-[169px]" alt="Logo Lestari">
                <h1 class="text-[32px] font-bold self-center text-center">Admin Login</h1>
            </div>
            <h2 class="text-[26px] font-light">Lestari</h2>
            <div class="flex flex-col form-bg w-[488px] h-auto rounded-lg border-2 border-gray p-6 gap-3">
                <?php if (isset($error)) : ?>
                    <p style="color: red; text-align: center;"><?= $error ?></p>
                <?php endif; ?>

                <form action="" method="POST" class="flex flex-col gap-6">
                    <label for="admin_email" class="flex flex-col gap-2">
                        <span>Email</span>
                        <input type="email" id="admin_email" name="admin_email" 
                               class="w-full h-10 rounded-lg py-3 px-4 bg-transparent border-2 border-gray" 
                               placeholder="Email" required>
                    </label>
                    <label for="admin_password" class="flex flex-col gap-2">
                        <span>Password</span>
                        <input type="password" id="admin_password" name="admin_password" 
                               class="w-full h-10 rounded-lg py-3 px-4 bg-transparent border-2 border-gray" 
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                               title="Password harus memiliki minimal satu huruf besar, satu huruf kecil, satu angka, dan minimal 8 karakter" 
                               placeholder="Password" required>
                    </label>
                    <button type="submit" 
                            class="bg-[#009951] h-10 rounded-lg text-base font-bold items-center text-light border-2 border-dark">
                        Masuk
                    </button>
                </form>
                <a href="./password-reset/" class="underline self-end">Forgot password?</a>
            </div>
        </div>
    </div>
</body>
</html>
