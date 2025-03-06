<?php
include 'koneksi.php';

$sql_kelas = "SELECT id_kelas, kelas FROM kelas";
$result_kelas = $conn->query($sql_kelas);
// Query untuk tabel peminjam
$sql_peminjam = "SELECT * FROM peminjam ORDER BY id_peminjam DESC";
$result_peminjam = $conn->query($sql_peminjam);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GedeBook | Data Peminjam</title>
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

            <h2 class="text-5xl font-medium px-8 py-6">Data Peminjam</h2>

            <section class="m-8 grid gap-6 grid-cols-3">
                <!-- FORM INPUT -->
                <div class="bg-white p-5">
                    <h3 class="pb-4 border-b-[3px] text-2xl font-medium text-blue-800" id="formTitle">Tambah Data</h3>
                    <form class="grid mt-6" id="peminjamForm" method="POST">
                        <input type="hidden" name="id_peminjam" id="id_peminjam">
                        
                        <span class="text-xl">Nama Siswa</span>
                        <input type="text" name="nama_peminjam" id="nama_peminjam" required 
                               class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                        
                        <span class="text-xl">Kelas</span>
                        <select name="kelas" id="kelas" required 
                                class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">
                            <option value="">Pilih Kelas</option>
                            <?php while($row = $result_kelas->fetch_assoc()): ?>
                                <option value="<?= $row['id_kelas'] ?>"><?= $row['kelas'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        
                        <span class="text-xl">NISN</span>
                        <input type="text" name="nisn" id="nisn" required 
                               pattern="[0-9]{8,20}" 
                               title="NISN harus berupa angka dengan panjang 8-20 digit"
                               class="py-2 px-4 text-lg mt-2 mb-6 border-2 border-gray-400 rounded-2xl">

                        <input type="submit" id="submitBtn" value="Tambah" 
                               class="py-2 px-4 bg-[#2FC905] rounded-xl text-white font-medium text-lg mt-2 mb-6">
                    </form>
                </div>

                <!-- TABEL -->
                <div class="bg-white p-5 col-span-2">
                    <h3 class="pb-4 border-b-[3px] text-2xl font-medium text-blue-800">Daftar Peminjam</h3>
                    
                    <!-- SEARCH -->
                    <form action="" class="flex items-center justify-end py-6 gap-4">
                        <span class="text-xl">Nama Peminjam :</span>
                        <input type="text" id="searchInput" class="py-1 px-2 text-lg border-2 border-gray-400 rounded-2xl">
                    </form>

                    <table class="w-full text-xl">
                        <thead>
                            <tr class="text-center">
                                <td class="border border-gray-400 px-4 py-2">No.</td>
                                <td class="border border-gray-400 px-4 py-2">Nama Peminjam</td>
                                <td class="border border-gray-400 px-4 py-2">Kelas</td>
                                <td class="border border-gray-400 px-4 py-2">NISN</td>
                                <td class="border border-gray-400 px-4 py-2">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while($row = $result_peminjam->fetch_assoc()): 
                            ?>
                            <tr class="text-center">
                                <td class="border border-gray-400 px-4 py-2"><?= $no++ ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?= $row['nama_peminjam'] ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?= $row['kelas'] ?></td>
                                <td class="border border-gray-400 px-4 py-2"><?= $row['nisn'] ?></td>
                                <td class="border border-gray-400 px-4 py-2">
                                    <button type="button" onclick="editPeminjam(<?= $row['id_peminjam'] ?>)" 
                                            class="bg-yellow-400 py-1 px-3 rounded-lg">Edit</button>
                                    <form action="data-peminjam-proses.php" method="post" style="display: inline;" 
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <input type="hidden" name="id_peminjam" value="<?= $row['id_peminjam'] ?>">
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
    $('#peminjamForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const isEdit = $('#id_peminjam').val() !== '';
        formData.append('action', isEdit ? 'update' : 'create');
        
        $.ajax({
            url: 'data-peminjam-proses.php',
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
        $('#peminjamForm')[0].reset();
        $('#id_peminjam').val('');
        $('#formTitle').text('Tambah Data');
        $('#submitBtn').val('Tambah');
    }
});

// Function untuk edit peminjam
function editPeminjam(id) {
    $.ajax({
        url: 'data-peminjam-proses.php',
        type: 'GET',
        data: { action: 'get', id: id },
        success: function(response) {
            if(response.status === 'success') {
                const data = response.data;
                $('#id_peminjam').val(data.id_peminjam);
                $('#nama_peminjam').val(data.nama_peminjam);
                $('#kelas').val(data.kelas);
                $('#nisn').val(data.nisn);
                
                $('#formTitle').text('Edit Data');
                $('#submitBtn').val('Update');
                
                // Scroll ke form
                $('html, body').animate({
                    scrollTop: $("#peminjamForm").offset().top - 100
                }, 500);
            }
        }
    });
}
</script>
</body>
</html>