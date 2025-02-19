<?php 
include "../layout/header.php";

$id_pembimbing = $_GET["id"];

if (hapus_pembimbing($id_pembimbing, $id_user)) {
    // Jika penghapusan berhasil, keluarkan script SweetAlert
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data pembimbing berhasil dihapus!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'daftar_pembimbing.php'; // redirect ke halaman yang diinginkan
            }
        });
    </script>";
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Data pembimbing gagal dihapus!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'daftar_pembimbing.php'; // redirect ke halaman yang diinginkan
            }
        });
    </script>";
}
?>
