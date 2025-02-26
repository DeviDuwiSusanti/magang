<?php include "../layout/sidebarUser.php"; 

if (ISSET($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
    
    $sql = "SELECT * FROM tb_logbook WHERE id_pengajuan = '$id_pengajuan' AND id_user = '$id_user'";
    $query = mysqli_query($conn, $sql);

    $no = 1;
}

// akses status_pengajuan
$sql3 = "SELECT status_pengajuan FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
$query3 = mysqli_query($conn, $sql3);
$status_pengajuan = mysqli_fetch_assoc($query3)['status_pengajuan'];

// HAPUS LOGBOOK
if (isset($_GET['id_logbook']) && isset($_GET['id_pengajuan'])) {
    $id_logbook = $_GET['id_logbook'];
    $id_pengajuan = $_GET['id_pengajuan'];
    $sql2 =  "DELETE FROM tb_logbook WHERE id_logbook = '$id_logbook' AND id_pengajuan = '$id_pengajuan' AND id_user = '$id_user'";
    $query2 = mysqli_query($conn, $sql2);
    if ($query2){
        echo "<script> alert('Logbook Berhasil Dihapus'); window.location.href='logbook_daftar.php?id_pengajuan={$id_pengajuan}&id_user={$id_user}'; </script>";
    }
}

?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Logbook</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Logbook Harian Anda</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <?php
            if ($status_pengajuan!= '3'){?>
                <a href="logbook_unggah.php?id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Logbook
                </a>
            <?php
            }
            ?>
            <a href="logbook_print.php?id_pengajuan=<?= $id_pengajuan ?>&id_user=<?= $id_user ?>" class="btn btn-success">
                <i class="bi bi-printer me-1"></i>
                Cetak
            </a>
        </div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($query)){?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row['tanggal_logbook'] ?></td>
                                <td><?= $row['kegiatan_logbook'] ?></td>
                                <td><?= $row['keterangan_logbook'] ?></td>
                                <td>
                                    <a href="logbook_edit.php?id_logbook=<?= $row['id_logbook'] ?>&id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="?id_logbook=<?= $row['id_logbook'] ?>&id_pengajuan=<?= $id_pengajuan ?>" 
                                    onclick="return confirm('Anda yakin akan menghapus Logbook ini?')"
                                    class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php
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