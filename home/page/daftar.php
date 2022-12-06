<?php
session_start();
if (isset($_SESSION['userAdmin'])) {
    header('Location: beranda.php');
}
// require '../asset/php/config/config.php';
require_once '../../admin/asset/php/auth.php';

$user = new Auth();

// handle register request 
if (isset($_POST['reg'])) {
    $name = $user->validate($_POST['username']);
    $email = $user->validate($_POST['email']);
    $pass = $user->validate($_POST['password']);
    $cpass = $user->validate($_POST['cpassword']);

    if (empty($name) && empty($email) && empty($pass)) {
        // echo $user->showMessage('danger', 'Data wajib diisi');
        header("Location: daftar.php?error=Data wajib diisi");
        exit();
    } else if (empty($name) && empty($email)) {
        // echo $user->showMessage('danger', 'Nama dan Email wajib diisi');
        header("Location: daftar.php?error=Nama dan Email wajib diisi");
        // header("Location: ../../page/login.php?error=Email wajib diisi");
        exit();
    } else if (empty($name) && empty($pass)) {
        header("Location: daftar.php?error=Nama dan Kata Sandi wajib diisi");
        // echo $user->showMessage('danger', 'Nama dan Kata Sandi wajib diisi');
        // header("Location: ../../page/login.php?error=Kata Sandi wajib diisi&email=$email");
        exit();
    } else if (empty($email) && empty($pass)) {
        header("Location: daftar.php?error=Email dan Kata Sandi wajib diisi");
        // echo $user->showMessage('danger', 'Email dan Kata Sandi wajib diisi');
        exit();
    } else if (empty($name)) {
        header("Location: daftar.php?error=Nama wajib diisi");
        // echo $user->showMessage('danger', 'Nama wajib diisi');
        exit();
    } else if (empty($email)) {
        header("Location: daftar.php?error=Email wajib diisi");
        // echo $user->showMessage('danger', 'Email wajib diisi');
        exit();
    } else if (empty($pass)) {
        header("Location: daftar.php?error=Kata Sandi wajib diisi");
        // echo $user->showMessage('danger', 'Kata Sandi wajib diisi');
        exit();
    } else {
        if ($pass != $cpass) {
            header("Location: daftar.php?error=Kata Sandi tidak cocok!");
            // echo $user->showMessage('danger', 'Kata Sandi tidak cocok');
            exit();
        } else {
            $hpass = password_hash($pass, PASSWORD_DEFAULT);
            if ($email != 'achmadzakariya99@gmail.com') {
                header("Location: daftar.php?error=Silahkan mendaftar melalui aplikasi mobile di Play Store");
            } else if ($email != 'ahmadrio919@gmail.com') {
                header("Location: daftar.php?error=Silahkan mendaftar melalui aplikasi mobile di Play Store");
            } else if ($email != 'refyangigas471@gmail.com') {
                header("Location: daftar.php?error=Silahkan mendaftar melalui aplikasi mobile di Play Store");
            } else {

                $idK = $user->idKaryawan();
                $roleKaryawan = 2;

                if ($user->user_exist($email)) {
                    header("Location: daftar.php?error=Email ini sudah terdaftar");
                    exit();
                    // echo $user->showMessage('danger', 'Email ini sudah terdaftar');
                } else {
                    if ($berhasil = $user->registerKaryawan($idK, $name, $email, $hpass, $roleKaryawan)) {
                        // echo 'register';
                        // $_SESSION['user'] = $email;
                        // header("Location: daftar.php?success=Akun berhasil terdaftar!, Silahkan Masuk kembali");
                        if ($berhasil != null) {
                            // header("Location: daftar.php?success=Akun berhasil terdaftar!, Silahkan Masuk kembali");
                            header("Location: masuk.php");
                        } else {
                            header("Location: daftar.php?error=Terjadi kesalahan! Coba lagi nanti.");
                        }
                    } else {
                        header("Location: daftar.php?error=Terjadi kesalahan! Coba lagi nanti.");
                        // echo $user->showMessage('danger', 'Terjadi kesalahan! Coba lagi nanti.');
                        exit();
                    }
                }
            }
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
    <title>Daftar Akun | TOSEPATU - Anda Untung Kami Berkah</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/log-page.css">
    <!-- Icon -->
    <link rel='shortcut icon' href='../assets/img/icon-tab.jpg'>
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <form action="daftar.php" method="post" id="register-form" class="register">
            <img src="../assets/img/Logo_ToSepatu_no_bg.png" alt="Logo Tosepatu" width="150px">
            <h2>Daftar Akun</h2>
            <p>Masukkan data anda di bawah ini</p>
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
            <label>NAMA PENGGUNA</label>
            <input type="text" name="username" placeholder="Masukkan Nama Pengguna">
            <label>EMAIL</label>
            <input type="text" name="email" placeholder="Masukkan Email">

            <label>KATA SANDI</label>
            <input type="password" name="password" id="ipassword" placeholder="Masukkan Kata Sandi">
            <label>KONFIRMASI KATA SANDI</label>
            <input type="password" name="cpassword" id="cpassword" placeholder="Masukkan Konfirmasi Kata Sandi">
            <div id="passEror"></div>
            <br>

            <button type="submit" id="register-btn" name="reg">Daftar</button>
            <div class="btn-cancel">
                <a href="masuk.php">Kembali</a>
            </div>
        </form>
    </div>
    <!-- register Ajax Request link -->
    <!-- <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script> -->
    <script>
        // register Ajax Request 
        // $(document).ready(function() {
        //     $("#register-btn").click(function(e) {
        //         if ($("#register-form")[0].checkValidity()) {
        //             e.preventDefault();
        //             $.ajax({
        //                 url: '../asset/php/action.php',
        //                 method: 'post',
        //                 data: $("#register-form").serialize() + '&action=daftar',
        //                 success: function(response) {
        //                     if (response === 'daftar') {
        //                         window.location = 'masuk.php';
        //                     } else {
        //                         $("#regALert").html(response);
        //                     }
        //                 }
        //             });
        //         }
        //     });
        // });
    </script>
</body>

</html>