<?php
include 'koneksi.php';

// Query untuk mengambil data seri buku
$sql_seri = "SELECT id_seribuku, nama_buku FROM seri_buku";
$result_seri = $conn->query($sql_seri);

// Query untuk tabel buku
$sql_buku = "SELECT b.id_buku, b.no_buku, s.nama_buku 
             FROM buku b 
             JOIN seri_buku s ON b.seri_buku = s.id_seribuku";
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

            <h2 class="text-5xl font-medium px-8 py-6">Data Book</h2>

            <section class="m-8 grid gap-6 grid-cols-3">
                <!-- FORM INPUT -->
                <div class="bg-white p-5">
                    <h3 class="pb-4 border-b-[3px] text-2xl font-medium text-blue-800" id="formTitle">Tambah Data</h3>
                    <form class="grid mt-6" id="bukuForm" method="POST">
                        <input type="hidden" name="id_buku" id="id_buku">
                        
                        <span class="text-xl">Nomor Buku</span>
                        <input type="text" name="no_buku" id="no_buku" required 
                               class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                        
                        <span class="text-xl">Seri Buku</span>
                        <select name="seri_buku" id="seri_buku" required 
                                class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                            <option value="">Pilih Seri Buku</option>
                            <?php while($row = $result_seri->fetch_assoc()): ?>
                                <option value="<?= $row['id_seribuku'] ?>"><?= $row['nama_buku'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        
                        <input type="submit" id="submitBtn" value="Tambah" 
                               class="py-2 px-4 bg-[#2FC905] rounded-xl text-white font-medium text-lg mt-2 mb-6">
                    </form>
                </div>

                <!-- TABEL -->
                <div class="bg-white p-5 col-span-2">
                    <h3 class="pb-4 border-b-[3px] text-2xl font-medium text-blue-800">Daftar Buku</h3>
                    
                    <!-- SEARCH -->
                    <form action="" class="flex items-center justify-end py-6 gap-4">
                        <span class="text-xl">Nama Buku :</span>
                        <input type="text" id="searchInput" class="py-1 px-2 text-lg border-2 border-gray-400 rounded-2xl">
                    </form>

                    <table class="w-full text-xl">
                        <thead>
                            <tr class="text-center">
                                <td class="border border-gray-400 px-4 py-2">No.</td>
                                <td class="border border-gray-400 px-4 py-2">Nomor Buku</td>
                                <td class="border border-gray-400 px-4 py-2">Nama Buku</td>
                                <td class="border border-gray-400 px-4 py-2">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while($row = $result_buku->fetch_assoc()): 
                            ?>
                            <tr class="text-center">
                                <td class="border border-gray-400 px-4 py-2"><?= $no++ ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?= $row['no_buku'] ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?= $row['nama_buku'] ?></td>
                                <td class="border border-gray-400 px-4 py-2">
                                    <button type="button" onclick="editBuku(<?= $row['id_buku'] ?>)" 
                                            class="bg-yellow-400 py-1 px-3 rounded-lg">Edit</button>
                                    <form action="data-buku-proses.php" method="post" style="display: inline;" 
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <input type="hidden" name="id_buku" value="<?= $row['id_buku'] ?>">
                                        <button type="submit" name="delete" 
                                                class="bg-red-400 py-1 px-3 rounded-lg text-white">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

<script src="jquery.js"></script>
<script src="script.js"></script>

<script>
$(document).ready(function() {
    // Handle form submit
    $('#bukuForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const isEdit = $('#id_buku').val() !== '';
        formData.append('action', isEdit ? 'update' : 'create');
        
        $.ajax({
            url: 'data-buku-proses.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status === 'success') {
                    alert(response.message);
                    resetForm();
                    location.reload();
                } else {
                    alert(response.message || 'Terjadi kesalahan');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada server');
            }
        });
    });

    // Reset form
    function resetForm() {
        $('#bukuForm')[0].reset();
        $('#id_buku').val('');
        $('#formTitle').text('Tambah Data');
        $('#submitBtn').val('Tambah');
    }
});

// Function untuk edit buku
function editBuku(id) {
    $.ajax({
        url: 'data-buku-proses.php',
        type: 'GET',
        data: { action: 'get', id: id },
        success: function(response) {
            if(response.status === 'success') {
                const data = response.data;
                $('#id_buku').val(data.id_buku);
                $('#no_buku').val(data.no_buku);
                $('#seri_buku').val(data.seri_buku);
                
                $('#formTitle').text('Edit Data');
                $('#submitBtn').val('Update');
                
                // Scroll ke form
                $('html, body').animate({
                    scrollTop: $("#bukuForm").offset().top - 100
                }, 500);
            }
        }
    });
}
</script>
</body>
</html>