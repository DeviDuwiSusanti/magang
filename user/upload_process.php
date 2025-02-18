<?php
include "../layout/sidebarUser.php"; 
include '../koneksi.php'; // Pastikan koneksi sudah diimport

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data file dan jenis dokumen
    $id_user = $_SESSION['id_user'];  // ID user dari session
    $file = $_FILES['persyaratan'];  // File yang diupload
    $jenis_dokumen = $_POST['jenis_dokumen'];  // Jenis dokumen dari form

    // Proses setiap file yang diupload
    $uploadSuccess = false;
    foreach ($file['name'] as $key => $file_name) {
        $file_name = pathinfo($file_name, PATHINFO_FILENAME);  // Ambil nama file tanpa ekstensi
        $file_extension = pathinfo($file['name'][$key], PATHINFO_EXTENSION);  // Ekstensi file
        $file_name = $file_name . '_' . uniqid();  // Nama unik untuk file
        $file_path = 'uploads/' . $file_name . '.' . $file_extension;  // Path file

        // Membuat direktori jika belum ada
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Unggah file ke server
        if (move_uploaded_file($file['tmp_name'][$key], $file_path)) {
            // Simpan data file ke database
            $sql = "INSERT INTO tb_dokumen (nama_dokumen, jenis_dokumen, file_path, id_user, create_date) 
                    VALUES ('$file_name', '$jenis_dokumen[$key]', '$file_path', '$id_user', NOW())";

            if (mysqli_query($conn, $sql)) {
                $uploadSuccess = true;
            }
        }
    }

    // Setelah file berhasil diupload, tampilkan alert
    if ($uploadSuccess) {
        echo "<script>
                alert('Persyaratan berhasil diunggah!');
                window.location.href='persyaratan_daftar.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengunggah persyaratan.');
              </script>";
    }
}
?>