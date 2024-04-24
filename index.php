<?php
require_once __DIR__."/inc.app/auth-with-form.php";

?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title><?php echo $app->get_app_name();?></title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="favicon.png" rel="icon">
  <link href="apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="assets/css/font.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Appland - v2.2.0
  * Template URL: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style type="text/css">
	#header .logo h1{
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		max-width: calc(100vw - 85px);
		display: block;
	}
	#footer .copyright, #footer .credits {
		padding: 5px 0;
		float:none;
	}
	#header {
		padding: 15px 0 0 0;
	}
	#footer {
		padding: 0 0 0 0;
	}
	.credits{
		display:none;
	}
	#activation .download-btn {
		font-family: "Raleway", sans-serif;
		font-weight: 500;
		font-size: 15px;
		display: inline-block;
		padding: 8px 24px 10px 18px;
		border-radius: 3px;
		transition: 0.5s;
		color: #fff;
		background: #47536e;
		position: relative;
	}
	.activation-btn-area{
		padding:20px 0;
	}
	.progress-bar-loading{
		height:4px;
		width:100%;
		top:0;	
		overflow:hidden;
		display:none;
	}
	.progress-bar-loading-inner{
		position:absolute;
		z-index:2000;
		height:4px;
		width:100%;
		overflow:hidden;
	}
	.progress-bar{
		position:absolute;
		width:55%;
		height:4px;
		background: rgb(255,255,255);
		background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(43,118,140,1) 40%, rgba(9,96,121,1) 50%, rgba(39,115,137,1) 60%, rgba(255,255,255,0) 100%);
		animation-name: progress;
		animation-duration: 2s;
		animation-iteration-count: infinite;
	}
	@keyframes progress {
	  from {left: -70vw;}
	  to {left:170vw;}
	}
  </style>
  <script type="text/javascript">
	function showLoading()
	{
		$('.progress-bar-loading').css({'display':'block'});
	}
  </script>
</head>

