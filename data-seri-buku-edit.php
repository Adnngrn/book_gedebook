<?php
    include 'koneksi.php';

    // Ambil ID buku dari parameter URL
    $id_buku = $_GET['id'];

    // Query untuk mengambil data buku yang akan diedit
    $sql_buku = "SELECT s.*, k.id_kategori, k.kategori 
                 FROM seri_buku s
                 JOIN kategori k ON s.kategori_buku = k.id_kategori 
                 WHERE s.id_seribuku = $id_buku";
    $result_buku = $conn->query($sql_buku);
    $data_buku = $result_buku->fetch_assoc();

    // Query untuk daftar kategori
    $sql_kategori = "SELECT id_kategori, kategori FROM kategori";
    $result_kategori = $conn->query($sql_kategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GedeBook | Data Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar"></div>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-100 ml-64">
            <header class="bg-white flex justify-end items-center p-6 gap-4">
                <h3>Administrator</h3><img src="" alt="icon">
            </header>

            <h2 class="text-5xl font-medium px-8 py-6">Data Seri Buku</h2>

            <section class="m-8 grid gap-6 grid-cols-3">
                <!-- FORM INPUT -->
                <div class="bg-white p-5">
                    <h3 class="pb-4 border-b-[3px] text-2xl font-medium text-blue-800">Edit Data</h3>
                    <form class="grid mt-6" action="data-seri-buku-proses.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_seribuku" value="<?= $data_buku['id_seribuku']; ?>">
                        
                        <span class="text-xl">Nama Buku</span>
                        <input type="text" name="nama_buku" value="<?= htmlspecialchars($data_buku['nama_buku']); ?>" class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                        
                        <span class="text-xl">Deskripsi Buku</span>
                        <textarea name="deskripsi_buku" rows="3" class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl"><?= htmlspecialchars($data_buku['deskripsi_buku']); ?></textarea>

                        <div class="flex justify-between">
                            <span class="text-xl">Kategori Buku</span>
                            <button class="py-1 px-3 bg-[#E27C00] text-white rounded-md">Tambah</button>
                        </div>
                        <select name="kategori_buku" class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                            <?php while ($row = $result_kategori->fetch_assoc()): ?>
                                <option value="<?= $row['id_kategori']; ?>" <?= ($row['id_kategori'] == $data_buku['kategori_buku']) ? 'selected' : ''; ?>>
                                    <?= $row['kategori']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <span class="text-xl">Gambar Buku</span>
                        <?php if(!empty($data_buku['gambar_buku'])): ?>
                            <img src="<?= $data_buku['gambar_buku']; ?>" alt="Gambar Buku" class="w-32 mb-2">
                        <?php endif; ?>
                        <input type="file" name="gambar_buku" class="py-2 px-4 text-lg mt-2 mb-6">
                        <input type="hidden" name="gambar_lama" value="<?= $data_buku['gambar_buku']; ?>">
                        
                        <input type="submit" name="update" value="Update" class="py-2 px-4 bg-[#2FC905] rounded-xl text-white font-medium text-lg mt-2 mb-6">
                    </form>
                </div>

                <!-- TABEL -->
                
            </section>
        </main>
    </div>


<script src="jquery.js"></script>
<script src="script.js"></script>
</body>
</html>