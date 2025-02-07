<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Daftar Pengguna</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            margin: 20px;
            color: #333;
        }

        h2 {
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 8px;
            border: 1px solid #000;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-info {
            margin-bottom: 20px;
        }

        .filter-info table {
            width: auto;
            margin: 0 auto;
        }

        .filter-info td {
            padding: 4px 8px;
        }

        tfoot th,
        tfoot td {
            padding: 8px;
            border: 1px solid #000;
            background-color: #e6e6e6;
        }

        .no-print {
            text-align: center;
            margin-top: 20px;
        }

        .no-print button {
            padding: 10px 20px;
            background-color: #007BFF;
            border: none;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Daftar Bidang Website Sidoarjo Internship</h2>
    </div>

    <div class="filter-info">
        <table>
            <tr>
                <td><strong>DARI TANGGAL</strong></td>
                <td>:</td>
                <td>2025-01-01</td>
            </tr>
            <tr>
                <td><strong>SAMPAI TANGGAL</strong></td>
                <td>:</td>
                <td>2025-01-31</td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="text-align: center;">NAMA BIDANG</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Teknologi Informasi</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Akutansi</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Manajemen</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Total Bidang</th>
                <td>3 Bidang</td>
            </tr>
            <!-- <tr>
                <th>Modal Awal</th>
                <td>Rp. 1.000.000,-</td>
            </tr>
            <tr>
                <th>Keuntungan</th>
                <td>Rp. 1.450.000,-</td>
            </tr> -->
        </tfoot>
    </table>

    <div class="header">
        <h2>Total Keseluruhan Bidang: 3 Bidang</h2>
    </div>

    <div class="no-print">
        <button onclick="window.print()">Cetak Laporan</button>
    </div>

</body>

</html>