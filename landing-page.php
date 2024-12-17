<?php
session_start();  // Start session untuk memeriksa status login

// Halaman yang tidak memerlukan login (seperti landing-page.php)
if (basename($_SERVER['PHP_SELF']) != 'landing-page.php') {
    // Jika user belum login, arahkan ke halaman login atau lainnya
    if (!isset($_SESSION['loggedin'])) {
        header("Location: landing-page.php");
        exit();  // Jangan lupa exit setelah redirect
    }
}
// Logika untuk halaman aktif
$current_page = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="en"class="bg-light dark:[color-scheme:light]">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="./css/styles.css" rel="stylesheet">
  <title>Landing Page - Lestari</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <!-- Tailwind CSS -->
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
            <li><a href="./landing-page.php">Home</a></li>
            <li><a href="./user/tentang.php">Tentang Kami</a></li>
            <li>
              <a>Layanan</a>
              <ul class="p-2">
                <!-- Drop Off -->
                <li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <button onclick="window.location.href='./user/drop-off/dropoff.php'" >
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
                    <button onclick="window.location.href='./user/drop-off/poin.php'" >
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
                    <button onclick="window.location.href='./user/marketplace/marketplace.php'">
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
            <li><a href="./user/blog.php">Blog</a></li>
            <li><a href="./user/kontak-kami.php">Kontak Kami</a></li>
          </ul>
        </div>
        <!-- BRAND LOGO -->
        <a href="./landing-page.php" class="ml-1">
          <img src="./images/logo-crop.png" class="h-4 sm:h-5 md:h-6 lg:h-7" alt="Logo Lestari">
        </a>
      </div>
<!-- DESKTOP MODE -->
<div class="navbar-center hidden lg:flex">
  <ul class="menu menu-horizontal px-1 text-dark text-base">
  <li>
    <a href="./landing-page.php"
       style="padding: 8px; 
              text-decoration: <?= ($current_page == 'landing-page.php') ? 'underline' : 'none' ?>; 
              font-weight: <?= ($current_page == 'landing-page.php') ? 'bold' : 'normal' ?>;
              color: <?= ($current_page == 'landing-page.php') ? '#1B5E20' : '' ?>;
              text-decoration-color: <?= ($current_page == 'landing-page.php') ? '#1B5E20' : '' ?>;">
        Home
    </a>
