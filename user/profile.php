<?php
session_start();  // Pastikan session sudah dimulai

// Koneksi ke database
include '../controller/config.php';  // Sesuaikan dengan path file database.php

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../landing-page.php");
    exit();
}

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id']; // Pastikan user_id disimpan di sesi saat login

// Query untuk mengambil data pengguna
$sql_user = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_user = $stmt->get_result();
$user = $result_user->fetch_assoc();

// Ambil total berat sampah (total waste weight)
$sql_waste = "SELECT SUM(waste_weight) AS total_weight FROM detail_request WHERE request_id IN (SELECT request_id FROM drop_off_request WHERE user_id = ?)";
$stmt_waste = $conn->prepare($sql_waste);
$stmt_waste->bind_param("i", $user_id);
$stmt_waste->execute();
$result_waste = $stmt_waste->get_result();
$waste = $result_waste->fetch_assoc();

// Ambil total poin yang sudah dikumpulkan
$sql_points = "SELECT user_total_points AS total_points FROM users WHERE user_id= ?";
$stmt_points = $conn->prepare($sql_points);
$stmt_points->bind_param("i", $user_id);
$stmt_points->execute();
$result_points = $stmt_points->get_result();
$points = $result_points->fetch_assoc();

// Ambil jumlah total drop off yang sudah dilakukan
$sql_drop_off = "SELECT COUNT(request_id) AS total_drop_off FROM drop_off_request WHERE user_id = ?";
$stmt_drop_off = $conn->prepare($sql_drop_off);
$stmt_drop_off->bind_param("i", $user_id);
$stmt_drop_off->execute();
$result_drop_off = $stmt_drop_off->get_result();
$drop_off = $result_drop_off->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en" class="bg-light dark:[color-scheme:light]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/styles.css" rel="stylesheet">
    <title>Lestari - Drop Off</title>
      <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'poppins': ['Poppins', 'sans-serif']
          }
        }
      }
    }
  </script>
    <script>
        function toggleModal() {
            const modal = document.getElementById("location-modal");
            modal.classList.toggle("hidden");
        }
    </script>
</head>
<body class="font-poppins">
<!-- NAVBAR -->
<div class="navbar bg-light h-20 px-4 md:px-10 justify-between sticky top-0 z-50">
   <!-- MOBILE SCREEN MODE -->
   <div class="navbar-start pl-1/2">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden" id="hamburger-btn">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h8m-8 6h16" />
            </svg>
            </div>
            <ul
            id="dropdown-menu"
            class="menu menu-sm dropdown-content bg-white rounded-box z-[1] mt-3 w-52 p-2 shadow hidden">
            <li><a href="../landing-page.php">Home</a></li>
            <li><a href="../user/tentang.php">Tentang Kami</a></li>
            <li>
              <a>Layanan</a>
              <ul class="p-2">
                <!-- Drop Off -->
                <li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <button onclick="window.location.href='../user/drop-off/dropoff.php'" >
                        <p>Drop Off</p>
                    </button>
                    <?php else: ?>
                    <button onclick="showModal()" >
                        <p>Drop Off</p>
                    </button>
                    <?php endif; ?>
                </li>
                 <!-- Rewards -->
                <li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <button onclick="window.location.href='../user/drop-off/poin.php'" >
                        <p>Rewards</p>
                    </button>
                    <?php else: ?>
                    <button onclick="showModal()" >
                        <p>Rewards</p>
                    </button>
                    <?php endif; ?>
                </li>
                
                <!-- Marketplace -->
                <li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <button onclick="window.location.href='../user/marketplace/marketplace.php'">
                        <p>Marketplace</p>
                    </button>
                    <?php else: ?>
                    <button onclick="showModal()" >
                        <p>Marketplace</p>
                    </button>
                    <?php endif; ?>
                </li>
                    </ul>
                </li>
            <li><a href="../user/blog.php">Blog</a></li>
            <li><a href="../user/kontak-kami.php">Kontak Kami</a></li>
          </ul>
        </div>
        <!-- BRAND LOGO -->
        <a href="../landing-page.php" class="ml-1">
          <img src="../images/logo-crop.png" class="h-4 sm:h-5 md:h-6 lg:h-7" alt="Logo Lestari">
        </a>
      </div>
