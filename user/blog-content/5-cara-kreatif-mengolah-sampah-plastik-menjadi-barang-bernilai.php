<!-- tips daur ulang -->
<?php
session_start();

if (!in_array(basename($_SERVER['PHP_SELF']), ['landing-page.php', 'tentang.php', 'blog.php'])) {
  if (!isset($_SESSION['loggedin'])) {
      header("Location: ../../landing-page.php");
      exit();
  }
}

?>
<!DOCTYPE html>
<html lang="en"class="bg-light dark:[color-scheme:light]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/styles.css" rel="stylesheet">
    <title>Lestari - Blog</title>
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
        <a href="../../landing-page.php" class="ml-1">
          <img src="../../images/logo-crop.png" class="h-4 sm:h-5 md:h-6 lg:h-7" alt="Logo Lestari">
        </a>
      </div>
<!-- DESKTOP MODE -->
<div class="navbar-center hidden lg:flex">
  <ul class="menu menu-horizontal px-1 text-dark text-base">
  <li>
    <a href="../../landing-page.php"
       style="padding: 8px; 
              text-decoration: <?= ($current_page == 'landing-page.php') ? 'underline' : 'none' ?>; 
              font-weight: <?= ($current_page == 'landing-page.php') ? 'bold' : 'normal' ?>;
              color: <?= ($current_page == 'landing-page.php') ? '#1B5E20' : '' ?>;
              text-decoration-color: <?= ($current_page == 'landing-page.php') ? '#1B5E20' : '' ?>;">
        Home
    </a>
