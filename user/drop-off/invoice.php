<?php
session_start();  // Pastikan session sudah dimulai

// Koneksi ke database
include '../../controller/config.php';  // Sesuaikan dengan path file database.php

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../landing-page.php");
    exit();
}

// Get user_id from session
$user_id = $_SESSION['user_id']; // Ensure 'user_id' is stored in session

$bank_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$bank_id) {
    die('Bank ID tidak ditemukan. Silakan coba lagi.');
}

// Insert new drop_off request if not already inserted in this session
if (!isset($_SESSION['drop_off_inserted'])) {
  $stmt = $conn->prepare("INSERT INTO drop_off_request (user_id, bank_id, status, drop_off_request_created_at, drop_off_request_updated_at) VALUES (?, ?, 'waiting', NOW(), NOW())");
  $stmt->bind_param("ii", $user_id, $bank_id); // Pastikan kedua parameter user_id dan bank_id diikat dengan benar
  
  if ($stmt->execute()) {
      $request_id = $stmt->insert_id; // Ambil ID request terakhir
      $_SESSION['drop_off_inserted'] = true; // Set session untuk menandai data sudah dimasukkan
      $_SESSION['request_id'] = $request_id; // Simpan request_id di session
  } else {
      die("Error inserting data: " . $stmt->error);
  }
  

    $stmt->close();
} else {
    // Retrieve request_id from session
    $request_id = $_SESSION['request_id'];
}

$query = "SELECT d.request_id, d.status, d.drop_off_request_created_at, u.user_email, 
                 COALESCE(SUM(dr.waste_weight * w.waste_point), 0) AS total_points, 
                 GROUP_CONCAT(w.waste_name SEPARATOR ', ') AS waste_names,
                 GROUP_CONCAT(CONCAT(w.waste_name, ' ', dr.waste_weight, 'kg') SEPARATOR ', ') AS waste_details
          FROM drop_off_request d
          INNER JOIN users u ON d.user_id = u.user_id
          LEFT JOIN detail_request dr ON d.request_id = dr.request_id
          LEFT JOIN waste w ON dr.waste_id = w.waste_id
          WHERE d.request_id = ?
          GROUP BY d.request_id";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if there's any result
if ($result->num_rows > 0) {
    $request = $result->fetch_assoc();
} else {
    die('Error: No drop_off request found for this user.');
}

// Store total points in a variable for use in the modal
$total_points = $request['total_points'];
?>
<!DOCTYPE html>
<html lang="en"class="bg-light dark:[color-scheme:light]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/styles.css" rel="stylesheet">
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
            const modal = document.getElementById("rewardModal");
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
            <li><a href="../../landing-page.php">Home</a></li>
            <li><a href="../../user/tentang.php">Tentang Kami</a></li>
            <li>
              <a>Layanan</a>
              <ul class="p-2">
                <!-- Drop Off -->
                <li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <button onclick="window.location.href='../../user/drop-off/dropoff.php'" >
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
                    <button onclick="window.location.href='../../user/drop-off/poin.php'" >
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
                    <button onclick="window.location.href='../../user/marketplace/marketplace.php'">
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
            <li><a href="../../user/blog.php">Blog</a></li>
            <li><a href="../../user/kontak-kami.php">Kontak Kami</a></li>
          </ul>
        </div>
         <!-- BRAND LOGO -->
         <a href="../../landing-page.php" class="ml-1">
          <img src="../../images/logo-crop.png" class="h-4 sm:h-5 md:h-6 lg:h-7" alt="Logo Lestari">
        </a>
      </div>
