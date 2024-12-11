<?php
session_start(); // Pastikan session sudah dimulai

// Koneksi ke database
include '../../controller/config.php'; // Sesuaikan dengan path file database.php

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../landing-page.php");
    exit();
}

// Get user_id from session
$user_id = $_SESSION['user_id']; // Pastikan 'user_id' disimpan di session

$bank_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$bank_id) {
    die('Bank ID tidak ditemukan. Silakan coba lagi.');
}

// Hitung total poin pengguna
$totalPoints = 0;
$queryPoints = "
    SELECT SUM(detail_request.points_earned) AS total_points
    FROM drop_off_request
    INNER JOIN detail_request ON drop_off_request.request_id = detail_request.request_id
    WHERE drop_off_request.user_id = ?";
$stmtPoints = $conn->prepare($queryPoints);
$stmtPoints->bind_param("i", $user_id);
$stmtPoints->execute();
$resultPoints = $stmtPoints->get_result();
if ($resultPoints && $resultPoints->num_rows > 0) {
    $row = $resultPoints->fetch_assoc();
    $totalPoints = $row['total_points'] ?? 0;
}
$stmtPoints->close();

// Ambil daftar rewards sesuai dengan bank_id
$queryRewards = "
    SELECT reward_id, reward_name, reward_points_required, reward_image 
    FROM rewards 
    WHERE bank_id = ? 
    ORDER BY created_at DESC";
$stmtRewards = $conn->prepare($queryRewards);
$stmtRewards->bind_param("i", $bank_id);
$stmtRewards->execute();
$resultRewards = $stmtRewards->get_result();

// Proses tukar poin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redeem'])) {
  $rewardId = intval($_POST['reward_id']);
  $rewardPointsRequired = intval($_POST['reward_points_required']);

  // Query untuk mengecek stok reward
  $queryStock = "SELECT stock FROM rewards WHERE reward_id = ? AND bank_id = ?";
  $stmtStock = $conn->prepare($queryStock);
  $stmtStock->bind_param("ii", $rewardId, $bank_id);
  $stmtStock->execute();
  $resultStock = $stmtStock->get_result();
  $stock = 0;

  if ($resultStock && $resultStock->num_rows > 0) {
      $row = $resultStock->fetch_assoc();
      $stock = $row['stock']; // Ambil stok reward
  }
  $stmtStock->close();

  // Cek apakah stok reward mencukupi
  if ($stock > 0) {
      // Cek apakah pengguna memiliki poin yang cukup
      if ($totalPoints >= $rewardPointsRequired) {
          // Insert transaksi penukaran ke database
          $queryRedeem = "
              INSERT INTO redeem (user_id, reward_id, bank_id, status, created_at, updated_at) 
              VALUES (?, ?, ?, 'pending', NOW(), NOW())";
          $stmtRedeem = $conn->prepare($queryRedeem);
          $stmtRedeem->bind_param("iii", $user_id, $rewardId, $bank_id);

          if ($stmtRedeem->execute()) {
              // Kurangi total poin setelah berhasil ditukar
              $totalPoints -= $rewardPointsRequired;

              // Kurangi stok reward setelah berhasil redeem
              $queryUpdateStock = "UPDATE rewards SET stock = stock - 1 WHERE reward_id = ?";
              $stmtUpdateStock = $conn->prepare($queryUpdateStock);
              $stmtUpdateStock->bind_param("i", $rewardId);
              $stmtUpdateStock->execute();
              $stmtUpdateStock->close();

              echo "<script>
                  window.onload = function() {
                      document.getElementById('popupSuccess').classList.remove('hidden');
                  };
              </script>";
          } else {
              echo "<script>
                  alert('Terjadi kesalahan saat memproses penukaran.');
              </script>";
          }

          $stmtRedeem->close();
      } else {
          echo "<script>
                  window.onload = function() {
                      document.getElementById('popupPoinTidakCukup').classList.remove('hidden');
                  };
              </script>";
      }
  } else {
      // Jika stok reward habis
      echo "<script>
                  window.onload = function() {
                      document.getElementById('popupStockHabis').classList.remove('hidden');
                  };
              </script>";
  }
}