<body>
<div class="fixed-top progress-bar-loading"><div class="progress-bar-loading-inner"><div class="progress-bar"></div></div></div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top  header-transparent ">
    <div class="container d-flex align-items-center">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="./"><?php echo $app->get_app_name();?></a></h1>
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="./">Awal</a></li>
          <li><a href="#features">Fitur</a></li>
          <li><a href="#gallery">Galeri</a></li>
          <li><a href="#faq">FAQ</a></li>
          <li><a href="#contact">Kontak</a></li>
          <li><a href="tabungan.php">Tabungan</a></li>
		  <li><a href="transfer-dana.php">Transfer</a></li>
          <li><a href="pembiayaan.php">Pembiayaan</a></li>
		  <li><a href="pengingat.php">Pengingat</a></li>
          <li><a href="nasabah.php">Nasabah</a></li>
          <li><a href="logout.php">Keluar</a></li>
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
          <div>
            <h1><?php echo $app->get_app_full_name();?></h1>
            <h2>Aplikasi <?php echo $app->get_app_full_name();?> bisa Anda dapatkan di Google Play dan App Store.</h2>
            <a href="#" class="download-btn"><i class="bx bxl-play-store"></i> Google Play</a>
          </div>
        </div>
        <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
          <img src="assets/img/hero-img.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= App Features Section ======= -->
    <section id="features" class="features">
      <div class="container">

        <div class="section-title">
          <h2>Fitur Aplikasi</h2>
          <p>Aplikasi <?php echo $app->get_app_full_name();?> menyediakan fitur sebagai berikut</p>
        </div>

        <div class="row no-gutters">
          <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
            <div class="content d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="bx bx-receipt"></i>
                  <h4>Informasi Tabungan</h4>
                  <p>Informasi tabungan berupa mutasi dan saldo rekening yang dapat dipilih berdasarkan tanggal.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-receipt"></i>
                  <h4>Informasi Pembiayaan</h4>
                  <p>Informasi pembiayaan meliputi daftar tagihan, informasi pembayaran, informasi denda, dan informasi agunan.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-transfer"></i>
                  <h4>Transfer Dana</h4>
                  <p>Transfer dana atau pemindahbukuan dari satu rekening ke rekening lain dapat dilakukan melalui aplikasi..</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-info-circle"></i>
                  <h4>Petunjuk Penggunaan</h4>
                  <p>Aplikasi <?php echo $app->get_app_full_name();?> dilengkapi dengan petunjuk penggunaan aplikasi.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                  <i class="bx bx-chat"></i>
                  <h4>Tanya Jawab</h4>
                  <p>Tanya jawab adalah daftar pertanyaan yang sering ditanyakan beserta dengan jawaban secara umum. Pertanyaan khusus dapat diajukan ke customer care atau datang langsung ke cabang koperasi.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                  <i class="bx bx-id-card"></i>
                  <h4>Informasi Kontak</h4>
                  <p>Aplikasi <?php echo $app->get_app_full_name();?> menampilkan informasi kontak yang dapat dihubungi oleh nasabah.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            <img src="assets/img/features.svg" class="img-fluid" alt="">
          </div>
        </div>

      </div>
    </section><!-- End App Features Section -->

    <!-- ======= Details Section ======= -->
    <section id="details" class="details">
      <div class="container">

        <div class="row content">
          <div class="col-md-4" data-aos="fade-right">
            <img src="assets/img/details-1.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-4" data-aos="fade-up">
            <h3>Monitoring Tabungan</h3>
            <p>
              Aplikasi <?php echo $app->get_app_full_name();?> memudahkan Anda untuk memonitor transaksi saldo tabungan dengan cepat dan mudah.
            </p>
            <ul>
              <li><i class="icofont-check"></i> Informasi bisa didapatkan dengan cepat</li>
              <li><i class="icofont-check"></i> Tidak perlu datang ke kantor cabang</li>
              <li><i class="icofont-check"></i> Tidak perlu bertanya kepada petugas</li>
            </ul>
            <p>
              Informasi transaksi saldo tabungan tersimpan secara aman karena aplikasi dilengkapi dengan username dan password. Aktivasi juga hanya dilakukan di kantor cabang.
            </p>
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
            <img src="assets/img/details-2.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
            <h3>Monitoring Pembiayaan</h3>
            <p>
              Aplikasi <?php echo $app->get_app_full_name();?> memudahkan Anda untuk memonitor pembiayaan. Informasi pembiayaan antara lain adalah sebagai berikut:
            </p>
            <ul>
              <li><i class="icofont-check"></i> Informasi agihan yang belum dibayar beserta jatuh tempo</li>
              <li><i class="icofont-check"></i> Informasi tagihan yang sudah dibayar</li>
              <li><i class="icofont-check"></i> Informasi keterlambatan (jika ada)</li>
              <li><i class="icofont-check"></i> Informasi denda (jika ada)</li>
            </ul>
            <p>
              Fitur pengingat pembayaran cicilan dapat diaktifkan dengan mengunduh kalender pembayaran tagihan.
            </p>
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4" data-aos="fade-right">
            <img src="assets/img/details-3.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-5" data-aos="fade-up">
            <h3>Penyajian Informasi Secara Cepat dan Akurat</h3>
            <p>Seluruh informasi pada Aplikasi <?php echo $app->get_app_full_name();?> selalu dimutakhirkan setiap saat. Informasi yang tersedia di aplikasi merupakan aplikasi terbaru.</p>
            <ul>
              <li><i class="icofont-check"></i> Nasabah dapat memilih sendiri informasi yang akan ditampilkan</li>
              <li><i class="icofont-check"></i> Nasabah dapat melihat ulang informasi kapan saja bila dikehendaki</li>
            </ul>
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
            <img src="assets/img/details-4.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
            <h3>Perubahan Sandi Secara Mandiri</h3>
            <p>Perubahan kata sandi dapat dilakukan secara mandiri oleh nasabah melalui aplikasi. Apabila nasabah lupa kata sandi, nasabah dapat mengajukan pengaturan ulang kata sandi di kantor cabang koperasi terdekat.</p>
            <ul>
              <li><i class="icofont-check"></i> Perubahan kata sandi memerlukan kata sandi lama</li>
              <li><i class="icofont-check"></i> Perubahan kata sandi memerlukan NIK (Nomor Induk Kependudukan) untuk verifikasi data</li>
              <li><i class="icofont-check"></i> Perubahan kata sandi dapat dilakukan kapan saja tanpa ada batasan</li>
            </ul>
            <p>
              Semakin sering mengubah kata sandi akan meningkatkan keamanan akun Anda.
            </p>
          </div>
        </div>

      </div>
    </section><!-- End Details Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
      <div class="container">

        <div class="section-title">
          <h2>Galeri</h2>
          <p>Gambar di bawah ini menampilkan layar aplikasi pada saat digunakan</p>
        </div>

        <div class="owl-carousel gallery-carousel" data-aos="fade-up">
          <a href="assets/img/gallery/gallery-1.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-1.png" alt=""></a>
          <a href="assets/img/gallery/gallery-2.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-2.png" alt=""></a>
          <a href="assets/img/gallery/gallery-3.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-3.png" alt=""></a>
          <a href="assets/img/gallery/gallery-4.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-4.png" alt=""></a>
          <a href="assets/img/gallery/gallery-5.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-5.png" alt=""></a>
          <a href="assets/img/gallery/gallery-6.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-6.png" alt=""></a>
          <a href="assets/img/gallery/gallery-7.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-7.png" alt=""></a>
          <a href="assets/img/gallery/gallery-8.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-8.png" alt=""></a>
          <a href="assets/img/gallery/gallery-9.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-9.png" alt=""></a>
          <a href="assets/img/gallery/gallery-10.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-10.png" alt=""></a>
          <a href="assets/img/gallery/gallery-11.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-11.png" alt=""></a>
          <a href="assets/img/gallery/gallery-12.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-12.png" alt=""></a>
          <a href="assets/img/gallery/gallery-13.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-13.png" alt=""></a>
          <a href="assets/img/gallery/gallery-14.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-14.png" alt=""></a>
          <a href="assets/img/gallery/gallery-15.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-15.png" alt=""></a>
          <a href="assets/img/gallery/gallery-16.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-16.png" alt=""></a>
          <a href="assets/img/gallery/gallery-17.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-17.png" alt=""></a>
          <a href="assets/img/gallery/gallery-18.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-18.png" alt=""></a>
          <a href="assets/img/gallery/gallery-19.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-19.png" alt=""></a>
          <a href="assets/img/gallery/gallery-20.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-20.png" alt=""></a>
          <a href="assets/img/gallery/gallery-21.png" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-21.png" alt=""></a>
        </div>

      </div>
    </section><!-- End Gallery Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Pernyataan Nasabah</h2>
          <p>Berikut adalah pernyataan nasabah yang telah menggunakan aplikasi ini</p>
        </div>

        <div class="owl-carousel testimonials-carousel" data-aos="fade-up">

          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
              <h3>Budi Satria</h3>
              <h4>Pengusaha</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Aplikasi ini sangat membantu nasabah dalam mendapatkan informasi terbaru. Nasabah tidak perlu datang ke kantor cabang jika ingin melihat status pembiayaan atau saldo rekening tabungannya.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
              <h3>Joko Susilo</h3>
              <h4>Pengusaha</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Mantap banget deh pokoknya. Maju terus <?php echo $app->get_app_name();?>.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
              <h3>Handoyo</h3>
              <h4>Pengusaha</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Dulu saya harus datang hujan-hujanan ke kantor cabang hanya untuk mengetahui jumlah saldo dan cicilan yang belum dibayar. Semenjak ada aplikasi ini, saya bisa menghemat waktu, tenaga dan biaya. .
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          

        </div>

      </div>
    </section><!-- End Testimonials Section -->

    

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container">

        <div class="section-title">

          <h2>Pertanyaan yang Sering Ditanyakan</h2>
          <p>Berikut ini merupakan daftar pertanyaan yang sering ditanyakan dengan jawaban pasti</p>
        </div>

        <div class="accordion-list">
          <ul>
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse" href="#accordion-list-1">Apakah saldo tabungan di aplikasi akan langsung berubah jika ada transaksi baru? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-1" class="collapse show" data-parent=".accordion-list">
                <p>
                  Ya. Informasi saldo pada apliksi akan langsung berubah apabila ada transaksi baru baik debit maupun kredit.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-2" class="collapsed">Bagaimana apabila ada kesalahan input data yang dilakukan oleh petugas/teller? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-2" class="collapse" data-parent=".accordion-list">
                <p>
                  Apabila terjadi kesalahan pada input data yang dilakukan oleh petugas/teller, nasabah dapat datang ke kantor cabang koperasi terdekat dengan membawa semua bukti transaksi seperti buku tabungan maupun slip setoran.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-3" class="collapsed">Apakah saya bisa mendapatkan pengingat tanggal pembayaran cicilan? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-3" class="collapse" data-parent=".accordion-list">
                <p>
                  Bisa. Caranya dengan mengunduh kalender pembayaran cicilan dengan menggunakan smartphone Android. Kalender tersebut akan menjadi pengingat tanggal pembayaran cicilan.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-4" class="collapsed">Apakah saya bisa membayar cicilan tanpa membayar denda? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-4" class="collapse" data-parent=".accordion-list">
                <p>
                  Bisa. Denda yang belum dibayar dapat dilunasi pada saat pengambilan agunan.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-5" class="collapsed">Apakah denda yang belum dibayar namun cicilannya sudah dibayar akan terus bertambah hingga dilunasi? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-5" class="collapse" data-parent=".accordion-list">
                <p>
                  Tidak. Ketika cicilan sudah dilunasi, maka jumlah denda tidak akan bertambah.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#accordion-list-5" class="collapsed">Bagaimana perhitungan bagi hasil? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-5" class="collapse" data-parent=".accordion-list">
                <p>
                  Bagi hasil dihitung berdasarkan saldo rata-rata harian nasabah dibagi dengan jumlah saldo rata-rata harian seluruh nasabah kemudian dikali dengan jumlah bagi hasil yang ditetapkan oleh koperasi.
				  Saldo yang besar belum tentu akan mendapatkan bagi hasil yang besar tergantung kepada berapa lama saldo pada periode tersebut.
				  Sebagai contoh: seorang nasabah memiliki saldo sebesar Rp 10.000 selama 30 hari dan Rp 45.000.000 selama 1 hari. Maka saldo rata-data harian nasabah tersebut adalah: <br />
				  ((10.000 x 30) + (45.000.000 x 1)) / 31 atau sebesar Rp 1.461.290,323<br />
				  Jika saldo rata-rata harian seluruh nasabah adalah sebesar Rp 3.000.000.000 dan bagi hasil yang diberikan oleh koperasi sebesar Rp 50.000.000, maka bagi hasil yang didapatkan sebesar Rp 24.354,83871. Namun apabila saldo nasabah tersebut Rp 45.000.000 selama 31 hari, maka bagi hasil yang diperoleh adalah sebesar Rp 750.000.



                </p>
              </div>
            </li>

          </ul>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
	<?php
	
	$data_cabang_str = $app->get_profile('cabang');
	$data_hari_kerja_str = $app->get_profile('hari_kerja');
	if($data_cabang_str != null)
	{
		$data_cabang = json_decode($data_cabang_str, true);
	}
	else
	{
		$data_cabang = array();
	}
	if($data_hari_kerja_str != null)
	{
		$data_hari_kerja = json_decode($data_hari_kerja_str, true);
	}
	else
	{
		$data_hari_kerja = array();
	}
	
	?>
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Hubungi Kami</h2>
          <p>Untuk pertanyaan yang belum masuk ke daftar tanya jawab, silakan tanyakan kepada kami.</p>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="row">
              <div class="col-lg-6 info" data-aos="fade-up">
                <i class="bx bx-map"></i>
                <h4>Alamat Kantor</h4>
                
				<?php
					if($data_cabang != null && count($data_cabang) > 0)
					{
						foreach($data_cabang as $data)
						{
					?>
						<p><strong><?php echo $data['nama'];?></strong><br/>
						<?php echo $data['alamat'];?></p>
					<?php
						}
					}
					?>
				
              </div>
              <div class="col-lg-6 info" data-aos="fade-up" data-aos-delay="100">
                <i class="bx bx-phone"></i>
                <h4>Telepon Kantor</h4>
                <?php
					if($data_cabang != null && count($data_cabang) > 0)
					{
						foreach($data_cabang as $data)
						{
							if($data['telepon_pejabat'] != '')
							{
					?>
						<p><?php echo $data['telepon_pejabat'];?></p>
					<?php
							}
						}
					}
					?>
              </div>
              <div class="col-lg-6 info" data-aos="fade-up" data-aos-delay="200">
                <i class="bx bx-envelope"></i>
                <h4>Email Kantor</h4>
                <?php
					if($data_cabang != null && count($data_cabang) > 0)
					{
						foreach($data_cabang as $data)
						{
							if($data['email_pejabat'] != '')
							{
					?>
						<p><?php echo $data['email_pejabat'];?></p>
					<?php
							}
						}
					}
					?>
              </div>
			  
              <div class="col-lg-6 info" data-aos="fade-up" data-aos-delay="300">
                <i class="bx bx-time-five"></i>
                <h4>Jam Buka Kantor</h4>
                
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
					<?php
					if($data_hari_kerja != null && count($data_hari_kerja) > 0)
					{
						foreach($data_hari_kerja as $data)
						{
							if($data['kantor_buka'] == 1)
							{
					?>
						<tr>
							<td><?php echo $data['nama'];?></td>
							<td><?php echo substr($data['jam_buka_kantor'], 0, 5);?> - <?php echo substr($data['jam_tutup_kantor'], 0, 5);?></td>
						</tr>
						
					<?php
							}
						}
					}
					?>
						
						
					</tbody>
				</table>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form" data-aos="fade-up">
              <div class="form-group">
                <input placeholder="Subjek" type="text" class="form-control" name="subject" id="subject" data-rule="minlen:4" data-msg="Mohon isi subjek pesan" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea placeholder="Pesan" class="form-control" name="message" rows="5" data-rule="required" data-msg="Mohon isi pesan"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Sedang Memuat</div>
                <div class="error-message"></div>
                <div class="sent-message">Pesan telah dikirim. Terima kasih.</div>
              </div>
              <div class="text-center"><button type="submit">Kirim Pesan</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
	<!--
    <div class="footer-newsletter" data-aos="fade-up">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <h4>Berlangganan Informasi</h4>
            <p>Untuk berlangganan informasi, silakan masukkan alamat email Anda. Kami akan menngirimkan email setiap kali ada informasi terbaru,</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Berlangganan">
            </form>
          </div>
        </div>
      </div>
    </div>
	-->
	<?php
	if(isset($_SERVER['HTTP_X_APPLICATION_VERSION']))
	{
	?>
	<div class="footer-newsletter">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 footer-links" data-aos="fade-up" data-aos-delay="300">
            <h4>Update</h4>
			<?php			
			if($app->is_up_to_date($_SERVER))
			{
				?>
				<p>Anda menggunakan versi terbaru</p>
				<?php
			}
			else
			{
				?>
				<p>Perbarui versi aplikasi Anda</p>
				<p><a class="btn btn-primary" href="https://dev.albasiko-2.com/app-debug.apk">Unduh</a></p>
				<?php
			}
			?>
          </div>

        </div>
      </div>
    </div>
	
	<?php
	}
	?>
	
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 footer-links" data-aos="fade-up" data-aos-delay="300">
            <h4>Media Sosial Kami</h4>
            <p>Aktif di media sosial? Berikut adalah link media sosial kami.</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    

    <div class="container py-4">
      <div class="copyright">
        &copy; <strong><span>Planetbiru Studio</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/ -->
        Designed by <a href="https://www.planetbiru.net/">Planetbiru Studio</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>