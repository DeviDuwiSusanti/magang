<?php
include "../layout/sidebarUser.php";
include '../koneksi.php';
include "functions.php";

// Pastikan id_pengajuan ada di session
if (isset($_GET['id_pengajuan'])) {
    $_SESSION['id_pengajuan'] = $_GET['id_pengajuan'];
}
$id_pengajuan = $_SESSION['id_pengajuan'] ?? '';

// Query untuk mendapatkan daftar dokumen dengan jenis 'persyaratan' yang sudah diunggah
$stmt = $conn->prepare("SELECT * FROM tb_dokumen WHERE id_user = ? AND jenis_dokumen = '2' AND id_pengajuan = ? AND status_active = 1");
$stmt->bind_param("ss", $id_user, $id_pengajuan);
$stmt->execute();
$result = $stmt->get_result();

// Proses hapus file
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['hapus_laporan'])) {
    $id_dokumen = $_POST['id_dokumen'];

    // Ambil file_path berdasarkan id_dokumen
    $stmt_get = $conn->prepare("SELECT file_path, id_user FROM tb_dokumen WHERE id_dokumen = ?");
    $stmt_get->bind_param("s", $id_dokumen);
    $stmt_get->execute();
    $result_get = $stmt_get->get_result();
    $file_data = $result_get->fetch_assoc();

    // Pastikan hanya user yang mengunggah yang bisa menghapus
    if ($file_data && $file_data['id_user'] == $id_user) {
        $file_path = $file_data['file_path'];

        // Hapus file fisik jika ada
        if (!empty($file_path) && file_exists($file_path)) {
            unlink($file_path);
        }

        // Update status_active menjadi 0 di database
        $stmt_update = $conn->prepare("UPDATE tb_dokumen SET status_active = 0 WHERE id_dokumen = ?");
        $stmt_update->bind_param("s", $id_dokumen);
        
        if ($stmt_update->execute()) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Laporan berhasil dihapus!',
                }).then(() => { window.location.href = 'persyaratan_daftar.php'; });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menghapus laporan!',
                });
            </script>";
        }
    }
}
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Daftar Persyaratan yang Telah Diunggah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Dokumen Persyaratan</li>
        </ol>
        <div class="mb-4 dropdown-divider"></div>

        <div class="mb-4 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#unggahModal">
                <i class="bi bi-upload me-1"></i> Unggah Persyaratan Baru
            </button>
        </div>

        <div class="table-responsive-sm">
            <table id="myTable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen</th>
                        <th>Jenis Dokumen</th>
                        <th>Tanggal Unggah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank"> <?= htmlspecialchars($row['nama_dokumen']) ?></a></td>
                            <td>Persyaratan</td>
                            <td><?= htmlspecialchars($row['create_date']) ?></td>
                            <td class="text-center">
                                <?php if ($row['id_user'] == $id_user): ?>
                                    <form method="POST">
                                        <input type="hidden" name="id_dokumen" value="<?= $row['id_dokumen'] ?>">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="konfirmasiHapus(this)">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                        <input type="hidden" name="hapus_laporan" value="1">
                                    </form>

                                    <!-- Tambahkan SweetAlert -->
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        function konfirmasiHapus(button) {
                                            Swal.fire({
                                                title: "Apakah Anda yakin?",
                                                text: "Laporan yang dihapus tidak dapat dikembalikan!",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#d33",
                                                cancelButtonColor: "#3085d6",
                                                confirmButtonText: "Ya, hapus!",
                                                cancelButtonText: "Batal"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    button.closest("form").submit();
                                                }
                                            });
                                        }
                                    </script>

                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Proses Upload -->
<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $deskripsi = $_POST['deskripsi'] ?? 'Tidak ada deskripsi';
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    if ($file_extension !== "pdf") {
        echo json_encode(["status" => "error", "message" => "Hanya file PDF yang diperbolehkan!"]);
        exit();
    }
    
    $upload_dir = "../assets/doc/"; 
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_path = $upload_dir . uniqid() . "_" . basename($file_name);
    
    if (move_uploaded_file($file_tmp, $file_path)) {
        $id_dokumen = generateIdDokumen($conn, $id_pengajuan);
        $stmt = $conn->prepare("INSERT INTO tb_dokumen (id_dokumen, nama_dokumen, jenis_dokumen, file_path, id_pengajuan, id_user, create_by, status_active, create_date, change_date) VALUES (?, ?, '2', ?, ?, ?, ?, '1', NOW(), NOW())");
        $stmt->bind_param("ssssss", $id_dokumen, $deskripsi, $file_path, $id_pengajuan, $id_user, $id_user);
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
                window.location.href = "persyaratan_daftar.php";
            });
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


<?php include "../layout/footerDashboard.php"; ?>