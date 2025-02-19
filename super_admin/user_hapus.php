<?php 
    include "sidebar.php";
    $id_user_ini = $_GET["id_user"];

    if(Super_admin_hapus_user($id_user_ini, $id_user)) {
        echo "<script>
            alert ('Berhasil Hapus Data User');
            document.location.href = 'user_view.php';
        </script>";
    } else {
        echo "<script>
            alert ('Gagal Hapus Data User');
            document.location.href = 'user_view.php';
        </script>";
    }

?>