<?php include "../layout/sidebarUser.php"; 
include "functions.php";

$sqlTanggal = "SELECT * FROM tb_pengajuan WHERE id_pengajuan = '$id_pengajuan'";
$queryTanggal = mysqli_query($conn, $sqlTanggal);
$rowTanggal = mysqli_fetch_assoc($queryTanggal);


if (isset($_POST['input_logbook'])) {
    $tanggal = $_POST['tanggal'];
    $kegiatan = $_POST['kegiatan'];
    $keterangan = $_POST['keterangan'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ttd = $_POST['ttd'];
    
    $uploadedFoto = uploadFoto($_FILES['gambar_kegiatan'], '../assets/img/logbook/');
    $target_file = $uploadedFoto['path'];

    $id_logbook = generateLogbookId($conn, $id_pengajuan);

        // Query INSERT dengan id_logbook yang sudah dibuat
        $sql = "INSERT INTO tb_logbook (`id_logbook`, `tanggal_logbook`, `kegiatan_logbook`, `keterangan_logbook`, `jam_mulai`, `jam_selesai`, `foto_kegiatan`, `tanda_tangan`, `id_pengajuan`, `id_user`, `create_by`) 
                VALUES ('$id_logbook', '$tanggal', '$kegiatan', '$keterangan', '$jam_mulai', '$jam_selesai', '$target_file', '$ttd', '$id_pengajuan', '$id_user', '$id_user')";

        // Cek apakah data berhasil diinput
        if (mysqli_query($conn, $sql)) {
            showAlert('Berhasil!', 'Logbook Berhasil Diinput', 'success', "logbook_daftar.php");
            exit();
        } else {
            showAlert('Gagal!', 'Logbook gagal diinput. Silakan coba lagi.', 'error');
        }    
}

?>

<div class="main-content p-4">
    <div class="container-fluid">
        <!-- Heading Dashboard -->
        <h1 class="mb-4">Unggah Logbook</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Unggah Logbook Harian</li>
            <a href="logbook_daftar.php" class="btn btn-primary">Lihat Daftar Logbook</a>
        </ol>
        <div class="dropdown-divider"></div><br><br>
        
        <form action="" class="form-profile" method="POST" enctype="multipart/form-data">
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

            <!-- Jam Pelaksanaan -->
            <div class="mb-3">
                <label for="jam_pelaksanaan" class="form-label">Jam Pelaksanaan</label>
                <div class="d-flex gap-2">
                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai">
                    <span class="align-self-center">sampai</span>
                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai">
                </div>
            </div>

             <!-- Input Gambar dan Tanda Tangan berdampingan -->
             <div class="d-flex gap-4">
                <!-- Unggah Gambar -->
                <div class="mb-3" style="flex: 1;">
                    <label for="gambar_kegiatan" class="form-label">Unggah Gambar Kegiatan (Landscape Only)</label>
                    <input type="file" class="form-control" id="gambar_kegiatan" name="gambar_kegiatan" accept="image/*">
                    <div id="preview-container" style="margin-top: 10px; max-width: 300px; max-height: 200px; overflow: hidden; display: flex; justify-content: center; align-items: center; border: 1px solid #ddd; border-radius: 5px;"></div>
                </div>
                
                <!-- Tanda Tangan -->
                <div class="mb-3" style="flex: 1;">
                    <label for="signature-pad" class="form-label">Tanda Tangan</label>
                    <canvas id="signature-pad" width="300" height="150" style="border: 1px solid #000; display: block; margin-bottom: 10px;"></canvas>
                    <button type="button" class="btn btn-danger btn-sm" id="clear-signature">Hapus Tanda Tangan</button>
                    <input type="hidden" name="ttd" id="signature-data">
                </div>
            </div>
    
            <!-- Tombol Submit -->
            <button type="submit" name="input_logbook" class="btn btn-primary edit"><i class="bi bi-floppy me-1"></i>Simpan</button>
        </form>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>

<!-- Timepicker (analog) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/clockpicker/dist/bootstrap-clockpicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/clockpicker/dist/bootstrap-clockpicker.min.js"></script>

<!-- Croppie -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script>
    // Jam analog picker
    $(document).ready(function(){
        $('#jam_mulai').clockpicker({ autoclose: true });
        $('#jam_selesai').clockpicker({ autoclose: true });
    });

    // Preview dan validasi gambar landscape
    const fileInput = document.getElementById('gambar_kegiatan');
    const previewContainer = document.getElementById('preview-container');

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
                        fileInput.value = '';
                        previewContainer.innerHTML = '';
                    }
                };
            };
            reader.readAsDataURL(file);
        }
    });
