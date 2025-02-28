<?php 
include "../layout/sidebarUser.php"; 
include "functions.php";

if (ISSET($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
    
    $sql = "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_pengajuan = '$id_pengajuan' AND u.level = '4' AND pu.id_user = u.id_user";
    $query = mysqli_query($conn, $sql);

    $no = 1;

    // akses pengajuan
    $sql3 = "SELECT * FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
    $query3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($query3);

}if (isset($_GET['id_userHapus']) && isset($_GET['id_pengajuan'])) {
    $id_userHapus = $_GET['id_userHapus'];
    $id_pengajuan = $_GET['id_pengajuan'];
    $sql2 =  "DELETE tb_user, tb_profile_user 
            FROM tb_user 
            JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user
            WHERE tb_user.id_user = '$id_userHapus' AND tb_profile_user.id_pengajuan = '$id_pengajuan'";
    $query2 = mysqli_query($conn, $sql2);
    if ($query2){
        echo "<script> alert('Data Anggota Berhasil Dihapus'); window.location.href='detail_anggota.php?id_pengajuan={$id_pengajuan}'; </script>";
    }
}if (ISSET($_POST['update_anggota'])){
    $id_pengajuan = $_POST['id_pengajuan'];
    $id_userUpdate = $_POST['id_user'];
    $nama_anggota = $_POST['nama_user'];
    $email = $_POST['email'];
    $nik = $_POST['nik'];
    $nim = $_POST['nim'];

    $sqlUpdate = "UPDATE tb_profile_user SET nama_user = '$nama_anggota', nik = '$nik', nim = '$nim', nisn = '$nim' WHERE id_user = '$id_userUpdate'";
    if (mysqli_query($conn, $sqlUpdate)){
        $sqlUpdate2 = "UPDATE tb_user SET email = '$email' WHERE id_user = '$id_userUpdate'";
        if (mysqli_query($conn, $sqlUpdate2)){
            echo "<script> alert('Data Anggota Berhasil DiUpdate'); window.location.href='detail_anggota.php?id_pengajuan={$id_pengajuan}'; </script>";
        }
    }
}if (ISSET($_POST['tambah_anggota'])){
    $id_pengajuan = $_POST['id_pengajuan'];
    $nama_anggota = $_POST['nama_user'];
    $email = $_POST['email'];
    $nik = $_POST['nik'];
    $nim = $_POST['nim'];
    $id_user4  = generateIdUser4($conn, $id_user);

    $sqlTambah = "INSERT INTO tb_profile_user (id_user, nama_user, nik, nim, nisn, id_pengajuan) VALUES ('$id_user4', '$nama_anggota', '$nik', '$nim', '$nim', '$id_pengajuan')";
    if (mysqli_query($conn, $sqlTambah)){
        $sqlTambah2 = "INSERT INTO tb_user (id_user, email, level) VALUES ('$id_user4', '$email', '4')";
        if (mysqli_query($conn, $sqlTambah2)){
            echo "<script> alert('Data Anggota Berhasil Ditambah'); window.location.href='detail_anggota.php?id_pengajuan={$id_pengajuan}'; </script>";
        }
    }
}if (isset($_GET['id_userEdit']) && isset($_GET['id_pengajuan'])) {
    $id_pengajuan = $_GET['id_pengajuan'];
    $id_userEdit = $_GET['id_userEdit'];
    $editQuery = mysqli_query($conn, "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_user = u.id_user AND u.id_user = '$id_userEdit'");
    $editRow = mysqli_fetch_assoc($editQuery);
?>
    <!-- Form Edit Anggota -->
    <div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Edit Anggota -->
        <h1 class="mb-4">Edit Anggota</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Form Edit Data Anggota</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        
        <form action="detail_anggota.php" method="POST" class="form-profile">
            <input type="hidden" name="id_user" value="<?= $editRow['id_user'] ?>">
            <input type="hidden" name="id_pengajuan" value="<?= $id_pengajuan ?>">
            
            <div class="mb-3">
                <label for="nama_user" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama_user" name="nama_user" value="<?= $editRow['nama_user'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $editRow['email'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="number" class="form-control" id="nik" name="nik" value="<?= $editRow['nik'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="nim" class="form-label">Nim/Nisn</label>
                <input type="number" class="form-control" id="nim" name="nim" value="<?= !empty($editRow['nim']) ? $editRow['nim'] : $editRow['nisn'] ?>">
            </div>
    
            <!-- Tombol Submit -->
            <button type="submit" name="update_anggota" class="btn btn-primary edit">
                <i class="bi bi-floppy me-1"></i>Simpan Perubahan
            </button>
        </form>
    </div>
</div>
<?php
// FORM TAMBAH ANGGOTA
}if (isset($_GET['id_user']) && isset($_GET['id_pengajuan'])) {
    $id_pengajuan = $_GET['id_pengajuan'];
    $id_user = $_GET['id_user'];
?>
    <!-- Form Tambah Anggota -->
    <div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading tambah Anggota -->
        <h1 class="mb-4">Tambah Anggota</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Form Tambah Data Anggota</li>
        </ol>
        <div class="dropdown-divider mb-3"></div>
        
        <form action="detail_anggota.php" method="POST" class="form-profile">
            <input type="hidden" name="id_pengajuan" value="<?= $id_pengajuan ?>">
            
            <div class="mb-3">
                <label for="nama_user" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama_user" name="nama_user" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="number" class="form-control" id="nik" name="nik" required>
            </div>
            
            <div class="mb-3">
                <label for="nim" class="form-label">Nim/Nisn</label>
                <input type="number" class="form-control" id="nim" name="nim">
            </div>
    
            <!-- Tombol Submit -->
            <button type="submit" name="tambah_anggota" class="btn btn-primary edit">
                <i class="bi bi-floppy me-1"></i>Tambah Anggota
            </button>
        </form>
    </div>
</div>
<?php
}else{
?>
<!-- TABEL DAFTAR ANGGOTA -->
<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Anggota</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Anggota <?= $row3['jenis_pengajuan'] ?></li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <?php
            if ($row3['status_pengajuan'] == '1'){?>
                <a href="?id_user=<?= $row['id_user'] ?>&id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Anggota
                </a>
            <?php
            }
            ?>
        </div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIK</th>
                            <th>Nim/Nisn</th>
                            <?php
                            if ($row3['status_pengajuan'] == '1'){?>
                                <th>Aksi</th>
                            <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($query)){?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row['nama_user'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['nik'] ?></td>
                                <td><?= !empty($row['nim']) ? $row['nim'] : $row['nisn'] ?></td>
                                <?php
                                if ($row3['status_pengajuan'] == '1'){?>
                                <td>
                                    <a href="detail_anggota.php?id_userEdit=<?= $row['id_user'] ?>&id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="detail_anggota.php?id_userHapus=<?= $row['id_user'] ?>&id_pengajuan=<?= $id_pengajuan ?>" 
                                    onclick="return confirm('Anda yakin akan menghapus Data Anggota ini?')"
                                    class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                                <?php
                                }
                                ?>
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
<?php
}
?>

<?php include "../layout/footerDashboard.php" ?>

