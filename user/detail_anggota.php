<?php 
include "../layout/sidebarUser.php"; 
include "functions.php";

// TABEL DAFTAR ANGGOTA
if (isset($_GET['id_pengajuan']) && count($_GET) === 1) {
    $id_pengajuan = $_GET['id_pengajuan'];
    $sql = "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_pengajuan = '$id_pengajuan' AND u.level = '4' AND pu.id_user = u.id_user";
    $query = mysqli_query($conn, $sql);

    $no = 1;

    // update jumlah anggota magang
    $sqlAnggota = "SELECT COUNT(*) AS jumlahAnggota FROM tb_profile_user WHERE id_pengajuan = '$id_pengajuan'";
    $queryAnggota = mysqli_query($conn, $sqlAnggota);
    $jumlah_anggota = mysqli_fetch_assoc($queryAnggota)['jumlahAnggota'];

    $updateJumlah = "UPDATE tb_pengajuan SET jumlah_pelamar = '$jumlah_anggota' WHERE id_pengajuan = '$id_pengajuan'";
    $queryJumlah = mysqli_query($conn, $updateJumlah);

    // akses pengajuan
    $sql3 = "SELECT * FROM tb_pengajuan p, tb_bidang b WHERE p.id_pengajuan = '$id_pengajuan' AND p.id_bidang = b.id_bidang";
    $query3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($query3);
    ?>

    <div class="main-content p-3">
        <div class="container-fluid">
            <h1 class="mb-4">Daftar Anggota</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Daftar Anggota <?= $row3['jenis_pengajuan'] ?></li>
            </ol>
            <div class="mb-4 dropdown-divider"></div>
            <div class="mb-4 text-end">
                <?php
                if ($row3['status_pengajuan'] == '1' && $jumlah_anggota < $row3['kuota_bidang']){?>
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
}if (isset($_GET['id_userHapus']) && isset($_GET['id_pengajuan'])) {
    $id_userHapus = $_GET['id_userHapus'];
    $id_pengajuan = $_GET['id_pengajuan'];
    $sql2 =  "DELETE tb_user, tb_profile_user 
            FROM tb_user 
            JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user
            WHERE tb_user.id_user = '$id_userHapus' AND tb_profile_user.id_pengajuan = '$id_pengajuan'";
    $query2 = mysqli_query($conn, $sql2);
    if (mysqli_query($conn, $sql2)){
        showAlert('Berhasil!', 'Data Anggota Berhasil Dihapus', 'success', "detail_anggota.php?id_pengajuan={$id_pengajuan}");
        exit();
    }else{
        showAlert('Gagal!', 'Data anggota gagal dihapus. Silakan coba lagi.', 'error');
    }   
    
}if (ISSET($_POST['update_anggota'])){
    $id_pengajuan = $_POST['id_pengajuan'];
    $id_userUpdate = $_POST['id_user'];
    $nama_anggota = $_POST['nama_user'];
    $email = $_POST['email'];
    $nik = $_POST['nik'];
    $nim = $_POST['nim'];

    $sqlUpdate = "UPDATE tb_profile_user SET nama_user = '$nama_anggota', nik = '$nik', nim = '$nim', nisn = '$nim', change_by = '$id_user' WHERE id_user = '$id_userUpdate'";
    if (mysqli_query($conn, $sqlUpdate)){
        $sqlUpdate2 = "UPDATE tb_user SET email = '$email', change_by = '$id_user' WHERE id_user = '$id_userUpdate'";
        if (mysqli_query($conn, $sqlUpdate2)){
            showAlert('Berhasil!', 'Data Anggota Berhasil Diupdate', 'success', "detail_anggota.php?id_pengajuan={$id_pengajuan}");
            exit();
        }else{
            showAlert('Gagal!', 'Data anggota gagal diupdate. Silakan coba lagi.', 'error');
        }   
    }
}if (ISSET($_POST['tambah_anggota'])){
    $id_pengajuan = $_POST['id_pengajuan'];
    $nama_anggota = $_POST['nama_user'];
    $email = $_POST['email'];
    $nik = $_POST['nik'];
    $nim = $_POST['nim'];
    $id_user4  = generateIdUser4($conn, $id_user);
    $pendidikan = "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'";
    $result = mysqli_query($conn, $pendidikan);
    $id_pendidikan = mysqli_fetch_assoc($result)['id_pendidikan'];

    $sqlTambah = "INSERT INTO tb_profile_user (id_user, nama_user, nik, nim, nisn, id_pengajuan, id_pendidikan, create_by) VALUES ('$id_user4', '$nama_anggota', '$nik', '$nim', '$nim', '$id_pengajuan', '$id_pendidikan', '$id_user')";
    if (mysqli_query($conn, $sqlTambah)){
        $sqlTambah2 = "INSERT INTO tb_user (id_user, email, level, create_by) VALUES ('$id_user4', '$email', '4', '$id_user')";
        if (mysqli_query($conn, $sqlTambah2)){
            showAlert('Berhasil!', 'Data Anggota Berhasil di tambah', 'success', "detail_anggota.php?id_pengajuan={$id_pengajuan}");
            exit();
        }else{
            showAlert('Gagal!', 'Data anggota gagal di tambah. Silakan coba lagi.', 'error');
        }   
    }
// FORM EDIT ANGGOTA
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
                <input type="text" class="form-control" id="nama_user" name="nama_user" >
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" >
            </div>
            
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="number" class="form-control" id="nik" name="nik" >
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
}

include "../layout/footerDashboard.php" 
?>


<!-- ==========  VALIDASIIII ===============-->
<script>
$(document).ready(function() {
    $(".form-profile").on("submit", function(e) {
        let isValid = true;
        $(".error-message").remove(); // Hapus pesan error lama

        // Fungsi tambah pesan error
        function showError(input, message) {
            $(input).after(`<div class="error-message text-danger mt-1">${message}</div>`);
        }

        // Dapatkan id_user (kosong jika tambah anggota)
        const id_userEdit = $("input[name='id_user']").val() || ""; // kalau tambah anggota, kosong

        // Validasi Nama
        const nama = $("#nama_user").val().trim();
        const namaRegex = /^[a-zA-Z\s]+$/;
        if (nama === "") {
            isValid = false;
            showError("#nama_user", "Nama tidak boleh kosong!");
        } else if (!namaRegex.test(nama)) {
            isValid = false;
            showError("#nama_user", "Nama hanya boleh berisi huruf!");
        }

        // Validasi Email
        const email = $("#email").val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") {
            isValid = false;
            showError("#email", "Email tidak boleh kosong!");
        } else if (!emailRegex.test(email)) {
            isValid = false;
            showError("#email", "Masukkan email yang valid!");
        } else {
            // AJAX untuk cek email
            $.ajax({
                url: 'cek.php',
                type: 'POST',
                data: { email: email, id_userEdit: id_userEdit }, // kirim id_userEdit (bisa kosong)
                async: false,
                success: function(response) {
                    if (response === "exists") {
                        isValid = false;
                        showError("#email", "Email sudah digunakan!");
                    }
                }
            });
        }

        // Validasi NIK
        const nik = $("#nik").val().trim();
        if (nik === "") {
            isValid = false;
            showError("#nik", "NIK tidak boleh kosong!");
        } else if (nik.length !== 16 || isNaN(nik)) {
            isValid = false;
            showError("#nik", "NIK harus 16 digit angka!");
        }

        // Validasi NIM/NISN
        const nim = $("#nim").val().trim();
        if (nim === "") {
            isValid = false;
            showError("#nim", "NIM/NISN tidak boleh kosong!");
        } else if (nim.length < 10 || nim.length > 12 || isNaN(nim)) {
            isValid = false;
            showError("#nim", "NIM/NISN harus 10-12 digit angka!");
        }

        // Cegah submit jika ada error
        if (!isValid) {
            e.preventDefault();
        }
    });
});

</script>
