<?php
include '../layout/sidebarUser.php';

// Ambil data pendidikan
$pendidikan = query("SELECT * FROM tb_pendidikan WHERE status_active = '1'");
$no = 1;

// Handle hapus data
if (isset($_GET["id_pendidikan_ini"])) {
    $id_pendidikan_ini = $_GET["id_pendidikan_ini"];
    if (hapus_pendidikan_super_admin($id_pendidikan_ini, $id_user)) { 
        echo "<script>hapus_pendidikan_super_admin_success()</script>";
    } else { 
        echo "<script>hapus_pendidikan_super_admin_gagal()</script>";
    }
}


if(isset($_POST["edit_pendidikan"])) {
    if(edit_pendidikan($_POST) > 0) { ?>
        <script>edit_pendidikan_super_admin_success()</script>
    <?php } else { ?>
        <script>edit_pendidikan_super_admin_gagal()</script>
    <?php }
}

if(isset($_POST["tambah_sekolah"])) {
    if (tambah_data_sekolah($POST) > 0) {

    }
}



if(isset($_POST["tambah_universitas"])) {
    if (tambah_data_sekolah($POST) > 0) {

    }
}

// Ambil semua jurusan berdasarkan sekolah yang tersedia
$sekolahData = [];
$rows = query("SELECT nama_pendidikan, jurusan FROM tb_pendidikan WHERE fakultas IS NULL OR fakultas = ''");

foreach ($rows as $row) {
    $nama = $row['nama_pendidikan'];
    $jurusan = $row['jurusan'];

    if (!isset($sekolahData[$nama])) {
        $sekolahData[$nama] = [];
    }

    if ($jurusan && !in_array($jurusan, $sekolahData[$nama])) {
        $sekolahData[$nama][] = $jurusan;
    }
}


// Struktur data perguruan tinggi
$universitasData = [];
$perguruan_tinggi = query("SELECT * FROM tb_pendidikan WHERE fakultas IS NOT NULL AND fakultas != '' ORDER BY nama_pendidikan ASC");
foreach ($perguruan_tinggi as $kampus) {
    $universitasData[$kampus['nama_pendidikan']][$kampus['fakultas']][] = [
        'id_pendidikan' => $kampus['id_pendidikan'],
        'jurusan' => $kampus['jurusan']
    ];
}
?>


    <style>
        /* Atur z-index untuk dropdown Select2 */
        .select2-container--open {
            z-index: 9999 !important;
        }
    </style>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Halaman Daftar Sekolah Dan Perguruan Tinggi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"></li>
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
                                    <a href="#" class="btn btn-danger btn-sm" onclick="confirm_hapus_pendidikan_super_admin('<?= $studi['id_pendidikan'] ?>')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-id="<?= $studi['id_pendidikan'] ?>"
                                        data-nama-pendidikan="<?= $studi['nama_pendidikan'] ?>"
                                        data-fakultas="<?= $studi['fakultas'] ?>"
                                        data-jurusan="<?= $studi['jurusan'] ?>"
                                        data-alamat="<?= $studi['alamat_pendidikan'] ?>"
                                        data-user = "<?= $id_user ?>">
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
    </main>


    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditPendidikan" action="" method="POST">
                        <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                        <input type="hidden" name="id_pendidikan" id="id_pendidikan_edit">
                        <input type="hidden" name="id_user" id="id_user_edit">
                        <div class="mb-3">
                            <label for="nama_pendidikan_edit" class="form-label">Nama Sekolah / Universitas</label>
                            <input type="text" class="form-control" id="nama_pendidikan_edit" name="nama_pendidikan">
                        </div>

                        <div class="mb-3" id="fakultas_group">
                            <label for="fakultas_edit" class="form-label">Fakultas</label>
                            <input type="text" class="form-control" id="fakultas_edit" name="fakultas">
                        </div>

                        <div class="mb-3">
                            <label for="jurusan_edit" class="form-label">Jurusan / Prodi</label>
                            <input type="text" class="form-control" id="jurusan_edit" name="jurusan">
                        </div>
                        <div class="mb-3">
                            <label for="alamat_pendidikan_edit" class="form-label">Alamat Pendidikan</label>
                            <textarea class="form-control" id="alamat_pendidikan_edit" name="alamat_pendidikan" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" name="edit_pendidikan" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal untuk Tambah Sekolah -->
    <div class="modal fade" id="modalTambahSekolah" tabindex="-1" aria-labelledby="modalTambahSekolahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahSekolahLabel">Tambah Sekolah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                    <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
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

                    <div class="mb-3">
                        <label for="alamat_pendidikan" class="form-label">Alamat </label>
                        <textarea name="alamat_pendidikan" id="almaat_pendidikan" class="form-control"></textarea>
                    </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" name="tambah_sekolah" class="btn btn-primary">Simpan</button>
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
                    <form action="" method="POST">
                    <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
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

                        <div class="mb-3">
                            <label for="alamat_pendidikan" class="form-label">Alamat </label>
                            <textarea name="alamat_pendidikan" id="almaat_pendidikan" class="form-control"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" name="tambah_universitas" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <?php include "../layout/footerDashboard.php" ?>

    <script>
        // Data sekolah dan universitas dari PHP
        const sekolahData = <?= json_encode($sekolahData) ?>;
        const universitasData = <?= json_encode($universitasData) ?>;
    </script>

    <!-- JavaScript untuk Modal Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Tombol yang memicu modal
                var id = button.getAttribute('data-id');
                var namaPendidikan = button.getAttribute('data-nama-pendidikan');
                var fakultas = button.getAttribute('data-fakultas');
                var jurusan = button.getAttribute('data-jurusan');
                var alamat = button.getAttribute('data-alamat');
                var user = button.getAttribute('data_user');

                // Isi nilai ke dalam form modal
                document.getElementById('id_pendidikan_edit').value = id;
                document.getElementById('nama_pendidikan_edit').value = namaPendidikan;
                document.getElementById('fakultas_edit').value = fakultas;
                document.getElementById('jurusan_edit').value = jurusan;
                document.getElementById('alamat_pendidikan_edit').value = alamat;
                document.getElementById('id_user_edit').value = user;

                // Tampilkan atau sembunyikan fakultas
                var fakultasGroup = document.getElementById('fakultas_group');
                if (fakultas === "" || fakultas === null) {
                    fakultasGroup.style.display = "none";
                } else {
                    fakultasGroup.style.display = "block";
                }
            });
        });
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
        });
