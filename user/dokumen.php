<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--=============== BOXICONS digunakan untuk menambahkan ikon  ===============-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--=============== SWIPER CSS untu membuat slider===============-->
    <link rel="stylesheet" href="./assets/libraries/swiper-bundle.min.css" />

    <!--=============== Custom CSS ===============-->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .section {
            padding: 40px 0;
        }

        h2 {
            font-weight: bold;
            color: #343a40;
        }

        form {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
            color: #495057;
        }

        .form-control {
            border-radius: 6px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-primary:active {
            background-color: #004085;
            transform: translateY(0);
        }
    </style>

    <title>Form Pengajuan</title>
</head>

<body>

 <!--==================== FORM PENGAJUAN ====================-->
 <section class="section" id="form-pengajuan">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Form Pengajuan</h2>
        <form>
            <div class="mb-3">
                <label for="dokumenRekomendasiProvinsi" class="form-label">Upload Dokumen Surat Rekomendasi Bakesbanpol Provinsi</label>
                <input class="form-control" type="file" id="dokumenRekomendasiProvinsi">
            </div>
            <div class="mb-3">
                <label for="dokumenRekomendasiDaerah" class="form-label">Upload Dokumen Surat Rekomendasi Bakesbanpol Daerah</label>
                <input class="form-control" type="file" id="dokumenRekomendasiDaerah">
            </div>
            <div class="mb-3">
                <label for="dokumenProposal" class="form-label">Upload Dokumen Proposal</label>
                <input class="form-control" type="file" id="dokumenProposal">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</section>

</body>

</html>