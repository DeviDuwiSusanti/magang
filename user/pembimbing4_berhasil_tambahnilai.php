<?php
include '../layout/sidebarUser.php';
include "functions.php";

$pengajuan = query("SELECT id_pengajuan, id_user, status_pengajuan FROM tb_pengajuan WHERE id_pembimbing = '$id_user' AND (status_pengajuan = '2' OR status_pengajuan = '4' OR status_pengajuan = '5')");
$daftar_anggota = [];
$pendidikan_user = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload"])) {
    if (pembimbing_upload_nilai($_POST)) { ?>
        <script>
            alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Input Nilai Berhasil", "pembimbing4.php");
        </script>
    <?php } else { ?>
        <script>
            alert_berhasil_gagal_super_admin("error", "Gagal !!", "Input Nilai Gagal", "pembimbing4.php");
        </script>
    <?php }
}

if (!empty($pengajuan)) {
    $pengajuan_user = $pengajuan[0]["id_pengajuan"];
    $user_id = $pengajuan[0]["id_user"];
    $status_pengajuan = $pengajuan[0]["status_pengajuan"];

    // Ambil ID pendidikan
    $id_pendidikan_data = query("SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$user_id'");
    if (!empty($id_pendidikan_data)) {
        $id_pendidikan = $id_pendidikan_data[0]["id_pendidikan"];

        // Ambil detail pendidikan
        $pendidikan_result = query("SELECT * FROM tb_pendidikan WHERE id_pendidikan = '$id_pendidikan'");
        if (!empty($pendidikan_result)) {
            $pendidikan_user = $pendidikan_result[0];
        }
    }

    // Ambil daftar anggota
    $daftar_anggota = query("SELECT pu.id_user, pu.nama_user, pu.gambar_user, u.email
                            FROM tb_profile_user pu 
                            JOIN tb_user u ON pu.id_user = u.id_user 
                            WHERE pu.id_pengajuan = '$pengajuan_user' AND pu.status_active = '1'");
}

$no = 1;
?>

<!-- <style>
    .signature-pad {
        background-color: #f8f9fa;
        width: 100%;
    }
    
    .signature-pad canvas {
        width: 100%;
        height: 200px;
        touch-action: none;
    }
</style> -->

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Anggota Magang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Berikut adalah anggota peserta magang dari pengajuan Anda</li>
        </ol>
    </div>

    <?php if (!empty($daftar_anggota)) : ?>
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
                                <th>Nilai Peserta</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($daftar_anggota as $anggota) : 
                                // Cek apakah nilai sudah diinput
                                $check_nilai = query("SELECT id_nilai FROM tb_nilai WHERE id_user = '".$anggota['id_user']."' AND id_pengajuan = '$pengajuan_user'");
                                $nilai_exists = !empty($check_nilai);
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $anggota["nama_user"] ?></td>
                                    <td><?= $anggota["email"] ?></td>
                                    <td><img src="../assets/img/user/<?= $anggota["gambar_user"] ?>" alt="Foto" width="50" class="rounded-circle"></td>
                                    <td><?= $pendidikan_user['nama_pendidikan'] ?? '-' ?></td>
                                    <td><?= $pendidikan_user['jurusan'] ?? '-' ?></td>

                                    <td>
                                        <button class="btn btn-success btn-sm openNilai"
                                            data-id_pengajuan="<?= $pengajuan_user ?>"
                                            data-id_user="<?= $anggota['id_user'] ?? '' ?>"
                                            data-bs-toggle="<?= ($status_pengajuan == '5' && !$nilai_exists) ? 'modal' : '' ?>"
                                            data-bs-target="<?= ($status_pengajuan == '5' && !$nilai_exists) ? '#nilaiModal' : '' ?>"
                                            <?= ($status_pengajuan != '5' || $nilai_exists) ? 'disabled' : '' ?>
                                            title="<?= $nilai_exists ? 'Nilai sudah diinput' : 'Input nilai peserta' ?>">
                                            <i class="bi bi-bar-chart"></i> Input Nilai
                                        </button>

                                        <?php if ($nilai_exists) : ?>
                                            <a href="pembimbing4_cetak_nilai_sertif.php?id_user=<?= $anggota['id_user'] ?>&id_pengajuan=<?= $pengajuan_user ?>" 
                                                class="btn btn-sm btn-primary" 
                                                title="Lihat Nilai" 
                                                target="_blank">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="container mt-5">
            <div class="alert alert-warning text-center">
                Belum ada Daftar Anak anggota magang yang aktif Atau Berlangsung.
            </div>
        </div>
    <?php endif; ?>
</main>

<!-- Modal untuk Input Nilai -->
<div class="modal fade" id="nilaiModal" tabindex="-1" aria-labelledby="nilaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="nilaiForm" method="POST">
            <input type="hidden" id="nilai_id_pengajuan" name="id_pengajuan">
            <input type="hidden" id="nilai_id_user" name="id_user">
            <input type="hidden" name="upload" value="1">
            <input type="hidden" name="create_by" value="<?= $id_user ?>">
            <input type="hidden" id="signatureData" name="signature">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nilaiModalLabel">Input Nilai Peserta Magang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kehadiran/Absensi (0-100)</label>
                            <input type="number" class="form-control" name="kehadiran" min="0" max="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ketepatan Waktu/Disiplin (0-100)</label>
                            <input type="number" class="form-control" name="disiplin" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggung Jawab Terhadap Tugas (0-100)</label>
                            <input type="number" class="form-control" name="tanggung_jawab" min="0" max="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kreativitas (0-100)</label>
                            <input type="number" class="form-control" name="kreativitas" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kerjasama Tim (0-100)</label>
                            <input type="number" class="form-control" name="kerjasama" min="0" max="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kemampuan Penggunaan TI (0-100)</label>
                            <input type="number" class="form-control" name="teknologi_informasi" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan/Komentar</label>
                        <textarea class="form-control" name="catatan" rows="3"></textarea>
                    </div>

                    <!-- <div class="mb-3">
                        <label class="form-label">Tanda Tangan Pembimbing</label>
                        <div id="signature-pad" class="signature-pad border rounded">
                            <canvas width="100%" height="200"></canvas>
                        </div>
                        <div class="mt-2">
                            <button type="button" id="clearSignature" class="btn btn-sm btn-danger">Hapus Tanda Tangan</button>
                        </div>
                    </div> -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>

<!-- Script untuk Signature Pad -->
<!-- <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script> -->
<script>
    $(document).ready(function() {
        $('#table_anggota').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthMenu: [5, 10],
            columnDefs: [{
                orderable: false,
                targets: [3]
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
</script>

<script>
    $(document).ready(function() {
        // Untuk Nilai Modal
        document.querySelectorAll('.openNilai').forEach(button => {
            button.addEventListener('click', function() {
                const idPengajuan = this.getAttribute('data-id_pengajuan');
                const idUser = this.getAttribute('data-id_user');
                document.getElementById('nilai_id_pengajuan').value = idPengajuan;
                document.getElementById('nilai_id_user').value = idUser;
            });
        });
    });
</script>

<!-- 
<script>
    // Inisialisasi signature pad
    let signaturePad = null;
    
    $(document).ready(function() {
        // Inisialisasi signature pad saat modal ditampilkan
        $('#nilaiModal').on('shown.bs.modal', function () {
            const canvas = document.querySelector("canvas");
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(248, 249, 250)',
                penColor: 'rgb(0, 0, 0)'
            });
            
            // Handle resize
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }
            
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
        });
        
        // Clear signature
        $('#clearSignature').click(function() {
            signaturePad.clear();
        });
        
        // Handle form submission
        $('#nilaiForm').submit(function(e) {
            e.preventDefault();
            
            // Validasi tanda tangan
            if (signaturePad.isEmpty()) {
                alert('Harap berikan tanda tangan terlebih dahulu');
                return false;
            }
            
            // Simpan tanda tangan sebagai data URL
            $('#signatureData').val(signaturePad.toDataURL());
            
            // Submit form
            this.submit();
        });
    });
    
    // Untuk Nilai Modal
    document.querySelectorAll('.openNilai').forEach(button => {
        button.addEventListener('click', function() {
            const idPengajuan = this.getAttribute('data-id_pengajuan');
            const idUser = this.getAttribute('data-id_user');
            document.getElementById('nilai_id_pengajuan').value = idPengajuan;
            document.getElementById('nilai_id_user').value = idUser;
        });
    });
</script> -->