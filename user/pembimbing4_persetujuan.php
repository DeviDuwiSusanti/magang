<?php
include '../layout/sidebarUser.php';
include "functions.php";

// Ambil data bidang pembimbing saat ini
$current_user = query("SELECT id_bidang FROM tb_profile_user WHERE id_user = '$id_user' AND status_active = '1'")[0];
$id_bidang = $current_user['id_bidang'];

// Ambil semua pengajuan di bidang pembimbing saat ini dengan status 1 (sedang diajukan)
$pengajuan = query("SELECT p.id_pengajuan, p.id_user, p.status_pengajuan, p.tanggal_zoom, 
                    pu.nama_user, pu.gambar_user, pen.nama_pendidikan, pen.jurusan,
                    b.nama_bidang
                    FROM tb_pengajuan p
                    JOIN tb_profile_user pu ON p.id_user = pu.id_user
                    LEFT JOIN tb_pendidikan pen ON pu.id_pendidikan = pen.id_pendidikan
                    JOIN tb_bidang b ON p.id_bidang = b.id_bidang
                    WHERE p.id_bidang = '$id_bidang' AND p.status_pengajuan = '1' AND p.status_active = '1'
                    ORDER BY p.id_pengajuan");

// Kelompokkan data berdasarkan id_kelompok
$kelompok_pengajuan = [];
foreach ($pengajuan as $p) {
    $kelompok_pengajuan[$p['nama_user']][] = $p;
}

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $id_pengajuan = $_POST['id_pengajuan'];
        $id_user_magang = $_POST['id_user_magang'];
        $action = $_POST['action'];
        $alasan = isset($_POST['alasan']) ? $_POST['alasan'] : null;
        $id_persetujuan = generateId_persetujuan($id_user);
        
        // Simpan persetujuan pembimbing ke database
        $query = "INSERT INTO tb_persetujuan_pembimbing 
                 (id_persetujuan, id_pengajuan, id_pembimbing, status_persetujuan, alasan_penolakan, tanggal_persetujuan, create_by) 
                 VALUES ('$id_persetujuan','$id_pengajuan', '$id_user', ";
        $query .= $action == 'bersedia' ? "'1'" : "'0'";
        $query .= ", ";
        $query .= $alasan ? "'$alasan'" : "NULL";
        $query .= ", NOW(), '$id_user')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>
                alert_berhasil_gagal_super_admin('success', 'Berhasil !!', 'Persetujuan berhasil disimpan', 'pembimbing4_persetujuan.php');
            </script>";
        } else {
            echo "<script>
                alert_berhasil_gagal_super_admin('error', 'Gagal !!', 'Terjadi kesalahan saat menyimpan persetujuan', 'pembimbing4_persetujuan.php');
            </script>";
        }
    }
}
?>

