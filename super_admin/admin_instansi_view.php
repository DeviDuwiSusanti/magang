<?php 
    include "sidebar.php";
    $admin_instansi = query("SELECT * FROM tb_user u, tb_profile_user p WHERE p.id_user = u.id_user AND u.level = '2' AND (p.id_instansi IS NULL OR p.id_instansi = '') ");
    $no = 1;
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Calon Admin Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"> Halaman View Calon Admin Instansi </li>
        </ol>
    </div>
    <div class="container mt-5">                                
        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="table_admin_instansi" class="table table-bordered table-hover text-center align-middle">
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
                        <?php foreach($admin_instansi as $calon) : 
                            $jenis_kelamin = ($calon["jenis_kelamin"] == 'P' ? "Perempuan" : "Laki - Laki");
                            $level = ($calon["level"] == '2' ? "Admin Instansi" : "Bukan Admin Instansi");
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $calon["nama_user"] ?></td>
                            <td><?= $jenis_kelamin ?></td>
                            <td><?= $calon["tempat_lahir"] ?>, <?= $calon["tanggal_lahir"] ?></td>
                            <td><?= $calon["telepone_user"] ?></td>
                            <td><?= $calon["alamat_user"] ?></td>
                            <td>
                                <img src="../assets/img/user/<?= $calon["gambar_user"] ?>" alt="Gambar user" class="img-thumbnail" style="width: 100px;">
                            </td>
                            <td><?= $level ?></td>
                            <td>
                                <a href="admin_instansi_generate.php?id_user=<?= $calon["id_user"] ?>" class="btn btn-success btn-sm">
                                    <i class="bi bi-wrench"></i> Jadikan Admin Instansi
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
        $('#table_admin_instansi').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [{"orderable" : false, "targets" : [2, 3, 4, 5, 6, 7,8]}],
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
            }
        })
    })

</script>