<?php
require_once '../asset/php/session.php';

$user = new Auth();
$kurir = $user->fetchAllTim(2);
// $pelanggan = $user->fetchAllTim(3);
$mtd = $user->fetchAllMetodePengambilan();

if (isset($_GET['id_pesanan'])) {
    $idPesanan = $user->validate($_GET['id_pesanan']);
    $code = $user->fetchAllDetailPesananByID($idPesanan);
    $cek = $user->fetchAllPesananByID($idPesanan);
    if ($code > 0 && $cek < 1) {
        header('location: pesanan.php');
        die;
    }
    $catatan = $cek['catatan'];
    $idPengiriman = $cek['uid_pengiriman'];
    $idKaryawan = $cek['uid_akun'];
    $cekPengambilan = $user->fetchAllMetodePengambilanByID($idPengiriman);
    $namaPengambilan = $cekPengambilan['nama_pengiriman'];
    $alamat = $cek['alamat'];
    $namaKaryawan = $kurir[0]['username'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan | TOSEPATU - Anda Untung Kami Berkah</title>
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
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'edit-status-pesanan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-ticket"></i>Pesanan</a>
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
                            <h4>Konfirmasi Pesanan</h4>
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
                                    // if ($cekPelanggan != null) {

                                    $idPelanggan = $pelangganPilihan['uid_user'];

                                    $pelangganPilihanNama =  $user->fetchAllPelangganByID($idPelanggan);
                                    // $fotopelanggan = $pelangganPilihanNama[0]['foto'];
                                    $namapelanggan = $pelangganPilihanNama[0]['username_user'];
                                    $nopelanggan = $pelangganPilihanNama[0]['no_telp_user'];
                                    // $alamatpelanggan = $pelangganPilihanNama[0]['alamat'];

                                    $ufoto = '../asset/img/avatarr.png';
                                    ?>


                                    <a href="" class="after-pilih-pelanggan">
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
                                    // if ($pilihan != null) { 
                                    ?>
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
                                <a href="tambah-produk-pesanan.php?id_pesanan=<?php echo $idPesanan; ?>" class="after-pilih-produk">
                                    <div class="grand-total-box">
                                        <?php
                                        $grandTotal = $user->grand_total_pesanan($idPesanan);
                                        $setGrand = $user->upGrandTotal($grandTotal, $idPesanan);
                                        ?>
                                        <p style="text-align: start;"><strong><i class="fa-solid fa-box-open" style="font-size: larger;"></i> &nbsp;&nbsp;Tambah Produk Pesanan </strong></p>
                                        <p style="display: flex; justify-content: end; align-items: flex-end;"><strong>Total Keseluruhan : &nbsp;&nbsp;&nbsp; Rp. <?php echo number_format($grandTotal); ?></strong>&nbsp;&nbsp;&nbsp;</p>
                                        <input type="hidden" name="grandtotal" value="<?= $grandTotal; ?>">
                                    </div>
                                </a>
                            </div>
                            <div class="catatan-produk-pesanan">
                                <label><b>Catatan Pesanan</b>&nbsp;&nbsp; <p style="font-style: italic;">(Opsional)</p></label>
                                <textarea name="catatan-pesanan" rows="5" style="resize: none; border: 1px solid #ddd; border-radius: 8px;" readonly><?= $catatan; ?></textarea>
                            </div>
                            <div class="metode-pengambilan-pesanan">
                                <label><b>Metode Pengambilan</b></label>
                                <input type="hidden" name="qty_update_id" class="idp" value="<?php echo $row['uid_pesanan']; ?>">
                                <select name="Metode-select" class="metode-select">
                                    <option value="<?= $idPengiriman; ?>" selected disabled><?= $namaPengambilan; ?></option>
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
                                <input type="hidden" name="qty_update_id" class="idp" value="<?php echo $idPesanan; ?>">
                                <label><b>Alamat</b></label>
                                <input id="cek" type="text" name="alamat-pelanggan" placeholder="Masukkan Alamat Pelanggan" value="<?= $alamat; ?>">
                            </div>
                            <div class="pilih-karyawan-pesanan">
                                <label><b>Pilih Karyawan</b></label>
                                <input type="hidden" name="qty_update_id" class="idp" value="<?php echo $idPesanan; ?>">
                                <select name="karyawan-select" class="karyawan-select">
                                    <?php if ($idKaryawan == null) { ?>
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
                                    <?php } else { ?>
                                        <option value="<?= $idKaryawan; ?>" selected disabled><?= $namaKaryawan; ?></option>
                                    <?php
                                        $output = '';
                                        foreach ($kurir as $row) {
                                            $output .= '<option value="' . $row['id_akun'] .
                                                '">' . $row['username'] .
                                                '</option>';
                                        }
                                        echo $output;
                                    }
                                    ?>
                                </select>
                                <!-- <input type="text" name="nama-pelanggan" placeholder="Masukkan Nama Keryawan"> -->
                            </div>
                            <br>
                            <input class="btn-buat-pesanan" type="submit" id="<?= $idPesanan; ?>" value="Konfirmasi Pesanan">
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

                    $(".metode-select").on('change', function() {
                        var $mtp = $(this).closest('.metode-pengambilan-pesanan');

                        var idp = $mtp.find(".idp").val();
                        var mtd = $mtp.find(".metode-select").val();
                        location.reload(true);
                        $.ajax({
                            url: '../asset/php/action.php',
                            method: 'post',
                            cache: false,
                            data: {
                                mtd: mtd,
                                idp: idp,
                            },
                            success: function(response) {
                                // console.log(response);
                            }
                        });
                    });

                    $('#cek').keyup(function() {
                        var $amt = $(this).closest('.alamat-produk-pesanan');
                        var idp = $amt.find(".idp").val();
                        var changeAlamat = $("#cek").val();
                        if (changeAlamat === '') {
                            $("#cek").val(changeAlamat);
                        } else {
                            $.ajax({
                                url: '../asset/php/action.php',
                                method: 'post',
                                data: {
                                    changeAlamat: changeAlamat,
                                    idp: idp,
                                },
                                success: function(response) {
                                    console.log(response);
                                }
                            });
                        }
                    });

                    $(".karyawan-select").on('change', function() {
                        var $kur = $(this).closest('.pilih-karyawan-pesanan');

                        var idp = $kur.find(".idp").val();
                        var kar = $kur.find(".karyawan-select").val();
                        location.reload(true);
                        $.ajax({
                            url: '../asset/php/action.php',
                            method: 'post',
                            cache: false,
                            data: {
                                kar: kar,
                                idp: idp,
                            },
                            success: function(response) {
                                console.log(response);
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

                    // proses konfirmasi
                    $(document).on("click", ".btn-buat-pesanan", function(e) {
                        e.preventDefault();
                        konfirmasi_pesanan = $(this).attr('id');
                        Swal.fire({
                            title: 'Status pesanan akan diproses!',
                            text: 'Lanjutkan Konfirmasi Pesanan?',
                            type: 'warning',
                            position: 'center',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#5FD3D0',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Konfirmasi'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '../asset/php/prosess.php',
                                    method: 'post',
                                    data: {
                                        konfirmasi_pesanan: konfirmasi_pesanan
                                    },
                                    success: function(response) {
                                        // console.log(response);
                                        // if (response === 'berhasil') {
                                        window.location = 'pesanan.php';
                                        // } else if (response == 'metode dan kurir belum diisi') {
                                        //     Swal.fire({
                                        //         position: 'center',
                                        //         icon: 'error',
                                        //         text: 'Metode Pengambilan dan Kurir belum diisi',
                                        //         title: 'Pesanan Gagal'
                                        //     });
                                        // } else if (response === 'metode belum diisi') {
                                        //     Swal.fire({
                                        //         position: 'center',
                                        //         icon: 'error',
                                        //         text: 'Metode Pengambilan belum diisi',
                                        //         title: 'Pesanan Gagal'
                                        //     });
                                        // } else if (response === 'karyawan belum diisi') {
                                        //     Swal.fire({
                                        //         position: 'center',
                                        //         icon: 'error',
                                        //         text: 'Kurir belum diisi',
                                        //         title: 'Pesanan Gagal'
                                        //     });
                                        // } else if (response === 'alamat belum diisi') {
                                        //     Swal.fire({
                                        //         position: 'center',
                                        //         icon: 'error',
                                        //         text: 'Alamat belum diisi',
                                        //         title: 'Pesanan Gagal'
                                        //     });
                                        // } else {
                                        //     Swal.fire({
                                        //         position: 'center',
                                        //         icon: 'error',
                                        //         title: 'Terjadi kesalahan! Silahkan refresh halaman dan coba lagi.'
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

                    $(document).on("click", ".tablink", function(e) {
                        e.preventDefault();

                        // delBP_id = $(this).attr('id');

                        Swal.fire({
                            title: 'Apakah Anda Yakin?',
                            text: 'Pesanan sedang menunggu konfirmasi',
                            type: 'warning',
                            position: 'center',
                            icon: 'warning',
                            showCancelButton: true,
                            cancelButtonColor: '#5FD3D0',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Kembali',
                            cancelButtonText: 'Lanjutkan konfirmasi pesanan'
                        }).then((result) => {
                            if (result.value) {
                                window.location = 'pesanan.php';
                            }
                        })
                    });
                });

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