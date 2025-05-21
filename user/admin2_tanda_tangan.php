<?php
include "../layout/sidebarUser.php";

$id_instansi_ini = $_SESSION["id_instansi"];

if(isset($_POST["submit_approve"])) {
    $result = approve_nilai($_POST);
    if($result > 0) { ?>
        <script>
            alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Admin Berhasil Menyetujui Penilaian", "admin2_tanda_tangan.php")
        </script>
    <?php } else { ?>
        <script>
            alert_berhasil_gagal_super_admin("error", "Gagal !!", "Admin Gagal Menyetujui Penilaian", "admin2_tanda_tangan.php")
        </script>
    <?php }
}

// Get all nilai that need approval (where tanda_tangan_admin is null)
$id_instansi = query("SELECT id_instansi FROM tb_profile_user WHERE id_user = '$id_user'")[0];
$id_instansi_ini = $id_instansi["id_instansi"];
$nilai_need_approval = query("SELECT n.*, p.id_instansi, pu.nama_user, pu.gambar_user
                            FROM tb_nilai n
                            JOIN tb_profile_user pu ON n.id_user = pu.id_user
                            JOIN tb_pengajuan p ON n.id_pengajuan = p.id_pengajuan
                            WHERE n.tanggal_approve IS NULL AND p.id_instansi = '$id_instansi_ini'");

$no = 1;
?>

<style>
.qr-wrapper {
    width: 180px;
    height: 180px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd;
    padding: 10px;
    background-color: #fff;
}
</style>



<div class="main-content p-3">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Persetujuan Nilai Magang</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Berikut daftar nilai yang perlu persetujuan</li>
        </ol>
        
        <!-- Link to Certificate Background Management -->
        <div class="mb-4">
            <a href="admin2_sertifikat.php" class="btn btn-primary">
                <i class="bi bi-image"></i> Kelola Background Sertifikat
            </a>
        </div>
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
                                <th>QR Code Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($nilai_need_approval as $nilai) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-center">
                                        <div>
                                        <?php $gambar = !empty($nilai["gambar_user"]) ? $nilai["gambar_user"] : 'avatar.png'; ?>
                                            <img src="../assets/img/user/<?= $gambar ?>" alt="Foto" class="rounded-circle mb-2" style="object-fit: cover; width: 100px; height: 100px">
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
                                        <div class="text-center">
                                            <div>
                                                <?php if (!empty($nilai["url_qr"])) : ?>
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($nilai['url_qr']) ?>&size=150x150" alt="QR Code">
                                                <?php endif; ?>
                                            </div>
                                            <small class="text-muted d-block"><a href="<?= $nilai["url_qr"] ?>"><i class="bi bi-eye"></i></a></small>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-primary downloadQR" 
                                                    data-id="<?= $nilai['id_nilai'] ?>"
                                                    data-url="<?= $nilai['url_qr'] ?>">
                                                    <i class="bi bi-download"></i> Download
                                                </button>
                                            </div>
                                        </div>
                                    </td>


                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="id_admin_approve" value="<?= $id_user ?>">
                                            <input type="hidden" name="id_nilai" value="<?= $nilai['id_nilai'] ?>">
                                            <button type="submit" name="submit_approve" class="btn btn-success btn-sm">
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
</div>

<?php include "../layout/footerDashboard.php"; ?>

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

<!-- QR Code Library -->
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    $(document).ready(function () {
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

        // View Nilai Modal
        $('.viewNilai').click(function () {
            const idNilai = $(this).data('id_nilai');
            $.ajax({
                url: 'pembimbing4_penilaian.php',
                type: 'GET',
                data: {
                    id_nilai: idNilai
                },
                success: function (response) {
                    $('#viewNilaiContent').html(response);
                }
            });
        });
    });

    // Generate QR Codes and enable download after all elements are loaded
    window.onload = function () {
        document.querySelectorAll('.downloadQR').forEach(function (button) {
            const idNilai = button.dataset.id;
            const url = button.dataset.url;

            if (url && idNilai) {
                const container = document.getElementById("qr-container-" + idNilai);
                if (container) {
                    container.innerHTML = '';
                    new QRCode(container, {
                    text: url,
                    width: 160,
                    height: 160,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });

                }
            }

            // Download QR Code
            button.addEventListener('click', function () {
                const qrElement = document.getElementById("qr-container-" + idNilai);
                html2canvas(qrElement).then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'qr-verifikasi-' + idNilai + '.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                });
            });
        });
    };
</script>
