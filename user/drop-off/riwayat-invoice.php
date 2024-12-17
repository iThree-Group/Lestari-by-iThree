<?php
session_start();
include '../../controller/config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../landing-page.php");
    exit();
}

// Ambil request_id dari parameter URL
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : null;

if (!$request_id) {
    die("Request ID tidak valid.");
}

// Query untuk mendapatkan riwayat drop-off yang statusnya "accepted"
$query = "SELECT d.request_id, d.status, d.drop_off_request_created_at, u.user_email, 
                 COALESCE(SUM(dr.waste_weight * w.waste_point), 0) AS total_points, 
                 GROUP_CONCAT(w.waste_name SEPARATOR ', ') AS waste_names,
                 GROUP_CONCAT(CONCAT(w.waste_name, ' ', dr.waste_weight, 'kg') SEPARATOR ', ') AS waste_details
          FROM drop_off_request d
          INNER JOIN users u ON d.user_id = u.user_id
          LEFT JOIN detail_request dr ON d.request_id = dr.request_id
          LEFT JOIN waste w ON dr.waste_id = w.waste_id
          WHERE d.request_id = ? AND d.status = 'accepted'
          GROUP BY d.request_id";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $invoice = $result->fetch_assoc();
} else {
    die("Invoice tidak ditemukan atau belum di-accepted.");
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
<body>
<body class="font-poppins">
<main class="bg-light container mx-auto md:px-16 px-10 py-12">
<h2 class="text-2xl font-bold text-black-700 mb-4 text-center">Riwayat Drop Off</h2>
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
        <span class="<?= htmlspecialchars($invoice['status']) === 'accepted' ? 'text-green-600 font-bold' : ''; ?>">
            <?= htmlspecialchars(ucfirst($invoice['status'])); ?>
        </span>
    </p>
</div>


            <!-- Drop Off Information -->
            <div class="flex justify-between items-center text-sm text-green-600 font-semibold">
                <span><?= date('d M Y · H:i', strtotime($invoice['drop_off_request_created_at'])); ?></span>
                <span>Request ID <?= htmlspecialchars($invoice['request_id']); ?></span>
                </div>
                <hr class="border-dashed border-green-600 my-4">
            <!-- Drop Off Details -->
            <div class="mt-6 space-y-4">
                <div>
                    <h3 class="text-green-700 font-semibold text-sm">DROP OFF - LESTARI</h3>
                    <div class="bg-gray-50 rounded-lg shadow p-4 flex justify-between items-center">
                        <span>Total Poin</span>
                        <span class="text-green-600 font-bold"> <i class="fas fa-coins text-green-600"></i> 
                        <?= number_format($invoice['total_points']); ?>
                    </span>

                    </div>
                </div>
                <div>
                    <h3 class="text-green-700 font-semibold text-sm">DETAIL DROP OFF</h3>
                    <div class="bg-gray-50 rounded-lg shadow p-4">
                        <span><?= htmlspecialchars($invoice['waste_details']); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
