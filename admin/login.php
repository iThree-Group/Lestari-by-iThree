<?php
session_start();

// Arahkan ke halaman dashboard jika admin sudah login
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Tampilkan pesan error jika ada kesalahan
$errorMessage = null;
$lastEmailAttempt = isset($_SESSION['email_attempt']) ? $_SESSION['email_attempt'] : '';

if (isset($_SESSION['login_message'])) {
    $errorMessage = $_SESSION['login_message'];
    unset($_SESSION['login_message']); // Hapus pesan setelah ditampilkan
    unset($_SESSION['email_attempt']); // Hapus email yang tersimpan setelah ditampilkan
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/styles.css" rel="stylesheet">
    <title>Masuk | Admin Lestari</title>
</head>
<body>
    <div class="flex justify-center bg-gradient-to-b from-green-admin to-dark-green-admin w-full h-screen p-[34px]">
        <div class="flex flex-col items-center bg-light w-[622px] h-auto rounded-[114px] pt-6 pb-[75px] px-[15px] text-dark gap-4 self-center">
            <div>
                <img src="../images/Logo admin.png" class="w-[279px] h-[150px]" alt="Logo Lestari">
                <h1 class="text-3xl font-bold self-center text-center">Admin Login</h1>
            </div>

            <?php if ($errorMessage): ?>
                <div class="flex flex-col w-auto h-auto p-2 text-center text-red font-medium text-sm">
                    <p><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></p>
                </div>
            <?php else: ?>
                <h2 class="text-2xl font-light">Lestari</h2>
            <?php endif; ?> 

            <div class="flex flex-col form-bg w-[488px] h-auto rounded-lg border-2 border-gray p-6 gap-3">
                <form action="./auth.php" method="POST" class="flex flex-col gap-6 dark:[color-scheme:light]">

                    <label for="admin_email" class="flex flex-col gap-2">
                        <span>Alamat email</span>
                        <input type="email" id="admin_email" name="admin_email" required 
                               value="<?php echo htmlspecialchars($lastEmailAttempt, ENT_QUOTES); ?>" 
                               class="w-full h-10 rounded-lg py-3 px-4 bg-transparent border-2 border-gray" 
                               placeholder="Email">
                    </label>

                    <label for="admin_password" class="flex flex-col gap-2">
                        <span>Kata sandi</span>
                        <input type="password" id="admin_password" name="admin_password" required 
                               class="w-full h-10 rounded-lg py-3 px-4 bg-transparent border-2 border-gray" 
                               pattern=".{8,}" title="Password harus memiliki minimal 8 karakter" 
                               placeholder="Kata sandi">
                    </label>
                    
                    <button type="submit" class="bg-[#009951] h-10 rounded-lg text-base font-bold items-center text-light border-2 border-dark">Masuk</button>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
