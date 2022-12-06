<?php
// session_start();
require_once 'session-karyawan.php';
// echo '<pre>';

// if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $tittle = ucfirst(basename($_SERVER['PHP_SELF'], '.php'));
    ?>
    <title><?= $tittle ?> | TOSEPATU - Anda Untung Kami Berkah</title>
    <!-- Icon -->
    <link rel='shortcut icon' href='../../../home/assets/img/icon-tab.jpg'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../asset/css/page-karyawan.css">
    <!-- <link rel="stylesheet" href="../asset/css/pop-up.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Link auth line chart -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
</head>

<body>
    <section id="menu">
        <div class="logo">
            <img src="../../../home/assets/img/Logo_ToSepatu_no_bg.png" alt="Logo tosepatu">
            <h2>TOSEPATU.KC</h2>
        </div>
        <div class="item">
            <li><i class="fa-solid fa-chart-pie"></i>
                <a href="beranda-karyawan.php" <?= (basename($_SERVER['PHP_SELF']) == "beranda-karyawan.php") ? "nav-active" : ""; ?>>Beranda</a>
            </li>
            <li><i class="fa-solid fa-ticket"></i>
                <a href="tugas-karyawan.php" <?= (basename($_SERVER['PHP_SELF']) == "tugas-karayawan.php") ? "active" : ""; ?>>Tugas</a>
            </li>
            <li><i class="fa-solid fa-gear"></i>
                <a href="pengaturan-karyawan.php" <?= (basename($_SERVER['PHP_SELF']) == "pengaturan-karyawan.php") ? "active" : ""; ?>>Pengaturan</a>
            </li>
        </div>
    </section>
    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="nav-judul">
                    <h2><?= $tittle; ?></h2>
                </div>
            </div>
            <div class="profile">
                <i class="fa-solid fa-bell"></i>
                <img src="../../../admin/asset/img/divider.png" alt="vertical line">

                <!-- <i class="fa-light fa-pipe"></i> -->
                <h4>
                    <?php
                    echo $fname;
                    ?>
                </h4>
                <div class="dropdown" style="float:right">
                    <button class="dropbtn">
                        <?php if (!$cphoto) : ?>
                            <img class="photo" src="../../../admin/asset/img/avatarr.png">
                        <?php else : ?>
                            <img src="<?= '../asset/php/' . $cphoto; ?>">
                        <?php endif; ?>
                        <!-- <img class="photo" src="" alt="Foto Profile"> -->
                    </button>
                    <div class="dropdown-content">
                        <a href="pengaturan-karyawan.php"><i class="fa-solid fa-gear"></i>&nbsp;Pengaturan</a>
                        <a href="../../../admin/asset/php/logout.php"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Keluar</a>
                    </div>
                </div>
            </div>