</li>
    <li>
    <a href="./user/tentang.php"
       style="padding: 8px; 
              text-decoration: <?= ($current_page == 'tentang.php') ? 'underline' : 'none' ?>; 
              font-weight: <?= ($current_page == 'tentang.php') ? 'bold' : 'normal' ?>;
              color: <?= ($current_page == 'tentang.php') ? '#1B5E20' : '' ?>;
              text-decoration-color: <?= ($current_page == 'tentang.php') ? '#1B5E20' : '' ?>;">
        Tentang Kami
    </a>
  </li>
    <li>
      <details>
        <summary>Layanan</summary>
        <ul class="bg-light absolute left-1/2 transform -translate-x-1/2 rounded-[10px] border-[1px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border-gray px-[14px] py-[20px] flex flex-wrap items-center gap-3 min-w-[300px] max-w-[600px]">
          <!-- Drop Off -->
          <li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button onclick="window.location.href='./user/drop-off/dropoff.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="./images/truck.png" class="w-8 h-8" alt="">
                <p>Drop Off</p>
              </button>
            <?php else: ?>
              <button onclick="showModal()" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="./images/truck.png" class="w-8 h-8" alt="">
                <p>Drop Off</p>
              </button>
            <?php endif; ?>
          </li>
          <!-- Rewards -->
          <li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button onclick="window.location.href='./user/drop-off/poin.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="./images/reward.png" class="w-8 h-8" alt="">
                <p>Rewards</p>
              </button>
            <?php else: ?>
              <button onclick="showModal()" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="./images/reward.png" class="w-8 h-8" alt="">
                <p>Rewards</p>
              </button>
            <?php endif; ?>
          </li>
         
          <!-- Marketplace -->
          <li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <button onclick="window.location.href='./user/marketplace/marketplace.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="./images/marketplace.png" class="w-8 h-8" alt="">
                <p>Marketplace</p>
              </button>
            <?php else: ?>
              <button onclick="showModal()" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
                <img src="./images/marketplace.png" class="w-8 h-8" alt="">
                <p>Marketplace</p>
              </button>
            <?php endif; ?>
          </li>
        </ul>
      </details>
    </li>
    <li> <a href="./user/blog.php"
       style="padding: 8px; 
              text-decoration: <?= ($current_page == 'blog.php') ? 'underline' : 'none' ?>; 
              font-weight: <?= ($current_page == 'blog.php') ? 'bold' : 'normal' ?>;
              color: <?= ($current_page == 'blog.php') ? '#1B5E20' : '' ?>;
              text-decoration-color: <?= ($current_page == 'blog.php') ? '#1B5E20' : '' ?>;">
        Blog
    </a>
  </li>
  <li> <a href="./user/kontak-kami.php"
       style="padding: 8px; 
              text-decoration: <?= ($current_page == 'kontak-kami.php') ? 'underline' : 'none' ?>; 
              font-weight: <?= ($current_page == 'kontak-kami.php') ? 'bold' : 'normal' ?>;
              color: <?= ($current_page == 'kontak-kami.php') ? '#1B5E20' : '' ?>;
              text-decoration-color: <?= ($current_page == 'blog.php') ? '#1B5E20' : '' ?>;">
        Kontak Kami
    </a>
  </li>  
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
                <a href="./user/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                <a href="./backend/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
        </div>
    <?php else: ?>
      <!-- Tombol Sign In dan Sign Up jika belum login -->
        <a href="./user/signin.php" class="btn md:min-w-[100px] md:h-12 md:shadow-md md:rounded-full md:bg-gradient-to-r from-green to-dark-green md:text-sm md:border md:border-to-r md:from-green md:to-dark-green md:font-medium md:text-white md:text-center text-base bg-transparent text-sm text-[#1B5E20] border-0 shadow-none">
          Sign In
        </a>
        <a href="./user/signup.php" class="btn btn-outline md:min-w-[100px] md:h-12 md:shadow-md md:border border-to-r from-green to-dark-green md:rounded-full md:text-sm md:font-medium md:text-[#1B5E20] md:text-center text-base bg-transparent text-sm text-[#1B5E20] border-0 shadow-none whitespace-nowrap">
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

<!-- Hero Section -->
<section class="bg-gradient-to-r from-green to-dark-green text-white h-auto">
  <div class="container md:max-w-full mx-auto md:mx-0 md:px-0 md:pl-12 md:gap-5 flex flex-col md:flex-row items-center md:justify-between h-full">
    <div class="w-full md:w-1/2 text-center py-10 md:py-0 h-full flex flex-col justify-center items-center md:items-start md:text-left">
      <h1 class="text-2xl md:text-3xl lg:text-4xl xl:text-5xl max-w-80 md:max-w-[610px] lg:max-w-[500px] xl:max-w-[600px] md:text-left font-bold leading-tight md:leading-normal lg:leading-relaxed xl:leading-relaxed mb-4">
        Tukarkan Sampah, Dapatkan Hadiahnya
      </h1>
      <p class="text-lg md:text-xl">
        #TukarSampahUntukKebaikan
      </p>
    </div>
    <div class="md:w-1/2 md:right-0 md:top-[80px] flex">
      <!-- gambar mobile -->
      <img 
        src="./images/hero-banner-mobile.png" 
        alt="Hero Image Mobile" 
        class="rounded-lg max-w-full h-auto object-cover md:hidden">
        <!-- gambar dekstop -->
      <img 
        src="./images/hero-banner.png" 
        alt="Hero Image Desktop" 
        class="rounded-lg max-w-full h-auto object-cover hidden md:block 2xl:ml-auto">
    </div>
  </div>
</section>

