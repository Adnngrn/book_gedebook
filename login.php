<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_email = trim($_POST['email']);
    $input_password = trim($_POST['password']);

    if (empty($input_email) || empty($input_password)) {
        echo json_encode(['success' => false, 'message' => 'email dan password tidak boleh kosong!']);
        exit;
    }

    // Ambil password dan role user dari database
    $stmt = $conn->prepare("SELECT users.password, role.role 
                            FROM users 
                            LEFT JOIN role ON users.role = role.id_role
                            WHERE users.email = ?");
    $stmt->bind_param("s", $input_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind hasil query ke variabel
        $stmt->bind_result($stored_password, $role);
        $stmt->fetch();

        // Verifikasi password
        if ($input_password === $stored_password) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['email'] = $input_email;
            $_SESSION['role'] = $role; // Simpan role ke session

            echo json_encode(['success' => true, 'message' => 'Login berhasil!', 'role' => $role]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Password salah!']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'email tidak ditemukan!']);
        exit;
    }

    $stmt->close();
}
$conn->close();
?>
