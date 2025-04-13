<?php
include "../layout/header.php";
include "function.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../assets/phpmailer/src/PHPMailer.php';
include '../assets/phpmailer/src/Exception.php';
include '../assets/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST["pengajuan_id"]);
    $tanggal = mysqli_real_escape_string($conn, $_POST["tanggal_pelaksanaan"]);
    $tanggal = formatTanggalLengkapIndonesia($tanggal);
    $jam = mysqli_real_escape_string($conn, $_POST["jam_pelaksanaan"]);
    $link_zoom = mysqli_real_escape_string($conn, $_POST["link_zoom"]);

    // $pembimbing = mysqli_real_escape_string($conn, $_POST["pembimbing"]);
    
    // // Ambil nama pembimbing berdasarkan ID pembimbing yang dipilih
    // $query_pembimbing = "SELECT nama_user FROM tb_profile_user WHERE id_user = '$pembimbing'";
    // $result_pembimbing = mysqli_query($conn, $query_pembimbing);
    
    // if ($result_pembimbing && $row_pembimbing = mysqli_fetch_assoc($result_pembimbing)) {
    //     $nama_pembimbing = $row_pembimbing['nama_user'];
    // } else {
    //     $nama_pembimbing = "Tidak Diketahui";
    // }

    // Ambil data user dari tb_pengajuan
    $query = "SELECT id_user, nama_bidang, nama_panjang 
              FROM tb_pengajuan 
              JOIN tb_bidang ON tb_pengajuan.id_bidang = tb_bidang.id_bidang 
              JOIN tb_instansi ON tb_pengajuan.id_instansi = tb_instansi.id_instansi 
              WHERE tb_pengajuan.id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id_user'];
        $bidang_magang = $row['nama_bidang'];
        $nama_instansi = $row['nama_panjang'];

        // Ambil email user dari tb_user
        $query_user = "SELECT nama_user, email FROM tb_user 
                       JOIN tb_profile_user ON tb_user.id_user = tb_profile_user.id_user 
                       WHERE tb_user.id_user = '$id_user'";
        $result_user = mysqli_query($conn, $query_user);

        if ($result_user && $row_user = mysqli_fetch_assoc($result_user)) {
            $nama_pelamar = $row_user['nama_user'];
            $email = $row_user['email'];

            if ($email) {
                // Kirim email konfirmasi Zoom
                $email_pengirim = 'moneyuang25@gmail.com';
                $nama_pengirim = 'Diskominfo Sidoarjo';
                $email_penerima = $email;
                $subject = 'Undangan Wawancara Zoom Magang';

                $salam = salamBerdasarkanWaktu();
                $message = "
                    <p>{$salam} <strong>{$nama_pelamar}</strong>,</p>
                    <p>Kami ingin mengundang Anda dalam sesi wawancara untuk magang di <strong>{$nama_instansi}</strong> pada bidang <strong>{$bidang_magang}</strong>.</p>
                    <p><strong>Detail Zoom:</strong></p>
                    <ul>
                        <li><strong>Tanggal:</strong> {$tanggal}</li>
                        <li><strong>Jam:</strong> {$jam} WIB</li>
                        <li><strong>Link Zoom:</strong> <a href='{$link_zoom}'>{$link_zoom}</a></li>
                    </ul>
                    <p>Mohon untuk hadir tepat waktu. Jika ada pertanyaan, silakan hubungi kami melalui email ini.</p>
                    <br>
                    <p>Hormat kami,</p>
                    <p><strong>{$nama_pengirim}</strong><br>Diskominfo Sidoarjo</p>
                ";

                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Username = $email_pengirim;
                $mail->Password = 'leeufuyyxfovbqtb';
                $mail->Port = 465;
                $mail->SMTPAuth = true;
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
                            text: 'Email telah dikirim!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'pengajuan.php';
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Email gagal dikirim!',
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
                        text: 'Email tidak ditemukan!',
                        icon: 'error'
                    }).then(() => {
                        window.history.back();
                    });
                </script>";
            }
        }
    }
}

function salamBerdasarkanWaktu()
{
    date_default_timezone_set('Asia/Jakarta');
    $jam = date("H");
    if ($jam < 11) return "Selamat pagi";
    if ($jam < 15) return "Selamat siang";
    if ($jam < 19) return "Selamat sore";
    return "Selamat malam";
}
