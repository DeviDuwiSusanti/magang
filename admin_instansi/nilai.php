<?php include 'header.php'; ?>

<div class="main-content p-4">
    <h1 class="mb-4">Manajemen Nilai Magang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Kelola Nilai Akhir</li>
    </ol>
    <div class="mb-4 dropdown-divider"></div>
    <h1 class="text-center"><i class="bi bi-clipboard-check"></i> Input Nilai Akhir</h1>
    <p class="text-center text-muted">Admin Instansi dapat memasukkan nilai akhir untuk peserta magang.</p>

    <div class="table-responsive-sm">
        <div class="bungkus-2">
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Program Magang</th>
                        <th>Tanggal Magang</th>
                        <th>Nilai Akhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ahmad Fauzi</td>
                        <td>Program IT</td>
                        <td>01 Jan 2025 - 30 Mar 2025</td>
                        <td>
                            <input type="number" class="form-control" min="0" max="100" id="nilai_1" value="85">
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="simpanNilai(1)">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Siti Aminah</td>
                        <td>Program Desain</td>
                        <td>05 Feb 2025 - 05 Mei 2025</td>
                        <td>
                            <input type="number" class="form-control" min="0" max="100" id="nilai_2" value="90">
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="simpanNilai(2)">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function simpanNilai(id) {
        var nilai = document.getElementById("nilai_" + id).value;
        alert("Nilai untuk peserta ID " + id + " disimpan: " + nilai);
        // Di sini kamu bisa tambahkan AJAX untuk menyimpan nilai ke database
    }
</script>

<?php include "footer.php"; ?>