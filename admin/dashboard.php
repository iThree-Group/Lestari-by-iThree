<?php
session_start();
include('../controller/config.php');

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['login_message'] = "Not authorized";
    header('Location: login.php');
    exit();
}

// Ambil data admin
$admin_id = $_SESSION['admin_id'];

// Query untuk mengambil data bank_id admin yang sedang login
$adminQuery = "SELECT bank_id FROM admin WHERE admin_id = ?";
$stmt = $conn->prepare($adminQuery);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$adminData = $result->fetch_assoc();
$bank_id = isset($adminData['bank_id']) ? $adminData['bank_id'] : null;

if (!$bank_id) {
    echo "Admin tidak terkait dengan bank sampah.";
    exit();
}

// Query untuk menghitung total berat sampah yang diterima
$query_total_sampah = "
    SELECT SUM(dr.waste_weight) AS total_berat 
    FROM detail_request dr
    JOIN drop_off_request dor ON dr.request_id = dor.request_id
    WHERE dor.bank_id = ?
    AND dor.status = 'accepted'";
$stmt = $conn->prepare($query_total_sampah);
$stmt->bind_param("i", $bank_id);
$stmt->execute();
$stmt->bind_result($total_sampah);
$stmt->fetch();
$total_sampah = $total_sampah ?? 0;
$stmt->close();

// Query untuk menghitung jumlah Drop-off Requests
$requestQuery = "SELECT COUNT(*) AS total_requests FROM drop_off_request WHERE bank_id = ?";
$stmt = $conn->prepare($requestQuery);
$stmt->bind_param("i", $bank_id);
$stmt->execute();
$requestResult = $stmt->get_result();
$requestData = $requestResult->fetch_assoc();
$total_requests = $requestData['total_requests'] ?? 0;
$stmt->close();

// Query untuk menghitung jumlah Drop-off Requests yang menunggu
$query_drop_off_menunggu = "SELECT COUNT(*) AS total_menunggu FROM drop_off_request WHERE status = 'waiting' AND bank_id = ?";
$stmt = $conn->prepare($query_drop_off_menunggu);
$stmt->bind_param("i", $bank_id);
$stmt->execute();
$stmt->bind_result($total_menunggu);
$stmt->fetch();
$total_menunggu = $total_menunggu ?? 0;
$stmt->close();

// Query untuk mendapatkan nama sampah yang paling sering diterima
$query_kategori_populer = "
    SELECT w.waste_name AS waste_category, COUNT(w.waste_name) AS jumlah
    FROM detail_request dr
    JOIN waste w ON dr.waste_id = w.waste_id
    JOIN drop_off_request dor ON dr.request_id = dor.request_id
    WHERE dor.bank_id = ?
    AND dor.status = 'accepted'
    GROUP BY w.waste_name
    ORDER BY jumlah DESC
    LIMIT 1";
$stmt = $conn->prepare($query_kategori_populer);
$stmt->bind_param("i", $bank_id);
$stmt->execute();
$stmt->bind_result($kategori_populer, $jumlah_populer);
$stmt->fetch();
$kategori_populer = $kategori_populer ?? "Tidak ada";
$stmt->close();

// Query untuk mendapatkan data
$query = "
    SELECT 
        u.user_name,
        dr.waste_weight,
        w.waste_name,
        dor.status
    FROM drop_off_request dor
    JOIN detail_request dr ON dor.request_id = dr.request_id
    JOIN waste w ON dr.waste_id = w.waste_id
    JOIN users u ON dor.user_id = u.user_id
    WHERE dor.bank_id = ?
    AND dor.status = 'accepted'
    ORDER BY dor.drop_off_request_created_at DESC;