<!-- DESKTOP MODE -->
<div class="navbar-center hidden lg:flex">
  <ul class="menu menu-horizontal px-1 text-dark text-base">
    <li><a href="../landing-page.php">Home</a></li>
    <li><a href="../user/tentang.php">Tentang Kami</a></li>
    <li>
      <details>
        <summary>Layanan</summary>
        <ul class="bg-light absolute left-1/2 transform -translate-x-1/2 rounded-[10px] border-[1px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border-gray px-[14px] py-[20px] flex flex-wrap items-center gap-3 min-w-[300px] max-w-[600px]">
          <!-- Drop Off -->
          <li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button onclick="window.location.href='../user/drop-off/dropoff.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../images/truck.png" class="w-8 h-8" alt="">
                <p>Drop Off</p>
              </button>
            <?php else: ?>
              <button onclick="showModal()" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../images/truck.png" class="w-8 h-8" alt="">
                <p>Drop Off</p>
              </button>
            <?php endif; ?>
          </li>
          <!-- Rewards -->
          <li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button onclick="window.location.href='../user/drop-off/poin.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../images/reward.png" class="w-8 h-8" alt="">
                <p>Rewards</p>
              </button>
            <?php else: ?>
              <button onclick="showModal()" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../images/reward.png" class="w-8 h-8" alt="">
                <p>Rewards</p>
              </button>
            <?php endif; ?>
          </li>
          
          <!-- Marketplace -->
          <li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button onclick="window.location.href='../user/marketplace/marketplace.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../images/marketplace.png" class="w-8 h-8" alt="">
                <p>Marketplace</p>
              </button>
            <?php else: ?>
              <button onclick="showModal()" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../images/marketplace.png" class="w-8 h-8" alt="">
                <p>Marketplace</p>
              </button>
            <?php endif; ?>
          </li>
        </ul>
      </details>
    </li>
    <li><a href="../user/blog.php">Blog</a></li>
    <li><a href="../user/kontak-kami.php">Kontak Kami</a></li>
  </ul>
</div>


<!-- Profile -->
<div class="navbar-end ml-[5px] flex items-center gap-x-0 md:gap-4">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <!-- Dropdown User -->
        <div class="relative">
            <button class="font-medium text-sm text-[#1B5E20] focus:outline-none" onclick="toggleDropdown()">
                Halo, <?= htmlspecialchars($_SESSION['user_name']); ?> 
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-md z-10">
                <a href="../user/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                <a href="../backend/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
        </div>
    <?php else: ?>
      <!-- Tombol Sign In dan Sign Up jika belum login -->
        <a href="../user/signin.php" class="btn md:min-w-[100px] md:h-12 md:shadow-md md:rounded-full md:bg-gradient-to-r from-green to-dark-green md:text-sm md:border md:border-to-r md:from-green md:to-dark-green md:font-medium md:text-white md:text-center text-base bg-transparent text-sm text-[#1B5E20] border-0 shadow-none">
          Sign In
        </a>
        <a href="../user/signup.php" class="btn btn-outline md:min-w-[100px] md:h-12 md:shadow-md md:border border-to-r from-green to-dark-green md:rounded-full md:text-sm md:font-medium md:text-[#1B5E20] md:text-center text-base bg-transparent text-sm text-[#1B5E20] border-0 shadow-none whitespace-nowrap">
          Sign Up
        </a>
    <?php endif; ?>
</div>

<script>
    // Toggle dropdown visibility
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown if clicked outside
    window.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdownMenu');
        const button = event.target.closest('button');
        // Jika yang diklik bukan tombol atau dropdown, sembunyikan dropdown
        if (!button || button.getAttribute('onclick') !== 'toggleDropdown()') {
            dropdown.classList.add('hidden');
        }
    });
