<?php
require_once '../asset/php/sidebar.php';
$tbl = new Auth();
?>
<div class="tbl-container">
    <div class="tbl-content">
        <div class="tbl-header">
            <h3>Semua Pelanggan</h3>
            <div class="tbl-header-right">
                <a href="#"><i class="fa-solid fa-arrow-up-short-wide">&nbsp;&nbsp;&nbsp;</i>Sort</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-filter">&nbsp;&nbsp;&nbsp;</i>Filter</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <form action="" method="post" id="add-pesanan-form-search">
                    <input type="text" name="searchPelanggan" placeholder="Cari Pelanggan..." id="searchPesanan">
                </form>
            </div>
        </div>
        <div class="tbl-table" id="showAllPelanggan">
        </div>
    </div>
</div>
<!-- Link Ajax Request-->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    $(document).ready(function(){
        fetchAllPelanggan();
        function fetchAllPelanggan() {
            $.ajax({
                url: '../asset/php/action.php',
                method: 'post',
                data: {
                    action: 'fetchAllPelanggan'
                },
                success: function(response) {
                    $("#showAllPelanggan").html(response);
                }
            });
        }
    });
</script>
</body>

</html>