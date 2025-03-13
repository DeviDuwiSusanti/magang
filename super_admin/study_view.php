<?php
include "sidebar.php";
$pendidikan = query("SELECT * FROM tb_pendidikan WHERE status_active = '1'");
$no = 1;

if (isset($_GET["id_pendidikan_ini"])) {
    $id_pendidikan = $_GET["id_pendidikan_ini"];
    
    if (hapus_pendidikan_super_admin($id_pendidikan, $id_user)) { 
        echo "<script>hapus_pendidikan_super_admin_success()</script>";
    } else { 
        echo "<script>hapus_pendidikan_super_admin_gagal()</script>";
    }
}
?>

<?php

if (isset($_POST['id_pendidikan'])) {
    $id_pendidikan = $_POST['id_pendidikan'];
    
    // Query untuk mendapatkan jurusan berdasarkan id_pendidikan (sekolah)
    $query = "SELECT jurusan FROM tb_pendidikan WHERE id_pendidikan = '$id_pendidikan'";
    $result = mysqli_query($conn, $query);
    
    $data = mysqli_fetch_assoc($result);
    $jurusan = explode(",", $data['jurusan']); // Misal jurusan disimpan sebagai string dipisahkan koma
    
    $options = "<option value=''>Pilih Jurusan</option>";
    foreach ($jurusan as $j) {
        $options .= "<option value='$j'>$j</option>";
    }
    
    echo $options;
}

if (isset($_POST['fakultas'])) {
    $fakultas = $_POST['fakultas'];
    
    // Query untuk mendapatkan prodi berdasarkan fakultas (universitas)
    $query = "SELECT jurusan FROM tb_pendidikan WHERE fakultas = '$fakultas'";
    $result = mysqli_query($conn, $query);
    
    $data = mysqli_fetch_assoc($result);
    $prodi = explode(",", $data['jurusan']); // Misal prodi disimpan sebagai string dipisahkan koma
    
    $options = "<option value=''>Pilih Prodi</option>";
    foreach ($prodi as $p) {
        $options .= "<option value='$p'>$p</option>";
    }
    
    echo $options;
}
?>


<?php

if (isset($_POST['id_pendidikan'])) {
    $id_pendidikan = $_POST['id_pendidikan'];
    
    // Query untuk mendapatkan fakultas berdasarkan id_pendidikan (universitas)
    $query = "SELECT fakultas FROM tb_pendidikan WHERE id_pendidikan = '$id_pendidikan'";
    $result = mysqli_query($conn, $query);
    
    $data = mysqli_fetch_assoc($result);
    $fakultas = explode(",", $data['fakultas']); // Misal fakultas disimpan sebagai string dipisahkan koma
    
    $options = "<option value=''>Pilih Fakultas</option>";
    foreach ($fakultas as $f) {
        $options .= "<option value='$f'>$f</option>";
    }
    
    echo $options;
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Sekolah / Perguruan Tinggi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Daftar Sekolah Atau Perguruan Tinggi Pengguna</li>
        </ol>
    </div>
    <div class="container mt-5 mb-5">                        
        <!-- Tambah Data Button -->
        <div class="mb-3 text-end">
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Data
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#" class="dropdown-item" id="tambahSekolah">Sekolah</a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item" id="tambahUniversitas">Perguruan Tinggi</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="table_study" class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Sekolah / Universitas</th>
                            <th>Fakultas</th>
                            <th>Jurusan / Prodi</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendidikan as $studi) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $studi["nama_pendidikan"] ?></td>
                            <td><?= $studi["fakultas"] ?></td>
                            <td><?= $studi["jurusan"] ?></td>
                            <td><?= $studi["alamat_pendidikan"] ?></td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="#" class="btn btn-danger btn-sm" onclick="confirm_hapus_pendidikan_super_admin(<?= $studi['id_pendidikan'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <a href="study_edit.php?id_pendidikan=<?= $studi["id_pendidikan"] ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal untuk Tambah Sekolah -->
