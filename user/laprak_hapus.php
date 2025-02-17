<?php
include '../koneksi.php';  // Pastikan koneksi ke database sudah benar

// Cek apakah id_dokumen ada dalam query string
if (isset($_GET['id_dokumen'])) {
    $id_dokumen = $_GET['id_dokumen'];

    // Query untuk menghapus dokumen berdasarkan id_dokumen
    $sql = "DELETE FROM tb_dokumen WHERE id_dokumen = '$id_dokumen'";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, alihkan ke halaman daftar laporan
        echo "<script>alert('Laporan berhasil dihapus!'); window.location.href='laprak_daftar.php';</script>";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<script>alert('Gagal menghapus laporan.'); window.location.href='laprak_daftar.php';</script>";
    }
} else {
    // Jika tidak ada id_dokumen yang diterima
    echo "<script>alert('ID dokumen tidak ditemukan.'); window.location.href='laprak_daftar.php';</script>";
}
?>