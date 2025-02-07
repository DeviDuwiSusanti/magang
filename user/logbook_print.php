<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Logbook Harian</title>
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
            text-align: center;
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
        <h2>Daftar Logbook Harian</h2>
    </div>

    <div class="filter-info">
        <table>
            <tr>
                <td><strong>MAGANG</strong></td>
                <td>:</td>
                <td>Bidang Informatika</td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 2%;">No</th>
                <th>Tanggal</th>
                <th>Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">1</td>
                <td style="text-align: left;">Diskusi Tim</td>
                <td style="text-align: left;">Diskusi Proyek Magang</td>
            </tr>
            <tr>
                <td style="text-align: center;">2</td>
                <td style="text-align: left;">Pengerjaan Tugas</td>
                <td style="text-align: left;">Mengerjakan Flowchart Sistem Magang</td>
            </tr>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Total Logbook</th>
                <td colspan="2">2 Logbook</td>
            
            </tr>
        </tfoot>
    </table>

    <div class="no-print">
        <button onclick="window.print()">Cetak Logbook</button>
    </div>

</body>

</html>