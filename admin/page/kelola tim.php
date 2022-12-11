<?php
require_once '../asset/php/sidebar.php';
$kry = new Auth();
?>
<div class="tbl-container">
    <div class="tbl-content">
        <div class="tbl-header">
            <h3>Semua Karyawan</h3>
            <div class="tbl-header-right">
                <a href="#popup1"><i class="fa-solid fa-user">&nbsp;&nbsp;&nbsp;</i>Tambah Tim</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-sort">&nbsp;&nbsp;&nbsp;</i>Sort</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-filter">&nbsp;&nbsp;&nbsp;</i>Filter</a>
            </div>
        </div>

        <div class="tbl-table" id="showAllUser"></div>
        <div id="popup1" class="overlay">
            <div class="popup">
                <h2>Tambah Tim</h2>
                <a class="close" href="kelola tim.php">&times;</a>
                <div class="content">
                    Silahkan masukkan data karyawan baru
                </div>
                <div class="form-add-karyawan">
                    <form action="#" method="post" id="add-karyawan-form">
                        <input type="text" name="id-karyawan" value="<?= $kry->idKaryawan(); ?>" readonly>
                        <input type="text" name="nama-karyawan" required placeholder="Masukkan Nama">
                        <input type="text" name="email-karyawan" required placeholder="Masukkan Email">
                        <input type="password" name="kata-sandi-karyawan" required placeholder="Masukkan Kata Sandi">
                        <div id="showOption"></div>
                        <br>
                        <br>

                        <button type="submit" id="add-karyawan-btn" name="add-karyawan-btn-n">Tambah</button>
                    </form>
                </div>
            </div>
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
                    action: 'fetchAllUser'
                },
                success: function(response) {
                    $("#showAllUser").html(response);
                }
            });
        }

        // showOption();

        // function showOption() {
        //     $.ajax({
        //         url: '../asset/php/action.php',
        //         method: 'post',
        //         data: {
        //             action: 'showOption'
        //         },
        //         success: function(response) {
        //             $("#showOption").html(response);
        //         }
        //     });
        // }

        $("#add-karyawan-btn").click(function(e) {
            if ($("#add-karyawan-form")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: '../asset/php/prosess.php',
                    method: 'post',
                    data: $("#add-karyawan-form").serialize() + '&action=addKaryawan',
                    success: function(response) {
                        $("#add-karyawan-form")[0].reset();
                        // window.location = 'beranda.php';
                        console.log(response);
                        // if (response === 'berhasil') {
                        //     Swal.fire({
                        //         position: 'center',
                        //         icon: 'success',
                        //         title: 'Karyawan berhasil ditambahkan',
                        //         showConfirmButton: false,
                        //         timer: 5000
                        //     })
                        //     // location.reload();
                        // } else {
                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: 'Oops...',
                        //         text: 'Terjadi kesalahan!'
                        //     })
                        // }
                    }
                });
            }
        });

        // $("body").on("click", ".userDetailIcon", function(e) {
        //     e.preventDefault();

        //     details_id = $(this).attr('id');

        //     $.ajax({
        //         url: '../asset/php/action.php',
        //         type: 'post',
        //         data: {
        //             details_id: details_id
        //         },
        //         success: function(response) {
        //             data = JSON.parse(response);
        //             // console.log(data);
        //             $("#getName").text(data.username + ' ' + '(ID : ' + data.id_akun + ')');
        //             $("#getEmail").text('E-Mail : ' + data.email);
        //             $("#getPhone").text('No. WhatsApp : ' + data.no_telp);
        //             $("#getAlamat").text('Alamat : ' + data.alamat);
        //             $("#getCreated").text('Terdaftar Pada Tanggal : ' + data.created_at);
        //             $("#getVerified").text('Verifikasi : ' + data.verified);
        //         }
        //     });
        // });

        // $('.userDetailIcon').click(function(e) {
        //     e.preventDefault();
        //     details_id = $(this).attr('id');
        //     $.ajax({
        //         url: '../asset/php/action.php',
        //         type: 'post',
        //         data: {
        //             action: details_id
        //         },
        //         success: function(response) {
        //             data = JSON.parse(response);
        //             console.log(data);
        //             // $("#getName").text(data.username + ' ' + '(ID : ' + data.id_akun + ')');
        //             // $("#getEmail").text('E-Mail : ' + data.email);
        //             // $("#getPhone").text('No. WhatsApp : ' + data.no_telp);
        //             // $("#getAlamat").text('Alamat : ' + data.alamat);
        //             // $("#getCreated").text('Terdaftar Pada Tanggal : ' + data.created_at);
        //             // $("#getVerified").text('Verifikasi : ' + data.verified);
        //             // $("#popupDetail").html(response);
        //         }
        //     });

        // });
    });
</script>
</body>

</html>