<?php include "../layout/sidebarUser.php";
include "functions.php"; 

if (ISSET($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
};

$no = 1;

// akses status_pengajuan
$sql3 = "SELECT status_pengajuan FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
$query3 = mysqli_query($conn, $sql3);
$status_pengajuan = mysqli_fetch_assoc($query3)['status_pengajuan'];

// akses anggota
$sql_anggota = "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_pengajuan = '$id_pengajuan' AND u.level = '4' AND pu.id_user = u.id_user";
$query_anggota = mysqli_query($conn, $sql_anggota);

// HAPUS LOGBOOK
if (isset($_GET['id_logbook'])) {
    $id_logbook = $_GET['id_logbook'];
    $sql2 =  "DELETE FROM tb_logbook WHERE id_logbook = '$id_logbook' AND id_pengajuan = '$id_pengajuan' AND id_user = '$id_user'";
    $query2 = mysqli_query($conn, $sql2);
    if ($query2) {
        showAlert('Berhasil!', 'Logbook Berhasil Dihapus', 'success', "logbook_daftar.php");
        exit();
    } else {
        showAlert('Gagal!', 'Logbook gagal dihapus. Silakan coba lagi.', 'error');
    }    
}

?>
<!-- TABEL DAFTAR LOGBOOK -->
<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Logbook</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Logbook Harian</li>
        </ol>

        <div class="dropdown">
            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
            Logbook Anggota
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?id_user_anggota=<?= $id_user ?>#logbook_container">Anda</a></li>
                <?php
                while ($row_anggota = mysqli_fetch_assoc($query_anggota)){?>
                    <li><a class="dropdown-item" href="?id_user_anggota=<?= $row_anggota['id_user'] ?>#logbook_container"><?= $row_anggota['nama_user'] ?></a></li>
                <?php
                }
                ?>
            </ul>
        </div>
        
        <div class="mb-4 dropdown-divider"></div>
        
        <div class="mb-4 text-end" id="logbook_container">
            <?php
            $id_user_anggota = isset($_GET['id_user_anggota']) ? $_GET['id_user_anggota'] : $id_user; 
                if ($status_pengajuan != '5' && $id_user_anggota == $id_user){
                    ?>
                    <a href="logbook_input.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Logbook
                    </a>
                <?php          
                }
                ?>

            <a href="logbook_print.php?id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-success">
                <i class="bi bi-printer me-1"></i>
                Cetak
            </a>
        </div>
       
        <div class="table-responsive-sm" >     
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Keterangan</th>
                            <th>Waktu</th>
                            <th>Foto Kegiatan</th>
                            <?php 
                            if ($status_pengajuan != '5' && $id_user_anggota == $id_user){?> 
                                <th>Aksi</th> 
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $logbook = getLogbook($conn, $id_pengajuan, $id_user_anggota);
                        while ($row = mysqli_fetch_assoc($logbook)){?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row['tanggal_logbook'] ?></td>
                                <td><?= $row['kegiatan_logbook'] ?></td>
                                <td><?= $row['keterangan_logbook'] ?></td>
                                <td>
                                    <?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?>
                                </td>

                                <td><img src="<?= $row['foto_kegiatan'] ?>" alt=""></td>
                                <?php
                                if ($status_pengajuan!= '5'){?>
                                <td>
                                    <a href="logbook_edit.php?id_logbook=<?= $row['id_logbook'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="?id_logbook=<?= $row['id_logbook'] ?>" 
                                    onclick="return confirm('Anda yakin akan menghapus Logbook ini?')"
                                    class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php
                                }
                        $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include "../layout/footerDashboard.php" ?>