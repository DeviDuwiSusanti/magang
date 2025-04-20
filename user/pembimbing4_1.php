<?php 
    include '../layout/sidebarUser.php'; 

    // Ambil id_pengajuan yang ditangani oleh pembimbing ini
    $pengajuan = query("SELECT id_pengajuan, id_user FROM tb_pengajuan WHERE id_pembimbing = '$id_user'")[0];
    $pengajuan_user = $pengajuan["id_pengajuan"];

    $user_id = $pengajuan["id_user"];

    // Ambil ID pendidikan dari user pertama (karena semua sama)
    $id_pendidikan_data = query("SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$user_id'")[0];
    $id_pendidikan = $id_pendidikan_data["id_pendidikan"];

    // Ambil detail pendidikan
    $pendidikan_user = query("SELECT * FROM tb_pendidikan WHERE id_pendidikan = '$id_pendidikan'")[0];

    // Ambil daftar anggota dari pengajuan
    $daftar_anggota = query("SELECT pu.nama_user, pu.gambar_user, u.email
                            FROM tb_profile_user pu 
                            JOIN tb_user u ON pu.id_user = u.id_user 
                            WHERE pu.id_pengajuan = '$pengajuan_user' AND pu.status_active = '1'");

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
            <table id="table_anggota" class="table table-striped table-bordered align-middle text-center">
            <thead class="table-light small">
                        <tr>
                            <th>No.</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th>Pendidikan</th>
                            <th>Jurusan</th>
                            <th>Logbook Peserta</th>
                            <th>Unggah Nilai</th>
                            <th>Unggah Sertifikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($daftar_anggota as $anggota) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $anggota["nama_user"] ?></td>
                            <td><?= $anggota["email"] ?></td>
                            <td><img src="../assets/img/user/<?= $anggota["gambar_user"] ?>" alt="Foto" width="50" class="rounded-circle"></td>
                            <td><?= $pendidikan_user["nama_pendidikan"] ?></td>
                            <td><?= $pendidikan_user["jurusan"] ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include "../layout/footerDashboard.php"; ?>


<script>
    $(document).ready(function() {
        $('#table_anggota').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthMenu: [5, 10],
            columnDefs: [{ orderable: false, targets: [3] }],
            language: {
                search: "Cari : ",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>
