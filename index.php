<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/styles.css">
  <title>Homepage Lestari</title>
</head>
<body>
  <!-- NAVBAR -->
  <nav class="relative px-4 md:px-9 h-12 md:h-16 flex justify-between lg:justify-normal xl:justify-center items-center bg-light">
		<a class="flex justify-start xl:justify-normal" href="./landing-page.php">
			<img src="./images/logo-crop.png" class="h-4 md:h-5" alt="Logo Lestari">
		</a>
		<div class="lg:hidden">
			<button class="navbar-burger flex items-center text-blue-600 p-3">
				<svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<title>Mobile menu</title>
					<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
				</svg>
			</button>
		</div>
		<div class="hidden lg:flex ml-auto xl:ml-64 justify-end xl:justify-normal gap-8">
        <ul class="menu menu-horizontal px-1 text-dark text-base gap-2">
            <li><a>Home</a></li>
            <li><a>Tentang kami</a></li>
            <li>
              <details>
                <summary>Layanan</summary>
                  <ul ul class="bg-light absolute left-1/2 transform -translate-x-1/2 rounded-[10px] border-[1px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] border-gray px-[14px] py-[20px] flex-wrap flex items-center gap-[11px] min-w-[475px] h-[144px]">
                    <li><button class="btn btn-success w-[142px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex px-2.5 content-center text-light text-base font-medium gap-[10px]">
                      <img src="./images/truck.png" class="w-10" alt="">
                      <p>Drop Off</p>
                    </button></li>
                    <li><button class="btn btn-success w-[142px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex px-2.5 content-center text-light text-base font-medium gap-[5px]">
                      <img src="./images/reward.png" class="w-10" alt="">
                      <p>Rewards</p>
                    </button></li>
                    <li><button class="btn btn-success w-[142px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex px-2.5 content-center text-light text-base font-medium gap-2">
                      <img src="./images/Vector.png" class="w-8" alt="">
                      <p>Tutorial</p>
                    </button></li>
                    <li><button class="btn btn-success w-[171px] shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] rounded-[20px] flex px-2.5 content-center text-light text-base font-medium gap-[6px]">
                      <img src="./images/marketplace.png" class="w-10" alt="">
                      <p>Marketplace</p>
                    </button></li>
                  </ul>
              </details>
            </li>
            <li><a>Blog</a></li>
            <li><a>Kontak Kami</a></li>
          </ul>
      <div class="flex justify-end flex-row gap-4 w-auto items-center">
          <!-- JIKA BELUM LOGIN -->
          <a class="hidden lg:flex lg:ml-auto h-9 px-5 text-base font-medium rounded-3xl transition duration-200 bg-gradient-to-r from-green to-dark-green text-light border-dark border items-center" href="#">Sign In</a>
          <a class="hidden lg:flex px-5 h-9 text-base font-medium rounded-3xl transition duration-200 border-dark border-2 text-dark items-center" href="#">Sign up</a>

          <!-- JIKA SUDAH LOGIN -->
          <!-- <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar ml-8">
            <div class="w-9 rounded-full">
              <img
                alt="Tailwind CSS Navbar component"
                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
            </div>
          </div> -->
          <!-- END IF -->
      </div>
    </div>
	</nav>
	<div class="navbar-menu relative z-50 hidden ">
		<div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
		<nav class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-light border-r overflow-y-auto">
			<div class="flex items-center mb-8">
				<a class="mr-auto text-3xl font-bold leading-none" href="./">
					<img src="./images/logo-crop.png" class="h-5" alt="Logo Lestari">
				</a>
				<button class="navbar-close">
					<svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</button>
			</div>
			<div>
        <ul class="menu rounded-box w-full">
          <li class="mb-1">
						<a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Home</a>
					</li>
          <li class="mb-1">
						<a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Tentang kami</a>
					</li>
          <li>
            <details open>
              <summary class="p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded">Layanan</summary>
              <ul>
                <li class="mb-1">
                  <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Drop Off</a>
                </li>
                <li class="mb-1">
                  <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Rewards</a>
                </li>
                <li class="mb-1">
                  <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Tutorial</a>
                </li>
                <li class="mb-1">
                  <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Marketplace</a>
                </li>
              </ul>
            </details>
          </li>
          <li class="mb-1">
						<a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Blog</a>
					</li>
          <li class="mb-1">
						<a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded" href="#">Kontak kami</a>
					</li>
        </ul>
			</div>
			<div class="mt-auto">
        <div class="pt-6">
          <!-- JIKA BELUM LOGIN -->
					<a class="block px-4 py-3 mb-3 leading-loose text-xs text-center font-semibold bg-gray-50 hover:bg-gray-100 rounded-xl" href="#">Sign In</a>
					<a class="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-semibold bg-blue-600 hover:bg-blue-700  rounded-xl" href="#">Sign Up</a>

          <!-- JIKA SUDAH LOGIN -->
          <!-- <a class="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-semibold bg-blue-600 hover:bg-blue-700  rounded-xl" href="#">Nama User</a>
          <a class="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-semibold bg-blue-600 hover:bg-blue-700  rounded-xl" href="#">Log Out</a> -->

          <!-- ENDIF -->
				</div>
        
				<p class="my-4 text-xs text-center text-gray-400">
					<span>Lestari by iThree © 2024</span>
				</p>
			</div>
		</nav>
	</div>
  <!-- NAVBAR END -->

  <!-- HERO -->
  <section class="w-full bg-gradient-to-r from-green to-dark-green h-auto md:h-[375px] lg:h-[500px]">
    <div class="xl:w-[1280px] xl:place-self-center xl:px-12 flex flex-col md:flex-row md:justify-between md:pl-9">
      <div class="h-64 lg:h-auto md:h-auto w-full items-center flex flex-col gap-4 px-4 md:px-0 justify-center content-center md:items-start xl:items-baseline text-light text-center md:text-left xl:w-auto">
        <h1 class="text-xl md:text-3xl lg:text-4xl w-72 md:w-[363px] lg:w-[450px] md:leading-normal lg:leading-relaxed font-extrabold">Tukarkan Sampah, Dapatkan Hadiahnya</h1>
        <p class="text-base md:text-xl font-medium">#TukarSampahUntukKebaikan</p>
      </div>
      <img src="./images/banner_hero.png" class="w-full md:w-[375px] lg:w-[500px] rounded-t-[100px] md:rounded-l-[100px] md:rounded-tr-none md:justify-end xl:justify-start" alt="">
    </div>
  </section>
  <!-- HERO END -->

  <div class="bg-light">
    <!-- STATISTIK -->
    <section class="w-full pt-10 md:pt-12 text-dark">
      <div class="xl:w-[1280px] xl:place-self-center flex flex-col md:grid md:grid-cols-2 md:gap-4 lg:gap-6 xl:gap-8 px-4 md:px-9 items-center">
        <div class="flex justify-center md:justify-normal items-center aspect-square">
          <div class="w-44 h-44 md:px-20 md:py-20 md:h-full md:w-auto bg-gradient-to-b from-green to-dark-green rounded-3xl flex justify-center items-center">
            <img src="./images/chart-crop.png" class="md:h-full aspect-auto" alt="">
          </div>
        </div>
        <div class="flex flex-col items-center md:items-start">
          <h2 class="text-base md:text-lg lg:text-2xl lg:leading-normal font-extrabold text-center md:text-justify max-w-80 md:max-w-full mt-6 md:mt-0">Kelola Sampah dengan Drop Off, Dapatkan Poin Berharga</h2>
          <p class="text-sm lg:text-base font-medium text-justify mt-6 md:mt-2">LESTARI mengajak kamu untuk melakukan Drop Off sampah di bank sampah terdekat dan mendapatkan hadiah menarik. Pilah sampahmu (plastik, kertas, logam, atau organik), bawa ke bank sampah, kumpulkan poin, dan tukarkan dengan hadiah ramah lingkungan. Dengan Drop Off, kamu ikut berkontribusi menjaga bumi, mengurangi sampah di lingkungan, serta mendukung upaya daur ulang. Ayo, manfaatkan fitur ini dan jadikan bumi lebih bersih dan hijau!</p>
          <div class="w-full grid grid-cols-2 gap-[1px] h-auto text-light text-center mt-6 md:mt-3 items-center">
            <div class="bg-green flex flex-col items-center justify-center py-2 lg:py-4 rounded-l-2xl">
              <h3 class="text-base lg:text-lg xl:text-xl font-extrabold">2jt kg+</h3>
              <p class="text-sm lg:text-base font-medium max-w-24 lg:max-w-28">Sampah didaur ulang</p>
            </div>
            <div class="bg-green flex flex-col items-center justify-center h-full rounded-r-2xl">
              <h3 class="text-base lg:text-lg xl:text-xl font-extrabold">15rb+</h3>
              <p class="text-sm lg:text-base font-medium">Pengguna</p>
            </div>
          </div>
          <div class="flex flex-row place-self-start mt-5 md:mt-3 gap-2.5 items-center">
            <p class="font-extrabold text-sm lg:text-base xl:text-lg">Lihat Selengkapnya</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
              <path d="M15.2516 9.37579H3.23261C3.0611 9.37579 2.89662 9.44164 2.77534 9.55885C2.65407 9.67606 2.58594 9.83503 2.58594 10.0008C2.58594 10.1665 2.65407 10.3255 2.77534 10.4427C2.89662 10.5599 3.0611 10.6258 3.23261 10.6258H15.2516L10.5348 15.1833C10.4134 15.3006 10.3452 15.4598 10.3452 15.6258C10.3452 15.7918 10.4134 15.9509 10.5348 16.0683C10.6562 16.1856 10.8209 16.2516 10.9926 16.2516C11.1644 16.2516 11.3291 16.1856 11.4505 16.0683L17.2705 10.4433C17.3307 10.3852 17.3785 10.3163 17.4111 10.2403C17.4437 10.1644 17.4605 10.083 17.4605 10.0008C17.4605 9.91858 17.4437 9.83718 17.4111 9.76125C17.3785 9.68532 17.3307 9.61635 17.2705 9.55829L11.4505 3.93329C11.3291 3.81593 11.1644 3.75 10.9926 3.75C10.8209 3.75 10.6562 3.81593 10.5348 3.93329C10.4134 4.05065 10.3452 4.20982 10.3452 4.37579C10.3452 4.54176 10.4134 4.70093 10.5348 4.81829L15.2516 9.37579Z" fill="black"/>
            </svg>
          </div>
        </div>
      </div>
    </section>
    <!-- STATISTIK END -->
  
    <!-- LAYANAN -->
    <section class="w-full pt-10 md:pt-12 text-dark">
      <div class="xl:w-[1280px] xl:place-self-center px-4 md:px-9">
        <div class="flex flex-col text-dark gap-2 text-center items-center">
          <h2 class="font-extrabold text-[18px]">Layanan</h2>
          <p class="font-light text-sm max-w-72 sm:max-w-full">Revolusi daur ulang dari Mall Sampah untuk semua orang</p>
        </div>
        <div class="mt-4 flex flex-col md:grid md:grid-cols-3 gap-8">
          <div class="w-full pt-5 pb-8 px-5 items-center flex flex-col border-gray border-2 shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl">
            <img src="./images/reward.png" class="w-8" alt="">
            <h3 class="font-semibold text-[18px] mt-1">Rewards</h3>
            <p class="font-light text-sm mt-2 text-center max-w-80">Lestari mengubah sampahmu menjadi poin yang bisa kamu kumpulkan dan tukarkan dengan berbagai hadiah ramah lingkungan atau produk menarik lainnya.</p>
          </div>
          <div class="w-full pt-5 pb-8 px-5 items-center flex flex-col border-gray border-2 shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl">
            <img src="./images/Vector.png" class="w-8" alt="">
            <h3 class="font-semibold text-[18px] mt-1">Tutorial</h3>
            <p class="font-light text-sm mt-2 text-center max-w-80">Lestari menyediakan video tutorial mendaur ulang sampah menjadi produk berguna dan kreatif. Pelajari langkah-langkah mudah untuk mengubah limbah menjadi barang bernilai dan dukung gaya hidup ramah lingkungan.</p>
          </div>
          <div class="w-full pt-5 pb-8 px-5 items-center flex flex-col border-gray border-2 shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl">
            <img src="./images/marketplace.png" class="w-8" alt="">
            <h3 class="font-semibold text-[18px] mt-1">Marketplace</h3>
            <p class="font-light text-sm mt-2 text-center max-w-80">Marketplace Lestari menyediakan berbagai produk daur ulang berkualitas yang dapat kamu beli. Dukung gerakan ramah lingkungan dengan berbelanja produk-produk unik  di Lestari.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- LAYANAN END -->

    <!-- JENIS SAMPAH -->
    <section class="w-full pb-10 pt-10 md:pt-12 text-dark">
      <div class="xl:w-[1280px] xl:place-self-center px-4 md:px-9">
        <div class="flex flex-col text-dark gap-2 text-center items-center">
          <h2 class="font-extrabold text-[18px]">Jenis Sampah</h2>
          <p class="font-light text-sm max-w-72 sm:max-w-full">Lihat semua jenis sampah yang kami daur ulang.</p>
        </div>
        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-5">
          <div class="w-full pt-5 pb-7 items-center flex flex-col border-gray border shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl gap-2">
            <img src="./images/paper.png" class="w-9" alt="">
            <p class="font-light text-base text-center">Kertas</p>
          </div>
          <div class="w-full pt-5 pb-7 items-center flex flex-col border-gray border shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl gap-2">
            <img src="./images/paper.png" class="w-9" alt="">
            <p class="font-light text-base text-center">Kertas</p>
          </div>
          <div class="w-full pt-5 pb-7 items-center flex flex-col border-gray border shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl gap-2">
            <img src="./images/paper.png" class="w-9" alt="">
            <p class="font-light text-base text-center">Kertas</p>
          </div>
          <div class="w-full pt-5 pb-7 items-center flex flex-col border-gray border shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl gap-2">
            <img src="./images/paper.png" class="w-9" alt="">
            <p class="font-light text-base text-center">Kertas</p>
          </div>
          <div class="w-full pt-5 pb-7 items-center flex flex-col border-gray border shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl gap-2">
            <img src="./images/paper.png" class="w-9" alt="">
            <p class="font-light text-base text-center">Kertas</p>
          </div>
          <div class="w-full pt-5 pb-7 items-center flex flex-col border-gray border shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl gap-2">
            <img src="./images/paper.png" class="w-9" alt="">
            <p class="font-light text-base text-center">Kertas</p>
          </div>
          <div class="w-full pt-5 pb-7 items-center flex flex-col border-gray border shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl gap-2">
            <img src="./images/paper.png" class="w-9" alt="">
            <p class="font-light text-base text-center">Kertas</p>
          </div>
          <div class="w-full pt-5 pb-7 items-center flex flex-col border-gray border shadow-[0px_4px_4px_rgba(0,0,0,0.25)] rounded-3xl gap-2">
            <img src="./images/paper.png" class="w-9" alt="">
            <p class="font-light text-base text-center">Kertas</p>
          </div>
        </div>
      </div>
    </section>
    <!-- JENIS SAMPAH END -->
  </div>

  <!-- FOOTER -->

</body>

<script>
// Burger menus
document.addEventListener('DOMContentLoaded', function() {
    // open
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');

    if (burger.length && menu.length) {
        for (var i = 0; i < burger.length; i++) {
            burger[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    // close
    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');

    if (close.length) {
        for (var i = 0; i < close.length; i++) {
            close[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    if (backdrop.length) {
        for (var i = 0; i < backdrop.length; i++) {
            backdrop[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }
});
</script>

</html>