?>


<!DOCTYPE html>
<html lang="en" class="bg-light dark:[color-scheme:light]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/styles.css" rel="stylesheet">
    <title>Lestari - Tukar Poin</title>
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
        function togglePopup(rewardId, rewardPointsRequired, rewardName, rewardImage) {
    const popup = document.getElementById("popupReward");
    const rewardIdInput = document.getElementById("reward_id");
    const rewardPointsInput = document.getElementById("reward_points_required");
    const rewardNameElement = document.getElementById("rewardName");
    const rewardImageElement = document.getElementById("rewardImage");

    rewardIdInput.value = rewardId;
    rewardPointsInput.value = rewardPointsRequired;
    rewardNameElement.textContent = rewardName;
    rewardImageElement.src = rewardImage;

    popup.classList.toggle("hidden");
}

        function closePopup() {
            const popup = document.getElementById("popupReward");
            popup.classList.add("hidden");
        }
    </script>
</head>
<body class="font-poppins">
<!-- NAVBAR -->
<div class="navbar bg-light h-20 pr-10 justify-between sticky top-0 z-50">
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
            <li><a href="../../user/tentang.php">Tentang kami</a></li>
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
        <a href="../../landing-page.php" class="">
          <img src="../../images/Logo.png" alt="Logo Lestari">
        </a>
      </div>
<!-- DESKTOP MODE -->
<div class="navbar-center hidden lg:flex">
  <ul class="menu menu-horizontal px-1 text-dark text-base">
    <li><a href="../../landing-page.php">Home</a></li>
    <li><a href="../../user/tentang.php">Tentang kami</a></li>
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
  <!-- NAVBAR END -->->

                        <body class="font-poppins bg-gray-100"> 
                          <!-- Kontainer -->
                          <div class="bg-light flex flex-col items-center py-10">
                              <!-- Judul Halaman -->
                              <h1 class="text-3xl text-[#1B5E20] font-bold mb-8">Tukar Poin Reward</h1>

                              <!-- Pesan Status Penukaran -->
                              <?php if (!empty($redeemMessage)): ?>
                                  <div class="bg-green-100 text-green-700 p-4 mb-6 rounded-lg shadow">
                                      <?= htmlspecialchars($redeemMessage); ?>
                                  </div>
                              <?php endif; ?>

                            <!-- Daftar Rewards -->
                              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-screen-lg mx-auto">
                                  <?php while ($reward = $resultRewards->fetch_assoc()): ?>
                                      <div class="bg-white shadow-md rounded-lg overflow-hidden w-80 flex flex-col h-full">
                                          <div class="relative flex-shrink-0">
                                          <img src="<?= htmlspecialchars($reward['reward_image']); ?>" alt="<?= htmlspecialchars($reward['reward_name']); ?>" class="w-full h-40 object-cover">
                                              <div class="absolute top-0 left-0 bg-gradient-to-r from-green to-dark-green text-white p-4 rounded-br-lg">
                                                  <p class="font-bold"><?= htmlspecialchars($reward['reward_name']); ?></p>
                                              </div>
                                              <div class="p-4">
                          <h3 class="text-gray-800 font-semibold text-lg text-center">Tukarkan poin dengan <?= htmlspecialchars($reward['reward_name']); ?></h3>
                          <div class="flex justify-between items-center">
                              <p class="text-green-900 font-bold"><?= $reward['reward_points_required']; ?> Poin</p>
                              <button 
                                  class="bg-gradient-to-r from-green to-dark-green text-white px-4 py-2 rounded-full hover:bg-green-700"
                                  onclick="togglePopup(<?= $reward['reward_id']; ?>, <?= $reward['reward_points_required']; ?>)">
                                  Tukar
                              </button>
                          </div>
                      </div>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    <!-- Popup Konfirmasi -->
    <div id="popupReward" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-[700px]">
  <div class="flex items-center justify-center mb-4">
    <img id="rewardImage" src="https://placehold.co/300x150" alt="Reward Image" class="rounded-lg shadow-md" />
