<?php
require_once '../asset/php/sidebar.php';
$tbl = new Auth();
?>

<div class="tbl-container" id="Pesanan">
    <div class="tbl-content">
        <div class="tbl-header">
            <h3>Semua Pesanan</h3>
            <div class="tbl-header-right">
                <!-- <button class="tablink w3-red" onclick="openCity(event,'Profil')">Buat Pesanan</button> -->
                <a href="#" class="tablink w3-red" onclick="openCity(event, 'Buat Pesanan')"><i class="fa-sharp fa-solid fa-cart-plus">&nbsp;&nbsp;&nbsp;</i>Buat Pesanan</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" class="tablink"><i class="fa-solid fa-sort">&nbsp;&nbsp;&nbsp;</i>Sort</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" class="tablink"><i class="fa-solid fa-filter">&nbsp;&nbsp;&nbsp;</i>Filter</a>
            </div>
        </div>
        <div class="tbl-table" id="showAllPesanan">
        </div>
    </div>

</div>

<div class="tbl-container" id="Buat Pesanan" style="display: none;">
    <div class="tbl-content">
        <div class="tbl-header">
            <h3><a href="#" class="tablink" onclick="openCity(event, 'Pesanan')"><i class="fa-solid fa-arrow-left"></i></a>&nbsp;&nbsp;&nbsp;Buat Pesanan</h3>
            <div class="tbl-header-right">
                <!-- <a href="#"><i class="fa-sharp fa-solid fa-cart-plus">&nbsp;&nbsp;&nbsp;</i>Buat Pesanan</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                <a href="#"><i class="fa-solid fa-sort">&nbsp;&nbsp;&nbsp;</i>Sort</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-filter">&nbsp;&nbsp;&nbsp;</i>Filter</a>
            </div>
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
    });
</script>
</body>

</html>