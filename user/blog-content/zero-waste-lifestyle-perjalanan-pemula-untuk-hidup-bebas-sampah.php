<!-- gaya Hidup -->
<?php
session_start();

if (!in_array(basename($_SERVER['PHP_SELF']), ['landing-page.php', 'tentang.php', 'blog.php'])) {
  if (!isset($_SESSION['loggedin'])) {
      header("Location: landing-page.php");
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
        <a href="../../landing-page.php" class="">
          <img src="../../images/Logo.png" alt="Logo Lestari">
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
<!-- Content -->
    <main class="bg-light container mx-auto px-16 py-12">
        <p class="text-sm bg-green-100 text-[#1B5E20] font-medium inline-block px-3 py-1 rounded">Gaya Hidup</p>
        <h1 class="text-3xl font-bold text-[#1B5E20] mt-4">Zero Waste Lifestyle: Perjalanan Pemula untuk Hidup Bebas Sampah</h1>
        <p class="text-gray-500 mt-2">Dipublikasikan 2 Desember 2024</p>
        <img src="../../images/user/blog/content3.png" alt="Gambar ilustrasi daur ulang" class="mt-4 mb-6 w-[500px] rounded-lg">
        <p class="text-gray-700 mb-1 text-justify">
        Terwujudnya lingkungan yang bebih bersih dimulai dari langkah-langkah kecil yang konsisten. Zero waste lifestyle bukan hanya tentang mengurangi sampah, tetapi juga tentang mengubah pola pikir dan kebiasaan kita sehari-hari.      </p>
        <div class="mt-8 space-y-10">
      </main>
  <!-- Main Content -->
<main class="max-w-6xl mx-auto bg-white rounded-lg md:p-8 md:px-1 px-8 py-1 mt-1">
  <section class="mb-12">
    <h1 class="text-2xl font-extrabold text-[#1B5E20] mb-1 text-left">
      Apa itu Zero Waste Lifestyle?
    </h1>
    <p class="text-gray-700  text-lg leading-relaxed">
    Zero Waste Lifestyle adalah gaya hidup yang bertujuan untuk meminimalkan produksi sampah dalam kehidupan sehari-hari. Konsep ini berfokus pada prinsip 5R:    </p>
  </section>

  <!-- Prinsip Zero Waste -->
  <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <!-- Refuse -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 shadow-sm">
      <h2 class="text-xl font-semibold text-[#1B5E20] mb-2">Refuse (Menolak)</h2>
      <p class="text-gray-600">
        Menolak barang-barang yang tidak diperlukan, seperti sedotan plastik, brosur kertas, atau barang promosi gratis, yang berpotensi menjadi sampah.
      </p>
    </div>
    <!-- Reduce -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 shadow-sm">
      <h2 class="text-xl font-semibold text-[#1B5E20] mb-2">Reduce (Mengurangi)</h2>
      <p class="text-gray-600">
        Kurangi pembelian barang-barang baru dengan memprioritaskan kualitas daripada kuantitas. Fokus pada barang yang benar-benar esensial.
      </p>
    </div>
    <!-- Reuse -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 shadow-sm">
      <h2 class="text-xl font-semibold text-[#1B5E20] mb-2">Reuse (Menggunakan Kembali)</h2>
      <p class="text-gray-600">
        Gunakan kembali barang-barang yang Anda miliki, seperti tas kain, botol minum, dan kotak makan, untuk mengurangi konsumsi barang sekali pakai.
      </p>
    </div>
    <!-- Recycle -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 shadow-sm">
      <h2 class="text-xl font-semibold text-[#1B5E20] mb-2">Recycle (Mendaur Ulang)</h2>
      <p class="text-gray-600">
        Mendaur ulang barang-barang seperti kertas, kaca, atau plastik dengan memilah sampah rumah tangga sesuai jenis materialnya.
      </p>
    </div>
    <!-- Rot -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 shadow-sm">
      <h2 class="text-xl font-semibold text-[#1B5E20] mb-2">Rot (Membusuk)</h2>
      <p class="text-gray-600">
        Ubah sampah organik seperti sisa makanan atau daun kering menjadi kompos yang berguna untuk menyuburkan tanah.
      </p>
    </div>
  </section>

  <!-- Tips Memulai -->
  <section class="mt-16 bg-green-50 border border-green-200 rounded-lg p-8 shadow-md">
    <h2 class="text-xl font-bold text-[#1B5E20] mb-6">
      Tips Memulai Zero Waste Lifestyle
    </h2>
    <ul class="list-disc list-inside space-y-3 text-gray-700">
      <li>Membawa tas belanja kain untuk menggantikan plastik.</li>
      <li>Menggunakan botol minum atau cangkir kopi yang dapat digunakan kembali.</li>
      <li>Menghindari penggunaan alat makan sekali pakai seperti sendok atau sedotan plastik.</li>
      <li>Memilah sampah berdasarkan jenisnya: organik dan anorganik.</li>
      <li>Membuat kompos dari sisa dapur seperti kulit buah dan sayuran.</li>
    </ul>
    <p class="text-gray-600 mt-4">
      Ingat, setiap langkah kecil yang Anda ambil membantu menciptakan perubahan besar. Jadilah bagian dari solusi untuk menjaga bumi kita tetap hijau dan sehat!
    </p>
  </section>
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
