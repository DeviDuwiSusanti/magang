<?php 
confirmDeleteScript();

// query awal
if (isset($_GET['id_pengajuan']) && count($_GET) === 1 OR isset($_GET['id_userEdit'])) {
    if (isset($_GET['id_pengajuan'])){
        $id_pengajuan = $_GET['id_pengajuan'];
    }
    $sql = "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_pengajuan = '$id_pengajuan' AND pu.id_user = u.id_user AND u.status_active = '1'";
    $query = mysqli_query($conn, $sql);

    $no = 1;

    // update jumlah anggota magang
    $sqlAnggota = "SELECT COUNT(*) AS jumlahAnggota FROM tb_profile_user WHERE id_pengajuan = '$id_pengajuan' AND status_active = '1'";
    $queryAnggota = mysqli_query($conn, $sqlAnggota);
    $jumlah_anggota = mysqli_fetch_assoc($queryAnggota)['jumlahAnggota'];

    $updateJumlah = "UPDATE tb_pengajuan SET jumlah_pelamar = '$jumlah_anggota' WHERE id_pengajuan = '$id_pengajuan'";
    $queryJumlah = mysqli_query($conn, $updateJumlah);

    // akses pengajuan
    $sql3 = "SELECT * FROM tb_pengajuan p, tb_bidang b WHERE p.id_pengajuan = '$id_pengajuan' AND p.id_bidang = b.id_bidang";
    $query3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($query3);
}
?>