<div class="modal fade" id="modalTambahSekolah" tabindex="-1" aria-labelledby="modalTambahSekolahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahSekolahLabel">Tambah Sekolah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="proses_tambah_sekolah.php" method="POST">
                    <div class="mb-3">
                        <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                        <select class="form-control select2" id="nama_sekolah" name="nama_sekolah" required>
                            <option value="">Pilih Sekolah</option>
                            <?php
                            $sekolah = query("SELECT * FROM tb_pendidikan WHERE fakultas IS NULL");
                            foreach ($sekolah as $s) : ?>
                                <option value="<?= $s['id_pendidikan'] ?>"><?= $s['nama_pendidikan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="nama_sekolah_hidden" name="nama_sekolah_hidden">
                    </div>
                    <div class="mb-3">
                        <label for="jurusan_sekolah" class="form-label">Jurusan</label>
                        <select class="form-control select2" id="jurusan_sekolah" name="jurusan_sekolah" required>
                            <option value="">Pilih Jurusan</option>
                        </select>
                        <input type="hidden" id="jurusan_sekolah_hidden" name="jurusan_sekolah_hidden">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Universitas -->
<div class="modal fade" id="modalTambahUniversitas" tabindex="-1" aria-labelledby="modalTambahUniversitasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahUniversitasLabel">Tambah Universitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="proses_tambah_universitas.php" method="POST">
                    <div class="mb-3">
                        <label for="nama_universitas" class="form-label">Nama Universitas</label>
                        <select class="form-control select2" id="nama_universitas" name="nama_universitas" required>
                            <option value="">Pilih Universitas</option>
                            <?php
                            $universitas = query("SELECT * FROM tb_pendidikan WHERE fakultas IS NOT NULL");
                            foreach ($universitas as $u) : ?>
                                <option value="<?= $u['id_pendidikan'] ?>"><?= $u['nama_pendidikan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="nama_universitas_hidden" name="nama_universitas_hidden">
                    </div>
                    <div class="mb-3">
                        <label for="fakultas_universitas" class="form-label">Fakultas</label>
                        <select class="form-control select2" id="fakultas_universitas" name="fakultas_universitas" required>
                            <option value="">Pilih Fakultas</option>
                        </select>
                        <input type="hidden" id="fakultas_universitas_hidden" name="fakultas_universitas_hidden">
                    </div>
                    <div class="mb-3">
                        <label for="jurusan_universitas" class="form-label">Jurusan</label>
                        <select class="form-control select2" id="jurusan_universitas" name="jurusan_universitas" required>
                            <option value="">Pilih Jurusan</option>
                        </select>
                        <input type="hidden" id="jurusan_universitas_hidden" name="jurusan_universitas_hidden">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table_study').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [5, 10, 25, 50, 100],
            "columnDefs": [{"orderable": false, "targets": [2, 3, 4, 5]}],
            "language": {
                "search": "Cari : ",
                "lengthMenu": "Tampilkan _MENU_ data Per Halaman",
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ Data",
                "paginate": {
                    "first": "Awal ",
                    "last": " Akhir",
                    "next": "Selanjutnya ",
                    "previous": " Sebelumnya",
                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className: 'btn btn-danger m-2',
                    title: 'Laporan Data Study User',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ]
        });

        // Tampilkan modal tambah sekolah
        document.getElementById('tambahSekolah').addEventListener('click', function(e) {
            e.preventDefault();
            $('#modalTambahSekolah').modal('show');
        });

        // Tampilkan modal tambah universitas
        document.getElementById('tambahUniversitas').addEventListener('click', function(e) {
            e.preventDefault();
            $('#modalTambahUniversitas').modal('show');
        });

        // Inisialisasi Select2
        $('.select2').select2({
            tags: true,
            placeholder: "Pilih atau ketik manual",
            allowClear: true
        });

        // Atur z-index dropdown Select2 agar lebih tinggi dari modal Bootstrap
        $('.select2-container--open').css('z-index', '9999');

        // Handle perubahan nama sekolah
        $('#nama_sekolah').on('change', function() {
            var id_pendidikan = $(this).val();
            $('#nama_sekolah_hidden').val(id_pendidikan);

            // Ambil daftar jurusan berdasarkan id_pendidikan
            $.ajax({
                url: 'study_view.php',
                type: 'POST',
                data: { id_pendidikan: id_pendidikan },
                success: function(response) {
                    $('#jurusan_sekolah').html(response);
                    $('#jurusan_sekolah').trigger('change');
                }
            });
        });

        // Handle perubahan nama universitas
        $('#nama_universitas').on('change', function() {
            var id_pendidikan = $(this).val();
            $('#nama_universitas_hidden').val(id_pendidikan);

            // Ambil daftar fakultas berdasarkan id_pendidikan
            $.ajax({
                url: 'study_view.php',
                type: 'POST',
                data: { id_pendidikan: id_pendidikan },
                success: function(response) {
                    $('#fakultas_universitas').html(response);
                    $('#fakultas_universitas').trigger('change');
                }
            });
        });

        // Handle perubahan fakultas
        $('#fakultas_universitas').on('change', function() {
            var fakultas = $(this).val();
            $('#fakultas_universitas_hidden').val(fakultas);

            // Ambil daftar jurusan berdasarkan fakultas
            $.ajax({
                url: 'get_jurusan.php',
                type: 'POST',
                data: { fakultas: fakultas },
                success: function(response) {
                    $('#jurusan_universitas').html(response);
                    $('#jurusan_universitas').trigger('change');
                }
            });
        });
    });
</script>

<style>
    /* Atur z-index dropdown Select2 agar lebih tinggi dari modal Bootstrap */
    .select2-container--open {
        z-index: 9999 !important;
    }
</style>

<?php include "footer.php" ?>