<!-- DESKTOP MODE -->
<div class="navbar-center hidden lg:flex">
  <ul class="menu menu-horizontal px-1 text-dark text-base">
    <li><a href="../../landing-page.php">Home</a></li>
    <li><a href="../../user/tentang.php">Tentang Kami</a></li>
    <li>
      <details>
        <summary>Layanan</summary>
        <ul class="bg-light absolute left-1/2 transform -translate-x-1/2 rounded-[10px] border-[1px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border-gray px-[14px] py-[20px] flex flex-wrap items-center gap-3 min-w-[300px] max-w-[600px]">
          <!-- Drop Off -->
          <li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button onclick="window.location.href='../../user/drop-off/dropoff.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../../images/truck.png" class="w-8 h-8" alt="">
                <p>Drop Off</p>
              </button>
            <?php else: ?>
              <button onclick="showModal()" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../../images/truck.png" class="w-8 h-8" alt="">
                <p>Drop Off</p>
              </button>
            <?php endif; ?>
          </li>
          <!-- Rewards -->
          <li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button onclick="window.location.href='../../user/drop-off/poin.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../../images/reward.png" class="w-8 h-8" alt="">
                <p>Rewards</p>
              </button>
            <?php else: ?>
              <button onclick="showModal()" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../../images/reward.png" class="w-8 h-8" alt="">
                <p>Rewards</p>
              </button>
            <?php endif; ?>
          </li>
         
          <!-- Marketplace -->
          <li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button onclick="window.location.href='../../user/marketplace/marketplace.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../../images/marketplace.png" class="w-8 h-8" alt="">
                <p>Marketplace</p>
              </button>
            <?php else: ?>
              <button onclick="showModal()" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="../../images/marketplace.png" class="w-8 h-8" alt="">
                <p>Marketplace</p>
              </button>
            <?php endif; ?>
          </li>
        </ul>
      </details>
    </li>
    <li><a href="../../user/blog.php">Blog</a></li>
    <li><a href="../../user/kontak-kami.php">Kontak Kami</a></li>
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
                <a href="../../user/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                <a href="../../backend/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
        </div>
    <?php else: ?>
      <!-- Tombol Sign In dan Sign Up jika belum login -->
        <a href="../../user/signin.php" class="btn md:min-w-[100px] md:h-12 md:shadow-md md:rounded-full md:bg-gradient-to-r from-green to-dark-green md:text-sm md:border md:border-to-r md:from-green md:to-dark-green md:font-medium md:text-white md:text-center text-base bg-transparent text-sm text-[#1B5E20] border-0 shadow-none">
          Sign In
        </a>
        <a href="../../user/signup.php" class="btn btn-outline md:min-w-[100px] md:h-12 md:shadow-md md:border border-to-r from-green to-dark-green md:rounded-full md:text-sm md:font-medium md:text-[#1B5E20] md:text-center text-base bg-transparent text-sm text-[#1B5E20] border-0 shadow-none whitespace-nowrap">
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

    <!-- Main Content -->
    <main class="bg-light container mx-auto md:px-16 px-10 py-12">
        <div class="bg-white rounded-xl shadow-lg p-6 relative">
            <!-- Icon and Heading -->
            <div class="text-center">
                <img src="../../images/Logo admin.png" alt="Icon" class="mx-auto mb-4">
            </div>
             <!-- Status Section -->
              <div class="bg-gray-50 rounded-lg shadow p-4 mb-4">
                  <h3 class="text-green-700 font-semibold text-sm">Status Verifikasi</h3>
                  <p class="text-sm text-gray-600">
                      Status: 
                      <span class="<?= 
                          $request['status'] === 'waiting' 
                              ? 'text-yellow-500' 
                              : ($request['status'] === 'rejected' 
                                  ? 'text-red-500' 
                                  : 'text-green-600'); 
                      ?> font-bold">
                          <?= htmlspecialchars(ucfirst($request['status'])); ?>
                      </span>
                  </p>
              </div>

            <!-- Drop Off Information -->
            <div class="flex justify-between items-center text-sm text-green-600 font-semibold">
                <span><?= date('d M Y · H:i', strtotime($request['drop_off_request_created_at'])); ?></span>
                <span><?= htmlspecialchars($request['user_email']); ?></span>
                </div>
                <hr class="border-dashed border-green-600 my-4">
            <!-- Drop Off Details -->
            <div class="mt-6 space-y-4">
                <div>
                    <h3 class="text-green-700 font-semibold text-sm">DROP OFF - LESTARI</h3>
                    <div class="bg-gray-50 rounded-lg shadow p-4 flex justify-between items-center">
                        <span>Total Poin</span>
                        <span class="text-green-600 font-bold">$<?= number_format($request['total_points']); ?></span>
                    </div>
                </div>
                <div>
                    <h3 class="text-green-700 font-semibold text-sm">DETAIL DROP OFF</h3>
                    <div class="bg-gray-50 rounded-lg shadow p-4">
                        <span><?= htmlspecialchars($request['waste_details']); ?></span>
                    </div>
                </div>
            </div>
            <!-- Button -->
            <div class="mt-8 text-center">
                <button onclick="toggleModal()" class="bg-gradient-to-r from-green to-dark-green text-white font-semibold rounded-full px-6 py-2 hover:bg-green-700">
                    Klaim Poin
                </button>
            </div>
        </div>
    </main>
    <!-- Modal -->
    <div id="rewardModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
     <div class="bg-white rounded-lg p-6 w-80 text-center relative">
      <div class="absolute top-2 right-2 cursor-pointer" onclick="toggleModal()">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 hover:text-gray-700" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </div>
      <div class="mb-4">
        <img src="../../images/user/selamat.png" alt="Reward Icon" class="mx-auto">
      </div>
      <p class="text-green-700 font-semibold mb-4">Kamu mendapatkan poin</p>
      <div class="bg-green-50 border border-green-500 rounded-lg p-4 flex justify-center items-center mb-4">
        <span class="text-green-600 font-bold text-2xl">+ <?= number_format($request['total_points']); ?></span>
      </div>
      <button onclick="window.location.href='../../user/drop-off/poin.php'" class="bg-gradient-to-r from-green to-dark-green text-white py-2 px-4 rounded-full shadow-lg hover:bg-green-600">
          Lihat Poin
      </button>
    </div>
  </div>
