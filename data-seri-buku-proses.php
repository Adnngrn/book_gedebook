<?php
// Pastikan tidak ada output atau whitespace sebelum <?php
include 'koneksi.php';

// Set header JSON di awal
header('Content-Type: application/json');

// GET (Ambil data untuk edit)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get') {
    try {
        $id = $_GET['id'];
        $sql = "SELECT * FROM seri_buku WHERE id_seribuku = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        } else {
            throw new Exception("Data tidak ditemukan");
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

// CREATE (Tambah Data)
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    try {
        $nama_buku = $_POST['nama_buku'];
        $deskripsi_buku = $_POST['deskripsi_buku'];
        $kategori_buku = $_POST['kategori_buku'];
        
        // Handle upload gambar
        $gambar_buku = '';
        if (!empty($_FILES['gambar_buku']['name'])) {
            $upload_dir = "uploads/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $gambar_buku = time() . '_' . $_FILES['gambar_buku']['name'];
            if (!move_uploaded_file($_FILES['gambar_buku']['tmp_name'], $upload_dir . $gambar_buku)) {
                throw new Exception("Gagal mengupload gambar");
            }
        }

        $sql = "INSERT INTO seri_buku (nama_buku, deskripsi_buku, kategori_buku, gambar_buku) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $nama_buku, $deskripsi_buku, $kategori_buku, $gambar_buku);

        if (!$stmt->execute()) {
            throw new Exception("Gagal menyimpan data: " . $stmt->error);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

// UPDATE (Edit Data)
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    try {
        $id_seribuku = $_POST['id_seribuku'];
        $nama_buku = $_POST['nama_buku'];
        $deskripsi_buku = $_POST['deskripsi_buku'];
        $kategori_buku = $_POST['kategori_buku'];
        
        // Handle upload gambar baru jika ada
        if (!empty($_FILES['gambar_buku']['name'])) {
            $upload_dir = "uploads/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $gambar_buku = time() . '_' . $_FILES['gambar_buku']['name'];
            if (!move_uploaded_file($_FILES['gambar_buku']['tmp_name'], $upload_dir . $gambar_buku)) {
                throw new Exception("Gagal mengupload gambar");
            }
            
            // Update dengan gambar baru
            $sql = "UPDATE seri_buku SET nama_buku=?, deskripsi_buku=?, kategori_buku=?, gambar_buku=? 
                    WHERE id_seribuku=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisi", $nama_buku, $deskripsi_buku, $kategori_buku, $gambar_buku, $id_seribuku);
        } else {
            // Update tanpa gambar
            $sql = "UPDATE seri_buku SET nama_buku=?, deskripsi_buku=?, kategori_buku=? 
                    WHERE id_seribuku=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $nama_buku, $deskripsi_buku, $kategori_buku, $id_seribuku);
        }

        if (!$stmt->execute()) {
            throw new Exception("Gagal mengupdate data: " . $stmt->error);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Data berhasil diupdate'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

// DELETE (Hapus Data)
if (isset($_POST['delete'])) {
    try {
        $id_seribuku = $_POST['id_seribuku'];
        
        // Ambil nama file gambar sebelum menghapus data
        $sql = "SELECT gambar_buku FROM seri_buku WHERE id_seribuku = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_seribuku);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        // Hapus data dari database
        $sql = "DELETE FROM seri_buku WHERE id_seribuku = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_seribuku);
        
        if (!$stmt->execute()) {
            throw new Exception("Gagal menghapus data");
        }
        
        // Hapus file gambar jika ada
        if (!empty($data['gambar_buku'])) {
            $file_path = "uploads/" . $data['gambar_buku'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        header("Location: data-seri-buku.php");
        exit;
    } catch (Exception $e) {
        echo "<script>alert('Gagal menghapus data: " . $e->getMessage() . "'); 
              window.location.href='data-seri-buku.php';</script>";
        exit;
    }
}
?>
