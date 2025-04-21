<?php 
    include '../layout/sidebarUser.php'; 
    include "functions.php";

    // Cek apakah ada pengajuan yang ditangani pembimbing
    $pengajuan = query("SELECT id_pengajuan, id_user, status_pengajuan FROM tb_pengajuan WHERE id_pembimbing = '$id_user' AND (status_pengajuan = '2' OR status_pengajuan = '4' OR status_pengajuan = '5')");

    $daftar_anggota = [];
    $pendidikan_user = null;

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
        $daftar_anggota = query("SELECT pu.nama_user, pu.gambar_user, u.email
                                FROM tb_profile_user pu 
                                JOIN tb_user u ON pu.id_user = u.id_user 
                                WHERE pu.id_pengajuan = '$pengajuan_user' AND pu.status_active = '1'");
    }

    $no = 1;
?>

<!-- Dropzone CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />

<!-- Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

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
                                <th>Logbook Peserta</th>
                                <th>Nilai Dan Sertifikat</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($daftar_anggota as $anggota) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $anggota["nama_user"] ?></td>
                                <td><?= $anggota["email"] ?></td>
                                <td><img src="../assets/img/user/<?= $anggota["gambar_user"] ?>" alt="Foto" width="50" class="rounded-circle"></td>
                                <td><?= $pendidikan_user['nama_pendidikan'] ?? '-' ?></td>
                                <td><?= $pendidikan_user['jurusan'] ?? '-' ?></td>
                                
                                <td>
                                    <button class="btn btn-info btn-sm openLogbook"
                                            data-id_pengajuan="<?= $pengajuan_user ?>"
                                            data-id_user="<?= $anggota['id_user'] ?? '' ?>"
                                            data-bs-toggle="<?= ($status_pengajuan == '4' || $status_pengajuan == '5') ? 'modal' : '' ?>"
                                            data-bs-target="<?= ($status_pengajuan == '4' || $status_pengajuan == '5') ? '#logbookModal' : '' ?>"
                                            <?= ($status_pengajuan != '4' && $status_pengajuan != '5') ? 'disabled' : '' ?>>
                                        <i class="bi bi-book"></i>
                                    </button>
                                </td>

                                <!-- Tombol Nilai & Sertifikat -->
                                <td>
                                    <button class="btn btn-success btn-sm openNilai"
                                            data-id_pengajuan="<?= $pengajuan_user ?>"
                                            data-id_user="<?= $anggota['id_user'] ?? '' ?>"
                                            data-bs-toggle="<?= ($status_pengajuan == '5') ? 'modal' : '' ?>"
                                            data-bs-target="<?= ($status_pengajuan == '5') ? '#nilaiModal' : '' ?>"
                                            <?= ($status_pengajuan != '5') ? 'disabled' : '' ?>>
                                        <i class="bi bi-bar-chart"></i>
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </button>
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



<!-- Modal untuk Logbook -->
<div class="modal fade" id="logbookModal" tabindex="-1" aria-labelledby="logbookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logbookModalLabel">Logbook Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Logbook</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk Nilai dan Sertifikat -->
<div class="modal fade" id="nilaiModal" tabindex="-1" aria-labelledby="nilaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="nilaiForm" method="POST">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="nilaiModalLabel">Upload Sertifikat dan Nilai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Upload File (PDF)</label>
                <div class="dropzone" id="fileDropzone"></div>
            </div>

            <!-- Tempat input rename file muncul -->
            <div id="renameContainer" class="mb-3" style="display: none;">
                <label class="form-label">Ganti Nama File</label>
                <input type="text" class="form-control" id="renameInput" placeholder="contoh: sertifikat_john_doe.pdf">
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="button" id="uploadBtn" class="btn btn-primary">Upload</button>
            </div>
        </div>
        </form>
    </div>
</div>



<?php include "../layout/footerDashboard.php"; ?>
<!-- Script untuk DataTable -->
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

        // Event listener untuk membuka modal dengan JavaScript
        $(".openModal").on("click", function() {
            var type = $(this).data("type");
            var id = $(this).data("id");
            var modalId = "#" + type + "Modal" + id;

            // Membuka modal sesuai dengan ID yang ditentukan
            $(modalId).modal('show');
        });
    });
</script>


<script>
  Dropzone.autoDiscover = false;

  const myDropzone = new Dropzone("#fileDropzone", {
    url: "/simpan-nilai-sertifikat", // Ganti sesuai backend kamu
    maxFiles: 1,
    acceptedFiles: ".pdf",
    addRemoveLinks: true,
    autoProcessQueue: false,
    paramName: "file_sertifikat", // Nama parameter file di server
    init: function () {
      this.on("addedfile", function (file) {
        // Tampilkan input rename saat file ditambahkan
        document.getElementById("renameContainer").style.display = "block";
        document.getElementById("renameInput").value = file.name;
      });

      this.on("removedfile", function () {
        // Sembunyikan rename input kalau file dihapus
        document.getElementById("renameContainer").style.display = "none";
        document.getElementById("renameInput").value = "";
      });

      this.on("sending", function (file, xhr, formData) {
        // Kirim nama file baru sebagai bagian dari data
        const newName = document.getElementById("renameInput").value;
        formData.append("new_filename", newName);
      });

      this.on("success", function (file, response) {
        alert("File berhasil diupload!");
        this.removeAllFiles();
        document.getElementById("renameContainer").style.display = "none";
        const modal = bootstrap.Modal.getInstance(document.getElementById("nilaiModal"));
        modal.hide();
      });

      this.on("error", function (file, errorMessage) {
        alert("Terjadi kesalahan saat mengupload file.");
      });
    }
  });

  document.getElementById("uploadBtn").addEventListener("click", function () {
    if (myDropzone.getAcceptedFiles().length === 0) {
      alert("Silakan upload file terlebih dahulu.");
      return;
    }
    myDropzone.processQueue();
  });
</script>