<section class="bg-white md:py-16 py-10">
  <div class="container mx-auto px-12">
    <div class="md:flex md:flex-row items-start md:gap-6 md:items-stretch">
      <div class="md:w-1/2 text-center place-content-center md:place-content-baseline mb-8 md:mb-10 flex relative">
        <!-- Kotak Hijau (hanya muncul di desktop) -->
        <div class="bg-gradient-to-r from-green to-dark-green rounded-lg shadow-md w-auto h-60 md:w-full lg:h-full aspect-square lg:aspect-auto p-4 max-w-full items-center flex justify-center">
          <img src="./images/chart.png" alt="Chart" 
        class="h-full">
        </div>
      </div>

<!-- Konten Teks -->
      <div class="w-full md:w-3/4 md:pt-0">
        <h2 class="text-base sm:text-xl lg:text-3xl max-w-72 sm:max-w-96 md:max-w-full place-self-center md:place-self-auto text-black font-bold mb-4 break-words text-center md:text-justify">
          Kelola Sampah dengan Drop Off, Dapatkan Poin Berharga
        </h2>
        <p class="text-black mb-6" style="text-align: justify;">
          LESTARI mengajak kamu untuk melakukan Drop Off sampah di bank sampah terdekat dan mendapatkan hadiah menarik. Pilah sampahmu (plastik, kertas, logam, atau organik), bawa ke bank sampah, kumpulkan poin, dan tukarkan dengan hadiah ramah lingkungan. Dengan Drop Off, kamu ikut berkontribusi menjaga bumi, mengurangi sampah di lingkungan, serta mendukung upaya daur ulang. Ayo, manfaatkan fitur ini dan jadikan bumi lebih bersih dan hijau!
        </p>
        <div class="md:mb-6 mb-2">
          <div class="bg-gradient-to-r from-green to-dark-green text-white p-4 rounded-lg shadow-md flex justify-between">
            <div class="text-center text-l">
              <h5 class="font-bold md:text-xl text-l">2jt Kg+</h5>
              <p class="text-sm">Sampah di Daur Ulang</p>
            </div>
            <div class="text-center">
              <h5 class="font-bold md:text-xl text-l">15rb+</h5>
              <p class="text-sm">Pengguna</p>
            </div>
          </div>
        </div>
        <div class="block">
          <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <a href="./user/drop-off/dropoff.php" class="md:mt-4 text-black font-bold cursor-pointer hover:text-green-700">
                  Lihat Selengkapnya →
              </a>
          <?php else: ?>
              <a href="javascript:void(0)" onclick="showModal()" class="block md:mt-4 text-black font-bold cursor-pointer hover:text-green-700">
                  Lihat Selengkapnya →
              </a>
          <?php endif; ?>
      </div>

      </div>
    </div>
  </div>
</section>

