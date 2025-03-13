<?php include "../layout/sidebarUser.php";
include "functions.php"; 

if (ISSET($_GET['id_pengajuan'])){
    $id_pengajuan = $_GET['id_pengajuan'];
};

// ============== QUERY TAMBAH LOGBOOK ==================

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['input_logbook'])) {
    inputLogbook($_POST, $_FILES, $id_pengajuan, $id_user);
}

// =============== QUERY UPDATE ====================
$id_logbook_edit = null;
$dataLama = null;

if (ISSET($_GET['id_logbook_edit'])){
    $id_logbook_edit = $_GET['id_logbook_edit'];
    
    $sql = "SELECT * FROM tb_logbook WHERE id_logbook = '$id_logbook_edit'";
    $query = mysqli_query($conn, $sql);
    $dataLama = mysqli_fetch_assoc($query);
    $ttd = $dataLama['tanda_tangan'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && ISSET($_POST['update_logbook'])){
    updateLogbook($_POST, $_FILES, $id_user, $id_logbook_edit, $dataLama);
}


$no = 1;

// akses status_pengajuan
$sql3 = "SELECT status_pengajuan FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
$query3 = mysqli_query($conn, $sql3);
$status_pengajuan = mysqli_fetch_assoc($query3)['status_pengajuan'];

// akses anggota
$sql_anggota = "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_pengajuan = '$id_pengajuan' AND pu.id_user = u.id_user  AND u.status_active = '1'";
$query_anggota = mysqli_query($conn, $sql_anggota);

// HAPUS LOGBOOK
if (isset($_GET['id_logbook_hapus'])) {
    hapusLogbook($id_user);
}

?>
<!-- ================= TABEL DAFTAR LOGBOOK ============== -->
<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Logbook</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Logbook Harian</li>
        </ol>

        <?php 
        if ($ketua){?>
            <div class="dropdown">
                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                    Lihat Logbook Anggota
                </button>
                <ul class="dropdown-menu">
                    <?php
                    while ($row_anggota = mysqli_fetch_assoc($query_anggota)){?>
                        <li><a class="dropdown-item" href="?id_user_anggota=<?= $row_anggota['id_user'] ?>#logbook_container"><?= $row_anggota['nama_user'] ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        <?php
        }
        ?>
        
        <div class="mb-4 dropdown-divider"></div>
        
        <div class="mb-4 text-end" id="logbook_container">
            <?php
                $id_user_anggota = isset($_GET['id_user_anggota']) && $_GET['id_user_anggota'] != $id_user ? $_GET['id_user_anggota'] : $id_user;
                if ($status_pengajuan != '5' && $id_user_anggota == $id_user){
                    ?>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahLogbook">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Logbook
                </button>

                <a href="print.php?id_pengajuan=<?= $id_pengajuan ?>" class="btn btn-success">
                    <i class="bi bi-printer me-1"></i>
                    Cetak
                </a>
            <?php          
            }
            ?>
        </div>
       
        <div class="table-responsive-sm" >     
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Keterangan</th>
                            <th>Waktu</th>
                            <th>Foto Kegiatan</th>
                            <th>TTD</th>
                            <?php 
                            if ($status_pengajuan != '5' && $id_user_anggota == $id_user){?> 
                                <th>Aksi</th> 
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $logbook = getLogbook($conn, $id_pengajuan, $id_user_anggota);
                        while ($row = mysqli_fetch_assoc($logbook)){?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= formatTanggalLengkapIndonesia($row['tanggal_logbook']) ?></td>
                                <td><?= $row['kegiatan_logbook'] ?></td>
                                <td><?= $row['keterangan_logbook'] ?></td>
                                <td>
                                    <?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?>
                                </td>

                                <td><img src="<?= $row['foto_kegiatan'] ?>" alt=""></td>
                                <td><img src="<?= $row['tanda_tangan'] ?>" alt="TTD"></td>
                                <?php
                                if ($status_pengajuan != '5' && $id_user_anggota == $id_user){?> 
                                <td>
                                    <a href="?id_logbook_edit=<?= $row['id_logbook'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <a href="?id_logbook_hapus=<?= $row['id_logbook'] ?>" 
                                    onclick="return confirm('Anda yakin akan menghapus Logbook ini?')"
                                    class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php
                                }
                        $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include "../layout/footerDashboard.php" ?>


<!-- ============== Modal Tambah Logbook =============-->
<?php
$sqlTanggal = "SELECT * FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
$queryTanggal = mysqli_query($conn, $sqlTanggal);
$rowTanggal = mysqli_fetch_assoc($queryTanggal);
?>
<div class="modal fade" id="modalTambahLogbook" tabindex="-1" aria-labelledby="logbookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Menambah class modal-lg untuk memperlebar modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logbookModalLabel">Tambah Logbook</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="form_tambahLogbook" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" min="<?= $rowTanggal['tanggal_mulai'] ?>" max="<?= $rowTanggal['tanggal_selesai'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="kegiatan" class="form-label">Kegiatan</label>
                        <input type="text" class="form-control" id="kegiatan" name="kegiatan">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="jam_pelaksanaan" class="form-label">Jam Pelaksanaan</label>
                        <div class="d-flex gap-2">
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai">
                            <span class="align-self-center">sampai</span>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai">
                        </div>
                    </div>
                    <div class="d-flex gap-4">
                        <div class="mb-3" style="flex: 1;">
                            <label for="gambar_kegiatan" class="form-label">Unggah Gambar Kegiatan (Landscape Only)</label>
                            <input type="file" class="form-control" id="gambar_kegiatan" name="gambar_kegiatan" accept="image/*">
                            <div id="preview-container" style="margin-top: 10px; max-width: 300px; max-height: 200px; overflow: hidden; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; border-radius: 5px;"></div>
                        </div>
                        <div class="mb-3" style="flex: 1;">
                            <label for="signature-pad" class="form-label">Tanda Tangan</label>
                            <canvas id="signature-pad" width="400" height="200" style="border: 1px solid #000; display: block; margin-bottom: 10px;"></canvas>
                            <button type="button" class="btn btn-danger btn-sm" id="clear-signature">Hapus Tanda Tangan</button>
                            <input type="hidden" name="ttd" id="signature-data">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="input_logbook" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ====================== Modal Edit Logbook ================= -->

<div class="modal fade" id="modalEditLogbook" tabindex="-1" aria-labelledby="editLogbookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLogbookModalLabel">Edit Logbook</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="form_editLogbook" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" value="<?= $dataLama['tanggal_logbook'] ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_kegiatan" class="form-label">Kegiatan</label>
                        <input type="text" class="form-control" id="edit_kegiatan" name="kegiatan" value="<?= $dataLama['kegiatan_logbook'] ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"><?= $dataLama['keterangan_logbook'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="jam_pelaksanaan" class="form-label">Jam Pelaksanaan</label>
                        <div class="d-flex gap-2">
                            <input type="time" class="form-control"  id="edit_jam_mulai" name="jam_mulai" value="<?= $dataLama['jam_mulai'] ?>">
                            <span class="align-self-center">sampai</span>
                            <input type="time" class="form-control"  id="edit_jam_selesai" name="jam_selesai" value="<?= $dataLama['jam_selesai'] ?>">
                        </div>
                    </div>

                    <div class="d-flex gap-4">
                        <div class="mb-3" style="flex: 1;">
                            <label for="gambar_kegiatan" class="form-label">Unggah Gambar Kegiatan (Landscape Only)</label>
                            <!-- Modal Edit Logbook -->
                            <input type="file" class="form-control" id="edit_gambar_kegiatan" name="gambar_kegiatan" accept="image/*">
                            <div id="edit_preview_container" style="margin-top: 10px; max-width: 300px; max-height: 200px; overflow: hidden; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; border-radius: 5px;">
                                <img src="<?= $dataLama['foto_kegiatan'] ?>" alt="Gambar Kegiatan Lama" style="max-width:100%; height:auto;">
                            </div>
                        </div>
                        <div class="mb-3" style="flex: 1;">
                            <label for="edit_signature_pad" class="form-label">Tanda Tangan</label>
                            <canvas id="edit_signature_pad" width="400" height="200" style="border: 1px solid #000; display: block; margin-bottom: 10px;"></canvas>
                            <button type="button" class="btn btn-danger btn-sm" id="edit_clear_signature">Hapus Tanda Tangan</button>
                            <input type="hidden" name="ttd" id="edit_signature_data">
                        </div>
                    </div>


                    <!-- Tombol Submit -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="update_logbook" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if ($id_logbook_edit): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('modalEditLogbook'));
            modal.show();
            
            // Saat modal ditutup, hapus query string id_logbook_edit dan reload halaman
            const modalElement = document.getElementById('modalEditLogbook');
            modalElement.addEventListener('hidden.bs.modal', function () {
                const url = new URL(window.location.href);
                url.searchParams.delete('id_logbook_edit');
                window.location.href = url.toString();
            });
        });
    </script>
<?php endif; ?>



<!--  ==================== Timepicker (analog) =================-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/clockpicker/dist/bootstrap-clockpicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/clockpicker/dist/bootstrap-clockpicker.min.js"></script>

<!-- Croppie -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<!-- ===================== Jam analog picker ==================-->
<script>
    $(document).ready(function(){
        $('#jam_mulai').clockpicker({ autoclose: true });
        $('#jam_selesai').clockpicker({ autoclose: true });

        $('#edit_jam_mulai').clockpicker({ autoclose: true });
        $('#edit_jam_selesai').clockpicker({ autoclose: true });

    });

    // Fungsi untuk validasi dan preview gambar landscape
    function handleImagePreview(fileInputId, previewContainerId) {
        const fileInput = document.getElementById(fileInputId);
        const previewContainer = document.getElementById(previewContainerId);

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = function () {
                        if (img.width >= img.height) {
                            previewContainer.innerHTML = `<img src="${img.src}" alt="Preview" style="max-width:100%; height:auto;">`;
                        } else {
                            alert('Hanya gambar landscape yang diperbolehkan.');
                            fileInput.value = ''; // reset input
                            previewContainer.innerHTML = ''; // kosongkan preview
                        }
                    };
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Panggil fungsi untuk masing-masing modal
    handleImagePreview('gambar_kegiatan', 'preview-container'); // Tambah logbook
    handleImagePreview('edit_gambar_kegiatan', 'edit_preview_container'); // Edit logbook
</script>

<!-- =============== Inisialisasi canvas tanda tangan =======================-->
<script>
    // Inisialisasi canvas tanda tangan
    const isEditMode = <?= isset($id_logbook_edit) ? 'true' : 'false' ?>;
    const canvas = document.getElementById(isEditMode ? 'edit_signature_pad' : 'signature-pad');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    // Jika dalam mode edit, tampilkan tanda tangan sebelumnya
    <?php if (isset($id_logbook_edit) && !empty($ttd)): ?>
        const previousSignature = <?= json_encode($ttd) ?>;
        if (previousSignature) {
            const img = new Image();
            img.src = previousSignature;
            img.onload = () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Bersihkan canvas
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height); // Gambar tanda tangan sebelumnya
                document.getElementById(isEditMode ? 'edit_signature_data' : 'signature-data').value = previousSignature;
            };
        }
    <?php endif; ?>

    // Event untuk menggambar tanda tangan
    canvas.addEventListener('mousedown', () => drawing = true);
    canvas.addEventListener('mouseup', () => {
        drawing = false;
        ctx.beginPath();
        saveSignature();
    });
    canvas.addEventListener('mousemove', draw);

    function draw(e) {
        if (!drawing) return;
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = 'black';
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    }

    // Hapus tanda tangan
    document.getElementById(isEditMode ? 'edit_clear_signature' : 'clear-signature').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById(isEditMode ? 'edit_signature_data' : 'signature-data').value = '';
    });

    // Simpan tanda tangan ke hidden input
    function saveSignature() {
        const signatureData = canvas.toDataURL('image/png');
        document.getElementById(isEditMode ? 'edit_signature_data' : 'signature-data').value = signatureData;
    }