</script>


<!-- ======= VALIDASI ========== -->
<script>
$(document).ready(function() {
    $('.form-profile').on('submit', function(e) {
        e.preventDefault(); // cegah submit default

        let tanggal = $('#tanggal').val();
        let kegiatan = $('#kegiatan').val().trim();
        let keterangan = $('#keterangan').val().trim();
        let jam_mulai = $('#jam_mulai').val();
        let jam_selesai = $('#jam_selesai').val();
        let gambar = $('#gambar_kegiatan')[0].files[0];
        let ttd = $('#signature-data').val(); // Ambil tanda tangan dari hidden input
        let id_user = <?= json_encode($id_user); ?>;
        let id_pengajuan = <?= json_encode($id_pengajuan); ?>;
        let isValid = true;

        // Bersihkan pesan error sebelumnya
        $('.text-danger').remove();

        // Validasi Kegiatan
        if (kegiatan === '') {
            $('#kegiatan').after('<small class="text-danger">Kegiatan harus diisi</small>');
            isValid = false;
        }

        // Validasi Keterangan
        if (keterangan === '') {
            $('#keterangan').after('<small class="text-danger">Keterangan harus diisi</small>');
            isValid = false;
        }

        // Validasi Tanggal
        if (tanggal === '') {
            $('#tanggal').after('<small class="text-danger">Tanggal harus diisi</small>');
            isValid = false;
        }

        // Validasi Waktu (Jam Mulai dan Jam Selesai)
        if (jam_mulai === '') {
            $('#jam_mulai').after('<small class="text-danger">Jam mulai harus diisi</small>');
            isValid = false;
        }

        if (jam_selesai === '') {
            $('#jam_selesai').after('<small class="text-danger">Jam selesai harus diisi</small>');
            isValid = false;
        }

        // Validasi Jam Mulai < Jam Selesai
        if (jam_mulai && jam_selesai && jam_mulai >= jam_selesai) {
            $('#jam_selesai').after('<small class="text-danger">Jam selesai harus lebih dari jam mulai</small>');
            isValid = false;
        }

        // Validasi Gambar (harus diunggah)
        if (!gambar) {
            $('#gambar_kegiatan').after('<small class="text-danger">Gambar kegiatan harus diunggah</small>');
            isValid = false;
        } else if (gambar.size > 1048576) { // 1 MB = 1048576 bytes
            $('#gambar_kegiatan').after('<small class="text-danger">Ukuran gambar tidak boleh lebih dari 1 MB</small>');
            isValid = false;
        }

        // Validasi Tanda Tangan
        if (ttd === '') {
            $('#signature-pad').after('<small class="text-danger">Tanda tangan wajib diisi</small>');
            isValid = false;
        }

        // Jika ada error, hentikan proses
        if (!isValid) {
            return;
        }

        // Cek tanggal unik (AJAX)
        $.ajax({
            url: 'cek.php',
            type: 'POST',
            data: {
                tanggal: tanggal,
                id_user: id_user,
                id_pengajuan: id_pengajuan,
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    $('#tanggal').after('<small class="text-danger">Tanggal ini sudah digunakan</small>');
                } else {
                    // Submit form jika semua validasi lolos
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'input_logbook',
                        value: '1'
                    }).appendTo('.form-profile');
                    
                    $('.form-profile')[0].submit();
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengecek tanggal. Silakan coba lagi.');
            }
        });
    });
});

</script>

<script>
    // Inisialisasi canvas tanda tangan
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let drawing = false;

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

    document.getElementById('clear-signature').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById('signature-data').value = '';
    });

    function saveSignature() {
        const signatureData = canvas.toDataURL('image/png');
        document.getElementById('signature-data').value = signatureData;
    }
</script>