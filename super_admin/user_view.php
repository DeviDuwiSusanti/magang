<?php 
    include "sidebar.php";
    $user = query("SELECT u.*, p.*, i.nama_pendek, b.nama_bidang FROM tb_profile_user p JOIN tb_user u ON  p.id_user = u.id_user 
                LEFT JOIN tb_instansi i ON p.id_instansi = i.id_instansi
                LEFT JOIN tb_bidang b ON p.id_bidang = b.id_bidang
                WHERE u.status_active = '1' AND p.status_active = '1' ");
    $no = 1;

    if(isset($_GET["id_user_ini"])) {
        $id_user_ini = $_GET["id_user_ini"];
        
        if(hapus_user_super_admin($id_user_ini, $id_user)) { 
            echo "<script>hapus_user_super_admin_success()</script>";
        } else { 
            echo "<script>hapus_user_super_admin_gagal()</script>";
        }
    }
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">User</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"> Halaman View user</li>
        </ol>
    </div>
    <div class="container mt-5 mb-5">                        
        <!-- Tambah Data Button -->
        <div class="mb-3 text-end">
            <a href="user_tambah.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Tambah Admin Instansi
            </a>
        </div>
        
        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="table_user"  class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Gender</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Gambar</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($user as $u) :
                            $jenis_kelamin = ($u["jenis_kelamin"] == "0" ? "Perempuan" : "Laki - Laki");
                            $admin_instansi = (($u["id_instansi"] == "") ? "Calon Admin Instansi" : "Admin " . $u["nama_pendek"]);
                            $pembimbing_bidang = (($u["id_bidang"] == "") ? "Calon Pembimbing Bidang" : "Pembimbing " .$u["nama_bidang"]);
                            $level = "";
                            if($u["level"] == "1") {
                                $level = "Super Admin";
                            }
                            if($u["level"] == "2") {
                                $level = $admin_instansi;
                            }
                            if($u["level"] == "3") {
                                $level = "User Ketua";
                            }
                            if($u["level"] == "4") {
                                $level = "User Kelompok";
                            }
                            if($u["level"] == "5") {
                                $level = $pembimbing_bidang;
                            }
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $u["nama_user"] ?></td>
                            <td><?= $jenis_kelamin ?></td>
                            <td><?= $u["tempat_lahir"] ?>, <?= $u["tanggal_lahir"] ?></td>
                            <td><?= $u["telepone_user"] ?></td>
                            <td><?= $u["alamat_user"] ?></td>
                            <td>
                                <img src="../assets/img/user/<?= $u["gambar_user"] ?>" alt="Gambar user" class="img-thumbnail" style="width: 100px;">
                            </td>
                            <td><?= $level ?></td>
                            <td class="d-flex justify-content-center gap-2">
                                <?php if($u["level"] == '1' || $u["level"] == '2') { ?>
                                    <a href="#" class="btn btn-danger btn-sm" onclick="confirm_hapus_user_super_admin(<?= $u['id_user'] ?>)">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <a href="user_edit.php?id_user=<?= $u["id_user"] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <?php } else { ?>
                                        <a href="#" class="btn btn-danger btn-sm" onclick="confirm_hapus_user_super_admin(<?= $u['id_user'] ?>)">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                <?php } ?>
                                
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php include "footer.php" ?>
<script>
    $(document).ready(function() {
        $('#table_user').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [{"orderable" : false, "targets" : [2, 3, 4, 5, 6, 7, 8]}],
            "language" : {
                "search" : "Cari : ",
                "lengthMenu" : "Tampilkan _MENU_  data Per Halaman",
                "info" : "Menampilkan _START_ hingga _END_ dari _TOTAL_ Data",
                "paginate" : {
                    "first" : "Awal ",
                    "last" : " Akhir",
                    "next" : "Selanjutnya ",
                    "previous" : " Sebelumnya",
                }
            }, 

            dom : 'Blfrtip',
            buttons : [
                {
                    extend : 'pdfHtml5',
                    text : '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className : 'btn btn-danger m-2',
                    title : 'Laporan Data User',
                    exportOptions : {
                        columns : [0, 1, 2, 3, 4, 5, 7]
                    }
                }
            ]
        })
    })

</script>