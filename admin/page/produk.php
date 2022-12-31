<?php
require_once '../asset/php/sidebar.php';
$prd = new Auth();
?>
<div class="tbl-container">
    <div class="tbl-content">
        <div class="tbl-header">
            <a href="#popup1" style="color: #fff; background-color: #5FD3D0; text-decoration: none; font-size: small;" class="btn-left"><i class="fa-solid fa-user">&nbsp;&nbsp;&nbsp;</i>Tambah Produk</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="tbl-header-right">
                <a href="#"><i class="fa-solid fa-arrow-up-short-wide">&nbsp;&nbsp;&nbsp;</i>Sort</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-filter">&nbsp;&nbsp;&nbsp;</i>Filter</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <form action="" method="post" id="add-pesanan-form-search">
                    <input type="text" name="searchProduk" placeholder="Cari Produk..." id="searchProduk">
                </form>
            </div>
        </div>
        <div class="tbl-table" id="showAllUser"></div>

        <div id="popup1" class="overlay">
            <div class="popup">
                <h2>Tambah Produk</h2>
                <a class="close" href="produk.php">&times;</a>
                <div class="content">
                    Silahkan masukkan data produk
                </div>
                <div class="form-produk">
                    <form action="#" method="post" id="add-produk-form" enctype="multipart/form-data">
                        <input type="text" name="id-produk" value="<?= $prd->idProdukIncrement(); ?>" readonly>
                        <input type="file" name="foto-produk" required placeholder="Masukkan Foto Produk">
                        <input type="text" name="nama-produk" required placeholder="Masukkan Nama Produk">
                        <input type="text" name="harga-produk" required placeholder="Masukkan Harga Produk">
                        <br>
                        <br>

                        <button type="submit" id="add-produk-btn" name="add-produk-btn-n">Tambah</button>
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
                    action: 'fetchAllProdukk'
                },
                success: function(response) {
                    $("#showAllUser").html(response);
                }
            });
        }


        $("#add-produk-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '../asset/php/prosess.php',
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(this),
                success: function(response) {
                    // console.log(response);
                    if (response === 'berhasil') {
                        // window.location = 'beranda.php';
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Produk berhasil ditambahkan'
                        })
                        $("#add-produk-form")[0].reset();
                    } else if (response === 'gambar-tidak-valid') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            confirmButtonColor: '#5FD3D0',
                            text: 'Gambar harus JPG, JPEG dan PNG!'
                        })
                        $("#add-produk-form")[0].reset();
                    } else if (response === 'terlalu-besar') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            confirmButtonColor: '#5FD3D0',
                            text: 'Ukuran gambar harus kurang dari 10mb'
                        })
                        $("#add-produk-form")[0].reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan!'
                        })
                    }
                }
            });

        });

        $("body").on("click", ".deleteProdukIcon", function(e) {
            e.preventDefault();

            delP_id = $(this).attr('id');

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Data produk akan dihapus',
                type: 'warning',
                position: 'center',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '../asset/php/action.php',
                        method: 'post',
                        data: {
                            delP_id: delP_id
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data produk berhasil dihapus',
                                showConfirmButton: false,
                                timer: 5000
                            })
                            fetchAllUser();
                        }
                    })
                }
            })
        });
    });
</script>
</body>

</html>