<?php
include '../layout/sidebarUser.php';
include "functions.php";

// Get all pengajuan being supervised by this pembimbing
$pengajuan_list = query("SELECT id_pengajuan, id_instansi, id_bidang, id_user, status_pengajuan, tanggal_selesai, tanggal_extend 
                         FROM tb_pengajuan 
                         WHERE id_pembimbing = '$id_user' 
                         AND (status_pengajuan = '5' OR status_pengajuan = '2' OR status_pengajuan = '4')");
?>

<div class="main-content p-3">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Absensi Anggota Magang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Berikut adalah daftar absensi peserta magang yang Anda bimbing</li>
        </ol>
    </div>

    <?php if (!empty($pengajuan_list)) : ?>
        <?php foreach ($pengajuan_list as $pengajuan): ?>
            <?php
            $pengajuan_user = $pengajuan["id_pengajuan"];
            $user_id = $pengajuan["id_user"];
            $status_pengajuan = $pengajuan["status_pengajuan"];
            
            // Convert status to readable format
            if($status_pengajuan == 2) {
                $status_pengajuan = "Diterima";
            } else if ($status_pengajuan == 4) {
                $status_pengajuan = "Berlangsung";
            } else if($status_pengajuan == 5) {
                $status_pengajuan = "Selesai";
            }
            
            $tanggal_selesai = $pengajuan["tanggal_selesai"];
            $tanggal_extend = $pengajuan["tanggal_extend"];

            // Get all anggota for this pengajuan
            $daftar_anggota = query("SELECT pu.id_user, pu.nama_user, pu.gambar_user, u.email, pu.id_pendidikan
                                   FROM tb_profile_user pu 
                                   JOIN tb_user u ON pu.id_user = u.id_user 
                                   WHERE pu.id_pengajuan = '$pengajuan_user' AND pu.status_active = '1'");
            ?>

            <div class="container mt-5">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white fw-bold">
                        Pengajuan ID: <?= $pengajuan_user ?> &nbsp; | &nbsp; Status: <?= $status_pengajuan ?>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($daftar_anggota)) : ?>
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Foto</th>
                                        <th>Pendidikan</th>
                                        <th>Jurusan</th>
                                        <th>Absensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($daftar_anggota as $anggota) :
                                        // Get pendidikan info for each anggota
                                        $pendidikan_data = [];
                                        if (!empty($anggota['id_pendidikan'])) {
                                            $pendidikan_data = query("SELECT * FROM tb_pendidikan WHERE id_pendidikan = '" . $anggota['id_pendidikan'] . "'");
                                            $pendidikan_data = $pendidikan_data[0] ?? [];
                                        }
                                        
                                        // Count total absensi
                                        $total_absensi = query("SELECT COUNT(*) as total FROM tb_absensi 
                                                               WHERE id_user = '" . $anggota['id_user'] . "' 
                                                               AND id_pengajuan = '$pengajuan_user'
                                                               AND status_active = '1'");
                                        $absensi_count = $total_absensi[0]['total'];
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $anggota["nama_user"] ?></td>
                                            <td><?= $anggota["email"] ?></td>
                                            <td><img src="../assets/img/user/<?= $anggota["gambar_user"] ?: 'avatar.png' ?>" width="50" class="rounded-circle"></td>
                                            <td><?= $pendidikan_data['nama_pendidikan'] ?? '-' ?></td>
                                            <td><?= $pendidikan_data['jurusan'] ?? '-' ?></td>
                                            <td>
                                                <button class="btn btn-info btn-sm viewAbsensi"
                                                    data-id_pengajuan="<?= $pengajuan_user ?>"
                                                    data-id_user="<?= $anggota['id_user'] ?>"
                                                    data-nama_user="<?= $anggota['nama_user'] ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#absensiModal">
                                                    <i class="bi bi-calendar-check"></i> Lihat (<?= $absensi_count ?>)
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-warning">Belum ada anggota aktif.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="container mt-5">
            <div class="alert alert-warning text-center">
                Tidak ada data pengajuan yang dibimbing.
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal untuk Absensi -->
<div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="absensiModalLabel">Daftar Absensi <span id="namaPeserta"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="absensiContent">
                <!-- Content akan diisi via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('table').each(function() {
            $(this).DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthMenu: [5, 10],
                columnDefs: [{
                    orderable: false,
                    targets: [3, 6] // Kolom foto dan absensi tidak bisa diurutkan
                }],
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

        // Absensi Modal
        $('.viewAbsensi').click(function() {
            const idPengajuan = $(this).data('id_pengajuan');
            const idUser = $(this).data('id_user');
            const namaUser = $(this).data('nama_user');
            
            $('#namaPeserta').text(namaUser);
            
            $.ajax({
                url: 'pembimbing4_view_absensi.php',
                type: 'GET',
                data: {
                    id_pengajuan: idPengajuan,
                    id_user: idUser
                },
                beforeSend: function() {
                    $('#absensiContent').html('<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p>Memuat data absensi...</p></div>');
                },
                success: function(response) {
                    $('#absensiContent').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading absensi:", error);
                    $('#absensiContent').html('<div class="alert alert-danger">Gagal memuat data absensi</div>');
                }
            });
        });
    });
</script>