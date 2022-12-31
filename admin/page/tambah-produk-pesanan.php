<?php
// session_start();
require_once '../asset/php/session.php';
$prd = new Auth();

if (isset($_GET['id_pesanan'])) {
    $idPesanan = $prd->validate($_GET['id_pesanan']);
    $code = $prd->fetchAllDetailPesananByID($idPesanan);
    $cek = $prd->fetchAllPesananByID($idPesanan);
    if ($code > 0 && $cek < 1) {
        header('location: pesanan.php');
        die;
    }
    $set = $prd->setData($idPesanan);
    $get = $prd->getData();
}
$count = $prd->fetchDetailPesananProduk($idPesanan);
// echo '<pre>';

// if (isset($_POST['update_qty_btn'])) {
//     // $idPesanan = $prd->idPesananIncrement();
//     $idProduk = $prd->validate($_POST['id-produk']);
//     $namaProduk = $prd->validate($_POST['nama-produk']);
//     $hargaProduk = $prd->validate($_POST['harga-produk']);
//     $qty = 1;
//     $subTotal = $hargaProduk * $qty;

//     $message = '';

//     $cekPesanan = $prd->fetchDetailPesanan($idProduk);
//     if ($cekPesanan == true) {
//         $message .= '<script>
//         Swal.fire({
//             position: "center",
//             icon: "warning",
//             title: "Produk sudah ditambahkan"
//         })';
//         $message .= '</script>';
//     } else {
//         // $p = $prd->addPesanan($idPesanan);
//         $d = $prd->addDetailPesanan($idPesanan, $idProduk, $qty, $hargaProduk, $subTotal);
//         $message = 'produk berhasil ditambahkan';
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Pesanan | TOSEPATU - Anda Untung Kami Berkah</title>
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
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'beranda.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-chart-pie"></i>Beranda</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'tambah-produk-pesanan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-ticket"></i>Pesanan</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'pelanggan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-lightbulb"></i>Pelanggan</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'produk.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-box-open"></i>Produk</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'kelola tim.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-users"></i>Kelola Tim</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'laporan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-book"></i>Laporan</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'pengaturan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-gear"></i>Pengaturan</a>
        </div>
    </section>
    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="nav-judul">
                    <h2>Pesanan /&nbsp;&nbsp;</h2>
                    <h3>Konfirmasi Pesanan /&nbsp;&nbsp;</h3>
                    <h4>Tambah Produk Pesanan</h4>
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
                        <a href=""><i class="fa-solid fa-gear"></i>&nbsp;Pengaturan</a>
                        <a href=""><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Keluar</a>
                    </div>
                </div>
            </div>
            <div class="tbl-container">
                <div class="tbl-content">
                    <div class="tbl-header">
                        <h3><a href="edit-status-pesanan.php?id_pesanan=<?php echo $get; ?>" class="tablink" id="<?php echo $get; ?>"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Kembali</a></h3>
                        <div class="tbl-header-right">
                            <form action="" method="post">
                                <input type="text" name="searchProduk" placeholder="Cari Produk..." id="searchProduk">
                            </form>
                        </div>
                    </div>

                    <div class="tbl-table-card" id="showAllUser"></div>
                    <div class="checkout">
                        <a href="edit-status-pesanan.php?id_pesanan=<?php echo $get; ?>" id="nextPesanan">Lanjutkan Pesanan
                            <span>
                                <?php
                                if ($count == null) {
                                    $count = 0;
                                ?>
                                    <p><?php echo $count; ?></p>
                                <?php
                                } else { ?>
                                    <p><?php echo $count; ?></p>
                                <?php
                                }
                                ?>
                            </span>
                        </a>
                    </div>

                </div>
            </div>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!-- Link Ajax Request-->
            <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
            <script>
                $(document).ready(function() {
                    fetchAllUser();

                    function fetchAllUser() {
                        $.ajax({
                            url: '../asset/php/action.php',
                            method: 'post',
                            data: {
                                action: 'pilihProduk'
                            },
                            success: function(response) {
                                $("#showAllUser").html(response);
                                // location.reload();
                            }
                        });
                    }

                    $('#searchProduk').keyup(function() {
                        var searchProduk = $("#searchProduk").val();
                        if (searchProduk === '') {
                            fetchAllUser();
                        } else {
                            load_data(searchProduk);
                        }
                    });

                    $(document).on("click", ".addPesanan", function(e) {
                        if ($("#form-pilih-produk")[0].checkValidity()) {
                            e.preventDefault();
                            add_pilih_produk = $(this).attr('id');
                            $.ajax({
                                url: '../asset/php/prosess.php',
                                method: 'post',
                                data: {
                                    add_pilih_produk: add_pilih_produk
                                },
                                success: function(response) {
                                    if (response === 'berhasil') {
                                        window.location = 'edit-status-pesanan.php?id_pesanan=<?php echo $get; ?>';
                                    } else if (response === 'already') {
                                        Swal.fire({
                                            icon: 'warning',
                                            text: 'Produk sudah ditambahkan. Silahkan pilih produk lainnya.',
                                            confirmButtonColor: '#FED049',
                                            timer: 5000
                                        });
                                        fetchAllUser();
                                    } else if (response === 'masukkan pelanggan') {
                                        Swal.fire({
                                            icon: 'warning',
                                            text: 'Masukkan Pelanggan terlebih dahulu!',
                                            confirmButtonColor: '#FED049',
                                            timer: 5000
                                        });
                                        fetchAllUser();
                                    } else {
                                        console.log(response);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Terjadi kesalahan!, Coba ulang kembali.'
                                        })
                                        fetchAllUser();
                                    }
                                }
                            });
                        }
                    });
                });
                load_data();

                function load_data(searchProduk) {
                    $.ajax({
                        url: "../asset/php/action.php",
                        method: "POST",
                        data: {
                            searchProduk: searchProduk
                        },
                        success: function(response) {
                            $('#showAllUser').html(response);
                        }
                    });
                }
            </script>
</body>

</html>