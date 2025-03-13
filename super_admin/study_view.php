<?php
include "sidebar.php";

// Fungsi untuk mengambil data sekolah dari database
function getSekolah() {
    return query("SELECT DISTINCT nama_pendidikan FROM tb_pendidikan WHERE status_active = '1'");
}

// Fungsi untuk mengambil data jurusan berdasarkan sekolah
function getJurusanBySekolah($nama_sekolah) {
    return query("SELECT DISTINCT jurusan FROM tb_pendidikan WHERE nama_pendidikan = '$nama_sekolah' AND status_active = '1'");
}

// Fungsi untuk mengambil data universitas dari database
function getUniversitas() {
    return query("SELECT DISTINCT nama_pendidikan FROM tb_pendidikan WHERE status_active = '1'");
}

// Fungsi untuk mengambil data fakultas berdasarkan universitas
function getFakultasByUniversitas($nama_universitas) {
    return query("SELECT DISTINCT fakultas FROM tb_pendidikan WHERE nama_pendidikan = '$nama_universitas' AND status_active = '1'");
}

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
                <form action="study_view.php" method="POST">
                    <div class="mb-3">
                        <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                        <div class="input-group">
                            <select class="form-select select2" id="nama_sekolah" name="nama_sekolah" required>
                                <option value="">Pilih Sekolah</option>
                                <?php foreach (getSekolah() as $sekolah) : ?>
                                    <option value="<?= $sekolah['nama_pendidikan'] ?>"><?= $sekolah['nama_pendidikan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-outline-secondary" id="tambahSekolahManual">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control mt-2" id="inputNamaSekolahManual" name="inputNamaSekolahManual" placeholder="Masukkan Nama Sekolah Baru" style="display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="jurusan_sekolah" class="form-label">Jurusan</label>
                        <div class="input-group">
                            <select class="form-select select2" id="jurusan_sekolah" name="jurusan_sekolah" required>
                                <option value="">Pilih Jurusan</option>
                            </select>
                            <button type="button" class="btn btn-outline-secondary" id="tambahJurusanManual">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control mt-2" id="inputJurusanManual" name="inputJurusanManual" placeholder="Masukkan Jurusan Baru" style="display: none;">
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
                <form action="study_view.php" method="POST">
                    <div class="mb-3">
                        <label for="nama_universitas" class="form-label">Nama Universitas</label>
                        <div class="input-group">
                            <select class="form-select select2" id="nama_universitas" name="nama_universitas" required>
                                <option value="">Pilih Universitas</option>
                                <?php foreach (getUniversitas() as $universitas) : ?>
                                    <option value="<?= $universitas['nama_pendidikan'] ?>"><?= $universitas['nama_pendidikan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-outline-secondary" id="tambahUniversitasManual">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control mt-2" id="inputNamaUniversitasManual" name="inputNamaUniversitasManual" placeholder="Masukkan Nama Universitas Baru" style="display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="fakultas_universitas" class="form-label">Fakultas</label>
                        <div class="input-group">
                            <select class="form-select select2" id="fakultas_universitas" name="fakultas_universitas" required>
                                <option value="">Pilih Fakultas</option>
                            </select>
                            <button type="button" class="btn btn-outline-secondary" id="tambahFakultasManual">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control mt-2" id="inputFakultasManual" name="inputFakultasManual" placeholder="Masukkan Fakultas Baru" style="display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="jurusan_universitas" class="form-label">Jurusan</label>
                        <div class="input-group">
                            <select class="form-select select2" id="jurusan_universitas" name="jurusan_universitas" required>
                                <option value="">Pilih Jurusan</option>
                            </select>
                            <button type="button" class="btn btn-outline-secondary" id="tambahJurusanUniversitasManual">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control mt-2" id="inputJurusanUniversitasManual" name="inputJurusanUniversitasManual" placeholder="Masukkan Jurusan Baru" style="display: none;">
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

        // Inisialisasi Select2
        $('.select2').select2({
            placeholder: "Pilih atau ketik manual",
            allowClear: true
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

        // Tombol + untuk menambahkan sekolah manual
        document.getElementById('tambahSekolahManual').addEventListener('click', function() {
            document.getElementById('inputNamaSekolahManual').style.display = 'block';
        });

        // Tombol + untuk menambahkan jurusan manual
        document.getElementById('tambahJurusanManual').addEventListener('click', function() {
            document.getElementById('inputJurusanManual').style.display = 'block';
        });

        // Tombol + untuk menambahkan universitas manual
        document.getElementById('tambahUniversitasManual').addEventListener('click', function() {
            document.getElementById('inputNamaUniversitasManual').style.display = 'block';
        });

        // Tombol + untuk menambahkan fakultas manual
        document.getElementById('tambahFakultasManual').addEventListener('click', function() {
            document.getElementById('inputFakultasManual').style.display = 'block';
        });

        // Tombol + untuk menambahkan jurusan universitas manual
        document.getElementById('tambahJurusanUniversitasManual').addEventListener('click', function() {
            document.getElementById('inputJurusanUniversitasManual').style.display = 'block';
        });

        // Load jurusan berdasarkan sekolah yang dipilih
        $('#nama_sekolah').on('change', function() {
            var nama_sekolah = $(this).val();
            if (nama_sekolah) {
                $.ajax({
                    url: 'get_jurusan.php', // Buat file ini untuk mengambil data jurusan
                    type: 'POST',
                    data: { nama_sekolah: nama_sekolah },
                    success: function(response) {
                        $('#jurusan_sekolah').html(response);
                    }
                });
            } else {
                $('#jurusan_sekolah').html('<option value="">Pilih Jurusan</option>');
            }
        });

        // Load fakultas berdasarkan universitas yang dipilih
        $('#nama_universitas').on('change', function() {
            var nama_universitas = $(this).val();
            if (nama_universitas) {
                $.ajax({
                    url: 'get_fakultas.php', // Buat file ini untuk mengambil data fakultas
                    type: 'POST',
                    data: { nama_universitas: nama_universitas },
                    success: function(response) {
                        $('#fakultas_universitas').html(response);
                    }
                });
            } else {
                $('#fakultas_universitas').html('<option value="">Pilih Fakultas</option>');
            }
        });
    });
</script>

<?php include "footer.php" ?>