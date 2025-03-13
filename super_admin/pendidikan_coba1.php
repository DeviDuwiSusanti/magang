<?php
include "sidebar.php";

$pendidikan = query("SELECT * FROM tb_pendidikan WHERE status_active = '1'");
$no = 1;

// Handle hapus data
if (isset($_GET["id_pendidikan_ini"])) {
    $id_pendidikan = $_GET["id_pendidikan_ini"];
    if (hapus_pendidikan_super_admin($id_pendidikan, $id_user)) { 
        echo "<script>hapus_pendidikan_super_admin_success()</script>";
    } else { 
        echo "<script>hapus_pendidikan_super_admin_gagal()</script>";
    }
}

// Handle AJAX request untuk mengambil jurusan atau fakultas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nama_pendidikan'])) {
        $nama_pendidikan = $_POST['nama_pendidikan'];
        $data = query("SELECT DISTINCT jurusan FROM tb_pendidikan WHERE nama_pendidikan = '$nama_pendidikan'");
        echo json_encode($data);
        exit;
    }

    if (isset($_POST['fakultas'])) {
        $fakultas = $_POST['fakultas'];
        $data = query("SELECT DISTINCT jurusan FROM tb_pendidikan WHERE fakultas = '$fakultas'");
        echo json_encode($data);
        exit;
    }
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
                                $sekolah = query("SELECT DISTINCT nama_pendidikan FROM tb_pendidikan WHERE fakultas IS NULL");
                                foreach ($sekolah as $s) : ?>
                                    <option value="<?= $s['nama_pendidikan'] ?>"><?= $s['nama_pendidikan'] ?></option>
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
                                $universitas = query("SELECT DISTINCT nama_pendidikan FROM tb_pendidikan WHERE fakultas IS NOT NULL");
                                foreach ($universitas as $u) : ?>
                                    <option value="<?= $u['nama_pendidikan'] ?>"><?= $u['nama_pendidikan'] ?></option>
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
            // Inisialisasi DataTable
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

            // Inisialisasi Select2 di dalam modal
            $('#modalTambahSekolah').on('shown.bs.modal', function () {
                $('#nama_sekolah').select2({
                    dropdownParent: $('#modalTambahSekolah'),
                    tags: true,
                    placeholder: "Pilih atau ketik manual",
                    allowClear: true
                });

                $('#jurusan_sekolah').select2({
                    dropdownParent: $('#modalTambahSekolah'),
                    tags: true,
                    placeholder: "Pilih atau ketik manual",
                    allowClear: true
                });
            });

            $('#modalTambahUniversitas').on('shown.bs.modal', function () {
                $('#nama_universitas').select2({
                    dropdownParent: $('#modalTambahUniversitas'),
                    tags: true,
                    placeholder: "Pilih atau ketik manual",
                    allowClear: true
                });

                $('#fakultas_universitas').select2({
                    dropdownParent: $('#modalTambahUniversitas'),
                    tags: true,
                    placeholder: "Pilih atau ketik manual",
                    allowClear: true
                });

                $('#jurusan_universitas').select2({
                    dropdownParent: $('#modalTambahUniversitas'),
                    tags: true,
                    placeholder: "Pilih atau ketik manual",
                    allowClear: true
                });
            });

            // Tampilkan modal tambah sekolah
            $('#tambahSekolah').on('click', function(e) {
                e.preventDefault();
                $('#modalTambahSekolah').modal('show');
            });

            // Tampilkan modal tambah universitas
            $('#tambahUniversitas').on('click', function(e) {
                e.preventDefault();
                $('#modalTambahUniversitas').modal('show');
            });

            // Handle perubahan pada select nama sekolah
            $('#nama_sekolah').on('change', function() {
                var namaSekolah = $(this).val();
                $('#nama_sekolah_hidden').val(namaSekolah);

                // Ambil daftar jurusan berdasarkan nama sekolah
                $.ajax({
                    url: 'pendidikan.php',
                    type: 'POST',
                    data: { nama_pendidikan: namaSekolah },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var options = '<option value="">Pilih Jurusan</option>';
                        data.forEach(function(item) {
                            options += '<option value="' + item.jurusan + '">' + item.jurusan + '</option>';
                        });
                        $('#jurusan_sekolah').html(options);
                    }
                });
            });

            // Handle perubahan pada select nama universitas
            $('#nama_universitas').on('change', function() {
                var namaUniversitas = $(this).val();
                $('#nama_universitas_hidden').val(namaUniversitas);

                // Ambil daftar fakultas berdasarkan nama universitas
                $.ajax({
                    url: 'pendidikan.php',
                    type: 'POST',
                    data: { nama_pendidikan: namaUniversitas },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var options = '<option value="">Pilih Fakultas</option>';
                        data.forEach(function(item) {
                            options += '<option value="' + item.fakultas + '">' + item.fakultas + '</option>';
                        });
                        $('#fakultas_universitas').html(options);
                    }
                });
            });

            // Handle perubahan pada select fakultas universitas
            $('#fakultas_universitas').on('change', function() {
                var fakultas = $(this).val();
                $('#fakultas_universitas_hidden').val(fakultas);

                // Ambil daftar jurusan berdasarkan fakultas
                $.ajax({
                    url: 'pendidikan.php',
                    type: 'POST',
                    data: { fakultas: fakultas },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var options = '<option value="">Pilih Jurusan</option>';
                        data.forEach(function(item) {
                            options += '<option value="' + item.jurusan + '">' + item.jurusan + '</option>';
                        });
                        $('#jurusan_universitas').html(options);
                    }
                });
            });
        });
    </script>
