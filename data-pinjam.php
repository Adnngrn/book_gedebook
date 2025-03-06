<?php
include 'koneksi.php';

$sql_peminjam = "SELECT id_peminjam, nama_peminjam, kelas FROM peminjam";
$result_peminjam = $conn->query($sql_peminjam);

$sql_buku = "SELECT id_buku, no_buku, seri_buku FROM buku";
$result_buku = $conn->query($sql_buku);

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

            <h2 class="text-5xl font-medium px-8 py-6">Data Pinjam</h2>

            <section class="m-8 grid gap-6 grid-cols-3">
                <!-- FORM INPUT -->
                <div class="bg-white p-5">
                    <h3 class="pb-4 border-b-[3px] text-2xl font-medium text-blue-800">Tambah Data</h3>
                    <form class="grid mt-6" action="">
                        <span class="text-xl">Nama Peminjam</span>
                        <select name="peminjam" id="peminjam" required 
                                class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                            <option value="">Peminjam</option>
                            <?php while($row = $result_peminjam->fetch_assoc()): ?>
                                <option value="<?= $row['id_peminjam'] ?>"> <?= $row['nama_peminjam'] ?> /<?= $row['kelas'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        
                        <span class="text-xl">Buku</span>
                        <select name="peminjam" id="peminjam" required 
                                class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                            <option value="">Buku</option>
                            <?php while($row = $result_buku->fetch_assoc()): ?>
                                <option value="<?= $row['id_buku'] ?> "> <?= $row['id_buku'] ?> /<?= $row['no_buku'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        
                        <div class="grid grid-cols-2">
                            <div>
                                <span class="text-lg">Tanggal Pinjam</span>
                                <input type="date" name="" id="" class="py-1 px-2 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                            </div>
                            <div>
                                <span class="text-lg">Tanggal Pinjam</span>
                                <input type="date" name="" id="" class="py-1 px-2 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="" id=""><span> Data sudah benar?</span>
                        </div>
                        <input type="submit" name="" id="" class="py-2 px-4 bg-[#2FC905] rounded-xl text-white font-medium text-lg mt-2 mb-6 ">
                    </form>
                </div>

                <!-- TABEL -->
                <div class="bg-white p-5 col-span-2">
                    <h3 class="pb-4 border-b-[3px] text-2xl font-medium text-blue-800">Daftar Buku</h3>
                        <!-- SEARCH -->
                    <form action="" class="flex items-center justify-end py-6 gap-4">
                        <span class="text-xl">Search :</span>
                        <input type="text" name="" id="" class="py-1 px-2 text-lg border-2 border-gray-400 rounded-2xl">
                    </form>

                    <table class="w-full text-xl">
                        <thead>
                            <tr>
                                <td>No.</td>
                                <td>Nama Buku</td>
                                <td>Nama Peminjam</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Harry Potah : Ars King / #0001</td>
                                <td>Fahmi'un Nur Rizki / XII-RPL</td>
                                <td>
                                    <input type="submit" value="Edit" name="" id="" class="bg-yellow-400 py-1 px-3 rounded-lg">
                                    <input type="submit" value="Hapus" name="" id="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

<script src="jquery.js"></script>
<script src="script.js"></script>
</body>
</html>