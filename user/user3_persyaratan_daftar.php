<?php
// Ambil id_user dan id_pengajuan jika belum didefinisikan
if (!isset($id_user)) {
    session_start();
    $id_user = $_SESSION['id_user'] ?? '';
}
if (!isset($id_pengajuan)) {
    $id_pengajuan = $_SESSION['id_pengajuan'] ?? '';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_laporan'])) {
    $id_dokumen = $_POST['id_dokumen'];

    // Ambil file path dari database
    $query = $conn->prepare("SELECT file_path FROM tb_dokumen WHERE id_dokumen = ?");
    $query->bind_param("s", $id_dokumen);
    $query->execute();
    $result = $query->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        // Hapus file dari folder (fisik)
        if (file_exists($data['file_path'])) {
            unlink($data['file_path']);
        }

       // Update status_active jadi 0 (soft delete) dan isi kolom change_by
        $stmt = $conn->prepare("UPDATE tb_dokumen SET status_active = 0, change_date = NOW(), change_by = ? WHERE id_dokumen = ?");
        $stmt->bind_param("ss", $id_user, $id_dokumen);
        $stmt->execute();

        $status = 'success';
        $msg = 'Dokumen berhasil dihapus.';
    } else {
        $status = 'error';
        $msg = 'Dokumen tidak ditemukan.';
    }

    // Tampilkan SweetAlert
    switch ($status) {
        case 'success':
            $icon = 'success';
            break;
        case 'error':
            $icon = 'error';
            break;
        default:
            $icon = 'info';
    }

    echo "<script>
        Swal.fire({
            icon: '$icon',
            title: '".ucfirst($status)."!',
            text: '$msg'
        }).then(() => {
            window.location.href = window.location.href;
        });
    </script>";
    exit;
}



// Query daftar dokumen persyaratan
$stmt = $conn->prepare("SELECT * FROM tb_dokumen WHERE id_user = ? AND jenis_dokumen IN (1, 2) AND id_pengajuan = ? AND status_active = 1");
$stmt->bind_param("ss", $id_user, $id_pengajuan);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Modal Daftar Dokumen -->
<div class="modal fade" id="daftarDokumenModal" tabindex="-1" aria-labelledby="daftarDokumenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="daftarDokumenModalLabel">Daftar Dokumen Persyaratan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive-sm">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Dokumen</th>
                <th>Tgl. Unggah</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">
                    <?= htmlspecialchars($row['nama_dokumen']) ?>
                  </a>
                </td>
                <td><?= htmlspecialchars($row['create_date']) ?></td>
                <td>
                  <?php if ($row['id_user'] == $id_user): ?>
                    <form method="POST" class="hapus-dokumen-form">
                        <input type="hidden" name="id_dokumen" value="<?= $row['id_dokumen'] ?>">
                        <input type="hidden" name="hapus_laporan" value="1">
                        <button type="button" class="btn btn-danger btn-sm hapus-btn">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                  <?php else: ?>
                  <button class="btn btn-secondary btn-sm" disabled>
                    <i class="bi bi-trash"></i>
                  </button>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <!-- Tombol Unggah Baru di dalam modal -->
        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#unggahModal">
          <i class="bi bi-upload"></i> Unggah Persyaratan Baru
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Unggah Persyaratan -->
<div class="modal fade" id="unggahModal" tabindex="-1" aria-labelledby="unggahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unggahModalLabel">Unggah Persyaratan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="dropzone" id="myDropzone" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_pengajuan" value="<?= $id_pengajuan ?>">
                    <input type="hidden" name="id_user" value="<?= $id_user ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="submit-all">Unggah</button>
            </div>
        </div>
    </div>
</div>

<!-- Proses Upload -->
<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $deskripsi = $_POST['deskripsi'] ?? 'Tidak ada deskripsi';
    $file_extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

    if ($file_extension !== "pdf") {
        echo json_encode(["status" => "error", "message" => "Hanya file PDF yang diperbolehkan!"]);
        exit();
    }

    // Panggil fungsi uploadFileUser dari functions.php
    $upload_result = uploadFileUser($_FILES['file'], $id_pengajuan);

    if ($upload_result) {
        $id_dokumen = generateIdDokumen($conn, $id_pengajuan);
        $stmt = $conn->prepare("INSERT INTO tb_dokumen (id_dokumen, nama_dokumen, jenis_dokumen, file_path, id_pengajuan, id_user, create_by, status_active, create_date, change_date) VALUES (?, ?, '2', ?, ?, ?, ?, '1', NOW(), NOW())");
        $stmt->bind_param("ssssss", $id_dokumen, $deskripsi, $upload_result['path'], $id_pengajuan, $id_user, $id_user);
        $stmt->execute();
        echo json_encode(["status" => "success", "message" => "File berhasil diunggah!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal mengunggah file!"]);
    }
    exit();
}
?>

