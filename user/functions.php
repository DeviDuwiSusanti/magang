
<?php
function generateIdPengajuan($conn) {
    // Ambil tanggal saat ini dalam format YYYYMMDD
    $tanggal = date("Ymd");

    // Ambil jumlah pengajuan yang sudah ada untuk hari ini
    $query = "SELECT COUNT(*) AS total FROM tb_pengajuan WHERE id_pengajuan LIKE '$tanggal%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalPengajuanHariIni = $row['total'] + 1; // Urutan berikutnya

    // Format XX menjadi dua digit (01, 02, 03, ...)
    $nomorUrut = str_pad($totalPengajuanHariIni, 2, "0", STR_PAD_LEFT);

    // Gabungkan untuk mendapatkan id_pengajuan
    return $tanggal . $nomorUrut;
}

function generateIdDokumen($conn, $id_pengajuan) {
    $query = "SELECT MAX(CAST(SUBSTRING(id_dokumen, -2) AS UNSIGNED)) AS max_nomor 
               FROM tb_dokumen 
               WHERE id_dokumen LIKE '$id_pengajuan%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $nextNumber = $row['max_nomor'] ? $row['max_nomor'] + 1 : 1;

    $nomorUrut = str_pad($nextNumber, 2, "0", STR_PAD_LEFT);

    return $id_pengajuan . $nomorUrut;
}


function generateIdUser4($conn, $id_user) {
    // Loop sampai menemukan ID yang belum ada
    $nextId = 1;
    do {
        $counter = str_pad($nextId, 2, "0", STR_PAD_LEFT);
        $newId = trim($id_user) . $counter;

        // Cek apakah ID ini sudah ada di tb_user
        $query = "SELECT COUNT(*) as count FROM tb_user WHERE id_user = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $newId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $nextId++;
    } while ($row['count'] > 0); // Ulangi jika ID sudah ada

    return $newId;
}

function generateLogbookId($conn, $id_pengajuan) {
    // Ambil counter terbesar untuk id_pengajuan ini
    $sql_max = "SELECT MAX(CAST(SUBSTRING(id_logbook, -2) AS UNSIGNED)) as max_counter FROM tb_logbook WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $sql_max);
    $row = mysqli_fetch_assoc($result);
    $counter = str_pad($row['max_counter'] + 1, 2, '0', STR_PAD_LEFT); // Tambah 1 ke counter terbesar

    // Buat id_logbook dengan format 10 digit id_pengajuan + 2 digit counter
    $id_logbook = $id_pengajuan . $counter;

    return $id_logbook;
}


function uploadFile($file) {
    $target_dir = "../assets/doc/";  // Update path here
    $target_file = $target_dir . basename($file["name"]);
    
    // Pindahkan file ke folder tujuan
    move_uploaded_file($file["tmp_name"], $target_file);
    
    // Mengembalikan array dengan path dan nama file
    return [
        'path' => $target_file,
        'name' => basename($file["name"])
    ];
}

function uploadFoto($file, $target_dir) {
    $target_file = rtrim($target_dir, '/') . '/' . basename($file["name"]); // Pastikan path selalu benar
    
    // Pindahkan file ke folder tujuan
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return [
            'path' => $target_file,
            'name' => basename($file["name"])
        ];
    }
    return null; // Jika gagal upload
}


function deleteOldDocument($conn, $id_pengajuan, $id_user, $jenis_dokumen) {
    // Ambil file lama dari database
    $query = "SELECT file_path FROM tb_dokumen 
               WHERE id_pengajuan = '$id_pengajuan' 
               AND id_user = '$id_user'
               AND jenis_dokumen = '$jenis_dokumen'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $file_path = $row['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path); // Hapus file fisik
        }
    }

    // Hapus record lama di database
    // $deleteQuery = "DELETE FROM tb_dokumen 
    //                 WHERE id_pengajuan = '$id_pengajuan' 
    //                 AND id_user = '$id_user'
    //                 AND jenis_dokumen = '$jenis_dokumen'";
    // mysqli_query($conn, $deleteQuery);
}

