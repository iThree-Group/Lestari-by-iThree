<?php
include 'connect_admin.php';

// Proses tambah produk baru
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_reward'])) {
    $reward_name = $_POST['reward_name'];
    $reward_points_required = $_POST['reward_points_required'];
    $stock = intval($_POST['stock']); // Ambil nilai stok dari input pengguna

    // Proses upload gambar
    $target_dir = "uploads/";
    $reward_image = $target_dir . basename($_FILES['reward_image']['name']);
    if (move_uploaded_file($_FILES['reward_image']['tmp_name'], $reward_image)) {
        // Query insert dengan kolom stock
        $sql = "INSERT INTO rewards (reward_name, reward_points_required, reward_image, stock, bank_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisii", $reward_name, $reward_points_required, $reward_image, $stock, $bank_id);

        if ($stmt->execute()) {
            $message = "Produk berhasil ditambahkan.";
        } else {
            $message = "Gagal menambahkan produk: " . $stmt->error;
        }
        $stmt->close();
        header("Location: ./");
        exit();
    } else {
        $message = "Gagal mengupload gambar.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/styles.css" rel="stylesheet">
    <title>Kelola Reward | Admin Lestari</title>
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
                <button class="btn btn-success bg-transparent border-0 text-light font-bold justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../penerimaan-sampah/'">
                    <img src="../../images/admin/Truck.png" alt="">
                    <p class="text-lg">Penerimaan Sampah</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../informasi-tutorial/'">
                    <img src="../../images/admin/Recycling.png" alt="">
                    <p>Informasi Tutorial</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../statistik-laporan/'">
                    <img src="../../images/admin/Graph.png" alt="">
                    <p>Statistik & Laporan</p>
                </button>
                <button class="btn btn-success bg-green-btn text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../kelola-reward/'">
                    <img src="../../images/admin/prize.png" class="w-[30px]" alt="">
                    <p>Kelola Reward</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../manajemen-user/'">
                    <img src="../../images/admin/Management.png" alt="">
                    <p>Manajemen User</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../marketplace/'">
                    <img src="../../images/admin/WhatsApp.png" alt="">
                    <p>Marketplace</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../kelola-blog/'">
                    <img src="../../images/admin/Blog.png" alt="">
                    <p>Kelola Blog</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../pengaturan/'">
                    <img src="../../images/admin/Settings.png" alt="">
                    <p>Pengaturan</p>
                </button>
            </div>
        </div> 
        <!-- SIDEBAR END -->

        <!-- CONTENT -->
        <div class="bg-light-bg-content w-full h-auto pb-11 px-5 pt-5">
            <!-- HEADER -->
            <div class="flex flex-row justify-between bg-gradient-to-r from-[#1E5E3F] to-[#3FC483] w-full h-[88px] px-[23px] rounded-[20px] text-light font-extrabold text-[32px] items-center">
                <h1>Statistik & Laporan</h1>
                <div class="dropdown dropdown-end self-center">
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
                        <li><a href="../pengaturan/" class="flex flex-row gap-[10px]">
                            <img src="../../images/admin/Settings-profile.png" class="w-[30px]" alt="Settings">
                            <p class="text-xl font-normal">Pengaturan</p>
                        </a></li>
                            <hr class="h-[2px] w-full text-gray my-6">
                            <li>
                              <form action="../signout.php" method="POST" id="signOutForm" class="flex flex-row gap-[10px]">
                                <button type="submit" style="display: none;" id="signOutButton"></button>
                                <a href="javascript:void(0);" onclick="document.getElementById('signOutForm').submit();" class="flex flex-row gap-[10px]">
                                    <img src="../../images/admin/sign-out.png" class="w-[30px]" alt="Sign Out">
                                    <p class="text-xl font-normal">Sign Out</p>
                                </a>
                              </form>
                           </li>
                        </ul>
                    </div>
                </div>
            <!-- HEADER END -->
            
            <!-- ADD TUTORIAL -->
            <section class="bg-light p-6 mt-7 rounded-[10px] w-full shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)]">
                <div class="flex flex-row">
                    <a href="./" class="self-center">
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
                    <div class="flex flex-col gap-[5px] text-center mx-auto">
                        <h1 class="text-dark font-bold text-[24px] text-center">Tambah Produk Baru</h1>

                         <!-- Pesan -->
                        <?php if (!empty($message)): ?>
                                <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
                        <?php endif; ?>

                    </div>
                </div>
                <form method="POST" enctype="multipart/form-data" class="flex flex-col gap-9 mt-[26px] text-dark">
                    <div class="flex flex-col gap-[10px] w-1/2">
                        <label for="reward_name" class="px-1 text-2xl font-medium">Nama Produk</label>
                        <input type="text" id="reward_name" name="reward_name" placeholder="Masukkan nama produk" class="w-full h-12 bg-light border border-gray px-3 font-light shadow-[0px_4px_4px_rgba(0,0,0,0.25)]" required>
                    </div>
                    <div class="flex flex-col gap-[10px] w-full">
                        <label for="reward_points_required"  class="px-1 text-2xl font-medium">Jumlah Poin</label>
                        <input type="number" id="reward_points_required" name="reward_points_required"  min="0" placeholder="Masukkan Jumlah Poin" class="w-full h-12 bg-light border border-gray px-3 font-light dark:[color-scheme:light] shadow-[0px_4px_4px_rgba(0,0,0,0.25)]" required>
                    </div>
                    <div class="flex flex-col gap-[10px] w-full">
                        <label for="stock" class="px-1 text-2xl font-medium">Stok Produk</label>
                        <input type="number" id="stock" name="stock" min="0" placeholder="Masukkan Jumlah Stok" class="w-full h-12 bg-light border border-gray px-3 font-light dark:[color-scheme:light] shadow-[0px_4px_4px_rgba(0,0,0,0.25)]" required>
                    </div>

                    <div class="flex flex-col gap-[10px] w-full">
                        <label for="reward_image" class="px-1 text-2xl font-medium">Gambar Produk</label>
                        <div class="w-full min-h-[204px] bg-light border-dashed border-2 border-gray py-3 font-light flex items-center justify-center">
                            <input type="file" name="reward_image" accept="image/*" class="file-input file-input-ghost dark:[color-scheme:light]">
                        </div>
                    </div>
                    <button type="submit" name="add_reward" class="btn btn-success bg-[#2ECC71] rounded-[20px] w-[327px] self-center text-xl font-extrabold text-light shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border border-gray">Upload Produk</button>
                </form>
             </section>

            <!-- dialogs -->
            <dialog id="added" class="modal">
                <div class="modal-box bg-light w-[531px] h-auto py-24 rounded-[20px] gap-6 flex flex-col items-center align-middle content-center">
                    <h3 class="text-[32px] font-bold text-center text-dark">Berhasil Upload Produk</h3>
                    <img src="../../images/admin/checklist.png" class="w-[100px]" alt="">
                </div>
                <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
                    <button> </button>
                </form>
            </dialog>

            <dialog id="denied" class="modal">
                <div class="modal-box bg-light w-[593px] h-auto rounded-[20px] gap-10 flex flex-col items-center py-[75px]">
                    <h3 class="text-[32px] font-bold text-center text-dark">Data ditolak</h3>
                    <img src="../../images/admin/denied.png" class="w-[100px]" alt="">
                </div>
                <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
                    <button> </button>
                </form>
            </dialog>
        </div>
    </div>
</body>
</html>