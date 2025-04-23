<?php 
    include '../layout/sidebarUser.php';
    $instansi = query("SELECT * FROM tb_instansi WHERE status_active = 1");
    $no = 1;

    if(isset($_GET["id_instansi_ini"])) {
        $id_instansi = $_GET["id_instansi_ini"];
        
        if(hapus_instansi($id_instansi, $id_user)) { ?>
            <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Hapus Data Instansi Berhasil", "super1_instansi.php"); </script>
        <?php  } else {  ?>
            <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Hapus Data Instansi Gagal", "super1_instansi.php"); </script>
        <?php  }
    }

    if(isset($_POST["tambah_instansi"])) {
        $result = tambah_instansi_super_admin($_POST);
        if ($result === 404) { ?>
            <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Id Instansi Sudah Tersimpan Didalam Database", "super1_instansi.php"); </script>
        <?php }
        else if($result > 0) { ?>
            <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Tambah Data Instansi Berhasil", "super1_instansi.php"); </script>
        <?php } else { ?>
            <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Tambah Data Instansi Gagal", "super1_instansi.php"); </script>
        <?php }
    }

    if(isset($_POST["edit_instansi"])) {
        if(edit_instansi_super_admin($_POST) > 0) { ?>
            <script> alert_berhasil_gagal_super_admin("success", "Berhasil !!", "Edit Data Instansi Berhasil", "super1_instansi.php"); </script>
        <?php } else { ?>
            <script> alert_berhasil_gagal_super_admin("error", "Gagal !!", "Edit Data Instansi Gagal", "super1_instansi.php"); </script>
        <?php }
    }
?>


<!-- Modal Preview Gambar -->
<div id="imageModalPreview" class="image-modal" onclick="closeImageModal()">
    <span class="image-modal-close">&times;</span>
    <img class="image-modal-content" id="modalPreviewImage">
</div>

<style>
    /* style for preview image */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999; /* Lebih tinggi dari modal Bootstrap */
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.85);
        justify-content: center;
        align-items: center;
    }

    .image-modal-content {
        max-width: 90%;
        max-height: 90vh;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .image-modal-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10000;
    }

    .image-modal-close:hover {
        color: #ccc;
    }
</style>


<div class="container-fluid px-4">
    <h1 class="mt-4">Halaman Daftar Instansi</h1>
</div>

<div class="container mt-5 mb-5">                        
    <!-- Tambah Data Button -->
    <div class="mb-3 text-end">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Data Instansi
        </button>
    </div>
    
    <!-- Table -->
    <div class="card ">
        <div class="card-body">
            <table id="table_instansi" class="table table-bordered table-hover text-center align-middle">
                <thead >
                    <tr>
                        <th>No.</th>
                        <th>Id Instansi</th>
                        <th>Nama Pendek</th>
                        <th>Nama Panjang</th>
                        <th>Group Instansi</th>
                        <th>Gambar Instansi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($instansi as $opd) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $opd["id_instansi"] ?></td>
                        <td><?= $opd["nama_pendek"] ?></td>
                        <td><?= $opd["nama_panjang"] ?></td>
                        <td><?= $opd["group_instansi"] ?></td>
                        <td><img src="../assets/img/instansi/<?= $opd["gambar_instansi"] ?>" alt="gambar_instansi" onclick="openImageModal(this)"></td>

                        <td class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-danger btn-sm" onclick="confirm_hapus_instansi_super_admin(<?= $opd['id_instansi'] ?>)">
                                <i class="bi bi-trash"></i>
                            </a>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                                    data-id="<?= $opd['id_instansi'] ?>" 
                                    data-nama-pendek="<?= $opd['nama_pendek'] ?>" 
                                    data-nama-panjang="<?= $opd['nama_panjang'] ?>" 
                                    data-group="<?= $opd['group_instansi'] ?>" 
                                    data-alamat="<?= $opd['alamat_instansi'] ?>" 
                                    data-deskripsi="<?= $opd['deskripsi_instansi'] ?>" 
                                    data-lokasi="<?= $opd['lokasi_instansi'] ?>" 
                                    data-telepon="<?= $opd['telepone_instansi'] ?>" 
                                    data-gambar="<?= $opd['gambar_instansi'] ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>




