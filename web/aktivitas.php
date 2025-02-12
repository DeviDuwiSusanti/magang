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
        <table>
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
            <tr>
                <td>1</td>
                <td>Hendra Hartono</td>
                <td>Universitas Trunojoyo Madura</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Komunikasi</td>
                <td>3 Bulan</td>
                <td>02 Januari - 02 Mei</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Siti Nur Aprilia</td>
                <td>Universitas Trunojoyo Madura</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang IT</td>
                <td>3 Bulan</td>
                <td>05 Februari - 05 Mei</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Andi Saputra</td>
                <td>Universitas Airlangga</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Jurnalistik</td>
                <td>6 Bulan</td>
                <td>10 Januari - 10 Juli</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Siti Aisyah</td>
                <td>Universitas Brawijaya</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Humas</td>
                <td>3 Bulan</td>
                <td>01 Maret - 01 Juni</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Joko Prasetyo</td>
                <td>Institut Teknologi Sepuluh Nopember</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Keamanan Data</td>
                <td>4 Bulan</td>
                <td>15 Januari - 15 Mei</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Lisa Febrianti</td>
                <td>Universitas Trunojoyo Madura</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Desain Grafis</td>
                <td>3 Bulan</td>
                <td>12 Februari - 12 Mei</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Budi Santoso</td>
                <td>Universitas Negeri Malang</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Data Science</td>
                <td>6 Bulan</td>
                <td>01 Januari - 01 Juli</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Aulia Rahman</td>
                <td>Universitas Gadjah Mada</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Cyber Security</td>
                <td>3 Bulan</td>
                <td>10 Februari - 10 Mei</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Nadia Kurniawati</td>
                <td>Universitas Padjadjaran</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Media Digital</td>
                <td>4 Bulan</td>
                <td>05 Maret - 05 Juli</td>
            </tr>
            <tr>
                <td>10</td>
                <td>Rizky Hidayat</td>
                <td>Universitas Diponegoro</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Riset dan Analisis</td>
                <td>3 Bulan</td>
                <td>07 Februari - 07 Mei</td>
            </tr>
            <tr>
                <td>11</td>
                <td>Fajar Ramadhan</td>
                <td>Universitas Surabaya</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Pengembangan Web</td>
                <td>6 Bulan</td>
                <td>01 Januari - 01 Juli</td>
            </tr>
            <tr>
                <td>12</td>
                <td>Dewi Anggraini</td>
                <td>Universitas Trunojoyo Madura</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Public Relations</td>
                <td>3 Bulan</td>
                <td>08 Februari - 08 Mei</td>
            </tr>
            <tr>
                <td>13</td>
                <td>Rendy Prasetyo</td>
                <td>Universitas Jember</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Mobile Development</td>
                <td>4 Bulan</td>
                <td>10 Maret - 10 Juli</td>
            </tr>
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
    const rows = Array.from(tableBody.getElementsByTagName("tr"));
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    const pagination = document.getElementById("pagination");

    function showPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.forEach((row, index) => {
            row.style.display = index >= start && index < end ? "" : "none";
        });
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    }

    function nextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    }

    function updatePagination() {
        const prevButton = pagination.querySelector('.prev');
        const nextButton = pagination.querySelector('.next');

        // Disable/enable buttons based on the current page
        prevButton.classList.toggle('disabled', currentPage === 1);
        nextButton.classList.toggle('disabled', currentPage === totalPages);

        // Show the correct page
        showPage(currentPage);
    }

    // Tampilkan halaman pertama saat halaman dimuat
    updatePagination();
</script>

</body>
</html>
