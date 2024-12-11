<?php
include 'connect_admin.php';

// Ambil data reward untuk diedit jika tombol edit ditekan
$edit_data = null;
$modal_open = false; // Variabel kontrol untuk modal
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    // Pastikan query mengembalikan data hanya jika bank_id sesuai
    $sql = "SELECT * FROM rewards WHERE reward_id = ? AND bank_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $edit_id, $bank_id);  // Bind parameter reward_id dan bank_id
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $modal_open = true; // Modal akan terbuka jika ada data edit
}

if (isset($_GET['saved'])) {
    $modal_open_edit = true; // Modal akan terbuka jika ada data edit
}

if (isset($_SESSION['flash_message'])) {
    $modal_open_added = true;
    unset($_SESSION['flash_message']);
}

// Proses update reward
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_reward'])) {
    $reward_id = $_POST['reward_id'];
    $reward_name = $_POST['reward_name'];
    $reward_points_required = $_POST['reward_points_required'];
    $stock = $_POST['stock']; // Ambil data stok dari form

    // Proses upload gambar jika ada
    $reward_image = $edit_data['reward_image'];
    if (!empty($_FILES['reward_image']['name'])) {
        $target_dir = "uploads/";
        $reward_image = $target_dir . basename($_FILES['reward_image']['name']);
        move_uploaded_file($_FILES['reward_image']['tmp_name'], $reward_image);
    }

    // Cek apakah form sudah disubmit
    if (isset($_POST['update_reward'])) {
        // Query untuk memperbarui data di database, dengan memeriksa bank_id
        $sql = "UPDATE rewards SET reward_name = ?, reward_points_required = ?, stock = ?, reward_image = ? WHERE reward_id = ? AND bank_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisii", $reward_name, $reward_points_required, $stock, $reward_image, $reward_id, $bank_id);

        // Eksekusi query dan cek apakah berhasil
        if ($stmt->execute()) {
            // Jika berhasil, set flag sukses dan lakukan redirect
            $save_successful = true;  // Flag untuk memicu modal
            $stmt->close();
            
            // Redirect untuk menghindari pengiriman ulang form pada saat refresh dan untuk menampilkan modal
            header("Location: index.php?saved=true");
            exit;
        } else {
            // Jika gagal, set pesan error
            $message = "Gagal memperbarui reward: " . $stmt->error;
            $stmt->close();
        }
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
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../statistik-laporan/'">
                    <img src="../../images/admin/Graph.png" alt="">
                    <p>Statistik & Laporan</p>
                </button>
                <button class="btn btn-success bg-green-btn text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../kelola-reward/'">
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

        <!-- CONTENT -->
        <div class="bg-light-bg-content w-full h-auto pb-11 px-5 pt-5">
            <!-- HEADER -->
            <div class="flex flex-row justify-between bg-gradient-to-r from-[#1E5E3F] to-[#3FC483] w-full h-[88px] px-[23px] rounded-[20px] text-light font-extrabold text-[32px] items-center">
                <h1>Kelola Reward</h1>
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
            
            <!-- BUTTONS -->
            <div class="flex flex-row gap-[22px] mt-[31px] ">
                <button class="btn btn-warning h-[42px] px-[27px] text-light rounded-[20px] border border-dark bg-[#F6AC0A] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] font-medium text-xl" onclick="location.href='./'">
                    Kelola Produk Reward
                </button>
                <button class="btn btn-warning h-[42px] px-[27px] text-light rounded-[20px] mr-auto border border-dark bg-[#F6AC0A] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] font-medium text-xl" onclick="location.href='./redeem-list.php'">
                    Daftar Tukar Reward
                </button>
                <button onclick="location.href='./add.php'" class="bg-[#2980B9] h-10 flex flex-row gap-[18px] content-center w-[279px] pl-[27px] rounded-[5px] items-center self-center border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)]">
                    <img src="../../images/admin/Plus.png" class="h-[30px]" alt="Add">
                    <span class="text-light text-base font-extrabold">Tambah produk</span>
                </button>
            </div>
            <!-- BUTTONS END -->

            <!-- Pesan -->
            <?php if (isset($message)): ?>
                  <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

             <!-- GRID -->
             <div class="bg-light w-full h-auto p-10 mt-7 border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] grid grid-cols-3 gap-7 rounded-[10px]">
                <!-- CARDS -->
                <?php
                // Periksa apakah admin sudah login
                if (!isset($_SESSION['admin_id'])) {
                    die("Anda tidak diizinkan mengakses data ini.");
                }

                // Ambil admin_id dari session
                $admin_id = $_SESSION['admin_id'];

                // Query untuk mengambil bank_id berdasarkan admin_id
                $adminQuery = "SELECT bank_id FROM admin WHERE admin_id = ?";
                $stmt = $conn->prepare($adminQuery);
                $stmt->bind_param("i", $admin_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $adminData = $result->fetch_assoc();
                $stmt->close();

                $bank_id = $adminData['bank_id'] ?? null;

                if (!$bank_id) {
                    die("Admin tidak terkait dengan bank sampah.");
                }

                // Jika bank_id tersedia, ambil data rewards
                $sql = "SELECT * FROM rewards WHERE bank_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $bank_id); // Bind parameter (integer)
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()): ?>
                        <div class="bg-light w-auto h-auto shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] px-1.5 pb-[15px]">
                            <figure class="pt-[7px]">
                                <img src="<?= htmlspecialchars($row['reward_image'] ?? 'default.jpg'); ?>" 
                                    alt="Reward Image" 
                                    class="rounded-[15px]" />
                            </figure>
                            <div class="mt-[31px] gap-[9px] flex flex-col">
                                <h2 class="text-dark text-[15px] font-extrabold"><?= htmlspecialchars($row['reward_name']); ?></h2>
                                <p class="text-xs text-dark font-normal max-w-[238px]">Poin: <?= htmlspecialchars($row['reward_points_required']); ?></p>
                                <p class="text-xs text-dark font-normal max-w-[238px]">Stok: <?= htmlspecialchars($row['stock']); ?></p> <!-- Menampilkan stok -->
                            </div>
                            <div class="mt-[50px] h-5 flex flex-row justify-between align-middle">
                                <a href="?edit_id=<?= htmlspecialchars($row['reward_id']); ?>">
                                    <button class="bg-[#2ECC71] h-full w-[72px] rounded-[10px] text-[10px] font-semibold text-light">Edit</button>
                                </a>
                            </div>
                        </div>
                    <?php endwhile;
                } else {
                    echo "<p>Tidak ada rewards untuk bank ini.</p>";
                }

                $stmt->close();
                ?>
            </div>


            <!-- CARDS END  -->

            <!-- dialogs -->
            <dialog id="verified" class="modal">
                <div class="modal-box bg-light w-[593px] h-auto rounded-[20px] gap-10 flex flex-col items-center py-[75px]">
                    <h3 class="text-[32px] font-bold text-center text-dark">Berhasil Verifikasi</h3>
                    <img src="../../images/admin/checklist.png" class="w-[100px]" alt="">
                </div>
                <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
                    <button> </button>
                </form>
            </dialog>

            <dialog id="added" class="modal" <?= $modal_open_added ? 'open' : ''; ?>>
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

            <dialog id="deleted" class="modal" <?= $modal_open_deleted ? 'open' : ''; ?>>
                <div class="modal-box bg-light w-[531px] h-auto py-24 rounded-[20px] gap-6 flex flex-col items-center align-middle content-center">
                    <h3 class="text-[32px] font-bold text-center text-dark">Data berhasil dihapus</h3>
                    <img src="../../images/admin/checklist.png" class="w-[100px]" alt="">
                </div>
                <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
                    <button> </button>
                </form>
            </dialog>

            <!-- Modal Edit Reward (form untuk mengedit data) -->
            <?php if ($edit_data): ?>
                <dialog id="edit" class="modal" <?= $modal_open ? 'open' : ''; ?>>
                    <div class="modal-box bg-light min-w-[550px] h-auto rounded-[20px] gap-[18px] flex flex-col px-10 py-7">
                        <h3 class="text-2xl font-bold text-dark">Edit Produk</h3>
                        <form method="post" enctype="multipart/form-data" class="flex flex-col gap-[18px] w-full text-dark">
                            <input type="hidden" name="reward_id" value="<?= htmlspecialchars($edit_data['reward_id']); ?>" />
                            
                            <!-- Nama Produk -->
                            <div class="flex flex-col gap-[9px]">
                                <label for="reward_name" class="text-sm font-medium">Nama Produk</label>
                                <input type="text" id="reward_name" name="reward_name" value="<?= htmlspecialchars($edit_data['reward_name']); ?>" class="w-full h-7 bg-light border border-gray px-1.5 font-normal text-xs" required>
                            </div>
                            
                            <!-- Jumlah Poin -->
                            <div class="flex flex-col gap-[9px]">
                                <label for="reward_points_required" class="text-sm font-medium">Jumlah Poin</label>
                                <input type="number" id="reward_points_required" name="reward_points_required" value="<?= $edit_data['reward_points_required']; ?>" class="w-full h-7 bg-light border border-gray px-1.5 font-normal text-xs" required>
                            </div>
                            
                            <!-- Stok -->
                            <div class="flex flex-col gap-[9px]">
                                <label for="stock" class="text-sm font-medium">Stok</label>
                                <input type="number" id="stock" name="stock" value="<?= $edit_data['stock']; ?>" class="w-full h-7 bg-light border border-gray px-1.5 font-normal text-xs" required>
                            </div>

                            <!-- Gambar -->
                            <div class="flex flex-col gap-[9px]">
                                <label for="reward_image" class="text-sm font-medium">Gambar Produk</label>
                                <!-- Tampilkan gambar saat ini -->
                                <img src="<?= htmlspecialchars($edit_data['reward_image']); ?>" alt="Gambar Produk" class="w-20 h-20 object-cover rounded-md border">
                                <!-- Input file untuk mengganti gambar -->
                                <input type="file" id="reward_image" name="reward_image" class="w-full h-7 bg-light border border-gray px-1.5 font-normal text-xs" accept="image/*">
                                <small class="text-gray-500 text-xs">Kosongkan jika tidak ingin mengganti gambar.</small>
                            </div>
                            
                            <!-- Tombol Aksi -->
                            <div class="flex flex-row-reverse gap-[15px] mt-2 items-end">
                                <button type="submit" name="update_reward" class="bg-[#2ECC71] h-auto w-auto px-[14px] py-2 rounded-[10px] text-xs font-semibold text-light">Simpan Perubahan</button>
                                <button type="button" onclick="document.getElementById('edit').close();" class="bg-[#95A5A6] h-auto w-auto px-[14px] py-2 rounded-[10px] text-xs font-semibold text-light">Batal</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            <?php endif; ?>


            <dialog id="saved" class="modal"  <?= $modal_open_edit ? 'open' : ''; ?>>
                <div class="modal-box bg-light w-[593px] h-auto rounded-[20px] gap-10 flex flex-col items-center py-[75px]">
                    <h3 class="text-[32px] font-bold text-center text-dark">Data berhasil disimpan</h3>
                    <img src="../../images/admin/checklist.png" class="w-[100px]" alt="">
                </div>
                <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
                    <button> </button>
                </form>
            </dialog>

         

        </div>
    </div>
</body>
</html>