<?php
require 'config.php'; // Menghubungkan ke database

// Pastikan ID dikirim
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = $_GET['id'];

// Ambil data pelanggan berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM pelanggan WHERE ID_Pelanggan = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Jika pelanggan tidak ditemukan
if ($result->num_rows === 0) {
    die("Pelanggan tidak ditemukan.");
}

$row = $result->fetch_assoc();

// Menyimpan perubahan data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $ktp = $_POST['ktp'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];

    $update_stmt = $conn->prepare("UPDATE pelanggan SET Nama_Penyewa=?, No_KTP_SIM=?, Alamat=?, No_Telp_HP=? WHERE ID_Pelanggan=?");
    $update_stmt->bind_param("ssssi", $nama, $ktp, $alamat, $nohp, $id);
    $update_stmt->execute();

    // Redirect kembali ke halaman data pelanggan
    header("Location: datapelanggan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-600 text-black p-6">
            <h2 class="text-xl font-bold mb-4">RentalMobilPro Dashboard</h2>
            <nav>
                <ul class="space-y-4">
                    <li><a href="dashboard.php" class="block py-2 px-4 rounded hover:bg-blue-500 text-black">Dashboard</a></li>
                    <li><a href="datapelanggan.php" class="block py-2 px-4 rounded hover:bg-blue-500 text-black">Data Pelanggan</a></li>
                    <li><a href="transaksirental.php" class="block py-2 px-4 rounded hover:bg-blue-500 text-black">Transaksi Rental</a></li>
                    <li><a href="datakendaraan.php" class="block py-2 px-4 rounded hover:bg-blue-500 text-black">Data Kendaraan</a></li>
                </ul>
            </nav>
        </aside>

        <div class="container mx-auto p-6">
            <h2 class="text-2xl font-bold mb-4">Edit Pelanggan</h2>
            <div class="bg-white p-4 rounded shadow">
                <form method="POST">
                    <label class="block font-semibold">Nama:</label>
                    <input type="text" name="nama" value="<?= $row['Nama_Penyewa'] ?>" class="border p-2 w-full mb-2" required>

                    <label class="block font-semibold">No KTP/SIM:</label>
                    <input type="text" name="ktp" value="<?= $row['No_KTP_SIM'] ?>" class="border p-2 w-full mb-2" required>

                    <label class="block font-semibold">Alamat:</label>
                    <input type="text" name="alamat" value="<?= $row['Alamat'] ?>" class="border p-2 w-full mb-2" required>

                    <label class="block font-semibold">No HP:</label>
                    <input type="text" name="nohp" value="<?= $row['No_Telp_HP'] ?>" class="border p-2 w-full mb-2" required>

                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                    <a href="datapelanggan.php" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