</script>


<script>
        $(document).ready(function() {
             // Inisialisasi Select2 dengan opsi input manual
            $('#nama_sekolah, #jurusan_sekolah').select2({
                tags: true, // Aktifkan input manual
                placeholder: "Pilih atau ketik manual",
                allowClear: true,
                dropdownParent: $('#modalTambahSekolah') // Dropdown muncul di dalam modal
            });

            // Update jurusan berdasarkan sekolah yang dipilih
            $('#nama_sekolah').on('change', function () {
                const selectedSekolah = $(this).val();
                const jurusanSelect = $('#jurusan_sekolah');

                // Reset jurusan
                jurusanSelect.empty().trigger('change');
                $('#jurusan_sekolah_hidden').val(''); // reset hidden

                if (sekolahData[selectedSekolah]) {
                    sekolahData[selectedSekolah].forEach(jurusan => {
                        const option = new Option(jurusan, jurusan, false, false);
                        jurusanSelect.append(option);
                    });
                }

                jurusanSelect.trigger('change'); // Refresh Select2
                $('#nama_sekolah_hidden').val(selectedSekolah); // Update hidden value
            });
            
            $('#nama_sekolah').on('change', function() {
            $('#nama_sekolah_hidden').val($(this).val());
        });

            $('#jurusan_sekolah').on('change', function() {
            $('#jurusan_sekolah_hidden').val($(this).val());
        });



        
            // Inisialisasi Select2
            $('#nama_universitas, #fakultas_universitas, #jurusan_universitas').select2({
                tags: true,
                placeholder: "Pilih atau ketik manual",
                allowClear: true,
                dropdownParent: $('#modalTambahUniversitas')
            });

            // Dinamis fakultas saat universitas dipilih
            $('#nama_universitas').on('change', function () {
                const selectedUniversity = $(this).val();
                const fakultasSelect = $('#fakultas_universitas');
                const jurusanSelect = $('#jurusan_universitas');

                fakultasSelect.empty().trigger('change');
                jurusanSelect.empty().trigger('change');
                $('#fakultas_universitas_hidden').val('');
                $('#jurusan_universitas_hidden').val('');

                if (universitasData[selectedUniversity]) {
                    Object.keys(universitasData[selectedUniversity]).forEach(fakultas => {
                        const option = new Option(fakultas, fakultas, false, false);
                        fakultasSelect.append(option);
                    });
                }

                fakultasSelect.trigger('change');
                $('#nama_universitas_hidden').val(selectedUniversity);
            });

            // Dinamis jurusan saat fakultas dipilih
            $('#fakultas_universitas').on('change', function () {
                const selectedUniversity = $('#nama_universitas').val();
                const selectedFaculty = $(this).val();
                const jurusanSelect = $('#jurusan_universitas');

                jurusanSelect.empty().trigger('change');
                $('#jurusan_universitas_hidden').val('');

                if (universitasData[selectedUniversity] &&
                    universitasData[selectedUniversity][selectedFaculty]) {
                    universitasData[selectedUniversity][selectedFaculty].forEach(item => {
                        const option = new Option(item.jurusan, item.jurusan, false, false);
                        jurusanSelect.append(option);
                    });
                }

                jurusanSelect.trigger('change');
                $('#fakultas_universitas_hidden').val(selectedFaculty);
            });

            // Simpan input manual ke hidden
            $('#jurusan_universitas').on('change', function () {
                $('#jurusan_universitas_hidden').val($(this).val());
            });

            
        });
    </script>