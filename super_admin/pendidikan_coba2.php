<?php
include "sidebar.php";

// Ambil data pendidikan
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

// Struktur data sekolah
$sekolahData = [];
$sekolah = query("SELECT * FROM tb_pendidikan WHERE fakultas IS NULL");
foreach ($sekolah as $school) {
    $sekolahData[$school['nama_pendidikan']][] = [
        'id_pendidikan' => $school['id_pendidikan'],
        'jurusan' => $school['jurusan']
    ];
}

// Struktur data perguruan tinggi
$universitasData = [];
$perguruan_tinggi = query("SELECT * FROM tb_pendidikan WHERE fakultas IS NOT NULL");
foreach ($perguruan_tinggi as $kampus) {
    $universitasData[$kampus['nama_pendidikan']][$kampus['fakultas']][] = [
        'id_pendidikan' => $kampus['id_pendidikan'],
        'jurusan' => $kampus['jurusan']
    ];
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
        // Data sekolah dan universitas dari PHP
        const sekolahData = <?= json_encode($sekolahData) ?>;
        const universitasData = <?= json_encode($universitasData) ?>;
    </script>

    

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

            // Tampilkan modal tambah sekolah
            document.getElementById("tambahSekolah").addEventListener("click", function(e) {
                e.preventDefault();
                new bootstrap.Modal(document.getElementById('modalTambahSekolah')).show();
            });

            // Tampilkan modal tambah universitas
            document.getElementById("tambahUniversitas").addEventListener("click", function(e) {
                e.preventDefault();
                new bootstrap.Modal(document.getElementById('modalTambahUniversitas')).show();
            });

            // Event listener untuk pilihan sekolah
            document.getElementById("nama_sekolah").addEventListener("change", function() {
                let jurusanSelect = document.getElementById("jurusan_sekolah");
                let selectedSchool = this.value;

                // Kosongkan opsi sebelumnya
                jurusanSelect.innerHTML = '<option value="">Pilih Jurusan</option>';

                if (selectedSchool && sekolahData[selectedSchool]) {
                    sekolahData[selectedSchool].forEach(item => {
                        let option = new Option(item.jurusan, item.id_pendidikan);
                        jurusanSelect.appendChild(option);
                    });
                }
            });

            // Event listener untuk pilihan universitas
            document.getElementById("nama_universitas").addEventListener("change", function() {
                let facultySelect = document.getElementById("fakultas_universitas");
                let selectedUniversity = this.value;

                // Kosongkan opsi sebelumnya
                facultySelect.innerHTML = '<option value="">Pilih Fakultas</option>';

                if (selectedUniversity && universitasData[selectedUniversity]) {
                    Object.keys(universitasData[selectedUniversity]).forEach(fakultas => {
                        let option = new Option(fakultas, fakultas);
                        facultySelect.appendChild(option);
                    });
                }
            });

            // Event listener untuk pilihan fakultas
            document.getElementById("fakultas_universitas").addEventListener("change", function() {
                let prodiSelect = document.getElementById("jurusan_universitas");
                let selectedUniversity = document.getElementById("nama_universitas").value;
                let selectedFaculty = this.value;

                // Kosongkan opsi sebelumnya
                prodiSelect.innerHTML = '<option value="">Pilih Jurusan</option>';

                if (selectedUniversity && selectedFaculty && universitasData[selectedUniversity][selectedFaculty]) {
                    universitasData[selectedUniversity][selectedFaculty].forEach(item => {
                        let option = new Option(item.jurusan, item.id_pendidikan);
                        prodiSelect.appendChild(option);
                    });
                }
            });
        });
    </script>
