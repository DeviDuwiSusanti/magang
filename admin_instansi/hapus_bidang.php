<?php 
include "../layout/header.php";

$id_bidang = $_GET["id_bidang"];

if (hapus_bidang($id_bidang, $id_user)) {
    // Jika penghapusan berhasil, keluarkan script SweetAlert
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data bidang berhasil dihapus!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'view_bidang.php'; // redirect ke halaman yang diinginkan
            }
        });
    </script>";
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Data bidang gagal dihapus!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'view_bidang.php'; // redirect ke halaman yang diinginkan
            }
        });
    </script>";
}
?>
