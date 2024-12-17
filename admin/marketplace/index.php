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

// Proses hapus produk
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query untuk menghapus data
    $sql = "DELETE FROM marketplace WHERE marketplace_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        // Beri pesan jika penghapusan berhasil
        $message = "Produk berhasil dihapus.";
    } else {
        // Pesan error jika penghapusan gagal
        $message = "Gagal menghapus Produk. " . $stmt->error;
    }
    $stmt->close();
    
    // Redirect kembali ke halaman kelola reward setelah penghapusan
    header("Location: index.php");
    exit();
}


// Filter pencarian dan pengurutan
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
$urutkan = isset($_GET['urutkan']) ? trim($_GET['urutkan']) : '';

// Menyiapkan query dasar
$sql = "SELECT * FROM marketplace WHERE marketplace_product_name LIKE ?";
$params = ['%' . $search . '%'];
$types = 's';

// Menambahkan urutan berdasarkan pilihan
if ($urutkan === 'harga_asc') {
    $sql .= " ORDER BY marketplace_price ASC";
} elseif ($urutkan === 'harga_desc') {
    $sql .= " ORDER BY marketplace_price DESC";
} elseif ($urutkan === 'nama') {
    $sql .= " ORDER BY marketplace_product_name ASC";
}

// Menyiapkan dan menjalankan query
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/styles.css" rel="stylesheet">
    <title>Marketplace | Admin Lestari</title>
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
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../kelola-reward/'">
                    <img src="../../images/admin/prize.png" class="w-[30px]" alt="">
                    <p>Kelola Reward</p>
                </button>
                <button class="btn btn-success bg-green-btn border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../marketplace/'">
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
                <h1>Marketplace</h1>
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
          <div class="mt-7 w-1/3">
                <form action="index.php" method="get" class="flex flex-col lg:flex-row gap-4">
                    <!-- Input Pencarian -->
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari produk..." 
                        value="<?= htmlspecialchars($search) ?>" 
                        class="min-w-72 px-1 text-dark text-sm font-light bg-light rounded-[5px] py-1.5 h-[34px] border border-gray">
                    
                    <!-- Pilihan Urutkan -->
                    <select 
                        name="urutkan" 
                        class="w-auto h-[34px] bg-light border border-gray rounded-[5px] text-sm px-3 py-1.5 font-medium text-dark">
                            <option value="">Urutkan Berdasarkan</option>
                            <option value="harga_asc" <?= $urutkan === 'harga_asc' ? 'selected' : '' ?>>Harga Termurah</option>
                            <option value="harga_desc" <?= $urutkan === 'harga_desc' ? 'selected' : '' ?>>Harga Termahal</option>
                            <option value="nama" <?= $urutkan === 'nama' ? 'selected' : '' ?>>Nama Produk</option>
                    </select>
                    <!-- Tombol Cari -->
                      <button type="submit" class="btn-success bg-[#2E9E5D] text-light w-auto py-2 px-4 text-base font-medium rounded-md shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border border-gray">
                         Cari
                     </button>
                </form>
            </div>
            <!-- BUTTONS END -->

            <!-- TABLE -->
            <div class="bg-light rounded-[10px] w-full h-auto shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] p-10 mt-10 text-dark gap-[18px] flex flex-col">
                <div class="grid grid-cols-3 gap-[30px]">
                    <!-- CARDS -->
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="bg-light w-auto h-auto shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] px-3 pb-[15px]">
                                <figure class="pt-[7px] justify-self-center">
                                    <img src="<?= htmlspecialchars($row['marketplace_image'] ? '../../images/user/products/' . $row['marketplace_image'] : '../../images/default.jpg'); ?>" 
                                         alt="Product Image" 
                                         class="rounded-[15px]" />
                                </figure>
                                <div class="mt-[31px] gap-[5px] flex flex-col">
                                    <h3 class="text-dark text-[15px] font-extrabold"><?= htmlspecialchars($row['marketplace_product_name']) ?></h3>
                                    <h2 class="text-xl text-[#077E46] font-semibold max-w-[238px]">Rp <?= number_format($row['marketplace_price'], 0, ',', '.') ?></h2>
                                    <p class="text-[10px] opacity-50 font-normal text-dark"><?= $row['marketplace_description'] ?></p>
                                </div>

                                <div class="mt-[21px] h-[21px] flex justify-center">
                                     <a href="javascript:void(0)" onclick="showDeleteDialog(<?= $row['marketplace_id']; ?>)">
                                          <button class="bg-[#C0392B] h-full w-[77px] rounded-[10px] text-[10px] font-semibold text-light flex flex-row gap-1 justify-center items-center">
                                             <img class="w-[10px]" src="../../images/admin/trash.png" alt="">
                                             <span>Hapus</span>
                                          </button>
                                     </a>
                                </div>
                            </div> 
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Tidak ada produk ditemukan.</p>
                    <?php endif; ?>
                </div> 
            <!-- CARDS END  -->

              <!-- Dialog Konfirmasi Hapus -->
           <dialog id="delete" class="modal">
               <div class="modal-box bg-light w-auto h-auto rounded-[20px] gap-[17px] flex flex-col items-center py-[42px] px-[83px]">
                    <img src="../../images/admin/delete-alert.png" class="w-[60px]" alt="">
                    <h3 class="text-[20px] font-bold text-center text-dark">Konfirmasi Hapus</h3>
                    <p class="text-center text-xs font-normal text-dark leading-relaxed">Apakah Anda yakin ingin menghapus informasi ini?<br>
                      Tindakan ini tidak dapat dibatalkan</p>
                    <div class="mt-10">
                        <form method="dialog" class="flex flex-row-reverse items-end gap-[18px]">
                          <!-- Tombol Ya, Hapus -->
                          <button type="button" onclick="confirmDelete()" class="bg-[#EB3223] h-auto w-auto px-[14px] py-2 rounded-[10px] text-xs font-semibold text-light">Ya, Hapus</button>
                          <!-- Tombol Batal -->
                          <button type="button" onclick="closeDeleteDialog()" class="bg-[#95A5A6] h-auto w-auto px-[14px] py-2 rounded-[10px] text-xs font-semibold text-light">Batal</button>
                        </form>
                    </div>
                </div>                
            </dialog>

           <!-- Dialog Data Berhasil Dihapus -->
           <dialog id="deleted" class="modal">
               <div class="modal-box bg-light w-[531px] h-auto py-24 rounded-[20px] gap-6 flex flex-col items-center align-middle content-center">
                    <h3 class="text-[32px] font-bold text-center text-dark">Data berhasil dihapus</h3>
                    <img src="../../images/admin/checklist.png" class="w-[100px]" alt="">
                </div>
                <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
                    <button type="button" onclick="closeDeletedDialog()"> </button>
                </form>
           </dialog>

        <script>
           let rewardIdToDelete = null;

            // Menampilkan dialog konfirmasi hapus
            function showDeleteDialog(rewardId) {
                 rewardIdToDelete = rewardId;  // Menyimpan reward_id yang akan dihapus
                 document.getElementById('delete').showModal();
            }

            // Menutup dialog konfirmasi hapus
            function closeDeleteDialog() {
                  document.getElementById('delete').close();
            }

            // Menampilkan dialog "Data berhasil dihapus"
            function showDeletedDialog() {
                  document.getElementById('delete').close();  // Menutup dialog konfirmasi
                  document.getElementById('deleted').showModal();  // Menampilkan dialog sukses
            }

            // Fungsi Konfirmasi Penghapusan
            function confirmDelete() {
                if (rewardIdToDelete) {
                   // Redirect ke halaman PHP untuk menghapus data
                    window.location.href = "?delete_id=" + rewardIdToDelete;
                }
            }

            // Menutup dialog "Data berhasil dihapus"
              function closeDeletedDialog() {
                 document.getElementById('deleted').close();
            }
        </script>

        </div>
    </div>
</body>
</html>
