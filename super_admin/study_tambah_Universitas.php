<?php
include "sidebar.php";


// Ambil daftar universitas dari database (tanpa duplikat)
$query_universitas = "SELECT DISTINCT nama_pendidikan FROM tb_pendidikan WHERE fakultas IS NOT NULL AND fakultas != ''";
$result_universitas = mysqli_query($conn, $query_universitas);

// Jika request AJAX untuk mengambil fakultas
if (isset($_POST['nama_universitas'])) {
    $nama_universitas = $_POST['nama_universitas'];
    $query_fakultas = "SELECT DISTINCT fakultas FROM tb_pendidikan WHERE nama_pendidikan = '$nama_universitas' AND fakultas IS NOT NULL";
    $result_fakultas = mysqli_query($conn, $query_fakultas);

    $options = '<option value="">Pilih Fakultas</option>';
    while ($row = mysqli_fetch_assoc($result_fakultas)) {
        $options .= '<option value="' . $row['fakultas'] . '">' . $row['fakultas'] . '</option>';
    }

    echo $options;
    exit; // Hentikan eksekusi script selanjutnya
}

// Jika request AJAX untuk mengambil program studi
if (isset($_POST['nama_fakultas'])) {
    $nama_fakultas = $_POST['nama_fakultas'];
    $query_prodi = "SELECT DISTINCT jurusan FROM tb_pendidikan WHERE fakultas = '$nama_fakultas'";
    $result_prodi = mysqli_query($conn, $query_prodi);

    $options = '<option value="">Pilih Program Studi</option>';
    while ($row = mysqli_fetch_assoc($result_prodi)) {
        $options .= '<option value="' . $row['jurusan'] . '">' . $row['jurusan'] . '</option>';
    }

    echo $options;
    exit; // Hentikan eksekusi script selanjutnya
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Data Universitas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Halaman Tambah Data Universitas</li>
        </ol>
    </div>

    <div class="container mt-5">
        <form action="study_view.php" class="form-instansi" method="POST" enctype="multipart/form-data">
            <!-- Nama Universitas -->
            <div class="mb-3">
                <label for="nama_universitas" class="form-label">Nama Universitas</label>
                <select class="form-control select2" id="nama_universitas" name="nama_universitas" required>
                    <option value="">Pilih Universitas</option>
                    <?php while ($row = mysqli_fetch_assoc($result_universitas)): ?>
                        <option value="<?php echo $row['nama_pendidikan']; ?>"><?php echo $row['nama_pendidikan']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#tambahUniversitasModal">Tambah Universitas Baru</button>
            </div>
            <!-- Nama Fakultas -->
            <div class="mb-3">
                <label for="fakultas" class="form-label">Fakultas</label>
                <select class="form-control select2" id="fakultas" name="fakultas" required>
                    <option value="">Pilih Fakultas</option>
                </select>
                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#tambahFakultasModal">Tambah Fakultas Baru</button>
            </div>
            <!-- Nama Program Studi -->
            <div class="mb-3">
                <label for="jurusan_prodi" class="form-label">Program Studi</label>
                <select class="form-control select2" id="jurusan_prodi" name="jurusan_prodi" required>
                    <option value="">Pilih Program Studi</option>
                </select>
                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#tambahProdiModal">Tambah Program Studi Baru</button>
            </div>
            <!-- Alamat Universitas -->
            <div class="mb-3">
                <label for="alamat_study" class="form-label">Alamat Universitas</label>
                <textarea class="form-control" name="alamat_study" id="alamat_study" placeholder="Masukkan Alamat Universitas"></textarea>
            </div>
            <!-- Submit Button -->
            <div class="text-center mt-3">
                <button type="submit" name="tambah_study" class="btn btn-success w-100">Tambah Data Universitas</button>
            </div>
        </form>
        <a href="study_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a><br>
    </div>
</main>

<!-- Modal Tambah Universitas Baru -->
<div class="modal fade" id="tambahUniversitasModal" tabindex="-1" aria-labelledby="tambahUniversitasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUniversitasModalLabel">Tambah Universitas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahUniversitas">
                    <div class="mb-3">
                        <label for="nama_universitas_baru" class="form-label">Nama Universitas</label>
                        <input type="text" class="form-control" id="nama_universitas_baru" name="nama_universitas_baru" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanUniversitasBaru">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Fakultas Baru -->
<div class="modal fade" id="tambahFakultasModal" tabindex="-1" aria-labelledby="tambahFakultasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahFakultasModalLabel">Tambah Fakultas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahFakultas">
                    <div class="mb-3">
                        <label for="nama_fakultas_baru" class="form-label">Nama Fakultas</label>
                        <input type="text" class="form-control" id="nama_fakultas_baru" name="nama_fakultas_baru" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanFakultasBaru">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Program Studi Baru -->
<div class="modal fade" id="tambahProdiModal" tabindex="-1" aria-labelledby="tambahProdiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahProdiModalLabel">Tambah Program Studi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahProdi">
                    <div class="mb-3">
                        <label for="nama_prodi_baru" class="form-label">Nama Program Studi</label>
                        <input type="text" class="form-control" id="nama_prodi_baru" name="nama_prodi_baru" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanProdiBaru">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Load fakultas berdasarkan universitas yang dipilih
        $('#nama_universitas').change(function() {
            var nama_universitas = $(this).val();
            if (nama_universitas) {
                $.ajax({
                    url: 'study_tambah_universitas.php', // Menggunakan file yang sama
                    type: 'POST',
                    data: {nama_universitas: nama_universitas},
                    success: function(response) {
                        $('#fakultas').html(response);
                    }
                });
            } else {
                $('#fakultas').html('<option value="">Pilih Fakultas</option>');
            }
        });

        // Load program studi berdasarkan fakultas yang dipilih
        $('#fakultas').change(function() {
            var nama_fakultas = $(this).val();
            if (nama_fakultas) {
                $.ajax({
                    url: 'study_tambah_universitas.php', // Menggunakan file yang sama
                    type: 'POST',
                    data: {nama_fakultas: nama_fakultas},
                    success: function(response) {
                        $('#jurusan_prodi').html(response);
                    }
                });
            } else {
                $('#jurusan_prodi').html('<option value="">Pilih Program Studi</option>');
            }
        });

        // Simpan universitas baru ke Select2 (tanpa ke database)
        $('#simpanUniversitasBaru').click(function() {
            var nama_universitas = $('#nama_universitas_baru').val();
            if (nama_universitas) {
                var newOption = new Option(nama_universitas, nama_universitas, true, true);
                $('#nama_universitas').append(newOption).trigger('change');
                $('#tambahUniversitasModal').modal('hide');
                $('#nama_universitas_baru').val(''); // Reset input
            }
        });

        // Simpan fakultas baru ke Select2 (tanpa ke database)
        $('#simpanFakultasBaru').click(function() {
            var nama_fakultas = $('#nama_fakultas_baru').val();
            if (nama_fakultas) {
                var newOption = new Option(nama_fakultas, nama_fakultas, true, true);
                $('#fakultas').append(newOption).trigger('change');
                $('#tambahFakultasModal').modal('hide');
                $('#nama_fakultas_baru').val(''); // Reset input
            }
        });

        // Simpan program studi baru ke Select2 (tanpa ke database)
        $('#simpanProdiBaru').click(function() {
            var nama_prodi = $('#nama_prodi_baru').val();
            if (nama_prodi) {
                var newOption = new Option(nama_prodi, nama_prodi, true, true);
                $('#jurusan_prodi').append(newOption).trigger('change');
                $('#tambahProdiModal').modal('hide');
                $('#nama_prodi_baru').val(''); // Reset input
            }
        });
    });
</script>