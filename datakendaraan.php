<?php
include 'config.php'; // Pastikan file koneksi sudah tersedia

// Menangani proses penambahan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $id_sewa = $_POST['id_sewa'];
    $no_polisi = $_POST['no_polisi'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];

    $stmt = $conn->prepare("INSERT INTO kendaraan (ID_Sewa, No_Polisi, Jenis_Kendaraan) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_sewa, $no_polisi, $jenis_kendaraan);
    $stmt->execute();
    $stmt->close();
    header("Location: datakendaraan.php");
    exit();
}

// Menangani proses penghapusan data
if (isset($_GET['hapus'])) {
    $id_kendaraan = $_GET['hapus'];
    $conn->query("DELETE FROM kendaraan WHERE ID_Kendaraan = '$id_kendaraan'");
    header("Location: datakendaraan.php");
    exit();
}

// Ambil data kendaraan dan transaksi rental
$result = $conn->query("SELECT kendaraan.*, penyewaan.ID_Sewa FROM kendaraan 
                        JOIN penyewaan ON kendaraan.ID_Sewa = penyewaan.ID_Sewa");
$transaksi = $conn->query("SELECT ID_Sewa FROM penyewaan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex">
    <aside class="w-64 bg-blue-600 text-white p-6 h-screen">
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
        <h2 class="text-2xl font-bold mb-4">Tambah Kendaraan</h2>
        <div class="bg-white p-4 rounded shadow mb-6">
            <form method="POST">
                <label>Pilih Transaksi Rental:</label>
                <select name="id_sewa" class="border p-2 w-full mb-2" required>
                    <?php while ($row = $transaksi->fetch_assoc()): ?>
                        <option value="<?php echo $row['ID_Sewa']; ?>">
                            <?php echo $row['ID_Sewa']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <input type="text" name="no_polisi" placeholder="No Polisi" class="border p-2 w-full mb-2" required>
                <input type="text" name="jenis_kendaraan" placeholder="Jenis Kendaraan" class="border p-2 w-full mb-2" required>
                <button type="submit" name="tambah" class="bg-green-500 text-white px-4 py-2 rounded">Tambah</button>
            </form>
        </div>
        <h2 class="text-2xl font-bold mb-4">Data Kendaraan Yang Disewa</h2>
        <div class="bg-white p-4 rounded shadow">
            <table class="w-full border-collapse border border-gray-200">
                <tr class="bg-gray-100">
                    <th class="border p-2">ID Kendaraan</th>
                    <th class="border p-2">ID Sewa</th>
                    <th class="border p-2">No Polisi</th>
                    <th class="border p-2">Jenis Kendaraan</th>
                    <th class="border p-2">Aksi</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="border p-2"><?php echo $row['ID_Kendaraan']; ?></td>
                    <td class="border p-2"><?php echo $row['ID_Sewa']; ?></td>
                    <td class="border p-2"><?php echo $row['No_Polisi']; ?></td>
                    <td class="border p-2"><?php echo $row['Jenis_Kendaraan']; ?></td>
                    <td class="border p-2">
                        <a href="datakendaraan.php?hapus=<?php echo $row['ID_Kendaraan']; ?>" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Hapus data ini?')">Hapus</a>
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


