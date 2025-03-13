<?php
include "sidebar.php";

// Ambil daftar sekolah dari database (tanpa duplikat)
$query_sekolah = "SELECT DISTINCT nama_pendidikan FROM tb_pendidikan WHERE fakultas IS NULL OR fakultas = ''";
$result_sekolah = mysqli_query($conn, $query_sekolah);

// Jika request AJAX untuk mengambil jurusan
if (isset($_POST['nama_sekolah'])) {
    $nama_sekolah = $_POST['nama_sekolah'];
    $query_jurusan = "SELECT DISTINCT jurusan FROM tb_pendidikan WHERE nama_pendidikan = '$nama_sekolah' AND (fakultas IS NULL OR fakultas = '')";
    $result_jurusan = mysqli_query($conn, $query_jurusan);

    $options = '<option value="">Pilih Jurusan</option>';
    while ($row = mysqli_fetch_assoc($result_jurusan)) {
        $options .= '<option value="' . $row['jurusan'] . '">' . $row['jurusan'] . '</option>';
    }

    echo $options;
    exit; // Hentikan eksekusi script selanjutnya
}

// Jika request AJAX untuk menambahkan sekolah baru
if (isset($_POST['nama_sekolah_baru'])) {
    $nama_sekolah_baru = $_POST['nama_sekolah_baru'];
    $query_tambah_sekolah = "INSERT INTO tb_pendidikan (nama_pendidikan) VALUES ('$nama_sekolah_baru')";
    if (mysqli_query($conn, $query_tambah_sekolah)) {
        echo json_encode(['status' => 'success', 'nama_pendidikan' => $nama_sekolah_baru]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan sekolah baru']);
    }
    exit;
}

// Jika request AJAX untuk menambahkan jurusan baru
if (isset($_POST['nama_jurusan_baru'])) {
    $nama_jurusan_baru = $_POST['nama_jurusan_baru'];
    $nama_sekolah = $_POST['nama_sekolah'];
    $query_tambah_jurusan = "INSERT INTO tb_pendidikan (nama_pendidikan, jurusan) VALUES ('$nama_sekolah', '$nama_jurusan_baru')";
    if (mysqli_query($conn, $query_tambah_jurusan)) {
        echo json_encode(['status' => 'success', 'jurusan' => $nama_jurusan_baru]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan jurusan baru']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Sekolah</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Data Sekolah</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Halaman Tambah Data Sekolah</li>
            </ol>
        </div>

        <div class="container mt-5">
            <form action="study_view.php" class="form-instansi" method="POST" enctype="multipart/form-data">
                <!-- Nama Sekolah -->
                <div class="mb-3">
                    <label for="nama_study" class="form-label">Nama Sekolah</label>
                    <select class="form-control" id="nama_study" name="nama_study" required>
                        <option value="">Pilih Sekolah</option>
                        <?php while ($row = mysqli_fetch_assoc($result_sekolah)): ?>
                            <option value="<?php echo $row['nama_pendidikan']; ?>"><?php echo $row['nama_pendidikan']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#tambahSekolahModal">Tambah Sekolah Baru</button>
                </div>
                <!-- Nama Jurusan -->
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <select class="form-control" id="jurusan" name="jurusan" required>
                        <option value="">Pilih Jurusan</option>
                    </select>
                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#tambahJurusanModal">Tambah Jurusan Baru</button>
                </div>
                <!-- Alamat Sekolah -->
                <div class="mb-3">
                    <label for="alamat_study" class="form-label">Alamat Sekolah</label>
                    <textarea class="form-control" name="alamat_study" id="alamat_study" placeholder="Masukkan Alamat Sekolah"></textarea>
                </div>
                <!-- Submit Button -->
                <div class="text-center mt-3">
                    <button type="submit" name="tambah_study" class="btn btn-success w-100">Tambah Data Sekolah</button>
                </div>
            </form>
            <a href="study_view.php" class="btn btn-danger mb-4 bi bi-arrow-left-circle"> Kembali</a><br>
        </div>
    </main>

    <!-- Modal Tambah Sekolah Baru -->
    <div class="modal fade" id="tambahSekolahModal" tabindex="-1" aria-labelledby="tambahSekolahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSekolahModalLabel">Tambah Sekolah Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahSekolah">
                        <div class="mb-3">
                            <label for="nama_sekolah_baru" class="form-label">Nama Sekolah</label>
                            <input type="text" class="form-control" id="nama_sekolah_baru" name="nama_sekolah_baru" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanSekolahBaru">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Jurusan Baru -->
    <div class="modal fade" id="tambahJurusanModal" tabindex="-1" aria-labelledby="tambahJurusanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahJurusanModalLabel">Tambah Jurusan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahJurusan">
                        <div class="mb-3">
                            <label for="nama_jurusan_baru" class="form-label">Nama Jurusan</label>
                            <input type="text" class="form-control" id="nama_jurusan_baru" name="nama_jurusan_baru" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanJurusanBaru">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

    <script>
    // Event listener untuk memuat jurusan berdasarkan sekolah yang dipilih
    document.getElementById("nama_study").addEventListener("change", function() {
        let nama_sekolah = this.value;
        let jurusanSelect = document.getElementById("jurusan");

        if (nama_sekolah) {
            fetch("study_tambah_sekolah.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `nama_sekolah=${encodeURIComponent(nama_sekolah)}`,
            })
            .then(response => response.text())
            .then(data => {
                jurusanSelect.innerHTML = data;
            })
            .catch(error => {
                console.error("Error:", error);
            });
        } else {
            jurusanSelect.innerHTML = '<option value="">Pilih Jurusan</option>';
        }
    });

    // Event listener untuk menambahkan sekolah baru
    document.getElementById("simpanSekolahBaru").addEventListener("click", function() {
        let nama_sekolah = document.getElementById("nama_sekolah_baru").value;
        let namaStudySelect = document.getElementById("nama_study");

        if (nama_sekolah) {
            fetch("study_tambah_sekolah.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `nama_sekolah_baru=${encodeURIComponent(nama_sekolah)}`,
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Tambahkan opsi baru ke dropdown
                    let newOption = document.createElement("option");
                    newOption.value = data.nama_pendidikan;
                    newOption.text = data.nama_pendidikan;
                    namaStudySelect.appendChild(newOption);

                    // Pilih opsi baru
                    namaStudySelect.value = data.nama_pendidikan;

                    // Tutup modal
                    let modal = bootstrap.Modal.getInstance(document.getElementById("tambahSekolahModal"));
                    modal.hide();

                    // Reset input
                    document.getElementById("nama_sekolah_baru").value = "";
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    });

    // Event listener untuk menambahkan jurusan baru
    document.getElementById("simpanJurusanBaru").addEventListener("click", function() {
        let nama_jurusan = document.getElementById("nama_jurusan_baru").value;
        let nama_sekolah = document.getElementById("nama_study").value;
        let jurusanSelect = document.getElementById("jurusan");

        if (nama_jurusan && nama_sekolah) {
            fetch("study_tambah_sekolah.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `nama_jurusan_baru=${encodeURIComponent(nama_jurusan)}&nama_sekolah=${encodeURIComponent(nama_sekolah)}`,
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Tambahkan opsi baru ke dropdown
                    let newOption = document.createElement("option");
                    newOption.value = data.jurusan;
                    newOption.text = data.jurusan;
                    jurusanSelect.appendChild(newOption);

                    // Pilih opsi baru
                    jurusanSelect.value = data.jurusan;

                    // Tutup modal
                    let modal = bootstrap.Modal.getInstance(document.getElementById("tambahJurusanModal"));
                    modal.hide();

                    // Reset input
                    document.getElementById("nama_jurusan_baru").value = "";
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    });
</script>
</body>
</html>