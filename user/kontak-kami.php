<?php
   session_start();
   
   if (!in_array(basename($_SERVER['PHP_SELF']), ['landing-page.php', 'tentang.php', 'blog.php', 'kontak-kami.php'])) {
     if (!isset($_SESSION['loggedin'])) {
         header("Location: landing-page.php");
         exit();
     }
   }
// Logika untuk halaman aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en"class="bg-light dark:[color-scheme:light]">
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
  <li>
    <a href="../landing-page.php"
       style="padding: 8px; 
              text-decoration: <?= ($current_page == 'landing-page.php') ? 'underline' : 'none' ?>; 
              font-weight: <?= ($current_page == 'landing-page.php') ? 'bold' : 'normal' ?>;
              color: <?= ($current_page == 'landing-page.php') ? '#1B5E20' : '' ?>;
              text-decoration-color: <?= ($current_page == 'landing-page.php') ? '#1B5E20' : '' ?>;">
        Home
    </a>
</li>
    <li>
    <a href="../user/tentang.php"
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
    <li> <a href="../user/blog.php"
       style="padding: 8px; 
              text-decoration: <?= ($current_page == 'blog.php') ? 'underline' : 'none' ?>; 
              font-weight: <?= ($current_page == 'blog.php') ? 'bold' : 'normal' ?>;
              color: <?= ($current_page == 'blog.php') ? '#1B5E20' : '' ?>;
              text-decoration-color: <?= ($current_page == 'blog.php') ? '#1B5E20' : '' ?>;">
        Blog
    </a>
  </li>
  <li> <a href="../user/kontak-kami.php"
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
      <div class="bg-white container mx-auto px-12 py-6 md:px-24">
        <h2 class="text-3xl text-[#1B5E20] font-bold mb-3 text-center">Kontak Kami</h2>
        <p class="text-gray-700 mb-6 text-center">Punya pertanyaan atau ingin berkolaborasi? Jangan ragu untuk menghubungi kami</p>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
          <!-- Contact Information -->
          <div class="bg-green-100 p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-[#1B5E20] mb-4">Alamat Kantor</h3>
            <p class="text-gray-700 mb-4">Jl. Lingkungan Hijau No. 123<br>Jakarta Selatan, 12345</p>
            <h3 class="text-lg font-bold text-[#1B5E20] mb-4">Email</h3>
            <p class="text-gray-700 mb-4">
                <a href="mailto:info@lestari.id" class="hover:text-green-600">info@lestari.id</a><br>
                <a href="mailto:support@lestari.id" class="hover:text-green-600">support@lestari.id</a>
            </p>
            <h3 class="text-lg font-bold text-[#1B5E20] mb-4">Telepon</h3>
            <p class="text-gray-700 mb-4">(021) 1234-5678<br>0800-1234-5678 (Bebas Pulsa)</p>
            <h3 class="text-lg font-bold text-[#1B5E20] mb-4">Jam Operasional</h3>
            <p class="text-gray-700 mb-4">
                Senin - Jumat: 09:00 - 17:00<br>
                Sabtu: 09:00 - 15:00
            </p>
          </div>
          <!-- Tambahkan Swiper.js ke dalam file HTML -->
          <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
          <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
          <!-- Testimonial Slider -->
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-green-700 mb-4 text-center">Cek apa kata mereka</h2>
            <!-- Swiper Container -->
            <div class="swiper">
                <div class="swiper-wrapper mb-8">
                  <!-- Slide 1 -->
                  <div class="swiper-slide p-9 bg-[#FFFDE8] rounded-2xl border border-gray shadow">
                      <p class="text-gray-700 text-center mb-4">"Program daur ulang yang sangat terorganisir. Semua sampah dipilah dengan baik dan diproses secara profesional."</p>
                      <p class="font-semibold text-green-700">Siti Rahayu</p>
                  </div>
                  <!-- Slide 2 -->
                  <div class="swiper-slide p-9 bg-[#FFFDE8] rounded-2xl border border-gray shadow">
                      <p class="text-gray-700 text-center mb-4">"Pelayanan sangat baik, selalu responsif terhadap pertanyaan. Terima kasih!"</p>
                      <p class="font-semibold text-green-700">Andi Wijaya</p>
                  </div>
                  <!-- Slide 3 -->
                  <div class="swiper-slide p-9 bg-[#FFFDE8] rounded-2xl border border-gray shadow">
                      <p class="text-gray-700 text-center mb-4">"Lestari benar-benar berkontribusi untuk lingkungan yang lebih baik. Sukses selalu!"</p>
                      <p class="font-semibold text-green-700">Dewi Kurnia</p>
                  </div>
                </div>
                <!-- Pagination -->
                <div class="swiper-pagination"></div>
                <!-- Navigation Buttons -->
                <div class="swiper-button-prev after:text-green"></div>
                <div class="swiper-button-next after:text-green"></div>
            </div>
            <div class="flex flex-row justify-between items-center mt-4">

                  <img src="../images/user/MSIB.png" 
                        class="md:w-[150px] w-[70px] xl:w-[125px] 2xl:w-[150px]" 
                        alt="msib">
                  
                  <img src="../images/user/kampus-merdeka.png" 
                        class="md:w-[150px] w-[70px] xl:w-[125px] 2xl:w-[150px] ml-4" 
                        alt="kampus merdeka">

                  <img src="../images/user/ytta logo.png" 
                        class="md:w-[150px] w-[90px] xl:w-[125px] 2xl:w-[150px]" 
                        alt="iThree logo">
            </div>
          </div>
          <script>
            const swiper = new Swiper('.swiper', {
              loop: true,
              pagination: {
                el: '.swiper-pagination',
                clickable: true,
              },
              navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
              },
              autoplay: {
                delay: 3000,
              },
            });
          </script>
          <!-- modal  -->
          <div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-sm">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Yuk Login dulu</h2>
                <p class="text-gray-600 mb-6">Silakan login terlebih dahulu untuk mengakses layanan ini.</p>
                <div class="flex justify-center gap-4">
                  <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                  <a href="../user/signin.php" class="px-4 py-2 bg-gradient-to-r from-green to-dark-green text-white rounded-lg hover:bg-green-700">Login</a>
                </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Footer -->
      <footer class="bg-gradient-to-r from-green to-dark-green text-white py-7">
         <div class="container mx-auto px-12">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
               <a class="py-3" href="../landing-page.php">
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