<!-- Modal Daftar Anggota -->
<div class="modal fade" id="anggotaModal" tabindex="-1" aria-labelledby="anggotaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="anggotaModalLabel">Daftar Anggota <?= $row3['jenis_pengajuan'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">

                <!-- Tombol Tambah Anggota -->
                <?php if ($row3['status_pengajuan'] == '1' && $jumlah_anggota < $row3['kuota_bidang']) { ?>
                    <div class="mb-3 text-end">
                        <a href="?anggotaBaru=<?= '1' ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Tambah Anggota</a>
                    </div>
                <?php } ?>

                <!-- Tabel Anggota -->
                <div class="table-responsive-sm">
                    <table id="myTable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <?php
                                $studi = mysqli_query($conn, "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'");
                                $id_studi = mysqli_fetch_assoc($studi)['id_pendidikan']; ?>
                                <th><?= strlen($id_studi) == 7 ? 'NIM' : 'NISN' ?></th>
                                <?php if ($row3['status_pengajuan'] == '1') { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $row['nama_user'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['nik'] ?></td>
                                    <td><?= strlen($row['id_pendidikan']) == 7 ? $row['nim'] : $row['nisn'] ?></td>
                                    <?php if ($row3['status_pengajuan'] == '1'): ?>
                                        <td>
                                            <?php $isKetua = cekStatusUser($row['id_user']) === 'Ketua'; ?>
                                            <a href="<?= $isKetua ? '#' : "?id_userEdit={$row['id_user']}" ?>"
                                                class="btn btn-warning btn-sm <?= $isKetua ? 'disabled' : '' ?>">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                onclick="confirmDelete('?id_userHapus=<?= $row['id_user'] ?>&id_pengajuan=<?= $id_pengajuan ?>', 'anggota <?= $row['nama_user'] ?>')"
                                                class="btn btn-danger btn-sm <?= $isKetua ? 'disabled' : '' ?>">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php
$id_userEdit = null;
$editRow = null;
if (isset($_GET['id_userEdit'])) {
    $id_userEdit = $_GET['id_userEdit'];
    $editQuery = mysqli_query($conn, "SELECT * FROM tb_profile_user pu, tb_user u WHERE pu.id_user = u.id_user AND u.id_user = '$id_userEdit'");
    $editRow = mysqli_fetch_assoc($editQuery);
}

if (isset($_GET['id_userHapus'])) {
    hapusAnggota($id_user, $id_pengajuan); 
}if (ISSET($_POST['update_anggota'])){
    updateAnggota($_POST, $id_user, $id_pengajuan);
}
if (ISSET($_POST['tambah_anggota'])){
    tambahAnggota($_POST, $id_user, $id_pengajuan);
}
?>

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="tambahAnggotaModal" tabindex="-1" aria-labelledby="tambahAnggotaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAnggotaModalLabel">Tambah Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" class="form_tambahAnggota">                
                    <div class="mb-3">
                        <label for="nama_user" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_user" name="nama_user">
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="number" class="form-control" id="nik" name="nik" oninput="this.value=this.value.slice(0,16)">
                    </div>
                    
                    <?php
                    $studi = mysqli_query($conn, "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'");
                    $id_studi = mysqli_fetch_assoc($studi)['id_pendidikan'];
                    if (strlen($id_studi) == 7) : ?>
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="number" class="form-control" id="nim" name="nim" oninput="this.value=this.value.slice(0,12)">
                        </div>
                    <?php else : ?>
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="number" class="form-control" id="nisn" name="nisn" oninput="this.value=this.value.slice(0,10)">
                        </div>
                    <?php endif; ?>

                                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah_anggota" class="btn btn-primary">Tambah Anggota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Anggota -->
<div class="modal fade" id="editAnggotaModal" tabindex="-1" aria-labelledby="editAnggotaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnggotaModalLabel">Edit Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" class="form_editAnggota">
                    <input type="hidden" name="id_user" id="edit_id_user"  value="<?= $id_userEdit ?>">

                    <div class="mb-3">
                        <label for="edit_nama_user" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit_nama_user" name="nama_user" value="<?= $editRow['nama_user'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" value="<?= $editRow['email'] ?>">
                        <input type="hidden" name="original_email" value="<?= $editRow['email'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="edit_nik" class="form-label">NIK</label>
                        <input type="number" class="form-control" id="edit_nik" name="nik" value="<?= $editRow['nik'] ?>" oninput="this.value=this.value.slice(0,16)">
                    </div>

                     
                    <?php
                    $studi = mysqli_query($conn, "SELECT id_pendidikan FROM tb_profile_user WHERE id_user = '$id_user'");
                    $id_studi = mysqli_fetch_assoc($studi)['id_pendidikan'];
                    if (strlen($id_studi) == 7) : ?>
                        <div class="mb-3">
                            <label for="edit_nim" class="form-label">NIM</label>
                            <input type="number" class="form-control" id="edit_nim" name="nim" value="<?= $editRow['nim'] ?>" oninput="this.value=this.value.slice(0,12)">
                        </div>
                    <?php else : ?>
                        <div class="mb-3">
                            <label for="edit_nisn" class="form-label">NISN</label>
                            <input type="number" class="form-control" id="edit_nisn" name="nisn" value="<?= $editRow['nisn'] ?>" oninput="this.value=this.value.slice(0,10)">
                        </div>
                    <?php endif; ?>

                    <button type="submit" name="update_anggota" class="btn btn-primary">
                        <i class="bi bi-floppy me-1"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- js tabel daftar anggota -->
<?php 
if (isset($_GET['id_pengajuan'])): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('anggotaModal'));
        modal.show();

        document.getElementById('anggotaModal').addEventListener('hidden.bs.modal', function () {
            const url = new URL(window.location.href);
            url.searchParams.delete('id_pengajuan');
            window.location.href = url.toString();
        });
    });
    </script>
<?php endif; ?>

<!-- js tambah anggota baru -->
<?php if (isset($_GET['anggotaBaru'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('tambahAnggotaModal'));
            modal.show();
            
            // Saat modal ditutup, hapus query string id_logbook_tambah dan reload halaman
            const modalElement = document.getElementById('tambahAnggotaModal');
            modalElement.addEventListener('hidden.bs.modal', function () {
                const url = new URL(window.location.href);
                url.searchParams.delete('anggotaBaru');
                window.location.href = url.toString();
            });
        });
    </script>
<?php endif; ?>

