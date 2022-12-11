<?php
require_once '../asset/php/sidebar.php';
$tbl = new Auth();
?>

<div class="tbl-container" id="Semua Pesanan">
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
            <h3><a href="#" class="tablink" onclick="openCity(event, 'Semua Pesanan')"><i class="fa-solid fa-arrow-left"></i></a>&nbsp;&nbsp;&nbsp;Buat Pesanan</h3>
            <div class="tbl-header-right">
                <input type="text" name="id-pesanan" readonly value="<?= $tbl->idPesananIncrement(); ?>">
            </div>
        </div>
        <!-- <div class="tbl-table" id="showAllProdukk"></div> -->

        <div class="form-add-pesanan">
            <form action="#" method="post" id="add-pesanan-form">
                <div class="add-id-pesanan">
                    <label><b>ID Pesanan</b></label>
                    <input type="text" name="id-pesanan" readonly value="<?= $tbl->idPesananIncrement(); ?>">
                </div>
                <div class="info-pelanggan">
                    <label><b>Info Pelanggan</b></label>
                    <button>
                        <i class="fa-solid fa-id-card"></i>
                        <label>Masukkan Pelanggan</label>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
                <label>Pilih Produk</label>
                <div class="info-produk-pesanan">
                    <button>
                        <i class="fa-solid fa-box-open"></i>
                        <label>Tambah Produk</label>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
                <label>Catatan Pesanan (Opsional)</label>
                <input type="text" name="nama-pelanggan" placeholder="Masukkan Nama Pelanggan">

                <label>Alamat</label>
                <input type="text" name="nama-pelanggan" placeholder="Masukkan Nama Pelanggan">

                <label>Pilih Karyawan</label>
                <input type="text" name="nama-pelanggan" placeholder="Masukkan Nama Keryawan">
                <br>
                <br>

                <button type="submit" id="add-pengambilan-btn">Tambah</button>
            </form>
        </div>

    </div>
</div>

<div class="tbl-container" id="Pesanan Baru" style="display: none;">
    <div class="tbl-content">
        <div class="tbl-header">
            <h3><a href="#" class="tablink" onclick="openCity(event, 'Semua Pesanan')"><i class="fa-solid fa-arrow-left"></i></a>&nbsp;&nbsp;&nbsp;Buat Pesanan</h3>
            <div class="tbl-header-right">
                <input type="text" name="id-pesanan" readonly value="<?= $tbl->idPesananIncrement(); ?>">
            </div>
        </div>
        <div class="tbl-table" id="showAllProdukk">
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

    $(document).ready(function() {
        fetchAllProdukk();

        function fetchAllProdukk() {
            $.ajax({
                url: '../asset/php/action.php',
                method: 'post',
                data: {
                    action: 'fetchAllProdukk'
                },
                success: function(response) {
                    // console.log(response);
                    $("#showAllProdukk").html(response);
                }
            });
        }

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


    });
</script>
</body>

</html>