</div>
<h2 id="rewardName" class="text-center text-2xl font-bold text-green-900 mb-4"></h2>
<p class="text-gray-700 text-center mb-6">
    Apakah Anda yakin ingin menukarkan point Anda dengan <span id="rewardNameDisplay"></span>? Point akan langsung terpotong setelah konfirmasi.
</p>


            <form method="POST">
                <input type="hidden" id="reward_id" name="reward_id">
                <input type="hidden" id="reward_points_required" name="reward_points_required">
                <div class="flex justify-center gap-4">
                    <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400" onclick="closePopup()">Batalkan</button>
                    <button type="submit" name="redeem" class="bg-gradient-to-r from-green to-dark-green text-white px-4 py-2 rounded-md hover:bg-green-700">Ya, Tukar Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup untuk Pesan Sukses -->
    <div id="popupSuccess" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-[400px] text-center">
        <div class="flex justify-center mb-4">
          <!-- Tanda Checklist -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <h2 class="text-xl font-bold text-green-900 mb-2">Berhasil!</h2>
        <p class="text-gray-700 mb-4">Point Anda berhasil ditukarkan.</p>
      <button  onclick="window.location.href='../../user/drop-off/poin.php'"  class="bg-gradient-to-r from-green to-dark-green text-white py-2 px-4 rounded-full shadow-lg hover:bg-green-600">
          Lihat Poin
        </button>
      </div>
    </div>
    
    <!-- Popup untuk Pesan Poin Tidak Cukup -->
<div id="popupPoinTidakCukup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-[400px] text-center">
    <div class="flex justify-center mb-4">
      <!-- Ikon X (Menandakan Gagal) -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </div>
    <h2 class="text-xl font-bold text-red-900 mb-2">Gagal!</h2>
    <p class="text-gray-700 mb-4">Point Anda Tidak Cukup.</p>
    <button onclick="closePoinTidakCukupPopup()" class="bg-gradient-to-r from-red-500 to-red-700 text-white px-4 py-2 rounded-md hover:bg-red-700">
      Tutup
    </button>
  </div>
</div>

<!-- Popup untuk Pesan Stok Habis -->
<div id="popupStockHabis" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-[400px] text-center">
    <div class="flex justify-center mb-4">
      <!-- Ikon X (Menandakan Gagal) -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </div>
    <h2 class="text-xl font-bold text-red-900 mb-2">Gagal!</h2>
    <p class="text-gray-700 mb-4">Stock Sudah Habis.</p>
    <button onclick="closeStockHabisPopup()" class="bg-gradient-to-r from-red-500 to-red-700 text-white px-4 py-2 rounded-md hover:bg-red-700">
      Tutup
    </button>
  </div>
</div>

<script>
    // Fungsi untuk menutup popup sukses
    function closeSuccessPopup() {
    const successPopup = document.getElementById("popupSuccess");
    successPopup.classList.add("hidden");
  }
  function closeStockHabisPopup() {
    const successPopup = document.getElementById("popupStockHabis");
    successPopup.classList.add("hidden");
  }
  
  function closePoinTidakCukupPopup() {
    const successPopup = document.getElementById("popupPoinTidakCukup");
    successPopup.classList.add("hidden");
  }
  // Fungsi untuk menampilkan popup sukses
  function showSuccessPopup() {
    const successPopup = document.getElementById("popupSuccess");
    successPopup.classList.remove("hidden");

    // Sembunyikan popup sukses secara otomatis setelah 3 detik
    setTimeout(function() {
      successPopup.classList.add("hidden");
    }, 3000);
  }
  function showSuccessPopup() {
    const successPopup = document.getElementById("popupPoinTidakCukup");
    successPopup.classList.remove("hidden");

    // Sembunyikan popup sukses secara otomatis setelah 3 detik
    setTimeout(function() {
      successPopup.classList.add("hidden");
    }, 3000);
  }
  function showSuccessPopup() {
    const successPopup = document.getElementById("popupStockHabis");
    successPopup.classList.remove("hidden");

    // Sembunyikan popup sukses secara otomatis setelah 3 detik
    setTimeout(function() {
      successPopup.classList.add("hidden");
    }, 3000);
  }
  

</script>

</body>
</html>
