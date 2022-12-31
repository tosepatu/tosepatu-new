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
                                $dataa = $tbl->idPesananIncrement();
                                echo $dataa;
                                ?>" class="btn-buat-pesanan">
                    <i class="fa-sharp fa-solid fa-cart-plus">&nbsp;&nbsp;&nbsp;</i>Buat Pesanan
                </a>
            </form>
            <div class="tbl-header-right">
                <a href="#" onclick="sort(0)" class="sortById"><i class="fa-solid fa-arrow-up-short-wide">&nbsp;&nbsp;&nbsp;</i>Sort</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#"><i class="fa-solid fa-filter">&nbsp;&nbsp;&nbsp;</i>Filter</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <form action="" method="post" id="add-pesanan-form-search">
                    <input type="text" name="searchPesanan" placeholder="Cari Pesanan..." id="searchPesanan">
                </form>
            </div>
        </div>
        <div class="tab-menu">
            <button class="tablink w3-red" onclick="openCity(event,'showAllPesanan')">Semua Pesanan</button>
            <button class="tablink" onclick="openCity(event,'showPesananBaru')">Pesanan Baru</button>
            <button class="tablink" onclick="openCity(event,'showPesananProses')">Pesanan Di Proses</button>
            <button class="tablink" onclick="openCity(event,'showPesananSelesai')">Pesanan Selesai</button>
            <button class="tablink" onclick="openCity(event,'showPesananBatal')">Pesanan Dibatalkan</button>
        </div>
        <div class="tbl-table" id="showAllPesanan"></div>
        <div class="tbl-table" id="showPesananBaru" style="display: none;"></div>
        <div class="tbl-table" id="showPesananProses" style="display: none;"></div>
        <div class="tbl-table" id="showPesananSelesai" style="display: none;"></div>
        <div class="tbl-table" id="showPesananBatal" style="display: none;"></div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Link Ajax Request-->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    function openCity(evt, cityName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("tbl-table");
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

    function sort(evt, sortName) {
        var i, x, sortById;
        x = document.getElementsByClassName("tbl-table");
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
        fetchAllPesanan();

        function fetchAllPesanan() {
            $.ajax({
                url: '../asset/php/action.php',
                method: 'post',
                data: {
                    action: 'showAllPesanan'
                },
                success: function(response) {
                    $("#showAllPesanan").html(response);
                }
            });
        }

        fetchPesananBaru();

        function fetchPesananBaru() {
            $.ajax({
                url: '../asset/php/action.php',
                method: 'post',
                data: {
                    action: 'showPesananBaru'
                },
                success: function(response) {
                    // console.log(response);
                    $("#showPesananBaru").html(response);
                }
            });
        }

        fetchPesananProses();

        function fetchPesananProses() {
            $.ajax({
                url: '../asset/php/action.php',
                method: 'post',
                data: {
                    action: 'showPesananProses'
                },
                success: function(response) {
                    // console.log(response);
                    $("#showPesananProses").html(response);
                }
            });
        }

        fetchPesananSelesai();

        function fetchPesananSelesai() {
            $.ajax({
                url: '../asset/php/action.php',
                method: 'post',
                data: {
                    action: 'showPesananSelesai'
                },
                success: function(response) {
                    // console.log(response);
                    $("#showPesananSelesai").html(response);
                }
            });
        }

        fetchPesananBatal();

        function fetchPesananBatal() {
            $.ajax({
                url: '../asset/php/action.php',
                method: 'post',
                data: {
                    action: 'showPesananBatal'
                },
                success: function(response) {
                    // console.log(response);
                    $("#showPesananBatal").html(response);
                }
            });
        }

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
                        // console.log(response);
                        if (response === 'berhasil') {
                            window.location = 'buat-pesanan.php?id_pesanan=<?php $dataa = $tbl->idPesananIncrement();
                                                                            echo $dataa; ?>';
                        } else if (response === 'memiliki pesanan yang belum selesai') {
                            Swal.fire({
                                title: 'Anda memiliki pesanan yang belum terselesaikan.',
                                text: 'Lanjutkan Pesanan?',
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
                                            action: 'addPesanan_id_'
                                        },
                                        success: function(response) {
                                            // console.log(response);
                                            window.location = 'buat-pesanan.php?id_pesanan=' + response;
                                        }
                                    })
                                }
                            })
                        } else {
                            console.log(response);
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

        $('#searchPesanan').keyup(function() {
            var searchPesanan = $("#searchPesanan").val();
            if (searchPesanan === '') {
                fetchAllPesanan();
            } else {
                load_data(searchPesanan);
            }
        });

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("showAllPesanan");
            switching = true;
            //Set the sorting direction to ascending:
            dir = "asc";
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /*check if the two rows should switch place,
                    based on the direction, asc or desc:*/
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    //Each time a switch is done, increase this count by 1:
                    switchcount++;
                } else {
                    /*If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again.*/
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    });

    load_data();

    function load_data(searchPesanan) {
        $.ajax({
            url: "../asset/php/action.php",
            method: "POST",
            data: {
                searchPesanan: searchPesanan
            },
            success: function(response) {
                $('#showAllPesanan').html(response);
            }
        });
    }

    $(document).on("click", ".status-pesanan-proses", function(e) {
        e.preventDefault();

        upStatusPesanan_id = $(this).attr('id');

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: 'Status pesanan akan diperbarui',
            type: 'warning',
            position: 'center',
            icon: 'info',
            showCloseButton: true,
            showDenyButton: true,
            confirmButtonColor: '#F5B12C',
            cancelButtonColor: '#e8392f',
            confirmButtonText: 'Pesanan Selesai',
            denyButtonText: 'Batalkan Pesanan',
            focusConfirm: false,
            focusCancal: false,
            returnFocus: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../asset/php/prosess.php',
                    method: 'post',
                    data: {
                        upStatusPesanan_selesai: upStatusPesanan_id
                    },
                    success: function(response) {
                        location.reload(true);
                    }
                })
            } else if (result.isDenied) {
                $.ajax({
                    url: '../asset/php/prosess.php',
                    method: 'post',
                    data: {
                        upStatusPesanan_batalkan: upStatusPesanan_id
                    },
                    success: function(response) {
                        location.reload(200);
                    }
                })
            }
        })
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