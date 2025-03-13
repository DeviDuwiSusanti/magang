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
                            <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" required>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan_sekolah" class="form-label">Jurusan</label>
                            <input type="text" class="form-control" id="jurusan_sekolah" name="jurusan_sekolah" required>
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
                            <input type="text" class="form-control" id="nama_universitas" name="nama_universitas" required>
                        </div>
                        <div class="mb-3">
                            <label for="fakultas_universitas" class="form-label">Fakultas</label>
                            <input type="text" class="form-control" id="fakultas_universitas" name="fakultas_universitas" required>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan_universitas" class="form-label">Jurusan</label>
                            <input type="text" class="form-control" id="jurusan_universitas" name="jurusan_universitas" required>
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
        });
    </script>

    
<?php include "footer.php" ?>