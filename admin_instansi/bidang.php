<?php
include "../layout/header.php";

$bidang = "SELECT b.id_bidang, b.nama_bidang, b.status_active, b.deskripsi_bidang, b.kuota_bidang, b.kriteria_bidang, b.dokumen_prasyarat,
                  i.id_instansi, i.nama_panjang, 
                  pu.id_user 
            FROM tb_bidang AS b
            JOIN tb_instansi AS i ON b.id_instansi = i.id_instansi
            JOIN tb_profile_user AS pu ON i.id_instansi = pu.id_instansi
            WHERE pu.id_user = '$id_user'
            AND b.status_active = '1'
            ORDER BY b.id_bidang ASC";

$query = mysqli_query($conn, $bidang);
$bidang = mysqli_fetch_all($query, MYSQLI_ASSOC);
$no = 1;
$id_instansi = $_SESSION['id_instansi'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_bidang'])) {
    if (tambah_bidang($_POST) > 0) {
        echo "
            <script>
                tambah_bidang_admin_instansi_success();
            </script>
        ";
    } else {
        echo "
            <script>
                tambah_bidang_admin_instansi_gagal();
            </script>
        ";
    }
}

if (isset($_GET["id_bidang_ini"])) {
    $id = $_GET["id_bidang_ini"];
    if (hapus_bidang($id, $id_user)) {
        echo "
            <script>
                hapus_bidang_admin_instansi_success();
            </script>
        ";
    } else {
        echo "
            <script>
                hapus_bidang_admin_instansi_gagal();
            </script>
        ";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_bidang'])) {
    if (edit_bidang($_POST) > 0) {
        echo "
            <script>
                edit_bidang_admin_instansi_success();
            </script>
        ";
    } else {
        echo "
            <script>
                edit_bidang_admin_instansi_gagal();
            </script>
        ";
    }
}
?>

<div class="main-content p-3">
    <div class="container-fluid">
        <h1 class="mb-4">Bidang Instansi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Kelola Bidang Instansi</li>
        </ol>
        <div class=" mb-4 dropdown-divider"></div>
        <div class="mb-4 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBidangModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Bidang
            </button>
        </div>
        <div class="table-responsive-sm">
            <div class="bungkus-2">
                <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bidang</th>
                            <th>Deskripsi</th>
                            <th>Kriteria</th>
                            <th>Kuota</th>
                            <th>Dokumen Prasyarat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bidang as $bd) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $bd["nama_bidang"] ?></td>
                                <td><?= $bd["deskripsi_bidang"] ?></td>
                                <td><?= $bd["kriteria_bidang"] ?></td>
                                <td><?= $bd["kuota_bidang"] ?></td>
                                <td><?= $bd["dokumen_prasyarat"] ?></td>
                                <td style="width: 85px;">
                                    <button type="button" class="btn btn-warning btn-sm editBidangBtn"
                                        data-bs-toggle="modal" data-bs-target="#editBidangModal"
                                        data-id_bidang="<?= $bd['id_bidang'] ?>"
                                        data-nama_bidang="<?= $bd['nama_bidang'] ?>"
                                        data-deskripsi="<?= $bd['deskripsi_bidang'] ?>"
                                        data-kriteria="<?= $bd['kriteria_bidang'] ?>"
                                        data-kuota="<?= $bd['kuota_bidang'] ?>"
                                        data-dokumen="<?= $bd['dokumen_prasyarat'] ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" onclick="hapus_bidang_admin_instansi('<?= $bd['id_bidang'] ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Bidang -->
<div class="modal fade" id="tambahBidangModal" tabindex="-1" aria-labelledby="tambahBidangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBidangModalLabel">Tambah Bidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" id="id_user" value="<?= $id_user ?>">
                    <input type="hidden" name="id_instansi" id="id_instansi" value="<?= $id_instansi ?>">
                    <div class="mb-3">
                        <label for="nama_bidang" class="form-label">Nama Bidang</label>
                        <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" placeholder="Masukkan nama bidang" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Bidang</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi bidang" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kriteria" class="form-label">Kriteria</label>
                        <textarea class="form-control" id="kriteria" name="kriteria" rows="3" placeholder="Masukkan kriteria bidang" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kuota" class="form-label">Kuota</label>
                        <input type="number" class="form-control" id="kuota" name="kuota" placeholder="Masukkan kuota bidang" required>
                    </div>
                    <div class="mb-3">
                        <label for="dokumen" class="form-label">Dokumen Prasyarat</label>
                        <textarea class="form-control" id="dokumen" name="dokumen" rows="3" placeholder="Masukkan dokumen prasyarat" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="tambah_bidang">Tambah Bidang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Bidang -->
<div class="modal fade" id="editBidangModal" tabindex="-1" aria-labelledby="editBidangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBidangModalLabel">Edit Bidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_user" value="<?= $id_user ?>">
                    <input type="hidden" name="id_bidang" id="edit_id_bidang">
                    <div class="mb-3">
                        <label for="nama_bidang" class="form-label fw-bold">Nama Bidang</label>
                        <input type="text" class="form-control" id="edit_nama_bidang" name="nama_bidang" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Bidang</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kriteria" class="form-label fw-bold">Kriteria</label>
                        <textarea class="form-control" id="edit_kriteria" name="kriteria" rows="3" required></textarea>
                        <small class="text-muted">*Pisahkan dengan koma</small>
                    </div>
                    <div class="mb-3">
                        <label for="kuota" class="form-label fw-bold">Kuota</label>
                        <input type="number" class="form-control" id="edit_kuota" name="kuota" required">
                    </div>
                    <div class="mb-3">
                        <label for="dokumen" class="form-label fw-bold">Dokumen Prasyarat</label>
                        <textarea class="form-control" id="edit_dokumen" name="dokumen" rows="3" required></textarea>
                        <small class="text-muted">*Pisahkan dengan koma</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="edit_bidang" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll(".editBidangBtn");

        editButtons.forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("edit_id_bidang").value = this.getAttribute("data-id_bidang");
                document.getElementById("edit_nama_bidang").value = this.getAttribute("data-nama_bidang");
                document.getElementById("edit_deskripsi").value = this.getAttribute("data-deskripsi");
                document.getElementById("edit_kriteria").value = this.getAttribute("data-kriteria");
                document.getElementById("edit_kuota").value = this.getAttribute("data-kuota");
                document.getElementById("edit_dokumen").value = this.getAttribute("data-dokumen");
            });
        });
    });


    function confirmDelete(event) {
        // Mencegah aksi default link
        event.preventDefault();

        // Mendapatkan URL yang akan dihapus
        const url = event.currentTarget.href;

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data bidang akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, alihkan ke URL hapus
                window.location.href = url;
            }
        });
    }
</script>