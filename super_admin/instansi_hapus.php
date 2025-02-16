<?php 
    include "sidebar.php";
    $id_instansi = $_GET["id_instansi"];

    if(hapus_instansi($id_instansi, $id_user)) {
        echo "<script>
            alert ('Berhasil Hapus Data Instansi');
            document.location.href = 'instansi_view.php';
        </script>";
    } else {
        echo "<script>
            alert ('Gagal Hapus Data Instansi');
            document.location.href = 'instansi_view.php';
        </script>";
    }

?>