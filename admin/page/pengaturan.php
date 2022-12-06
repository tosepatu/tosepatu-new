<?php
require_once '../asset/php/sidebar.php';

?>
<div class="tbl-container-pengaturan">
    <div class="tbl-profile">
        <div class="tab-menu">
            <button class="tablink w3-red" onclick="openCity(event,'Profil')">Profil Akun</button>
            <button class="tablink" onclick="openCity(event,'EProfil')">Edit Profil</button>
            <button class="tablink" onclick="openCity(event,'UKataSandi')">Ubah Kata Sandi</button>
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
                    <img src="../asset/img/avatarr.png">
                <?php else : ?>
                    <img src="<?= '../asset/php/' . $cphoto; ?>">
                <?php endif; ?>
            </div>
        </div>

        <div id="EProfil" class="city" style="display:none">
            <div class="rec-photos-E">
                <?php if (!$cphoto) : ?>
                    <img src="../asset/img/avatarr.png">
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
                <img src="../asset/img/change-pass.png">
            </div>
        </div>
    </div>
</div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<!-- Function halaman profile -->
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

    // proces edit
    $("#edit-profile-form").submit(function(e) {
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
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Profil akun berhasil diubah',
                        showConfirmButton: false,
                        timer: 5000
                    })
                    location.reload();
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

    // proces change password
    $("#change-password-btn").click(function(e) {
        if ($("#change-password-form")[0].checkValidity()) {
            e.preventDefault();
            // if ($("#npass").val() != $("#cpass").val()) {
            //     $("#change-password-error").text('* Kata Sandi tidak cocok!');
            // } else {
            $.ajax({
                url: '../asset/php/prosess.php',
                method: 'post',
                data: $("#change-password-form").serialize() + '&action=change_pass',
                success: function(response) {
                    $("#change-password-alert").html(response);
                    $("#change-password-form")[0].reset();
                }
            });
            // }
        }
    });

    // verifikai email
    $("#verify-email").click(function(e) {
        e.preventDefault();
        $(this).text('Tunggu Sebentar...');
        $.ajax({
            url: '../asset/php/prosess.php',
            method: 'post',
            data: {
                action: 'verify-email'
            },
            success: function(response) {
                if (response === 'terkirim') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Link Terkirim, Check email sekarang',
                        showConfirmButton: false,
                        timer: 5000
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan!'
                    })
                }
                $("#verify-email").text('Verifikasi sekarang');
            }
        });
    });

    var selector = 'li';
    $(selector).on('click', function() {
        $(selector).removeClass("active");
        $(this).addClass("active");
    });
</script>
</body>

</html>