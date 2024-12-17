<?php
session_start();
// Sertakan konfigurasi database
require_once('../../controller/config.php');

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['login_message'] = "Not authorized";
    header('Location: ../login.php');
    exit();
}

// Mengambil data request_id yang dikirimkan
$request_id = isset($_GET['id']) ? $_GET['id'] : null;
$error_message = "";

// Periksa koneksi database
if ($conn) {

    // Cek jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'];

        // Jika tombol Verifikasi ditekan
        if ($status === 'accepted') {
            // Ambil input waste_type dan waste_weight
            $waste_types = isset($_POST['waste_type']) ? $_POST['waste_type'] : [];
            $waste_weights = isset($_POST['waste_weight']) ? $_POST['waste_weight'] : [];

            // Validasi: pastikan inputan tidak kosong
            if (empty($waste_types) || empty($waste_weights)) {
                $error_message = "Please add at least one waste type and weight.";
            } else {
                $valid = true; // Flag untuk memeriksa apakah semua data valid

                // Proses input jika valid
                for ($i = 0; $i < count($waste_types); $i++) {
                    $waste_type = $waste_types[$i];
                    $waste_weight = $waste_weights[$i];

                    // Pastikan jenis sampah dan beratnya valid
                    if (is_numeric($waste_weight) && $waste_weight > 0) {
                        // Ambil points_per_kg dari waste untuk jenis sampah yang dipilih
                        $points_query = "SELECT waste_point FROM waste WHERE waste_id = ?";
                        $points_stmt = $conn->prepare($points_query);
                        $points_stmt->bind_param('i', $waste_type);
                        $points_stmt->execute();
                        $points_stmt->bind_result($waste_point);
                        $points_stmt->fetch();
                        $points_stmt->close();

                        if ($waste_point) {
                            $points_earned = $waste_weight * $waste_point; // Menghitung poin yang diperoleh

                            // Insert ke detail_request
                            $detail_query = "INSERT INTO detail_request (request_id, waste_id, waste_weight, points_earned) VALUES (?, ?, ?, ?)";
                            $detail_stmt = $conn->prepare($detail_query);
                            $detail_stmt->bind_param('iiii', $request_id, $waste_type, $waste_weight, $points_earned);
                            if (!$detail_stmt->execute()) {
                                $error_message = "Error inserting detail request.";
                                $valid = false; // Set valid ke false jika ada error
                            }
                            $detail_stmt->close();
                        } else {
                            $error_message = "Invalid waste type selected.";
                            $valid = false;
                        }
                    } else {
                        $error_message = "Invalid waste weight input.";
                        $valid = false;
                    }
                }

                // Update status jika semua input valid
                if ($valid) {
                    $update_query = "UPDATE drop_off_request SET status = ? WHERE request_id = ?";
                    $update_stmt = $conn->prepare($update_query);
                    $update_stmt->bind_param('si', $status, $request_id);
                    if (!$update_stmt->execute()) {
                        $error_message = "Error updating status.";
                    }
                    $update_stmt->close();
                }
            }
        }

        // Jika tombol Tolak ditekan
        if ($status === 'rejected' && empty($error_message)) {
            // Update status menjadi rejected tanpa memeriksa input waste_type atau waste_weight
            $query = "UPDATE drop_off_request SET status = ? WHERE request_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('si', $status, $request_id);
            if (!$stmt->execute()) {
                $error_message = "Error updating status.";
            }
            $stmt->close();
        }

        // Redirect setelah berhasil
        if (empty($error_message)) {
            header('Location: index.php'); // Redirect ke halaman penerimaan setelah sukses
            exit();
        }
    }

    // Query untuk mendapatkan data jenis sampah
    $waste_query = "SELECT waste_id, waste_name FROM waste";
    $waste_result = $conn->query($waste_query);

    if (!$waste_result) {
        die("Error fetching waste data: " . $conn->error);
    }

} else {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/styles.css" rel="stylesheet">
    <title>Penerimaan Sampah | Admin Lestari</title>
</head>
<body>
    <div class="flex flex-row min-h-[1024px] w-full">
        <!-- SIDEBAR -->
        <div class="bg-gradient-to-t from-green-admin to-dark-green-admin w-[345px] h-auto text-light">
            <div class="flex flex-col pt-10 items-center">
                <h1 class="text-[32px] font-extrabold">Admin Lestari</h1>
                <hr class="w-[345px] h-[1px] bg-light mt-[33px]">
            </div>
            <div class="join join-vertical flex flex-col gap-[19px] mt-[33px] ml-[50px]">
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../dashboard.php'">
                    <img src="../../images/admin/Home.png" alt="">
                    <p>Dashboard</p>
                </button>
                <button class="btn btn-success bg-green-btn text-light font-bold justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../penerimaan-sampah/'">
                    <img src="../../images/admin/Truck.png" alt="">
                    <p class="text-lg">Penerimaan Sampah</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../statistik-laporan/'">
                    <img src="../../images/admin/Graph.png" alt="">
                    <p>Statistik & Laporan</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../kelola-reward/'">
                    <img src="../../images/admin/prize.png" class="w-[30px]" alt="">
                    <p>Kelola Reward</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../marketplace/'">
                    <img src="../../images/admin/WhatsApp.png" alt="">
                    <p>Marketplace</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../pengaturan/'">
                    <img src="../../images/admin/Settings.png" alt="">
                    <p>Pengaturan</p>
                </button>
            </div>
        </div> 
        <!-- SIDEBAR END -->

        <script>
        // Fungsi untuk menambahkan input jenis sampah
        function addMoreWaste() {
            var wasteContainer = document.getElementById('waste-container');
            var wasteCount = wasteContainer.getElementsByClassName('waste-item').length + 1;
            
            var newWasteItem = document.createElement('div');
            newWasteItem.classList.add('flex', 'flex-col', 'gap-[5px]', 'w-full', 'waste-item');
            
            newWasteItem.innerHTML = ` 
                <label for="jenis-sampah-${wasteCount}" class="px-1">Jenis Sampah</label>
                <select id="jenis-sampah-${wasteCount}" name="waste_type[]" class="select select-bordered w-full h-12 bg-light border border-gray px-[14px] text-base font-normal">
                    <option disabled selected>Pilih Jenis Sampah</option>
                    <?php while ($row = $waste_result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['waste_id']) ?>">
                            <?= htmlspecialchars($row['waste_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <label for="berat-sampah-${wasteCount}" class="px-1">Berat Sampah</label>
                <div class="flex flex-row gap-[9px] items-center w-full justify-between">
                    <input type="number" id="berat-sampah-${wasteCount}" name="waste_weight[]" min="0" placeholder="0" class="w-full h-12 bg-light border border-gray px-[14px] font-light">
                    <span class="text-base font-light justify-self-end">Kg</span>
                    <button type="button" class="btn btn-error text-white" onclick="removeWasteItem(this)">X</button>
                </div>
            `;
            wasteContainer.appendChild(newWasteItem);
        }

        // Fungsi untuk menghapus input jenis sampah
        function removeWasteItem(button) {
            button.parentElement.parentElement.remove();
        }

        document.querySelector('form').addEventListener('submit', function (e) {
        const wasteItems = document.querySelectorAll('.waste-item');
        const status = document.querySelector('button[type="submit"][name="status"]:focus').value;

        // Jika tombol Verifikasi ditekan
        if (status === 'accepted') {
            if (wasteItems.length === 0) {
                alert('Anda harus menambahkan setidaknya satu jenis sampah.');
                e.preventDefault();
            } else {
                // Periksa apakah semua input berat sampah valid
                for (const item of wasteItems) {
                    const weightInput = item.querySelector('input[name="waste_weight[]"]');
                    if (!weightInput.value || parseFloat(weightInput.value) <= 0) {
                        alert('Berat sampah harus diisi dan lebih dari 0.');
                        e.preventDefault();
                        return;
                    }
            }
        }
    }
});
    </script>
</head>
<body>
        <!-- CONTENT -->
        <div class="bg-light-bg-content w-full h-auto pb-11 px-5 pt-5">
            <!-- HEADER -->
            <div class="flex flex-row justify-between bg-gradient-to-r from-[#1E5E3F] to-[#3FC483] w-full h-[88px] px-[23px] rounded-[20px] text-light font-extrabold text-[32px] items-center">
                <h1>Penerimaan Sampah</h1>
                <div class="dropdown dropdown-end self-center flex items-center">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-[50px] rounded-full">
                        <img
                            alt="Tailwind CSS Navbar component"
                            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                        </div>
                    </div>
                    <ul
                        tabindex="0"
                        class="menu menu-sm dropdown-content bg-light rounded-[10px] z-[1] mt-3 w-[233px] py-6 border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] text-dark">
                        <li><a href="../pengaturan/profil.php" class="flex flex-row gap-[10px] mb-[15px]">
                            <img src="../../images/admin/Profile.png" class="w-[30px]" alt="Profile">
                            <p class="text-xl font-normal">Profile</p>
                        </a></li>
                        <hr class="h-[2px] w-full text-gray my-6">
                        <li><a class="flex flex-row gap-[10px]">
                            <img src="../../images/admin/sign-out.png" class="w-[30px]" alt="Sign Out">
                            <p class="text-xl font-normal">Sign Out</p>
                        </a></li>
                    </ul>
                </div>
            </div>
            <!-- HEADER END -->
            
            <!-- FORM -->
            <div class="bg-light rounded-[10px] w-[639px] h-auto shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col justify-self-center pt-[25px] pb-[50px] mt-[46px] text-dark">
                <div class="flex flex-col gap-[21px] text-center">
                    <div class="flex flex-row">
                        <a href="./" class="self-center pl-7 absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35" fill="none">
                                <g clip-path="url(#clip0_120_5431)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.5792 19.0458C11.1695 18.6357 10.9395 18.0797 10.9395 17.5C10.9395 16.9203 11.1695 16.3643 11.5792 15.9541L19.8275 7.70289C20.2379 7.29272 20.7944 7.06236 21.3746 7.0625C21.6619 7.06257 21.9464 7.11922 22.2118 7.22922C22.4772 7.33923 22.7183 7.50043 22.9214 7.70362C23.1245 7.90682 23.2856 8.14802 23.3954 8.41347C23.5053 8.67892 23.5618 8.96341 23.5618 9.2507C23.5617 9.53799 23.5051 9.82246 23.3951 10.0879C23.285 10.3532 23.1238 10.5944 22.9207 10.7975L16.2196 17.5L22.9221 24.2025C23.1311 24.4042 23.2979 24.6455 23.4127 24.9123C23.5274 25.1791 23.5879 25.4661 23.5906 25.7566C23.5932 26.047 23.538 26.3351 23.4282 26.604C23.3183 26.8729 23.156 27.1172 22.9507 27.3227C22.7454 27.5282 22.5012 27.6907 22.2324 27.8008C21.9637 27.911 21.6756 27.9664 21.3852 27.9641C21.0947 27.9617 20.8077 27.9015 20.5407 27.7869C20.2738 27.6724 20.0323 27.5059 19.8304 27.2971L11.5763 19.0458H11.5792Z" fill="black"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_120_5431">
                                    <rect width="35" height="35" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                        <h2 class="text-2xl font-bold mx-auto">Input Data Penerimaan Sampah</h2>
                    </div>
                    <p class="text-sm font-light">Silakan isi data penerimaan sampah dengan lengkap</p>
                </div>
                <form action="" method="POST" class="flex flex-col text-base font-medium mt-[50px] w-full px-[90px] gap-[31px]">
                    <!-- Waste Inputs -->
                    <input type="hidden" name="request_id" value="<?= htmlspecialchars($request_id); ?>">
                    <div id="waste-container" class="flex flex-col gap-[5px]">
                    </div>

                    <button type="button" id="add-more-waste" class="btn btn-info text-light rounded-[10px] py-2 px-5" onclick="addMoreWaste()">Tambah Jenis Sampah</button>

                    <div class="flex flex-row justify-center gap-12 w-full">
                    <button 
                        class="btn btn-success bg-[#2ECC71] rounded-[20px] text-[15px] font-semibold px-[41px] text-light shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border border-gray" 
                        type="submit" name="status" value="accepted">
                        Verifikasi
                    </button>
                    
                    <!-- Tombol Tolak -->
                    <button 
                        class="btn btn-error bg-[#C0392B] rounded-[20px] text-[15px] font-semibold px-[41px] text-light shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border border-gray" 
                        type="submit" name="status" value="rejected">
                        Tolak
                    </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DIALOGS
    <dialog id="denied" class="modal">
        <div class="modal-box bg-light w-[593px] h-auto rounded-[20px] gap-10 flex flex-col items-center py-[75px]">
            <h3 class="text-[32px] font-bold text-center text-dark">Data ditolak</h3>
            <img src="../../images/admin/denied.png" class="w-[100px]" alt="">
        </div>
        <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
            <button> </button>
        </form>
    </dialog> -->
</body>
</html>