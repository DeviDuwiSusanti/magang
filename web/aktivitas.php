<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Pengajuan Aktif</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/lowongan.css" />
    <link rel="stylesheet" href="../assets/css/home.css"/>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .pagination {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        .pagination button {
            margin: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include "../layout/navbarUser.php" ?>
<main class="main">
    <section>
        <div class="swiper-container gallery-top">
            <div class="swiper-wrapper">
                <section class="islands swiper-slide">
                    <img src="../assets/img/pw3.jpg" alt="" class="islands__bg" />
                    <div class="islands__container container">
                        <div class="islands__data">
                            <h1 class="islands__title">Internship Portal</h1>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    
    <div class="container mt-5">
        <h1 class="text-center mb-4">Tabel Kegiatan Aktif</h1>
        <table class="table table-striped table-bordered">
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
                <td>Revika Syariqatun Alifia</td>
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
            <tr>
                <td>14</td>
                <td>Winda Putri</td>
                <td>Universitas Kristen Petra</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Produksi Konten</td>
                <td>3 Bulan</td>
                <td>15 Februari - 15 Mei</td>
            </tr>
            <tr>
                <td>15</td>
                <td>Alif Ramadhan</td>
                <td>Universitas Trunojoyo Madura</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Pengolahan Data</td>
                <td>3 Bulan</td>
                <td>20 Februari - 20 Mei</td>
            </tr>
            <tr>
                <td>16</td>
                <td>Dimas Ananda</td>
                <td>Universitas Trunojoyo Madura</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Multimedia</td>
                <td>3 Bulan</td>
                <td>22 Februari - 22 Mei</td>
            </tr>
            <tr>
                <td>17</td>
                <td>Laras Putri</td>
                <td>Universitas Surabaya</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Public Speaking</td>
                <td>3 Bulan</td>
                <td>25 Februari - 25 Mei</td>
            </tr>
            <tr>
                <td>18</td>
                <td>Samsul Huda</td>
                <td>Institut Teknologi Sepuluh Nopember</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Jaringan</td>
                <td>4 Bulan</td>
                <td>01 Maret - 01 Juli</td>
            </tr>
            <tr>
                <td>19</td>
                <td>Anggi Pratama</td>
                <td>Universitas Negeri Malang</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang SEO</td>
                <td>3 Bulan</td>
                <td>05 Maret - 05 Juni</td>
            </tr>
            <tr>
                <td>20</td>
                <td>Eka Wibowo</td>
                <td>Universitas Trunojoyo Madura</td>
                <td>Kominfo Sidoarjo</td>
                <td>Bidang Digital Marketing</td>
                <td>3 Bulan</td>
                <td>07 Maret - 07 Juni</td>
            </tr>

            </tbody>
        </table>
    </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center" id="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" onclick="prevPage()">Previous</a>
                </li>
            </ul>
        </nav>
    </div>
</main>

    <?php include "../layout/footerUser.php" ?>

    <script>
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

        function gotoPage(page) {
            currentPage = page;
            updatePagination();
        }

        function updatePagination() {
            pagination.innerHTML = `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="prevPage()">Previous</a>
                </li>
            `;

            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="gotoPage(${i})">${i}</a>
                    </li>
                `;
            }

            pagination.innerHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="nextPage()">Next</a>
                </li>
            `;

            showPage(currentPage);
        }

        // Tampilkan halaman pertama saat halaman dimuat
        updatePagination();

    </script>
</body>
</html>