</script>


<!-- ======= VALIDASI LOGBOOK========== -->
<script>
$(document).ready(function() {
    /* ============================
       Fungsi Validasi Form Logbook
       ============================ */
    function validateLogbook(formId, isEdit) {
        var form = $(formId);
        var tanggal = form.find('[name="tanggal"]').val();
        var kegiatan = form.find('[name="kegiatan"]').val().trim();
        var keterangan = form.find('[name="keterangan"]').val().trim();
        var jam_mulai = form.find('[name="jam_mulai"]').val();
        var jam_selesai = form.find('[name="jam_selesai"]').val();
        var gambarElem = form.find('[name="gambar_kegiatan"]')[0];
        var gambar = gambarElem ? gambarElem.files[0] : null;
        var ttd = form.find('[name="ttd"]').val();
        var isValid = true;
        
        // Bersihkan error sebelumnya
        form.find('.text-danger').remove();

        // Validasi Kegiatan
        if (kegiatan === '') {
            form.find('[name="kegiatan"]').after('<small class="text-danger">Kegiatan harus diisi</small>');
            isValid = false;
        }
        // Validasi Keterangan
        if (keterangan === '') {
            form.find('[name="keterangan"]').after('<small class="text-danger">Keterangan harus diisi</small>');
            isValid = false;
        }
        // Validasi Tanggal
        if (tanggal === '') {
            form.find('[name="tanggal"]').after('<small class="text-danger">Tanggal harus diisi</small>');
            isValid = false;
        }
        // Validasi Waktu
        if (jam_mulai === '') {
            form.find('[name="jam_mulai"]').after('<small class="text-danger">Jam mulai harus diisi</small>');
            isValid = false;
        }
        if (jam_selesai === '') {
            form.find('[name="jam_selesai"]').after('<small class="text-danger">Jam selesai harus diisi</small>');
            isValid = false;
        }
        if (jam_mulai && jam_selesai && jam_mulai >= jam_selesai) {
            form.find('[name="jam_selesai"]').after('<small class="text-danger">Jam selesai harus lebih dari jam mulai</small>');
            isValid = false;
        }
        // Validasi Gambar:
        // Mode tambah: wajib diunggah.
        // Mode edit: jika diunggah, ukurannya tidak boleh > 1MB.
        if (!isEdit) {
            if (!gambar) {
                form.find('[name="gambar_kegiatan"]').after('<small class="text-danger">Gambar kegiatan harus diunggah</small>');
                isValid = false;
            } else if (gambar.size > 1048576) {
                form.find('[name="gambar_kegiatan"]').after('<small class="text-danger">Ukuran gambar tidak boleh lebih dari 1 MB</small>');
                isValid = false;
            }
        } else {
            if (gambar && gambar.size > 1048576) {
                form.find('[name="gambar_kegiatan"]').after('<small class="text-danger">Ukuran gambar tidak boleh lebih dari 1 MB</small>');
                isValid = false;
            }
        }
        // Validasi Tanda Tangan
        if (ttd === '') {
            form.find('#signature-pad, #edit_signature_pad').after('<small class="text-danger">Tanda tangan wajib diisi</small>');
            isValid = false;
        }
        
        return isValid;
    }
    
    /* ================================
       Event Submit untuk Form Tambah Logbook
       ================================ */
    $('#form_tambahLogbook').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        if (!validateLogbook('#form_tambahLogbook', false)) {
            return;
        }
        // Cek tanggal unik via AJAX (untuk tambah)
        var tanggal = form.find('[name="tanggal"]').val();
        var id_user = <?= json_encode($id_user); ?>;
        var id_pengajuan = <?= json_encode($id_pengajuan); ?>;
        $.ajax({
            url: 'cek.php',
            type: 'POST',
            data: {
                tanggal: tanggal,
                id_user: id_user,
                id_pengajuan: id_pengajuan
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    form.find('[name="tanggal"]').after('<small class="text-danger">Tanggal ini sudah digunakan</small>');
                } else {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'input_logbook',
                        value: '1'
                    }).appendTo(form);
                    form[0].submit();
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengecek tanggal. Silakan coba lagi.');
            }
        });
    });
    
    /* ================================
       Event Submit untuk Form Edit Logbook
       ================================ */
    $('#form_editLogbook').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        if (!validateLogbook('#form_editLogbook', true)) {
            return;
        }
        // Ambil tanggal lama dari data logbook yang asli (dikirim dari PHP)
        var tanggal_lama = <?= json_encode($dataLama['tanggal_logbook'] ?? '') ?>;
        var tanggal = form.find('[name="tanggal"]').val();
        var id_user = <?= json_encode($id_user); ?>;
        var id_pengajuan = <?= json_encode($id_pengajuan); ?>;
        $.ajax({
            url: 'cek.php',
            type: 'POST',
            data: {
                tanggal: tanggal,
                id_user: id_user,
                id_pengajuan: id_pengajuan,
                tanggal_lama: tanggal_lama
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    form.find('[name="tanggal"]').after('<small class="text-danger">Tanggal ini sudah digunakan</small>');
                } else {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'update_logbook',
                        value: '1'
                    }).appendTo(form);
                    form[0].submit();
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengecek tanggal. Silakan coba lagi.');
            }
        });
    });
});
</script>