<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Instansi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahInstansi" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                    
                    <!-- ID Instansi -->
                    <div class="mb-3">
                        <label for="id_instansi" class="form-label">ID Instansi</label>
                        <input type="text" inputmode="numeric" maxlength="10" class="form-control" id="id_instansi" name="id_instansi" placeholder="Masukkan ID instansi" required>
                        <small id="id_instansi_warning" class="text-warning d-block mt-1" style="font-size: 12px;"></small>
                    </div>

                    <!-- Nama Pendek -->
                    <div class="mb-3">
                        <label for="nama_pendek" class="form-label">Nama Pendek Instansi</label>
                        <input type="text" maxlength="100" class="form-control" id="nama_pendek" name="nama_pendek" placeholder="Masukkan nama Pendek instansi" required>
                        <small id="nama_pendek_warning" class="text-warning d-block mt-1" style="font-size: 12px;"></small>
                    </div>

                    <!-- Nama Panjang -->
                    <div class="mb-3">
                        <label for="nama_panjang" class="form-label">Nama Panjang Instansi</label>
                        <input type="text" maxlength="255" class="form-control" id="nama_panjang" name="nama_panjang" placeholder="Masukkan nama Panjang instansi" required>
                        <small id="nama_panjang_warning" class="text-warning d-block mt-1" style="font-size: 12px;"></small>
                    </div>

                    <!-- Group -->
                    <div class="mb-3">
                        <label for="group_instansi" class="form-label">Group Instansi</label>
                        <input type="text" maxlength="100" class="form-control" id="group_instansi" name="group_instansi" placeholder="Masukkan Group instansi">
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat_instansi" class="form-label">Alamat Instansi</label>
                        <textarea class="form-control" id="alamat_instansi" name="alamat_instansi" rows="3" placeholder="Masukkan alamat instansi"></textarea>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi_instansi" class="form-label">Deskripsi Instansi</label>
                        <textarea class="form-control" id="deskripsi_instansi" name="deskripsi_instansi" rows="3" placeholder="Masukkan deskripsi instansi"></textarea>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-3">
                        <label for="lokasi_instansi" class="form-label">Lokasi Instansi</label>
                        <textarea class="form-control" id="lokasi_instansi" name="lokasi_instansi" rows="3" placeholder="Masukkan Lokasi Instansi"></textarea>
                    </div>

                    <!-- Telepon -->
                    <div class="mb-3">
                        <label for="telepone_instansi" class="form-label">Telepon Instansi</label>
                        <input type="tel" pattern="[0-9]{8,15}" inputmode="numeric" maxlength="15" class="form-control" id="telepone_instansi" name="telepone_instansi" placeholder="Masukkan nomor telepon instansi">
                    </div>

                    <!-- Upload Foto Profil -->
                    <div class="input-field">
                        <label for="image">Upload Logo / Gambar Instansi (Max 1MB)</label><br><br>
                        <div class="image-preview" id="imagePreview">
                            <img src="../assets/img/instansi/logo_kab_sidoarjo.png" id="previewImage" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;" onclick="openImageModal(this)">
                        </div>
                        <input type="file" class="input" id="image" name="gambar_instansi" accept="image/*" onchange="validateFile()">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="tambah_instansi" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Instansi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditInstansi" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" id="id_user_edit" value="<?= $id_user ?>">
                    <input type="hidden" name="id_instansi" id="id_instansi_edit">
                    <div class="mb-3">
                        <label for="nama_pendek_edit" class="form-label">Nama Pendek Instansi</label>
                        <input type="text" class="form-control" id="nama_pendek_edit" name="nama_pendek">
                    </div>
                    <div class="mb-3">
                        <label for="nama_panjang_edit" class="form-label">Nama Panjang Instansi</label>
                        <input type="text" class="form-control" id="nama_panjang_edit" name="nama_panjang">
                    </div>
                    <div class="mb-3">
                        <label for="group_instansi_edit" class="form-label">Group Instansi</label>
                        <input type="text" class="form-control" id="group_instansi_edit" name="group_instansi">
                    </div>
                    <div class="mb-3">
                        <label for="alamat_instansi_edit" class="form-label">Alamat Instansi</label>
                        <textarea class="form-control" id="alamat_instansi_edit" name="alamat_instansi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_instansi_edit" class="form-label">Deskripsi Instansi</label>
                        <textarea class="form-control" id="deskripsi_instansi_edit" name="deskripsi_instansi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi_instansi_edit" class="form-label">Lokasi Instansi</label>
                        <textarea class="form-control" id="lokasi_instansi_edit" name="lokasi_instansi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="telepone_instansi_edit" class="form-label">Telepon Instansi</label>
                        <input type="tel" class="form-control" id="telepone_instansi_edit" name="telepone_instansi">
                    </div>
                        
                    <div class="input-field">
                        <label for="gambar_instansi_edit">Upload Logo / Gambar Instansi (Max 1MB)</label><br><br>
                        <div class="image-preview" id="imagePreviewEdit">
                            <img src="../assets/img/instansi/<?= $opd["gambar_instansi"] ?>" id="previewImageEdit" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;" onclick="openImageModal(this)">
                            <input type="hidden" name="gambar_instansi_lama" id="gambar_instansi_lama" value="<?= $opd["gambar_instansi"] ?>">
                        </div>
                        <input type="file" class="input" id="gambar_instansi_edit" name="gambar_instansi" accept="image/*" onchange="validateFileEdit()">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="edit_instansi" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Tombol yang memicu modal
        var id = button.getAttribute('data-id');
        var namaPendek = button.getAttribute('data-nama-pendek');
        var namaPanjang = button.getAttribute('data-nama-panjang');
        var group = button.getAttribute('data-group');
        var alamat = button.getAttribute('data-alamat');
        var deskripsi = button.getAttribute('data-deskripsi');
        var lokasi = button.getAttribute('data-lokasi');
        var telepon = button.getAttribute('data-telepon');
        var gambar = button.getAttribute('data-gambar'); // Ambil nilai gambar lama

        // Isi nilai ke dalam form modal
        document.getElementById('id_instansi_edit').value = id;
        document.getElementById('nama_pendek_edit').value = namaPendek;
        document.getElementById('nama_panjang_edit').value = namaPanjang;
        document.getElementById('group_instansi_edit').value = group;
        document.getElementById('alamat_instansi_edit').value = alamat;
        document.getElementById('deskripsi_instansi_edit').value = deskripsi;
        document.getElementById('lokasi_instansi_edit').value = lokasi;
        document.getElementById('telepone_instansi_edit').value = telepon;

        // Tampilkan gambar lama
        if (gambar) {
            document.getElementById('previewImageEdit').src = '../assets/img/instansi/' + gambar;
            document.getElementById('gambar_instansi_lama').value = gambar; // Simpan nilai gambar lama di input hidden
        } else {
            document.getElementById('previewImageEdit').src = '../assets/img/instansi/logo_kab_sidoarjo.png'; // Gambar default jika tidak ada
            document.getElementById('gambar_instansi_lama').value = 'logo_kab_sidoarjo.png'; // Nilai default
        }
    });
}); 


