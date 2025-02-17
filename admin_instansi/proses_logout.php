<?php
include "../layout/header.php";
// session_start();
session_destroy(); // Hapus semua sesi
echo "<script>
    Swal.fire({
        title: 'Logout Berhasil!',
        text: 'Anda telah keluar dari sistem.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = '../login.php';
    });
</script>";
?>
