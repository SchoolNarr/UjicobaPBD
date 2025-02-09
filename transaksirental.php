<?php
include 'config.php'; // Pastikan file koneksi sudah tersedia

// Menangani proses penambahan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $lama_sewa = $_POST['lama_sewa'];
    $tanggal_diambil = $_POST['tanggal_diambil'];
    $waktu_diambil = $_POST['waktu_diambil'];
    $tanggal_dikembalikan = $_POST['tanggal_dikembalikan'];
    $waktu_dikembalikan = $_POST['waktu_dikembalikan'];
    $driver_non_driver = $_POST['driver_non_driver'];
    $biaya_sewa = $_POST['biaya_sewa'];
    $keterangan_lain = $_POST['keterangan_lain'];

    $stmt = $conn->prepare("INSERT INTO penyewaan (ID_Pelanggan, Lama_Sewa, Tanggal_Diambil, Waktu_Diambil, Tanggal_Dikembalikan, Waktu_Dikembalikan, Driver_Non_Driver, Biaya_Sewa, Keterangan_Lain) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssssis", $id_pelanggan, $lama_sewa, $tanggal_diambil, $waktu_diambil, $tanggal_dikembalikan, $waktu_dikembalikan, $driver_non_driver, $biaya_sewa, $keterangan_lain);
    $stmt->execute();
    $stmt->close();
    header("Location: transaksirental.php");
    exit();
}

// Menangani proses penghapusan data
if (isset($_GET['hapus'])) {
    $id_sewa = $_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM penyewaan WHERE ID_Sewa = ?");
    $stmt->bind_param("i", $id_sewa);
    $stmt->execute();
    $stmt->close();
    header("Location: transaksirental.php");
    exit();
}

// Default values for sorting
$sort = $_GET['sort'] ?? 'ID_Sewa';
$order = $_GET['order'] ?? 'asc';
$month_filter = $_GET['month_filter'] ?? ''; // Tambahkan variabel filter bulan

// Validate the sort input to prevent SQL Injection
$allowed_columns = ['ID_Sewa', 'Nama_Penyewa', 'Lama_Sewa', 'Tanggal_Diambil'];
if (!in_array($sort, $allowed_columns)) {
    $sort = 'ID_Sewa';
}
$order = ($order === 'desc') ? 'desc' : 'asc';

// Query data transaksi dengan filter bulan jika ada
$query = "SELECT penyewaan.*, pelanggan.Nama_Penyewa FROM penyewaan 
          JOIN pelanggan ON penyewaan.ID_Pelanggan = pelanggan.ID_Pelanggan";
if (!empty($month_filter)) {
    $query .= " WHERE DATE_FORMAT(Tanggal_Diambil, '%Y-%m') = '$month_filter'";
}
$query .= " ORDER BY $sort $order";