";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $bank_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $activities = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $activities[] = $row;
        }
    }

    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/styles.css" rel="stylesheet">
    <title>Dashboard | Admin Lestari</title>
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
                <button class="btn btn-success bg-green-btn text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]">
                    <img src="../images/admin/Home.png" alt="">
                    <p>Dashboard</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='./penerimaan-sampah/'">
                    <img src="../images/admin/Truck.png" alt="">
                    <p class="text-lg">Penerimaan Sampah</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='./statistik-laporan/'">
                    <img src="../images/admin/Graph.png" alt="">
                    <p>Statistik & Laporan</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='./kelola-reward/'">
                    <img src="../images/admin/prize.png" class="w-[30px]" alt="">
                    <p>Kelola Reward</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='./marketplace/'">
                    <img src="../images/admin/WhatsApp.png" alt="">
                    <p>Marketplace</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='./pengaturan/'">
                    <img src="../images/admin/Settings.png" alt="">
                    <p>Pengaturan</p>
                </button>
            </div>
        </div> 
        <!-- SIDEBAR END -->

        <!-- CONTENT -->
        <div class="bg-light-bg-content w-full h-auto px-5 py-5">
            <!-- HEADER -->
            <div class="flex flex-row justify-between bg-gradient-to-r from-[#1E5E3F] to-[#3FC483] w-full h-[88px] px-[23px] rounded-[20px] text-light font-extrabold text-[32px] items-center">
                <h1>Dashboard</h1>
                <div class="dropdown dropdown-end self-center">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar flex items-center">
                        <div class="w-[50px] rounded-full">
                        <img
                            alt="Tailwind CSS Navbar component"
                            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                        </div>
                    </div>
                    <ul
                        tabindex="0"
                        class="menu menu-sm dropdown-content bg-light rounded-[10px] z-[1] mt-3 w-[233px] py-6 border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] text-dark">
                        <li><a href="./pengaturan/profil.php" class="flex flex-row gap-[10px] mb-[15px]">
                            <img src="../images/admin/Profile.png" class="w-[30px]" alt="Profile">
                            <p class="text-xl font-normal">Profile</p>
                        </a></li>
                        <li><a href="./pengaturan/" class="flex flex-row gap-[10px]">
                            <img src="../images/admin/Settings-profile.png" class="w-[30px]" alt="Settings">
                            <p class="text-xl font-normal">Pengaturan</p>
                        </a></li>
                        <!-- <hr class="h-[2px] w-full text-gray my-6">
                        <li><a class="flex flex-row gap-[10px]">
                            <img src="../images/admin/sign-out.png" class="w-[30px]" alt="Sign Out">
                            <p class="text-xl font-normal">Sign Out</p>
                        </a></li> -->
                    
                        <hr class="h-[2px] w-full text-gray my-6">
                        <li>
                            <form action="signout.php" method="POST" id="signOutForm" class="flex flex-row gap-[10px]">
                                <button type="submit" style="display: none;" id="signOutButton"></button>
                                <a href="javascript:void(0);" onclick="document.getElementById('signOutForm').submit();" class="flex flex-row gap-[10px]">
                                    <img src="../images/admin/sign-out.png" class="w-[30px]" alt="Sign Out">
                                    <p class="text-xl font-normal">Sign Out</p>
                                </a>
                            </form>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <!-- HEADER END -->
            
            <!-- DASHBOARD CARD -->
            <div class="h-auto w-full mt-[63px] grid grid-cols-4 gap-7">
                <div class="bg-gradient-to-b from-[#F6AC0A] to-[#906506] rounded-[20px] border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col pl-[23px] pt-[33px] pb-[49px] h-full text-dark gap-[11px]">
                    <h4 class="text-xs font-bold">Total Berat Sampah Diterima</h4>
                    <div class="flex flex-col">
                        <h2 class="text-xl font-normal  "><?php echo number_format($total_sampah); ?> kg</h2>
                        <p class="text-[10px] font-light">Selama ini</p>
                    </div>
                </div>
                <div class="bg-gradient-to-b from-[#08FCF0] to-[#05968F] rounded-[20px] border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col pl-[23px] pt-[33px] pb-[49px] h-full text-dark gap-[11px]">
                    <h4 class="text-xs font-bold">Total Drop-off Entry</h4>
                    <div class="flex flex-col">
                        <h2 class="text-xl font-normal  "><?php echo number_format($total_requests); ?></h2>
                        <p class="text-[10px] font-light">Telah masuk sistem</p>
                    </div>
                </div>
                <div class="bg-gradient-to-b from-[#0AF649] to-[#06902B] rounded-[20px] border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col pl-[23px] pt-[33px] pb-[49px] h-full text-dark gap-[11px]">
                    <h4 class="text-xs font-bold">Total Drop-off Waitings</h4>
                    <div class="flex flex-col">
                        <h2 class="text-xl font-normal  "><?php echo $total_menunggu; ?></h2>
                        <p class="text-[10px] font-light">Menunggu verifikasi</p>
                    </div>
                </div>
                <div class="bg-gradient-to-b from-[#ECF310] to-[#898D09] rounded-[20px] border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col pl-[23px] pt-[33px] pb-[49px] h-full text-dark gap-[11px]">
                    <h4 class="text-xs font-bold">Sampah Paling Sering Diterima</h4>
                    <div class="flex flex-col">
                        <h2 class="text-xl font-normal  "><?php echo $kategori_populer; ?></h2>
                        <p class="text-[10px] font-light">Selama ini</p>
                    </div>
                </div>
            </div>
            <!-- DASHBOARD CARD END -->

            <!-- RECENT ACTIVITY -->
             <div class="bg-light w-full h-auto rounded-[10px] px-[26px] py-9 mt-[54px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] text-dark flex flex-col gap-[22px]">
                <h2 class="text-2xl font-bold">Aktivitas Terbaru</h2>

                <!-- <div class="flex flex-row justify-between pl-[7px] pr-[45px] w-full h-[62px] rounded-[10px] bg-light border border-gray">
                    <div class="flex flex-col">
                        <h4 class="text-xl font-normal">Cut Nyak Gem</h4>
                        <p class="text-xs font-light">Mengantarkan 3 Kg Sampah Kertas</p>
                    </div>
                    <div class="bg-[#FFDE75] w-[159px] h-[27px] rounded-[10px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border border-gray self-center text-center content-center">
                        <p class="text-xs font-light">Menunggu Verifikasi</p>
                    </div>
                </div>
                
                <div class="flex flex-row justify-between pl-[7px] pr-[45px] w-full h-[62px] rounded-[10px] bg-light border border-gray">
                    <div class="flex flex-col">
                        <h4 class="text-xl font-normal">Budi Santoso</h4>
                        <p class="text-xs font-light">Mengantarkan 7 Kg Sampah Plastik</p>
                    </div>
                    <div class="bg-[#2ECC71] w-[159px] h-[27px] rounded-[10px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border border-gray self-center text-center content-center">
                        <p class="text-xs font-light">Selesai</p>
                    </div>
                </div>
                
                <div class="flex flex-row justify-between pl-[7px] pr-[45px] w-full h-[62px] rounded-[10px] bg-light border border-gray">
                    <div class="flex flex-col">
                        <h4 class="text-xl font-normal">Dewi Kartika</h4>
                        <p class="text-xs font-light">Mengantarkan 4 Kg Sampah Plastik</p>
                    </div>
                    <div class="bg-[#2ECC71] w-[159px] h-[27px] rounded-[10px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border border-gray self-center text-center content-center">
                        <p class="text-xs font-light">Selesai</p>
                    </div>
                </div> -->

                <div class="overflow-auto h-[314px] flex flex-col gap-5">
                    <?php foreach ($activities as $activity) : ?>
                        <div class="flex flex-row justify-between pl-2 pr-10 w-full h-auto py-[1px] rounded-[10px] bg-light border border-gray">
                            <div class="flex flex-col mb-3">
                                <h4 class="text-xl font-normal"><?php echo $activity['user_name'] ?></h4>
                                <p class="text-xs font-light">Mengantarkan <?php echo $activity['waste_weight'] ?> kg sampah <?php echo strtolower($activity['waste_name']) ?></p>
                            </div>
        
                            <!-- IF CONDITION -->
                            <?php if ($activity['status'] == "accepted") : ?>
                                <div class="bg-[#2ECC71] w-[159px] h-[27px] rounded-[10px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border border-gray self-center text-center content-center">
                                    <p class="text-xs font-light">Selesai</p>
                                </div>
                            <?php else : ?>
                                <div class="bg-[#FFDE75] w-[159px] h-[27px] rounded-[10px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border border-gray self-center text-center content-center">
                                    <p class="text-xs font-light">Menunggu Verifikasi</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
             </div>
             <!-- RECENT ACTIVITY END -->
        </div>
    </div>
</body>
</html>