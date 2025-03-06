<?php
    include 'koneksi.php';

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
                    <h3 class="pb-4 border-b-[3px] text-2xl font-medium text-blue-800" id="formTitle">Tambah Data</h3>
                    <form class="grid mt-6" id="bukuForm" method="POST" enctype="multipart/form-data">
                        <!-- Hidden input untuk id saat edit -->
                        <input type="hidden" name="id_seribuku" id="id_seribuku">
                        
                        <span class="text-xl">Nama Buku</span>
                        <input type="text" name="nama_buku" id="nama_buku" required 
                               class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                        
                        <span class="text-xl">Deskripsi Buku</span>
                        <textarea name="deskripsi_buku" id="deskripsi_buku" rows="3" required
                                  class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl"></textarea>

                        <div class="flex justify-between">
                            <span class="text-xl">Kategori Buku</span>
                            <button type="button" class="py-1 px-3 bg-[#E27C00] text-white rounded-md">Tambah</button>
                        </div>
                        <select name="kategori_buku" id="kategori_buku" required 
                                class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                            <?php 
                            while ($row = $result_kategori->fetch_assoc()): 
                            ?>
                                <option value="<?= $row['id_kategori']; ?>"><?= $row['kategori']; ?></option>
                            <?php endwhile; ?>
                        </select>

                        <span class="text-xl">Gambar Buku</span>
                        <div id="preview_gambar" class="mb-2"></div>
                        <input type="file" name="gambar_buku" id="gambar_buku" accept="image/*"
                               class="py-2 px-4 text-lg mt-2 mb-6">
                        <input type="hidden" name="gambar_lama" id="gambar_lama">
                        
                        <input type="submit" id="submitBtn" name="action" value="Tambah" 
                               class="py-2 px-4 bg-[#2FC905] rounded-xl text-white font-medium text-lg mt-2 mb-6">
                    </form>
                </div>

                <!-- TABEL -->
                <div class="bg-white p-5 col-span-2">
                    <h3 class="pb-4 border-b-[3px] text-2xl font-medium text-blue-800">Daftar Buku</h3>
                        <!-- SEARCH -->
                    <form action="" class="flex items-center justify-end py-6 gap-4">
                        <span class="text-xl">Nama Buku :</span>
                        <input type="text" name="" id="" class="py-1 px-2 text-lg border-2 border-gray-400 rounded-2xl">
                    </form>

                    <?php

                    // Ambil data dari tabel seri_buku
                    $sql = "SELECT s.id_seribuku, s.nama_buku, k.kategori 
                            FROM seri_buku s
                            JOIN kategori k ON s.kategori_buku = k.id_kategori";
                    $result = $conn->query($sql);
                    ?>

                    <table class="w-full text-xl border-collapse border border-gray-400 mt-6">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-400 px-4 py-2">No.</th>
                                <th class="border border-gray-400 px-4 py-2">Nama Buku</th>
                                <th class="border border-gray-400 px-4 py-2">Kategori Buku</th>
                                <th class="border border-gray-400 px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result->fetch_assoc()):
                            ?>
                            <tr class="text-center">
                                <td class="border border-gray-400 px-4 py-2"><?= $no++; ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?= htmlspecialchars($row['nama_buku']); ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?= htmlspecialchars($row['kategori']); ?></td>
                                <td class="border border-gray-400 px-4 py-2">
                                    <button onclick="editBuku(<?= $row['id_seribuku']; ?>)" class="bg-yellow-400 py-1 px-3 rounded-lg">Edit</button>
                                    <a href="detail.php?id=<?= $row['id_seribuku']; ?>" class="bg-blue-400 py-1 px-3 rounded-lg text-white">Detail</a>
                                    <form action="data-seri-buku-proses.php" method="post" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <input type="hidden" name="id_seribuku" value="<?= $row['id_seribuku']; ?>">
                                        <button type="submit" name="delete" class="bg-red-400 py-1 px-3 rounded-lg text-white">Hapus</button>
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
        const isEdit = $('#id_seribuku').val() !== '';
        formData.set('action', isEdit ? 'update' : 'create');
        
        $.ajax({
            url: 'data-seri-buku-proses.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status === 'success') {
                    alert(response.message);
                    // Reset form
                    resetForm();
                    // Refresh tabel
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

    // Function untuk reset form
    function resetForm() {
        $('#bukuForm')[0].reset();
        $('#id_seribuku').val('');
        $('#preview_gambar').empty();
        $('#gambar_lama').val('');
        $('#formTitle').text('Tambah Data');
        $('#submitBtn').val('Tambah');
    }

    // Preview gambar saat file dipilih
    $('#gambar_buku').on('change', function() {
        const file = this.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_gambar').html(`<img src="${e.target.result}" class="w-32">`);
            }
            reader.readAsDataURL(file);
        }
    });
});

// Function untuk edit buku
function editBuku(id) {
    $.ajax({
        url: 'data-seri-buku-proses.php',
        type: 'GET',
        data: { action: 'get', id: id },
        success: function(response) {
            if(response.status === 'success') {
                const data = response.data;
                $('#id_seribuku').val(data.id_seribuku);
                $('#nama_buku').val(data.nama_buku);
                $('#deskripsi_buku').val(data.deskripsi_buku);
                $('#kategori_buku').val(data.kategori_buku);
                $('#gambar_lama').val(data.gambar_buku);
                
                if(data.gambar_buku) {
                    $('#preview_gambar').html(`<img src="uploads/${data.gambar_buku}" class="w-32">`);
                }
                
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