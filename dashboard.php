<?php
include 'config.php'; // Pastikan file koneksi sudah tersedia

// Ambil data ringkasan
$total_pelanggan = $conn->query("SELECT COUNT(*) as total FROM pelanggan")->fetch_assoc()['total'];
$total_kendaraan = $conn->query("SELECT COUNT(*) as total FROM kendaraan")->fetch_assoc()['total'];
$kendaraan_disewa = $conn->query("SELECT COUNT(*) as total FROM penyewaan")->fetch_assoc()['total'];
$total_pendapatan = $conn->query("SELECT SUM(Biaya_Sewa) as total FROM penyewaan")->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-600 text-white p-6 h-screen">
        <h2 class="text-xl font-bold mb-4">Ental Mbim Motoy</h2>
        <nav>
            <ul class="space-y-4">
                <li><a href="dashboard.php" class="block py-2 px-4 rounded bg-blue-500">Dashboard</a></li>
                <li><a href="datapelanggan.php" class="block py-2 px-4 rounded hover:bg-blue-500">Data Pelanggan</a></li>
                <li><a href="transaksirental.php" class="block py-2 px-4 rounded hover:bg-blue-500">Transaksi Rental</a></li>
                <li><a href="datakendaraan.php" class="block py-2 px-4 rounded hover:bg-blue-500">Data Kendaraan</a></li>
            </ul>
        </nav>
    </aside>

    <main class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded shadow text-center">
                <h3 class="text-lg font-bold">Total Pelanggan</h3>
                <p class="text-2xl"><?php echo $total_pelanggan; ?></p>
            </div>
            <div class="bg-white p-6 rounded shadow text-center">
                <h3 class="text-lg font-bold">Total Kendaraan</h3>
                <p class="text-2xl"><?php echo $total_kendaraan; ?></p>
            </div>
            <div class="bg-white p-6 rounded shadow text-center">
                <h3 class="text-lg font-bold">Kendaraan Disewa</h3>
                <p class="text-2xl"><?php echo $kendaraan_disewa; ?></p>
            </div>
            <div class="bg-white p-6 rounded shadow text-center">
                <h3 class="text-lg font-bold">Total Pendapatan</h3>
                <p class="text-2xl">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></p>
            </div>
        </div>
    </main>
</body>
</html>

<?php
$conn->close();
?>