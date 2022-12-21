<?php
require_once '../asset/php/session.php';

$user = new Auth();
$kurir = $user->fetchAllTim(2);
$pelanggan = $user->fetchAllTim(3);
$mtd = $user->fetchAllMetodePengambilan();

if (isset($_GET['id_pesanan'])) {
    $idPesanan = $user->validate($_GET['id_pesanan']);
    $code = $user->fetchAllDetailPesananByID($idPesanan);
    $cek = $user->fetchAllPesananByID($idPesanan);
    if ($code == true && $cek == false) {
        header('location: pesanan.php');
        die;
    }
}

if (isset($_POST['qty_update_btn'])) {
    $update_value = $user->validate($_POST['qty_update']);
    $update_id = $user->validate($_POST['qty_update_id']);

    $setQuery = $user->upQtyPilihanProduk($update_value, $idPesanan, $update_id);
    if ($setQuery == true) {
        header('location: buat-pesanan.php?id_pesanan=' . $idPesanan . '');
        echo 'berhasil';
    } else {
        echo 'wrong';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan | TOSEPATU - Anda Untung Kami Berkah</title>
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
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'buat-pesanan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-ticket"></i>Pesanan</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'pelanggan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-lightbulb"></i>Pelanggan</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'produk.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-box-open"></i>Produk</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'kelola tim.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-users"></i>Kelola Tim</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'laporan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-book"></i>Laporan</a>
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'pengaturan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-gear"></i>Pengaturan</a>
            <!-- <li><i class="fa-solid fa-gear"></i>
            </li> -->
        </div>
    </section>
    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div class="nav-judul">
                    <h2>Pesanan /&nbsp;&nbsp;<h2>
                            <h4>Buat Pesanan</h4>
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

            <div class="tbl-container" id="Buat Pesanan">
                <div class="tbl-content">
                    <div class="tbl-header">
                        <h3><a href="#" class="tablink" id="<?php echo $idPesanan; ?>"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Kembali</a></h3>
                        <div class="tbl-header-right">
                            <!-- <input type="text" name="id-pesanan" readonly value=""> -->
                        </div>
                    </div>

                    <div class="form-add-pesanan">
                        <form action="#" method="post" id="add-pesanan-form">
                            <div class="add-id-pesanan">
                                <label><b>ID Pesanan</b></label>
                                <input type="text" name="id-pesanan" readonly value="<?= $idPesanan; ?>">
                            </div>
                            <div class="info-pelanggan">
                                <label><b>Info Pelanggan</b></label>
                                <select name="karyawan-select">
                                    <option>--- Pilih Pelanggan ---</option>
                                    <?php
                                    $output = '';
                                    foreach ($pelanggan as $row) {
                                        $output .= '<option value="' . $row['id_akun'] .
                                            '"';
                                        if ($_POST['karyawan-select'] == $row['id_akun']) {
                                            echo 'selected';
                                        }
                                        $output .= '>' . $row['username'] .
                                            '</option>';
                                    }
                                    echo $output;
                                    ?>
                                </select>
                            </div>
                            <div class="pop"></div>
                            <div class="info-produk-pesanan">
                                <label><b>Produk Pesanan</b></label>
                                <div class="bungkus-box">
                                    <?php
                                    $pilihan = $user->fetchAllDetailPesananByID($idPesanan);
                                    $path = '../asset/php/uploads/';
                                    if ($pilihan != null) { ?>
                                        <?php foreach ($pilihan as $row) {
                                            // insiasi
                                            $qty = $row['qty'];
                                            $hargaProduk = $row['harga_layanan'];
                                            $subTotal = $row['sub_total'];

                                            // panggil fungsi tampil data produk layanan
                                            $fotoProduk = $user->fetchAllProdukByID($row['uid_layanan']);
                                            $namaProduk = $fotoProduk['nama_layanan'];
                                            $foto = $fotoProduk['foto_layanan'];
                                            if ($foto != '') {
                                                $ufoto = $path . $foto;
                                            } else {
                                                $ufoto = '../asset/img/avatarr.png';
                                            }
                                        ?>
                                            <div class="box-pilihan-produk">
                                                <div class="foto-produk-pilihan">
                                                    <img src="<?php echo $ufoto; ?>">
                                                </div>
                                                <div class="data-produk-pilihan">
                                                    <p><?php echo $namaProduk; ?></p>
                                                    <input type="hidden" name="nama-produk-pilihan">
                                                    <p><?php echo $hargaProduk; ?></p>
                                                    <input type="hidden" name="harga-produk-pilihan">
                                                </div>
                                                <div class="data-produk-pilihan-aksi">
                                                    <input type="hidden" name="qty_update_id" value="<?php echo $row['uid_layanan']; ?>">
                                                    <input type="number" name="qty_update" min="1" value="<?php echo $qty; ?>">
                                                    <input type="submit" name="qty_update_btn" value="Perbarui Jumlah">
                                                    <input type="text" name="subtotal-produk-pilihan" readonly value="<?php echo $subTotal; ?>">
                                                </div>
                                            </div>
                                        <?php
                                        } ?>
                                        <div class="grand-total-box">
                                            <br>
                                            <hr>
                                            <br>
                                            <?php
                                            $grandTotal = $user->grand_total_pesanan($idPesanan);
                                            ?>
                                            <p style="text-align: start;">Total : </p>
                                            <p style="display: flex; justify-content: end; align-items: flex-end;"><?php echo $grandTotal; ?></p>
                                            <?php
                                            ?>
                                            <hr>
                                        </div>
                                        <br>
                                </div>
                            <?php } else { ?>
                                <a href="keranjang.php?id_pesanan=<?php echo $idPesanan; ?>">
                                    <i class="fa-solid fa-box-open"></i>
                                    <label>Tambah Produk</label>
                                </a>
                            <?php
                                    }
                            ?>
                            </div>
                            <div class="catatan-produk-pesanan">
                                <label><b>Catatan Pesanan (Opsional)</b></label>
                                <textarea name="catatan-pesanan" rows="5" style="resize: none; border: 1px solid #ddd; border-radius: 8px;"></textarea>
                            </div>
                            <div class="metode-pengambilan-pesanan">
                                <label><b>Metode Pengambilan</b></label>
                                <select name="karyawan-select">
                                    <option>--- Pilih Metode ---</option>
                                    <?php
                                    $output = '';
                                    foreach ($mtd as $row) {
                                        $output .= '<option value="' . $row['id_pengiriman'] .
                                            '">' . $row['nama_pengiriman'] .
                                            '</option>';
                                    }
                                    echo $output;
                                    ?>
                                </select>
                            </div>
                            <div class="alamat-produk-pesanan">
                                <label><b>Alamat</b></label>
                                <input id="cek" type="text" name="alamat-pelanggan" placeholder="Masukkan Alamat Pelanggan">
                            </div>
                            <div class="pilih-karyawan-pesanan">
                                <label><b>Pilih Karyawan</b></label>
                                <select name="karyawan-select">
                                    <option>--- Pilih Karyawan ---</option>
                                    <?php
                                    $output = '';
                                    foreach ($kurir as $row) {
                                        $output .= '<option value="' . $row['id_akun'] .
                                            '">' . $row['username'] .
                                            '</option>';
                                    }
                                    echo $output;
                                    ?>
                                </select>
                                <!-- <input type="text" name="nama-pelanggan" placeholder="Masukkan Nama Keryawan"> -->
                            </div>
                            <br>
                            <input class="btn-buat-pesanan" type="submit" id="add_data" value="Buat Pesanan">
                            <!-- <button class="btn-buat-pesanan" type="submit" id="add-pesanan-btn" disabled>Tambah</button> -->
                        </form>
                    </div>

                    <div id="popup1" class="overlay" popup-name="popup-1">
                        <div class="popup">
                            <h2>Info Pelanggan</h2>
                            <a class="close" href="">&times;</a>
                            <div class="content">
                                Silahkan pilih pelanggan
                            </div>
                            <div class="form-produk">
                                <form action="" method="post">
                                    <input type="text" name="search" placeholder="Cari pelanggan..." id="search">
                                    <div class="tbl-table-search" id="showAllPelanggan">
                                        <br>
                                        <br>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
            <script>
                $(document).ready(function() {
                    fetchAllPelanggan();

                    function fetchAllPelanggan() {
                        $.ajax({
                            url: '../asset/php/action.php',
                            method: 'post',
                            data: {
                                action: 'fetchAllPelangganPesanan'
                            },
                            success: function(response) {
                                $("#showAllPelanggan").html(response);
                            }
                        });
                    }

                    // $("#keyword"), on("keyup", function() {
                    //     $("form-produk").load('../asset/php/prosess.php');
                    // });

                    // $(document).on("click", ".PelangganConfirmIcon", function() {
                    //     // e.preventDefault();
                    //     details_id = $(this).attr('id');
                    //     var id = $(this).data('id_akun');
                    //     $("#id-pelanggan_id").val(id);
                    //     // function post_value(s) {
                    //     //     opener.document.getElementById(details_id).value = s;
                    //     //     self.close();
                    //     // }
                    // });
                    // $(document).on("click", ".PelangganConfirmIcon", function(e) {
                    //     e.preventDefault();
                    //     details_id = $(this).attr('id');
                    //     $.ajax({
                    //         url: '../asset/php/action.php',
                    //         method: 'post',
                    //         data: {
                    //             details_id: details_id
                    //         },
                    //         success: function(response) {
                    //             console.log(response);
                    //             // $("#getName").text(data.username);
                    //             // $("#getNo").text(data.no_telp);
                    //         }
                    //     });
                    // });

                    $('#search').keyup(function() {
                        var search = $("#search").val();
                        if (search === '') {
                            fetchAllPelanggan();
                        } else {
                            load_data(search);
                        }
                    });

                    $(document).on("click", ".tablink", function(e) {
                        e.preventDefault();

                        delBP_id = $(this).attr('id');

                        Swal.fire({
                            title: 'Apakah Anda Yakin?',
                            text: 'Pesanan akan dibatalkan',
                            type: 'warning',
                            position: 'center',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Batalkan pesanan'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: '../asset/php/action.php',
                                    method: 'post',
                                    data: {
                                        delBP_id: delBP_id
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: 'Pesanan berhasil dibatalkan',
                                            showConfirmButton: false,
                                            timer: 5000
                                        })
                                        location.reload(200);
                                    }
                                })
                            }
                        })
                    });
                });
                load_data();

                function load_data(search) {
                    $.ajax({
                        url: "../asset/php/action.php",
                        method: "POST",
                        data: {
                            search: search
                        },
                        success: function(response) {
                            $('#showAllPelanggan').html(response);
                        }
                    });
                }

                // $(function() {
                //     $('[popup-open]').on('click', function() {
                //         var popup_name = $(this).attr('popup-open');
                //         $('[popup-name="' + popup_name + '"]').fadeIn(300);
                //     });
                // });
                // $("#modal-info-pelanggan").click(function(e) {
                //     e.preventDefault();
                //     $.ajax({
                //         url: '../asset/php/action.php',
                //         method: 'post',
                //         data: {
                //             action: 'modal-popup'
                //         },
                //         success: function(response) {
                //             $(".pop").html(response);
                //             // console.log(response)
                //         }
                //     });
                // });
            </script>
</body>

</html>