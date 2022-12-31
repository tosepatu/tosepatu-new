<?php
include_once 'admin/asset/php/config/config.php';
$db = new Database();
$sql = "UPDATE pengunjung SET hits = hits + 1 WHERE id_pengunjung = 0";
$stmt = $db->conn->prepare($sql);
$stmt->execute();
session_start();
if (isset($_SESSION['userAdmin'])) {
    header('Location: ../../admin/page/beranda.php');
}
?>
<!DOCTYPE html>
<html lang="en" id="#">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tosepatu - Anda Untung Kami Berkah</title>
  

  <!-- Font cdn link js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <!-- Link eksternal file CSS -->
  <link rel="stylesheet" href="home/assets/css/style.css" />

  <!-- Icon -->
  <link rel="shortcut icon" href="home/assets/img/icon-tab.jpg" />

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>

<body>
  <!-- Landing Page Start -->
  <!-- Awal Header -->
  <header>
    <a href="#" class="logo">
      <img src="home/assets/img/Logo_ToSepatu_no_bg.png" alt="Logo Tosepatu" height="100px" />
    </a>
    <div id="menu-bar" class="fas fa-bars"></div>
    <nav class="navbar">
      <a href="#tentang">Tentang</a>
      <a href="#layanan">Layanan</a>
      <a href="#carakerja">Cara Kerja</a>
      <a href="#mobileapp" class="nav-link">Unduh Aplikasi Seluler</a>
      <a href="home/page/masuk.php" class="btn">Masuk</a>
    </nav>
  </header>
  <!-- Akhir Header -->

  <!-- Awal Home Section -->
  <section class="home" id="home">
    <div class="content">
      <h3>Layanan Jasa Cuci Sepatu</h3>
      <p>
        ToSepatu merupakan usaha dalam bidang jasa cuci sepatu yang
        menyediakan beberapa layanan cuci sepatu dengan harga terjangkau,
        layanan cepat, dan hasil yang tepat.
      </p>
      <a href="#mobileapp" class="btn">Pesan Sekarang</a>
    </div>
    <div class="image">
      <img src="home/assets//img/new-pair-white-sneakers-isolated-white 1 (1).png" alt="White Sneakers" />
    </div>
  </section>
  <!-- Akhir Home Section -->

  <!-- Awal tentang -->
  <section class="tentang" id="tentang">
    <div class="box-container">
      <div class="box-pertama">
        <h3>Tentang Kami</h3>
        <p>
          Terbentuknya kami ber-awal dari sekelompok pertemanan yang sedang memikirkan kehidupan untuk mengisi waktu luang.
          Dimulainya bisnis ini pada tanggal 21 September 2022, sementara sampai saat ini 
          tempatnya berada di Kabupaten Jember.
        </p>
      </div>
      <div class="box">
        <div class="box-content">
          <img src="home/assets//img/box-1.png" alt="box-1" height="200px" width="180px" />
          <h5>Struktur layanan bisnis yang kompeten.</h5>
        </div>
      </div>
      <div class="box-center">
        <div class="box-content">
          <img src="home/assets//img/box-2.png" alt="box-2" height="200px" width="168px" />
          <h5>Kinerja tim yang solid untuk kenyamanan bersama.</h5>
        </div>
      </div>
      <div class="box">
        <div class="box-content">
          <img src="home/assets//img/box-3.png" alt="box-3" height="200px" width="180px" />
          <h5>Pelayanan cepat demi kepuasan kalian semua.</h5>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Tentang -->

  <!-- Awal Layanan -->
  <section class="layanan" id="layanan">
    <div class="deepclean1">
      <div class="pic-component">
        <img src="home/assets//img/layanan-1.png" alt="deepclean" />
      </div>
      <div class="component">
        <h5>Layanan 1</h5>
        <h3>Deep Clean</h3>
        <p>
          layanan pertama ini untuk cuci sepatu semua bagian seperti Upper, Midsole, Outsole, Insole serta tali sepatu.
        </p>
        <a href="#" class="btn">Baca Selengkapnya</a>
      </div>
    </div>
    <div class="deepclean2">
      <div class="component">
        <h5>Layanan 2</h5>
        <h3>Deep Clean + Sepatu Putih</h3>
        <p>
          Pada layanan ini hanya dikhususkan untuk sepatu yang dominan putih. Layanan ini untuk cuci sepatu bagian seperti Upper, Midsole, Outsole, Insole serta tali sepatu.
        </p>
        <a href="#" class="btn">Baca Selengkapnya</a>
      </div>
      <div class="pic-component">
        <img src="home/assets//img/layanan-2.png" alt="deepclean+sepatuputih" />
      </div>
    </div>
  </section>
  <!-- Akhir Layanan -->

  <!-- Awal Cara Kerja -->
  <section class="carakerja" id="carakerja">
    <div class="step-container">
      <h3>Cara Kerja</h3>
      <div class="step">
        <p>Download Aplikasi mobile di playstore atau appstore.</p>
        <div class="step-box">
          <p>01</p>
        </div>
      </div>
      <div class="step">
        <p>Daftarkan akun anda dan masuk pada aplikasi.</p>
        <div class="step-box">
          <p>02</p>
        </div>
      </div>
      <div class="step">
        <p>Silahkan pilih layanan dan pesan.</p>
        <div class="step-box">
          <p>03</p>
        </div>
      </div>
      <div class="step">
        <p>Tunggu konfirmasi dari admin.</p>
        <div class="step-box">
          <p>04</p>
        </div>
      </div>
      <div class="step">
        <p>Setelah konfirmasi, pesanan akan di proses.</p>
        <div class="step-box">
          <p>05</p>
        </div>
      </div>
    </div>
    <div class="image-step">
      <img src="home/assets//img/cara-kerja.png" alt="cara-kerja" />
    </div>
  </section>
  <!-- Akhir Cara Kerja -->

  <!-- Awal mobile app -->
  <div class="mobileapp" id="mobileapp">
    <img src="home/assets//img/mobile.png" alt="mobileapp" />
    <div class="content">
      <h3>Unduh aplikasi ini</h3>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Urna, ac
        interdum in at eget. Egestas lacinia at id sagittis convallis dui
        lorem eget id. Cursus pulvinar tempor, netus dis. Curabitur potenti
        vitae, malesuada dui laoreet tincidunt tristique pellentesque tellus.
        Molestie arcu sit quam sit. Purus in sapien ultrices sit morbi neque,
        ipsum, ac. Integer at nulla libero, volutpat molestie amet enim at.
        Cras a tincidunt condimentum sit nec amet, congue sed tincidunt. Id
        vel vestibulum at consectetur justo aliquet a.
      </p>
      <a href="#" title="Download Aplikasi Di PlayStore">
        <img src="home/assets//img/google-play-store.png" alt="playstore" class="android" />
      </a>
      <a href="#" title="Download Aplikasi Di App Store">
        <img src="home/assets//img/app-store.png" alt="app-store" class="iphone" />
      </a>
    </div>
  </div>
  <!-- Akhir mobile app -->

  <!-- Awal footer -->
  <footer class="footer" id="footer">
    <div class="terakhir">
      <img src="home/assets//img/icon-tab.jpg" alt="logo" />
      <div class="social-media">
        <h5>Sosial Media</h5>
        <a href="https://wa.me/message/TJHCXV2IHL45I1" target="_blank">WhatsApp</a>
        <a href="https://www.instagram.com/tosepatu.kc" target="_blank">Instagram</a>
      </div>
      <div class="location">
        <h5>location</h5>
        <a href="#Location">Jl. Tawang Mangu Gg 3 No 20 (Gang Buntu Kontrakan Pak Ribut)</a>
      </div>
      <div class="new">
        <h5>New</h5>
        <p>Ingin Update Diskon, Promo Silahkan Klik Dibawah Ini</p>
        <a href="https://www.instagram.com/tosepatu.kc" target="_blank" class="btn">Follow It</a>
      </div>
    </div>
    <div class="copyright">
      <p>@copyright 2022 tosepatu.com</p>
    </div>
  </footer>
  <!-- Akhir footer -->

  <!-- Link eksternal file JS -->
  <script src="home/assets/js/script.js"></script>
</body>

</html>