<div class="main-content p-3">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Persetujuan Pembimbingan Magang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Berikut adalah permintaan pembimbingan magang yang perlu Anda setujui</li>
        </ol>
    </div>

    <?php if (!empty($kelompok_pengajuan)) : ?>
        <div class="container mt-5">
            <?php foreach ($kelompok_pengajuan as $id_kelompok => $anggota_kelompok) : ?>
                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Kelompok <?= $id_kelompok ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-info">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Foto</th>
                                        <th width="20%">Nama Peserta</th>
                                        <th width="15%">Pendidikan</th>
                                        <th width="15%">Jurusan</th>
                                        <th width="15%">Tanggal Wawancara</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($anggota_kelompok as $i => $p) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i + 1 ?></td>
                                            <td class="text-center">
                                                <img src="../assets/img/user/<?= !empty($p["gambar_user"]) ? $p["gambar_user"] : 'avatar.png' ?>" 
                                                     alt="Foto" width="60" class="rounded-circle">
                                            </td>
                                            <td><?= $p["nama_user"] ?></td>
                                            <td><?= $p["nama_pendidikan"] ?? '-' ?></td>
                                            <td><?= $p["jurusan"] ?? '-' ?></td>
                                            <td>
                                                <?= $p["tanggal_zoom"] ? date('d F Y', strtotime($p["tanggal_zoom"])) : 'Belum dijadwalkan' ?>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                                                        data-bs-target="#detailModal<?= $p['id_pengajuan'] ?>">
                                                    <i class="bi bi-eye"></i> Detail
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk setiap pengajuan dalam kelompok -->
                <?php foreach ($anggota_kelompok as $p) : ?>
                    <?php 
                        // Cek apakah pembimbing ini sudah memberikan persetujuan
                        $sudah_memberikan_persetujuan = query("SELECT COUNT(*) as total FROM tb_persetujuan_pembimbing 
                                                            WHERE id_pengajuan = '".$p["id_pengajuan"]."' 
                                                            AND id_pembimbing = '$id_user'")[0]['total'] > 0;
                        
                        $today = date('Y-m-d');
                        $tanggal_zoom = $p["tanggal_zoom"] ?? null;
                        $wawancara_sudah_berlalu = $tanggal_zoom && ($today > $tanggal_zoom);
                    ?>
                    
                    <div class="modal fade" id="detailModal<?= $p['id_pengajuan'] ?>" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title" id="detailModalLabel">Detail Permohonan Magang - Kelompok <?= $id_kelompok ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-3 text-center">
                                            <img src="../assets/img/user/<?= !empty($p["gambar_user"]) ? $p["gambar_user"] : 'avatar.png' ?>" 
                                                 alt="Foto" width="120" class="rounded-circle mb-2">
                                            <h5><?= $p["nama_user"] ?></h5>
                                        </div>
                                        <div class="col-md-9">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="30%">Pendidikan</th>
                                                    <td><?= $p["nama_pendidikan"] ?? '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jurusan</th>
                                                    <td><?= $p["jurusan"] ?? '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Bidang Magang</th>
                                                    <td><?= $p["nama_bidang"] ?? '-' ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kelompok</th>
                                                    <td><?= $id_kelompok ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Wawancara</th>
                                                    <td>
                                                        <?= $p["tanggal_zoom"] ? date('d F Y', strtotime($p["tanggal_zoom"])) : 'Belum dijadwalkan' ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        <span class="badge bg-warning">Menunggu Persetujuan Pembimbing</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <?php if (!$tanggal_zoom) : ?>
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle-fill"></i> Menunggu Jadwal Wawancara Melalui Zoom Atau Meeting
                                        </div>
                                    <?php elseif (!$wawancara_sudah_berlalu) : ?>
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle-fill"></i> Jadwal Wawancara via Zoom Atau Meeting Pada Tanggal <?= date('d F Y', strtotime($tanggal_zoom)) ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle-fill"></i> Wawancara via Zoom Atau Meeting sudah dilakukan
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!$sudah_memberikan_persetujuan) : ?>
                                        <?php if ($tanggal_zoom && $wawancara_sudah_berlalu) : ?>
                                            <form method="POST" id="persetujuanForm<?= $p['id_pengajuan'] ?>">
                                                <input type="hidden" name="id_pengajuan" value="<?= $p["id_pengajuan"] ?>">
                                                <input type="hidden" name="id_user_magang" value="<?= $p["id_user"] ?>">
                                                
                                                <div class="text-center mt-4">
                                                    <button type="button" class="btn btn-success btn-lg mx-2" 
                                                            id="btnBersedia<?= $p['id_pengajuan'] ?>"
                                                            onclick="confirmPersetujuan('bersedia', <?= $p['id_pengajuan'] ?>)">
                                                        <i class="bi bi-check-circle"></i> Bersedia
                                                    </button>
                                                    
                                                    <button type="button" class="btn btn-danger btn-lg mx-2" 
                                                            id="btnTidakBersedia<?= $p['id_pengajuan'] ?>"
                                                            onclick="showAlasanForm(<?= $p['id_pengajuan'] ?>)">
                                                        <i class="bi bi-x-circle"></i> Tidak Bersedia
                                                    </button>
                                                </div>
                                                
                                                <div id="alasanForm<?= $p['id_pengajuan'] ?>" class="mt-4" style="display:none;">
                                                    <div class="form-group">
                                                        <label for="alasan<?= $p['id_pengajuan'] ?>" class="form-label">Alasan Penolakan</label>
                                                        <textarea class="form-control" id="alasan<?= $p['id_pengajuan'] ?>" name="alasan" rows="3" required></textarea>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <button type="button" class="btn btn-secondary me-2" onclick="hideAlasanForm(<?= $p['id_pengajuan'] ?>)">
                                                            Batal
                                                        </button>
                                                        <button type="button" class="btn btn-danger" onclick="confirmPersetujuan('tidak_bersedia', <?= $p['id_pengajuan'] ?>)">
                                                            <i class="bi bi-send"></i> Kirim Penolakan
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="action" id="actionInput<?= $p['id_pengajuan'] ?>">
                                            </form>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <div class="alert alert-success text-center">
                                            <i class="bi bi-check-circle-fill"></i> Anda sudah memberikan persetujuan untuk pengajuan ini.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="container mt-5">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle-fill"></i> Saat ini tidak ada permintaan pembimbingan yang menunggu persetujuan Anda.
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include "../layout/footerDashboard.php"; ?>

<script>
    function confirmPersetujuan(action, id_pengajuan) {
        let message = '';
        let confirmText = '';
        
        if (action === 'bersedia') {
            message = 'Apakah Anda yakin bersedia membimbing peserta magang ini?';
            confirmText = 'Ya, Saya Bersedia';
        } else {
            const alasan = document.getElementById('alasan' + id_pengajuan).value;
            if (!alasan) {
                alert('Harap isi alasan penolakan');
                return;
            }
            message = 'Apakah Anda yakin tidak bersedia membimbing peserta magang ini?';
            confirmText = 'Ya, Saya Tidak Bersedia';
        }
        
        Swal.fire({
            title: 'Konfirmasi',
            text: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: 'Batal',
            confirmButtonColor: action === 'bersedia' ? '#28a745' : '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('actionInput' + id_pengajuan).value = action;
                document.getElementById('persetujuanForm' + id_pengajuan).submit();
            }
        });
    }
    
    function showAlasanForm(id_pengajuan) {
        document.getElementById('alasanForm' + id_pengajuan).style.display = 'block';
        document.getElementById('btnBersedia' + id_pengajuan).disabled = true;
        document.getElementById('btnTidakBersedia' + id_pengajuan).disabled = true;
    }
    
    function hideAlasanForm(id_pengajuan) {
        document.getElementById('alasanForm' + id_pengajuan).style.display = 'none';
        document.getElementById('btnBersedia' + id_pengajuan).disabled = false;
        document.getElementById('btnTidakBersedia' + id_pengajuan).disabled = false;
        document.getElementById('alasan' + id_pengajuan).value = '';
    }
</script>