</script>
    </div>
    <!-- navbar -->
    <script>
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const dropdownMenu = document.getElementById('dropdown-menu');

        hamburgerBtn.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });
    </script>
  <!-- NAVBAR END -->

  <!-- Profile Section -->
  <main class="container mx-auto mt-8 md:px-16 px-8">
        <div class="bg-gradient-to-r from-green to-dark-green text-white rounded-lg p-6 text-center">
            <h2 class="text-2xl font-bold mt-4"><?= htmlspecialchars($user['user_name']); ?></h2>
            <p class="text-sm">Aktif</p>
        </div>

        <!-- Stats -->
        <div class="mt-6 grid grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-lg font-bold text-green-600"><?= $waste['total_weight']; ?> Kg</p>
                <p class="text-sm text-gray-600">Total Sampah</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-lg font-bold text-green-600"><?= $points['total_points']; ?> Poin</p>
                <p class="text-sm text-gray-600">Point Reward</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <p class="text-lg font-bold text-green-600"><?= $drop_off['total_drop_off']; ?></p>
                <p class="text-sm text-gray-600">Drop Off</p>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="mt-8 bg-white rounded-lg shadow p-6 mb-12">
      <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Pribadi</h3>
      <div class="space-y-4">
        <div>
          <label class="block text-gray-600 text-sm">Nama Lengkap</label>
          <input type="text" value="<?php echo htmlspecialchars($user['user_name']); ?>" class="w-full border border-gray-300 rounded px-4 py-2" readonly>
        </div>
        <div>
          <label class="block text-gray-600 text-sm">Email</label>
          <input type="text" value="<?php echo htmlspecialchars($user['user_email']); ?>" class="w-full border border-gray-300 rounded px-4 py-2" readonly>
        </div>
        <div>
          <label class="block text-gray-600 text-sm">Nomor Telepon</label>
          <input type="text" value="<?php echo htmlspecialchars($user['user_phone_number']); ?>" class="w-full border border-gray-300 rounded px-4 py-2" readonly>
        </div>
        <div>
          <label class="block text-gray-600 text-sm">Alamat</label>
          <input type="text" value="<?php echo htmlspecialchars($user['user_address']); ?>" class="w-full border border-gray-300 rounded px-4 py-2" readonly>
        </div>
        <div>
                    <label class="block text-gray-600 text-sm">Bergabung Sejak</label>
                    <input type="text" value="<?= date("F Y", strtotime($user['created_at'])); ?>" class="w-full border border-gray-300 rounded px-4 py-2" readonly>
  </div>

            <div class="flex justify-between mt-6">
                <a href="../backend/logout.php"  class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Logout</a>
                <a href="../user/settings.php" class="bg-gradient-to-r from-green to-dark-green text-white px-4 py-2 rounded">
                    Pengaturan
                </a>
            </div>
        </div>
    </main>
    
<!-- Footer -->
<footer class="bg-gradient-to-r from-green to-dark-green text-white py-7">
  <div class="container mx-auto px-12">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <a href="../landing-page.php">
      <img src="../images/logo-crop-white.png" alt="Logo Lestari" class="h-7 lg:h-9">
      </a>
    </div>
    
    <!-- Grid Container -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center md:text-left">
      <!-- Bagian Lestari -->
      <div class="text-left col-span-1 md:col-span-1">
        <h4 class="font-bold mb-2">Lestari</h4>
        <a href="../landing-page.php" class="block text-white hover:underline mb-1">Home</a>
        <a href="../user/tentang.php" class="block text-white hover:underline mb-1">Tentang Kami</a>
        <a href="../landing-page.php" class="block text-white hover:underline mb-1">Layanan</a>
        <a href="../user/blog.php" class="block text-white hover:underline mb-1">Blog</a>
      </div>

      <!-- Bagian Informasi -->
      <div class="text-right md:text-center col-span-1 md:col-span-1">
        <h4 class="font-bold mb-2">Informasi</h4>
        <a href="../user/kontak-kami.php" class="block text-white hover:underline mb-1">Kontak Kami</a>
      </div>

      <!-- Bagian Hubungi Kami -->
      <div class="col-span-2 md:col-span-1 text-center">
        <h4 class="font-bold mb-2">Hubungi Kami</h4>
        <div class="flex justify-center space-x-4 mt-2">
          <a href="#"><img src="../images/user/sosmed/instagram.png" alt="Instagram"></a>
          <a href="#"><img src="../images/user/sosmed/fb.png" alt="Facebook"></a>
          <a href="#"><img src="../images/user/sosmed/x.png" alt="Twitter"></a>
          <a href="#"><img src="../images/user/sosmed/wa.png" alt="Whatsapp"></a>
          <a href="#"><img src="../images/user/sosmed/yt.png" alt="YouTube"></a>
        </div>
      </div>
    </div>
  </div>
</footer>
<script>
    // Notifikasi jika belum login
    function alertLogin() {
        alert("Silakan login untuk mengakses layanan ini.");
    }
    //modal
    function showModal() {
    document.getElementById('loginModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('loginModal').classList.add('hidden');
    }

</script>
</body>
</html>