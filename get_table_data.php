<?php
include 'koneksi.php';

$sql = "SELECT s.id_seribuku, s.nama_buku, s.deskripsi_buku, s.gambar_buku, s.kategori_buku, k.kategori 
        FROM seri_buku s
        JOIN kategori k ON s.kategori_buku = k.id_kategori";
$result = $conn->query($sql);

$no = 1;
while ($row = $result->fetch_assoc()):
?>
<tr class="text-center">
    <td class="border border-gray-400 px-4 py-2"><?= $no++; ?></td>
    <td class="border border-gray-400 px-4 py-2"><?= htmlspecialchars($row['nama_buku']); ?></td>
    <td class="border border-gray-400 px-4 py-2"><?= htmlspecialchars($row['kategori']); ?></td>
    <td class="border border-gray-400 px-4 py-2">
        <button type="button" class="edit-btn bg-yellow-400 py-1 px-3 rounded-lg" 
                data-id="<?= $row['id_seribuku']; ?>"
                data-nama="<?= htmlspecialchars($row['nama_buku']); ?>"
                data-deskripsi="<?= htmlspecialchars($row['deskripsi_buku']); ?>"
                data-kategori="<?= $row['kategori_buku']; ?>"
                data-gambar="<?= $row['gambar_buku']; ?>">
            Edit
        </button>
        <a href="detail.php?id=<?= $row['id_seribuku']; ?>" class="bg-blue-400 py-1 px-3 rounded-lg text-white">Detail</a>
        <form action="data-seri-buku-proses.php" method="post" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
            <input type="hidden" name="id_seribuku" value="<?= $row['id_seribuku']; ?>">
            <button type="submit" name="delete" class="bg-red-400 py-1 px-3 rounded-lg text-white">Hapus</button>
        </form>
    </td>
</tr>
<?php endwhile; ?> 