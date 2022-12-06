<?php
require_once '../../admin/asset/php/auth.php';
$user = new Auth();
$msg = '';

if (isset($_GET['email']) && isset($_GET['code'])) {
    $email = $user->validate($_GET['email']);
    $code = $user->validate($_GET['code']);
    
    // Check Link 
    $user_checklink = $user->reset_pass($email, $code);
    
    if ($user_checklink != null) {
        // reset password
        if (isset($_POST['change-pw'])) {
            // validasi inputan
            $newPW = $user->validate($_POST['new_password']);
            $confirmPW = $user->validate($_POST['confirm_password']);
            // cross cek ulang inputan
            if (empty($newPW) && empty($confirmPW)) {
                // $msg = '';
                $msg = $user->showMessage('danger', 'Data Wajib diisi!');
                // header("Location: reset-password.php?error=Kata Sandi baru dan Konfirmasi Kata Sandi wajib diisi!");
            } else if (empty($newPW)) {
                $msg = $user->showMessage('danger', 'Kata Sandi Baru wajib diisi');
                // header("Location: reset-password.php?error=Kata Sandi Baru wajib diiisi!");
            } else if (empty($confirmPW)) {
                $msg = $user->showMessage('danger', 'Konfirmasi Kata Sandi wajib diisi');
                // header("Location: reset-password.php?error=Konfirmasi Kata Sandi wajib diisi!");
            } else {
                if ($newPW === $confirmPW) {
                    $hashed_password = password_hash($newPW, PASSWORD_DEFAULT);
                    if ($berhasil = $user->update_pass($hashed_password, $email)) {
                        if ($berhasil != null) {
                            // $msg = $user->showMessage('success', 'Konfirmasi Kata Sandi wajib diisi');
                            header("Location: reset-password.php?success=Kata Sandi berhasil diubah, Silahkan Masuk Kembali");
                        } else {
                            $msg = $user->showMessage('danger', 'Terjadi kesalahan! coba lagi nanti');
                            // header("Location: reset-password.php?error=Terjadi Kesalahan! Coba lagi nanti");
                        }
                    } else {
                        $msg = $user->showMessage('danger', 'Terjadi kesalahan! coba lagi nanti');
                        // header("Location: reset-password.php?error=Terjadi Kesalahan! Coba lagi nanti");
                    }
                } else {
                    $msg = $user->showMessage('danger', 'Kata Sandi tidak cocok!');
                    // header("Location: reset-password.php?error=Kata Sandi tidak cocok!");
                }
            }
        }
    } else {
        $expired = 'Maaf, Link anda tidak valid!';
        header("Location: reset-password.php?errorlinkvalid=Maaf, Link anda tidak valid");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ubah Kata Sandi - Anda Untung Kami Berkah</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/log-page.css">
    <!-- Icon -->
    <link rel='shortcut icon' href='../assets/img/icon-tab.jpg'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
    <form class="reset" action="" method="post">
        <img src="../assets/img/Logo_ToSepatu_no_bg.png" alt="Logo Tosepatu" width="150px">
        <h2>Ubah Kata Sandi</h2>
        <p>Masukkan kata sandi baru anda dan konfirmasi kata sandi di bawah ini</p>
        <div id="alert"><?= $msg; ?></div>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error">
                <?= htmlspecialchars($_GET['error']) ?>
            </p>
            <label>KATA SANDI BARU</label>
            <input type="password" name="new_password" placeholder="Masukkan Kata Sandi Baru">
            <label>KONFIRMASI KATA SANDI</label>
            <input type="password" name="confirm_password" placeholder="Masukkan Konfirmasi Kata Sandi">
            <br>

            <button type="submit" name="change-pw">Ubah Kata Sandi</button>
        <?php
        } ?>
        <?php if (isset($_GET['success'])) { ?>
            <p class="success">
                <?= htmlspecialchars($_GET['success']); ?>
            </p>
            <div>
                <a href="masuk.php" style="text-decoration: none;">
                    <button type="button" name="login-n" ta>Masuk</button>
                </a>
            </div>
        <?php
        } ?>
        <?php
        if (isset($_GET['errorlinkvalid'])) { ?>
            <p class="errorlinkvalid">
                <?= htmlspecialchars($_GET['errorlinkvalid']) ?>
            </p>
            <div>
                <a href="forgot.php" style="text-decoration: none;">
                    <button type="button" name="login-n" ta>Kembali</button>
                </a>
            </div>
        <?php
        }
        ?>
        <?php
        if (isset($_GET['email']) && isset($_GET['code'])) { ?>
            <label>KATA SANDI BARU</label>
            <input type="password" name="new_password" placeholder="Masukkan Kata Sandi Baru">
            <label>KONFIRMASI KATA SANDI</label>
            <input type="password" name="confirm_password" placeholder="Masukkan Konfirmasi Kata Sandi">
            <br>

            <button type="submit" name="change-pw">Ubah Kata Sandi</button>
        <?php
        }
        ?>
    </form>
</body>

</html>