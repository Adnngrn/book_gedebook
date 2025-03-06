<?php
include 'koneksi.php';

header('Content-Type: application/json');

// GET (Ambil data untuk edit)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get') {
    try {
        $id = $_GET['id'];
        $sql = "SELECT * FROM peminjam WHERE id_peminjam = ?";
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
        if(empty($_POST['nama_peminjam']) || empty($_POST['kelas']) || empty($_POST['nisn'])) {
            throw new Exception("Semua field harus diisi");
        }

        $nama_peminjam = $_POST['nama_peminjam'];
        $kelas = $_POST['kelas'];
        $nisn = strval($_POST['nisn']);

        // Validasi format NISN
        if (!preg_match("/^\d{8,20}$/", $nisn)) {
            throw new Exception("NISN harus berupa angka dengan panjang 8-20 digit");
        }

        // Cek apakah NISN sudah ada
        $check_sql = "SELECT id_peminjam FROM peminjam WHERE nisn = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $nisn);
        $check_stmt->execute();
        if($check_stmt->get_result()->num_rows > 0) {
            throw new Exception("NISN sudah terdaftar");
        }

        // Insert data baru
        $sql = "INSERT INTO peminjam (nama_peminjam, kelas, nisn) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nama_peminjam, $kelas, $nisn);

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
        if(empty($_POST['id_peminjam']) || empty($_POST['nama_peminjam']) || 
           empty($_POST['kelas']) || empty($_POST['nisn'])) {
            throw new Exception("Semua field harus diisi");
        }

        $id_peminjam = $_POST['id_peminjam'];
        $nama_peminjam = $_POST['nama_peminjam'];
        $kelas = $_POST['kelas'];
        $nisn = $_POST['nisn'];

        // Validasi format NISN
        if (!preg_match("/^\d{8,20}$/", $nisn)) {
            throw new Exception("NISN harus berupa angka dengan panjang 8-20 digit");
        }

        // Cek duplikasi NISN kecuali untuk ID yang sama
        $check_sql = "SELECT id_peminjam FROM peminjam WHERE nisn = ? AND id_peminjam != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $nisn, $id_peminjam);
        $check_stmt->execute();
        if($check_stmt->get_result()->num_rows > 0) {
            throw new Exception("NISN sudah terdaftar");
        }

        // Update data
        $sql = "UPDATE peminjam SET nama_peminjam = ?, kelas = ?, nisn = ? WHERE id_peminjam = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nama_peminjam, $kelas, $nisn, $id_peminjam);

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
        $id_peminjam = $_POST['id_peminjam'];
        
        $sql = "DELETE FROM peminjam WHERE id_peminjam = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_peminjam);
        
        if (!$stmt->execute()) {
            throw new Exception("Gagal menghapus data");
        }
        
        header("Location: data-peminjam.php");
        exit;
    } catch (Exception $e) {
        echo "<script>alert('Gagal menghapus data: " . $e->getMessage() . "'); 
              window.location.href='data-peminjam.php';</script>";
        exit;
    }
}
?> 