<!DOCTYPE html>
<html lang="en">
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
   <div class="navbar bg-light h-20 pr-10 justify-between sticky top-0 z-50">
   <!-- MOBILE SCREEN MODE -->
      <div class="navbar-start pl-[41px]">
        <div class="dropdown ">
          <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
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
            tabindex="0"
            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
            <li><a>Item 1</a></li>
            <li>
              <a>Parent</a>
              <ul class="p-2">
                <li><a>Submenu 1</a></li>
                <li><a>Submenu 2</a></li>
              </ul>
            </li>
            <li><a>Item 3</a></li>
          </ul>
        </div>
        <!-- BRAND LOGO -->
        <a href="." class="">
          <img src="../../images/Logo.png" alt="Logo Lestari">
        </a>
      </div>
<!-- DESKTOP MODE -->
<div class="navbar-center hidden lg:flex">
  <ul class="menu menu-horizontal px-1 text-dark text-base">
    <li><a>Home</a></li>
    <li><a href="./user/tentang.php">Tentang kami</a></li>
    <li>
      <details>
        <summary>Layanan</summary>
        <ul class="bg-light absolute left-1/2 transform -translate-x-1/2 rounded-[10px] border-[1px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border-gray px-[14px] py-[20px] flex flex-wrap items-center gap-3 min-w-[300px] max-w-[600px]">
          <li>
            <button onclick="window.location.href='./user/drop_off/dropoff.php'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
              <img src="../../images/truck.png" class="w-8 h-8" alt="">
              <p>Drop Off</p>
            </button>
          </li>
          <li>
            <button onclick="window.location.href='./rewards.html'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
              <img src="../../images/reward.png" class="w-8 h-8" alt="">
              <p>Rewards</p>
            </button>
          </li>
          <li>
            <button onclick="window.location.href='./tutorial.html'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
              <img src="../../images/Vector.png" class="w-6 h-6" alt="">
              <p>Tutorial</p>
            </button>
          </li>
          <li>
            <button onclick="window.location.href='./marketplace.html'" class="btn btn-success flex-grow shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex items-center justify-center px-4 py-2 gap-2 min-w-[120px] max-w-[200px]">
              <img src="../../images/marketplace.png" class="w-8 h-8" alt="">
              <p>Marketplace</p>
            </button>
          </li>
        </ul>
      </details>
    </li>
    <li><a>Blog</a></li>
    <li><a>Kontak Kami</a></li>
  </ul>
</div>

        <!-- if user not login -->
        <!-- <div class="navbar-end ml-[5px] flex flex-row gap-4 w-auto">
          <a href="./user/signin.php" class="btn min-w-[100px] h-1 shadow-md rounded-full bg-gradient-to-r from-green to-dark-green text-sm border border-to-r from-green to-dark-green font-medium text-white text-center">Sign In</a>
          <a href="./user/signup.php" class="btn btn-outline min-w-[100px] h-1 shadow-md border border-to-r from-green to-dark-green rounded-full text-sm font-medium text-[#1B5E20] text-center">Sign Up</a>
        </div> -->
        <!-- endif -->

        <!-- if user login -->
        <div class="ml-[233px] content-center">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
            <div class="w-[50px] rounded-full">
              <img
                alt="Tailwind CSS Navbar component"
                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
            </div>
          </div>
        </div>
        <!-- endif -->
    </div>
  <!-- NAVBAR END -->

  <!-- Blog Section -->
  <main class="container mx-auto mt-8 px-4">
    <h1 class="text-3xl font-bold text-center text-green-600 mb-2">Blog Lestari</h1>
    <p class="text-center text-gray-700">Temukan artikel menarik seputar daur ulang, lingkungan, dan tips ramah lingkungan</p>

    <!-- Blog Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
      <!-- Blog Card 1 -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <img src="https://placehold.co/400x250" alt="Blog Image" class="w-full">
        <div class="p-4">
          <span class="bg-green-100 text-green-600 text-xs font-medium px-2 py-1 rounded">Tips Daur Ulang</span>
          <h2 class="text-lg font-bold mt-2 text-gray-800">5 Cara Kreatif Mengolah Sampah Plastik Menjadi Barang Bernilai</h2>
          <p class="text-sm text-gray-600 mt-1">Pelajari cara mengubah sampah plastik menjadi produk yang memiliki nilai jual dan bermanfaat untuk kehidupan sehari-hari.</p>
          <div class="flex justify-between items-center mt-4 text-gray-500 text-sm">
            <p>5 menit baca</p>
            <p>2 hari yang lalu</p>
          </div>
        </div>
      </div>
      
      <!-- Blog Card 2 -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <img src="https://placehold.co/400x250" alt="Blog Image" class="w-full">
        <div class="p-4">
          <span class="bg-green-100 text-green-600 text-xs font-medium px-2 py-1 rounded">Lingkungan</span>
          <h2 class="text-lg font-bold mt-2 text-gray-800">Dampak Positif Program Bank Sampah Bagi Lingkungan</h2>
          <p class="text-sm text-gray-600 mt-1">Simak bagaimana program bank sampah memberikan dampak positif bagi lingkungan dan masyarakat sekitar.</p>
          <div class="flex justify-between items-center mt-4 text-gray-500 text-sm">
            <p>4 menit baca</p>
            <p>5 hari yang lalu</p>
          </div>
        </div>
      </div>

      <!-- Blog Card 3 -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <img src="https://placehold.co/400x250" alt="Blog Image" class="w-full">
        <div class="p-4">
          <span class="bg-green-100 text-green-600 text-xs font-medium px-2 py-1 rounded">Gaya Hidup</span>
          <h2 class="text-lg font-bold mt-2 text-gray-800">Zero Waste Lifestyle: Panduan Pemula untuk Hidup Bebas Sampah</h2>
          <p class="text-sm text-gray-600 mt-1">Temukan langkah-langkah mudah untuk memulai gaya hidup zero waste dan berkontribusi pada kelestarian lingkungan.</p>
          <div class="flex justify-between items-center mt-4 text-gray-500 text-sm">
            <p>7 menit baca</p>
            <p>1 minggu yang lalu</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Load More Button -->
    <div class="flex justify-center mt-8">
      <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">See More</button>
    </div>
  </main>

  <!-- Footer -->
<footer class="bg-gradient-to-r from-green to-dark-green text-white py-5">
    <div class="container mx-auto px-4 text-center">
      <div class="flex justify-center">
        <a href="./landingpage.php">
          <img src="../../images/Logo.png" alt="Logo Lestari" class="h-20">
        </a>
      </div>
      <div class="container mx-auto grid grid-cols-3 gap-4 text-center">
      <div>
        <h4 class="font-bold">Lestari</h4>
        <p>Home</p>
        <p>Tentang Kami</p>
        <p>Layanan</p>
        <p>Blog</p>
      </div>
      <div>
        <h4 class="font-bold">Informasi</h4>
        <p>Kontak Kami</p>
      </div>
      <div>
        <h4 class="font-bold">Hubungi Kami</h4>
        <div class="flex justify-center space-x-4 mt-2">
          <a href="#"><img src="https://placehold.co/20x20" alt="Instagram"></a>
          <a href="#"><img src="https://placehold.co/20x20" alt="Facebook"></a>
          <a href="#"><img src="https://placehold.co/20x20" alt="Twitter"></a>
          <a href="#"><img src="https://placehold.co/20x20" alt="YouTube"></a>
        </div>
      </div>
    </div>
    </div>
  </footer>
    
</body>
</html>