<?php
include "../koneksi.php";

// Endpoint untuk mengambil data pembimbing berdasarkan pengajuan_id
if (isset($_GET['pengajuan_id'])) {
    $pengajuan_id = $_GET['pengajuan_id'];

    // Query untuk mengambil data pembimbing berdasarkan bidang yang diajukan
    $query = "SELECT u.id_user, pu.nama_user 
              FROM tb_user u
              JOIN tb_profile_user pu ON u.id_user = pu.id_user
              JOIN tb_pengajuan p ON pu.id_bidang = p.id_bidang
              WHERE u.level = 5 AND p.id_pengajuan = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $pengajuan_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Siapkan array untuk menyimpan data pembimbing
        $pembimbing = [];
        while ($row = $result->fetch_assoc()) {
            $pembimbing[] = $row;
        }

        // Keluarkan data dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($pembimbing);

        // Tutup statement
        $stmt->close();
    } else {
        // Jika query gagal
        header('Content-Type: application/json');
        echo json_encode(["error" => "Query preparation failed"]);
    }
} else {
    // Jika pengajuan_id tidak ada
    header('Content-Type: application/json');
    echo json_encode(["error" => "pengajuan_id is required"]);
}

// Tutup koneksi
$conn->close();
?>