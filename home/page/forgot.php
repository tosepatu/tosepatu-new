<?php
require '../../admin/asset/php/config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../assets/php/vendor/autoload.php';
require '../assets/php/vendor/phpmailer/phpmailer/src/Exception.php';
require '../assets/php/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../assets/php/vendor/phpmailer/phpmailer/src/SMTP.php';

require_once '../../admin/asset/php/auth.php';
$user = new Auth();

if (isset($_POST['send_link'])) {
    $email = $user->validate($_POST['email']);

    // Check email apakah ada di database
    if (empty($email)) {
        // echo $user->showMessage('danger', 'Email Wajib diisi');
        header("Location: forgot.php?error=Email wajib diisi");
        exit();
    } else {
        $userFound = $user->currentUser($email);

        if ($userFound != null) {
            // cek role
            $cekUser = $user->checkRole($email);
            if ($cekUser == true) {
                # generate code
                $code = $user->generateRandomString();
    
                // formulate link
                $link = 'href="http://localhost:3000/home/page/reset-password.php?email=' . $email . '&code=' . $code . '"';
                $link2 = '<span style="width:95%"><a style="color: #40754C; display: flex; justify-content: center; align-items: center; margin: 0, auto;"' . $link . '>Link</a></span>';
    
                $userFound = $user->forgot($code, $email);
    
                // send email menggunakan php mailer
                $mail_send = new PHPMailer(true);
                // cofigurasi localhost
                $mail_send->isSMTP();
                $mail_send->Host = 'smtp.gmail.com';
                $mail_send->SMTPAuth = true;
                $mail_send->Username = 'tosepatu.kc@gmail.com';
                $mail_send->Password = 'keycmwufauijzziv';
                $mail_send->SMTPSecure = 'ssl';
                $mail_send->Port = 465;
                // inisialissasi format pesan email
                $to = $email;
                $subject = "Reset Kata Sandi from TOSEPATU";
                $message = "
                    <p>Halo '$email',</p>
    
                    <p>Silakan klik tautan ini untuk mengatur ulang kata sandi anda:</p>
                    <p>$link2</p>
                    <br>
                    <p>Anda Untung Kami Berkah</p>
                    <span>- ADMIN TOSEPATU -</span>
                ";
                // $from = "tosepatu.kc@gmail.com";
                $mail_send->setFrom('tosepatu.kc@gmail.com');
                $mail_send->addAddress($to);
                $mail_send->isHTML(true);
    
                $mail_send->Subject = $subject;
                $mail_send->Body = $message;
    
                if ($mail_send->send()) {
                    header("Location: forgot.php?success=Link Terkirim. Check email sekarang!");
                } else {
                    header("Location: forgot.php?error=Gagal mengirim ke email");
                    exit();
                }
            } else {
                // echo $user->showMessage('danger', 'Email atau Kata Sandi Salah');
                header("Location: forgot.php?error=Silahkan reset kata sandi melalui aplikasi mobile di Play Store");
                exit();
            }
        } else {
            header("Location: forgot.php?error=Email tidak ditemukan");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi - Anda Untung Kami Berkah</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/log-page.css">
    <!-- Icon -->
    <link rel='shortcut icon' href='../assets/img/icon-tab.jpg'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
    <form class="forgot" action="forgot.php" method="post">
        <img src="../assets/img/Logo_ToSepatu_no_bg.png" alt="Logo Tosepatu" width="150px">
        <h2>Lupa Kata Sandi</h2>
        <p>Masukkan alamat email Anda</p>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error">
                <?= htmlspecialchars($_GET['error']) ?>
            </p>
        <?php
        } ?>
        <?php if (isset($_GET['success'])) { ?>
            <p class="success">
                <?= htmlspecialchars($_GET['success']); ?>
            </p>
        <?php
        } ?>
        <label>EMAIL</label>
        <input type="text" name="email" placeholder="Masukkan Email" value="<?php if (isset($_GET['email'])) echo (htmlspecialchars($_GET['email'])) ?>">
        <br>

        <button type="submit" name="send_link">Kirim Link</button>
        <div class="btn-cancel">
            <a href="masuk.php">Kembali</a>
        </div>
    </form>
</body>

</html>