<!-- js edit anggota -->
<?php if ($id_userEdit): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('editAnggotaModal'));
            modal.show();
            
            // Saat modal ditutup, hapus query string id_logbook_edit dan reload halaman
            const modalElement = document.getElementById('editAnggotaModal');
            modalElement.addEventListener('hidden.bs.modal', function () {
                const url = new URL(window.location.href);
                url.searchParams.delete('id_userEdit');
                window.location.href = url.toString();
            });
        });
    </script>
<?php endif; ?>


<!-- ==========  VALIDASIIII ===============-->
<script>
$(document).ready(function() {
    $(".form_tambahAnggota, .form_editAnggota").on("submit", function(e) {
        let isValid = true;
        $(this).find(".error-message").remove(); // Hapus pesan error lama

        // Fungsi tambah pesan error
        function showError(input, message) {
            $(input).after(`<div class="error-message text-danger mt-1">${message}</div>`);
            $(input).addClass('is-invalid');
        }

        // Cari elemen input dalam form yang dikirimkan (tambah atau edit)
        const form = $(this);
        const id_userEdit = form.find("input[name='id_user']").val() || ""; // kosong kalau tambah anggota

        // Validasi Nama
        const namaInput = form.find("[name='nama_user']");
        const nama = namaInput.val().trim();
        const namaRegex = /^[a-zA-Z\s]+$/;
        if (nama === "") {
            isValid = false;
            showError(namaInput, "Nama tidak boleh kosong!");
        } else if (!namaRegex.test(nama)) {
            isValid = false;
            showError(namaInput, "Nama hanya boleh berisi huruf!");
        }

        // Validasi Email
        const emailInput = form.find("[name='email']");
        const email = emailInput.val().trim();
        const originalEmail = form.find("input[name='original_email']").val(); // email awal (sebelum edit)
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email === "") {
            isValid = false;
            showError(emailInput, "Email tidak boleh kosong!");
        } else if (!emailRegex.test(email)) {
            isValid = false;
            showError(emailInput, "Masukkan email yang valid!");
        } else if (email !== originalEmail) { // Cek ke DB hanya jika email diubah
            // Untuk AJAX sync, kita perlu menggunakan deferred object
            const emailCheck = $.ajax({
                url: 'cek.php',
                type: 'POST',
                data: { email: email, id_userEdit: id_userEdit },
                async: false
            }).responseText;
            
            if (emailCheck === "exists") {
                isValid = false;
                showError(emailInput, "Email sudah digunakan!");
            }
        }

        // Validasi NIK
        const nikInput = form.find("[name='nik']");
        const nik = nikInput.val().trim();
        if (nik === "") {
            isValid = false;
            showError(nikInput, "NIK tidak boleh kosong!");
        } else if (nik.length !== 16 || isNaN(nik)) {
            isValid = false;
            showError(nikInput, "NIK harus 16 digit angka!");
        }

        // Validasi Pendidikan (NIM/NISN)
        const isUniversity = <?= strlen($id_studi) == 7 ? 'true' : 'false' ?>;

        if (isUniversity) {
            // University validation - NIM
            const nimInput = form.find("[name='nim']");
            const nim = nimInput.val().trim();
            if (nim === "") {
                isValid = false;
                showError(nimInput, "NIM wajib diisi untuk universitas!");
            } else if (nim.length !== 12 || isNaN(nim)) {
                isValid = false;
                showError(nimInput, "NIM harus 12 digit angka!");
            }
        } else {
            // School validation - NISN
            const nisnInput = form.find("[name='nisn']");
            const nisn = nisnInput.val().trim();
            if (nisn === "") {
                isValid = false;
                showError(nisnInput, "NISN wajib diisi untuk sekolah!");
            } else if (nisn.length !== 10 || isNaN(nisn)) {
                isValid = false;
                showError(nisnInput, "NISN harus 10 digit angka!");
            }
        }

        // Cegah submit jika ada error
        if (!isValid) {
            e.preventDefault();
        } else {
            // Jika valid, hapus class error
            form.find("input").removeClass('is-invalid');
        }
    });
});
</script>