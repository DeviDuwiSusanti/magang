<?php
include "../layout/sidebarUser.php";



if(isset($_POST["submit_approve"])) {
    $result = approve_nilai($_POST) ;
    if($result === 404) { ?>
        <script>alert_berhasil_gagal_super_admin("error", "Gagal !!", "Tanda Tangan Tidak Boleh Kosong", "admin2_tanda_tangan.php")</script>
    <?php } else if ($result > 0) { ?>
        <script>alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Admin Berhasil Menyetujui Penilian", "admin2_tanda_tangan.php")</script>
    <?php } else { ?>
        <script>alert_berhasil_gagal_super_admin("error", "Gagal !!", "Admin Gagal Menyetujui Penilaian", "admin2_tanda_tangan.php")</script>
    <?php }
}


// Get all nilai that need approval (where tanda_tangan_admin is null)
$id_instansi = query("SELECT id_instansi FROM tb_profile_user WHERE id_user = '$id_user'")[0];
$id_instansi_ini = $id_instansi["id_instansi"];
$nilai_need_approval = query("SELECT n.*, p.id_instansi, pu.nama_user, pu.gambar_user
                            FROM tb_nilai n
                            JOIN tb_profile_user pu ON n.id_user = pu.id_user
                            JOIN tb_pengajuan p ON n.id_pengajuan = p.id_pengajuan
                            WHERE n.tanda_tangan_admin IS NULL AND p.id_instansi = '$id_instansi_ini'");

$no = 1;
?>

<style>
    .signature-pad {
        background-color: #f8f9fa;
        width: 100%;
    }
    
    .signature-pad canvas {
        width: 100%;
        height: 200px;
        touch-action: none;
    }
</style>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Persetujuan Nilai Magang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Berikut daftar nilai yang perlu persetujuan</li>
        </ol>
    </div>

    <?php if (!empty($nilai_need_approval)) : ?>
        <div class="container mt-5">
            <div class="card shadow-lg">
                <div class="card-body">
                    <table id="table_nilai" class="table table-striped table-bordered align-middle text-center">
                        <thead class="table-light small">
                            <tr>
                                <th>No.</th>
                                <th>Peserta</th>
                                <th>Rata-rata Nilai</th>
                                <th>Detail Nilai</th>
                                <th>Tanda Tangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($nilai_need_approval as $nilai) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-center">
                                        <div>
                                            <img src="../assets/img/user/<?= $nilai["gambar_user"] ?>" alt="Foto" class="rounded-circle mb-2" style="object-fit: cover; width: 100px; height: 100px">
                                            <div style="font-size: 14px;"><?= $nilai["nama_user"] ?></div>
                                        </div>
                                    </td>

                                    <td><?= number_format($nilai['rata_rata'], 2) ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm viewNilai"
                                            data-id_nilai="<?= $nilai['id_nilai'] ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewNilaiModal">
                                            <i class="bi bi-eye"></i> Lihat
                                        </button>
                                    </td>
                                    <td>
                                        <div id="signature-pad-<?= $nilai['id_nilai'] ?>" class="signature-pad border rounded">
                                            <canvas width="100%" height="100"></canvas>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-danger clearSignature" data-id="<?= $nilai['id_nilai'] ?>">
                                                Hapus Tanda Tangan
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                    <form method="POST">
                                        <input type="hidden" name="id_admin_approve" value="<?= $id_user ?>">
                                        <input type="hidden" name="id_nilai" value="<?= $nilai['id_nilai'] ?>">
                                        <input type="hidden" name="tanda_tangan_admin" id="signature-data-<?= $nilai['id_nilai'] ?>">
                                        <button type="submit" name="submit_approve" class="btn btn-success btn-sm" onclick="return handleSubmit(<?= $nilai['id_nilai'] ?>)">
                                            <i class="bi bi-check-circle"></i> Setujui
                                        </button>
                                    </form>
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
            <div class="alert alert-success text-center">
                Tidak ada nilai yang perlu disetujui saat ini.
            </div>
        </div>
    <?php endif; ?>
</main>

<!-- Modal untuk View Nilai -->
<div class="modal fade" id="viewNilaiModal" tabindex="-1" aria-labelledby="viewNilaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewNilaiModalLabel">Detail Nilai Peserta Magang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewNilaiContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php"; ?>

<!-- Script untuk Signature Pad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_nilai').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthMenu: [5, 10],
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

        // Initialize signature pads for each row
        let signaturePads = {};
        $('.signature-pad').each(function() {
            const id = $(this).attr('id').split('-')[2];
            const canvas = this.querySelector('canvas');
            signaturePads[id] = new SignaturePad(canvas, {
                backgroundColor: 'rgb(248, 249, 250)',
                penColor: 'rgb(0, 0, 0)'
            });
            
            // Handle resize
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePads[id].clear();
            }
            
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
        });

        // Clear signature buttons
        $('.clearSignature').click(function() {
            const id = $(this).data('id');
            signaturePads[id].clear();
        });

        // View Nilai Modal
        $('.viewNilai').click(function() {
            const idNilai = $(this).data('id_nilai');
            $.ajax({
                url: 'ajax2_view_nilai.php',
                type: 'GET',
                data: {id_nilai: idNilai},
                success: function(response) {
                    $('#viewNilaiContent').html(response);
                }
            });
        });

        window.handleSubmit = function(id) {
            const pad = signaturePads[id];
            if (pad.isEmpty()) {
                alert("Tanda tangan tidak boleh kosong!");
                return false;
            }
            document.getElementById("signature-data-" + id).value = pad.toDataURL();
            return true;
        }

    });
</script>