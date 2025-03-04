<?php
include "../layout/header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../assets/phpmailer/src/PHPMailer.php';
include '../assets/phpmailer/src/Exception.php';
include '../assets/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST["id_pengajuan"]);

    // Ambil id_user dan informasi magang dari tb_pengajuan
    $query = "SELECT id_user, nama_bidang, tanggal_mulai, tanggal_selesai, alamat_instansi, nama_panjang 
            FROM tb_pengajuan 
            JOIN tb_bidang 
                ON tb_pengajuan.id_bidang = tb_bidang.id_bidang
            JOIN tb_instansi 
                ON tb_pengajuan.id_instansi = tb_instansi.id_instansi
            WHERE tb_pengajuan.id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id_user'];
        $bidang_magang = $row['nama_bidang'];
        $alamat_instansi = $row['alamat_instansi'];
        $nama_instansi = $row['nama_panjang'];
        $periode_mulai = date("d F Y", strtotime($row['tanggal_mulai']));
        $periode_selesai = date("d F Y", strtotime($row['tanggal_selesai']));

        // Ambil email dan nama user dari tb_user
        $query_user = "SELECT nama_user, email
                    FROM tb_user 
                    JOIN tb_profile_user 
                        ON tb_user.id_user = tb_profile_user.id_user
                    WHERE tb_user.id_user = '$id_user'";
        $result_user = mysqli_query($conn, $query_user);

        if ($result_user && $row_user = mysqli_fetch_assoc($result_user)) {
            $nama_pelamar = $row_user['nama_user'];
            $email = $row_user['email'];

            if ($email) {
                // Update status pengajuan menjadi 2 (Diterima)
                $sql_update = "UPDATE tb_pengajuan SET status_pengajuan = '2' WHERE id_pengajuan = '$id_pengajuan'";

                if (mysqli_query($conn, $sql_update)) {
                    // Data email
                    $email_pengirim = 'moneyuang25@gmail.com';
                    $nama_pengirim = 'Diskominfo Sidoarjo';
                    $email_penerima = $email;
                    $subject = 'Pemberitahuan Penerimaan Magang';

                    // Pesan email
                    $salam = salamBerdasarkanWaktu();
                    $message = "
                        <p>{$salam} <strong>{$nama_pelamar}</strong>,</p>
                        <p>Kami dengan senang hati menginformasikan bahwa Anda telah <strong>Diterima</strong> sebagai peserta magang di <strong>{$nama_instansi}</strong> pada bidang <strong>{$bidang_magang}</strong>.</p>
                        <p>Berikut adalah detail program magang Anda:</p>
                        <ul>
                            <li>📍 <strong>Instansi:</strong> {$nama_instansi}</li>
                            <li>📆 <strong>Periode Magang:</strong> {$periode_mulai} - {$periode_selesai}</li>
                            <li>🏢 <strong>Lokasi:</strong> {$alamat_instansi}</li>
                            <li>📑 <strong>Bidang:</strong> {$bidang_magang}</li>
                        </ul>
                        <p>Kami mengucapkan <strong>selamat</strong> atas pencapaian Anda dan berharap Anda dapat memperoleh pengalaman yang berharga selama mengikuti program ini.</p>
                        <p>Untuk informasi lebih lanjut, silakan akses <a href='#'>dashboard Anda</a>.</p>
                        <p>Jika ada pertanyaan, silakan menghubungi kami melalui email ini.</p>
                        <br>
                        <p>Hormat kami,</p>
                        <p><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
                    ";

                    // Konfigurasi PHPMailer
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = $email_pengirim;
                    $mail->Password = 'leeufuyyxfovbqtb'; // Pastikan menggunakan App Password Gmail
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';

                    $mail->setFrom($email_pengirim, $nama_pengirim);
                    $mail->addAddress($email_penerima);
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    if ($mail->send()) {
                        echo "<script>
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Pengajuan diterima dan email berhasil dikirim!',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'pengajuan.php';
                            });
                        </script>";
                    } else {
                        echo "<script>
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Pengajuan diterima tetapi gagal mengirim email!',
                                icon: 'warning'
                            }).then(() => {
                                window.location.href = 'pengajuan.php';
                            });
                        </script>";
                    }
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal memperbarui status pengajuan!',
                            icon: 'error'
                        }).then(() => {
                            window.history.back();
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Email tidak ditemukan!',
                        icon: 'error'
                    }).then(() => {
                        window.history.back();
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'User tidak ditemukan!',
                    icon: 'error'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Data pengajuan tidak ditemukan!',
                icon: 'error'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }
}

function salamBerdasarkanWaktu() {
    date_default_timezone_set('Asia/Jakarta');
    $jam = date("H");
    if ($jam < 11) return "Selamat pagi";
    if ($jam < 15) return "Selamat siang";
    if ($jam < 19) return "Selamat sore";
    return "Selamat malam";
}
?>
