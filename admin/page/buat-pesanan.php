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
    if ($code > 0 && $cek < 1) {
        header('location: pesanan.php');
        die;
    }
}

// if (isset($_POST['qty_update_btn'])) {
//     $update_value = $user->validate($_POST['qty_update']);
//     $update_id = $user->validate($_POST['qty_update_id']);

//     $setQuery = $user->upQtyPilihanProduk($update_value, $idPesanan, $update_id);
//     if ($setQuery == true) {
//         header('location: buat-pesanan.php?id_pesanan=' . $idPesanan . '');
//         echo 'berhasil';
//     } else {
//         echo 'wrong';
//     }
// }
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
                                <div class="bungkus-box">
                                    <?php
                                    $pelangganPilihan =  $user->fetchAllPesananByID($idPesanan);
                                    // $pelangganPilihan = $user->fetchAllDetailPesananByID($idPesanan);
                                    // $search = $user->fetchPesananByUID_USER($cid);
                                    $cekPelanggan = $pelangganPilihan['uid_user'];
                                    if ($cekPelanggan != null) {

                                        $idPelanggan = $pelangganPilihan['uid_user'];

                                        $pelangganPilihanNama =  $user->fetchAllPelangganByID($idPelanggan);
                                        // $fotopelanggan = $pelangganPilihanNama[0]['foto'];
                                        $namapelanggan = $pelangganPilihanNama[0]['username_user'];
                                        $nopelanggan = $pelangganPilihanNama[0]['no_telp_user'];
                                        // $alamatpelanggan = $pelangganPilihanNama[0]['alamat'];

                                        $ufoto = '../asset/img/avatarr.png';
                                    ?>


                                        <a href="pilih-pelanggan.php?id_pesanan=<?php echo $idPesanan; ?>" class="after-pilih-pelanggan">
                                            <div class="box-card-pelanggan">
                                                <div class="foto-pelanggan-pilihan">
                                                    <img src="<?php echo $ufoto; ?>">
                                                </div>
                                                <div class="data-pelanggan-pilihan">
                                                    <p><?php echo $namapelanggan; ?></p>
                                                    <p><?php echo $nopelanggan; ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php
                                    } else { ?>
                                        <a href="pilih-pelanggan.php?id_pesanan=<?php echo $idPesanan; ?>">
                                            <i class="fa-solid fa-id-card"></i>
                                            <label>Masukkan Pelanggan</label>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="pop"></div>
                            <div class="info-produk-pesanan">
                                <label><b>Produk Pesanan</b></label>
                                <div class="bungkus-box">
                                    <?php
                                    // $i = 0;
                                    // $sql = "SELECT * FROM detail_pesanan WHERE uid_pesanan = ?";
                                    $pilihan = $user->fetchAllDetailPesananByID($idPesanan);
                                    // while ($i < $pilihan) {
                                    //     echo $i['uid_layanan'];
                                    // }
                                    $path = '../asset/php/uploads/';
                                    if ($pilihan != null) { ?>
                                        <?php foreach ($pilihan as $row) {
                                            // insiasi
                                            $hargaProduk = $row['harga_layanan'];
                                            $subTotal = $row['qty'] * $hargaProduk;

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
                                                    <input type="hidden" name="nama-produk-pilihan" value="<?= $namaProduk ?>">
                                                    <p>Rp. <?php echo number_format($hargaProduk); ?></p>
                                                    <input type="hidden" name="harga-produk-pilihan" value="<?= $hargaProduk ?>">
                                                </div>
                                                <div class="data-produk-pilihan-aksi">
                                                    <input type="hidden" name="qty_update_id" class="idp" value="<?php echo $row['uid_pesanan']; ?>">
                                                    <input type="hidden" name="qty_update_id_layanan" class="pid" value="<?php echo $row['uid_layanan']; ?>">
                                                    <input type="hidden" name="qty_update_price_layanan" class="pprice" value="<?php echo $hargaProduk; ?>">
                                                    <input type="number" name="qty_update_new" class="itemQty" min="1" value="<?php echo $row['qty']; ?>">
                                                    <input type="text" name="subtotal-produk-pilihan" readonly value="Rp. <?php echo number_format($subTotal); ?>">
                                                    <a href="" id="<?php echo $row['uid_layanan'] ?>" title="Hapus produk" class="hapusProdukBtn">Hapus</a>
                                                </div>
                                            </div>
                                        <?php
                                        } ?>

                                </div>
                                <!-- <div class="tbl-table-search" id="showAllPelanggan"> -->
                                <a href="keranjang.php?id_pesanan=<?php echo $idPesanan; ?>" class="after-pilih-produk">
                                    <div class="grand-total-box">
                                        <?php
                                        $grandTotal = $user->grand_total_pesanan($idPesanan);
                                        ?>
                                        <p style="text-align: start;"><strong><i class="fa-solid fa-box-open" style="font-size: larger;"></i> &nbsp;&nbsp;Lanjutkan Pesanan </strong></p>
                                        <p style="display: flex; justify-content: end; align-items: flex-end;"><strong>Total Keseluruhan : &nbsp;&nbsp;&nbsp; Rp. <?php echo number_format($grandTotal); ?></strong>&nbsp;&nbsp;&nbsp;</p>
                                        <input type="hidden" name="grandtotal" value="<?= $grandTotal; ?>">
                                    </div>
                                </a>
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
                                <label><b>Catatan Pesanan</b>&nbsp;&nbsp; <p style="font-style: italic;">(Opsional)</p></label>
                                <textarea name="catatan-pesanan" rows="5" style="resize: none; border: 1px solid #ddd; border-radius: 8px;"></textarea>
                            </div>
                            <div class="metode-pengambilan-pesanan">
                                <label><b>Metode Pengambilan</b></label>
                                <select name="Metode-select">
                                    <option value="" selected disabled>--- Pilih Metode ---</option>
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
                                    <option value="" selected disabled>--- Pilih Karyawan ---</option>
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
                                $("#showAllPelaggan").html(response);
                            }
                        });
                    }


                    $(".itemQty").on('change', function() {
                        var $el = $(this).closest('.data-produk-pilihan-aksi');

                        var idp = $el.find(".idp").val();
                        var pid = $el.find(".pid").val();
                        var pprice = $el.find(".pprice").val();
                        var qty = $el.find(".itemQty").val();
                        location.reload(true);
                        $.ajax({
                            url: '../asset/php/action.php',
                            method: 'post',
                            cache: false,
                            data: {
                                qty: qty,
                                pid: pid,
                                pprice: pprice,
                                idp: idp
                            },
                            success: function(response) {
                                // console.log(response);
                            }
                        });
                    });

                    $(document).on("click", ".hapusProdukBtn", function(e) {
                        if ($("#add-pesanan-form")[0].checkValidity()) {
                            e.preventDefault();
                            hapus_id = $(this).attr('id');
                            Swal.fire({
                                title: 'Produk akan dihapus!',
                                text: 'Lanjutkan hapus produk pilihan?',
                                type: 'warning',
                                position: 'center',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Lanjutkan!'
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        url: '../asset/php/prosess.php',
                                        method: 'post',
                                        data: {
                                            hapus_id: hapus_id
                                        },
                                        success: function(response) {
                                            if (response === 'berhasil') {
                                                location.reload(true);
                                            } else {
                                                Swal.fire({
                                                    position: 'center',
                                                    icon: 'error',
                                                    title: 'Terjadi Kesalahan!',
                                                    timer: 5000
                                                })
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    });

                    // proses checkout
                    $("#add-pesanan-form").submit(function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Pesanan akan diproses!',
                            text: 'Lanjutkan Proses Pemesanan?',
                            type: 'warning',
                            position: 'center',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Lanjutkan!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: '../asset/php/prosess.php',
                                    method: 'post',
                                    data: $('form').serialize() + "&action=checkout",
                                    success: function(response) {
                                        if (response === 'berhasil') {
                                            window.location = 'pesanan.php';
                                        } else if (response == 'metode dan kurir belum diisi') {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'error',
                                                text: 'Metode Pengambilan dan Kurir belum diisi',
                                                title: 'Pesanan Gagal'
                                            });
                                        } else if (response === 'metode belum diisi') {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'error',
                                                text: 'Metode Pengambilan belum diisi',
                                                title: 'Pesanan Gagal'
                                            });
                                        } else if (response === 'karyawan belum diisi') {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'error',
                                                text: 'Kurir belum diisi',
                                                title: 'Pesanan Gagal'
                                            });
                                        } else if (response === 'alamat belum diisi') {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'error',
                                                text: 'Alamat belum diisi',
                                                title: 'Pesanan Gagal'
                                            });
                                        } else {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'error',
                                                title: 'Terjadi kesalahan! Silahkan refresh halaman dan coba lagi.'
                                            });
                                        }
                                        // location.reload();
                                        // } else if (response === 'gambar-tidak-valid') {
                                        //     Swal.fire({
                                        //         icon: 'error',
                                        //         title: 'Oops...',
                                        //         confirmButtonColor: '#5FD3D0',
                                        //         text: 'Gambar harus JPG, JPEG dan PNG!'
                                        //     });
                                        // } else if (response === 'terlalu-besar') {
                                        //     Swal.fire({
                                        //         icon: 'error',
                                        //         title: 'Oops...',
                                        //         confirmButtonColor: '#5FD3D0',
                                        //         text: 'Ukuran gambar harus kurang dari 10mb'
                                        //     });
                                        // } else {
                                        //     Swal.fire({
                                        //         icon: 'error',
                                        //         title: 'Oops...',
                                        //         text: 'Terjadi kesalahan!'
                                        //     });
                                        // }
                                    }
                                });
                            }
                        });
                    });

                    // $(document).on("click", ".pilihPelangganPopup", function(e) {
                    //     if ($("#form_pilih_pelanggan_popup")[0].checkValidity()) {
                    //         e.preventDefault();
                    //         add_pilih_pelanggan = $(this).attr('id');
                    //         $.ajax({
                    //             url: '../asset/php/prosess.php',
                    //             method: 'post',
                    //             data: {
                    //                 add_pilih_pelanggan: add_pilih_pelanggan
                    //             },
                    //             success: function(response) {
                    //                 console.log(response);
                    //                 // if (response === 'berhasil') {
                    //                 //     Swal.fire({
                    //                 //         position: 'center',
                    //                 //         icon: 'success',
                    //                 //         title: 'Produk berhasil ditambahkan pada keranjang',
                    //                 //         confirmButtonColor: '#5FD3D0',
                    //                 //         timer: 5000
                    //                 //     });
                    //                 //     fetchAllUser();
                    //                 // } else if (response === 'already') {
                    //                 //     Swal.fire({
                    //                 //         icon: 'warning',
                    //                 //         text: 'Produk sudah ditambahkan. Silahkan pilih produk lainnya.',
                    //                 //         confirmButtonColor: '#FED049',
                    //                 //         timer: 5000
                    //                 //     });
                    //                 //     fetchAllUser();
                    //                 // } else {
                    //                 //     console.log(response);
                    //                 //     Swal.fire({
                    //                 //         icon: 'error',
                    //                 //         title: 'Oops...',
                    //                 //         text: 'Terjadi kesalahan!, Coba ulang kembali.'
                    //                 //     })
                    //                 //     fetchAllUser();
                    //                 // }
                    //             }
                    //         });
                    //     }
                    // });

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
                                        window.location = 'pesanan.php';
                                        // location.reload(200);
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