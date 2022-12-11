<?php
require_once '../asset/php/sidebar-karyawan.php';
require_once '../asset/php/auth-karyawan.php';

// $count = new Auth();
?>
<div class="tbl-container-pengaturan">
    <div class="tbl-profile">
        <div class="tab-menu">
            <button class="tablink w3-red" onclick="openCity(event,'Profil')">Profil Akun</button>
            <button class="tablink" onclick="openCity(event,'EProfil')">Edit Profil</button>
            <button class="tablink" onclick="openCity(event,'UKataSandi')">Ubah Kata Sandi</button>
            <!-- <button class="tablink" onclick="openCity(event,'Produk')">Produk Layanan</button> -->
        </div>

        <div id="Profil" class="city">
            <div class="rec-data">
                <div id="verify-alert"></div>
                <div class="rec-data-header">
                    ID Pengguna : <?= $cid; ?>
                </div>
                <div class="rec-data-body">
                    <p><b>Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><?= $cname; ?></p>
                    <p><b>E-mail &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><?= $cemail; ?></p>
                    <p><b>Alamat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><?= $calamat; ?></p>
                    <p><b>No. WhatsApp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><?= $ctelp; ?></p>
                    <p><b>Terdaftar tanggal &nbsp;&nbsp;&nbsp;&nbsp;: </b><?= $reg_on; ?></p>
                    <p><b>Verifikasi E-Mail &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><?= $verified; ?>
                        <?php if ($verified == 'Belum Verifikasi!') : ?>
                            <a href="" id="verify-email" class="verify-email">Verifikasi sekarang</a>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="rec-photos">
                <?php if (!$cphoto) : ?>
                    <img src="../../admin/asset/img/avatarr.png">
                <?php else : ?>
                    <img src="<?= '../../asset/php/' . $cphoto; ?>">
                <?php endif; ?>
            </div>
        </div>

        <div id="EProfil" class="city" style="display:none">
            <div class="rec-photos-E">
                <?php if (!$cphoto) : ?>
                    <img src="../../admin/asset/img/avatarr.png">
                <?php else : ?>
                    <img src="<?= '../asset/php/' . $cphoto; ?>">
                <?php endif; ?>
            </div>
            <div class="rec-data-E">
                <div class="rec-data-body-E">
                    <div class="form-edit-profile">
                        <form action="" method="POST" enctype="multipart/form-data" id="edit-profile-form">
                            <input type="hidden" name="old-foto-profile" value="<?= $cphoto; ?>">
                            <label>Unggah Foto Profil</label>
                            <input type="file" name="foto-profile">
                            <label>Nama</label>
                            <input type="text" name="nama-pengguna" value="<?= $cname; ?>">
                            <label>E-mail</label>
                            <input type="text" name="email-pengguna" value="<?= $cemail; ?>">
                            <label>Alamat</label>
                            <input type="text" name="alamat-pengguna" value="<?= $calamat; ?>">
                            <label>No. WhatsApp</label>
                            <input type="text" name="no_telp-pengguna" value="<?= $ctelp; ?>">
                            <button type="submit" id="edit-profile-btn" name="edit-profile-btn-n">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="UKataSandi" class="city" style="display:none">
            <div class="rec-data-U">
                <div class="rec-data-header">
                    ID Pengguna : <?= $cid; ?>
                </div>
                <div class="rec-data-body-U">
                    <div class="form-change-password">
                        <form action="" method="POST" id="change-password-form">
                            <div id="change-password-alert"></div>
                            <label>Kata Sandi Saat Ini</label>
                            <input type="password" name="cupass" id="cupas" placeholder="Masukkan Kata Sandi Saat Ini">
                            <label>Kata Sandi Baru</label>
                            <input type="password" name="npass" id="npass" placeholder="Masukkan Kata Sandi Baru">
                            <label>Konfirmasi Kata Sandi</label>
                            <input type="password" name="cpass" id="cpass" placeholder="Masukkan Konfirmasi Kata Sandi">

                            <button type="submit" id="change-password-btn" name="change-password-btn-n">Ubah Kata Sandi</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="rec-photos-U">
                <img src="../../admin/asset/img/change-pass.png">
            </div>
        </div>
    </div>
</div>
</section>

<!--   Core JS Files   -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script> -->
<!-- Line Chart -->
<script>
    function openCity(evt, cityName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("city");
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
    // var ctx1 = document.getElementById("chart-line").getContext("2d");

    // var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    // gradientStroke1.addColorStop(1, 'rgba(95, 211, 208, 0.2)');
    // gradientStroke1.addColorStop(0.2, 'rgba(95, 211, 208, 0.2)');
    // gradientStroke1.addColorStop(0, 'rgba(95, 211, 208, 0.2)');
    // new Chart(ctx1, {
    //     type: "line",
    //     data: {
    //         labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    //         datasets: [{
    //             label: "Mobile apps",
    //             tension: 0.4,
    //             borderWidth: 0,
    //             pointRadius: 0,
    //             borderColor: "#5FD3D0",
    //             backgroundColor: gradientStroke1,
    //             borderWidth: 3,
    //             fill: true,
    //             data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
    //             maxBarThickness: 6

    //         }],
    //     },
    //     options: {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //         plugins: {
    //             legend: {
    //                 display: false,
    //             }
    //         },
    //         interaction: {
    //             intersect: false,
    //             mode: 'index',
    //         },
    //         scales: {
    //             y: {
    //                 grid: {
    //                     drawBorder: false,
    //                     display: true,
    //                     drawOnChartArea: true,
    //                     drawTicks: false,
    //                     borderDash: [5, 5]
    //                 },
    //                 ticks: {
    //                     display: true,
    //                     padding: 10,
    //                     color: '#fbfbfb',
    //                     font: {
    //                         size: 11,
    //                         family: "Open Sans",
    //                         style: 'normal',
    //                         lineHeight: 2
    //                     },
    //                 }
    //             },
    //             x: {
    //                 grid: {
    //                     drawBorder: false,
    //                     display: false,
    //                     drawOnChartArea: false,
    //                     drawTicks: false,
    //                     borderDash: [5, 5]
    //                 },
    //                 ticks: {
    //                     display: true,
    //                     color: '#ccc',
    //                     padding: 20,
    //                     font: {
    //                         size: 11,
    //                         family: "Open Sans",
    //                         style: 'normal',
    //                         lineHeight: 2
    //                     },
    //                 }
    //             },
    //         },
    //     },
    // });
</script>
<!-- Link auth line chart -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- <script src="path/to/chartjs/dist/chart.umd.js"></script> -->
<!-- Link Ajax Request-->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<!-- Ajax add produk request -->
<script>
    // $(document).ready(function() {
    //     $("#add-produk-btn").click(function(e) {
    //         if ($("#add-produk-form")[0].checkValidity()) {
    //             e.preventDefault();
    //             $.ajax({
    //                 url: '../asset/php/action.php',
    //                 method: 'post',
    //                 data: $("#add-produk-btn").serialize() + '$action=tambahproduk',
    //                 success: function(response) {
    //                     console.log(response);
    //                     if (response === 'tambahproduk') {
    //                         $("#alert").html(response);
    //                     } else {
    //                         $("#aAlert").html(response);
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });
</script>

</body>

</html>
<?php
// } else {
//     header("Location: ../login-admin/index.php");
// }
?>