<!-- Layanan Section -->
<section class="md:py-16 py-8 bg-gray-100">
    <div class="container mx-auto px-12">
        <h2 class="text-3xl text-black font-bold mb-2 text-center">Layanan</h2>
        <p class="text-black mb-8 text-center">Revolusi daur ulang dari Mall Sampah untuk semua orang</p>
        <div class="text-black grid md:grid-cols-2 gap-6">
            <!-- Card Rewards -->
            <div class="block">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <a href="./user/drop-off/poin.php" class="block">
                        <div class="bg-white p-6 rounded-lg shadow-md cursor-pointer hover:bg-green-200 h-full justify-between">
                            <h5 class="text-xl mb-2">🎁 Rewards</h5>
                            <p>LESTARI mengubah sampahmu menjadi poin yang bisa kamu kumpulkan dan tukarkan dengan hadiah ramah lingkungan.</p>
                        </div>
                    </a>
                <?php else: ?>
                    <a href="javascript:void(0)" onclick="showModal()" class="block">
                        <div class="bg-white p-6 rounded-lg shadow-md cursor-pointer hover:bg-green-200 h-full justify-between">
                            <h5 class="text-xl mb-2">🎁 Rewards</h5>
                            <p>LESTARI mengubah sampahmu menjadi poin yang bisa kamu kumpulkan dan tukarkan dengan hadiah ramah lingkungan.</p>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
            <!-- Card Tutorial -->
            <!-- <div class="block">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <a href="./user/tutorial/tutorial.php" class="block">
                        <div class="bg-white p-6 rounded-lg shadow-md cursor-pointer hover:bg-green-200 h-full justify-between">
                            <h5 class="text-xl mb-2">📺 Tutorial</h5>
                            <p>LESTARI menyediakan tutorial untuk mengubah limbah menjadi barang bernilai dengan gaya hidup ramah lingkungan.</p>
                        </div>
                    </a>
                <?php else: ?>
                    <a href="javascript:void(0)" onclick="showModal()" class="block">
                        <div class="bg-white p-6 rounded-lg shadow-md cursor-pointer hover:bg-green-200 h-full justify-between">
                            <h5 class="text-xl mb-2">📺 Tutorial</h5>
                            <p>LESTARI menyediakan tutorial untuk mengubah limbah menjadi barang bernilai dengan gaya hidup ramah lingkungan.</p>
                        </div>
                    </a>
                <?php endif; ?>
            </div> -->
            <!-- Card Marketplace -->
            <div class="block">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <a href="./user/marketplace/marketplace.php" class="block">
                        <div class="bg-white p-6 rounded-lg shadow-md cursor-pointer hover:bg-green-200 h-full justify-between">
                            <h5 class="text-xl mb-2">🛍️ Marketplace</h5>
                            <p>Marketplace LESTARI menyediakan produk berkualitas daur ulang. Dukungan nyata untuk gerakan ramah lingkungan.</p>
                        </div>
                    </a>
                <?php else: ?>
                    <a href="javascript:void(0)" onclick="showModal()" class="block">
                        <div class="bg-white p-6 rounded-lg shadow-md cursor-pointer hover:bg-green-200 h-full justify-between">
                            <h5 class="text-xl mb-2">🛍️ Marketplace</h5>
                            <p>Marketplace LESTARI menyediakan produk berkualitas daur ulang. Dukungan nyata untuk gerakan ramah lingkungan.</p>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


 <!-- Jenis sampah Section -->
<section class="bg-white py-16">
  <div class="text-black container mx-auto px-12">
    <h2 class="text-3xl font-bold mb-2 text-center">Jenis Sampah</h2>
    <p class="mb-8 text-center">Lihat semua jenis sampah yang kami daur ulang.</p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      
      <!-- Kertas -->
      <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? './user/sampah/kertas.php' : 'javascript:void(0)'; ?>" 
         onclick="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? '' : 'showModal()'; ?>" 
         class="bg-white p-4 rounded-lg shadow-md text-center hover:bg-green-100 transition-all">
        <div class="text-4xl mb-2">📄</div>
        <p>Kertas</p>
      </a>

      <!-- Plastik -->
      <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? './user/sampah/plastik.php' : 'javascript:void(0)'; ?>" 
         onclick="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? '' : 'showModal()'; ?>" 
         class="bg-white p-4 rounded-lg shadow-md text-center hover:bg-green-100 transition-all">
        <div class="text-4xl mb-2">🛢️</div>
        <p>Plastik</p>
      </a>

      <!-- Aluminium -->
      <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? './user/sampah/aluminium.php' : 'javascript:void(0)'; ?>" 
         onclick="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? '' : 'showModal()'; ?>" 
         class="bg-white p-4 rounded-lg shadow-md text-center hover:bg-green-100 transition-all">
        <div class="text-4xl mb-2">🥫</div>
        <p>Aluminium</p>
      </a>

      <!-- Besi & Logam -->
      <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? './user/sampah/besi.php' : 'javascript:void(0)'; ?>" 
         onclick="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? '' : 'showModal()'; ?>" 
         class="bg-white p-4 rounded-lg shadow-md text-center hover:bg-green-100 transition-all">
        <div class="text-4xl mb-2">🔩</div>
        <p>Besi & Logam</p>
      </a>

      <!-- Elektronik -->
      <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? './user/sampah/elektronik.php' : 'javascript:void(0)'; ?>" 
         onclick="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? '' : 'showModal()'; ?>" 
         class="bg-white p-4 rounded-lg shadow-md text-center hover:bg-green-100 transition-all">
        <div class="text-4xl mb-2">💻</div>
        <p>Elektronik</p>
      </a>

      <!-- Botol Kaca -->
      <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? './user/sampah/botol.php' : 'javascript:void(0)'; ?>" 
         onclick="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? '' : 'showModal()'; ?>" 
         class="bg-white p-4 rounded-lg shadow-md text-center hover:bg-green-100 transition-all">
        <div class="text-4xl mb-2">🍾</div>
        <p>Botol Kaca</p>
      </a>

      <!-- Merek -->
      <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? './user/sampah/merek.php' : 'javascript:void(0)'; ?>" 
         onclick="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? '' : 'showModal()'; ?>" 
         class="bg-white p-4 rounded-lg shadow-md text-center hover:bg-green-100 transition-all">
        <div class="text-4xl mb-2">🏷️</div>
        <p>Merek</p>
      </a>

      <!-- Khusus -->
      <a href="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? './user/sampah/khusus.php' : 'javascript:void(0)'; ?>" 
         onclick="<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? '' : 'showModal()'; ?>" 
         class="bg-white p-4 rounded-lg shadow-md text-center hover:bg-green-100 transition-all">
        <div class="text-4xl mb-2">🍃</div>
        <p>Khusus</p>
      </a>

    </div>
  </div>
