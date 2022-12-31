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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Produk | TOSEPATU - Anda Untung Kami Berkah</title>
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
            <a href="" class="link-side <?= (basename($_SERVER['PHP_SELF']) == 'pilih-pelanggan.php') ? "nav-active" : ""; ?>"><i class="fa-solid fa-ticket"></i>Pesanan</a>
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
                    <h3>Pesanan /&nbsp;&nbsp;</h3>
                    <h3>Buat Pesanan /&nbsp;&nbsp;</h3>
                    <h2>Masukkan Pelanggan</h2>
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
                        <h3><a href="buat-pesanan.php?id_pesanan=<?php echo $get; ?>" class="tablink" id="<?php echo $get; ?>"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Kembali</a></h3>
                        <div class="tbl-header-right">
                            <form action="" method="post" id="add-pelanggan-form-search">
                                <input type="text" name="searchPelanggan" placeholder="Cari Pelanggan..." id="searchPelanggan">
                            </form>
                        </div>
                    </div>

                    <div class="form-add-pesanan">
                        <form action="#" method="post" id="add-pelanggan-form">
                            <label><b>Nama</b></label>
                            <input type="text" name="searchPelangganByName" placeholder="Masukkan Nama" id="searchPelangganByName">
                            <label><b>Nomor Telepon</b></label>
                            <input type="tel" name="searchPelangganByNoTelp" placeholder="Masukkan Nomor Telepon" id="searchPelangganByNoTelp">
                            <div class="tbl-table-search" id="showAllPelanggan"></div>
                        </form>
                    </div>
                    <!-- <div class="tbl-table" id="showAllUser"></div> -->
                    <!-- <div class="tbl-table-card" id="showAllUser"></div> -->
                    <!-- <div class="checkout">
                        <a href="buat-pesanan.php?id_pesanan=" id="nextPesanan">Lanjutkan Pesanan
                            <span>
                            </span>
                        </a>
                    </div> -->

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
                                action: 'fetchAllPelangganPesanan'
                            },
                            success: function(response) {
                                $("#showAllPelanggan").html(response);
                            }
                        });
                    }

                    $('#searchPelanggan').keyup(function() {
                        var search = $("#searchPelanggan").val();
                        if (search === '') {
                            fetchAllUser();
                        } else {
                            load_data(search);
                        }
                    });

                    $('#searchPelangganByName').keyup(function() {
                        var searchByName = $("#searchPelangganByName").val();
                        if (searchByName === '') {
                            fetchAllUser();
                        } else {
                            load_dataByName(searchByName);
                        }
                    });

                    $('#searchPelangganByNoTelp').keyup(function() {
                        var searchByNoTelp = $("#searchPelangganByNoTelp").val();
                        if (searchByNoTelp === '') {
                            fetchAllUser();
                        } else {
                            load_dataByNoTelp(searchByNoTelp);
                        }
                    });

                    // $(document).on("click", ".tablink", function(e) {
                    //     e.preventDefault();

                    //     add_pilih_produk = $(this).attr('id');
                    //     $.ajax({
                    //         url: '../asset/php/action.php',
                    //         method: 'post',
                    //         data: {
                    //             add_pilih_produk: add_pilih_produk
                    //         },
                    //         success: function(response) {
                    //             console.log(response);
                    //             if (response == true) {
                    //                 window.location = 'buat-pesanan.php?id_pesanan'
                    //             } else {

                    //             }
                    //             Swal.fire({
                    //                 position: 'center',
                    //                 icon: 'success',
                    //                 title: 'Pesanan berhasil dibatalkan',
                    //                 showConfirmButton: false,
                    //                 timer: 5000
                    //             })
                    //             location.reload(200);
                    //         }
                    //     })

                    //     Swal.fire({
                    //         title: 'Apakah Anda Yakin?',
                    //         text: 'Pesanan akan dibatalkan',
                    //         type: 'warning',
                    //         position: 'center',
                    //         icon: 'warning',
                    //         showCancelButton: true,
                    //         confirmButtonColor: '#3085d6',
                    //         cancelButtonColor: '#d33',
                    //         confirmButtonText: 'Batalkan pesanan'
                    //     }).then((result) => {
                    //         if (result.value) {
                    //             $.ajax({
                    //                 url: '../asset/php/action.php',
                    //                 method: 'post',
                    //                 data: {
                    //                     add_pilih_produk: add_pilih_produk
                    //                 },
                    //                 success: function(response) {
                    //                     console.log(response);
                    //                     Swal.fire({
                    //                         position: 'center',
                    //                         icon: 'success',
                    //                         title: 'Pesanan berhasil dibatalkan',
                    //                         showConfirmButton: false,
                    //                         timer: 5000
                    //                     })
                    //                     location.reload(200);
                    //                 }
                    //             })
                    //         }
                    //     })
                    // });

                    $("#form-pilih-produk").submit(function(e) {
                        alert('hello');
                        e.preventDefault();
                        $.ajax({
                            url: '../asset/php/prosess.php',
                            method: 'post',
                            data: new FormData(this),
                            success: function(response) {
                                console.log(response);
                                // if (response === 'berhasil') {
                                //     // window.location = 'beranda.php';
                                //     Swal.fire({
                                //         position: 'center',
                                //         icon: 'success',
                                //         title: 'Produk berhasil ditambahkan'
                                //     })
                                //     $("#add-produk-form")[0].reset();
                                // } else if (response === 'gambar-tidak-valid') {
                                //     Swal.fire({
                                //         icon: 'error',
                                //         title: 'Oops...',
                                //         confirmButtonColor: '#5FD3D0',
                                //         text: 'Gambar harus JPG, JPEG dan PNG!'
                                //     })
                                //     $("#add-produk-form")[0].reset();
                                // } else if (response === 'terlalu-besar') {
                                //     Swal.fire({
                                //         icon: 'error',
                                //         title: 'Oops...',
                                //         confirmButtonColor: '#5FD3D0',
                                //         text: 'Ukuran gambar harus kurang dari 10mb'
                                //     })
                                //     $("#add-produk-form")[0].reset();
                                // } else {
                                //     Swal.fire({
                                //         icon: 'error',
                                //         title: 'Oops...',
                                //         text: 'Terjadi kesalahan!'
                                //     })
                                // }
                            }
                        });
                    });

                    $(document).on("click", ".pilihPelangganPopup", function(e) {
                        if ($("#add-pelanggan-form")[0].checkValidity()) {
                            e.preventDefault();
                            add_pilih_pelanggan = $(this).attr('id');
                            $.ajax({
                                url: '../asset/php/prosess.php',
                                method: 'post',
                                data: {
                                    add_pilih_pelanggan: add_pilih_pelanggan
                                },
                                success: function(response) {
                                    console.log(response);
                                    if (response === 'berhasil') {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: 'Pelanggan berhasil ditambahkan',
                                            confirmButtonColor: '#5FD3D0',
                                            timer: 5000
                                        });
                                        $("#add-pelanggan-form")[0].reset();
                                        $("#add-pelanggan-form-search")[0].reset();
                                    } else if (response === 'pelanggan diubah') {
                                        Swal.fire({
                                            icon: 'success',
                                            text: 'Pelanggan berhasil diubah.',
                                            confirmButtonColor: '#5FD3D0',
                                            timer: 5000
                                        });
                                        $("#add-pelanggan-form")[0].reset();
                                        $("#add-pelanggan-form-search")[0].reset();
                                    } else if (response === 'pelanggan sudah ditambahkan') {
                                        Swal.fire({
                                            icon: 'warning',
                                            text: 'Pelanggan telah ditambahkan.',
                                            confirmButtonColor: '#FED049',
                                            timer: 5000
                                        });
                                        $("#add-pelanggan-form")[0].reset();
                                        $("#add-pelanggan-form-search")[0].reset();
                                    } else {
                                        console.log(response);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Terjadi kesalahan!, Coba ulang kembali.'
                                        })
                                        $("#add-pelanggan-form")[0].reset();
                                        $("#add-pelanggan-form-search")[0].reset();
                                    }
                                }
                            });
                        }
                    });

                    // $(document).on("click", ".addPesanan", function(e) {
                    //     if ($("#form-pilih-produk")[0].checkValidity()) {
                    //         // addProduk = $(this).attr('id');
                    //         e.preventDefault();
                    //         $.ajax({
                    //             url: '../asset/php/prosess.php',
                    //             method: 'post',
                    //             data: {
                    //                 addProduk: addProduk
                    //             },
                    //             success: function(response) {
                    //                 console.log(response);
                    //                 // if (response === 'berhasil') {
                    //                 //     Swal.fire({
                    //                 //         position: 'center',
                    //                 //         icon: 'success',
                    //                 //         title: 'Produk berhasil ditambahkan pada pesanan',
                    //                 //         showConfirmButton: false,
                    //                 //         timer: 5000
                    //                 //     })
                    //                 //     fetchAllUser();
                    //                 // } else if (response === 'already') {
                    //                 //     Swal.fire({
                    //                 //         position: 'center',
                    //                 //         icon: 'warning',
                    //                 //         title: 'Produk sudah ditambahkan'
                    //                 //     })
                    //                 //     fetchAllUser();
                    //                 // } else {
                    //                 //     Swal.fire({
                    //                 //         position: 'center',
                    //                 //         icon: 'error',
                    //                 //         title: 'Terjadi kesalahan!'
                    //                 //     })
                    //                 // }
                    //             }
                    //         });
                    //     }
                    // });
                    // $("#addPesanan").click(function(e) {
                    //     // alert(hello);
                    //     //     e.preventDefault();
                    //     //     $.ajax({
                    //     //         url: '../asset/php/prosess.php',
                    //     //         method: 'post',
                    //     //         data: $("#form-pilih-produk").serialize() + '&action=addPesanan',
                    //     //         success: function(response) {
                    //     //             console.log(response);
                    //     //         }
                    //     //     });
                    //     // }
                    // });
                });
                load_data();
                load_dataByName();
                load_dataByNoTelp();

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

                function load_dataByName(searchByName) {
                    $.ajax({
                        url: "../asset/php/action.php",
                        method: "POST",
                        data: {
                            searchByName: searchByName
                        },
                        success: function(response) {
                            $('#showAllPelanggan').html(response);
                        }
                    });
                }

                function load_dataByNoTelp(searchByNoTelp) {
                    $.ajax({
                        url: "../asset/php/action.php",
                        method: "POST",
                        data: {
                            searchByNoTelp: searchByNoTelp
                        },
                        success: function(response) {
                            $('#showAllPelanggan').html(response);
                        }
                    });
                }
            </script>
</body>

</html>