function validateFile() {
        const fileInput = document.getElementById('image');
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const file = fileInput.files[0];

        if (file) {
            if (file.size > 1048576) { // 1MB = 1048576 bytes
                alert("Ukuran file terlalu besar! Maksimal 1MB.");
                fileInput.value = ""; // Reset file input
                previewImage.src = ""; // Hapus pratinjau
                previewContainer.style.display = "none";
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }


    function openImageModal(img) {
        const modal = document.getElementById("imageModalPreview");
        const modalImg = document.getElementById("modalPreviewImage");

        modal.style.display = "flex"; // make it center using flex
        modalImg.src = img.src;
    }

    function closeImageModal() {
        document.getElementById("imageModalPreview").style.display = "none";
    }



    function validateFileEdit() {
    const fileInput = document.getElementById('gambar_instansi_edit');
    const previewContainer = document.getElementById('imagePreviewEdit');
    const previewImage = document.getElementById('previewImageEdit');
    const file = fileInput.files[0];

    if (file) {
        if (file.size > 1048576) { // 1MB = 1048576 bytes
            alert("Ukuran file terlalu besar! Maksimal 1MB.");
            fileInput.value = ""; // Reset file input
            previewImage.src = "../assets/img/instansi/" + document.getElementById('gambar_instansi_lama').value; // Kembalikan ke gambar lama
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result; // Tampilkan pratinjau gambar baru
            previewContainer.style.display = "block";
        };
        reader.readAsDataURL(file);
    } else {
        previewImage.src = "../assets/img/instansi/" + document.getElementById('gambar_instansi_lama').value; // Kembalikan ke gambar lama jika tidak ada file baru
    }
}
</script>


<script>
    document.getElementById("id_instansi").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, "");
        });

    document.getElementById("telepone_instansi").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, "");
    });

    $(document).ready(function() {
        $('#table_instansi').DataTable({
            "paging" : true,
            "searching" : true,
            "ordering" : true,
            "info" : true,
            "lengthMenu" : [5, 10, 25, 50, 100],
            "columnDefs" : [
                {
                    "orderable" : false,
                    "targets" : [ 1, 2, 3, 4],
                    render: function(data, type, row) {
                        if(type === 'display' && data.length > 50) {
                            return data.substr(0, 50) + '...';
                        } return data;
                    }
                }
            ],
            "language" : {
                "search" : "Cari : ",
                "lengthMenu" : "Tampilkan _MENU_  data Per Halaman",
                "info" : "Menampilkan _START_ hingga _END_ dari _TOTAL_ Data",
                "paginate" : {
                    "first" : "Awal ",
                    "last" : " Akhir",
                    "next" : "Selanjutnya ",
                    "previous" : " Sebelumnya",
                }
            }, 

            dom : 'Blfrtip',
            buttons : [
                {
                    extend : 'pdfHtml5',
                    text : '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className : 'btn btn-danger m-2',
                    title : 'Laporan Data Instansi',
                    exportOptions : {
                        columns : [0, 1, 2, 3, 4]
                    }
                }
            ]
        });
    });
</script>


<!-- JavaScript Validasi Realtime -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const idInstansiInput = document.getElementById("id_instansi");
    const namaPendekInput = document.getElementById("nama_pendek");
    const namaPanjangInput = document.getElementById("nama_panjang");

    idInstansiInput.addEventListener("input", function () {
        const warning = document.getElementById("id_instansi_warning");
        if (this.value.length != 9) {
            warning.textContent = "ID Instansi seharusnya terdiri dari minimal 9 digit. Apakah sudah benar?";
        } else {
            warning.textContent = "";
        }
    });

    namaPendekInput.addEventListener("input", function () {
        const warning = document.getElementById("nama_pendek_warning");
        if (this.value.length > 30) {
            warning.textContent = "Nama pendek terlalu panjang. Gunakan singkatan jika memungkinkan.";
        } else {
            warning.textContent = "";
        }
    });

    namaPanjangInput.addEventListener("input", function () {
        const warning = document.getElementById("nama_panjang_warning");
        if (this.value.length < 10) {
            warning.textContent = "Nama panjang terlalu pendek. Hindari penggunaan singkatan.";
        } else {
            warning.textContent = "";
        }
    });
});
</script>