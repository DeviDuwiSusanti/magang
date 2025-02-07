<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Magang</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Daftar Mahasiswa Magang</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Universitas</th>
                    <th>Perusahaan</th>
                    <th>Bidang</th>
                    <th>Durasi</th>
                    <th>Periode Magang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data 1 -->
                <tr>
                    <td>1</td>
                    <td>Hendra Hartono</td>
                    <td>Universitas Trunojoyo Madura</td>
                    <td>Kominfo Sidoarjo</td>
                    <td>Cyber Security</td>
                    <td>3 Bulan</td>
                    <td>02 Januari - 02 Mei</td>
                    <td>
                        <a href="halamandetail.php" class="btn btn-sm btn-primary me-2" title="Lihat Detail">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </a>
                        <a href="unggah_logbook.php" class="btn btn-sm btn-success" title="Input Logbook">
                            <i class="bi bi-journal-plus"></i> Input Logbook
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle (Optional, jika butuh interaksi) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
