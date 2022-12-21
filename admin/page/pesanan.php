<?php
require_once '../asset/php/sidebar.php';
$tbl = new Auth();
$kurir = $tbl->fetchAllTim(2);
$mtd = $tbl->fetchAllMetodePengambilan();

?>

<div class="tbl-container" id="Semua Pesanan">
    <div class="tbl-content">
        <div class="tbl-header">
            <form action="" method="POST" id="buat-pesanan-btn-form">
                <!-- <input type="hidden" name="id-pesanan" value=""> -->
                <input type="hidden" name="metode-pengiriman-sementara" value="MT220921002">
                <a href="" id="<?php
                                $dataa = $tbl->idPesananIncrement(); echo $dataa;
                                ?>" class="btn-buat-pesanan">
                    <i class="fa-sharp fa-solid fa-cart-plus">&nbsp;&nbsp;&nbsp;</i>Buat Pesanan
                </a>
            </form>
            <div class="tbl-header-right">
                <a href="#"><i class="fa-solid fa-sort">&nbsp;&nbsp;&nbsp;</i>Sort</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-filter">&nbsp;&nbsp;&nbsp;</i>Filter</a>
            </div>
        </div>
        <div class="tab-menu">
            <button class="tablink w3-red" onclick="openCity(event,'Semua Pesanan')">Semua Pesanan</button>
            <button class="tablink" onclick="openCity(event,'Pesanan Baru')">Pesanan Baru</button>
            <button class="tablink" onclick="openCity(event,'Pesanan Proses')">Proses</button>
            <button class="tablink" onclick="openCity(event,'Pesanan Dikirim')">Dikirim</button>
            <button class="tablink" onclick="openCity(event,'Pesanan Selesai')">Selesai</button>
            <button class="tablink" onclick="openCity(event,'Pesanan Gagal')">Gagal</button>
        </div>
        <div class="tbl-table" id="showAllPesanan">
            <div class="write">NOT</div>
        </div>
    </div>

</div>

<div class="tbl-container" id="Buat Pesanan" style="display: none;">
    <div class="tbl-content">
        <div class="tbl-header">
            <h3><a href="pesanan.php" class="tablink"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Buat Pesanan</a></h3>
            <div class="tbl-header-right">
                <!-- <input type="text" name="id-pesanan" readonly value=""> -->
            </div>
        </div>

        <div class="form-add-pesanan">
            <form action="#" method="post" id="add-pesanan-form">
                <div class="add-id-pesanan">
                    <label><b>ID Pesanan</b></label>
                    <input type="text" name="id-pesanan" readonly value="<?= $tbl->idPesananIncrement(); ?>">
                </div>
                <div class="info-pelanggan">
                    <label><b>Info Pelanggan</b></label>
                    <button type="submit" id="modal-info-pelanggan">
                        <i class="fa-solid fa-id-card"></i>
                        <label>Masukkan Pelanggan</label>
                    </button>

                </div>
                <div class="info-produk-pesanan">
                    <label><b>Produk Layanan</b></label>
                    <button>
                        <i class="fa-solid fa-box-open"></i>
                        <label>Tambah Produk</label>
                    </button>
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
                    <input id="cek" type="text" name="nama-pelanggan" placeholder="Masukkan Alamat Pelanggan">
                </div>
                <div class="pilih-karyawan-pesanan">
                    <label><b>Pilih Karyawan</b></label>
                    <select name="karyawan-select">
                        <option>--- Pilih Kurir ---</option>
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
                <input class="btn-buat-pesanan" type="submit" id="add_data" value="Buat Pesanan" disabled="disabled" />
                <!-- <button class="btn-buat-pesanan" type="submit" id="add-pesanan-btn" disabled>Tambah</button> -->
            </form>
        </div>

    </div>
</div>

<!-- <div class="tbl-container" id="Pesanan Baru" style="display: none;">
    <div class="tbl-content">
        <div class="tbl-header">
        <h3><a href="pesanan.php" class="tablink"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Buat Pesanan</a></h3>
            <div class="tbl-header-right">
                <input type="text" name="id-pesanan" readonly value=""> 
            </div>
        </div>
        <div class="tbl-table" id="showAllPesanan">
        </div>
    </div>
</div> -->