<!-- Footer -->
<footer class="bg-gradient-to-r from-green to-dark-green text-white py-7">
  <div class="container mx-auto px-12">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <a href="../../landing-page.php">
      <img src="../../images/logo-crop-white.png" alt="Logo Lestari" class="h-7 lg:h-9">
      </a>
    </div>
    
    <!-- Grid Container -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center md:text-left">
      <!-- Bagian Lestari -->
      <div class="text-left col-span-1 md:col-span-1">
        <h4 class="font-bold mb-2">Lestari</h4>
        <a href="../../landing-page.php" class="block text-white hover:underline mb-1">Home</a>
        <a href="../../user/tentang.php" class="block text-white hover:underline mb-1">Tentang Kami</a>
        <a href="../../landing-page.php" class="block text-white hover:underline mb-1">Layanan</a>
        <a href="../../user/blog.php" class="block text-white hover:underline mb-1">Blog</a>
      </div>

      <!-- Bagian Informasi -->
      <div class="text-right md:text-center col-span-1 md:col-span-1">
        <h4 class="font-bold mb-2">Informasi</h4>
        <a href="../../user/kontak-kami.php" class="block text-white hover:underline mb-1">Kontak Kami</a>
      </div>

      <!-- Bagian Hubungi Kami -->
      <div class="col-span-2 md:col-span-1 text-center">
        <h4 class="font-bold mb-2">Hubungi Kami</h4>
        <div class="flex justify-center space-x-4 mt-2">
          <a href="#"><img src="../../images/user/sosmed/instagram.png" alt="Instagram"></a>
          <a href="#"><img src="../../images/user/sosmed/fb.png" alt="Facebook"></a>
          <a href="#"><img src="../../images/user/sosmed/x.png" alt="Twitter"></a>
          <a href="#"><img src="../../images/user/sosmed/wa.png" alt="Whatsapp"></a>
          <a href="#"><img src="../../images/user/sosmed/yt.png" alt="YouTube"></a>
        </div>
      </div>
    </div>
  </div>
</footer>
</body>
</html>


<?php
// Close the database connection
$conn->close();
?>