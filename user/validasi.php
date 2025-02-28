<?php

require '../koneksi.php'; // koneksi ke database

$errors = [];

// Validasi Step 1
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_instansi = trim($_POST['id_instansi']);
    $id_bidang = trim($_POST['id_bidang']);
    $jenis_pengajuan = trim($_POST['jenis_pengajuan']);
    $tanggal_mulai = trim($_POST['tanggal_mulai']);
    $tanggal_selesai = trim($_POST['tanggal_selesai']);

    if (empty($id_instansi)) {
        $errors['id_instansi'] = 'Instansi harus dipilih.';
    }

    if (empty($id_bidang)) {
        $errors['id_bidang'] = 'Bidang harus dipilih.';
    }
    if (empty($jenis_pengajuan)) {
        $errors['jenis_pengajuan'] = 'Jenis pengajuan harus dipilih.';
    }

    if (empty($tanggal_mulai)) {
        $errors['tanggal_mulai'] = 'Tanggal mulai harus diisi.';
    }

    if (empty($tanggal_selesai)) {
        $errors['tanggal_selesai'] = 'Tanggal selesai harus diisi.';
    }

    if (strtotime($tanggal_mulai) > strtotime($tanggal_selesai)) {
        $errors['tanggal'] = 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai.';
    }

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit();
    }
}

// Validasi Step 2 - Validasi email anggota
if (isset($_POST['anggota_email']) && is_array($_POST['anggota_email'])) {
    $id_pengajuan = isset($_POST['id_pengajuan']) ? intval($_POST['id_pengajuan']) : 0;
    $emails = $_POST['anggota_email'];

    $placeholders = implode(',', array_fill(0, count($emails), '?'));
    $sql = "SELECT email FROM tb_user WHERE email IN ($placeholders) AND id_user NOT IN (SELECT id_user FROM tb_profile_user WHERE id_pengajuan = ?)";

    $stmt = $conn->prepare($sql);
    $params = array_merge($emails, [$id_pengajuan]);
    $stmt->bind_param(str_repeat('s', count($emails)) . 'i', ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $usedEmails = [];
    while ($row = $result->fetch_assoc()) {
        $usedEmails[] = $row['email'];
    }

    if (!empty($usedEmails)) {
        $errors['anggota_email'] = 'Email berikut sudah digunakan: ' . implode(', ', $usedEmails);
    }

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit();
    }
}

echo json_encode(['status' => 'success']);
exit();
?>