<div class="tbl-container" id="Pesanan Baru" style="display: none;">
    <div class="tbl-content">
        <div class="tbl-header">
            <button onclick="openCity(event, 'Buat Pesanan')">
                <i class="fa-sharp fa-solid fa-cart-plus">&nbsp;&nbsp;&nbsp;</i>Buat Pesanan
            </button>
            <div class="tbl-header-right">
                <a href="#"><i class="fa-solid fa-sort">&nbsp;&nbsp;&nbsp;</i>Sort</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-filter">&nbsp;&nbsp;&nbsp;</i>Filter</a>
            </div>
        </div>
        <div class="tbl-table" id="showAllPesanan">
            <div class="write">NOT</div>
        </div>
    </div>

</div>

<div class="tbl-container" id="Pesanan Proses" style="display: none;">
    <div class="tbl-content">
        <div class="tbl-header">
            <h3><a href="#" class="tablink" onclick="openCity(event, 'Semua Pesanan')"><i class="fa-solid fa-arrow-left"></i></a>&nbsp;&nbsp;&nbsp;Buat Pesanan</h3>
            <div class="tbl-header-right">
                <input type="text" name="id-pesanan" readonly value="<?= $tbl->idPesananIncrement(); ?>">
            </div>
        </div>
        <div class="box-container" id="showPilihProduk">

            <!-- <form action="" method="POST">
                <div class="boc">
                    <img src="">
                </div>
            </form> -->
        </div>
        <div class="tbl-table" id="showAllProdukk">
        </div>
    </div>
</div>
<!-- Link Ajax Request-->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    function openCity(evt, cityName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("tbl-container");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
        }
        document.getElementById(cityName).style.display = "flex";
        evt.currentTarget.className += " w3-red";
    }

    $(document).ready(function() {
        $("#pilihan-produk").click(function(e) {
            e.preventDefault();
            // $(this).text('Tunggu Sebentar...');
            $.ajax({
                url: '../asset/php/prosess.php',
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: {
                    action: 'addPesanan'
                },
                success: function(response) {
                    console.log(response);
                }
            });
        });

        fetchAllPesanan();

        function fetchAllPesanan() {
            $.ajax({
                url: '../asset/php/action.php',
                method: 'post',
                data: {
                    action: 'showAllPesanan'
                },
                success: function(response) {
                    // console.log(response);
                    $("#showAllPesanan").html(response);
                }
            });
        }

        // $('form > input#cek').keyup(function() {
        //     var empty = false;
        //     $('form > input').each(function() {
        //         if ($(this).val() == '') {
        //             empty = true;
        //         }
        //     });

        //     if (empty) {
        //         $('#add_data').attr('disabled', 'disabled');
        //     } else {
        //         $('#add_data').removeAttr('disabled');
        //     }
        // })

        $("body").on("click", ".btn-buat-pesanan", function(e) {
            if ($("#buat-pesanan-btn-form")[0].checkValidity()) {
                addPesanan_id = $(this).attr('id');
                e.preventDefault();
                $.ajax({
                    url: '../asset/php/prosess.php',
                    method: 'post',
                    data: {
                        addPesanan_id: addPesanan_id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response === 'berhasil') {
                            window.location = 'buat-pesanan.php?id_pesanan=<?php $dataa = $tbl->idPesananIncrement();
                                                                            echo $dataa; ?>';
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Terjadi kesalahan!, Silahkan Reffresh dan coba kembali.'
                            })
                        }
                    }
                });
            }
        });

    });

    // $("#modal-info-pelanggan").on("click", function() {
    //     $(".overlay, .popup").addClass("active");
    // });

    // $(".close").on("click", function() {
    //     $(".overlay, .popup").removeClass("active");
    // });

    $("#add-pengambilan-btn").click(function(e) {
        if ($("#add-pengambilan-form")[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: '../asset/php/prosess.php',
                method: 'post',
                data: $("#add-pengambilan-form").serialize() + '&action=addPengambilan',
                success: function(response) {
                    $("#add-pengambilan-form")[0].reset();
                    // console.log(response);
                    if (response === 'berhasil') {
                        // window.location = 'beranda.php';
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Data berhasil ditambahkan',
                            showConfirmButton: false,
                            timer: 5000
                        })
                        // location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan!'
                        })
                    }
                }
            });
        }
    });
    // fetchPilihProdukk();

    // function fetchPilihProdukk() {
    //     $.ajax({
    //         url: '../asset/php/action.php',
    //         method: 'post',
    //         data: {
    //             action: 'pilihProduk'
    //         },
    //         success: function(response) {
    //             // console.log(response);
    //             $("#showPilihProdukk").html(response);
    //         }
    //     });
    // }


    // });
    // });
</script>
</body>

</html>