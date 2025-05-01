<?php 
    include '../layout/sidebarUser.php';
    $pengajuan = query("SELECT u.nama_user, i.nama_panjang, b.nama_bidang, p.* 
                        FROM tb_pengajuan p, tb_profile_user u, tb_instansi i, tb_bidang b
                        WHERE u.id_user = p.id_user AND i.id_instansi = p.id_instansi AND b.id_bidang = p.id_bidang AND p.status_active = '1'");
    $no = 1;

    if(isset($_GET["id_pengajuan_ini"])) {
        $id_pengajuan = $_GET["id_pengajuan_ini"];
        
        if(hapus_pengajuan_by_super_admin($id_pengajuan, $id_user)) { ?>
            <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Hapus Data Pengajuan Berhasil", "super1_pengajuan.php"); </script>
        <?php  } else { ?>
            <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Hapus Data Pengajuan Gagal", "super1_pengajuan.php"); </script>
        <?php }
    }
?>

<main class="main-content p-3">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Halaman Daftar Pengajuan User</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"></li>
        </ol>
    </div>
    <div class="container mt-5">                        
        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="table_pengajuan" class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama User</th>
                            <th>Nama Instansi</th>
                            <th>Nama Bidang</th>
                            <th>Jenis Pengajuan</th>
                            <th>Calon Pelamar</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pengajuan as $aju) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $aju["nama_user"] ?></td>
                            <td><?= $aju["nama_panjang"] ?></td>
                            <td><?= $aju["nama_bidang"] ?></td>
                            <td><?= $aju["jenis_pengajuan"] ?></td>
                            <td><?= $aju["jumlah_pelamar"] ?></td>
                            <td><?= $aju["tanggal_mulai"] ?></td>
                            <td><?= $aju["tanggal_selesai"] ?></td>
                            <td><?= $aju["status_pengajuan"] ?></td>
                            <td>
                                <a href="#" class="btn btn-danger btn-sm" onclick="hapus_pengajuan_by_super_admin(<?= $aju['id_pengajuan'] ?>)">
                                    <i class="bi bi-trash"></i>
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
<?php include "../layout/footerDashboard.php" ?>
<script>
    $(document).ready(function() {
        $('#table_pengajuan').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [{"orderable" : false, "targets" : [2, 3, 4, 5, 8]}],
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
                    title : 'Laporan Data Pengajuan User',
                    exportOptions : {
                        columns : [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }
            ]
        })
    })

</script>