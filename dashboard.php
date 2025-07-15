<?php
include "includes/db.php"; // jika belum

// Ambil data statistik status pengiriman
$stat_query = "SELECT status, COUNT(*) as total FROM shipments GROUP BY status";
$stat_result = mysqli_query($conn, $stat_query);

$shipment_stats = [
  'Menunggu' => 0,
  'Dalam Perjalanan' => 0,
  'Terkirim' => 0
];

while ($row = mysqli_fetch_assoc($stat_result)) {
  $shipment_stats[$row['status']] = $row['total'];
}

// Data pengiriman per hari (7 hari terakhir)
$line_data = [];
$date_labels = [];

$query = "
  SELECT shipment_date, COUNT(*) AS total
  FROM shipments
  WHERE shipment_date >= CURDATE() - INTERVAL 6 DAY
  GROUP BY shipment_date
  ORDER BY shipment_date ASC
";

$result = mysqli_query($conn, $query);

// Buat array dengan default 0 untuk setiap tanggal
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $line_data[$date] = 0;
    $date_labels[] = $date;
}

// Isi dengan hasil query
while ($row = mysqli_fetch_assoc($result)) {
    $line_data[$row['shipment_date']] = $row['total'];
}

// Konversi ke format JavaScript
$line_labels = json_encode(array_values($date_labels));
$line_values = json_encode(array_values($line_data));
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - CV Riyan Mandiri Transport</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="bg-gray-100 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow h-screen sticky top-0">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-lg font-bold text-blue-700">CV Riyan Mandiri</h2>
      <a href="dashboard.php"><p class="text-sm text-gray-500">Dashboard Admin</p></a>
    </div>
    <nav class="p-4 space-y-2">
      <a href="?page=customers" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 text-blue-700 font-medium">
        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4 4 0 017 17h10a4 4 0 011.879.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Data Pelanggan
      </a>
      <a href="?page=drivers" class="flex items-center px-4 py-2 rounded hover:bg-green-100 text-green-700 font-medium">
        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14h6m2 0a2 2 0 002-2V7a2 2 0 00-2-2h-1V4a1 1 0 00-2 0v1H10V4a1 1 0 00-2 0v1H7a2 2 0 00-2 2v5a2 2 0 002 2m0 0v2a2 2 0 002 2h6a2 2 0 002-2v-2" />
        </svg>
        Data Pengemudi
      </a>
      <a href="?page=fleet" class="flex items-center px-4 py-2 rounded hover:bg-yellow-100 text-yellow-700 font-medium">
        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16V6a1 1 0 011-1h3m10 0h3a1 1 0 011 1v10m-16 0h16m-2 4a2 2 0 11-4 0m-8 0a2 2 0 114 0" />
        </svg>
        Data Armada
      </a>
      <a href="?page=shipments" class="flex items-center px-4 py-2 rounded hover:bg-indigo-100 text-indigo-700 font-medium">
        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m4 0h2a1 1 0 001-1v-5a1 1 0 00-.293-.707L17 4H7L3.293 10.293A1 1 0 003 11v5a1 1 0 001 1h2" />
        </svg>
        Pengiriman
      </a>
      <a href="?page=reports" class="flex items-center px-4 py-2 rounded hover:bg-red-100 text-red-700 font-medium">
        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M9 7h6" />
        </svg>
        Laporan Pengiriman
      </a>
      <a href="?page=cost" class="flex items-center px-4 py-2 rounded hover:bg-red-100 text-red-700 font-medium">
        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M9 7h6" />
        </svg>
        Laporan Biaya
      </a>      
      <hr class="my-4">
      <a href="logout.php" class="flex items-center px-4 py-2 text-sm text-gray-500 hover:underline">Logout</a>
    </nav>
  </aside>

  <!-- Konten Utama -->
  <main class="flex-1 p-6">
    <h1 class="text-2xl font-semibold mb-6">Dashboard</h1>


    <div class="bg-white p-6 rounded-lg shadow">
      <?php
      $page = $_GET['page'] ?? null;
      $allowed_dirs = ['customers', 'drivers', 'fleet', 'shipments', 'reports','cost'];

      if ($page) {
          $parts = explode('/', $page);
          $folder = $parts[0];
          $file = $parts[1] ?? 'index';

          if (in_array($folder, $allowed_dirs)) {
              $path = "pages/{$folder}/{$file}.php";
              if (file_exists($path)) {
                  include $path;
              } else {
                  echo "<p class='text-red-600'>Halaman tidak ditemukan.</p>";
              }
          } else {
              echo "<p class='text-red-600'>Akses folder tidak diizinkan.</p>";
          }
      } else {
        ?>
        <div class="bg-white p-6 rounded shadow mb-10">
          <h2 class="text-xl font-bold mb-4">Statistik Pengiriman</h2>
          <canvas id="dashboardChart" height="100"></canvas>
        </div>
        <div class="bg-white p-6 rounded shadow mb-10">
          <h2 class="text-xl font-bold mb-4">Grafik Pengiriman per Hari</h2>
          <canvas id="lineChart" height="100"></canvas>
        </div>

<?php
          echo "<p class='text-gray-600'>Silakan pilih menu dari sidebar.</p>";
      }
      ?>
    </div>
  </main>
<script>
  const ctxDash = document.getElementById('dashboardChart').getContext('2d');
  const dashboardChart = new Chart(ctxDash, {
    type: 'bar',
    data: {
      labels: ['Menunggu', 'Dalam Perjalanan', 'Terkirim'],
      datasets: [{
        label: 'Jumlah Pengiriman',
        data: [
          <?= $shipment_stats['Menunggu'] ?>,
          <?= $shipment_stats['Dalam Perjalanan'] ?>,
          <?= $shipment_stats['Terkirim'] ?>
        ],
        backgroundColor: [
          'rgba(253, 224, 71, 0.7)',
          'rgba(129, 140, 248, 0.7)',
          'rgba(74, 222, 128, 0.7)'
        ],
        borderColor: [
          'rgba(202, 138, 4, 1)',
          'rgba(99, 102, 241, 1)',
          'rgba(34, 197, 94, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          precision: 0
        }
      }
    }
  });
</script>

<script>
  const ctxLine = document.getElementById('lineChart').getContext('2d');
  const lineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: <?= $line_labels ?>,
      datasets: [{
        label: 'Total Pengiriman',
        data: <?= $line_values ?>,
        fill: true,
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        borderColor: 'rgba(59, 130, 246, 1)',
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          precision: 0
        }
      }
    }
  });
</script>

</body>
</html>
