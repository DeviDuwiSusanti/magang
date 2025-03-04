<?php
include '../layout/header.php';

$id_instansi = $_SESSION['id_instansi'];
$no = 1;

// Query untuk data utama pengajuan
$sql = "SELECT 
            p.id_pengajuan, 
            pu.nama_user,
            b.nama_bidang,
            p.jenis_pengajuan,
            p.tanggal_mulai,
            p.tanggal_selesai,
            p.status_pengajuan,
            pembimbing.nama_user AS nama_pembimbing
        FROM tb_pengajuan AS p
        INNER JOIN tb_profile_user AS pu ON p.id_user = pu.id_user
        INNER JOIN tb_bidang AS b ON p.id_bidang = b.id_bidang
        LEFT JOIN tb_profile_user AS pembimbing 
            ON p.id_bidang = pembimbing.id_bidang
        LEFT JOIN tb_user AS u_pembimbing 
            ON pembimbing.id_user = u_pembimbing.id_user
            AND u_pembimbing.level = 5
        WHERE p.id_instansi = '$id_instansi'
        AND p.status_pengajuan IN ('2', '3', '4')

        UNION ALL

        -- Query untuk anggota kelompok (tanpa pengaju utama)
        SELECT 
            p.id_pengajuan, 
            anggota.nama_user,
            b.nama_bidang,
            p.jenis_pengajuan,
            p.tanggal_mulai,
            p.tanggal_selesai,
            p.status_pengajuan,
            pembimbing.nama_user AS nama_pembimbing 
        FROM tb_profile_user AS anggota
        INNER JOIN tb_pengajuan AS p ON anggota.id_pengajuan = p.id_pengajuan
        INNER JOIN tb_bidang AS b ON p.id_bidang = b.id_bidang
        -- JOIN ke pembimbing agar muncul juga
        LEFT JOIN tb_profile_user AS pembimbing 
            ON p.id_bidang = pembimbing.id_bidang
        LEFT JOIN tb_user AS u_pembimbing 
            ON pembimbing.id_user = u_pembimbing.id_user
            AND u_pembimbing.level = 5 
        WHERE p.id_instansi = '$id_instansi'
        AND p.status_pengajuan IN ('2', '3', '4')
        AND p.id_user <> anggota.id_user

        ORDER BY id_pengajuan DESC
";

$result = mysqli_query($conn, $sql);
?>

<div class="main-content p-4">
    <h1 class="mb-4">Manajemen Nilai Magang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Kelola Nilai Akhir & Sertifikat</li>
    </ol>
    <div class="mb-4 dropdown-divider"></div>
    <div class="table-responsive-sm">
        <div class="bungkus-2">
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Jenis Kegiatan</th>
                        <th>Bidang</th>
                        <th>Tanggal Magang</th>
                        <th>Upload Nilai</th>
                        <th>Upload Sertifikat</th>
                        <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row["nama_user"] ?></td>
                            <td><?= $row["jenis_pengajuan"] ?></td>
                            <td><?= $row["nama_bidang"] ?></td>
                            <td>
                                <?php
                                if (!empty($row['tanggal_mulai']) && !empty($row['tanggal_selesai'])) {
                                    echo date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai']));
                                } else {
                                    echo "Periode Tidak Diketahui";
                                }
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal" data-id="<?= $row['id_pengajuan'] ?>" data-type="nilai">
                                    <i class="bi bi-upload"></i> Upload/Edit
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal" data-id="<?= $row['id_pengajuan'] ?>" data-type="sertifikat">
                                    <i class="bi bi-upload"></i> Upload/Edit
                                </button>
                            </td>
                            <!-- <td>
                                <a href="#" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus file?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td> -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="upload_handler.php" enctype="multipart/form-data">
                    <input type="hidden" name="peserta_id" id="modalPesertaId">
                    <input type="hidden" name="file_type" id="modalFileType">
                    <label id="modalLabel">Pilih File:</label>
                    <input type="file" name="upload_file" accept="application/pdf,application/msword,image/*" required>
                    <button type="submit" class="btn btn-primary mt-3">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var uploadModal = document.getElementById("uploadModal");
        uploadModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute("data-id");
            var type = button.getAttribute("data-type");

            document.getElementById("modalPesertaId").value = id;
            document.getElementById("modalFileType").value = type;
            document.getElementById("modalLabel").textContent = type === "nilai" ? "Upload Nilai Akhir:" : "Upload Sertifikat:";
        });
    });
</script>