</li>
    <li>
    <a href="../../user/tentang.php"
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
    <li> <a href="../../user/blog.php"
       style="padding: 8px; 
              text-decoration: <?= ($current_page == 'blog.php') ? 'underline' : 'none' ?>; 
              font-weight: <?= ($current_page == 'blog.php') ? 'bold' : 'normal' ?>;
              color: <?= ($current_page == 'blog.php') ? '#1B5E20' : '' ?>;
              text-decoration-color: <?= ($current_page == 'blog.php') ? '#1B5E20' : '' ?>;">
        Blog
    </a>
  </li>
  <li> <a href="../../user/kontak-kami.php"
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
<!-- Content -->
    <main class=" bg-light container mx-auto px-16 py-12">
        <p class="text-sm bg-green-100 text-[#1B5E20] font-medium inline-block px-3 py-1 rounded">Tips Daur Ulang</p>
        <h1 class="text-3xl font-bold text-[#1B5E20] mt-4">5 Cara Kreatif Mengolah Sampah Plastik Menjadi Barang Bernilai</h1>
        <p class="text-gray-500 mt-2">Dipublikasikan 2 Hari yang Lalu</p>
        <img src="../../images/user/blog/content1.png" alt="Gambar ilustrasi daur ulang" class="mt-4 mb-6 w-[500px] rounded-lg">
        <p class="text-gray-700 mb-6 text-justify">
            Sampah plastik telah menjadi salah satu masalah lingkungan yang paling serius di era modern. Namun, dengan sedikit kreativitas dan inovasi, kita dapat mengubah sampah plastik menjadi produk yang bernilai dan bermanfaat.      </p>
        <div class="mt-8 space-y-10">
            <!-- Section 1 -->
            <section>
                <h2 class="text-xl font-bold text-[#1B5E20]">1. Membuat Pot Bunga dari Botol Plastik</h2>
                <div class="bg-gray-50 border rounded-lg p-4 mt-2 text-gray-700">
                <p class="mb-4">Botol plastik bekas dapat diubah menjadi pot bunga yang menarik dengan mengikuti langkah-langkah berikut :</p>
                    <ol class="list-decimal pl-5 space-y-2">
                    <li>Bersihkan botol plastik hingga benar-benar bersih.</li>
                    <li>Potong botol plastik menjadi dua bagian secara horizontal (sekitar 1/3 dari bawah).</li>
                    <li>Buat 4-5 lubang kecil di bagian bawah untuk drainase.</li>
                    <li>Buat pola sesuai desain yang diinginkan (bisa berbentuk hewan, geometris, dll).</li>
                    <li>Cat permukaan botol sesuai selera (tunggu hingga benar-benar kering).</li>
                    <li>Isi dengan media tanam.</li>
                    <li>Tanam tanaman yang diinginkan.</li>
                    </ol>
                </div>
            </section>

            <!-- Section 2 -->
            <section>
                <h2 class="text-xl font-bold text-[#1B5E20]">2. Tas Belanja dari Kemasan Plastik</h2>
                <div class="bg-gray-50 border rounded-lg p-4 mt-2 text-gray-700">
                <p class="mb-4">Kemasan plastik bekas dapat dianyam menjadi tas belanja yang kuat dan stylish. Berikut langkah langkah nya</p>
                    <ol class="list-decimal pl-5 space-y-2">
                        <li>Bersihkan kemasan plastik dari debu dan kotoran</li>
                        <li>Potong kemasan menjadi lembaran-lembaran sama besar</li>
                        <li>Susun dan setrika dengan kertas minyak sebagai pelapis</li>
                        <li>Jahit sesuai pola tas yang diinginkan</li>
                        <li>Tambahkan tali untuk pegangan tas</li>
                    </ol>
                </div>
            </section>

            <!-- Section 3 -->
            <section>
                <h2 class="text-xl font-bold text-[#1B5E20]">3. Hiasan Dinding dari Tutup Botol</h2>
                <div class="bg-gray-50 border rounded-lg p-4 mt-2 text-gray-700">
                <p class="mb-4">Tutup botol plastik dapat disusun menjadi hiasan dinding yang artistik dengan mengikuti langkah-langkah berikut :</p>
                    <ol class="list-decimal pl-5 space-y-2">
                    <li>Kumpulkan tutup botol dalam jumlah banyak.</li>
                    <li>Buat pola atau desain di papan.</li>
                    <li>Tempelkan tutup botol sesuai pola.</li>
                    <li>Semprot dengan clear coat untuk hasil mengkilap.</li>
                    </ol>
                </div>
            </section>

            <!-- Section 4 -->
            <section>
                <h2 class="text-xl font-bold text-[#1B5E20]">4. Tempat Pensil dari Botol Sampo</h2>
                <div class="bg-gray-50 border rounded-lg p-4 mt-2 text-gray-700">
                <p class="mb-4">Botol sampo bekas dapat diubah menjadi tempat pensil yang unik dengan mengikuti langkah langkah dibawah ini :</p>
                    <ol class="list-decimal pl-5 space-y-2">
                    <li>Bersihkan botol sampo hingga benar-benar bersih dari sisa sampo.</li>
                    <li>Potong botol sesuai ketinggian yang diinginkan (biasanya 15-20 cm).</li>
                    <li>Amplas permukaan botol agar cat dapat menempel dengan baik.</li>
                    <li>Buat pola atau desain yang diinginkan.</li>
                    <li>Cat dasar seluruh permukaan botol (2-3 lapis).</li>
                    <li>Tambahkan detail dan hiasan sesuai selera.</li>
                    <li>Aplikasikan clear coat untuk hasil yang tahan lama.</li>
                    </ol>
                </div>
            </section>

            <!-- Section 5 -->
            <section>
                <h2 class="text-xl font-bold text-[#1B5E20]">5. Vas Bunga dari Plastik Daur Ulang</h2>
                <div class="bg-gray-50 border rounded-lg p-4 mt-2 text-gray-700">
                <p class="mb-4">Berbagai jenis plastik dapat dilelehkan dan dibentuk ulang menjadi vas bunga dengan mengikuti langkah langkah dibawah ini :</p>
                    <ol class="list-decimal pl-5 space-y-2">
                        <li>Potong plastik menjadi potongan-potongan kecil</li>
                        <li>Siapkan cetakan dari botol plastik, lapisi dengan aluminium foil</li>
                        <li>Susun potongan plastik pada cetakan dengan pola yang diinginkan</li>
                        <li>Panaskan dengan hati-hati menggunakan heat gun atau oven dengan suhu rendah (~150°C)</li>
                        <li>Tunggu hingga plastik meleleh dan menyatu</li>
                        <li>Biarkan dingin secara alami</li>
                        <li>Lepaskan dari cetakan dengan hati-hati</li>
                    </ol>
                </div>
            </section>
        </div>
    </main>

<!-- modal  -->
<div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-sm">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Yuk Login dulu</h2>
        <p class="text-gray-600 mb-6">Silakan login terlebih dahulu untuk mengakses layanan ini.</p>
        <div class="flex justify-center gap-4">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
            <a href="../../user/signin.php" class="px-4 py-2 bg-gradient-to-r from-green to-dark-green text-white rounded-lg hover:bg-green-700">Login</a>
        </div>
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