</section>



<!-- modal  -->
<div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-sm">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Yuk Login dulu</h2>
        <p class="text-gray-600 mb-6">Silakan login terlebih dahulu untuk mengakses layanan ini.</p>
        <div class="flex justify-center gap-4">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
            <a href="./user/signin.php" class="px-4 py-2 bg-gradient-to-r from-green to-dark-green text-white rounded-lg hover:bg-green-700">Login</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gradient-to-r from-green to-dark-green text-white py-7">
  <div class="container mx-auto px-12">
    <!-- Logo -->
    <div class="flex justify-center mb-6 py-4">
      <a href="./landing-page.php">
        <img src="./images/logo-crop-white.png" alt="Logo Lestari" class="h-7 lg:h-9">
      </a>
    </div>
    
    <!-- Grid Container -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center md:text-left">
      <!-- Bagian Lestari -->
      <div class="text-left col-span-1 md:col-span-1">
        <h4 class="font-bold mb-2">Lestari</h4>
        <a href="./landing-page.php" class="block text-white hover:underline mb-1">Home</a>
        <a href="./user/tentang.php" class="block text-white hover:underline mb-1">Tentang Kami</a>
        <a href="./landing-page.php" class="block text-white hover:underline mb-1">Layanan</a>
        <a href="./user/blog.php" class="block text-white hover:underline mb-1">Blog</a>
      </div>

      <!-- Bagian Informasi -->
      <div class="text-right md:text-center col-span-1 md:col-span-1">
        <h4 class="font-bold mb-2">Informasi</h4>
        <a href="./user/kontak-kami.php" class="block text-white hover:underline mb-1">Kontak Kami</a>
      </div>

      <!-- Bagian Hubungi Kami -->
      <div class="col-span-2 md:col-span-1 text-center">
        <h4 class="font-bold mb-2">Hubungi Kami</h4>
        <div class="flex justify-center space-x-4 mt-2">
          <a href="#"><img src="./images/user/sosmed/instagram.png" alt="Instagram"></a>
          <a href="#"><img src="./images/user/sosmed/fb.png" alt="Facebook"></a>
          <a href="#"><img src="./images/user/sosmed/x.png" alt="Twitter"></a>
          <a href="#"><img src="./images/user/sosmed/wa.png" alt="Whatsapp"></a>
          <a href="#"><img src="./images/user/sosmed/yt.png" alt="YouTube"></a>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- script java -->
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