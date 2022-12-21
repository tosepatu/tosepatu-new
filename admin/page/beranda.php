<?php
require_once '../asset/php/sidebar.php';
require_once '../asset/php/auth.php';

$count = new Auth();
// $msg = '';
?>

<div class="card">
    <div class="card-box" style="border-color: #FFE61B;">
        <h4 style="color: #FFE61B">Jumlah Produk</h4>
        <p style="color: #FFE61B;">
            <?= $count->totalCount('layanan'); ?>
        </p>
    </div>
    <div class="card-box" style="border-color: #EC524B;">
        <h4 style="color: #EC524B;">Toko Dilihat</h4>
        <p style="color: #EC524B;">
            <?php $data = $count->siteHits();
            echo $data['hits']; ?>
        </p>
    </div>
    <div class="card-box" style="border-color: #2BB6F1;">
        <h4 style="color: #2BB6F1;">Dalam Proses</h4>
        <p style="color: #2BB6F1;">209</p>
    </div>
    <div class="card-box" style="border-color: #F5B12C;">
        <h4 style="color: #F5B12C;">Total Pesanan</h4>
        <p style="color: #F5B12C;">
            <?= $count->totalCount('detail_pesanan'); ?>
        </p>
    </div>
</div>

<div class="content-data">
    <div class="chart">
        <div class="card-header">
            <h3>
                <?php
                $bulan = date("F");
                echo 'Grafik Pemesanan ' . $count->bulan($bulan);
                ?>
            </h3>
            <p>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                echo $today = date('j F Y, g:i A');
                ?>
            </p>
        </div>
        <div class="cont-chart">
            <canvas id="chart-line" class="chart-canvas"></canvas>
        </div>
    </div>

    <div class="content-right">
        <div class="quick-access">
            <div class="tittle-quick">
                <i class="fa-solid fa-store"></i>
                <h4>Quick Access</h4>
            </div>
            <div class="item-quick">
                <a href="#popup1" class="link-add-produk"><i class="fa-solid fa-square-plus"></i>Tambah Produk</a>

                <div id="popup1" class="overlay">
                    <div class="popup">
                        <h2>Tambah Produk</h2>
                        <a class="close" href="beranda.php">&times;</a>
                        <div class="content">
                            Silahkan masukkan data produk
                        </div>
                        <div class="form-produk">
                            <form action="#" method="post" id="add-produk-form" enctype="multipart/form-data">
                                <input type="text" name="id-produk" value="<?= $count->idProdukIncrement(); ?>" readonly>
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

                <a href="#popup2" class="link-add-produk"><i class="fa-solid fa-truck-fast"></i>Tambah Metode Pengambilan</a>

                <div id="popup2" class="overlay">
                    <div class="popup">
                        <h2>Tambah Metode Pengambilan</h2>
                        <a class="close" href="beranda.php">&times;</a>
                        <div class="content">
                            Silahkan masukkan data metode pengambilan
                        </div>
                        <div id="alert"></div>
                        <div class="form-pesanan">
                            <form action="#" method="post" id="add-pengambilan-form">
                                <input type="text" name="id-pengambilan" readonly value="<?= $count->idPengirimanIncrement(); ?>">
                                <input type="text" name="nama-pengambilan" placeholder="Masukkan Nama pengambilan">
                                <br>
                                <br>

                                <button type="submit" id="add-pengambilan-btn">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="status-karyawan">
            <div class="tittle-status">
                <i class="fa-solid fa-user-check"></i>
                <h4>Status Karyawan</h4>
            </div>
            <div class="item-status">
                <li><a href="kelola tim.php">Achmad Zakariya</a><i class="fa-solid fa-circle-check"></i></li>
                <li><a href="kelola tim.php">A. Maulana Subandrio</a><i class="fa-solid fa-circle-check"></i></li>
                <li><a href="kelola tim.php">Refyan Gigas</a><i class="fa-solid fa-circle-check"></i></li>
                <li><a href="kelola tim.php">Daffa Fauzi</a><i class="fa-solid fa-circle-check"></i></li>
                <li><a href="kelola tim.php">Akbar Kusnandi</a><i class="fa-solid fa-circle-check"></i></li>
            </div>
        </div>
    </div>
</div>
</div>
</section>

<!--   Core JS Files   -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>
<!-- Line Chart -->
<script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(95, 211, 208, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(95, 211, 208, 0.2)');
    gradientStroke1.addColorStop(0, 'rgba(95, 211, 208, 0.2)');
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Mobile apps",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#5FD3D0",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                maxBarThickness: 6

            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#fbfbfb',
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#ccc',
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
</script>
<!-- Link auth line chart -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- <script src="path/to/chartjs/dist/chart.umd.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Link ajax -->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<!-- ajax request -->
<script>
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

    var x, i, j, l, ll, selElmnt, a, b, c;
    /*cari elemen apa saja dengan kelas "pilih-produk":*/
    x = document.getElementsByClassName("pilih-produk");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /* buat DIV baru untuk item yang dipilih:*/
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*\buat DIV baru dari daftar option:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
            /*untuk setiap option dalam pilihan,
            buat DIV baru sebagai item opsi:*/
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /*ketika item diklik, perbarui option/select,
                dan item yang dipilih:*/
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /*ketika option diklik, tutup kotak pilih lainnya,
            dan buka kotak pilih yang dipilih:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        /*fungsi untuk menutup semua kotak pilih dalam dokumen,
        kecuali kotak pilihan:*/
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }
    /*jika pengguna mengklik di mana saja di luar option,
    tutup semua kotak pilihan:*/
    document.addEventListener("click", closeAllSelect);
</script>

</body>

</html>
<?php
// } else {
//     header("Location: ../login-admin/index.php");
// }
?>