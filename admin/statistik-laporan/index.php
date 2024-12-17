<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../css/styles.css" rel="stylesheet">
    <title>Statistik & Laporan | Admin Lestari</title>
</head>
<body>
    <div class="flex flex-row h-full w-full">
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
                <button class="btn btn-success bg-green-btn text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../statistik-laporan/'">
                    <img src="../../images/admin/Graph.png" alt="">
                    <p>Statistik & Laporan</p>
                </button>
                <button class="btn btn-success bg-transparent border-0 text-light font-bold text-xl justify-start pl-[9px] w-[271px] h-[59px] flex flex-row gap-[13px]" onclick="location.href='../kelola-reward/'">
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
        <div class="bg-light-bg-content w-full h-auto px-5 pt-5 pb-12">
            <!-- HEADER -->
            <div class="flex flex-row justify-between bg-gradient-to-r from-[#1E5E3F] to-[#3FC483] w-full h-[88px] px-[23px] rounded-[20px] text-light font-extrabold text-[32px] items-center">
                <h1>Statistik & Laporan</h1>
                <div class="dropdown dropdown-end self-center flex items-center">
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
            
            <!-- DASHBOARD CARD -->
            <div class="h-[156px] w-full mt-[63px] grid grid-cols-4 gap-7">
                <!-- Dashboard Card: Jumlah Partisipan -->
                <div class="bg-[#fff] rounded-[20px] border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col h-full text-dark gap-[30px] text-center justify-center">
                    <h3 class="text-[32px] font-medium text-[#249AEF]" id="totalParticipants"></h3>
                    <p class="text-xs font-light">Jumlah Partisipan</p>
                    <script>
                        // URL ke file PHP untuk jumlah partisipan
                        const apiUrlParticipants = 'total_participants.php';

                        // Ambil data jumlah partisipan dari backend
                        fetch(apiUrlParticipants)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Update elemen dengan data jumlah partisipan
                                document.getElementById('totalParticipants').innerText = data.total_participants;
                            })
                            .catch(error => {
                                console.error('Error fetching total participants:', error);
                            });
                    </script>
                </div>
                <!-- Dashboard Card: Total Poin Diberikan -->
                <div class="bg-[#fff] rounded-[20px] border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col h-full text-dark gap-[30px] text-center justify-center">
                    <h3 class="text-[32px] font-medium text-[#249AEF] total_points"></h3>
                    <p class="text-xs font-light">Total Poin Diberikan</p>
                    <script>
                        // URL ke file PHP untuk total poin user
                        const apiUrlPoints = "total_points.php";
                        // Ambil data total poin dari backend
                        fetch(apiUrlPoints)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Network response was not ok");
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Perbarui elemen dengan data total poin
                                document.querySelector('.total_points').innerText = data.total_points || "0"; // Tampilkan 0 jika kosong
                            })
                            .catch(error => {
                                console.error("Error fetching total points:", error);
                            });
                    </script>
                </div>
                <!-- Dashboard Card: Rata-rata Sampah Per Hari -->
                <div class="bg-[#fff] rounded-[20px] border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col h-full text-dark gap-[30px] text-center justify-center">
                    <h3 id="averagePerDay" class="text-[32px] font-medium text-[#249AEF]"></h3>
                    <p class="text-xs font-light">Rata-rata Sampah Per Hari</p>
                    <script>
                        // URL ke file PHP
                        const apiUrlAverage = 'average_waste_perday.php';
                        // Ambil data rata-rata sampah per hari
                        fetch(apiUrlAverage)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Update elemen dengan data rata-rata sampah per hari
                                document.getElementById('averagePerDay').innerText = data.average_per_day.toFixed(2) + ' kg';
                            })
                            .catch(error => {
                                console.error('Error fetching average per day:', error);
                            });
                    </script>
                </div>
                <!-- Dashboard Card: Jumlah Bank Sampah terdaftar -->
                <div class="bg-[#fff] rounded-[20px] border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col h-full text-dark gap-[30px] text-center justify-center">
                    <h3 id="totalBanks" class="text-[32px] font-medium text-[#249AEF]"></h3>
                    <p class="text-xs font-light">Bank Sampah Terdaftar</p>
                    <script>
                        // URL ke file PHP
                        const apiUrlBanks = 'total_banks.php'; 
                        // Ambil data jumlah bank sampah terdaftar
                        fetch(apiUrlBanks)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Update elemen dengan data jumlah bank sampah
                                document.getElementById('totalBanks').innerText = data.total_banks;
                            })
                            .catch(error => {
                                console.error('Error fetching total banks:', error);
                            });
                    </script>
                </div>

            </div>
            <!-- DASHBOARD CARD END -->

            <!-- CHARTS -->
            <div class="w-full grid grid-cols-2 gap-7 mt-8 text-dark">
                <!-- graph chart -->
                <div class="bg-light rounded-[20px] p-6 w-full border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)]">
                    <h3 class="font-semibold text-[20px]">Tren Pilah Bulanan (kg)</h3>
                    <!-- component -->
                    <div class="mt-6">
                        <canvas id="myChart" width="auto" height="auto" role="img" aria-label="line graph to show selling overview in terms of months and numbers"></canvas>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        // Fungsi untuk mengambil data dari 'data_per_month.php'
                        async function fetchData() {
                            const response = await fetch('data_per_month.php');  // Mengambil data dari PHP
                            const data = await response.json();  // Mengubah data menjadi format JSON
                            
                            // Memperbarui grafik dengan data yang baru
                            updateChart(data);
                        }

                        // Fungsi untuk memperbarui grafik
                        function updateChart(newData) {
                            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                            
                            // Membuat labels berdasarkan data bulan dan tahun
                            const newLabels = newData.data_per_month.map(item => `${monthNames[item.month - 1]} ${item.year}`);
                            
                            // Membuat dataset untuk total berat sampah per bulan
                            const newDataset = newData.data_per_month.map(item => item.total_weight);
                            
                            // Memperbarui data grafik
                            chart.data.labels = newLabels;
                            chart.data.datasets[0].data = newDataset;
                            
                            // Memperbarui grafik
                            chart.update();
                        }

                        // Membuat grafik pertama kali setelah data dimuat
                        let chart;

                        async function initializeChart() {
                            const response = await fetch('data_per_month.php');  // Mengambil data dari PHP
                            const jsonData = await response.json();  // Mengubah data menjadi format JSON

                            // Membuat array bulan dan data total berat sampah per bulan
                            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                            
                            // Labels berdasarkan bulan dan tahun
                            const labels = jsonData.data_per_month.map(item => `${monthNames[item.month - 1]} ${item.year}`);

                            // Data untuk grafik
                            const data = jsonData.data_per_month.map(item => item.total_weight);

                            // Membuat grafik
                            const ctx = document.getElementById("myChart").getContext("2d");
                            chart = new Chart(ctx, {
                                type: "line",
                                data: {
                                    labels: labels,  // Labels untuk bulan dan tahun
                                    datasets: [{
                                        label: "Berat Sampah (Kg)",
                                        borderColor: "#249AEF",
                                        data: data, // Total berat sampah per bulan
                                        fill: false,
                                        pointBackgroundColor: "#4A5568",
                                        borderWidth: 3,
                                        pointBorderWidth: 4,
                                        pointHoverRadius: 6,
                                        pointHoverBorderWidth: 8,
                                        pointHoverBorderColor: "rgb(74,85,104,0.2)"
                                    }]
                                },
                                options: {
                                    responsive: true,  // Membuat chart responsif terhadap perubahan ukuran canvas
                                    plugins: {
                                        legend: {
                                            position: "top"
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        }

                        // Panggil fungsi untuk memulai chart dan ambil data dari PHP
                        initializeChart();

                    </script>
                </div>

                <!-- Doughnut CHART -->
                <div class="bg-light rounded-[20px] p-6 w-full border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)]">
                    <h3 class="font-semibold text-[20px] mb-1">Distribusi Jenis Sampah</h3>
                    <div class="place-self-center w-auto px-[115px] overflow-hidden">
                        <canvas class="p-2" id="chartDoughnut"></canvas>
                        </div>
                        <!-- Required chart.js -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                        <!-- Chart doughnut -->
                        <script>
                            // Mengambil data dari API PHP
                            fetch('waste_type_data.php')  // Ganti URL dengan path API PHP
                                .then(response => response.json())
                                .then(data => {
                                    // Menyiapkan data untuk chart
                                    const labels = data.map(item => item.jenis);  // Label berdasarkan jenis sampah
                                    const dataValues = data.map(item => item.jumlah);  // Data jumlah sampah

                                    const dataDoughnut = {
                                        labels: labels,
                                        datasets: [{
                                            label: "Distribusi Jenis Sampah (kg)",
                                            data: dataValues,
                                            backgroundColor: [
                                                "rgb(0, 150, 255)",
                                                "rgb(0, 128, 0)",
                                                "rgb(255, 0, 0)",
                                                "rgb(255, 165, 0)",
                                                "rgb(128, 0, 128)"
                                            ],
                                            hoverOffset: 4,
                                        }]
                                    };

                                    const configDoughnut = {
                                        type: "doughnut",
                                        data: dataDoughnut,
                                        options: {},
                                    };

                                    // Membuat grafik
                                    var chartDoughnut = new Chart(
                                        document.getElementById("chartDoughnut"),
                                        configDoughnut
                                    );
                                })
                                .catch(error => console.error("Error fetching data:", error));
                        </script>
                </div>
            </div>
            <!-- CHARTS END -->
            <!-- Laporan Program -->
            <div class="bg-light w-full p-6 rounded-[20px] mt-[30px] border border-gray shadow-[0px_4px_4px_-0px_rgba(0,0,0,0.25)] flex flex-col text-dark gap-[30px]">
                <h3 class="font-semibold text-[20px] mb-1">General Statistik dan Insight Aktivitas Drop-Off</h3>
                <table class="table border-collapse border border-[#828282] text-center w-full table-fixed">
                    <!-- head -->
                    <thead class="bg-[#E5E5E5] text-dark text-sm font-bold">
                        <tr class="border border-[#828282]">
                            <th class="border border-[#828282] w-1/2">Keterangan</th>
                            <th class="border border-[#828282] w-1/2">Detail</th>
                        </tr>
                    </thead>
                    <tbody id="reportTable" class="font-medium">
                        <!-- Data akan dimuat di sini -->
                    </tbody>
                </table>
            </div>
            <script>
                const reportApiUrl = 'general_stats.php'; // URL ke file PHP untuk statistik

                // Ambil data statistik dari backend
                fetch(reportApiUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const reportTable = document.getElementById('reportTable');
                        
                        // Reset tabel
                        reportTable.innerHTML = '';

                        // Menampilkan Total Berat Sampah Sepanjang Tahun
                        let reportHTML = `
                            <tr>
                                <td class="border border-[#828282]">Total Berat Sampah Sepanjang Tahun</td>
                                <td class="border border-[#828282]">${data.total_weight || 0} Kg</td>
                            </tr>
                        `;

                        // Menampilkan Bulan dengan Sampah Terbanyak
                        if (data.top_months && data.top_months.length > 0) {
                            const topMonths = data.top_months
                                .map(month => `${month.month_name} (${month.total_weight} Kg)`)
                                .join(', ');
                            reportHTML += `
                                <tr>
                                    <td class="border border-[#828282]">Bulan dengan Sampah Terbanyak</td>
                                    <td class="border border-[#828282]">${topMonths}</td>
                                </tr>
                            `;
                        } else {
                            reportHTML += `
                                <tr>
                                    <td class="border border-[#828282]">Bulan dengan Sampah Terbanyak</td>
                                    <td class="border border-[#828282]">-</td>
                                </tr>
                            `;
                        }

                        // Menampilkan Jenis Sampah Terbanyak
                        reportHTML += `
                            <tr>
                                <td class="border border-[#828282]">Jenis Sampah Terbanyak</td>
                                <td class="border border-[#828282]">${data.top_waste_type || 'Tidak ada'} (${data.top_waste_weight || 0} Kg)</td>
                            </tr>
                        `;

                        // Masukkan data ke dalam tabel
                        reportTable.innerHTML = reportHTML;
                    })
                    .catch(error => {
                        console.error('Error fetching report data:', error);

                        // Tampilkan error di tabel
                        const reportTable = document.getElementById('reportTable');
                        reportTable.innerHTML = `
                            <tr>
                                <td colspan="2" class="border border-[#828282] text-center">Gagal memuat data: ${error.message}</td>
                            </tr>
                        `;
                    });
            </script>
            <!-- Laporan Program End-->
        </div>
    </div>

    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>
</html>