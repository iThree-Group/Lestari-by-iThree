<?php
include 'connect_admin.php';

// Mengambil data dari tabel redeem
$sql = "SELECT redeem.*, rewards.reward_name, rewards.reward_points_required
FROM redeem
JOIN rewards ON redeem.reward_id = rewards.reward_id
WHERE redeem.bank_id = ?
ORDER BY redeem.created_at DESC;
";

// Pastikan koneksi ke database ($conn) sudah dibuat sebelumnya
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bank_id);
$stmt->execute();

// Simpan hasil dalam $redeem_result
$redeem_result = $stmt->get_result();
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
            
            <!-- BUTTONS -->
            <div class="flex flex-row gap-[22px] mt-[31px] ">
                <button class="btn btn-warning h-[42px] px-[27px] text-light rounded-[20px] border border-dark bg-[#F6AC0A] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] font-medium text-xl" onclick="location.href='./'">
                    Kelola Produk Reward
                </button>
                <button class="btn btn-warning h-[42px] px-[27px] text-light rounded-[20px] mr-auto border border-dark bg-[#F6AC0A] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] font-medium text-xl" onclick="location.href='./redeem-list.php'">
                    Daftar Tukar Reward
                </button>
            </div>
            <!-- BUTTONS END -->

             <!-- GRID -->
                <!-- TABLE -->
                <div class="table w-full mt-7">
                     <div class="overflow-x-auto">
                         <table class="table border-collapse border border-[#828282] text-center text-dark">
                        <!-- head -->
                         <thead class="bg-[#E5E5E5] text-sm font-bold text-dark">
                            <tr class="border border-[#828282]">
                                <th class="border border-[#828282]">Tanggal</th>
                                <th class="border border-[#828282]">ID User</th>
                                <th class="border border-[#828282]">Item Reward</th>
                                <th class="border border-[#828282]">Poin</th>
                                <th class="border border-[#828282]">Status</th>
                                <th class="border border-[#828282]">Aksi</th>
                            </tr>
                         </thead>
                         <tbody class="font-medium">
                            <?php while ($row = $redeem_result->fetch_assoc()): ?>
                                <tr>
                                    <td class="border border-[#828282]"><?= date("d/m/Y", strtotime($row['created_at'])); ?></td>
                                    <td class="border border-[#828282]"><?= htmlspecialchars($row['user_id']); ?></td>
                                    <td class="border border-[#828282]"><?= htmlspecialchars($row['reward_name']); ?></td>
                                    <td class="border border-[#828282]"><?= htmlspecialchars($row['reward_points_required']); ?></td>
                                    <td class="border border-[#828282]">
                                        <?php if ($row['status'] === 'pending'): ?>
                                            <p class="bg-[#FFDE75] rounded-[10px] px-4 py-1.5 w-auto place-self-center text-sm font-medium text-center">
                                                <?= htmlspecialchars(ucfirst($row['status'])); ?>
                                            </p>
                                        <?php elseif ($row['status'] === 'approved'): ?>
                                            <p class="bg-[#299E63] text-light rounded-[10px] px-4 py-1.5 w-auto place-self-center text-sm font-medium text-center">
                                                <?= htmlspecialchars(ucfirst($row['status'])); ?>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td class="border border-[#828282]"><?= htmlspecialchars(ucfirst($row['status'])); ?></td> -->
                                    <td class="border border-[#828282]">
                                        <?php if ($row['status'] === 'approved'): ?>
                                            <img src="../../images/admin/checklist-redeem.png" class="w-[30px] justify-self-center" alt="success">
                                        <?php endif; ?>
                                        <?php if ($row['status'] === 'pending'): ?>
                                            <button 
                                                class="btn-approve bg-green-btn text-white px-4 py-2 rounded-lg text-light" 
                                                data-redeem-id="<?= htmlspecialchars($row['redeem_id']); ?>">Verifikasi</button>
                                        <?php else: ?>
                                            <!-- <span class="text-gray-500">Approved</span> -->
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                       </table>
                   </div>
                </div>
                <!-- TABLE END -->

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

            <dialog id="denied" class="modal">
                <div class="modal-box bg-light w-[593px] h-auto rounded-[20px] gap-10 flex flex-col items-center py-[75px]">
                    <h3 class="text-[32px] font-bold text-center text-dark">Data ditolak</h3>
                    <img src="../../images/admin/denied.png" class="w-[100px]" alt="">
                </div>
                <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
                    <button> </button>
                </form>
            </dialog>

            <dialog id="edit" class="modal">
                <div class="modal-box bg-light min-w-[550px] h-auto rounded-[20px] gap-[18px] flex flex-col px-10 py-7">
                    <h3 class="text-2xl font-bold text-dark">Edit Produk</h3>
                    <form class="flex flex-col gap-[18px] w-full text-dark">
                        <div class="flex flex-col gap-[9px]">
                            <label for="nama-produk" class="text-sm font-medium">Nama Produk</label>
                            <input type="text" id="nama-produk" name="nama-produk" value="Kantong Plastik Sampah Roll" class="w-full h-7 bg-light border border-gray px-1.5 font-normal text-xs">
                        </div>
                        <div class="flex flex-col gap-[9px]">
                            <label for="jumlah-poin" class="text-sm font-medium">Jumlah Poin</label>
                            <input type="number" id="jumlah-poin" name="jumlah-poin" min="0" value="1000" class="w-full h-7 bg-light border border-gray px-1.5 font-normal text-xs dark:[color-scheme:light]">
                        </div>
                        <div class="flex flex-col gap-[9px]">
                            <label for="stok-produk" class="text-sm font-medium">Stok</label>
                            <input type="number" id="stok-produk" name="stok-produk" min="0" value="20" class="w-full h-7 bg-light border border-gray px-1.5 font-normal text-xs dark:[color-scheme:light]">
                        </div>
                        <div class="flex flex-row-reverse gap-[15px] mt-2 items-end">
                            <button onclick="getElementById('saved').showModal()" class="bg-[#2ECC71] h-auto w-auto px-[14px] py-2 rounded-[10px] text-xs font-semibold text-light">Simpan Perubahan</button>
                    </form>
                            <form method="dialog">
                                <button class="bg-[#95A5A6] h-auto w-auto px-[14px] py-2 rounded-[10px] text-xs font-semibold text-light">Batal</button>
                            </form>
                        </div>
                </div>
            </dialog>

            <dialog id="approved" class="modal">
                <div class="modal-box bg-light w-[593px] h-auto rounded-[20px] gap-10 flex flex-col items-center py-[75px]">
                    <h3 class="text-[32px] font-bold text-center text-dark">Reward berhasil disetujui</h3>
                    <img src="../../images/admin/checklist.png" class="w-[100px]" alt="">
                </div>
                <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
                    <button> </button>
                </form>
            </dialog>

            <dialog id="delete" class="modal">
                <div class="modal-box bg-light w-auto h-auto rounded-[20px] gap-[17px] flex flex-col items-center py-[42px] px-[83px]">
                    <img src="../../images/admin/delete-alert.png" class="w-[60px]" alt="">
                    <h3 class="text-[20px] font-bold text-center text-dark">Konfirmasi Hapus</h3>
                    <p class="text-center text-xs font-normal text-dark leading-relaxed">Apakah Anda yakin ingin menghapus informasi ini?<br>
                    Tindakan ini tidak dapat dibatalkan</p>
                    <div class="mt-10">
                        <form method="dialog" class="flex flex-row-reverse items-end gap-[18px]">
                            <button onclick="getElementById('deleted').showModal()" class="bg-[#EB3223] h-auto w-auto px-[14px] py-2 rounded-[10px] text-xs font-semibold text-light">Ya, Hapus</button>
                            <button class="bg-[#95A5A6] h-auto w-auto px-[14px] py-2 rounded-[10px] text-xs font-semibold text-light">Batal</button>
                        </form>
                    </div>
                </div>                
            </dialog>

            <dialog id="deleted" class="modal">
                <div class="modal-box bg-light w-[531px] h-auto py-24 rounded-[20px] gap-6 flex flex-col items-center align-middle content-center">
                    <h3 class="text-[32px] font-bold text-center text-dark">Data berhasil dihapus</h3>
                    <img src="../../images/admin/checklist.png" class="w-[100px]" alt="">
                </div>
                <form method="dialog" class="modal-backdrop bg-light bg-opacity-25">
                    <button> </button>
                </form>
            </dialog>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const approveButtons = document.querySelectorAll('.btn-approve');
            approveButtons.forEach(button => {
               button.addEventListener('click', async () => {
                   const redeemId = button.getAttribute('data-redeem-id');
                   if (!redeemId) {
                       alert("ID Redeem tidak ditemukan.");
                       return;
                    }
                   try {
                        const response = await fetch("approve-redeem.php", {
                           method: "POST",
                           headers: {
                               "Content-Type": "application/json",
                            },
                            body: JSON.stringify({ redeem_id: redeemId }),
                        });

                        if (!response.ok) {
                           throw new Error(`HTTP error: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                        // Perbarui elemen tombol dan tampilkan status approved di UI
                        button.parentElement.innerHTML = `
                            <img src="../../images/admin/checklist-redeem.png" class="w-[30px] justify-self-center" alt="success">
                            <span class="text-gray-500">Approved</span>
                        `;
                        alert("Reward berhasil disetujui!");
                    } else {
                        alert("Gagal menyetujui reward: " + data.message);
                    }
                } catch (error) {
                    console.error("Kesalahan saat mengirim permintaan:", error);
                    alert("Terjadi kesalahan saat mengirim permintaan. Cek console untuk info lebih lanjut.");
                }
            });
        });
    });
</script>

</body>
</html>