$result = $conn->query($query);
$pelanggan = $conn->query("SELECT ID_Pelanggan, Nama_Penyewa FROM pelanggan");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function printTable() {
            var printContents = document.getElementById('transaksiTable').outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</head>
<body class="bg-gray-100 flex">
    <aside class="w-64 bg-blue-600 text-white p-6" h-screen>
        <h2 class="text-xl font-bold mb-4">Ental Mbim Motoy</h2>
        <nav>
            <ul class="space-y-4">
                <li><a href="dashboard.php" class="block py-2 px-4 rounded hover:bg-blue-500">Dashboard</a></li>
                <li><a href="datapelanggan.php" class="block py-2 px-4 rounded hover:bg-blue-500">Data Pelanggan</a></li>
                <li><a href="transaksirental.php" class="block py-2 px-4 rounded hover:bg-blue-500">Transaksi Rental</a></li>
                <li><a href="datakendaraan.php" class="block py-2 px-4 rounded hover:bg-blue-500">Data Kendaraan</a></li>
            </ul>
        </nav>
    </aside>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Transaksi Rental</h2>
        <div class="bg-white p-4 rounded shadow mb-6">
            <form method="POST">
                <label>Pilih Pelanggan:</label>
                <select name="id_pelanggan" class="border p-2 w-full mb-2" required>
                    <?php while ($row = $pelanggan->fetch_assoc()): ?>
                        <option value="<?php echo $row['ID_Pelanggan']; ?>">
                            <?php echo $row['Nama_Penyewa']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <input type="number" name="lama_sewa" placeholder="Lama Sewa (hari)" class="border p-2 w-full mb-2" required>
                <input type="date" name="tanggal_diambil" class="border p-2 w-full mb-2" required>
                <input type="time" name="waktu_diambil" class="border p-2 w-full mb-2" required>
                <input type="date" name="tanggal_dikembalikan" class="border p-2 w-full mb-2" required>
                <input type="time" name="waktu_dikembalikan" class="border p-2 w-full mb-2" required>
                <label class="block mb-2">Driver atau Non-Driver:</label>
                <label class="inline-flex items-center">
                    <input type="radio" name="driver_non_driver" value="Driver" class="mr-2" required> Driver
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="radio" name="driver_non_driver" value="Non-Driver" class="mr-2" required> Non-Driver
                </label>
                <input type="number" name="biaya_sewa" placeholder="Biaya Sewa" class="border p-2 w-full mb-2" required>
                <input type="text" name="keterangan_lain" placeholder="Keterangan Lain" class="border p-2 w-full mb-2">
                <button type="submit" name="tambah" class="bg-green-500 text-white px-4 py-2 rounded">Tambah</button>
            </form>
        </div>
        <h2 class="text-2xl font-bold mb-4">Data Transaksi Rental</h2>
        <button onclick="printTable()" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Cetak</button>

        <!-- Filter Bulan -->
        <form method="GET" class="mb-4">
            <label for="month_filter" class="block mb-2 font-bold">Filter Berdasarkan Bulan:</label>
            <input type="month" id="month_filter" name="month_filter" value="<?php echo $month_filter; ?>" class="border p-2 mb-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Terapkan Filter</button>
            <a href="transaksirental.php" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Reset Filter</a>
        </form>

        <div class="bg-white p-4 rounded shadow">
            <table id="transaksiTable" class="w-full border-collapse border border-gray-200">
            <tr class="bg-gray-100">
                <?php $filter_param = !empty($month_filter) ? '&month_filter=' . $month_filter : ''; ?>
                <th class="border p-2">
                    ID Sewa
                    <a href="?sort=ID_Sewa&order=asc<?php echo $filter_param; ?>" class="text-blue-600">⬆️</a>
                    <a href="?sort=ID_Sewa&order=desc<?php echo $filter_param; ?>" class="text-blue-600">⬇️</a>
                </th>
                <th class="border p-2">
                    Nama Penyewa
                    <a href="?sort=Nama_Penyewa&order=asc<?php echo $filter_param; ?>" class="text-blue-600">⬆️</a>
                    <a href="?sort=Nama_Penyewa&order=desc<?php echo $filter_param; ?>" class="text-blue-600">⬇️</a>
                </th>
                <th class="border p-2">
                    Lama Sewa
                    <a href="?sort=Lama_Sewa&order=asc<?php echo $filter_param; ?>" class="text-blue-600">⬆️</a>
                    <a href="?sort=Lama_Sewa&order=desc<?php echo $filter_param; ?>" class="text-blue-600">⬇️</a>
                </th>
                <th class="border p-2">
                    Tanggal Diambil
                    <a href="?sort=Tanggal_Diambil&order=asc<?php echo $filter_param; ?>" class="text-blue-600">⬆️</a>
                    <a href="?sort=Tanggal_Diambil&order=desc<?php echo $filter_param; ?>" class="text-blue-600">⬇️</a>
                </th>
                <th class="border p-2">Waktu Diambil</th>
                <th class="border p-2">Tanggal Dikembalikan</th>
                <th class="border p-2">Waktu Dikembalikan</th>
                <th class="border p-2">Driver/Non-Driver</th>
                <th class="border p-2">Biaya Sewa</th>
                <th class="border p-2">Keterangan</th>
                <th class="border p-2">Aksi</th>
            </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="border p-2"><?php echo $row['ID_Sewa']; ?></td>
                    <td class="border p-2"><?php echo $row['Nama_Penyewa']; ?></td>
                    <td class="border p-2"><?php echo $row['Lama_Sewa']; ?></td>
                    <td class="border p-2"><?php echo $row['Tanggal_Diambil']; ?></td>
                    <td class="border p-2"><?php echo $row['Waktu_Diambil']; ?></td>
                    <td class="border p-2"><?php echo $row['Tanggal_Dikembalikan']; ?></td>
                    <td class="border p-2"><?php echo $row['Waktu_Dikembalikan']; ?></td>
                    <td class="border p-2"><?php echo $row['Driver_Non_Driver']; ?></td>
                    <td class="border p-2"><?php echo $row['Biaya_Sewa']; ?></td>
                    <td class="border p-2"><?php echo $row['Keterangan_Lain']; ?></td>
                    <td class="border p-2">
                        <a href="transaksirental.php?hapus=<?php echo $row['ID_Sewa']; ?>" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </main>
</body>
</html>

<?php
$conn->close();
?>
