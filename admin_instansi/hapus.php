<?php 
include "../layout/header.php";

// $id_pembimbing = $_GET["id"];
$id = $_GET["id"];
$type = $_GET["type"];

$success = false;

if ($type == "pembimbing") {
    $success = hapus_pembimbing($id, $id_user);
    $redirect = "daftar_pembimbing.php";
} else if ($type == "bidang") {
    $success = hapus_bidang($id, $id_user);
    $redirect = "view_bidang.php";
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Data gagal dihapus!',
            confirmButtonText: 'OK'
        });
    </script>";
    exit;
}

if ($success) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil dihapus!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '$redirect'; // redirect ke halaman yang diinginkan
            }
        });
    </script>";
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Data gagal dihapus!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '$redirect'; // redirect ke halaman yang diinginkan
            }
        });
    </script>";
}
?>