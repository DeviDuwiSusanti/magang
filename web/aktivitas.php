<?php
include "koneksi.php"; 

// Mengambil data lowongan dari database dengan JOIN tabel yang diperlukan
$sql = "SELECT * FROM tb_pengajuan 
        JOIN tb_profile_user ON tb_pengajuan.id_user = tb_profile_user.id_user
        JOIN tb_pendidikan ON tb_profile_user.id_pendidikan = tb_pendidikan.id_pendidikan
        JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
        JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
        WHERE tb_pengajuan.status_active = 'Y'";

// $sql = "
// SELECT p.*, 
//        u.nama AS nama_user, 
//        pd.nama AS nama_universitas  -- Mengambil nama universitas dari tabel tb_pendidikan
// FROM tb_pengajuan p
// JOIN tb_profile_user u ON p.id_user = u.id_user
// JOIN tb_pendidikan pd ON u.id_pendidikan = pd.id_pendidikan  -- Mengambil id_pendidikan dari tabel tb_profile_user
// WHERE p.status_active = 'Y';
// ";

$query = mysqli_query($conn, $sql);

// Membuat variabel untuk menghitung nomor urut
$no = 1;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Pengajuan Aktif</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style2.css" />
    <link rel="stylesheet" href="../assets/css/aktiv.css" />
    <link rel="stylesheet" href="../assets/css/low.css" />
</head>
<body>

<?php include "../layout/navbarUser.php" ?>

<main class="main">
<br><br><br>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Tabel Kegiatan Aktif</h1>
        <div class="search-container" style="text-align: center; margin-bottom: 20px;">
            <div class="search-wrapper">
                <input type="text" id="searchInput" class="search-input" placeholder="Cari Mahasiswa Aktif..." />
                <i id="searchIcon" class="fas fa-search search-icon"></i>
            </div>
        </div>
        <table class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Universitas</th>
            <th>Perusahaan</th>
            <th>Posisi</th>
            <th>Durasi</th>
            <th>Periode Magang</th>
        </tr>
    </thead>
    <tbody id="table-body">
        <?php while($row = mysqli_fetch_assoc($query)): ?>
            <tr class="table-row">
                <td><?= $no++; ?></td>
                <td><?= $row['nama_user'] ?></td>
                <td><?= $row['nama_pendidikan'] ?></td>
                <td><?= $row['nama_panjang'] ?></td>
                <td><?= $row['nama_bidang'] ?></td>
                <td>
                    <?php 
                        // Menghitung durasi berdasarkan tanggal mulai dan selesai
                        $start_date = strtotime($row['tanggal_mulai']);
                        $end_date = strtotime($row['tanggal_selesai']);
                        $duration = ($end_date - $start_date) / (60 * 60 * 24); // Menghitung durasi dalam hari
                        echo ceil($duration / 30) . " Bulan"; // Durasi dalam bulan
                    ?>
                </td>
                <td>
                    <?php 
                        // Format periode magang (tanggal mulai - tanggal selesai)
                        echo date('d F Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d F Y', strtotime($row['tanggal_selesai']));
                    ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    </div>

        <!-- Pagination -->
        <div class="pagination" id="pagination">
            <button class="prev disabled" onclick="prevPage()">Prev</button>
            <button class="next" onclick="nextPage()">Next</button>
        </div>
    </div>
</main>

<?php include "../layout/footerUser.php" ?>

<script>
    document.body.classList.add('light-theme');

    let currentPage = 1;
    const rowsPerPage = 5;
    const tableBody = document.getElementById("table-body");
    const rows = Array.from(tableBody.getElementsByClassName("table-row"));
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    const pagination = document.getElementById("pagination");

    // Menampilkan data berdasarkan halaman
    function showPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.forEach((row, index) => {
            row.style.display = index >= start && index < end ? "" : "none";
        });
    }

    // Fungsi untuk tombol prev
    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    }

    // Fungsi untuk tombol next
    function nextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    }

    // Memperbarui status tombol pagination
    function updatePagination() {
        const prevButton = pagination.querySelector('.prev');
        const nextButton = pagination.querySelector('.next');

        prevButton.classList.toggle('disabled', currentPage === 1);
        nextButton.classList.toggle('disabled', currentPage === totalPages);

        showPage(currentPage);
    }

    // Fungsi untuk mencari dan menyaring tabel berdasarkan nama
    function filterTable() {
        const searchValue = document.getElementById("searchInput").value.toLowerCase();
        rows.forEach((row) => {
            const nameCell = row.getElementsByTagName("td")[1]; // Mengambil kolom nama
            const name = nameCell.textContent || nameCell.innerText;
            if (name.toLowerCase().includes(searchValue)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // Menambahkan event listener pada input pencarian
    document.getElementById("searchInput").addEventListener("input", filterTable);

    // Tampilkan halaman pertama saat halaman dimuat
    updatePagination();
</script>

</body>
</html>
