<?php
require_once '../asset/php/sidebar.php';
$kry = new Auth();
if (isset($_GET['id_akun'])) {
    $id = $_GET['id_akun'];
    $code = $kry->fetchAllUserByID($id);
}
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
                    <div class="alert"></div>
                    <form action="#" method="post" id="add-karyawan-form">
                        <input type="text" name="id-karyawan" value="<?= $kry->idKaryawan(); ?>" readonly>
                        <input type="text" name="nama-karyawan" required placeholder="Masukkan Nama">
                        <input type="text" name="email-karyawan" required placeholder="Masukkan Email">
                        <input type="password" name="kata-sandi-karyawan" required placeholder="Masukkan Kata Sandi">
                        <br>
                        <br>

                        <button type="submit" id="add-karyawan-btn" name="add-karyawan-btn-n">Tambah</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- <div class="tbl-container" id="view" style="display: none;">
    <div class="tbl-content">
        <div class="tbl-header">
            <h3>Semua Karyawan</h3>
        </div>
    </div>
</div> -->



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

        // var id_aktif;

        // function on(clicked_id) {
        //     document.getElementById("popupDetail").style.display = "block";
        //     document.getElementById(clicked_id).style.display = "block";
        //     id_aktif = clicked_id;
        // }

        // function off() {
        //     document.getElementById("popupDetail").style.display = "none";
        // document.getElementById(id_aktif).style.display = "none";
        // }

        // function openCity(evt, cityName) {
        //     var i, x, tablinks;
        //     x = document.getElementsByClassName("tbl-container");
        //     for (i = 0; i < x.length; i++) {
        //         x[i].style.display = "none";
        //     }
        //     tablinks = document.getElementsByClassName("userDetailIcon");
        //     for (i = 0; i < x.length; i++) {
        //         tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
        //     }
        //     document.getElementById(cityName).style.display = "flex";
        //     evt.currentTarget.className += " w3-red";
        // }

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
                        // window.location = 'beranda.php';
                        // console.log(response);
                        if (response === 'berhasil') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Karyawan berhasil ditambahkan',
                                showConfirmButton: false,
                                timer: 5000
                            })
                            $("#add-karyawan-form")[0].reset();
                            // location.reload();
                        } else if (response === 'exist') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Email ini sudah terdaftar!'
                            })
                            $("#add-karyawan-form")[0].reset();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan!'
                            })
                            $("#add-karyawan-form")[0].reset();
                        }
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
        //             console.log(data);   
        //             $("#getName").text(data.username + ' ' + '(ID : ' + data.id_akun + ')');
        //             $("#getEmail").text('E-Mail : ' + data.email);
        //             $("#getPhone").text('No. WhatsApp : ' + data.no_telp);
        //             $("#getAlamat").text('Alamat : ' + data.alamat);
        //             $("#getCreated").text('Terdaftar Pada Tanggal : ' + data.created_at);
        //             $("#getVerified").text('Verifikasi : ' + data.verified);
        //         }
        //     });
        // });

        $("body").on("click", ".hapusUserIcon", function(e) {
            e.preventDefault();

            del_id = $(this).attr('id');

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Anda akan kehilangan data ini',
                type: 'warning',
                position: 'center',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iyaa, Hapus Akun Ini'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '../asset/php/action.php',
                        method: 'post',
                        data: {
                            del_id: del_id
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Akun berhasil di hapus',
                                showConfirmButton: false,
                                timer: 5000
                            })
                            fetchAllUser();
                        }
                    })
                }
            })
        });

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