function getBidangByInstansi($id_instansi) {
    global $conn;
    
    $sql = "SELECT id_bidang, nama_bidang, kuota_bidang FROM tb_bidang WHERE id_instansi = '$id_instansi' AND kuota_bidang > 0 ORDER BY nama_bidang ASC";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        return '<option value="" disabled>Terjadi kesalahan</option>';
    }

    $options = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="'.$row['id_bidang'].'" data-kuota="'.$row['kuota_bidang'].'">'.$row['nama_bidang'].' (Kuota: '.$row['kuota_bidang'].')</option>';
    }

    return $options ?: '<option value="" disabled>Bidang tidak tersedia</option>';
}

function getDetailBidang($id_bidang, $conn) {
    $sql_bidang = "SELECT nama_bidang, deskripsi_bidang, kriteria_bidang, dokumen_prasyarat, kuota_bidang 
                    FROM tb_bidang 
                    WHERE id_bidang = '$id_bidang'";
    $result = mysqli_query($conn, $sql_bidang);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return ["error" => "Data bidang tidak ditemukan."];
    }
}

function cekEmail($email) {
    global $conn;
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM tb_user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    return mysqli_num_rows($result) > 0;
}

function getStatusText($status) {
    $statusList = [
        1 => "Diajukan",
        2 => "Diterima",
        3 => "Ditolak",
        4 => "Berlangsung",
        5 => "Selesai",
    ];
    return $statusList[$status] ?? "Tidak Diketahui";
}

function getKategoriText($kategori) {
    $kategoriList = [
        1 => "Identitas",
        2 => "Prasyarat",
        3 => "Laporan Akhir",
        4 => "Nilai & Sertifikat",
    ];
    return $kategoriList[$kategori] ?? "Tidak Diketahui";
}

function showAlert($title, $text, $icon, $redirect = null) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '$title',
                text: '$text',
                icon: '$icon',
                confirmButtonText: 'OK'
            }).then(() => {";
    if ($redirect) {
        echo "window.location.href = '$redirect';";
    }
    echo "    });
        });
    </script>";
}

// Fungsi untuk menghitung durasi dalam bulan dan hari
function hitungDurasi($tanggal_mulai, $tanggal_selesai) {
    $start_date = new DateTime($tanggal_mulai);
    $end_date = new DateTime($tanggal_selesai);
    $interval = $start_date->diff($end_date);

    $bulan = $interval->m + ($interval->y * 12);
    $hari = $interval->d;

    return ($bulan > 0 ? "$bulan Bulan " : "") . ($hari > 0 ? "$hari Hari" : "");
}

// Fungsi untuk format tanggal Lengkap Indonesia
function formatTanggalLengkapIndonesia($tanggal) {
    $bulan = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];

    $tanggal_obj = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $tanggal_obj->format('j') . ' ' . $bulan[$tanggal_obj->format('m')] . ' ' . $tanggal_obj->format('Y');
}

// Fungsi untuk format tanggal ke format Indonesia tanpa tahun
function formatTanggalIndonesia($tanggal) {
    $bulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    $dateObj = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $dateObj ? $dateObj->format('d') . ' ' . $bulan[(int)$dateObj->format('m') - 1] : "Format Tidak Valid";
}

// Fungsi untuk format periode (contoh: "1 Januari - 10 Desember 2024" atau "1 Desember 2023 - 10 Januari 2024")
function formatPeriode($tanggal_mulai, $tanggal_selesai) {
    $start_date = DateTime::createFromFormat('Y-m-d', $tanggal_mulai);
    $end_date = DateTime::createFromFormat('Y-m-d', $tanggal_selesai);

    if ($start_date && $end_date) {
        if ($start_date->format('Y') === $end_date->format('Y')) {
            return formatTanggalIndonesia($tanggal_mulai) . ' - ' . formatTanggalIndonesia($tanggal_selesai) . ' ' . $start_date->format('Y');
        } else {
            return formatTanggalIndonesia($tanggal_mulai) . ' ' . $start_date->format('Y') . ' - ' . formatTanggalIndonesia($tanggal_selesai) . ' ' . $end_date->format('Y');
        }
    }
    return "Periode Tidak Diketahui";
}


?>