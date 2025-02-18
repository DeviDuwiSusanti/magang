<?php 
    include "sidebar.php";
    $id_user = $_GET["id_user"];
    $user = query("SELECT * FROM tb_profile_user WHERE id_user = '$id_user'")[0];
    $jenis_kelamin = ($user["jenis_kelamin"] == 'P' ? "Perempuan" : "Laki - Laki");

    $instansi_available = query("SELECT i.id_instansi, i.nama_panjang FROM tb_instansi i LEFT JOIN tb_profile_user p ON p.id_instansi = i.id_instansi WHERE p.id_instansi IS NULL OR p.id_instansi = '' ");
    $instansi_selected = query("SELECT DISTINCT i.nama_panjang FROM tb_instansi i INNER JOIN tb_profile_user p ON i.id_instansi = p.id_instansi");

?>

<div class="container mt-4">
        <h2 class="text-center p-4">Jadikan Admin Instansi</h2>
        <div class="card p-4">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="../assets/img/user/<?= $user["gambar_user"] ?>" alt="Gambar User" class="img-thumbnail mb-5" width="150">
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <td><i class="bi bi-person"></i> <strong>Nama</strong></td>
                            <td><?= $user["nama_user"] ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-gender-male"></i> <strong>Gender</strong></td>
                            <td><?= $jenis_kelamin ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-calendar"></i> <strong>Tanggal Lahir</strong></td>
                            <td><?= $user["tempat_lahir"] ?>, <?= $user["tanggal_lahir"] ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-telephone"></i> <strong>Telepon</strong></td>
                            <td><?= $user["telepone_user"] ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-house-door"></i> <strong>Alamat</strong></td>
                            <td><?= $user["alamat_user"] ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <form>
                <div class="mb-3">
                    <label for="instansi" class="form-label">Pilih Instansi</label>
                    <select id="instansi" class="form-select">
                        <option value="" selected disabled>---------- Pilih Instansi -----------</option>

                        <!-- Menampilkan instansi yang belum memiliki admin -->
                        <?php foreach ($instansi_available as $opd) : ?>
                            <option value="<?= $opd["id_instansi"] ?>"><?= $opd["nama_panjang"] ?></option>
                        <?php endforeach; ?>

                        <!-- Menampilkan instansi yang sudah memiliki admin sebagai opsi biasa -->
                        <?php if (!empty($instansi_selected)) : ?>
                            <optgroup label="Sudah Ada Admin">
                                <?php foreach ($instansi_selected as $opd_select) : ?>
                                    <option disabled><?= $opd_select["nama_panjang"] ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endif; ?>
                    </select>

                </div>

                <button type="submit" name="generate_admin_instansi" class="btn btn-success">
                    <i class="bi bi-person-check"></i> Jadikan Admin Instansi
                </button>
                <a href="admin_instansi_view" class="btn btn-danger">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
            </form>
        </div>
    </div>

<?php include "footer.php" ?>