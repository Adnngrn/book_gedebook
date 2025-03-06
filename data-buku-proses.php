<?php
include 'koneksi.php';

header('Content-Type: application/json');

// GET (Ambil data untuk edit)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get') {
    try {
        $id = $_GET['id'];
        $sql = "SELECT * FROM buku WHERE id_buku = ?";
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
        // Validasi input
        if(empty($_POST['no_buku']) || empty($_POST['seri_buku'])) {
            throw new Exception("Semua field harus diisi");
        }

        $no_buku = $_POST['no_buku'];
        $seri_buku = $_POST['seri_buku'];

        // Cek apakah nomor buku sudah ada
        $check_sql = "SELECT id_buku FROM buku WHERE no_buku = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $no_buku);
        $check_stmt->execute();
        if($check_stmt->get_result()->num_rows > 0) {
            throw new Exception("Nomor buku sudah ada");
        }

        // Insert data baru
        $sql = "INSERT INTO buku (no_buku, seri_buku) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $no_buku, $seri_buku);

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
        if(empty($_POST['id_buku']) || empty($_POST['no_buku']) || empty($_POST['seri_buku'])) {
            throw new Exception("Semua field harus diisi");
        }

        $id_buku = $_POST['id_buku'];
        $no_buku = $_POST['no_buku'];
        $seri_buku = $_POST['seri_buku'];

        // Cek duplikasi nomor buku kecuali untuk ID yang sama
        $check_sql = "SELECT id_buku FROM buku WHERE no_buku = ? AND id_buku != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $no_buku, $id_buku);
        $check_stmt->execute();
        if($check_stmt->get_result()->num_rows > 0) {
            throw new Exception("Nomor buku sudah ada");
        }

        // Update data
        $sql = "UPDATE buku SET no_buku = ?, seri_buku = ? WHERE id_buku = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $no_buku, $seri_buku, $id_buku);

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
        $id_buku = $_POST['id_buku'];
        
        $sql = "DELETE FROM buku WHERE id_buku = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_buku);
        
        if (!$stmt->execute()) {
            throw new Exception("Gagal menghapus data");
        }
        
        header("Location: data-buku.php");
        exit;
    } catch (Exception $e) {
        echo "<script>alert('Gagal menghapus data: " . $e->getMessage() . "'); 
              window.location.href='data-buku.php';</script>";
        exit;
    }
}
?> 