<!-- Modal Unggah Persyaratan -->
<div class="modal fade" id="unggahModal" tabindex="-1" aria-labelledby="unggahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unggahModalLabel">Unggah Persyaratan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="dropzone" id="myDropzone" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_pengajuan" value="<?= $id_pengajuan ?>">
                    <input type="hidden" name="id_user" value="<?= $id_user ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="submit-all">Unggah</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle (termasuk Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Script hapus dokumen -->
<script>
document.querySelectorAll('.hapus-btn').forEach(button => {
    button.addEventListener('click', function () {
        const form = this.closest('form');

        Swal.fire({
            title: 'Yakin mau hapus dokumen ini?',
            text: "File akan dihapus dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();  // submit form kalau user setuju
            }
        });
    });
});
</script>

<style>
   .dropzone {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: flex-start;
    border: 2px dashed #007bff;
    padding: 20px;
    border-radius: 10px;
    background: #f9f9f9;
    transition: 0.3s;
}

.dropzone:hover {
    border-color: #0056b3;
    background: #eef4ff;
}

.dz-preview {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 140px !important;
        height: 190px !important;
        position: relative;
        border-radius: 12px;
        background: #ffffff;
        padding: 12px;
        text-align: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #ddd;
    }

    .dz-preview:hover {
        transform: translateY(-3px);
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
    }

    .pdf-icon {
        width: 45px;
        height: 45px;
        margin-bottom: 10px;
    }

    .deskripsi-input {
        width: 100%;
        font-size: 12px;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        margin-top: 5px;
    }

    .action-container {
        position: absolute;
        top: 6px;
        right: 6px;
        z-index: 10;
    }

/* Tombol hapus di pojok kanan atas */
.remove-button {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    color: white;
    border: none;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
    z-index: 999; /* Pastikan tombol di atas elemen lain */
    pointer-events: auto; /* Pastikan tombol bisa diklik */
}

/* Hover efek */
.remove-button:hover {
    background: darkred;
}
.modal-backdrop.fade.show {
    display: none !important;
}
</style>

<script>
Dropzone.autoDiscover = false;

let myDropzone = new Dropzone("#myDropzone", {
    url: window.location.href,
    acceptedFiles: ".pdf",
    maxFilesize: 5, // Maksimal 5MB
    paramName: "file",
    autoProcessQueue: false,
    parallelUploads: 10,
    addRemoveLinks: false,
    clickable: true,
    thumbnailWidth: 50,
    thumbnailHeight: 50,
    init: function () {
        let dz = this;

        document.getElementById("submit-all").addEventListener("click", function () {
            if (dz.getQueuedFiles().length === 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    text: "Tidak ada file yang diunggah!",
                });
                return;
            }
            dz.processQueue();
        });

        dz.on("addedfile", function (file) {
            let filePreview = file.previewElement;
            filePreview.classList.add("custom-preview");
            filePreview.style.position = "relative";

            // Tambahkan ikon PDF
            let pdfIcon = document.createElement("img");
            pdfIcon.src = "https://cdn-icons-png.flaticon.com/512/337/337946.png";
            pdfIcon.className = "pdf-icon";

            let dzImage = filePreview.querySelector(".dz-image");
            dzImage.innerHTML = "";
            dzImage.appendChild(pdfIcon);

            // Input deskripsi
            let descriptionInput = document.createElement("input");
            descriptionInput.setAttribute("type", "text");
            descriptionInput.setAttribute("name", "descriptions[]");
            descriptionInput.setAttribute("placeholder", "Deskripsi...");
            descriptionInput.className = "form-control deskripsi-input";

            // Tombol hapus
            let removeButton = document.createElement("button");
            removeButton.className = "remove-button";
            removeButton.innerHTML = "X";
            removeButton.setAttribute("type", "button");

            removeButton.addEventListener("click", function (event) {
                event.preventDefault();
                event.stopPropagation();
                dz.removeFile(file);
                console.log("File dihapus:", file.name);
            });

            filePreview.appendChild(removeButton);
            filePreview.appendChild(descriptionInput);
        });

        dz.on("sending", function (file, xhr, formData) {
            let descriptionInput = file.previewElement.querySelector("input[name='descriptions[]']");
            formData.append("deskripsi", descriptionInput ? descriptionInput.value : "Tidak ada deskripsi");
        });

        dz.on("queuecomplete", function () {
            Swal.fire({
                icon: "success",
                title: "Sukses!",
                text: "Semua file berhasil diunggah!",
                confirmButtonText: "OK"
            }).then(() => {
                // Tutup modal secara manual
                $('#unggahModal').modal('hide');
                
                // Hapus backdrop yang mungkin tertinggal
                $('.modal-backdrop').remove();
                
                // Refresh daftar dokumen (opsional)
                $('#daftarDokumenModal').modal('show');
            });
        });

        // Kalau modal unggah ditutup, langsung redirect ke halaman status pengajuan
        $('#unggahModal').on('hidden.bs.modal', function () {
            window.location.href = "user3_statusPengajuan.php";
        });

        dz.on("error", function (file, message) {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Terjadi kesalahan saat mengunggah: " + message,
            });
        });
    }
});
</script>