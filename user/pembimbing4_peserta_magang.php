<?php 
    include '../layout/sidebarUser.php'; 

    // Ambil id_pengajuan yang ditangani oleh pembimbing ini
    $pengajuan = query("SELECT id_pengajuan FROM tb_pengajuan WHERE id_pembimbing = '$id_user'")[0];
    $pengajuan_user = $pengajuan["id_pengajuan"];

    // Ambil daftar anggota dari pengajuan tersebut

    $daftar_anggota = query("SELECT * FROM tb_profile_user, tb_user WHERE tb_profile_user.id_user = tb_user.id_user AND tb_profile_user.id_pengajuan = '$pengajuan_user' AND tb_profile_user.status_active = '1'");

    $no = 1;
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Anggota Magang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Berikut adalah anggota peserta magang dari pengajuan Anda</li>
        </ol>
    </div>
    <div class="container mt-5">                        
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="table_anggota" class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <!-- <th>Pendidikan</th>
                            <th>Jurusan</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($daftar_anggota as $anggota) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $anggota["nama_user"] ?></td>
                            <td><?= $anggota["email"] ?></td>
                            <td>
                                <img src="../assets/img/user/<?= $anggota["gambar_user"] ?>" alt="Foto" width="50" class="rounded-circle">
                            </td>
                            <!-- <td><?= $anggota["nama_pendidikan"] ?></td>
                            <td><?= $anggota["jurusan"] ?></td> -->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include "../layout/footerDashboard.php"; ?>

<!-- DataTables JS -->
<script>
    $(document).ready(function() {
        $('#table_anggota').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [5, 10],
            "columnDefs": [{"orderable": false, "targets": [3]}],
            "language": {
                "search": "Cari : ",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className: 'btn btn-danger m-2',
                    title: 'Laporan Daftar Anggota Pengajuan',
                    exportOptions: {
                        columns: [0, 1, 2, 4, 5] // kolom foto tidak di-export
                    }
                }
            ]
        });
    });
</script>
