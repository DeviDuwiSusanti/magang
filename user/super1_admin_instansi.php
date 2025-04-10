<?php 
    include '../layout/sidebarUser.php';
    $admin_instansi = query("SELECT * FROM tb_user u, tb_profile_user p WHERE p.id_user = u.id_user AND u.level = '2' 
                            AND (p.id_instansi IS NULL OR p.id_instansi = '') AND p.status_active = '1' ");
    $instansi_available = query("SELECT i.id_instansi, i.nama_panjang, i.status_active FROM tb_instansi i LEFT JOIN tb_profile_user p ON p.id_instansi = i.id_instansi WHERE (p.id_instansi IS NULL OR p.id_instansi = '') AND i.status_active = '1' ");
    $instansi_selected = query("SELECT DISTINCT i.nama_panjang FROM tb_instansi i INNER JOIN tb_profile_user p ON i.id_instansi = p.id_instansi");

    if(isset($_POST["generate_admin_instansi"])) {
        if(generate_admin_instansi($_POST) > 0) { ?>
            <script>generate_admin_instansi_success()</script>
        <?php } else { ?>
            <script>generate_admin_instansi_failed()</script>
        <?php }
    }
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Halaman Calon Admin Instansi</h1>
    </div>
    <div class="container mt-5">                                
        <!-- Table -->
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="table_admin_instansi" class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Gender</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Gambar</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($admin_instansi as $calon) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $calon["nama_user"] ?></td>
                            <td><?= ($calon["jenis_kelamin"] == 0 ? "Perempuan" : "Laki - Laki") ?></td>
                            <td><?= $calon["tempat_lahir"] ?>, <?= $calon["tanggal_lahir"] ?></td>
                            <td><?= $calon["telepone_user"] ?></td>
                            <td><?= $calon["alamat_user"] ?></td>
                            <td>
                                <img src="../assets/img/user/<?= $calon["gambar_user"] ?>" alt="Gambar user" class="img-thumbnail" style="width: 100px;">
                            </td>
                            <td><?= ($calon["level"] == '2' ? "Admin Instansi" : "Bukan Admin Instansi") ?></td>
                            <td>
                                <button class="btn btn-success btn-sm btn-modal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalAdminInstansi"
                                    data-id="<?= $calon['id_user'] ?>"
                                    data-nama="<?= $calon['nama_user'] ?>"
                                    data-gambar="<?= $calon['gambar_user'] ?>"
                                    data-gender="<?= ($calon["jenis_kelamin"] == 0 ? "Perempuan" : "Laki - Laki") ?>"
                                    data-tanggal="<?= $calon['tempat_lahir'] ?>, <?= $calon['tanggal_lahir'] ?>"
                                    data-telepon="<?= $calon['telepone_user'] ?>"
                                    data-alamat="<?= $calon['alamat_user'] ?>">
                                    <i class="bi bi-wrench"></i> Jadikan Admin Instansi
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

<!-- Modal -->
<div class="modal fade" id="modalAdminInstansi" tabindex="-1" aria-labelledby="modalAdminInstansiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAdminInstansiLabel">Jadikan Admin Instansi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="modal-gambar" src="" alt="Gambar User" class="img-thumbnail mb-3" width="100">
                </div>
                <table class="table">
                    <tr><td><strong>Nama:</strong></td><td id="modal-nama"></td></tr>
                    <tr><td><strong>Gender:</strong></td><td id="modal-gender"></td></tr>
                    <tr><td><strong>Tanggal Lahir:</strong></td><td id="modal-tanggal"></td></tr>
                    <tr><td><strong>Telepon:</strong></td><td id="modal-telepon"></td></tr>
                    <tr><td><strong>Alamat:</strong></td><td id="modal-alamat"></td></tr>
                </table>
                <form action="" method="POST">
                    <input type="hidden" name="id_super_admin" id="id_super_admin" value="<?= $id_user ?>">
                    <input type="hidden" name="id_user" id="modal-id-user">
                    <label for="instansi" class="form-label">Pilih Instansi</label>
                    <select id="instansi" class="form-select select2" name="id_instansi" required>
                        <option value="" selected disabled>Pilih Instansi</option>
                        <?php foreach ($instansi_available as $opd) : ?>
                            <option value="<?= $opd["id_instansi"] ?>"><?= $opd["nama_panjang"] ?></option>
                        <?php endforeach; ?>
                        <?php if (!empty($instansi_selected)) : ?>
                            <optgroup label="Sudah Ada Admin">
                                <?php foreach ($instansi_selected as $opd_select) : ?>
                                    <option disabled><?= $opd_select["nama_panjang"] ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                    </select>
                    <button type="submit" name="generate_admin_instansi" class="btn btn-success mt-3 w-100">
                        <i class="bi bi-person-check"></i> Jadikan Admin Instansi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footerDashboard.php" ?>



<script>
    $(document).ready(function() {
    $('#table_admin_instansi').DataTable();

    function initSelect2() {
        $(".select2").select2({
            dropdownParent: $("#modalAdminInstansi"), // Select2 tetap berada di dalam modal
            placeholder: "Cari instansi...",
            allowClear: true,
            width: '100%'
        });
    }

    // Panggil Select2 saat modal ditampilkan
    $("#modalAdminInstansi").on("shown.bs.modal", function() {
        initSelect2();
    });

    $(".btn-modal").click(function() {
        let id = $(this).data("id");
        let nama = $(this).data("nama");
        let gambar = $(this).data("gambar");
        let gender = $(this).data("gender");
        let tanggal = $(this).data("tanggal");
        let telepon = $(this).data("telepon");
        let alamat = $(this).data("alamat");

        $("#modal-id-user").val(id);
        $("#modal-nama").text(nama);
        $("#modal-gender").text(gender);
        $("#modal-tanggal").text(tanggal);
        $("#modal-telepon").text(telepon);
        $("#modal-alamat").text(alamat);
        $("#modal-gambar").attr("src", "../assets/img/user/" + gambar);
    });
});

</script>
