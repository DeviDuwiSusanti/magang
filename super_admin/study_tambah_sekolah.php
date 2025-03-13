<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendidikan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Atur z-index untuk dropdown Select2 */
        .select2-container--open {
            z-index: 9999 !important;
        }
    </style>
</head>
<body>
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk sekolah di dalam modal
            $('#nama_sekolah').select2({
                tags: true,
                placeholder: "Pilih atau ketik manual",
                allowClear: true,
                dropdownParent: $('#modalTambahSekolah') // Dropdown muncul di dalam modal
            });

            // Inisialisasi Select2 untuk jurusan sekolah di dalam modal
            $('#jurusan_sekolah').select2({
                tags: true,
                placeholder: "Pilih atau ketik manual",
                allowClear: true,
                dropdownParent: $('#modalTambahSekolah') // Dropdown muncul di dalam modal
            });
        });
    </script>
</body>
</html>