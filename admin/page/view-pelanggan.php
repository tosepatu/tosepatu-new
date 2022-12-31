<?php
require_once '../asset/php/session.php';


$user = new Auth();
if (isset($_GET['id_akun'])) {
    $id = $_GET['id_akun'];
    $code = $user->fetchAllPelangganByID($id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Detail Pelanggan | TOSEPATU - Anda Untung Kami Berkah</title>
    <!-- Icon -->
    <link rel='shortcut icon' href='../../../home/assets/img/icon-tab.jpg'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../asset/css/page.css">
    <!-- <link rel="stylesheet" href="../asset/css/pop-up.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="/DataTables/datatables.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"> -->
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
            <a href="beranda.php" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'beranda.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-chart-pie"></i>Beranda</a>
            <a href="pesanan.php" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'pesanan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-ticket"></i>Pesanan</a>
            <a href="pelanggan.php" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'view-pelanggan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-lightbulb"></i>Pelanggan</a>
            <a href="produk.php" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'produk.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-box-open"></i>Produk</a>
            <a href="kelola tim.php" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'kelola tim.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-users"></i>Kelola Tim</a>
            <a href="laporan.php" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'laporan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-book"></i>Laporan</a>
            <a href="pengaturan.php" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'pengaturan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-gear"></i>Pengaturan</a>
            <!-- <li><i class="fa-solid fa-gear"></i>
            </li> -->
        </div>
    </section>
    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="nav-judul">
                    <h2>Pelanggan /&nbsp;&nbsp;<h2>
                            <h4>Lihat Detail Pelanggan</h4>
                </div>
            </div>
            <div class="profile">
                <i class="fa-solid fa-bell"></i>
                <img src="../asset/img/divider.png" alt="vertical line">

                <!-- <i class="fa-light fa-pipe"></i> -->
                <h4>
                    <?php
                    echo $fname;
                    ?>
                </h4>
                <div class="dropdown" style="float:right">
                    <button class="dropbtn">
                        <?php if (!$cphoto) : ?>
                            <img class="photo" src="../asset/img/avatarr.png">
                        <?php else : ?>
                            <img class="photo" src="<?= '../asset/php/uploads/' . $cphoto; ?>">
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-content">
                        <a href="pengaturan.php"><i class="fa-solid fa-gear"></i>&nbsp;Pengaturan</a>
                        <a href="../asset/php/logout.php"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Keluar</a>
                    </div>
                </div>
            </div>

            <div class="tbl-container">
                <div class="tbl-content">
                    <div class="tbl-header">
                        <h3><a href="pelanggan.php" class="tablink"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Kembali</a></h3>
                    </div>
                    <div class="rec-data-E">
                        <div class="rec-data-photos">
                                <img src="../asset/img/avatarr.png">
                        </div>
                        <div class="rec-data">
                            <h2 id="getName"><?php echo $code[0]['username_user']; ?></h2>
                            <h2 id="getId"><?php echo $id ?></h2>
                            <div class="rec-data-body">
                                <p id="getPhone">No. Telepon : <?php echo $code[0]['no_telp_user'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>