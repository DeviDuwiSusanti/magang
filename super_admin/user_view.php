<?php 
    include "sidebar.php";
    $user = query("SELECT * FROM tb_profile_user p , tb_user u WHERE p.id_user = u.id_user");
    $no = 1;
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
                            $jenis_kelamin = ($u["jenis_kelamin"] == "P" ? "Perempuan" : "Laki - Laki");
                            $level = "";
                            if($u["level"] == "1") {
                                $level = "Super Admin";
                            }
                            if($u["level"] == "2") {
                                $level = "Admin Instansi";
                            }
                            if($u["level"] == "3") {
                                $level = "User Ketua";
                            }
                            if($u["level"] == "4") {
                                $level = "User Kelompok";
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
                                <a href="user_hapus.php?id_user=<?= $u["id_user"] ?>" class="btn btn-danger btn-sm" onclick="return(confirm('Apakah Anda Yakin Akan Menghapus Data Ini'))">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                                <a href="user_edit.php?id_user=<?= $u["id_user"] ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
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