<?php
include 'config.php'; // Pastikan file koneksi sudah tersedia

// Menangani proses penambahan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $nama_penyewa = $_POST['nama_penyewa'];
    $no_ktp_sim = $_POST['no_ktp_sim'];
    $alamat = $_POST['alamat'];
    $no_telp_hp = $_POST['no_telp_hp'];
    
    $stmt = $conn->prepare("INSERT INTO pelanggan (Nama_Penyewa, No_KTP_SIM, Alamat, No_Telp_HP) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama_penyewa, $no_ktp_sim, $alamat, $no_telp_hp);
    $stmt->execute();
    $stmt->close();
    header("Location: datapelanggan.php");
    exit();
}

if (isset($_GET['hapus'])) {
    $id_pelanggan = $_GET['hapus'];
    
    // Hapus transaksi rental terlebih dahulu
    $conn->query("DELETE FROM penyewaan WHERE ID_Pelanggan='$id_pelanggan'");

    // Setelah transaksi rental terhapus, hapus pelanggan
    if ($conn->query("DELETE FROM pelanggan WHERE ID_Pelanggan='$id_pelanggan'")) {
        header("Location: datapelanggan.php?status=deleted");
        exit();
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex">
    <!-- Sidebar -->
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

    <div class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Pelanggan</h2>
        <div class="bg-white p-4 rounded shadow mb-6">
            <form method="POST">
                <input type="text" name="nama_penyewa" placeholder="Nama Penyewa" class="border p-2 w-full mb-2" required>
                <input type="text" name="no_ktp_sim" placeholder="No KTP/SIM" class="border p-2 w-full mb-2" required>
                <input type="text" name="alamat" placeholder="Alamat" class="border p-2 w-full mb-2" required>
                <input type="text" name="no_telp_hp" placeholder="No Telepon/HP" class="border p-2 w-full mb-2" required>
                <button type="submit" name="tambah" class="bg-green-500 text-white px-4 py-2 rounded">Tambah</button>
            </form>
        </div>
        
        <h2 class="text-2xl font-bold mb-4">Data Pelanggan</h2>
        <div class="bg-white p-4 rounded shadow">
            <table class="w-full border-collapse border border-gray-200">
                <tr class="bg-gray-100">
                    <th class="border p-2">ID Pelanggan</th>
                    <th class="border p-2">Nama Penyewa</th>
                    <th class="border p-2">No KTP/SIM</th>
                    <th class="border p-2">Alamat</th>
                    <th class="border p-2">No Telepon/HP</th>
                    <th class="border p-2">Aksi</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="border p-2"><?php echo $row['ID_Pelanggan']; ?></td>
                    <td class="border p-2"><?php echo $row['Nama_Penyewa']; ?></td>
                    <td class="border p-2"><?php echo $row['No_KTP_SIM']; ?></td>
                    <td class="border p-2"><?php echo $row['Alamat']; ?></td>
                    <td class="border p-2"><?php echo $row['No_Telp_HP']; ?></td>
                    <td class="border p-2 flex gap-4">
                        <a href="edit_pelanggan.php?id=<?php echo $row['ID_Pelanggan']; ?>" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <a href="datapelanggan.php?hapus=<?php echo $row['ID_Pelanggan']; ?>" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>

