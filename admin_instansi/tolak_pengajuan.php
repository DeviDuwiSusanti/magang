<?php
include "../layout/header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../assets/phpmailer/src/PHPMailer.php';
include '../assets/phpmailer/src/Exception.php';
include '../assets/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST["id_pengajuan"]);
    $alasan_tolak = mysqli_real_escape_string($conn, $_POST["alasan_tolak"]);

    // Ambil id_user dari tb_pengajuan
    $query = "SELECT id_user, nama_bidang, nama_panjang
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
        $nama_instansi = $row['nama_panjang'];

        // Ambil email dari tb_user
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
                // Update status pengajuan
                $sql_update = "UPDATE tb_pengajuan SET status_pengajuan = '3' WHERE id_pengajuan = '$id_pengajuan'";

                if (mysqli_query($conn, $sql_update)) {
                    // Kirim OTP melalui email
                    $email_pengirim = 'moneyuang25@gmail.com';
                    $nama_pengirim = 'Diskominfo Sidoarjo';
                    $email_penerima = $email;
                    $subject = 'Pemberitahuan Penolakan Pengajuan';

                    $salam = salamBerdasarkanWaktu();
                    $message = "
                        <p>{$salam} <strong>{$nama_pelamar}</strong>,</p>
                        <p>Terima kasih telah mengajukan permohonan magang di <strong>{$nama_instansi}</strong> pada bidang <strong>{$bidang_magang}</strong>. Setelah melalui proses evaluasi, kami ingin menyampaikan bahwa pengajuan Anda <strong>belum dapat kami terima</strong> dengan alasan sebagai berikut:</p>
                        <blockquote><i>{$alasan_tolak}</i></blockquote>
                        <p>Mohon jangan berkecil hati, dan kami sangat menghargai minat serta usaha Anda dalam mengikuti program ini.</p>
                        <p>Jika ada pertanyaan lebih lanjut, silakan menghubungi kami melalui email ini.</p>
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
                                text: 'Pengajuan ditolak dan email berhasil dikirim!',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'pengajuan.php';
                            });
                        </script>";
                    } else {
                        echo "<script>
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Pengajuan ditolak tetapi gagal mengirim email!',
                                icon: 'warning'
                            }).then(() => {
                                window.location.href = 'pengajuan.php';
                            });
                        </script>";
                    }
                } else {
                    echo "<srcipt>
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal memperbarui status pengajuan!',
                            icon: 'error'
                        }).then(() => {
                            window.history.back();
                        })
                        })
                    </srcipt>";
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

function salamBerdasarkanWaktu()
{
    date_default_timezone_set('Asia/Jakarta');
    $jam = date("H");
    if ($jam < 11) return "Selamat pagi";
    if ($jam < 15) return "Selamat siang";
    if ($jam < 19) return "Selamat sore";
    return "Selamat malam";
}
