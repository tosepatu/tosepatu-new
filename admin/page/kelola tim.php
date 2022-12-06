<?php
require_once '../asset/php/sidebar.php';
$tbl = new Auth();
?>
<div class="tbl-container">
    <div class="tbl-content">
        <div class="tbl-header">
            <h3>Semua Karyawan</h3>
            <div class="tbl-header-right">
                <a href="#"><i class="fa-solid fa-user">&nbsp;&nbsp;&nbsp;</i>Tambah Karyawan</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-sort">&nbsp;&nbsp;&nbsp;</i>Sort</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-filter">&nbsp;&nbsp;&nbsp;</i>Filter</a>
            </div>
        </div>
        <div class="tbl-table" id="showAllUser">
            
        </div>
    </div>
</div>
<!-- Link Ajax Request-->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    $(document).ready(function(){
        fetchAllUser();
        function fetchAllUser() {
            $.ajax({
                url: '../asset/php/action.php',
                method: 'post',
                data: {
                    action: 'fetchAllUser'
                },
                success: function(response) {
                    $("#showAllUser").html(response);
                }
            });
        }
    });
</script>
</body>

</html>